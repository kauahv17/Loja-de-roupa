<?php

session_start();
include_once '../db/conexao.php';

// Obter o ID do funcionário selecionado
$funcionario = isset($_GET['funcionario']) ? mysqli_real_escape_string($conn, $_GET['funcionario']) : '';

// Montar a cláusula WHERE se necessário
$where = '';
if (!empty($funcionario)) {
    $where = "WHERE f.idfuncionario = '$funcionario'";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de vendas</title>
    <link rel="icon" type="image/png" href="/Loja-de-roupa/assets/img/logo_ME.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/filtroStyle.css">
    <link rel="stylesheet" href="../assets/css/tabelaRelatorioStyle.css">
</head>
    <div class="container my-4"><br>
        <div class="chart-icon left">
            <a href="home.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
        </div>
        <div class="chart-icon right form-form">
            <a href="pdfProduto.php" data-toggle="modal"><img src="../assets/img/pdf.svg" alt="PDF Produtos em Estoque" style="width:60px;"></a>
            <a href="../index.php"><img src="../assets/img/gear.svg" alt="Configurações"></a>
        </div>
        <h1 class="text-center color"><a href="relatorio_vendas.php">Relatório de vendas</a></h1>
    </div><br>
    <?php
        
        // Consulta das vendas
        $sql = "SELECT 
        v.idvenda,
        p.data_pedido,
        c.nome AS cliente,
            pr.nome AS produto,
            pp.quantidade,
            pp.tamanho,
            pp.preco_ped
            FROM venda v
            JOIN pedido p ON v.idpedido = p.idpedido
            JOIN cliente c ON p.idcliente = c.idcliente
        JOIN funcionario f ON p.idfuncionario = f.idfuncionario
        JOIN produto_pedido pp ON p.idpedido = pp.idpedido
        JOIN produto pr ON pp.idproduto = pr.idproduto
        $where
        ORDER BY v.idvenda DESC";
        
        $result = mysqli_query($conn, $sql);
        
        // Consulta para listar os funcionários
$sqlFunc = "SELECT idfuncionario, nome FROM funcionario";
$resultFunc = mysqli_query($conn, $sqlFunc);
?>


<div class="container mt-4">

    <!-- Botões de filtro por funcionário -->
    <form method="GET" class="mb-4">
        <div class="d-flex flex-wrap justify-content-center form-form">
            <?php while ($func = mysqli_fetch_assoc($resultFunc)): ?>
                <button 
                    type="submit" 
                    name="funcionario" 
                    value="<?= $func['idfuncionario'] ?>" 
                    class="btn-color <?= ($funcionario == $func['idfuncionario']) ? 'ativo' : '' ?>">
                    <?= $func['nome'] ?>
                </button>
            <?php endwhile; ?>
        </div>
    </form>

    <!-- Tabela com os resultados -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Quantidade</th>
                <th>Valor</th>
                <th>Data do Pedido</th>
                <th class="text-center" style="color: white;">
                    <a href="graficos.php" data-toggle="modal">
                        <img src="../assets/img/chart.svg" alt="Gráfico" style="width:35px;">
                    </a>
                </th> 
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['idvenda'] ?></td>
                        <td><?= htmlspecialchars($row['cliente']) ?></td>
                        <td><?= $row['quantidade'] ?></td>
                        <td>R$ <?= number_format($row['preco_ped'], 2, ',', '.') ?></td>
                        <td><?= date('d/m/Y', strtotime($row['data_pedido'])) ?></td>
                        <td class="text-center">
                            <!-- Ícone de visualização (por exemplo, um olho) -->
                            <a href="carrinho.php?id=<?= $row['idvenda'] ?>" title="Visualizar venda">
                                <img src="../assets/img/eye.svg" alt="Visualizar" style="width:30px;">
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Nenhuma venda encontrada para este funcionário.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>

</html> 

