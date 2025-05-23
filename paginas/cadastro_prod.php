<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/formStyle.css">
</head>

<body>
    <div class="form-bg">
        <img src="../assets/img/bg-circles.svg" alt="Fundo" class="bg-circles-img">
        <div class="form-main">
            <div class="form-left">
                <h1 class="h1-left">Cadastro<br>de produtos</h1>
            </div>
            <div class="form-right">
                <div class="settings-icon right">
                    <a href="estoque.php"><img src="../assets/img/voltar.svg" alt="voltar"></a>
                    <a href="../index.php"><img src="../assets/img/gear.svg" alt="Configurações"></a>
                </div>
                <form class="form-form" action="../db/processa_cadastro.php" method="POST">
                    <h2 class="h1-right">preencha os campos a baixo:</h2>
                    <input type="text" name="nome" placeholder="nome" required>
                    <input type="text" name="quantidade" placeholder="quantidade" required>
                    <input type="text" name="preço" placeholder="preço" required>
                    <input type="text" name="cor" placeholder="cor" required>
                    <input type="text" name="tipo" placeholder="tipo" required>
                    <button type="submit">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>