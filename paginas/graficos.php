<!DOCTYPE html>
<?php
    session_start();
?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Gráficos</title>
    <link rel="icon" type="image/png" href="/Loja-de-roupa/assets/img/logo_ME.png">
    <link rel="stylesheet" href="../assets/css/pdfStyle.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/sidebarStyle.css">
    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
    <div class="container my-4"><br>
        <div class="chart-icon left">    
            <a href="relatorio_vendas.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
        </div>
            <div class="settings-icone right" onclick="toggleMenu()">
                <div class="chart-icon right" onclick="toggleSidebar()">
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
        <h1 class="text-center">Gráficos da Loja</h1><br><br>
        

        <!-- Botões -->
        <div class="d-flex flex-wrap justify-content-center form-form">
            <button type="button" data-toggle="modal" data-target="#modalEstoque">Estoque por Tipo</button>
            <button type="button" data-toggle="modal" data-target="#modalVendasDia">Vendas por Dia</button>
            <button type="button" data-toggle="modal" data-target="#modalMaisVendidos">Top Produtos Vendidos</button>
            <button type="button" data-toggle="modal" data-target="#modalVendasFuncionario">Vendas por Funcionário</button>
            <button type="button" data-toggle="modal" data-target="#modalEstoqueCritico">Estoque Crítico</button>
        </div>

        <!-- Modais -->
        <!-- Estoque por Tipo -->
        <div class="modal fade" id="modalEstoque" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg"><div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Estoque por Tipo de Produto</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="chart_div"></div>
                </div>
            </div></div>
        </div>

        <!-- Vendas por Dia -->
        <div class="modal fade" id="modalVendasDia" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg"><div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vendas por Dia</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="chart_vendas_dia"></div>
                </div>
            </div></div>
        </div>

        <!-- Top Produtos Mais Vendidos -->
        <div class="modal fade" id="modalMaisVendidos" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg"><div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Top 10 Produtos Mais Vendidos</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="chart_produtos_mais_vendidos"></div>
                </div>
            </div></div>
        </div>

        <!-- Vendas por Funcionário -->
        <div class="modal fade" id="modalVendasFuncionario" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg"><div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vendas por Funcionário</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="chart_vendas_funcionario"></div>
                </div>
            </div></div>
        </div>

        <!-- Estoque Crítico -->
        <div class="modal fade" id="modalEstoqueCritico" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg"><div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Produtos com Estoque Crítico</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="chart_estoque_critico"></div>
                </div>
            </div></div>
        </div>

    </div>

    <!-- jQuery, Popper, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../js/configuracoes.js"></script>
    <!-- Scripts dos Gráficos -->
    <script src="../js/graficoEstoque.js"></script>
    <script src="../js/graficoVendasPorDia.js"></script>
    <script src="../js/graficoProdutosMaisVendidos.js"></script>
    <script src="../js/graficoVendasPorFuncionario.js"></script>
    <script src="../js/graficoEstoqueCritico.js"></script>
</body>
</html>
