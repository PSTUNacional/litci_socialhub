<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT'] . '/autoload.php');

use SH\Service\OpenAiService;

$openai = new OpenAiService();

$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if ($data === null) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid JSON payload']);
    exit;
}

if (!isset($data['method'])) {
    http_response_code(400);
    badRequest("Parameter 'method' is missing.");
}

$method = $data['method'];

if ($method === "createcaptions") {
    $contentType = $data['type'] ?? null;
    $content = $data['content'] ?? null;
    $language = $data['language'] ?? 'spanish';

    if (!$contentType || !$content) {
        badRequest("Parameters 'type' or 'content' are missing.");
    }

    if ($contentType === "url") {
        $response = $openai->createCaption($content, $language);

        // Se já for JSON, apenas envie
        echo $response;
    }
}

if ($method === 'createCarousel') {
    $content = $data['content'];
    if (!$content) {
        badRequest("Parameter 'content' is missing.");
    }

    $language = $data['language'] ?? 'spanish';

    $response = $openai->createCarousel($content, $language);

    echo $response;
}

if ($method === 'createOpenCarousel') {
    $content = $data['content'];
    if (!$content) {
        badRequest("Parameter 'content' is missing.");
    }

    $format = $data['format'];
    if (!$format) {
        badRequest("Parameter 'format' is missing.");
    }

    $language = $data['language'] ?? 'spanish';

    $response = $openai->createOpenCarousel($content, $format, $language);

    echo $response;
}

if ($method === 'translateCarousel') {
    $content = $data['content'];
    if (!$content) {
        badRequest("Parameter 'content' is missing.");
    }

    $language = $data['language'];
    if (!$language) {
        badRequest("Parameter 'language' is missing.");
    }

    $response = $openai->translateCarousel($content, $language);
    echo $response;
}

function badRequest($message)
{
    http_response_code(400);
    echo json_encode([
        "error" => "Bad Request",
        "message" => $message
    ]);
    exit();
}
