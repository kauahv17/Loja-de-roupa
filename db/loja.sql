-- Criar banco de dados
CREATE DATABASE loja;
USE loja;

-- Tabela: cliente
CREATE TABLE IF NOT EXISTS cliente(
  idcliente INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(200) NOT NULL,
  cpf VARCHAR(14) NOT NULL,
  telefone VARCHAR(15) DEFAULT NULL,
  PRIMARY KEY (idcliente)
);


-- Tabela: fornecedor
CREATE TABLE IF NOT EXISTS fornecedor(
  idfornecedor INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(200) NOT NULL,
  cnpj VARCHAR(15) NOT NULL,
  PRIMARY KEY (idfornecedor)
);

-- Tabela: funcionario
CREATE TABLE IF NOT EXISTS funcionario(
  idfuncionario INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(200) NOT NULL,
  cpf VARCHAR(14) NOT NULL,
  email VARCHAR(45) NOT NULL,
  senha VARCHAR(45) NOT NULL,
  cargo VARCHAR(20) NOT NULL,
  PRIMARY KEY (idfuncionario)
);

-- Tabela: pedido
CREATE TABLE IF NOT EXISTS pedido(
  idpedido INT NOT NULL AUTO_INCREMENT,
  data_pedido DATETIME NOT NULL,
  valor_total DOUBLE NOT NULL,
  idfuncionario INT NOT NULL,
  idcliente INT NOT NULL,
  PRIMARY KEY (idpedido),
  FOREIGN KEY (idfuncionario) REFERENCES funcionario(idfuncionario),
  FOREIGN KEY (idcliente)  REFERENCES cliente(idcliente)
);

-- Tabela: tipo_produto
CREATE TABLE IF NOT EXISTS tipo_produto(
  idtipo_produto INT NOT NULL AUTO_INCREMENT,
  tipo VARCHAR(100) NOT NULL,
  PRIMARY KEY (idtipo_produto)
);

-- Tabela: produto
CREATE TABLE IF NOT EXISTS produto (
  idproduto INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(200) NOT NULL,
  quantidade_estoque INT NOT NULL,
  preco_uni DOUBLE NOT NULL,
  cor VARCHAR(45) NOT NULL,
  idtipo_produto INT NOT NULL,
  PRIMARY KEY (idproduto),
  FOREIGN KEY (idtipo_produto) REFERENCES tipo_produto(idtipo_produto)
);

-- Tabela: produto_pedido
CREATE TABLE IF NOT EXISTS produto_pedido(
  idproduto_pedido INT NOT NULL AUTO_INCREMENT,
  idpedido INT NOT NULL,
  idproduto INT NOT NULL,
  quantidade_pedido INT DEFAULT NULL,
  preco_ped DOUBLE DEFAULT NULL,
  PRIMARY KEY (idproduto_pedido),
  FOREIGN KEY (idpedido) REFERENCES pedido (idpedido),
  FOREIGN KEY (idproduto) REFERENCES produto (idproduto)
);

-- Tabela: produtos_fornecidos
CREATE TABLE IF NOT EXISTS produtos_fornecidos(
  idprodutos_fornecidos INT NOT NULL AUTO_INCREMENT,
  idfornecedor INT NOT NULL,
  idproduto INT NOT NULL,
  data_fornecimento DATETIME NOT NULL,
  preco_for INT NOT NULL,
  quantidade INT NOT NULL,
  PRIMARY KEY (idprodutos_fornecidos),
  FOREIGN KEY (idfornecedor) REFERENCES fornecedor(idfornecedor),
  FOREIGN KEY (idproduto) REFERENCES produto(idproduto)
);

-- Tabela: venda
CREATE TABLE IF NOT EXISTS venda (
  idvenda INT NOT NULL AUTO_INCREMENT,
  idpedido INT NOT NULL,
  data_venda VARCHAR(45) DEFAULT NULL,
  PRIMARY KEY (idvenda),
  FOREIGN KEY (idpedido) REFERENCES pedido(idpedido)
);



-- Inserir tipo de produto antes do produto
INSERT INTO tipo_produto (idtipo_produto, tipo) VALUES
(1, 'camiseta');

-- Inserir cliente
INSERT INTO cliente (idcliente, nome, cpf, telefone) VALUES
(1, 'cliente', '333', '(14)99999-9999');

-- Inserir fornecedor
INSERT INTO fornecedor (idfornecedor, nome, cnpj) VALUES
(1, 'Fashion Rápida Atacadista LTDA', '11111111111111');

-- Inserir funcionários
INSERT INTO funcionario (idfuncionario, nome, cpf, email, senha, cargo) VALUES
(1, 'gerente', '111', 'gerente@gerente.com', '330cfbb0ddba6bc0d430b56ca93de8e9c1e0571f', 'gerente'),
(2, 'funcionario', '222', 'funcionario@funcionario.com', '19af83f28ae135d60ce7218681b745172e878533', 'funcionario');

-- Inserir produto (após tipo_produto)
INSERT INTO produto (idproduto, nome, quantidade_estoque, preco_uni, cor, idtipo_produto) VALUES
(1, 'camiseta da Nike', 20, 30.00, 'rosa', 1);

-- Inserir pedido (após cliente e funcionario)
INSERT INTO pedido (idpedido, data_pedido, valor_total, idfuncionario, idcliente) VALUES
(1, '2025-05-01 10:00:00', 60.00, 2, 1);

-- Inserir produtos fornecidos (após produto e fornecedor)
INSERT INTO produtos_fornecidos (idprodutos_fornecidos, idfornecedor, idproduto, data_fornecimento, preco_for, quantidade) VALUES
(1, 1, 1, '2025-04-30 14:00:00', 300, 20);

