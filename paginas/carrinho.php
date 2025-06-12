<?php
    session_start();
    include_once("../db/conexao.php");

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
        header('Location: carrinho.php');
        exit;
    }

    // Processar remoção de item
    if (isset($_POST['remover_item'])) {
        $produto_id = $_POST['idproduto'];
        $tamanho = $_POST['tamanho'] ?? null;

        foreach ($_SESSION['carrinho'] as $key => $item) {
            if (isset($item['produto_id'], $item['tamanho']) && $item['produto_id'] == $produto_id && $item['tamanho'] == $tamanho) {
                unset($_SESSION['carrinho'][$key]);
                $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
                break;
            }
        }
        header('Location: carrinho.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="icon" type="image/png" href="../assets/img/logo_ME.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/carrinhoStyle.css">
    <link rel="stylesheet" href="../assets/css/sidebarStyle.css">

</head>
<body>
    <div class="settings-icon left">
            <a href="vendas.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
        </div>
        <div class="settings-icon right">
            <div class="settings-icone" onclick="toggleSidebar()">
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
        <div class="carrinho-container">
            <div class="carrinho-header">
                <div class="h1-right">Carrinho</div>
            </div>
            <div class="carrinho-lista">
                <?php
                $total = 0;
                if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
                    foreach ($_SESSION['carrinho'] as $item) {
                        // Só processa se o item for válido
                        if (!isset($item['produto_id']) || empty($item['produto_id'])) {
                            continue;
                        }
                        $produto_id = $item['produto_id'];
                        $quantidade = $item['quantidade'];
                        $tamanho = isset($item['tamanho']) ? $item['tamanho'] : '';

                        // Buscar informações do produto
                        $sql = "SELECT p.*, tp.tipo 
                               FROM produto p 
                               JOIN tipo_produto tp ON p.idtipo_produto = tp.idtipo_produto 
                               WHERE p.idproduto = $produto_id";
                        $result = mysqli_query($conn, $sql);
                        $produto = mysqli_fetch_assoc($result);

                        if ($produto) {
                            $subtotal = $produto['preco_uni'] * $quantidade;
                            $total += $subtotal;
                ?>
                <div class="carrinho-card">
                    <div class="carrinho-card-img">
                        <img src="../assets/img/prod_img.svg" alt="Produto">
                    </div>
                    <div class="carrinho-card-group">
                        <div class="carrinho-card-info">
                                <span class="carrinho-card-title"><?php echo $produto['nome'] . ' ' . $produto['cor']; ?></span>
                                <span class="carrinho-card-price">R$ <?php echo number_format($produto['preco_uni'], 2, ',', '.'); ?></span>
                        </div>
                        <div class="carrinho-card-var">
                                <span class="carrinho-card-sum">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span>
                                <?php if($produto['tipo'] != 'óculos'): ?>
                                    <span class="tamanho">Tamanho: <?php echo $tamanho !== '' ? $tamanho : 'Não informado'; ?></span>
                                <?php endif; ?>
                        </div>
                    </div>
                    <div class="carrinho-card-img-trash">
                            <form method="POST" style="margin: 0;">
                                <input type="hidden" name="idproduto" value="<?php echo $produto_id; ?>">
                                <input type="hidden" name="tamanho" value="<?php echo $tamanho; ?>">
                                <button type="submit" name="remover_item" style="background: none; border: none; cursor: pointer;">
                                    <img src="../assets/img/lixeira.svg" alt="Remover">
                                </button>
                            </form>
                    </div>
                    <div class="carrinho-card-qntd-group">
                        <form method="POST">
                                <input type="hidden" name="idproduto" value="<?php echo $produto_id; ?>">
                            <input type="hidden" name="tamanho" value="<?php echo $tamanho; ?>">
                                <input type="hidden" name="quantidade" value="<?php echo $quantidade - 1; ?>">
                            <button type="submit" name="alterar_quantidade">-</button>
                        </form>
                            <span class="quantidade"><?php echo $quantidade; ?></span>
                        <form method="POST">
                                <input type="hidden" name="idproduto" value="<?php echo $produto_id; ?>">
                            <input type="hidden" name="tamanho" value="<?php echo $tamanho; ?>">
                                <input type="hidden" name="quantidade" value="<?php echo $quantidade + 1; ?>">
                            <button type="submit" name="alterar_quantidade">+</button>
                        </form>
                    </div>
                </div>
                <?php
                        }
                    }
                } else {
                    echo "<p style='text-align: center;'>Nenhum produto selecionado.</p>";
                }
                ?>



            <div class="carrinho-header">
                <div class="h1-right">Cliente</div>
            </div>
            <div class="carrinho-busca-group">
                <form class="carrinho-search">
                    <select class="carrinho-select" name="idcliente" required>
                        <option value="">Selecione o cliente</option>
                        <?php
                            $sql = "SELECT idcliente, cpf FROM cliente ORDER BY cpf ASC";
                            $result = mysqli_query($conn, $sql);
                            if($result){
                                while($row = mysqli_fetch_assoc($result)){
                                echo "<option value='{$row['idcliente']}'>{$row['cpf']}</option>";
                                }
                            } else {
                                echo "<option value=''>Erro ao carregar clientes</option>";
                            }
                        ?>
                    </select>
                    <button type="submit" class="carrinho-search-btn"><img src="../assets/img/lupa.svg" alt="Buscar"></button>
                </form>
                <a href="cadastro_cliente.php"><button class="carrinho-button">Cadastrar Cliente</button></a>
            </div>
            <div class="carrinho-valor-total">
                <span class="total">Valor total ----------------------------------------------------------------------------------------------- R$ <?php echo number_format($total, 2, ',', '.'); ?></span>
            </div>


            <a href="cadastro_cliente.php"><button class="carrinho-button">Finalizar compra</button></a>

        </div>
    </div>
    <script src="../js/configuracoes.js"></script>
</body>
</html>