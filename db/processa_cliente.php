<?php
session_start();
include_once("./conexao.php");

if (isset($_POST['nome'], $_POST['cpf'], $_POST['telefone'])) {
    
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cpf = mysqli_real_escape_string($conn, $_POST['cpf']);
    $telefone = mysqli_real_escape_string($conn, $_POST['telefone']);
    
    $dados_cliente = "INSERT INTO cliente(nome, cpf, telefone) 
        VALUES ('$nome', '$cpf', '$telefone')";

    if (mysqli_query($conn, $dados_cliente)) {
        echo "<meta http-equiv='refresh' content='0;url=../paginas/carrinho.php'>
            <script type='text/javascript'>alert('cliente cadastrado com sucesso! ');</script>";
        exit;
    } else {
        echo "<meta http-equiv='refresh' content='0;url=../paginas/carrinho.php'>
            <script type='text/javascript'>alert('Erro ao cadastrar cliente: ');</script>";
        exit;
    }

} else {
    echo "Preencha todos os campos!";
}
 
?>