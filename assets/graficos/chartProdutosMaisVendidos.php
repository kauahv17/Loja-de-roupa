<?php
include '../../db/conexao.php';

$sql = "SELECT p.nome AS produto, SUM(pp.quantidade) AS total_vendido
        FROM produto_pedido pp
        JOIN produto p ON pp.idproduto = p.idproduto
        GROUP BY pp.idproduto
        ORDER BY total_vendido DESC
        LIMIT 10";

$result = $conn->query($sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
$conn->close();

header("Content-type: application/json");
echo json_encode(['data' => $rows]);
?>
