<?php

    //configurar a conexão
    $host = "localhost";
    $user = "root";
    $password = "Jovana2552";
    $database = "loja";

    //abrir a conexão
    $conn =  mysqli_connect($host,$user,$password,$database);

    //testar a conexão
    if(!$conn){
        die("Falha na conexão: ".mysqli_connect_error());
    }
?>