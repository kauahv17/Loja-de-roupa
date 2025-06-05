<?php
session_start();
include_once("./conexao.php");

if (isset($_POST['nome'], $_POST['cnpj'])) {
    
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cnpj = mysqli_real_escape_string($conn, $_POST['cnpj']);
    
    $dados_fornecedor = "INSERT INTO fornecedor(nome, cnpj) 
        VALUES ('$nome', '$cnpj')";

    if (mysqli_query($conn, $dados_fornecedor)) {
        echo "<meta http-equiv='refresh' content='0;url=../paginas/fornecedores.php'>
            <script type='text/javascript'>alert('Fornecedor cadastrado com sucesso! ');</script>";
        exit;
    } else {
        echo "<meta http-equiv='refresh' content='0;url=../paginas/fornecedores.php'>
            <script type='text/javascript'>alert('Erro ao cadastrar fornecedor: ');</script>";
        exit;
    }

} else {
    echo "Preencha todos os campos!";
}
 
?>