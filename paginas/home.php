<!DOCTYPE html>
<?php
    session_start();
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/formStyle.css">
    <link rel="stylesheet" href="../assets/css/homeStyle.css">
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
                <div class="settings-icon right">
                    <a href="../index.php"><img src="../assets/img/gear.svg" alt="Configurações"></a>
                </div>
                <div class="form-form">
                    <a href="vendas.php"><button class="home-button">Realizar venda</button></a>
                    <a href="relatorio_vendas.php"><button class="home-button">Relatório de venda</button></a>
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
</body>
</html>