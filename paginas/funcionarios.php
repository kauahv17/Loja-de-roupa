<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários</title>
    <link rel="icon" type="image/png" href="/Loja-de-roupa/assets/img/logo_ME.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/funcionarioStyle.css">
    <link rel="stylesheet" href="../assets/css/sidebarStyle.css">
    <script src="../js/confirmacao_delete.js"></script>

</head>
<body>
<div class="settings-icon left">
        <a href="home.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
    </div>
    <div class="settings-icon right">
        <a href="cadastro_func.php"><img src="../assets/img/add_func.svg" alt="Adicionar"></a>
        <a href="pdfVendasFuncionario.php"><img src="../assets/img/pdf.svg" alt="PDF Vendas por Funcionários" style="width:45px;"></a>
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
    <div class="funcionario-container">
        <div class="funcionario-header">
            <div class="h1-right">Funcionários</div>
        </div>
        <form class="funcionario-search">
            <input type="text" placeholder="pesquisa" name="pesquisa">
            <button type="submit" class="funcionario-search-btn"><img src="../assets/img/lupa.svg" alt="Buscar"></button>
        </form>
        <div class="funcionario-lista">
            <?php 
                include_once '../db/conexao.php';
                $where = "WHERE funcionario.cargo != 'apagado'";
                if (isset($_GET['pesquisa']) && $_GET['pesquisa'] != '') {
                    $pesquisa = mysqli_real_escape_string($conn, $_GET['pesquisa']);
                    $where = "WHERE funcionario.cargo != 'apagado' AND (funcionario.nome LIKE '%$pesquisa%' OR funcionario.cpf LIKE '%$pesquisa%')";
                }
                $sql = "SELECT 
                            funcionario.idfuncionario as id,
                            funcionario.nome,
                            funcionario.cpf,
                            funcionario.email
                            FROM funcionario
                            $where";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="funcionario-card">
                <div class="funcionario-card-img">
                    <img src="../assets/img/prod_img.svg" alt="funcionario">
                </div>
                <div class="funcionario-card-info">
                    <div class="funcionario-card-title"><?php echo $row['nome']; ?></div>
                    <div class="funcionario-card-cpf">CPF: <?php echo $row['cpf']; ?></div>
                    <div class="funcionario-card-email">Email: <?php echo $row['email']; ?></div>
                    <div class="funcionario-card-actions">
                        <a href="cadastro_func.php?id=<?=$row['id'];?>"><img src="../assets/img/editar.svg" alt="Editar"></a>
                        <a href="../db/deleta_funcionario.php?id=<?=$row['id'];?>" class="delete-funcionario"><img src="../assets/img/lixeiraw.svg" alt="Excluir"></a>
                    </div>
                </div>
            </div>
            <?php
                }
            }else {
                echo "<p style='margin: 20px;'>Nenhum funcionário encontrado.</p>";
            }
            ?>
        </div>
    </div>
    <script src="../js/configuracoes.js"></script>
</body>
</html>  
