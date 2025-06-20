<?php
session_start();
include_once '../db/conexao.php';

$cargo = $_SESSION['cargo']; 
$idFuncionarioLogado = $_SESSION['idfuncionario'];
$funcionario = isset($_GET['funcionario']) ? mysqli_real_escape_string($conn, $_GET['funcionario']) : '';

$where = '';
if ($cargo == 'funcionario') {
    $where = "WHERE f.idfuncionario = '$idFuncionarioLogado'";
} elseif (!empty($funcionario)) {
    $where = "WHERE f.idfuncionario = '$funcionario'";
}

// Consulta resumo por pedido
$sql = "SELECT 
    v.idvenda,
    p.idpedido,
    p.data_pedido,
    c.nome AS cliente,
    p.quantidade AS qtd_total_vendida,
    p.valor_total,
    (SELECT COALESCE(SUM(pd.quantidade), 0) FROM devolucao d JOIN produto_devolucao pd ON d.iddevolucao = pd.iddevolucao WHERE d.idvenda = v.idvenda) AS qtd_total_devolvida
FROM venda v
JOIN pedido p ON v.idpedido = p.idpedido
JOIN cliente c ON p.idcliente = c.idcliente
JOIN funcionario f ON p.idfuncionario = f.idfuncionario 
$where
GROUP BY v.idvenda, p.idpedido, p.data_pedido, c.nome, p.quantidade, p.valor_total
ORDER BY v.idvenda DESC";

$result = mysqli_query($conn, $sql);

// Consulta funcionários para filtro
$sqlFunc = "SELECT idfuncionario, nome FROM funcionario WHERE cargo != 'apagado'"; 
$resultFunc = mysqli_query($conn, $sqlFunc);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Relatório de vendas</title>
<link rel="icon" type="image/png" href="/Loja-de-roupa/assets/img/logo_ME.png" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
<link rel="stylesheet" href="../assets/css/filtroStyle.css" />
<link rel="stylesheet" href="../assets/css/tabelaRelatorioStyle.css" />
<link rel="stylesheet" href="../assets/css/sidebarStyle.css">
</head>
<body>

<div class="container my-4"><br>
    <div class="chart-icon left">
        <a href="home.php"><img src="../assets/img/voltar.svg" alt="Voltar" /></a>
    </div>

    <div class="chart-icon right form-form">
        <a href="pdfProdutosMaisVendidos.php"><img src="../assets/img/pdf.svg" alt="PDF Vendas por Funcionários" style="width:60px;"></a>
        <div class="settings-icone right" onclick="toggleMenu()">
            <div class="settings-icon right" onclick="toggleSidebar()">
                <img src="../assets/img/gear.svg" alt="Configurações" style="cursor: pointer;">
            </div>
            <div class="sidebar" id="sidebar">
            <div>
                <h2>Configurações</h2>
                <h4><strong>Nome:</strong> <?php echo $_SESSION['nome']; ?></h4>
                <h4><strong>ID:</strong> <?php echo $_SESSION['idfuncionario']; ?></h4><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </div>
            <a href="../index.php">
                <img src="../assets/img/sair.svg" alt="Sair"> 
            </a>
            </div>
        </div>
    </div>
    
    <h1 class="text-center color"><a href="relatorio_vendas.php">Relatório de vendas</a></h1>
</div><br>

