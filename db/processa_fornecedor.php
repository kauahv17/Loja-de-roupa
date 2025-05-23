<?php
    //incluir a conexão com o BD
    include_once("./conexao.php");
    //recuperar os dados do formulário de Fornecedores
    $nome = $_POST['nome'];
    $cnpj = $_POST['cnpj'];
    //verificar se o fornecedor existe
    $sql_fornecedor = "SELECT * FROM fornecedor WHERE cnpj = '$cnpj'; ";
    $res = mysqli_query($conn, $sql_funcionario);

    if( mysqli_num_rows($res) === 0 ){//fornecedor não existe
        $row = mysqli_fetch_array($res);

        //criar o SQL que insere o usuário
        $dados_fornecedor = "INSERT INTO fornecedor(nome, cnpj) VALUES('$nome', '$cnpj');";
        $res = mysqli_query($conn, $dados_fornecedor);
        if( mysqli_affected_rows($conn) > 0 ){//Executou OK 
            //abrir a sessão
            session_start();
            $_SESSION['idfornecedor'] = $row['idfornecedor'];
            $_SESSION ['nome'] = $row['nome'];
            $_SESSION['cnpj'] = $row['cnpj'];


            if($res){//OK
                echo "<meta http-equiv='refresh' content='0;url=index.php'>
                <script type='text/javascript'>alert('Fornecedor cadastrado!');</script>";
            }else{//ERRO
                echo "<meta http-equiv='refresh' content='0;url=index.php'>
                <script type='text/javascript'>alert('Erro ao cadastrar o Fornecedor');</script>";
            }
        
            //Direcionamento para a página fornecedores 
            header("Location: ../paginas/fornecedores.php");
            
        }
    }else{//usuário existe
        echo "<meta http-equiv='refresh' content='0;url=index.php'>
            <script type='text/javascript'>alert('Esse fornecedor ja existe');</script>";
    }
?>