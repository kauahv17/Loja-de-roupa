<?php include '../db/conexao.php';?>

<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <h1 style="text-align:center; color:#e67e22; font-size:18pt;">Relatório de Produtos</h1>
    <div style="text-align:center;">
    <table border="1" cellspacing="0" cellpadding="8" style="width:90%; margin: 0 auto; border-collapse: collapse; font-size: 14pt; font-family: Arial, sans-serif;">
        <thead>
            <tr style="background-color: #e67e22; color: white;">
                <th style="width:8%;">ID</th>
                <th style="width:30%;">Nome</th>
                <th style="width:15%;">Cor</th>
                <th style="width:17%;">Estoque</th>
                <th style="width:22%;">Preço Unitário (R$)</th>
                <th style="width:15%;">Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT p.idproduto, p.nome, p.cor, p.quantidade_estoque, p.preco_uni, t.tipo 
                    FROM produto p 
                    JOIN tipo_produto t ON p.idtipo_produto = t.idtipo_produto 
                    ORDER BY p.idproduto ASC";
            $result = mysqli_query($conn, $sql);
            $linha = 0;

            while ($row = mysqli_fetch_assoc($result)) {
                $bgColor = ($linha % 2 == 0) ? '#fff3e0' : '#ffe0b2'; // tons laranja claros alternados
                echo "<tr style='background-color: {$bgColor};'>
                        <td>{$row['idproduto']}</td>
                        <td>{$row['nome']}</td>
                        <td>{$row['cor']}</td>
                        <td>{$row['quantidade_estoque']}</td>
                        <td>R$ " . number_format($row['preco_uni'], 2, ',', '.') . "</td>
                        <td>{$row['tipo']}</td>
                      </tr>";
                $linha++;
            }
            ?>
        </tbody>
    </table>
    </div>
</page>