<div class="container mt-4">

    <!-- Filtro por funcionário -->
    <?php if ($cargo == 'gerente'): ?>
        <form method="GET" class="mb-4">
            <div class="d-flex flex-wrap justify-content-center form-form">
                <?php while ($func = mysqli_fetch_assoc($resultFunc)): ?>
                    <button 
                        type="submit" 
                        name="funcionario" 
                        value="<?= $func['idfuncionario'] ?>" 
                        class="btn-color <?= ($funcionario == $func['idfuncionario']) ? 'ativo' : '' ?>">
                        <?= $func['nome'] ?>
                    </button>
                <?php endwhile; ?>
            </div>
        </form>
    <?php endif; ?>

    <!-- Tabela resumo de pedidos -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID Venda</th>
                <th>Cliente</th>
                <th>Status</th>
                <th>Valor</th>
                <th>Data</th>
                <th class="text-center" style="color: white;">
                    <a href="graficos.php">
                        <img src="../assets/img/chart.svg" alt="Gráficos" style="width:20px;" />
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <?php
                        // Determinar o status da venda
                        $status = '';
                        $badge_class = '';
                        if ($row['qtd_total_devolvida'] == 0) {
                            $status = 'Concluído';
                            $badge_class = 'badge-success';
                        } elseif ($row['qtd_total_devolvida'] < $row['qtd_total_vendida']) {
                            $status = 'Dev. Parcial';
                            $badge_class = 'badge-warning';
                        } else {
                            $status = 'Dev. Total';
                            $badge_class = 'badge-danger';
                        }
                    ?>
                    <tr>
                        <td><?= $row['idvenda'] ?></td>
                        <td><?= htmlspecialchars($row['cliente']) ?></td>
                        <td><span class="badge <?= $badge_class ?>"><?= $status ?></span></td>
                        <td>R$ <?= number_format($row['valor_total'], 2, ',', '.') ?></td>
                        <td><?= date('d/m/Y', strtotime($row['data_pedido'])) ?></td>
                        <td class="text-center">
                            <button class="btn btn-sm btnDetalhes" data-idvenda="<?= $row['idvenda'] ?>" data-idpedido="<?= $row['idpedido'] ?>">
                                <img src="../assets/img/eye.svg" alt="Ver detalhes" style="width:20px;" />
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Nenhuma venda encontrada para este funcionário.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Bootstrap para mostrar detalhes do pedido -->
<div class="modal fade" id="modalDetalhes" tabindex="-1" role="dialog" aria-labelledby="modalDetalhesLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetalhesLabel">Detalhes do Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Conteúdo da Venda Original -->
        <h6>Itens da Venda</h6>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Tamanho</th>
                    <th>Preço Unitário</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="detalhesBody">
                <!-- dados aqui -->
            </tbody>
        </table>
        <!-- Container para Detalhes da Devolução -->
        <div id="detalhesDevolucaoContainer" style="display:none;">
            <hr>
            <h6>Itens Devolvidos</h6>
            <div id="detalhesDevolucaoBody">
                <!-- conteúdo da devolução aqui -->
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Função para carregar detalhes via AJAX
$(document).ready(function(){
    $('.btnDetalhes').click(function(){
        var idpedido = $(this).data('idpedido');
        var idvenda = $(this).data('idvenda');
        
        $.ajax({
            url: 'detalhes_venda_completo.php',
            method: 'GET',
            data: { idpedido: idpedido, idvenda: idvenda },
            dataType: 'json',
            success: function(response){
                // Popula detalhes da venda
                var tbodyVenda = '';
                if(response.venda && response.venda.length > 0){
                    response.venda.forEach(function(item){
                        var subtotal = item.quantidade * item.preco_ped;
                        tbodyVenda += '<tr>'+
                            '<td>'+item.produto+'</td>'+
                            '<td>'+item.quantidade+'</td>'+
                            '<td>'+item.tamanho+'</td>'+
                            '<td>R$ '+parseFloat(item.preco_ped).toFixed(2).replace(".", ",")+'</td>'+
                            '<td>R$ '+subtotal.toFixed(2).replace(".", ",")+'</td>'+
                            '</tr>';
                    });
                } else {
                    tbodyVenda = '<tr><td colspan="5" class="text-center">Nenhum produto encontrado.</td></tr>';
                }
                $('#detalhesBody').html(tbodyVenda);

                // Popula detalhes da devolução, se houver
                if(response.devolucao && response.devolucao.info) {
                    var devolucaoHtml = '<h5>Motivo: ' + response.devolucao.info.motivo + '</h5>' +
                        '<p><strong>Data:</strong> ' + new Date(response.devolucao.info.data_devolucao).toLocaleDateString('pt-BR') + ' | ' +
                        '<strong>Funcionário:</strong> ' + response.devolucao.info.funcionario + ' | ' +
                        '<strong>Valor Devolvido:</strong> R$ ' + parseFloat(response.devolucao.info.valor_total).toFixed(2).replace(".", ",") + '</p>' +
                        '<table class="table table-sm table-bordered"><thead><tr><th>Produto</th><th>Qtd</th><th>Tamanho</th><th>Preço</th><th>Subtotal</th></tr></thead><tbody>';
                    
                    response.devolucao.itens.forEach(function(item){
                        var subtotal = item.quantidade * item.preco_dev;
                        devolucaoHtml += '<tr>' +
                            '<td>' + item.produto + '</td>' +
                            '<td>' + item.quantidade + '</td>' +
                            '<td>' + (item.tamanho || 'N/A') + '</td>' +
                            '<td>R$ ' + parseFloat(item.preco_dev).toFixed(2).replace(".", ",") + '</td>' +
                            '<td>R$ ' + subtotal.toFixed(2).replace(".", ",") + '</td>' +
                            '</tr>';
                    });

                    devolucaoHtml += '</tbody></table>';
                    
                    $('#detalhesDevolucaoBody').html(devolucaoHtml);
                    $('#detalhesDevolucaoContainer').show();
                } else {
                    $('#detalhesDevolucaoContainer').hide();
                    $('#detalhesDevolucaoBody').html('');
                }

                $('#modalDetalhes').modal('show');
            },
            error: function(){
                alert('Erro ao carregar detalhes do pedido.');
            }
        });
    });
});
</script>
<script src="../js/configuracoes.js"></script>
</body>
</html>
