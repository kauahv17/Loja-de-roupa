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
        $_SESSION['msg'] = "cliente cadastrado com sucesso!";
        $_SESSION['origem'] = "cadastro_cliente.php";
        header("Location: ../paginas/cadastro_cliente.php");
        exit;
    } else {
        $_SESSION['msg'] = "Erro ao cadastrar cliente: " . mysqli_error($conn);
        $_SESSION['origem'] = "cadastro_cliente.php";
        header("Location: ../paginas/cadastro_cliente.php");
        exit;
    }

} else {
    echo "Preencha todos os campos!";
}
 
?>