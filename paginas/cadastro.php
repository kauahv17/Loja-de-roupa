<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/cadastroStyle.css">
</head>

<body>
    <div class="login-bg">
        <img src="../assets/img/bg-circles.svg" alt="Fundo" class="bg-circles-img">
        <div class="login-main">
            <div class="login-left">
                <h1 class="h1-left">Cadastro<br>de funcionário</h1>
            </div>
            <div class="login-right">
                <div class="settings-icon right">
                    <a href="funcionarios.php"><img src="../assets/img/voltar.svg" alt="voltar"></a>
                    <a href="../index.php"><img src="../assets/img/gear.svg" alt="Configurações"></a>
                </div>
                <form class="cadastro-form" action="../db/processa_cadastro.php" method="POST">
                    <h2 class="h1-right">preencha os campos a baixo:</h2>
                    <input type="text" name="nome" placeholder="nome" required>
                    <input type="text" name="cpf" placeholder="cpf" required>
                    <input type="text" name="email" placeholder="email" required>
                    <input type="password" name="senha" placeholder="senha" required>
                    <button type="submit">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>