
<?php
require __DIR__ . '/../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
    // Inicia o buffer no início absoluto do script
    ob_start();
    
    // Gera o conteúdo HTML
    include __DIR__ . '/../db/contentVendasFuncionarios.php';
    $content = ob_get_clean();
    
    // Verifica se há conteúdo antes de gerar o PDF
    if (ob_get_length()) ob_clean();
    
    $html2pdf = new Html2Pdf('P', 'A4', 'pt');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    
    // Força a limpeza de buffers antes da saída
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    $html2pdf->output('vendas_funcionarios.pdf', 'I'); // 'I' para enviar para o navegador
    
} catch (Html2PdfException $e) {
    // Limpa todos os buffers em caso de erro
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
