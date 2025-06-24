<?php
session_start();
include 'header.php';

// Inicializa o carrinho na sessão se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

// Recebe o valor da pesquisa e da categoria
$pesquisa = $_GET['pesquisa'] ?? '';
$categoria = $_GET['categoria'] ?? '';

include_once '../db/conexao.php';
$where = '';
if ($pesquisa != '') {
    $pesquisa = mysqli_real_escape_string($conn, $pesquisa);
    $where = "WHERE LOWER(produto.nome) LIKE LOWER('%$pesquisa%') OR LOWER(tipo_produto.tipo) LIKE LOWER('%$pesquisa%')";
}
if ($categoria != '') {
    $categoria = mysqli_real_escape_string($conn, $categoria);
    $where .= $where == '' ? "WHERE LOWER(tipo_produto.tipo) = LOWER('$categoria')" : " AND LOWER(tipo_produto.tipo) = LOWER('$categoria')";
}

// Processar adição ao carrinho
if (isset($_POST['carrinho'])) {
    $produto_id = $_POST['idproduto'];
    $quantidade = $_POST['quantidade'];

    // Obter quantidade_estoque do produto
    $sql_estoque = "SELECT quantidade_estoque, nome FROM produto WHERE idproduto = ?";
    $stmt_estoque = mysqli_prepare($conn, $sql_estoque);
    mysqli_stmt_bind_param($stmt_estoque, "i", $produto_id);
    mysqli_stmt_execute($stmt_estoque);
    $result_estoque = mysqli_stmt_get_result($stmt_estoque);
    $produto_info_estoque = mysqli_fetch_assoc($result_estoque);
    mysqli_stmt_close($stmt_estoque);

    if (!$produto_info_estoque) {
        echo "<script>alert('Produto não encontrado.'); window.location.href='vendas.php';</script>";
        exit;
    }

    $quantidade_disponivel = $produto_info_estoque['quantidade_estoque'];
    $nome_produto = $produto_info_estoque['nome'];

    // Verificar se há estoque suficiente para a quantidade que está sendo adicionada (incluindo o que já está no carrinho)
    $quantidade_ja_no_carrinho = 0;
    foreach ($_SESSION['carrinho'] as $item) {
        if (isset($item['produto_id']) && $item['produto_id'] == $produto_id) {
            $quantidade_ja_no_carrinho += $item['quantidade'];
        }
    }

    if (($quantidade_ja_no_carrinho + $quantidade) > $quantidade_disponivel) {
        echo "<script>alert('Estoque insuficiente para \'" . $nome_produto . "\'. Disponível: " . $quantidade_disponivel . ".'); window.location.href='vendas.php';</script>";
        exit;
    }

    $tamanhos_selecionados = $_POST['tamanhos'] ?? [];
    // Se nenhum tamanho for selecionado (ex: para óculos), adiciona um valor vazio para o tamanho
    if (!is_array($tamanhos_selecionados) || empty($tamanhos_selecionados)) {
        $tamanhos_selecionados = ['']; 
    }

    foreach ($tamanhos_selecionados as $tamanho_selecionado) {
        // Verifica se o produto já está no carrinho com o mesmo tamanho
        $produto_existe = false;
        foreach ($_SESSION['carrinho'] as $key => $item) {
            // Garante que a chave 'tamanho' existe para comparação
            $item_tamanho = $item['tamanho'] ?? ''; 
            if (isset($item['produto_id']) && $item['produto_id'] == $produto_id && $item_tamanho == $tamanho_selecionado) {
                $_SESSION['carrinho'][$key]['quantidade'] += $quantidade;
                $produto_existe = true;
                break;
            }
        }

        // Se o produto não existe no carrinho, adiciona como novo item
        if (!$produto_existe) {
            $item = array(
                'produto_id' => $produto_id,
                'quantidade' => $quantidade,
                'tamanho' => $tamanho_selecionado
            );
            $_SESSION['carrinho'][] = $item;
        }
    }
    header('Location: vendas.php'); // Redireciona para evitar reenvio de formulário
    exit;
}

