<?php
require_once('../config.php');

// Verificar se o relatório em PDF está desativado
if ($relatorio_pdf != 'Sim') {
    // Neste caso, apenas exiba o conteúdo HTML no navegador
    $html = file_get_contents($url_sistema . "rel/relProdutos.php");
    echo $html;
    exit();
}

// Carregar a biblioteca DOMPDF
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Inicializar a classe DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);

$pdf = new Dompdf($options);

// Definir o tamanho do papel e orientação da página
$pdf->setPaper('A4', 'portrait'); // Para paisagem, use 'landscape' em vez de 'portrait'

// Carregar o conteúdo HTML
$html = file_get_contents($url_sistema . "rel/relProdutos.php");
$pdf->loadHtml($html);

// Renderizar o PDF
$pdf->render();

// Nomear o PDF gerado e enviá-lo para o navegador
$pdf->stream('produtos.pdf', array("Attachment" => false));
