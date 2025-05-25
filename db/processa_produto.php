<?php
include 'conexao.php';

if (isset($_POST['nome'], $_POST['quantidade'], $_POST['preco'], $_POST['cor'], $_POST['tipo'], $_POST['idfornecedor'], $_POST['data_fornecimento'], $_POST['preco_for'], $_POST['quantidade_for'])) {

    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $quantidade = intval($_POST['quantidade']);
    $preco = floatval($_POST['preco']);
    $cor = mysqli_real_escape_string($conn, $_POST['cor']);
    $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
    $idfornecedor = intval($_POST['idfornecedor']);
    $data_fornecimento = $_POST['data_fornecimento'];
    $preco_for = floatval($_POST['preco_for']);
    $quantidade_for = intval($_POST['quantidade_for']);

    // 1 - Verificar se tipo existe
    $check_tipo = "SELECT idtipo_produto FROM tipo_produto WHERE tipo = '$tipo'";
    $resTipo = mysqli_query($conn, $check_tipo);
    if (mysqli_num_rows($resTipo) > 0) {
        $rowTipo = mysqli_fetch_assoc($resTipo);
        $idtipo_produto = $rowTipo['idtipo_produto'];
    } else {
        $dados_tipo = "INSERT INTO tipo_produto (tipo) VALUES ('$tipo')";
        mysqli_query($conn, $dados_tipo);
        $idtipo_produto = mysqli_insert_id($conn);
    }

    // 2 - Inserir produto
    $dados_produto = "INSERT INTO produto (nome, quantidade_estoque, preco_uni, cor, idtipo_produto) VALUES ('$nome', $quantidade, $preco, '$cor', $idtipo_produto)";
    mysqli_query($conn, $dados_produto);
    $idproduto = mysqli_insert_id($conn);

    // 3 - Inserir na tabela produtos_fornecidos
    $dados_produtos_fornecidos = "INSERT INTO produtos_fornecidos (idfornecedor, idproduto, data_fornecimento, preco_for, quantidade) 
              VALUES ($idfornecedor, $idproduto, '$data_fornecimento', $preco_for, $quantidade_for)";
    if (mysqli_query($conn, $dados_produtos_fornecidos)) {
        $_SESSION['msg'] = "Produto cadastrado no estoque com sucesso!";
        $_SESSION['origem'] = "cadastro_prod.php";
        header("Location: ../paginas/estoque.php");
        exit;
    } else {
        $_SESSION['msg'] = "Erro ao cadastrar produto: " . mysqli_error($conn);
        $_SESSION['origem'] = "cadastro_prod.php";
        header("Location: ../paginas/cadastro_prod.php");
        exit;
    }

} else {
    echo "Preencha todos os campos!";
}

?>
