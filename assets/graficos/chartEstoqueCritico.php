<?php
include '../../db/conexao.php';

$sql = "SELECT nome AS produto, quantidade_estoque AS quantidade
        FROM produto
        WHERE quantidade_estoque <= 10
        ORDER BY quantidade_estoque ASC;";

$result = $conn->query($sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
$conn->close();

header("Content-type: application/json");
echo json_encode(['data' => $rows]);
?>
