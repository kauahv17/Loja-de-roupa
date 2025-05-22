<?php
    session_start();
     if( isset($_SESSION['idusuario']) ){//logado
        //Ir para Home
        include_once("paginas/home.php");
    }else{//sem login
        //formulário de login
        include_once("paginas/login.php");
    }
?>