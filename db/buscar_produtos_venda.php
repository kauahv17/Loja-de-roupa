<?php
session_start();
include_once("conexao.php");

if (!isset($_POST['idvenda'])) {
    echo "ID da venda não fornecido";
    exit;
}

$idvenda = (int)$_POST['idvenda'];

$sql = "SELECT pp.*, p.nome, p.quantidade_estoque 
        FROM venda v 
        JOIN pedido pd ON v.idpedido = pd.idpedido
        JOIN produto_pedido pp ON pd.idpedido = pp.idpedido
        JOIN produto p ON pp.idproduto = p.idproduto
        WHERE v.idvenda = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $idvenda);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo "<h4>Produtos da Venda</h4>";
    while ($row = mysqli_fetch_assoc($result)) {
        $idproduto = $row['idproduto'];

        echo "<div class='produto-item'>";
        echo "    <div class='produto-item-col select-col'>";
        echo "        <input type='checkbox' name='produtos[]' value='{$idproduto}' id='prod_{$idproduto}' onchange='toggleDevolucao(this, {$idproduto})'>";
        echo "    </div>";
        echo "    <div class='produto-item-col info-col'>";
        echo "        <label for='prod_{$idproduto}' class='produto-nome'>{$row['nome']}</label>";
        if ($row['tamanho']) {
            echo "    <span class='produto-detalhe'>Tamanho: {$row['tamanho']}</span>";
        }
        echo "        <span class='produto-detalhe'>Preço Unit.: R$ " . number_format($row['preco_ped'], 2, ',', '.') . "</span>";
        echo "    </div>";
        echo "    <div class='produto-item-col qtd-col'>";
        echo "        <label>Comprado</label>";
        echo "        <input type='number' value='{$row['quantidade']}' readonly class='qtd-input'>";
        echo "    </div>";
        echo "    <div class='produto-item-col qtd-col'>";
        echo "        <label for='qtd_devolucao_{$idproduto}'>A devolver</label>";
        echo "        <input type='number' name='qtd_devolucao_{$idproduto}' id='qtd_devolucao_{$idproduto}' min='1' max='{$row['quantidade']}' value='1' disabled class='qtd-input'>";
        if ($row['tamanho']) {
            echo "<input type='hidden' name='tamanho_{$idproduto}' value='{$row['tamanho']}'>";
        }
        echo "    </div>";
        echo "</div>";
    }
} else {
    echo "<p>Nenhum produto encontrado para esta venda.</p>";
}

mysqli_stmt_close($stmt);
?> 