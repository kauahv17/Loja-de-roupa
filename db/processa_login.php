<?php

    //incluir a conexão com o BD
    include_once("./conexao.php");
    //recuperar os dados do formulário de Login
    $email = $_POST['email'];
    //verificar se o usuário existe
    $sql_funcionario = "SELECT * FROM funcionario 
                    WHERE email = '$email'; ";
    $res = mysqli_query($conn, $sql_funcionario);
    $idfuncionario="";
    $cargo="";
    $nome="";

    if( mysqli_num_rows($res) > 0 ){//usuário existe
        //criptografia da senha digitada
        $senha_formulario = sha1("{$_POST['senha']}{$_POST['email']}");
        //recuperação da senha do banco de dados
        $row = mysqli_fetch_array($res);
        $senha_bd = $row[5];
        $idfuncionario = $row[0];
        //testar se as senhas são iguais
        if($senha_formulario == $senha_bd){//senha OK
            //autenticar o usuário
            //echo "Usuário OK";
            //abrir a sessão
            session_start();
            //registrar o id do usuário logado
            $_SESSION['idfuncionario'] = $idfuncionario;
            $_SESSION ['cargo'] = $cargo;
            $_SESSION['nome'] = $nome;
            if($cargo == 0){
                
                echo "<meta http-equiv='refresh' content='0;url=menu_gerente.php'>
            <script type='text/javascript'>alert('Bem-vindo $nome!');</script>";
            } else {
                echo "<meta http-equiv='refresh' content='0;url=menu_funcionario.php'>
            <script type='text/javascript'>alert('Bem-vindo $nome!');</script>";
            }
            
        }else{//ERRO - Senha incorreta
            echo "<meta http-equiv='refresh' content='0;url=index.php'>
            <script type='text/javascript'>alert('Senha incorreta!');</script>";
        }

    }else{//usuário não existe - ERRO
        echo "<meta http-equiv='refresh' content='0;url=index.php'>
            <script type='text/javascript'>alert('Usuário não encontrado!');</script>";
    }

?>