-- Inserir produto_pedido (após pedido e produto)
INSERT INTO produto_pedido (idproduto_pedido, idpedido, idproduto, quantidade_pedido, preco_ped) VALUES
(1, 1, 1, 2, 60.00);

-- Inserir venda (após pedido)
INSERT INTO venda (idvenda, idpedido, data_venda) VALUES
(1, 1, '2025-05-02 11:30:00');

-- Inserir 5 fornecedores
INSERT INTO fornecedor (idfornecedor, nome, cnpj) VALUES
(2, 'Top Moda Distribuidora', '22222222222222'),
(3, 'Sport Line Fornecimentos', '33333333333333'),
(4, 'Estilo Premium Varejo', '44444444444444'),
(5, 'Óptica Express Ltda', '55555555555555');

-- Inserir tipos de produto
INSERT INTO tipo_produto (idtipo_produto, tipo) VALUES
(2, 'calça'),
(3, 'tênis'),
(4, 'short'),
(5, 'óculos');

-- Inserir 30 produtos
INSERT INTO produto (nome, quantidade_estoque, preco_uni, cor, idtipo_produto) VALUES
-- Camisetas (9) - tipo 1
('Camiseta Dry Fit', 50, 35.00, 'preto', 1),
('Camiseta Oversized', 60, 45.00, 'branco', 1),
('Camiseta Slim', 40, 38.00, 'azul', 1),
('Camiseta Gola V', 55, 42.00, 'vermelho', 1),
('Camiseta Manga Longa', 30, 50.00, 'cinza', 1),
('Camiseta Casual', 70, 30.00, 'verde', 1),
('Camiseta Algodão', 45, 33.00, 'bege', 1),
('Camiseta Fitness', 65, 48.00, 'roxo', 1),
('Camiseta Polo', 35, 55.00, 'marinho', 1),

-- Calças (8) - tipo 2
('Calça Jeans Slim', 50, 80.00, 'azul', 2),
('Calça Jogger', 40, 75.00, 'preta', 2),
('Calça Moletom', 60, 65.00, 'cinza', 2),
('Calça Cargo', 30, 85.00, 'verde militar', 2),
('Calça Social', 20, 90.00, 'preta', 2),
('Calça Jeans Reta', 35, 78.00, 'azul escuro', 2),
('Calça Chino', 25, 82.00, 'bege', 2),
('Calça Tática', 15, 95.00, 'camuflada', 2),

-- Tênis (8) - tipo 3
('Tênis Esportivo', 40, 120.00, 'preto', 3),
('Tênis Casual', 35, 100.00, 'branco', 3),
('Tênis Corrida Pro', 25, 150.00, 'vermelho', 3),
('Tênis Urbano', 30, 110.00, 'cinza', 3),
('Tênis Skate', 20, 105.00, 'preto', 3),
('Tênis Fitness', 28, 130.00, 'azul', 3),
('Tênis Couro', 22, 160.00, 'marrom', 3),
('Tênis Caminhada', 45, 95.00, 'verde', 3),

-- Shorts (3) - tipo 4
('Shorts Moletom', 30, 60.00, 'cinza', 4),
('Shorts Esportivo', 25, 65.00, 'preto', 4),
('Shorts Jeans', 35, 70.00, 'azul claro', 4),

-- Óculos (2) - tipo 5
('Óculos de Sol Aviador', 20, 90.00, 'preto', 5),
('Óculos de Grau Retrô', 18, 85.00, 'tartaruga', 5);

-- Inserir registros em produtos_fornecidos
INSERT INTO produtos_fornecidos (idfornecedor, idproduto, data_fornecimento, preco_for, quantidade) VALUES
(1, 2, '2025-05-01 09:00:00', 300, 50),
(1, 3, '2025-05-01 09:05:00', 280, 60),
(1, 4, '2025-05-01 09:10:00', 270, 40),
(1, 5, '2025-05-01 09:15:00', 275, 55),
(1, 6, '2025-05-01 09:20:00', 290, 30),
(2, 7, '2025-05-01 09:25:00', 200, 70),
(2, 8, '2025-05-01 09:30:00', 210, 45),
(2, 9, '2025-05-01 09:35:00', 240, 65),
(2, 10, '2025-05-01 09:40:00', 250, 35),
(2, 11, '2025-05-01 09:45:00', 260, 40),
(3, 12, '2025-05-02 08:00:00', 270, 60),
(3, 13, '2025-05-02 08:05:00', 280, 30),
(3, 14, '2025-05-02 08:10:00', 285, 20),
(3, 15, '2025-05-02 08:15:00', 290, 35),
(3, 16, '2025-05-02 08:20:00', 295, 25),
(4, 17, '2025-05-02 08:25:00', 305, 15),
(4, 18, '2025-05-02 08:30:00', 310, 35),
(4, 19, '2025-05-02 08:35:00', 320, 20),
(4, 20, '2025-05-02 08:40:00', 330, 30),
(4, 21, '2025-05-02 08:45:00', 340, 25),
(5, 22, '2025-05-02 09:00:00', 270, 30),
(5, 23, '2025-05-02 09:05:00', 275, 25),
(5, 24, '2025-05-02 09:10:00', 280, 35),
(5, 25, '2025-05-02 09:15:00', 285, 40),
(1, 26, '2025-05-02 09:20:00', 290, 45),
(2, 27, '2025-05-02 09:25:00', 295, 50),
(2, 28, '2025-05-02 09:30:00', 300, 30),
(3, 29, '2025-05-02 09:35:00', 310, 20),
(3, 30, '2025-05-02 09:40:00', 315, 25),
(4, 31, '2025-05-02 09:45:00', 320, 18);