<?php
include_once '../db/conexao.php';

$idpedido = isset($_GET['idpedido']) ? (int) $_GET['idpedido'] : 0;

if($idpedido > 0){
    $sql = "SELECT 
        pr.nome AS produto,
        pp.quantidade,
        pp.tamanho,
        pp.preco_ped
    FROM produto_pedido pp
    JOIN produto pr ON pp.idproduto = pr.idproduto
    WHERE pp.idpedido = $idpedido";

    $result = mysqli_query($conn, $sql);
    $produtos = [];

    while($row = mysqli_fetch_assoc($result)){
        $produtos[] = [
            'produto' => $row['produto'],
            'quantidade' => (int)$row['quantidade'],
            'tamanho' => $row['tamanho'],
            'preco_ped' => (float)$row['preco_ped']
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($produtos);
    exit;
}
echo json_encode([]);
?>
