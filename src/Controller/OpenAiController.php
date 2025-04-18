<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT'] . '/autoload.php');

use SH\Service\OpenAiService;
$openai = new OpenAiService();

if (!isset($_POST['method'])) {
    http_response_code(400);
    badRequest("Parameter 'method' is missing.");
}

$method = $_POST['method'];

if ($method === "createcaptions") {
    $contentType = $_POST['type'] ?? null;
    $content = $_POST['content'] ?? null;
    $language = $_POST['language'] ?? 'spanish';

    if (!$contentType || !$content) {
        badRequest("Parameters 'type' or 'content' are missing.");
    }

    if ($contentType === "url") {
        $response = $openai->createCaption($content, $language);

        // Se já for JSON, apenas envie
        echo $response;
    } else {
        badRequest("Invalid content-type value.");
    }

} else {
    badRequest("Invalid method.");
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