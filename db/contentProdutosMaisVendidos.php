<?php
include '../db/conexao.php';
?>

<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <h1 style="text-align:center; color:#e67e22; font-size:18pt;">Relatório de Produtos Mais Vendidos</h1>
    <div style="text-align:center;">
    <table border="1" cellspacing="0" cellpadding="8" style="width:90%; margin: 0 auto; border-collapse: collapse; font-size: 14pt; font-family: Arial, sans-serif;">
        <thead>
            <tr style="background-color: #e67e22; color: white;">
                <th style="width:10%;">ID</th>
                <th style="width:30%;">Produto</th>
                <th style="width:20%;">Quantidade Vendida</th>
                <th style="width:20%;">Preço Unitário (R$)</th>
                <th style="width:25%;">Total em Vendas (R$)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "
                SELECT 
                    p.idproduto,
                    p.nome,
                    SUM(pp.quantidade) AS total_vendida,
                    p.preco_uni,
                    SUM(pp.quantidade * pp.preco_ped) AS total_vendas
                FROM produto p
                JOIN produto_pedido pp ON p.idproduto = pp.idproduto
                GROUP BY p.idproduto, p.nome, p.preco_uni
                ORDER BY total_vendida DESC
            ";

            $result = mysqli_query($conn, $sql);
            $linha = 0;
            $totalGeral = 0;

            while ($row = mysqli_fetch_assoc($result)) {
                $bgColor = ($linha % 2 == 0) ? '#fff3e0' : '#ffe0b2'; // linhas alternadas
                echo "<tr style='background-color: {$bgColor};'>
                        <td>{$row['idproduto']}</td>
                        <td>{$row['nome']}</td>
                        <td>{$row['total_vendida']}</td>
                        <td>R$ " . number_format($row['preco_uni'], 2, ',', '.') . "</td>
                        <td>R$ " . number_format($row['total_vendas'], 2, ',', '.') . "</td>
                      </tr>";
                $totalGeral += $row['total_vendas'];
                $linha++;
            }

            // Linha de total geral
            echo "<tr style='background-color:#e67e22; color:white; font-weight:bold;'>
                    <td colspan='4' style='text-align:right;'>TOTAL GERAL</td>
                    <td>R$ " . number_format($totalGeral, 2, ',', '.') . "</td>
                  </tr>";
            ?>
        </tbody>
    </table>
    </div>
</page>