// Processar alteração de quantidade
if (isset($_POST['alterar_quantidade'])) {
    $produto_id = $_POST['idproduto'];
    $nova_quantidade = $_POST['quantidade'];
    $tamanho = $_POST['tamanho'] ?? null;

    foreach ($_SESSION['carrinho'] as $key => $item) {
        if (isset($item['produto_id'], $item['tamanho']) && $item['produto_id'] == $produto_id && $item['tamanho'] == $tamanho) {
            if ($nova_quantidade <= 0) {
                unset($_SESSION['carrinho'][$key]);
                $_SESSION['carrinho'] = array_values($_SESSION['carrinho']); // Reindexa o array
            } else {
                $_SESSION['carrinho'][$key]['quantidade'] = $nova_quantidade;
            }
            break;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Vendas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/vendasStyle.css">
    <link rel="stylesheet" href="../assets/css/headerStyle.css">
    <link rel="stylesheet" href="../assets/css/sidebarStyle.css">
    <style>
        .vendas-card {
            min-height: 250px; /* Ajuste a altura mínima do card */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .vendas-card-info {
            flex-grow: 1; /* Permite que o info ocupe o espaço disponível */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        select[multiple] {
            overflow-y: auto;
            max-height: 100px;
            pointer-events: auto;
            flex-shrink: 0; /* Impede que o select encolha */
        }
        
        .vendas-card-icons {
            display: flex;
            flex-direction: column; /* Empilha os elementos verticalmente */
            gap: 10px; /* Espaço entre os elementos */
            align-items: flex-start; /* Alinha os itens à esquerda */
            margin-top: 10px; /* Adiciona um espaço acima da seção de ícones */
        }
        
        .vendas-card-carrinho-group {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 5px; /* Espaçamento entre os grupos de quantidade */
        }
        
        .btn-diminuir, .btn-aumentar {
            padding: 5px 10px;
            border: none;
            background-color: #f0f0f0;
            cursor: pointer;
            border-radius: 4px;
        }
        
        .btn-diminuir:hover, .btn-aumentar:hover {
            background-color: #e0e0e0;
        }
        
        .quantidade {
            padding: 0 10px;
            font-weight: bold;
        }

        .tamanho-exibido {
            font-size: 0.9em;
            color: #555;
            margin-left: 5px;
        }

        .btn-carrinho .cart {
            width: 30px; /* Aumenta a largura do ícone do carrinho */
            height: 30px; /* Aumenta a altura do ícone do carrinho */
        }
    </style>
</head>
<body>
    <div class="settings-icon left">
        <a href="home.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
    </div>
    <div class="settings-icon right">    
        <a href="pdfVendasPorDia.php"><img src="../assets/img/pdf.svg" alt="PDF Vendas Por Dia" style="width:60px;" /></a>
        <a href="carrinho.php"><img src="../assets/img/carrinho.svg" alt="carrinho"></a>
        <div class="settings-icone" id="config-icone" onclick="toggleSidebar()">           
            <img src="../assets/img/gear.svg" alt="Configurações" style="cursor: pointer;">                    
            <div class="sidebar" id="sidebar">
                <h2>Configurações</h2>
                <h4><strong>Nome:</strong> <?php echo $_SESSION['nome']; ?></h4>
                <h4><strong>ID:</strong> <?php echo $_SESSION['idfuncionario']; ?></h4><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <a href="../index.php">
                    <img src="../assets/img/sair.svg" alt="Sair"> 
                </a>
            </div>
        </div>
    </div>
    
    <div class="vendas-container">
        <div class="vendas-header">
            <div class="h1-right">Vendas</div>
        </div>
        <form class="vendas-search">
            <input type="text" placeholder="pesquisa" name="pesquisa">
            <button type="submit" class="vendas-search-btn"><img src="../assets/img/lupa.svg" alt="Buscar"></button>
        </form>
        <div class="vendas-lista">
            <?php 
            $sql = "SELECT 
                        produto.idproduto,
                        produto.nome,
                        produto.preco_uni,
                        produto.cor,
                        produto.quantidade_estoque,
                        tipo_produto.tipo AS tipo
                    FROM produto 
                    JOIN tipo_produto ON produto.idtipo_produto = tipo_produto.idtipo_produto $where";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="produto">
                </div>
                <div class="vendas-card-info">
                    <span class="vendas-card-title"><?php echo $row['nome'] . ' ' . $row['cor']; ?></span>
                    <div class="vendas-card-price-line">
                        <span class="vendas-card-price">R$ <?php echo number_format($row['preco_uni'], 2, ',', '.'); ?></span>
                        <span class="vendas-card-estoque">Estoque: <?php echo $row['quantidade_estoque']; ?></span>
                    </div>
                    <div class="vendas-card-icons">
                        <?php
                        $items_in_cart_for_this_product = [];
                        if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
                            foreach ($_SESSION['carrinho'] as $item) {
                                if (isset($item['produto_id']) && $item['produto_id'] == $row['idproduto']) {
                                    $items_in_cart_for_this_product[] = $item;
                                }
                            }
                        }

                        if ($row['tipo'] != 'óculos'): ?>
                            <div class='dropdown'>
                                <?php if(empty($items_in_cart_for_this_product)):?>
                                    <form method="POST">
                                        <div class="vendas-card-actions">
                                            <select name='tamanhos[]' required>
                                                <option value=""></option>
                                                <?php
                                                if ($row['tipo'] == 'camiseta') {
                                                    $tamanhos = ['PP', 'P', 'M', 'G', 'GG'];
                                                    foreach ($tamanhos as $t) {
                                                        echo "<option value='{$t}'>{$t}</option>";
                                                    }
                                                } else {
                                                    for ($i = 34; $i <= 45; $i++) {
                                                        echo "<option value='{$i}'>{$i}</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <button type="submit" name="carrinho" class="btn-carrinho">
                                                <img src="../assets/img/comprar.svg" alt="Carrinho" class="cart">
                                            </button>
                                        </div>
                                        <input type="hidden" name="idproduto" value="<?php echo $row['idproduto']; ?>">
                                        <input type="hidden" name="quantidade" value="1">
                                        <input type="hidden" name="cor" value="<?php echo $row['cor']; ?>">
                                    </form>
                                <?php else: ?>
                                    <?php foreach ($items_in_cart_for_this_product as $item_in_cart): ?>
                                        <div class="vendas-card-actions">
                                            <span class="size"><?php echo $item_in_cart['tamanho']; ?></span>
                                            <div class="vendas-card-botoes">
                                                <form method="POST">
                                                    <input type="hidden" name="idproduto" value="<?php echo $row['idproduto']; ?>">
                                                    <input type="hidden" name="tamanho" value="<?php echo $item_in_cart['tamanho'] ?? ''; ?>">
                                                    <input type="hidden" name="quantidade" value="<?php echo $item_in_cart['quantidade'] - 1; ?>">
                                                    <button type="submit" name="alterar_quantidade" class="btn-diminuir">-</button>
                                                </form>
                                                <span class="quantidade"><?php echo $item_in_cart['quantidade']; ?></span>
                                                <form method="POST">
                                                    <input type="hidden" name="idproduto" value="<?php echo $row['idproduto']; ?>">
                                                    <input type="hidden" name="tamanho" value="<?php echo $item_in_cart['tamanho'] ?? ''; ?>">
                                                    <input type="hidden" name="quantidade" value="<?php echo $item_in_cart['quantidade'] + 1; ?>">
                                                    <button type="submit" name="alterar_quantidade" class="btn-aumentar">+</button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


            <?php
                }

            } else {
                echo "<p style='text-align: center;'>Nenhum produto encontrado.</p>";
            }
            ?>
        </div>
    </div>

</body>
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
}

document.addEventListener('mousedown', function(event) {
    const sidebar = document.getElementById('sidebar');
    const configIcone = document.getElementById('config-icone');
    if (sidebar.classList.contains('active')) {
        if (!sidebar.contains(event.target) && !configIcone.contains(event.target)) {
            sidebar.classList.remove('active');
        }
    }
});
</script>
</html>
