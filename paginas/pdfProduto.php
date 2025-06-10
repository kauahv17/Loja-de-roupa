<?php
// Força o relatório a ser tratado como PDF desde o início
header('Content-Type: application/pdf');

require __DIR__ . '/../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
    // Buffer rigoroso para evitar qualquer saída antecipada
    if (ob_get_level() > 0) { ob_end_clean(); }
    ob_start();
    
    // Captura o conteúdo HTML
    include __DIR__ . '/../db/contentProduto.php';
    $content = ob_get_clean();
    
    // Verificação adicional de conteúdo prévio
    if (ob_get_length()) { ob_clean(); }
    
    // Configuração do PDF
    $html2pdf = new Html2Pdf('P', 'A4', 'pt', true, 'UTF-8', [10, 10, 10, 10]);
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->pdf->SetAuthor('Sistema de Loja');
    $html2pdf->pdf->SetTitle('Relatório de Produtos');
    
    // Processamento do HTML
    $html2pdf->writeHTML($content);
    
    // Limpeza final de buffers
    while (ob_get_level()) { ob_end_clean(); }
    
    // Saída para o navegador com tratamento de erros
    $html2pdf->output('relatorio_produtos.pdf', 'I');
    
} catch (Html2PdfException $e) {
    // Limpeza emergencial de buffers
    while (ob_get_level()) { ob_end_clean(); }
    
    // Mensagem de erro formatada
    header('Content-Type: text/html; charset=UTF-8');
    $formatter = new ExceptionFormatter($e);
    echo '<!DOCTYPE html><html><head><title>Erro ao gerar PDF</title></head><body>';
    echo '<h1>Erro na geração do relatório</h1>';
    echo $formatter->getHtmlMessage();
    echo '</body></html>';
}