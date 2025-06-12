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
    $where = "WHERE produto.nome LIKE '%$pesquisa%' OR tipo_produto.tipo LIKE '%$pesquisa%'";
}
if ($categoria != '') {
    $categoria = mysqli_real_escape_string($conn, $categoria);
    $where .= $where == '' ? "WHERE tipo_produto.tipo = '$categoria'" : " AND tipo_produto.tipo = '$categoria'";
}

// Processar adição ao carrinho
if (isset($_POST['carrinho'])) {
    $produto_id = $_POST['idproduto'];
    $quantidade = $_POST['quantidade'];
    $tamanho = $_POST['tamanhos'] ?? null;

    // Verifica se o produto já está no carrinho com o mesmo tamanho
    $produto_existe = false;
    foreach ($_SESSION['carrinho'] as $key => $item) {
        if ($item['produto_id'] == $produto_id && $item['tamanho'] == $tamanho) {
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
            'tamanho' => $tamanho
        );
        $_SESSION['carrinho'][] = $item;
    }
}

// Processar alteração de quantidade
if (isset($_POST['alterar_quantidade'])) {
    $produto_id = $_POST['idproduto'];
    $nova_quantidade = $_POST['quantidade'];
    $tamanho = $_POST['tamanho'] ?? null;

    foreach ($_SESSION['carrinho'] as $key => $item) {
        if ($item['produto_id'] == $produto_id && $item['tamanho'] == $tamanho) {
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
                        <?php if($row['tipo'] != 'óculos'): ?>
                            <div class='dropdown'>
                                <form method="POST">
                                    <select name='tamanhos' required>
                                        <option value=''></option>
                                        <?php
                                        if ($row['tipo'] == 'camiseta') {
                                            $tamanhos = ['PP', 'P', 'M', 'G', 'GG'];
                                            foreach ($tamanhos as $t) {
                                                $selected = '';
                                                // Verifica se este tamanho está no carrinho
                                                foreach ($_SESSION['carrinho'] as $item) {
                                                    if ($item['produto_id'] == $row['idproduto'] && $item['tamanho'] == $t) {
                                                        $selected = 'selected';
                                                        break;
                                                    }
                                                }
                                                echo "<option value='{$t}' {$selected}>{$t}</option>";
                                            }
                                        } else {
                                            for ($i = 34; $i <= 45; $i++) {
                                                $selected = '';
                                                // Verifica se este tamanho está no carrinho
                                                foreach ($_SESSION['carrinho'] as $item) {
                                                    if ($item['produto_id'] == $row['idproduto'] && $item['tamanho'] == $i) {
                                                        $selected = 'selected';
                                                        break;
                                                    }
                                                }
                                                echo "<option value='{$i}' {$selected}>{$i}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </form>
                            </div>
                        <?php endif; ?>
                        <div class="vendas-card-carrinho-group">
                            <?php 
                            $qntd = 0;
                            $tamanho = '';
                            // Verifica se o produto está no carrinho
                            foreach ($_SESSION['carrinho'] as $item) {
                                if ($item['produto_id'] == $row['idproduto']) {
                                    $qntd = $item['quantidade'];
                                    $tamanho = $item['tamanho'];
                                    break;
                                }
                            }
                            
                            if($qntd == 0): ?>
                                <form method="POST">
                                    <input type="hidden" name="idproduto" value="<?php echo $row['idproduto']; ?>">
                                    <input type="hidden" name="quantidade" value="1">
                                    <button type="submit" name="carrinho" class="btn-carrinho">
                                        <img src="../assets/img/comprar.svg" alt="Carrinho" class="cart">
                                    </button>
                                </form>
                            <?php else: ?>
                                <form method="POST">
                                    <input type="hidden" name="idproduto" value="<?php echo $row['idproduto']; ?>">
                                    <input type="hidden" name="tamanho" value="<?php echo $tamanho; ?>">
                                    <input type="hidden" name="quantidade" value="<?php echo $qntd - 1; ?>">
                                    <button type="submit" name="alterar_quantidade" class="btn-diminuir">-</button>
                                </form>
                                <span class="quantidade"><?php echo $qntd; ?></span>
                                <form method="POST">
                                    <input type="hidden" name="idproduto" value="<?php echo $row['idproduto']; ?>">
                                    <input type="hidden" name="tamanho" value="<?php echo $tamanho; ?>">
                                    <input type="hidden" name="quantidade" value="<?php echo $qntd + 1; ?>">
                                    <button type="submit" name="alterar_quantidade" class="btn-aumentar">+</button>
                                </form>
                            <?php endif; ?>
                        </div>
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
