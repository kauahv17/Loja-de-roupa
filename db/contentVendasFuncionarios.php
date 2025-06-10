<?php include '../db/conexao.php'; ?>

<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <h1 style="text-align:center;">Relatório de Vendas por Funcionário</h1>
    <table border="1" style="width:100%; border-collapse:collapse; font-size:12pt;" cellspacing="0">
        <thead>
            <tr style="background-color:#ccc;">
                <th>ID</th>
                <th>Funcionário</th>
                <th>Total de Pedidos</th>
                <th>Itens Vendidos</th>
                <th>Total em Vendas (R$)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "
                SELECT 
                    f.idfuncionario,
                    f.nome,
                    COUNT(DISTINCT p.idpedido) AS total_pedidos,
                    SUM(pp.quantidade) AS total_itens,
                    SUM(pp.quantidade * pp.preco_ped) AS total_vendas
                FROM funcionario f
                JOIN pedido p ON p.idfuncionario = f.idfuncionario
                JOIN produto_pedido pp ON pp.idpedido = p.idpedido
                JOIN venda v ON v.idpedido = p.idpedido
                GROUP BY f.idfuncionario, f.nome
                ORDER BY total_vendas DESC
            ";

            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['idfuncionario']}</td>
                        <td>{$row['nome']}</td>
                        <td>{$row['total_pedidos']}</td>
                        <td>{$row['total_itens']}</td>
                        <td>R$ " . number_format($row['total_vendas'], 2, ',', '.') . "</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</page>
