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
        $_SESSION['msg'] = "Funcionário cadastrado com sucesso!";
        $_SESSION['origem'] = "cadastro_func.php";
        header("Location: ../paginas/funcionarios.php");
        exit;
    } else {
        $_SESSION['msg'] = "Erro ao cadastrar funcionário: " . mysqli_error($conn);
        $_SESSION['origem'] = "cadastro_func.php";
        header("Location: ../paginas/cadastro_func.php");
        exit;
    }

} else {
    echo "Preencha todos os campos!";
}
 
?>