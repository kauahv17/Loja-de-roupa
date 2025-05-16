-- Criar banco de dados
CREATE DATABASE loja;
USE loja;

-- Tabela: funcionario
CREATE TABLE funcionario (
    idfuncionario INT NOT NULL AUTO_INCREMENT,
    cpf VARCHAR(14) NOT NULL,
    nome VARCHAR(45),
    email VARCHAR(45) NOT NULL,
    senha VARCHAR(45) NOT NULL,
    cargo VARCHAR(20),
    PRIMARY KEY (idfuncionario)
);

-- Tabela: cliente
CREATE TABLE cliente (
    idcliente INT NOT NULL AUTO_INCREMENT,
    cpf VARCHAR(14) NOT NULL,
    nome VARCHAR(45),
    telefone VARCHAR(15),
    PRIMARY KEY (idcliente)
);

-- Tabela: tipo_produto
CREATE TABLE tipo_produto (
    idtipo_produto INT NOT NULL,
    descricao VARCHAR(100),
    PRIMARY KEY (idtipo_produto)
);

-- Tabela: produto
CREATE TABLE produto (
    idproduto INT NOT NULL AUTO_INCREMENT,
    quantidade_estoque INT,
    preco_uni DOUBLE,
    cor VARCHAR(45),
    idtipo_produto INT NOT NULL,
    PRIMARY KEY (idproduto),
    FOREIGN KEY (idtipo_produto) REFERENCES tipo_produto(idtipo_produto)
);

-- Tabela: fornecedor
CREATE TABLE fornecedor (
    idfornecedor INT NOT NULL,
    cnpj VARCHAR(15),
    PRIMARY KEY (idfornecedor)
);

-- Tabela: produtos_fornecidos
CREATE TABLE produtos_fornecidos (
    idprodutos_fornecidos INT NOT NULL,
    idfornecedor INT NOT NULL,
    idproduto INT NOT NULL,
    data_fornecimento DATETIME,
    preco_for INT,
    quantidade INT,
    PRIMARY KEY (idprodutos_fornecidos),
    FOREIGN KEY (idfornecedor) REFERENCES fornecedor(idfornecedor),
    FOREIGN KEY (idproduto) REFERENCES produto(idproduto)
);

-- Tabela: pedido
CREATE TABLE pedido (
    idpedido INT NOT NULL,
    data_pedido DATETIME DEFAULT NULL,
    valor_total DOUBLE DEFAULT NULL,
    idfuncionario INT NOT NULL,
    idcliente INT NOT NULL,
    PRIMARY KEY (idpedido),
    FOREIGN KEY (idfuncionario) REFERENCES funcionario(idfuncionario),
    FOREIGN KEY (idcliente) REFERENCES cliente(idcliente)
);

-- Tabela: produto_pedido
CREATE TABLE produto_pedido (
    idproduto_pedido INT NOT NULL AUTO_INCREMENT,
    idpedido INT NOT NULL,
    idproduto INT NOT NULL,
    quantidade_pedido INT DEFAULT NULL,
    preco_ped DOUBLE DEFAULT NULL,
    PRIMARY KEY (idproduto_pedido),
    FOREIGN KEY (idpedido) REFERENCES pedido(idpedido),
    FOREIGN KEY (idproduto) REFERENCES produto(idproduto)
);

-- Tabela: venda
CREATE TABLE venda (
    idvenda INT NOT NULL AUTO_INCREMENT,
    idpedido INT NOT NULL,
    data_venda VARCHAR(45) DEFAULT NULL,
    PRIMARY KEY (idvenda),
    FOREIGN KEY (idpedido) REFERENCES pedido(idpedido)
);


-- Inserir tipo de produto antes do produto
INSERT INTO tipo_produto (idtipo_produto, descricao) VALUES
(1, 'blusa');

-- Inserir cliente
INSERT INTO cliente (idcliente, cpf, nome, telefone) VALUES
(1, '333', 'cliente', '(14)99999-9999');

-- Inserir fornecedor
INSERT INTO fornecedor (idfornecedor, cnpj) VALUES
(1, '11111111111111');

-- Inserir funcionários
INSERT INTO funcionario (idfuncionario, cpf, nome, email, senha, cargo) VALUES
(1, '111', 'gerente', 'gerente@gerente.com', '330cfbb0ddba6bc0d430b56ca93de8e9c1e0571f', 'gerente'),
(2, '222', 'funcionario', 'funcionario@funcionario.com', '19af83f28ae135d60ce7218681b745172e878533', 'funcionario');

-- Inserir produto (após tipo_produto)
INSERT INTO produto (idproduto, quantidade_estoque, preco_uni, cor, idtipo_produto) VALUES
(1, 20, 30.00, 'rosa', 1);

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