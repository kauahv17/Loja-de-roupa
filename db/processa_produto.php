<?php
session_start();
include_once("conexao.php");

// Receber os dados do formulário
$nome = mysqli_real_escape_string($conn, $_POST['nome']);
//$quantidade = (int) $_POST['quantidade'];
$preco = (float) $_POST['preco'];
$cor = mysqli_real_escape_string($conn, $_POST['cor']);
$tipo = (int) $_POST['tipo'];
$preco_for = (float) $_POST['preco_for'];
$quantidade_for = (int) $_POST['quantidade_for'];
$idfornecedor = (int) $_POST['idfornecedor'];

// --- Nova lógica: Verificar se o produto já existe ---
$sql_check_produto = "SELECT idproduto, quantidade_estoque FROM produto WHERE nome = '$nome' AND cor = '$cor' AND idtipo_produto = $tipo";
$result_check_produto = mysqli_query($conn, $sql_check_produto);

if ($result_check_produto && mysqli_num_rows($result_check_produto) > 0) {
    // Produto existente: Reabastecer estoque
    $produto_existente = mysqli_fetch_assoc($result_check_produto);
    $idproduto_existente = $produto_existente['idproduto'];
    $quantidade_estoque_atual = $produto_existente['quantidade_estoque'];
    $nova_quantidade_estoque = $quantidade_estoque_atual + $quantidade_for;

    mysqli_begin_transaction($conn);
    try {
        // 1. Atualizar a quantidade_estoque do produto existente
        $sql_update_estoque = "UPDATE produto SET quantidade_estoque = $nova_quantidade_estoque, preco_uni = $preco WHERE idproduto = $idproduto_existente";
        if (!mysqli_query($conn, $sql_update_estoque)) {
            throw new Exception("Erro ao reabastecer estoque do produto.");
        }

        // 2. Inserir nova entrada em produtos_fornecidos para registrar o reabastecimento
        $sql_produtos_fornecidos = "INSERT INTO produtos_fornecidos (idfornecedor, idproduto, preco_for, quantidade) VALUES ($idfornecedor, $idproduto_existente, $preco_for, $quantidade_for)";
        if (!mysqli_query($conn, $sql_produtos_fornecidos)) {
            throw new Exception("Erro ao registrar reabastecimento do produto fornecido.");
        }

        mysqli_commit($conn);
        echo "<script type='text/javascript'>alert('Estoque do produto reabastecido com sucesso!'); window.location.href='../paginas/estoque.php';</script>";
        exit;

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script type='text/javascript'>alert('Erro ao reabastecer produto: " . htmlspecialchars($e->getMessage()) . "'); window.location.href='../paginas/estoque.php';</script>";
        exit;
    }

} else {
    // Produto não existe: Cadastrar como novo produto
    mysqli_begin_transaction($conn);
    try {
        // 1. Inserir o novo produto na tabela produto
        $sql_novo_produto = "INSERT INTO produto (nome, quantidade_estoque, preco_uni, cor, idtipo_produto) VALUES ('$nome', $quantidade_for, $preco, '$cor', $tipo)";
        if (!mysqli_query($conn, $sql_novo_produto)) {
            throw new Exception("Erro ao cadastrar novo produto.");
        }
        $idnovo_produto = mysqli_insert_id($conn);

        // 2. Inserir na tabela produtos_fornecidos
        $sql_novo_produtos_fornecidos = "INSERT INTO produtos_fornecidos (idfornecedor, idproduto, preco_for, quantidade) VALUES ($idfornecedor, $idnovo_produto, $preco_for, $quantidade_for)";
        if (!mysqli_query($conn, $sql_novo_produtos_fornecidos)) {
            throw new Exception("Erro ao registrar novo produto fornecido.");
        }

        mysqli_commit($conn);
        echo "<script type='text/javascript'>alert('Produto cadastrado com sucesso!'); window.location.href='../paginas/estoque.php';</script>";
        exit;

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script type='text/javascript'>alert('Erro ao cadastrar novo produto: " . htmlspecialchars($e->getMessage()) . "'); window.location.href='../paginas/estoque.php';</script>";
        exit;
    }
}

// Se por algum motivo o script continuar (não deveria), exibe mensagem genérica
echo "<script type='text/javascript'>alert('Erro desconhecido ao processar produto.'); window.location.href='../paginas/estoque.php';</script>";
exit;

?>
