<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
    <link rel="icon" type="image/png" href="../assets/img/logo_ME.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/carrinhoStyle.css">
    <link rel="stylesheet" href="../assets/css/sidebarStyle.css">
    <style>
        body {
            background: #fafafa;
        }
        .pagamento-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 80vh;
        }
        .pagamento-qr {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #000;
            border-radius: 18px;
            padding: 32px 32px 16px 32px;
            margin-top: 32px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }
        .pagamento-qr img {
            width: 400px;
            height: 400px;
            background: #fff;
            border-radius: 8px;
            margin-bottom: 16px;
        }
        .pagamento-qr span {
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
        }
        .pagamento-title {
            font-size: 2rem;
            font-weight: bold;
            color: #444;
            margin-top: 32px;
            margin-bottom: 16px;
            text-align: center;
        }
        .settings-icon.left {
            position: absolute;
            top: 24px;
            left: 24px;
        }
        .settings-icon.right {
            position: absolute;
            top: 24px;
            right: 24px;
        }
    </style>
</head>
<body>
    <div class="settings-icon left">
        <a href="vendas.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
    </div>
    <div class="settings-icon right">
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
    <div class="pagamento-container">
        <div class="pagamento-title">Pagamento</div>
        <div class="pagamento-qr">
            <img src="../assets/img/qrcode.svg" alt="QR Code">
        </div>
    </div>
    <script src="../js/configuracoes.js"></script>
</body>
</html>
