<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/headerStyle.css">
    <link rel="stylesheet" href="../assets/css/fornecedorStyle.css">
</head>
<body>
    <div class="settings-icon left">
        <a href="home.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
    </div>
    <div class="settings-icon right">
        <a href="/Loja-de-roupa/cadastro_fornecedor.php"><img src="/Loja-de-roupa/assets/img/add_forn.svg" alt="Adicionar"></a>
        <a href="/Loja-de-roupa/index.php"><img src="/Loja-de-roupa/assets/img/gear.svg" alt="Configurações"></a>
    </div>
    <div class="fornecedor-container">
        <div class="fornecedor-header">
            <div class="h1-right">Fornecedores</div>
        </div><br><br>
        <form class="fornecedor-search">
            <input type="text" placeholder="pesquisa" name="pesquisa">
            <button type="submit" class="fornecedor-search-btn"><img src="../assets/img/lupa.svg" alt="Buscar"></button>
        </form>
        <div class="fornecedor-lista">
            <?php
            include_once '../db/conexao.php';
            $where = '';
            if (isset($_GET['pesquisa']) && $_GET['pesquisa'] != '') {
                $pesquisa = mysqli_real_escape_string($conn, $_GET['pesquisa']);
                $where = "WHERE fornecedor.nome LIKE '%$pesquisa%' OR fornecedor.cnpj LIKE '%$pesquisa%'";
            }
            $sql = "SELECT fornecedor.nome AS nome_f,
                            fornecedor.cnpj 
                            FROM fornecedor $where";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="fornecedor-card">
                
                <div class="fornecedor-card-info">
                    <div class="fornecedor-card-title"><?php echo $row['nome_f']; ?></div>
                    <div class="fornecedor-card-cnpj">cnpj: <?php echo $row['cnpj']; ?></div>
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
