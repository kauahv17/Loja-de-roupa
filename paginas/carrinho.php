<?php
    session_start();
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

</head>
<body>
    <div class="settings-icon left">
            <a href="vendas.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
        </div>
        <div class="settings-icon right">
            <a href="vendas.php"><img src="../assets/img/voltar.svg" alt="carrinho"></a>
            <a href="../index.php"><img src="../assets/img/gear.svg" alt="Configurações"></a>
        </div>
        <div class="carrinho-container">
            <div class="carrinho-header">
                <div class="h1-right">Carrinho</div>
            </div>
            <div class="carrinho-lista">
                <?php
                $result = 4;
                if ($result) {
                while ($result > 0) {
                    $result = $result - 1;
                ?>
                <div class="carrinho-card">
                    <div class="carrinho-card-img">
                        <img src="../assets/img/prod_img.svg" alt="Produto">
                    </div>
                    <div class="carrinho-card-group">
                        <div class="carrinho-card-info">
                            <span class="carrinho-card-title">camiseta</span>
                            <span class="carrinho-card-price">R$ 34</span>
                        </div>
                        <div class="carrinho-card-var">
                            <span class="carrinho-card-sum">R$130</span>
                            <div class='dropdown'>
                                <form method="POST">
                                    <select name='tamanhos' required>
                                        <option value=''></option>
                                        <?php
                                            $tamanhos = ['PP', 'P', 'M', 'G', 'GG'];
                                            foreach ($tamanhos as $t) {
                                                echo "<option value='{$t}'>{$t}</option>";
                                            }
                                        ?>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="carrinho-card-img-trash">
                        <img src="../assets/img/lixeira.svg" alt="Produto">
                    </div>
                    <div class="carrinho-card-qntd-group">
                        <form method="POST">
                            <input type="hidden" name="idproduto" value="<?php echo $row['idproduto']; ?>">
                            <input type="hidden" name="tamanho" value="<?php echo $tamanho; ?>">
                            <input type="hidden" name="quantidade" value="<?php echo $qntd - 1; ?>">
                            <button type="submit" name="alterar_quantidade">-</button>
                        </form>
                        <span class="quantidade">2</span>
                        <form method="POST">
                            <input type="hidden" name="idproduto" value="<?php echo $row['idproduto']; ?>">
                            <input type="hidden" name="tamanho" value="<?php echo $tamanho; ?>">
                            <input type="hidden" name="quantidade" value="<?php echo $qntd + 1; ?>">
                            <button type="submit" name="alterar_quantidade">+</button>
                        </form>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<p style='text-align: center;'>Nenhum produto selecionado.</p>";
                }
                ?>



            <div class="carrinho-header">
                <div class="h1-right">Cliente</div>
            </div>
            <div class="carrinho-busca-group">
                <form class="carrinho-search">
                    <select class="carrinho-select" name="idcliente" required>
                        <option value="">Selecione o cliente</option>
                        <?php
                            include_once("../db/conexao.php");
                            $sql = "SELECT idcliente, cpf FROM cliente ORDER BY cpf ASC";
                            $result = mysqli_query($conn, $sql);
                            if($result){
                                while($row = mysqli_fetch_assoc($result)){
                                echo "<option value='{$row['idcliente']}'>{$row['cpf']}</option>";
                                }
                            } else {
                                echo "<option value=''>Erro ao carregar clientes</option>";
                            }
                        ?>
                    </select>
                    <button type="submit" class="carrinho-search-btn"><img src="../assets/img/lupa.svg" alt="Buscar"></button>
                </form>
                <a href="cadastro_cliente.php"><button class="carrinho-button">Cadastrar Cliente</button></a>
            </div>
            <div class="carrinho-valor-total">
                <span class="total">Valor total ----------------------------------------------------------------------------------------------- R$189,90</span>
            </div>


            <a href="cadastro_cliente.php"><button class="carrinho-button">Finalizar compra</button></a>

        </div>
    </div>
</body>
</html>