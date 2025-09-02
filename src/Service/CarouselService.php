<?php
$zip = new ZipArchive();
$filename = "slides.zip";

if ($zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    exit("Não foi possível criar o ZIP");
}

// percorre todos os arquivos enviados via POST
foreach ($_FILES as $name => $file) {
    $zip->addFile($file['tmp_name'], $file['name']);
}

$zip->close();

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Content-Length: ' . filesize($filename));

readfile($filename);
unlink($filename); // remove o ZIP temporário
exit;