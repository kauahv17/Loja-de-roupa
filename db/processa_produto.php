<?php
session_start();
include_once("conexao.php");

// Receber os dados do formulário
$nome = mysqli_real_escape_string($conn, $_POST['nome']);
$quantidade = (int) $_POST['quantidade'];
$preco = (float) $_POST['preco'];
$cor = mysqli_real_escape_string($conn, $_POST['cor']);
$tipo = (int) $_POST['tipo'];
$idtamanho = !empty($_POST['idtamanho']) ? (int) $_POST['idtamanho'] : null;
$preco_for = (float) $_POST['preco_for'];
$quantidade_for = (int) $_POST['quantidade_for'];
$idfornecedor = (int) $_POST['idfornecedor'];

// Inserir o produto na tabela produto
$dados_produto = "INSERT INTO produto (nome, quantidade_estoque, preco_uni, cor, idtamanho, idtipo_produto) 
                VALUES ('$nome', $quantidade, $preco, '$cor', " . ($idtamanho !== null ? $idtamanho : 'NULL') . ", $tipo)";

if (mysqli_query($conn, $dados_produto)) {
    // Pegar o id do produto recém-inserido
    $idproduto = mysqli_insert_id($conn);

    // Inserir na tabela produtos_fornecidos
    $dados_produtos_fornecidos = "INSERT INTO produtos_fornecidos (idfornecedor, idproduto, preco_for, quantidade) 
                      VALUES ($idfornecedor, $idproduto, $preco_for, $quantidade_for)";

    if (mysqli_query($conn, $dados_produtos_fornecidos)) {
        $_SESSION['msg'] = "Produto cadastrado com sucesso!";
        $_SESSION['origem'] = "cadastro_prod.php";
        header("Location: ../paginas/estoque.php");
        exit;
    } else {
        $_SESSION['msg'] = "Erro ao cadastrar produto: " . mysqli_error($conn);
        $_SESSION['origem'] = "cadastro_prod.php";
        header("Location: ../paginas/cadastro_prod.php");
        exit;
    }

} else {
    echo "Preencha todos os campos!";
}

?>
