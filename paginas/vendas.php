<?php
    session_start();
    include 'header.php';

    // Recebe o valor da pesquisa e da categoria
    $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
    $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

    include_once '../db/conexao.php';
    $where = '';
    if (isset($_GET['pesquisa']) && $_GET['pesquisa'] != '') {
        $pesquisa = mysqli_real_escape_string($conn, $_GET['pesquisa']);
        $where = "WHERE produto.nome LIKE '%$pesquisa%' OR tipo_produto.tipo LIKE '%$pesquisa%'";
    }
    if (isset($_GET['categoria']) && $_GET['categoria'] != '') {
        $categoria = mysqli_real_escape_string($conn, $_GET['categoria']);
        if ($where == '') {
            $where = "WHERE tipo_produto.tipo = '$categoria'";
        } else {
            $where = " AND tipo_produto.tipo = '$categoria'";
        }
    }

    // Processar adição ao carrinho
    if (isset($_POST['adicionar_carrinho'])) {
        $produto_id = $_POST['produto_id'];
        $quantidade = $_POST['quantidade'];
        $tamanho = isset($_POST['tamanho']) ? $_POST['tamanho'] : null;

        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = array();
        }

        $item = array(
            'produto_id' => $produto_id,
            'quantidade' => $quantidade,
            'tamanho' => $tamanho
        );

        $_SESSION['carrinho'][] = $item;
    }

    // Processar alteração de quantidade
    if (isset($_POST['alterar_quantidade'])) {
        $produto_id = $_POST['produto_id'];
        $nova_quantidade = $_POST['nova_quantidade'];
        $tamanho = isset($_POST['tamanho']) ? $_POST['tamanho'] : null;

        foreach ($_SESSION['carrinho'] as $key => $item) {
            if ($item['produto_id'] == $produto_id && $item['tamanho'] == $tamanho) {
                if ($nova_quantidade <= 0) {
                    // Remove o item do carrinho se a quantidade for 0 ou menor
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/vendasStyle.css">
    <link rel="stylesheet" href="../assets/css/headerStyle.css">
</head>
<body>
    <div class="settings-icon left">
        <a href="home.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
    </div>
    <div class="settings-icon right">
        <a href="carrinho.php"><img src="../assets/img/carrinho.svg" alt="carrinho"></a>
        <a href="../index.php"><img src="../assets/img/gear.svg" alt="Configurações"></a>
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
                    $produto_no_carrinho = false;
                    $quantidade_carrinho = 0;
                    $tamanho_carrinho = null;

                    if (isset($_SESSION['carrinho'])) {
                        foreach ($_SESSION['carrinho'] as $item) {
                            if ($item['produto_id'] == $row['idproduto']) {
                                $produto_no_carrinho = true;
                                $quantidade_carrinho = $item['quantidade'];
                                $tamanho_carrinho = $item['tamanho'];
                                break;
                            }
                        }
                    }
            ?>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title"><?php echo $row['nome'], " ", $row['cor']; ?></div>
                        <div class="vendas-card-price-container">
                            <span class="vendas-card-price">R$ <?php echo number_format($row['preco_uni'], 2, ',', '.'); ?></span>
                            <span class="vendas-card-estoque">Estoque: <?php echo $row['quantidade_estoque']; ?></span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <?php if($row['tipo'] != 'óculos'): ?>
                            <div class='dropdown'>
                                <select name='tamanho' required>
                                    <option value=''></option>
                                    <?php
                                    if($row['tipo'] == 'camiseta'){
                                        $tamanhos = ['PP', 'P','M', 'G', 'GG'];
                                        foreach($tamanhos as $tamanho){ 
                                            $selected = ($tamanho == $tamanho_carrinho) ? 'selected' : '';
                                            echo "<option value='{$tamanho}' {$selected}>{$tamanho}</option>";
                                        }
                                    }else{
                                        for($i=34; $i <= 45; $i++){
                                            $selected = ($i == $tamanho_carrinho) ? 'selected' : '';
                                            echo "<option value='{$i}' {$selected}>{$i}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <?php if(!$produto_no_carrinho): ?>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="produto_id" value="<?php echo $row['idproduto']; ?>">
                                <input type="hidden" name="quantidade" value="1">
                                <input type="hidden" name="tamanho" value="<?php echo $tamanho_carrinho; ?>">
                                <button type="submit" name="adicionar_carrinho" class="btn-carrinho">
                                    <img src="../assets/img/comprar.svg" alt="Carrinho" class="cart">
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="quantidade-container">
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="produto_id" value="<?php echo $row['idproduto']; ?>">
                                    <input type="hidden" name="tamanho" value="<?php echo $tamanho_carrinho; ?>">
                                    <input type="hidden" name="nova_quantidade" value="<?php echo $quantidade_carrinho - 1; ?>">
                                    <button type="submit" name="alterar_quantidade" class="btn-diminuir">-</button>
                                </form>
                                <span class="quantidade"><?php echo $quantidade_carrinho; ?></span>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="produto_id" value="<?php echo $row['idproduto']; ?>">
                                    <input type="hidden" name="tamanho" value="<?php echo $tamanho_carrinho; ?>">
                                    <input type="hidden" name="nova_quantidade" value="<?php echo $quantidade_carrinho + 1; ?>">
                                    <button type="submit" name="alterar_quantidade" class="btn-aumentar">+</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p style='margin: 20px;'>Nenhum produto encontrado.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>  