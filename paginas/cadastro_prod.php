<?php
    session_start();
    include_once("../db/conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
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
                <h1 class="h1-left">Cadastro<br>de produtos</h1>
            </div>
            <div class="form-right">
                <div class="settings-icon right">
                    <a href="estoque.php"><img src="../assets/img/voltar.svg" alt="voltar"></a>
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
                
                <form class="form-form" action="../db/processa_produto.php" method="POST">
                    <h2 class="h1-right">preencha os campos a baixo:</h2>
                    <input type="text" name="nome" placeholder="nome" required>
                    <!-- <input type="number" name="quantidade" placeholder="quantidade" required>-->
                    <input type="number" name="preco" id="preco" placeholder="preço" step="1" min="0" required>
                    <input type="text" name="cor" placeholder="cor" required>
                    <select name="tipo" required>
                            <option value="">selecione o tipo</option>
                            <?php
                                
                                $sql = "SELECT idtipo_produto, tipo FROM tipo_produto";
                                $result = mysqli_query($conn, $sql);
    
                            if($result){
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<option value='{$row['idtipo_produto']}'>{$row['tipo']}</option>";
                                }
                            } else {
                                echo "<option value=''>Erro ao carregar tipo de produto</option>";
                            }
                            ?>
                    </select>
                    
                    <input type="number" name="preco_for" placeholder="preço fornecedor" step="1" min="0" required>
                    <input type="number" name="quantidade_for" placeholder="quantidade fornecida" required>
                    <!-- Fornecedor -->
                        <select name="idfornecedor" required>
                            <option value="">selecione o fornecedor</option>
                            <?php
                                
                                $sql = "SELECT idfornecedor, nome FROM fornecedor";
                                $result = mysqli_query($conn, $sql);
    
                            if($result){
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<option value='{$row['idfornecedor']}'>{$row['nome']}</option>";
                                }
                            } else {
                                echo "<option value=''>Erro ao carregar fornecedores</option>";
                            }
                            ?>
                        </select>
                    
                    <button type="submit">Cadastrar</button><br>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/configuracoes.js"></script>
</body>

</html>