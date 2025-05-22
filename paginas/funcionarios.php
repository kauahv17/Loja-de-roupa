<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/funcionarioStyle.css">
</head>
<body>
<div class="settings-icon left">
        <a href="home.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
    </div>
    <div class="settings-icon right">
        <a href="cadastro_func.php"><img src="../assets/img/add_func.svg" alt="Adicionar"></a>
        <a href="../index.php"><img src="../assets/img/gear.svg" alt="Configurações"></a>
    </div>
    <div class="funcionario-container">
        <div class="funcionario-header">
            <div class="h1-right">Funcionários</div>
        </div>
        <form class="funcionario-search">
            <input type="text" placeholder="pesquisa" name="pesquisa">
            <button type="submit" class="funcionario-search-btn"><img src="../assets/img/lupa.svg" alt="Buscar"></button>
        </form>
        <div class="funcionario-lista">
            <?php 
                include_once '../db/conexao.php';
                $where = "WHERE funcionario.cargo = 'funcionario'";
                if (isset($_GET['pesquisa']) && $_GET['pesquisa'] != '') {
                    $pesquisa = mysqli_real_escape_string($conn, $_GET['pesquisa']);
                    $where = "WHERE funcionario.cargo = 'funcionario' AND (funcionario.nome LIKE '%$pesquisa%' OR funcionario.cpf LIKE '%$pesquisa%')";
                }
                $sql = "SELECT 
                            funcionario.nome,
                            funcionario.cpf,
                            funcionario.email
                            FROM funcionario
                            $where";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="funcionario-card">
                <div class="funcionario-card-img">
                    <img src="../assets/img/prod_img.svg" alt="funcionario">
                </div>
                <div class="funcionario-card-info">
                    <div class="funcionario-card-title"><?php echo $row['nome']; ?></div>
                    <div class="funcionario-card-cpf">CPF: <?php echo $row['cpf']; ?></div>
                    <div class="funcionario-card-email">Email: <?php echo $row['email']; ?></div>
                    <div class="funcionario-card-actions">
                        <a href="cadastro_func.php?"><img src="../assets/img/editar.svg" alt="Editar"></a>
                        <a href="excluir_funcionario.php?"><img src="../assets/img/lixeira.svg" alt="Excluir"></a>
                    </div>
                </div>
            </div>
            <?php
                }
            }else {
                echo "<p style='margin: 20px;'>Nenhum funcionário encontrado.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>  
