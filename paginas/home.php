<!DOCTYPE html>
<?php
    session_start();
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" type="image/png" href="/Loja-de-roupa/assets/img/logo_ME.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/formStyle.css">
    <link rel="stylesheet" href="../assets/css/homeStyle.css">
    <link rel="stylesheet" href="../assets/css/sidebarStyle.css">
</head>

<body>
    <div class="form-bg">
        <img src="../assets/img/bg-circles.svg" alt="Fundo" class="bg-circles-img">
        <div class="form-main">
            <div class="form-left">
                <h1 class="h1-left">Home<br><?php
                        if ($_SESSION['cargo'] == 'gerente') {
                            echo 'Gerente';
                        } else {
                            echo 'Funcionário';
                        }
                    ?>
                </h1>
            </div>
            <div class="form-right">
                <div class="settings-icone right" onclick="toggleMenu()">
                    <div class="settings-icon right" onclick="toggleSidebar()">
                        <img src="../assets/img/gear.svg" alt="Configurações" style="cursor: pointer;">
                    </div>
                    <div class="sidebar" id="sidebar">
                    <div>
                        <h2>Configurações</h2>
                        <h4><strong>Nome:</strong> <?php echo $_SESSION['nome']; ?></h4>
                        <h4><strong>ID:</strong> <?php echo $_SESSION['idfuncionario']; ?></h4><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    </div>
                    <a href="../index.php">
                        <img src="../assets/img/sair.svg" alt="Sair"> 
                    </a>
                    </div>
                </div>
                <div class="form-form">
                    <a href="vendas.php"><button class="home-button">Realizar venda</button></a>
                    <a href="relatorio_vendas.php"><button class="home-button">Relatório de venda</button></a>
                    <a href="devolucao.php"><button class="home-button">Devolução</button></a>
                    <?php
                        if ($_SESSION['cargo'] == 'gerente') {
                            echo '<a href="funcionarios.php"><button class="home-button">Funcionários</button></a>';
                            echo '<a href="estoque.php"><button class="home-button">Estoque</button></a>';
                            echo '<a href="fornecedores.php"><button class="home-button">Fornecedores</button></a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/configuracoes.js"></script>
</body>
</html>