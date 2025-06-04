<?php
include 'conexao.php';

$sql = "SELECT f.nome AS funcionario, SUM(p.valor_total) AS total_vendas
        FROM pedido p
        JOIN funcionario f ON p.idfuncionario = f.idfuncionario
        JOIN venda v ON v.idpedido = p.idpedido
        GROUP BY f.idfuncionario";

$result = $conn->query($sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
$conn->close();

header("Content-type: application/json");
echo json_encode(['data' => $rows]);
?>
