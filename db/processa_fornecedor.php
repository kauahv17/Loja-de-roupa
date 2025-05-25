<?php
session_start();
include_once("./conexao.php");

if (isset($_POST['nome'], $_POST['cnpj'])) {
    
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cnpj = mysqli_real_escape_string($conn, $_POST['cnpj']);
    
    $dados_fornecedor = "INSERT INTO fornecedor(nome, cnpj) 
        VALUES ('$nome', '$cnpj')";

    if (mysqli_query($conn, $dados_fornecedor)) {
        $_SESSION['msg'] = "Fornecedor cadastrado com sucesso!";
        $_SESSION['origem'] = "cadastro_forn.php";
        header("Location: ../paginas/fornecedores.php");
        exit;
    } else {
        $_SESSION['msg'] = "Erro ao cadastrar fornecedor: " . mysqli_error($conn);
        $_SESSION['origem'] = "cadastro_forn.php";
        header("Location: ../paginas/cadastro_forn.php");
        exit;
    }

} else {
    echo "Preencha todos os campos!";
}
 
?>