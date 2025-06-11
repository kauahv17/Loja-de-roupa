<?php include '../db/conexao.php'; ?>

<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <h1 style="text-align:center; color:#e67e22; font-size:18pt;">Relatório de Vendas por Funcionário</h1>
    <div style="text-align:center;">
    <table border="1" cellspacing="0" cellpadding="8" style="width:90%; margin: 0 auto; border-collapse: collapse; font-size: 14pt; font-family: Arial, sans-serif;">
        <thead>
            <tr style="background-color: #e67e22; color: white;">
                <th style="width:10%;">ID</th>
                <th style="width:30%;">Funcionário</th>
                <th style="width:20%;">Total de Pedidos</th>
                <th style="width:20%;">Itens Vendidos</th>
                <th style="width:20%;">Total em Vendas (R$)</th>
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
            $linha = 0;
            $totalGeralVendas = 0;

            while ($row = mysqli_fetch_assoc($result)) {
                $bgColor = ($linha % 2 == 0) ? '#fff3e0' : '#ffe0b2'; // Laranja claro alternado
                echo "<tr style='background-color: {$bgColor};'>
                        <td>{$row['idfuncionario']}</td>
                        <td>{$row['nome']}</td>
                        <td>{$row['total_pedidos']}</td>
                        <td>{$row['total_itens']}</td>
                        <td>R$ " . number_format($row['total_vendas'], 2, ',', '.') . "</td>
                      </tr>";
                $totalGeralVendas += $row['total_vendas'];
                $linha++;
            }

            // Linha do total geral
            echo "<tr style='background-color:#e67e22; color:white; font-weight:bold;'>
                    <td colspan='4' style='text-align:right;'>TOTAL GERAL</td>
                    <td>R$ " . number_format($totalGeralVendas, 2, ',', '.') . "</td>
                  </tr>";
            ?>
        </tbody>
    </table>
    </div>
</page>
