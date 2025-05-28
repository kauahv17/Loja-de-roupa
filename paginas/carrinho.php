<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="icon" type="image/png" href="/Loja-de-roupa/assets/img/logo_ME.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/carrinhoStyle.css">
    <link rel="stylesheet" href="../assets/css/selectStyle.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body>
<div class="settings-icon left">
        <a href="vendas.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
    </div>
    <div class="settings-icon right">
        <a href="../index.php"><img src="../assets/img/gear.svg" alt="Configurações"></a>
    </div><br><br>
        <div class="carrinho-header">
            <div class="h1-right">Carrinho</div>
        </div>
        <br><br><br>


        <div class="carrinho-header">
            <div class="h1-right">Cliente</div>
        </div>
          <div>
            <form class="form-form" action="../db/processa_cliente.php" method="POST" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">    
        
                <select class="select-cliente" name="idcliente" required style="width: 500px; height: 60px; font-size: 20px; padding: 6px; border-radius: 6px;">
                    <option value="">Selecione o cliente</option>
                    <?php
                        include_once("../db/conexao.php");
                        $sql = "SELECT idcliente, nome FROM cliente ORDER BY nome ASC";
                        $result = mysqli_query($conn, $sql);
                        if($result){
                            while($row = mysqli_fetch_assoc($result)){
                            echo "<option value='{$row['idcliente']}'>{$row['nome']}</option>";
                            }
                        } else {
                            echo "<option value=''>Erro ao carregar clientes</option>";
                        }
                    ?>
                </select>

                <button class = "cadastrar" onclick="window.location.href='cadastro_cliente.php'">Cadastrar Cliente</button>   
            </form>
</div>
<script>
    $(document).ready(function() {
        $('.select-cliente').select2({
            placeholder: "Selecione o cliente",
            allowClear: true
        });
    });
</script>