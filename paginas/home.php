<!DOCTYPE html>
<?php
    session_start();
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/Loja-de-roupa/assets/css/homeStyle.css">
    <link rel="stylesheet" href="/Loja-de-roupa/assets/css/style.css">
</head>

<body>
    <div class="login-bg">
        <img src="/Loja-de-roupa/assets/img/bg-circles.svg" alt="Fundo" class="bg-circles-img">
        <div class="login-main">
            <div class="login-left">
                <h1 class="h1-left">Home<br><?php
                        if ($_SESSION['cargo'] == 'gerente') {
                            echo 'Gerente';
                        } else {
                            echo 'Funcionário';
                        }
                    ?>
                </h1>
            </div>
            <div class="login-right">
                <div class="settings-icon right">
                    <a href="/Loja-de-roupa/index.php"><img src="/Loja-de-roupa/assets/img/gear.svg" alt="Configurações"></a>
                </div>
                <div class="login-form"">
                    <a href="/Loja-de-roupa/paginas/vendas.php"><button class="home-button">Realizar venda</button></a>
                    <a href="/Loja-de-roupa/paginas/relatorio_vendas.php"><button class="home-button">Relatório de venda</button></a>
                    <?php
                        if ($_SESSION['cargo'] == 'gerente') {
                            echo '<a href="/Loja-de-roupa/paginas/funcionarios.php"><button class="home-button">Funcionários</button></a>';
                            echo '<a href="/Loja-de-roupa/paginas/estoque.php"><button class="home-button">Estoque</button></a>';
                            echo '<a href="/Loja-de-roupa/paginas/fornecedores.php"><button class="home-button">Fornecedores</button></a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>