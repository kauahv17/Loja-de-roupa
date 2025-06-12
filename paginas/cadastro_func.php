<?php
    session_start();
    include_once("../db/conexao.php");

    $row = [
        'nome' => '',
        'cpf' => '',
        'email' => '',
        'cargo' => '',
        'senha' => ''
    ];
    $pageTitle = "Cadastro <br>de funcionário";
    $idfuncionario = null;

    if (isset($_GET['id'])) {
        $idfuncionario = $_GET['id'];
        $pageTitle = "Atualizar <br> funcionário";
        $sql = "SELECT * FROM funcionario WHERE idfuncionario = $idfuncionario;";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($res);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="icon" type="image/png" href="/Loja-de-roupa/assets/img/logo_ME.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/formStyle.css">
    <link rel="stylesheet" href="../assets/css/sidebarStyle.css">
</head>

<body>
    <div class="form-bg">
        <img src="../assets/img/bg-circles.svg" alt="Fundo" class="bg-circles-img">
        <div class="form-main">
            <div class="form-left">
                <h1 class="h1-left"><?php echo $pageTitle; ?></h1>
            </div>
            <div class="form-right">
                <div class="settings-icon right">
                    <a href="funcionarios.php"><img src="../assets/img/voltar.svg" alt="voltar"></a>
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
                <form class="form-form" action="<?php echo ($idfuncionario !== null) ? '../db/atualiza_funcionario.php' : '../db/processa_cadastro.php'; ?>" method="POST">
                    <h2 class="h1-right">preencha os campos a baixo:</h2>
                    
                    <?php if ($idfuncionario !== null): ?>
                        <input type="hidden" name="idfuncionario" value="<?php echo $idfuncionario; ?>">
                    <?php endif; ?>
                    <input type="text" name="nome" placeholder="nome" value="<?php echo $row['nome']; ?>" required>
                    <input type="text" name="cpf" placeholder="cpf" value="<?php echo $row['cpf']; ?>" <?php echo ($idfuncionario !== null) ? 'readonly' : ''; ?> required>
                    <input type="text" name="email" placeholder="email" value="<?php echo $row['email']; ?>" required>
                    <input type="text" name="cargo" placeholder="cargo" value="<?php echo $row['cargo']; ?>" required>
                    <input type="password" name="senha" placeholder="senha" value="" required>
                    <button type="submit"><?php echo ($idfuncionario !== null) ? 'Atualizar' : 'Cadastrar'; ?></button>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/configuracoes.js"></script>
</body>

</html>