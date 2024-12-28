<?php
// session_start();
// include_once 'config/database.php';
require 'vendor/autoload.php';

use Dompdf\Dompdf;

// Fungsi untuk mengganti placeholder di template
function renderTemplate($filePath, $variables = []) {
    $template = file_get_contents($filePath);
    foreach ($variables as $key => $value) {
        $template = str_replace("{{" . $key . "}}", $value, $template);
    }
    return $template;
}

// Set tanggal untuk dokumen
$tanggal = date("d F Y");

// Load template HTML dan isi variabel
$html = renderTemplate("../assets/report/template.html", ["tanggal" => $tanggal]);

// Inisialisasi Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// Atur ukuran kertas dan orientasi
$dompdf->setPaper('A4', 'portrait');

// Render HTML ke PDF
$dompdf->render();

// Kirim PDF ke browser
$dompdf->stream("output.pdf", ["Attachment" => false]);
