<?php
include 'conexao.php';  
$sql = "SELECT tp.tipo AS descricao, SUM(p.quantidade_estoque) AS total 
        FROM produto p 
        JOIN tipo_produto tp ON p.idtipo_produto = tp.idtipo_produto
        GROUP BY tp.idtipo_produto";

$result = $conn->query($sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
$conn->close();

header("Content-type: application/json");
echo json_encode(['data' => $rows]);
?>
