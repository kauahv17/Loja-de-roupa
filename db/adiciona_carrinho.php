<?php
session_start();

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

$nome = $_POST['nome'] ?? '';
$preco = $_POST['preco'] ?? 0;
$cor = $_POST['cor'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$tamanho = $_POST['tamanho'] ?? '';

// Gera um id único para o produto no carrinho considerando nome, cor, tipo e tamanho
$id = md5($nome . $cor . $tipo . $tamanho);

$produto = [
    'id' => $id,
    'nome' => $nome,
    'preco' => floatval($preco),
    'cor' => $cor,
    'tipo' => $tipo,
    'tamanho' => $tamanho,
    'quantidade' => 1
];

// Se já existe, incrementa a quantidade
if (isset($_SESSION['carrinho'][$id])) {
    $_SESSION['carrinho'][$id]['quantidade'] += 1;
} else {
    $_SESSION['carrinho'][$id] = $produto;
}

header('Location: ../paginas/vendas.php');
exit; 