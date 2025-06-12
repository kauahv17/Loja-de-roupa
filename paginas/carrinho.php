<?php
    session_start();
    include_once("../db/conexao.php");

    // Processar alteração de quantidade
    if (isset($_POST['alterar_quantidade'])) {
        $produto_id = $_POST['idproduto'];
        $nova_quantidade = $_POST['quantidade'];
        $tamanho = $_POST['tamanho'] ?? null;

        foreach ($_SESSION['carrinho'] as $key => $item) {
            if (isset($item['produto_id'], $item['tamanho']) && $item['produto_id'] == $produto_id && $item['tamanho'] == $tamanho) {
                if ($nova_quantidade <= 0) {
                    unset($_SESSION['carrinho'][$key]);
                    $_SESSION['carrinho'] = array_values($_SESSION['carrinho']); // Reindexa o array
                } else {
                    $_SESSION['carrinho'][$key]['quantidade'] = $nova_quantidade;
                }
                break;
            }
        }
        header('Location: carrinho.php');
        exit;
    }

    // Processar remoção de item
    if (isset($_POST['remover_item'])) {
        $produto_id = $_POST['idproduto'];
        $tamanho = $_POST['tamanho'] ?? null;

        foreach ($_SESSION['carrinho'] as $key => $item) {
            if (isset($item['produto_id'], $item['tamanho']) && $item['produto_id'] == $produto_id && $item['tamanho'] == $tamanho) {
                unset($_SESSION['carrinho'][$key]);
                $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
                break;
            }
        }
        header('Location: carrinho.php');
        exit;
    }

    // Processar finalização da compra
    if (isset($_POST['finalizar_compra'])) {
        if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
            echo "<script>alert('O carrinho está vazio! Adicione produtos antes de finalizar a compra.'); window.location.href='carrinho.php';</script>";
            exit;
        }

        $idcliente = $_POST['idcliente'];
        // Verifica se um cliente foi selecionado
        if (empty($idcliente)) {
            echo "<script>alert('Por favor, selecione um cliente para finalizar a compra.'); window.location.href='carrinho.php';</script>";
            exit;
        }
        $idfuncionario = $_SESSION['idfuncionario'] ?? null; // Assuming this is set in session

        if (!$idfuncionario) {
             echo "<script>alert('Erro: ID do funcionário não encontrado na sessão.'); window.location.href='index.php';</script>";
             exit;
        }

        // Recalcular total e quantidade total a partir da sessão para evitar adulteração
        $valor_total_pedido = 0;
        $quantidade_total_pedido = 0;
        foreach ($_SESSION['carrinho'] as $item) {
            $produto_id = $item['produto_id'];
            $quantidade = $item['quantidade'];

            $sql_prod = "SELECT preco_uni FROM produto WHERE idproduto = ?";
            $stmt_prod = mysqli_prepare($conn, $sql_prod);
            mysqli_stmt_bind_param($stmt_prod, "i", $produto_id);
            mysqli_stmt_execute($stmt_prod);
            $result_prod = mysqli_stmt_get_result($stmt_prod);
            $produto_info = mysqli_fetch_assoc($result_prod);
            mysqli_stmt_close($stmt_prod);


            if ($produto_info) {
                $valor_total_pedido += $produto_info['preco_uni'] * $quantidade;
                $quantidade_total_pedido += $quantidade;
            } else {
                 echo "<script>alert('Erro: Produto no carrinho não encontrado no banco de dados.'); window.location.href='carrinho.php';</script>";
                 exit;
            }
        }

        mysqli_begin_transaction($conn);

        try {
            // 1. Inserir na tabela 'pedido'
            $sql_pedido = "INSERT INTO pedido (valor_total, quantidade, idfuncionario, idcliente) VALUES (?, ?, ?, ?)";
            $stmt_pedido = mysqli_prepare($conn, $sql_pedido);
            mysqli_stmt_bind_param($stmt_pedido, "diis", $valor_total_pedido, $quantidade_total_pedido, $idfuncionario, $idcliente);
            mysqli_stmt_execute($stmt_pedido);
            $idpedido = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt_pedido);

            if (!$idpedido) {
                throw new Exception("Erro ao inserir pedido.");
            }

            // 2. Inserir na tabela 'produto_pedido' e atualizar estoque
            foreach ($_SESSION['carrinho'] as $item) {
                $produto_id = $item['produto_id'];
                $quantidade = $item['quantidade'];
                $tamanho = $item['tamanho'] ?? null;

                // Obter preco_uni do produto para preco_ped
                $sql_get_preco = "SELECT preco_uni, quantidade_estoque FROM produto WHERE idproduto = ?";
                $stmt_get_preco = mysqli_prepare($conn, $sql_get_preco);
                mysqli_stmt_bind_param($stmt_get_preco, "i", $produto_id);
                mysqli_stmt_execute($stmt_get_preco);
                $result_get_preco = mysqli_stmt_get_result($stmt_get_preco);
                $produto_data = mysqli_fetch_assoc($result_get_preco);
                $preco_ped = $produto_data['preco_uni'];
                $estoque_atual = $produto_data['quantidade_estoque'];
                mysqli_stmt_close($stmt_get_preco);

                if ($estoque_atual < $quantidade) {
                    throw new Exception("Estoque insuficiente para o produto " . $produto['nome'] . " (ID: " . $produto_id . "). Estoque atual: " . $estoque_atual . ", quantidade solicitada: " . $quantidade);
                }

                // Inserir em produto_pedido
                $sql_produto_pedido = "INSERT INTO produto_pedido (idpedido, idproduto, quantidade, preco_ped, tamanho) VALUES (?, ?, ?, ?, ?)";
                $stmt_produto_pedido = mysqli_prepare($conn, $sql_produto_pedido);
                mysqli_stmt_bind_param($stmt_produto_pedido, "iiids", $idpedido, $produto_id, $quantidade, $preco_ped, $tamanho);
                mysqli_stmt_execute($stmt_produto_pedido);
                if (mysqli_stmt_affected_rows($stmt_produto_pedido) <= 0) {
                    throw new Exception("Erro ao inserir produto no pedido.");
                }
                mysqli_stmt_close($stmt_produto_pedido);

                // Atualizar estoque
                $sql_update_estoque = "UPDATE produto SET quantidade_estoque = quantidade_estoque - ? WHERE idproduto = ?";
                $stmt_update_estoque = mysqli_prepare($conn, $sql_update_estoque);
                mysqli_stmt_bind_param($stmt_update_estoque, "ii", $quantidade, $produto_id);
                mysqli_stmt_execute($stmt_update_estoque);
                if (mysqli_stmt_affected_rows($stmt_update_estoque) <= 0) {
                    throw new Exception("Erro ao atualizar estoque.");
                }
                mysqli_stmt_close($stmt_update_estoque);
            }

            // 3. Inserir na tabela 'venda'
            $sql_venda = "INSERT INTO venda (idpedido) VALUES (?)";
            $stmt_venda = mysqli_prepare($conn, $sql_venda);
            mysqli_stmt_bind_param($stmt_venda, "i", $idpedido);
            mysqli_stmt_execute($stmt_venda);
            if (mysqli_stmt_affected_rows($stmt_venda) <= 0) {
                throw new Exception("Erro ao inserir venda.");
            }
            mysqli_stmt_close($stmt_venda);

            mysqli_commit($conn);
            unset($_SESSION['carrinho']); // Limpar carrinho após a compra
            echo "<script>alert('Venda finalizada com sucesso!'); window.location.href='vendas.php';</script>";
            exit;

        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo "<script>alert('Erro ao finalizar venda: " . $e->getMessage() . "'); window.location.href='carrinho.php';</script>";
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="icon" type="image/png" href="../assets/img/logo_ME.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/carrinhoStyle.css">
    <link rel="stylesheet" href="../assets/css/sidebarStyle.css">

