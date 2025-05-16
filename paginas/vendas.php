<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/vendasStyle.css">
</head>
<body>
    <div class="vendas-container">
        <div class="vendas-header">
            <div class="vendas-back">
                <a href="home.php"><img src="../assets/img/voltar.svg" alt="Voltar"></a>
            </div>
            <div class="vendas-title">Vendas</div>
            <div class="vendas-nav">
            <a href="/Loja-de-roupa/index.php"><img src="/Loja-de-roupa/assets/img/gear.svg" alt="Configurações"></a>
            </div>
        </div>
        <form class="vendas-search">
            <input type="text" placeholder="pesquisa">
            <button type="submit" class="vendas-search-btn"><img src="../assets/img/lupa.svg" alt="Buscar"></button>
        </form>
        <div class="vendas-grid">
            <!-- Exemplo de card de produto -->
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Camiseta São Paulo</div>
                        <div class="vendas-card-price-container">
                            <span class="vendas-card-price">R$ 25,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" class="dropdown">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" class="cart"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Camiseta São Paulo</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 25,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;"></div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Camiseta São Paulo</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 25,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <!-- Novos produtos -->
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Shorts Esportivo</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 35,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Calça Jeans</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 70,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Vestido Floral</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 90,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Tênis Casual</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 120,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Blusa Moletom</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 80,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Saia Jeans</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 55,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Camisa Polo</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 60,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Regata Fitness</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 22,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Jaqueta Corta Vento</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 110,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Meia Esportiva</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 10,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Boné Casual</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 35,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Cinto Couro</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 45,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Chinelo Slide</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 30,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Bermuda Moletom</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 40,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Blazer Social</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 150,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="../assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Macacão Jeans</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 95,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="../assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="../assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 