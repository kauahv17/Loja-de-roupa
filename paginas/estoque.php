<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/headerStyle.css">
    <link rel="stylesheet" href="../assets/css/estoqueStyle.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="settings-icon left">
        <a href="home.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
    </div>
    <div class="settings-icon right">
        <a href="/Loja-de-roupa/index.php"><img src="/Loja-de-roupa/assets/img/gear.svg" alt="Configurações"></a>
    </div>
    <div class="estoque-container">
        <div class="estoque-header">
            <div class="estoque-title">Estoque</div>
        </div>
        <form class="estoque-search">
            <input type="text" placeholder="pesquisa" name="pesquisa">
            <button type="submit" class="estoque-search-btn"><img src="../assets/img/lupa.svg" alt="Buscar"></button>
        </form>
        <div class="estoque-lista">
            <?php
            include_once '../db/conexao.php';
            $where = '';
            if (isset($_GET['pesquisa']) && $_GET['pesquisa'] != '') {
                $pesquisa = mysqli_real_escape_string($conn, $_GET['pesquisa']);
                $where = "WHERE produto.nome LIKE '%$pesquisa%' OR tipo_produto.tipo LIKE '%$pesquisa%' OR fornecedor.nome LIKE '%$pesquisa%'";
            }
            $sql = "SELECT produto.nome AS nome_p,
                            tipo_produto.tipo,
                            produto.preco_uni,
                            fornecedor.nome AS nome_f,
                            fornecedor.cnpj
                            FROM produto
                            JOIN tipo_produto ON produto.idtipo_produto = tipo_produto.idtipo_produto
                            JOIN produtos_fornecidos pf ON produto.idproduto = pf.idproduto
                            JOIN fornecedor ON pf.idfornecedor = fornecedor.idfornecedor $where";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="estoque-card">
                <div class="estoque-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto">
                </div>
                <div class="estoque-card-info">
                    <div class="estoque-card-title"><?php echo $row['nome_p'] . ' (' . $row['tipo'] . ')'; ?></div>
                    <div class="estoque-card-preco">uni: R$ <?php echo number_format($row['preco_uni'], 2, ',', '.'); ?></div>
                </div>
                <div class="estoque-card-fornecedor">
                    <?php echo $row['nome_f']; ?><br>
                    <span class="estoque-card-cnpj">cnpj: <?php echo $row['cnpj']; ?></span>
                </div>
                <div class="estoque-card-actions">
                    <img src="../assets/img/drop.svg" alt="Mais opções" class="dropdown">
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
