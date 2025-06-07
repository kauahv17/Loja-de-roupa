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
                        <div class='dropdown'>
                            <?php
                                $temTamanho = false;
                                $tamanhoSelect = '';
                                if($row['tipo'] != 'óculos'){
                                    $temTamanho = true;
                                    $tamanhoSelect = "<select name='tamanho' required><option value=''></option>";
                                    if($row['tipo'] == 'camiseta'){
                                        $tamanhos = ['PP', 'P','M', 'G', 'GG'];
                                        foreach($tamanhos as $tamanho){ 
                                            $tamanhoSelect .= "<option value='{$tamanho}'>{$tamanho}</option>";
                                        }
                                    }else{
                                        for($i=34; $i <= 45; $i++){
                                            $tamanhoSelect .= "<option value='{$i}'>{$i}</option>";
                                        }
                                    }
                                    $tamanhoSelect .= "</select>";
                                    echo $tamanhoSelect;
                                }
                            ?>
                        </div>
                        <form method="POST" action="../db/adiciona_carrinho.php" style="display:inline;">
                            <input type="hidden" name="nome" value="<?php echo htmlspecialchars($row['nome']); ?>">
                            <input type="hidden" name="preco" value="<?php echo $row['preco_uni']; ?>">
                            <input type="hidden" name="cor" value="<?php echo htmlspecialchars($row['cor']); ?>">
                            <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($row['tipo']); ?>">
                            <?php if($temTamanho){ ?>
                                <input type="hidden" name="tamanho" value="">
                            <?php } ?>
                            <button type="submit" class="icon-btn">
                                <img src="../assets/img/comprar.svg" alt="Carrinho" class="cart">
                            </button>
                        </form>
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