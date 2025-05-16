<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas</title>
    <link rel="stylesheet" href="assets/css/homeStyle.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .vendas-container {
            padding: 32px 48px;
            height: 100vh;
            box-sizing: border-box;
            overflow-y: auto;
        }
        .vendas-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }
        .vendas-title {
            font-size: 2rem;
            font-weight: bold;
            margin: 0 auto;
        }
        .vendas-back {
            position: absolute;
            left: 0;
            top: 0;
            margin: 0 0 0 8px;
            display: flex;
            align-items: center;
            height: 100%;
        }
        .vendas-search {
            margin: 32px 0 24px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
        }
        .vendas-search input {
            width: 400px;
            max-width: 90vw;
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }
        .vendas-search-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0 0 0 4px;
            display: flex;
            align-items: center;
        }
        .vendas-grid {
            display: grid;
            grid-template-columns: repeat(4, 220px);
            gap: 24px;
            justify-content: center;
        }
        .vendas-card {
            background: #f2f2f2;
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 260px;
            width: 220px;
        }
        .vendas-card-img {
            background: #d9d9d9;
            height: 170px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .vendas-card-info {
            background: #e88c1a;
            color: #fff;
            padding: 18px 16px 8px 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;
        }
        .vendas-card-title {
            font-weight: bold;
            margin-bottom: 2px;
            font-size: 1.05rem;
        }
        .vendas-card-price {
            margin-bottom: 0;
            font-size: 1rem;
        }
        .vendas-card-actions {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 12px;
        }
        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }
        .vendas-nav {
            display: flex;
            align-items: center;
            gap: 16px;
        }
    </style>
</head>
<body>
    <div class="vendas-container">
        <div class="vendas-header">
            <div class="vendas-back">
                <a href="home.php"><img src="assets/img/voltar.svg" alt="Voltar" style="width:32px;"></a>
            </div>
            <div class="vendas-title">Vendas</div>
            <div class="vendas-nav">
                <a href="#"><img src="assets/img/gear.svg" alt="Configurações" style="width:32px;"></a>
            </div>
        </div>
        <form class="vendas-search">
            <input type="text" placeholder="pesquisa">
            <button type="submit" class="vendas-search-btn"><img src="assets/img/lupa.svg" alt="Buscar" style="width:22px;"></button>
        </form>
        <div class="vendas-grid">
            <!-- Exemplo de card de produto -->
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Camiseta São Paulo</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 25,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Camiseta São Paulo</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 25,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;"></div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Camiseta São Paulo</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 25,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <!-- Novos produtos -->
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Shorts Esportivo</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 35,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Calça Jeans</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 70,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Vestido Floral</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 90,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Tênis Casual</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 120,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Blusa Moletom</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 80,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Saia Jeans</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 55,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Camisa Polo</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 60,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Regata Fitness</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 22,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Jaqueta Corta Vento</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 110,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Meia Esportiva</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 10,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Boné Casual</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 35,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Cinto Couro</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 45,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Chinelo Slide</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 30,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Bermuda Moletom</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 40,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Blazer Social</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 150,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
            <div class="vendas-card">
                <div class="vendas-card-img">
                    <img src="assets/img/prod_img.svg" alt="Produto" style="width:60px;">
                </div>
                <div class="vendas-card-info">
                    <div>
                        <div class="vendas-card-title">Macacão Jeans</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span class="vendas-card-price">R$ 95,00</span>
                        </div>
                    </div>
                    <div class="vendas-card-actions">
                        <img src="assets/img/dropw.svg" alt="Mais opções" style="width:18px; vertical-align: middle;">
                        <button class="icon-btn"><img src="assets/img/carrinho.svg" alt="Carrinho" style="width:28px;"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 