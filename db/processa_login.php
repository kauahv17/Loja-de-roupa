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
        $senha_bd = $row[4];
        $idfuncionario = $row[0];
        $cargo = $row[5];
       

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
            
            if ($cargo === 'gerente') {
                //****Direcionamento para a página home do gerente OBS: Adicionar as páginas de menu gerente 
               header("Location: ../paginas/home.php");
            } else {
                //****Direcionamento para a página home do funcionário OBS: Adicionar as páginas de menu funcionário 
                header("Location: ../paginas/home.php");
            }

        }else{//ERRO - Senha incorreta
            echo "<meta http-equiv='refresh' content='0;url=index.php'>
            <script type='text/javascript'>alert('Senha incorreta!');</script>";
        }

    }else{//usuário não existe - ERRO
        echo "<meta http-equiv='refresh' content='0;url=index.php'>
            <script type='text/javascript'>alert('Usuário não encontrado!!!');</script>";
    }

?>