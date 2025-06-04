<?php
    session_start();
    if( !isset($_SESSION['idfuncionario']) ){
        header("location: ../index.php");
    }

    //abrir conexão com BD
    include_once("./conexao.php");
    //Recuperar os dados 
    $idfuncionario = $_GET['id'];
    //Código SQL
    $sql = "UPDATE funcionario 
            SET cargo = 'apagado'
            WHERE idfuncionario = $idfuncionario;";
    //Exercutar Código SQL
    $res = mysqli_query($conn, $sql);
    if( mysqli_affected_rows($conn) == 1 ){//OK
        echo "<meta http-equiv='refresh' content='0;url=../paginas/funcionarios.php'>
            <script type='text/javascript'>alert('funcionario apagado!');</script>";
    }else{//ERRO
        echo "<meta http-equiv='refresh' content='0;url=../paginas/funcionarios.php'>
            <script type='text/javascript'>alert('ERRO - funcionario não apagado!');</script>";
    }

?>