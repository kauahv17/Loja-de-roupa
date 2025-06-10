<?php
session_start();
include_once("./conexao.php");


if (isset($_POST['nome'], $_POST['cpf'], $_POST['email'], $_POST['senha'], $_POST['cargo'])) {

    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cpf = mysqli_real_escape_string($conn, $_POST['cpf']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $cargo = mysqli_real_escape_string($conn, $_POST['cargo']);
    $senha = $_POST['senha'];

    // Criptografar senha 
    $senha_criptografada = sha1("{$senha}{$email}");
    
    $dados_funcionario = "INSERT INTO funcionario(nome, cpf, email, senha, cargo) 
        VALUES ('$nome', '$cpf', '$email', '$senha_criptografada', '$cargo')";

    if (mysqli_query($conn, $dados_funcionario)) {
        echo "<meta http-equiv='refresh' content='0;url=../paginas/funcionarios.php'>
            <script type='text/javascript'>alert('Funcionário cadastrado com sucesso!');</script>";
        exit;
    } else {
        echo "<meta http-equiv='refresh' content='0;url=../paginas/funcionarios.php'>
            <script type='text/javascript'>alert('Erro ao cadastrar funcionário: ');</script>";
        exit;
    }

} else {
    echo "Preencha todos os campos!";
}
 
?>