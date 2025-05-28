<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="/Loja-de-roupa/assets/img/logo_ME.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/formStyle.css">
</head>

<body>
    <div class="form-bg">
        <img src="assets/img/bg-circles.svg" alt="Fundo" class="bg-circles-img">
        <div class="form-main">
            <div class="form-left">
                <h1 class="h1-left">Bem-vindo à<br>Moda Elegante</h1>
            </div>
            <div class="form-right">
                <form class="form-form" action="db/processa_login.php" method="POST">
                    <h2 class="h1-right">Login</h2>
                    <input type="text" name="email" placeholder="email" required>
                    <input type="password" name="senha" placeholder="senha" required>
                    <button type="submit">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>