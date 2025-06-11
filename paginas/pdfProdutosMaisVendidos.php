<?php
require __DIR__ . '/../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
    ob_start();
    include __DIR__ . '/../db/contentProdutosMaisVendidos.php';
    $content = ob_get_clean();

    $html2pdf = new Html2Pdf('P', 'A4', 'pt');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);

    while (ob_get_level()) {
        ob_end_clean();
    }

    $html2pdf->output('vendas_por_dia.pdf', 'I');

} catch (Html2PdfException $e) {
    while (ob_get_level()) {
        ob_end_clean();
    }

    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
