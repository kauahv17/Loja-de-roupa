<?php
include 'conexao.php';

echo '
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <h1 style="text-align:center; color:#e67e22; font-size:18pt;">Relatório de Vendas por Dia</h1>
    <div style="text-align:center;">
    <table border="1" cellspacing="0" cellpadding="8" style="width:90%; margin: 0 auto; border-collapse: collapse; font-size: 14pt; font-family: Arial, sans-serif;">
        <thead>
            <tr style="background-color: #e67e22; color: white;">
                <th style="width:25%;">Data da Venda</th>
                <th style="width:25%;">Cliente</th>
                <th style="width:25%;">Funcionário</th>
                <th style="width:25%;">Valor Total (R$)</th>
            </tr>
        </thead>
        <tbody>
';

$sql = "
    SELECT 
        DATE(v.data_venda) AS data,
        v.data_venda,
        c.nome AS cliente,
        f.nome AS funcionario,
        p.valor_total
    FROM venda v
    JOIN pedido p ON v.idpedido = p.idpedido
    JOIN cliente c ON p.idcliente = c.idcliente
    JOIN funcionario f ON p.idfuncionario = f.idfuncionario
    ORDER BY data DESC, v.data_venda ASC
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $currentDate = null;
    $dailyTotal = 0;
    $linha = 0;

    while ($row = $result->fetch_assoc()) {
        $saleDate = $row['data'];
        // Quando mudar a data, exibe o total do dia anterior (exceto no primeiro loop)
        if ($currentDate !== null && $currentDate != $saleDate) {
            // Linha total do dia anterior
            echo "<tr style='background-color:#e67e22; color:white; font-weight:bold;'>
                    <td colspan='3' style='text-align:right;'>Total do dia " . date('d/m/Y', strtotime($currentDate)) . "</td>
                    <td>R$ " . number_format($dailyTotal, 2, ',', '.') . "</td>
                  </tr>";
            $dailyTotal = 0;
        }

        $bgColor = ($linha % 2 == 0) ? '#fff3e0' : '#ffe0b2'; // tons laranja claros alternados
        echo "<tr style='background-color: {$bgColor};'>
                <td>" . date('d/m/Y H:i', strtotime($row['data_venda'])) . "</td>
                <td>{$row['cliente']}</td>
                <td>{$row['funcionario']}</td>
                <td>R$ " . number_format($row['valor_total'], 2, ',', '.') . "</td>
              </tr>";

        $dailyTotal += $row['valor_total'];
        $currentDate = $saleDate;
        $linha++;
    }

    // Exibe o total do último dia
    echo "<tr style='background-color:#e67e22; color:white; font-weight:bold;'>
            <td colspan='3' style='text-align:right;'>Total do dia " . date('d/m/Y', strtotime($currentDate)) . "</td>
            <td>R$ " . number_format($dailyTotal, 2, ',', '.') . "</td>
          </tr>";

} else {
    echo '<tr><td colspan="4" style="text-align:center; background-color: #fff8f0;">Nenhuma venda encontrada.</td></tr>';
}

echo '
        </tbody>
    </table>
    </div>
</page>
';
?>
