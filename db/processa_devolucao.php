<?php
session_start();
include_once("conexao.php");

if (!isset($_SESSION['idfuncionario'])) {
    header("location: ../index.php");
    exit;
}

if (!isset($_POST['idvenda'], $_POST['motivo'], $_POST['produtos'])) {
    echo "<script>alert('Dados incompletos!'); window.location.href='../paginas/devolucao.php';</script>";
    exit;
}

$idvenda = (int)$_POST['idvenda'];
$motivo = mysqli_real_escape_string($conn, $_POST['motivo']);
$idfuncionario = $_SESSION['idfuncionario'];
$produtos = $_POST['produtos'];

mysqli_begin_transaction($conn);

try {
    // 1. Calcular o valor total da devolução
    $valor_total_devolucao = 0;
    foreach ($produtos as $idproduto) {
        $qtd_devolucao = (int)$_POST["qtd_devolucao_$idproduto"];
        $sql_preco = "SELECT pp.preco_ped 
                      FROM venda v 
                      JOIN pedido p ON v.idpedido = p.idpedido 
                      JOIN produto_pedido pp ON p.idpedido = pp.idpedido 
                      WHERE v.idvenda = ? AND pp.idproduto = ?";
        
        $stmt = mysqli_prepare($conn, $sql_preco);
        mysqli_stmt_bind_param($stmt, "ii", $idvenda, $idproduto);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        
        $valor_total_devolucao += $row['preco_ped'] * $qtd_devolucao;
        mysqli_stmt_close($stmt);
    }

    // 2. Criar registro na tabela devolucao
    $sql_devolucao = "INSERT INTO devolucao (idvenda, motivo, valor_total, idfuncionario) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql_devolucao);
    mysqli_stmt_bind_param($stmt, "isdi", $idvenda, $motivo, $valor_total_devolucao, $idfuncionario);
    mysqli_stmt_execute($stmt);
    $iddevolucao = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    // 3. Registrar produtos devolvidos e atualizar estoque
    foreach ($produtos as $idproduto) {
        $qtd_devolucao = (int)$_POST["qtd_devolucao_$idproduto"];
        $tamanho = isset($_POST["tamanho_$idproduto"]) ? $_POST["tamanho_$idproduto"] : null;
        
        // Buscar preço do produto na venda original
        $sql_preco = "SELECT pp.preco_ped 
                      FROM venda v 
                      JOIN pedido p ON v.idpedido = p.idpedido 
                      JOIN produto_pedido pp ON p.idpedido = pp.idpedido 
                      WHERE v.idvenda = ? AND pp.idproduto = ?";
        
        $stmt = mysqli_prepare($conn, $sql_preco);
        mysqli_stmt_bind_param($stmt, "ii", $idvenda, $idproduto);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $preco_dev = $row['preco_ped'];
        mysqli_stmt_close($stmt);

        // Registrar produto devolvido
        $sql_produto_dev = "INSERT INTO produto_devolucao (iddevolucao, idproduto, quantidade, preco_dev, tamanho) 
                           VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_produto_dev);
        mysqli_stmt_bind_param($stmt, "iiids", $iddevolucao, $idproduto, $qtd_devolucao, $preco_dev, $tamanho);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Atualizar estoque
        $sql_update_estoque = "UPDATE produto SET quantidade_estoque = quantidade_estoque + ? WHERE idproduto = ?";
        $stmt = mysqli_prepare($conn, $sql_update_estoque);
        mysqli_stmt_bind_param($stmt, "ii", $qtd_devolucao, $idproduto);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    mysqli_commit($conn);
    echo "<script>alert('Devolução processada com sucesso!'); window.location.href='../paginas/devolucao.php';</script>";

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Erro ao processar devolução: " . htmlspecialchars($e->getMessage()) . "'); window.location.href='../paginas/devolucao.php';</script>";
}
?> 