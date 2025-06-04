<?php
    session_start();
    if( !isset($_SESSION['idfuncionario']) ){
        header("location: ../index.php");
    }
    //abrir conexão com BD
    include_once("./conexao.php");
    //Recuperar os dados do formulários
    $idfuncionario = $_POST['idfuncionario'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $cargo = $_POST['cargo'];
    $senha = $_POST['senha'];

    $senha_criptografada = sha1("{$senha}{$email}");
    //Código SQL
    $sql = "UPDATE funcionario 
            SET nome = '$nome', cpf = '$cpf', email = '$email', senha = '$senha_criptografada', cargo = '$cargo'
            WHERE idfuncionario = $idfuncionario;";
    //Exercutar Código SQL
    $res = mysqli_query($conn, $sql);
    if( mysqli_affected_rows($conn) == 1 ){//OK
        echo "<meta http-equiv='refresh' content='0;url=../paginas/funcionarios.php'>
            <script type='text/javascript'>alert('funcionario alterado!');</script>";
    }else{//ERRO
        echo "<meta http-equiv='refresh' content='0;url=../paginas/funcionarios.php'>
            <script type='text/javascript'>alert('ERRO - funcionario não alterado!');</script>";
    }

?>