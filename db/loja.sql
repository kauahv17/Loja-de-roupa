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
  data_pedido DATETIME DEFAULT (CURRENT_TIMESTAMP) NOT NULL,
  valor_total DECIMAL(10,2) NOT NULL,
  quantidade INT DEFAULT NULL,
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
  preco_uni DECIMAL(10,2) NOT NULL,
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
  quantidade INT DEFAULT NULL,
  preco_ped DECIMAL(10,2) DEFAULT NULL,
  tamanho VARCHAR(3) DEFAULT NULL,
  PRIMARY KEY (idproduto_pedido),
  FOREIGN KEY (idpedido) REFERENCES pedido (idpedido),
  FOREIGN KEY (idproduto) REFERENCES produto (idproduto)
);

-- Tabela: produtos_fornecidos
CREATE TABLE IF NOT EXISTS produtos_fornecidos(
  idprodutos_fornecidos INT NOT NULL AUTO_INCREMENT,
  idfornecedor INT NOT NULL,
  idproduto INT NOT NULL,
  data_fornecimento DATETIME DEFAULT (CURRENT_TIMESTAMP),
  preco_for DECIMAL(10,2) NOT NULL,
  quantidade INT NOT NULL,
  PRIMARY KEY (idprodutos_fornecidos),
  FOREIGN KEY (idfornecedor) REFERENCES fornecedor(idfornecedor),
  FOREIGN KEY (idproduto) REFERENCES produto(idproduto)
);

-- Tabela: venda
CREATE TABLE IF NOT EXISTS venda (
  idvenda INT NOT NULL AUTO_INCREMENT,
  idpedido INT NOT NULL,
  data_venda DATETIME DEFAULT (CURRENT_TIMESTAMP) NULL,
  PRIMARY KEY (idvenda),
  FOREIGN KEY (idpedido) REFERENCES pedido(idpedido)
);



-- Reiniciar incremento
ALTER TABLE cliente AUTO_INCREMENT = 1;
ALTER TABLE fornecedor AUTO_INCREMENT = 1;
ALTER TABLE funcionario AUTO_INCREMENT = 1;
ALTER TABLE pedido AUTO_INCREMENT = 1;
ALTER TABLE tipo_produto AUTO_INCREMENT = 1;
ALTER TABLE produto_pedido AUTO_INCREMENT = 1;
ALTER TABLE produtos_fornecidos AUTO_INCREMENT = 1;
ALTER TABLE venda AUTO_INCREMENT = 1;

-- Inserir 5 fornecedores
INSERT INTO fornecedor (idfornecedor, nome, cnpj) VALUES
(1, 'Fashion Rápida Atacadista LTDA', '11111111111111'),
(2, 'Top Moda Distribuidora', '22222222222222'),
(3, 'Sport Line Fornecimentos', '33333333333333'),
(4, 'Estilo Premium Varejo', '44444444444444'),
(5, 'Óptica Express Ltda', '55555555555555');

-- Inserir tipos de produto
INSERT INTO tipo_produto (idtipo_produto, tipo) VALUES
(1, 'camiseta'),
(2, 'calça'),
(3, 'tênis'),
(4, 'short'),
(5, 'óculos');

-- Inserir cliente
INSERT INTO cliente (nome, cpf, telefone) VALUES
('cliente', '333', '(14)99999-9999');

-- Inserir funcionários
INSERT INTO funcionario (nome, cpf, email, senha, cargo) VALUES
('gerente', '111', 'gerente@gerente.com', '330cfbb0ddba6bc0d430b56ca93de8e9c1e0571f', 'gerente'),
('funcionario', '222', 'funcionario@funcionario.com', '19af83f28ae135d60ce7218681b745172e878533', 'funcionario'),
('Caio Almeida Trindade', 54823917652, 'caio@cat.com', '24d36b0a1e38939beaead8955bd3255a5aab7dc7', 'funcionario'),
('Lucas Pereira Soares', 91284736519, 'lucas@lps.com', '7a70cacf6c2faab087424533520fe1452c0b1005', 'funcionario'),
('Marcos Vinicius Oliveira', 17294856301, 'marcos@mvo.com', 'd82918e330a28188a95515135adeb60518355bde', 'funcionario'),
('Bruna Costa Fernandes', 38172649580, 'bruna@bcf.com', '8157aebc7c5599964915b1727a57ca3d3866ca01', 'funcionario'),
('Gabriel Mendes Rocha', 64183927548, 'gabriel@gmr.com', '3ce09b652dac2b6b43d2ca20512b4d4615539c00', 'funcionario'),
('Juliana Lima Cardoso', 50391284765, 'juliana@jlc.com', '318cc57352d4d2477f2cb11cf8912bd96ef6346d', 'funcionario'),
('Fernando Araujo Martins', 84912037561, 'fernando@fam.com', 'ad2b99dc49c1948b5dd53d055c6fc59608a1e0f3', 'funcionario'),
('Larissa Gomes Freitas', 21593847620, 'larissa@lgf.com', 'ef55a70875d37a8f1c56a251a545f1f4925df266', 'funcionario'),
('Thiago Silva Almeida', 98475126309, 'thiago@tsa.com', 'bc1da7701028c9cbd27fab9e57a9cd3ecdd10a95', 'funcionario'),
('Amanda Ribeiro Sousa', 34785216904, 'amanda@ars.com', '16653cc4ee9201f663ddd70176fff7f7b40c0be7', 'funcionario');


