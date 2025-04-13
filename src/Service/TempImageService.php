<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$uploadDir = __DIR__ . '/../Temp/';

// Verifica se o arquivo foi enviado corretamente
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tmpName = $_FILES['image']['tmp_name'];
    $originalName = $_FILES['image']['name'];
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    $fileName = 'bannerToPost.' . $extension;
    $destination = $uploadDir . $fileName;

    if (move_uploaded_file($tmpName, $destination)) {
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'message' => 'Imagem salva com sucesso.',
            'path' => $destination
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao mover o arquivo.'
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Nenhum arquivo recebido ou erro no upload.'
    ]);
}
