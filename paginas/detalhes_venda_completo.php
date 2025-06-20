<?php
header('Content-Type: application/json');
include_once '../db/conexao.php';

if (!isset($_GET['idpedido'], $_GET['idvenda'])) {
    echo json_encode(['error' => 'IDs não fornecidos.']);
    exit;
}

$idpedido = (int)$_GET['idpedido'];
$idvenda = (int)$_GET['idvenda'];
$response = [
    'venda' => [],
    'devolucao' => null
];

// 1. Buscar detalhes da venda original
$sql_venda = "SELECT 
                pp.quantidade,
                pp.preco_ped,
                pp.tamanho,
                p.nome AS produto
            FROM produto_pedido pp
            JOIN produto p ON pp.idproduto = p.idproduto
            WHERE pp.idpedido = ?";

$stmt_venda = mysqli_prepare($conn, $sql_venda);
mysqli_stmt_bind_param($stmt_venda, "i", $idpedido);
mysqli_stmt_execute($stmt_venda);
$result_venda = mysqli_stmt_get_result($stmt_venda);
$response['venda'] = mysqli_fetch_all($result_venda, MYSQLI_ASSOC);
mysqli_stmt_close($stmt_venda);

// 2. Buscar detalhes da devolução, se existir
$sql_devolucao = "SELECT 
                    d.data_devolucao,
                    d.motivo,
                    d.valor_total,
                    f.nome AS funcionario,
                    pd.quantidade,
                    pd.preco_dev,
                    pd.tamanho,
                    p.nome AS produto
                FROM devolucao d
                JOIN funcionario f ON d.idfuncionario = f.idfuncionario
                JOIN produto_devolucao pd ON d.iddevolucao = pd.iddevolucao
                JOIN produto p ON pd.idproduto = p.idproduto
                WHERE d.idvenda = ?";

$stmt_dev = mysqli_prepare($conn, $sql_devolucao);
mysqli_stmt_bind_param($stmt_dev, "i", $idvenda);
mysqli_stmt_execute($stmt_dev);
$result_dev = mysqli_stmt_get_result($stmt_dev);

if (mysqli_num_rows($result_dev) > 0) {
    $devolucao_itens = mysqli_fetch_all($result_dev, MYSQLI_ASSOC);
    $response['devolucao'] = [
        'info' => [
            'motivo' => htmlspecialchars($devolucao_itens[0]['motivo']),
            'data_devolucao' => $devolucao_itens[0]['data_devolucao'],
            'funcionario' => htmlspecialchars($devolucao_itens[0]['funcionario']),
            'valor_total' => $devolucao_itens[0]['valor_total']
        ],
        'itens' => []
    ];
    foreach($devolucao_itens as $item) {
        $response['devolucao']['itens'][] = [
            'produto' => htmlspecialchars($item['produto']),
            'quantidade' => $item['quantidade'],
            'tamanho' => htmlspecialchars($item['tamanho']),
            'preco_dev' => $item['preco_dev']
        ];
    }
}

mysqli_stmt_close($stmt_dev);
echo json_encode($response);
?> 