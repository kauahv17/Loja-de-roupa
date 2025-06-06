<?php
include 'conexao.php';

$sql = "SELECT DATE(data_venda) AS dia, COUNT(*) AS total_vendas 
        FROM venda 
        GROUP BY dia 
        ORDER BY dia";

$result = $conn->query($sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
$conn->close();

header("Content-type: application/json");
echo json_encode(['data' => $rows]);
?>
