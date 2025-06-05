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

// Inserir o produto na tabela produto
$dados_produto = "INSERT INTO produto (nome, quantidade_estoque, preco_uni, cor, idtipo_produto) 
                VALUES ('$nome', $quantidade_for, $preco, '$cor', $tipo)";

if (mysqli_query($conn, $dados_produto)) {
    // Pegar o id do produto recém-inserido
    $idproduto = mysqli_insert_id($conn);

    // Inserir na tabela produtos_fornecidos
    $dados_produtos_fornecidos = "INSERT INTO produtos_fornecidos (idfornecedor, idproduto, preco_for, quantidade) 
                      VALUES ($idfornecedor, $idproduto, $preco_for, $quantidade_for)";

    if (mysqli_query($conn, $dados_produtos_fornecidos)) {
         echo "<meta http-equiv='refresh' content='0;url=../paginas/estoque.php'>
            <script type='text/javascript'>alert('Produto cadastrado com sucesso!');</script>";
        exit;
    } else {
        echo "<meta http-equiv='refresh' content='0;url=../paginas/estoque.php'>
            <script type='text/javascript'>alert('Erro ao cadastrar produto: ');</script>";
        exit;
    }

} else {
    echo "Preencha todos os campos!";
}

?>
