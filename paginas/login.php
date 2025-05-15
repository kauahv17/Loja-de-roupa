<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="login-bg">
        <img src="assets/img/bg-circles.svg" alt="Fundo" class="bg-circles-img">
        <div class="login-main">
            <div class="login-left">
                <h1>Bem-vindo à<br>Moda Elegante</h1>
            </div>
            <div class="login-right">
                <div class="settings-icon">
                    <img src="assets/img/gear.svg" alt="Configurações">
                </div>
                <form class="login-form" action="db/processa_login.php" method="POST">
                    <h2>Login</h2>
                    <input type="text" name="email" placeholder="email" required>
                    <input type="password" name="senha" placeholder="senha" required>
                    <button type="submit">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>