<?php
    session_start();
    include_once("../db/conexao.php");
    
    if (!isset($_SESSION['idfuncionario'])) {
        header("location: ../index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devolução</title>
    <link rel="icon" type="image/png" href="../assets/img/logo_ME.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/sidebarStyle.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .devolucao-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .devolucao-header {
            margin-bottom: 20px;
        }
        .devolucao-form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .produtos-container {
            margin-top: 20px;
        }
        .produto-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .produto-item-col {
            display: flex;
            flex-direction: column;
        }
        .select-col {
            justify-content: center;
        }
        .info-col {
            flex-grow: 1;
        }
        .qtd-col {
            width: 100px;
            align-items: center;
        }
        .produto-nome {
            font-weight: bold;
            font-size: 1.1em;
            color: #333;
            cursor: pointer;
        }
        .produto-detalhe {
            font-size: 0.9em;
            color: #666;
        }
        .qtd-input {
            width: 60px;
            text-align: center;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[readonly].qtd-input {
            background-color: #eee;
            border: 1px solid #ddd;
        }
        .qtd-col label {
            font-size: 0.9em;
            margin-bottom: 5px;
            color: #555;
        }
        .btn-devolucao {
            background-color: #e67e22;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-devolucao:hover {
            background-color: #d35400;
        }
    </style>
</head>
<body>
    <div class="settings-icon left">
        <a href="home.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
    </div>
    <div class="settings-icon right">
        <div class="settings-icone" onclick="toggleSidebar()">
            <img src="../assets/img/gear.svg" alt="Configurações" style="cursor: pointer;">
            <div class="sidebar" id="sidebar">
                <h2>Configurações</h2>
                <h4><strong>Nome:</strong> <?php echo $_SESSION['nome']; ?></h4>
                <h4><strong>ID:</strong> <?php echo $_SESSION['idfuncionario']; ?></h4>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <a href="../index.php">
                    <img src="../assets/img/sair.svg" alt="Sair"> 
                </a>
            </div>
        </div>
    </div>

    <div class="devolucao-container">
        <div class="devolucao-header">
            <h1>Devolução de Produtos</h1>
        </div>

        <div class="devolucao-form">
            <form method="POST" action="../db/processa_devolucao.php">
                <div class="form-group">
                    <label for="venda">Selecione a Venda:</label>
                    <select name="idvenda" id="venda" class="form-control" required>
                        <option value="">Selecione uma venda</option>
                        <?php
                        $sql = "SELECT v.idvenda, v.data_venda, c.nome as cliente, p.valor_total 
                                FROM venda v 
                                JOIN pedido p ON v.idpedido = p.idpedido 
                                JOIN cliente c ON p.idcliente = c.idcliente 
                                ORDER BY v.data_venda DESC";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $data_formatada = date('d/m/Y H:i', strtotime($row['data_venda']));
                            echo "<option value='{$row['idvenda']}'>
                                    Venda #{$row['idvenda']} - {$data_formatada} - Cliente: {$row['cliente']} - 
                                    R$ " . number_format($row['valor_total'], 2, ',', '.') . "
                                  </option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="produtos-container" id="produtos-venda">
                    <!-- Os produtos da venda serão carregados aqui via AJAX -->
                </div>

                <div class="form-group">
                    <label for="motivo">Motivo da Devolução:</label>
                    <textarea name="motivo" id="motivo" class="form-control" required rows="3"></textarea>
                </div>

                <button type="submit" class="btn-devolucao">Processar Devolução</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="../js/configuracoes.js"></script>
    <script>
        $(document).ready(function() {
            $('#venda').select2({
                placeholder: 'Selecione uma venda',
                width: '100%'
            });

            $('#venda').change(function() {
                const idvenda = $(this).val();
                if (idvenda) {
                    $.ajax({
                        url: '../db/buscar_produtos_venda.php',
                        type: 'POST',
                        data: { idvenda: idvenda },
                        success: function(response) {
                            $('#produtos-venda').html(response);
                        },
                        error: function() {
                            alert('Erro ao carregar produtos da venda');
                        }
                    });
                } else {
                    $('#produtos-venda').html('');
                }
            });
        });

        function toggleDevolucao(checkbox, idproduto) {
            const qtdInput = document.getElementById('qtd_devolucao_' + idproduto);
            if (checkbox.checked) {
                qtdInput.disabled = false;
                qtdInput.focus();
            } else {
                qtdInput.disabled = true;
            }
        }
    </script>
</body>
</html> 