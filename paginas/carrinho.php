<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="icon" type="image/png" href="/Loja-de-roupa/assets/img/logo_ME.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/carrinhoStyle.css">

</head>
<body>
<div class="settings-icon left">
        <a href="vendas.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
    </div>
    <div class="settings-icon right">
        <a href="../index.php"><img src="../assets/img/gear.svg" alt="Configurações"></a>
    </div><br><br>
        <div class="carrinho-header">
            <div class="h1-right">Carrinho</div>
        </div>
        <form class="carrinho-search" method="GET" action="">
            <input type="text" placeholder="pesquisa" name="pesquisa" value="<?php echo isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : '';?>">
            <button type="submit" class="carrinho-search-btn"><img src="../assets/img/lupa.svg" alt="Buscar"></button>
        </form>
        <br><br><br>

        <div class="carrinho-itens">
<?php
// Exemplo de estrutura para exibir os itens do carrinho
if(isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0){
    foreach($_SESSION['carrinho'] as $item){
        echo '
        <div class="carrinho-card">
            <div class="carrinho-card-img">
                <img src="'.($item['imagem'] ?? '../assets/img/placeholder_produto.svg').'" alt="Imagem do produto">
            </div>
            <div class="carrinho-card-info">
                <div class="carrinho-card-title">'.htmlspecialchars($item['nome']).'</div>
                <div>Cor: '.htmlspecialchars($item['cor']).'</div>
                <div>Tipo: '.htmlspecialchars($item['tipo']).'</div>
                '.($item['tamanho'] ? '<div>Tamanho: '.htmlspecialchars($item['tamanho']).'</div>' : '').'
                <div>Preço: R$ '.number_format($item['preco'], 2, ',', '.').'</div>
                <div class="carrinho-card-actions">
                    <form method="POST" action="../db/atualiza_carrinho.php" class="form-quantidade" style="display:inline-flex; align-items:center; gap:4px;">
                        <input type="hidden" name="id" value="'.$item['id'].'">
                        <button type="submit" name="acao" value="mais" class="btn-mais">+</button>
                        <span class="quantidade">'.intval($item['quantidade']).'</span>
                        <button type="submit" name="acao" value="menos" class="btn-menos">-</button>
                    </form>
                    <form method="POST" action="../db/remove_item.php" class="form-remover" style="display:inline;">
                        <input type="hidden" name="id" value="'.$item['id'].'">
                        <button type="submit" class="btn-remover" style="background:none; border:none; cursor:pointer;"><img src="../assets/img/lixeira.svg" alt="Remover"></button>
                    </form>
                </div>
            </div>
        </div>
        ';
    }
} else {
    echo '<div class="carrinho-vazio">Seu carrinho está vazio.</div>';
}
?>
</div>
<br>
<div class="carrinho-header">
    <div class="h1-right">Cliente</div>
</div>
<div>
    <form class="form-form" action="../db/processa_cliente.php" method="POST" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">    
        <select class="select-cliente" name="idcliente" required style="width: 500px; height: 60px; font-size: 20px; padding: 6px; border-radius: 6px;">
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
        <button class = "cadastrar" onclick="window.location.href='cadastro_cliente.php'" type="button">Cadastrar Cliente</button>   
    </form>
</div>
<br>
<div class="carrinho-total" style="margin: 30px auto; max-width: 600px; background: #e0e0e0; border-radius: 16px; padding: 24px; font-size: 22px; border: 2px solid #000; display: flex; justify-content: space-between; align-items: center;">
    <span>Valor Total</span>
    <span>
        <?php
            $total = 0;
            if(isset($_SESSION['carrinho'])){
                foreach($_SESSION['carrinho'] as $item){
                    $total += $item['preco'] * $item['quantidade'];
                }
            }
            echo 'R$ '.number_format($total, 2, ',', '.');
        ?>
    </span>
</div>
</body>
</html>