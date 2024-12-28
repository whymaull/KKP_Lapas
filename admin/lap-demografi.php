<?php
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

function renderTemplate($filePath, $variables = []) {
    $template = file_get_contents($filePath);
    foreach ($variables as $key => $value) {
        $template = str_replace("{{" . $key . "}}", $value, $template);
    }
    return $template;
}

$formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
$tanggal = $formatter->format(time()); 

$html = renderTemplate("assets/report/lap-demografi.html", ["tanggal" => $tanggal]);

$dompdf = new Dompdf();
$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream("laporan_demografi.pdf", ["Attachment" => false]);