</head>
<body>
    <div class="settings-icon left">
            <a href="vendas.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
        </div>
        <div class="settings-icon right">
            <div class="settings-icone" onclick="toggleSidebar()">
                <img src="../assets/img/gear.svg" alt="Configurações" style="cursor: pointer;">
                <div class="sidebar" id="sidebar">
                    <h2>Configurações</h2>
                    <h4><strong>Nome:</strong> <?php echo $_SESSION['nome']; ?></h4>
                    <h4><strong>ID:</strong> <?php echo $_SESSION['idfuncionario']; ?></h4><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    <a href="../index.php">
                        <img src="../assets/img/sair.svg" alt="Sair"> 
                    </a>
                </div>
            </div>
        </div>
        <div class="carrinho-container">
            <div class="carrinho-header">
                <div class="h1-right">Carrinho</div>
            </div>
            <div class="carrinho-lista">
                <?php
                $total = 0;
                if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
                    foreach ($_SESSION['carrinho'] as $item) {
                        // Só processa se o item for válido
                        if (!isset($item['produto_id']) || empty($item['produto_id'])) {
                            continue;
                        }
                        $produto_id = $item['produto_id'];
                        $quantidade = $item['quantidade'];
                        $tamanho = isset($item['tamanho']) ? $item['tamanho'] : '';

                        // Buscar informações do produto
                        $sql = "SELECT p.*, tp.tipo 
                               FROM produto p 
                               JOIN tipo_produto tp ON p.idtipo_produto = tp.idtipo_produto 
                               WHERE p.idproduto = $produto_id";
                        $result = mysqli_query($conn, $sql);
                        $produto = mysqli_fetch_assoc($result);

                        if ($produto) {
                            $subtotal = $produto['preco_uni'] * $quantidade;
                            $total += $subtotal;
                ?>
                <div class="carrinho-card">
                    <div class="carrinho-card-img">
                        <img src="../assets/img/prod_img.svg" alt="Produto">
                    </div>
                    <div class="carrinho-card-group">
                        <div class="carrinho-card-info">
                                <span class="carrinho-card-title"><?php echo $produto['nome'] . ' ' . $produto['cor']; ?></span>
                                <span class="carrinho-card-price">R$ <?php echo number_format($produto['preco_uni'], 2, ',', '.'); ?></span>
                        </div>
                        <div class="carrinho-card-var">
                                <span class="carrinho-card-sum">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span>
                                <?php if($produto['tipo'] != 'óculos'): ?>
                                    <span class="tamanho">Tamanho: <?php echo $tamanho !== '' ? $tamanho : 'Não informado'; ?></span>
                                <?php endif; ?>
                        </div>
                    </div>
                    <div class="carrinho-card-img-trash">
                            <form method="POST" style="margin: 0;">
                                <input type="hidden" name="idproduto" value="<?php echo $produto_id; ?>">
                                <input type="hidden" name="tamanho" value="<?php echo $tamanho; ?>">
                                <button type="submit" name="remover_item" style="background: none; border: none; cursor: pointer;">
                                    <img src="../assets/img/lixeira.svg" alt="Remover">
                                </button>
                            </form>
                    </div>
                    <div class="carrinho-card-qntd-group">
                        <form method="POST">
                                <input type="hidden" name="idproduto" value="<?php echo $produto_id; ?>">
                            <input type="hidden" name="tamanho" value="<?php echo $tamanho; ?>">
                                <input type="hidden" name="quantidade" value="<?php echo $quantidade - 1; ?>">
                            <button type="submit" name="alterar_quantidade">-</button>
                        </form>
                            <span class="quantidade"><?php echo $quantidade; ?></span>
                        <form method="POST">
                                <input type="hidden" name="idproduto" value="<?php echo $produto_id; ?>">
                            <input type="hidden" name="tamanho" value="<?php echo $tamanho; ?>">
                                <input type="hidden" name="quantidade" value="<?php echo $quantidade + 1; ?>">
                            <button type="submit" name="alterar_quantidade">+</button>
                        </form>
                    </div>
                </div>
                <?php
                        }
                    }
                } else {
                    echo "<p style='text-align: center;'>Nenhum produto selecionado.</p>";
                }
                ?>
            </div>

            <div class="carrinho-header">
                <div class="h1-right">Cliente</div>
            </div>
            <form method="POST" action="carrinho.php">
                <div class="carrinho-busca-group">
                    <select class="carrinho-select" name="idcliente" required>
                        <option value="">Selecione o cliente</option>
                        <?php
                            $sql = "SELECT idcliente, cpf, nome FROM cliente ORDER BY cpf ASC";
                            $result = mysqli_query($conn, $sql);
                            if($result){
                                while($row = mysqli_fetch_assoc($result)){
                                    $clienteDisplay = $row['cpf'] . ' - ' . $row['nome'];
                                    echo "<option value='{$row['idcliente']}'>{$clienteDisplay}</option>";
                                }
                            } else {
                                echo "<option value=''>Erro ao carregar clientes</option>";
                            }
                        ?>
                    </select>
                </div>
                <a href="cadastro_cliente.php"><button type="button" class="carrinho-button">Cadastrar Cliente</button></a>
                <div class="carrinho-valor-total">
                    <span class="total">Valor total ----------------------------------------------------------------------------------------------- R$ <?php echo number_format($total, 2, ',', '.'); ?></span>
                </div>

                <button type="submit" name="finalizar_compra" class="carrinho-button">Finalizar compra</button>
            </form>
        </div>
    </div>
    <script src="../js/configuracoes.js"></script>
</body>
</html>