-- Inserir 30 produtos (após tipo_produto)
INSERT INTO produto (nome, quantidade_estoque, preco_uni, cor, idtipo_produto) VALUES
-- Camisetas (9) - tipo 1
('Camiseta da Nike', 20, 30.00, 'rosa', 1),
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

-- Inserir pedido (após cliente e funcionario)
INSERT INTO pedido (valor_total, idfuncionario, idcliente) VALUES
(60.00, 2, 1);

-- Inserir produtos fornecidos (após produto e fornecedor)
INSERT INTO produtos_fornecidos (idfornecedor, idproduto, preco_for, quantidade) VALUES
(1, 1, 300, 20),
(1, 2, 300, 50),
(1, 3, 280, 60),
(1, 4, 270, 40),
(1, 5, 275, 55),
(1, 6, 290, 30),
(2, 7, 200, 70),
(2, 8, 210, 45),
(2, 9, 240, 65),
(2, 10, 250, 35),
(2, 11, 260, 40),
(3, 12, 270, 60),
(3, 13, 280, 30),
(3, 14, 285, 20),
(3, 15, 290, 35),
(3, 16, 295, 25),
(4, 17, 305, 15),
(4, 18, 310, 35),
(4, 19, 320, 20),
(4, 20, 330, 30),
(4, 21, 340, 25),
(5, 22, 270, 30),
(5, 23, 275, 25),
(5, 24, 280, 35),
(5, 25, 285, 40),
(1, 26, 290, 45),
(2, 27, 295, 50),
(2, 28, 300, 30),
(3, 29, 310, 20),
(3, 30, 315, 25),
(4, 31, 320, 18);

-- Inserir produto_pedido (após pedido e produto)
INSERT INTO produto_pedido (idpedido, idproduto, quantidade, preco_ped, tamanho) VALUES
(1, 1, 2, 60.00, 'G');

-- Inserir venda (após pedido)
INSERT INTO venda (idpedido) VALUES
(1);


-- Pedido 2
INSERT INTO pedido (valor_total, quantidade, idfuncionario, idcliente) VALUES
(120.00, 3, 3, 1);

-- Pedido 3
INSERT INTO pedido (valor_total, quantidade, idfuncionario, idcliente) VALUES
(200.00, 5, 4, 1);

-- Pedido 4
INSERT INTO pedido (valor_total, quantidade, idfuncionario, idcliente) VALUES
(80.00, 2, 5, 1);

-- Pedido 2
INSERT INTO produto_pedido (idpedido, idproduto, quantidade, preco_ped, tamanho) VALUES
(2, 2, 1, 35.00, 'M'),
(2, 3, 2, 45.00, 'G');

-- Pedido 3
INSERT INTO produto_pedido (idpedido, idproduto, quantidade, preco_ped, tamanho) VALUES
(3, 4, 3, 38.00, 'M'),
(3, 5, 2, 42.00, 'G');

-- Pedido 4
INSERT INTO produto_pedido (idpedido, idproduto, quantidade, preco_ped, tamanho) VALUES
(4, 6, 1, 50.00, 'P'),
(4, 7, 1, 30.00, 'M');

-- Venda para Pedido 2
INSERT INTO venda (idpedido, data_venda) VALUES
(2, '2025-06-04');

-- Venda para Pedido 3
INSERT INTO venda (idpedido, data_venda) VALUES
(3, '2025-06-05');

-- Venda para Pedido 4
INSERT INTO venda (idpedido, data_venda) VALUES
(4, '2025-06-06');

UPDATE produto SET quantidade_estoque = 5 WHERE idproduto = 2;
UPDATE produto SET quantidade_estoque = 8 WHERE idproduto = 3;
UPDATE produto SET quantidade_estoque = 4 WHERE idproduto = 4;
UPDATE produto SET quantidade_estoque = 2 WHERE idproduto = 5;

INSERT INTO produtos_fornecidos (idfornecedor, idproduto, preco_for, quantidade) VALUES
(2, 3, 270.00, 50),
(3, 4, 280.00, 30),
(4, 5, 290.00, 40);

-- Pedido 5
INSERT INTO pedido (valor_total, quantidade, idfuncionario, idcliente) VALUES
(180.00, 4, 6, 1);

-- Produtos vendidos no pedido 5
INSERT INTO produto_pedido (idpedido, idproduto, quantidade, preco_ped, tamanho) VALUES
(5, 8, 2, 33.00, 'G'),
(5, 9, 2, 48.00, 'M');

-- Venda para Pedido 5
INSERT INTO venda (idpedido, data_venda) VALUES
(5, '2025-06-07');