<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/homeStyle.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-bg">
        <img src="assets/img/bg-circles.svg" alt="Fundo" class="bg-circles-img">
        <div class="login-main">
            <div class="login-left">
                <h1>Home<br><?php
                        $idfuncionario = 1;
                        $idgerente = 0;
                        if ($idfuncionario == $idgerente) {
                            echo 'Gerente';
                        } else {
                            echo 'Funcionário';
                        }
                    ?>
                </h1>
            </div>
            <div class="login-right">
                <div class="settings-icon">
                    <img src="assets/img/gear.svg" alt="Configurações">
                </div>
                <div class="login-form" style="margin-top: 25vh; gap: 18px;">
                    <button class="home-button">Realizar venda</button>
                    <button class="home-button">Relatório de venda</button>
                    <?php
                        $idfuncionario = 1;
                        $idgerente = 0;
                        if ($idfuncionario == $idgerente) {
                            echo '<button class="home-button">Funcionários</button>';
                            echo '<button class="home-button">Estoque</button>';
                            echo '<button class="home-button">Fornecedores</button>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>