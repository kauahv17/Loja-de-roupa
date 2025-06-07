<?php include '../db/conexao.php';?>

<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <h1 style="text-align:center;">Relatório de Produtos</h1>
    <table border="1" style="width:100%; border-collapse:collapse; font-size:12pt;" cellspacing="0">
        <thead>
            <tr style="background-color:#ccc;">
                <th>ID</th>
                <th>Nome</th>
                <th>Cor</th>
                <th>Estoque</th>
                <th>Preço Unitário (R$)</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT p.idproduto, p.nome, p.cor, p.quantidade_estoque, p.preco_uni, t.tipo 
                    FROM produto p 
                    JOIN tipo_produto t ON p.idtipo_produto = t.idtipo_produto 
                    ORDER BY p.idproduto ASC";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['idproduto']}</td>
                        <td>{$row['nome']}</td>
                        <td>{$row['cor']}</td>
                        <td>{$row['quantidade_estoque']}</td>
                        <td>R$ " . number_format($row['preco_uni'], 2, ',', '.') . "</td>
                        <td>{$row['tipo']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</page>
