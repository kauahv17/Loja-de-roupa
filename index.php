<?php
    session_start();
     if( isset($_SESSION['idusuario']) ){//logado
        //Ir para Home
        include_once("./home.php");
    }else{//sem login
        //formulário de login
        include_once("paginas/login.php");
    }
?>