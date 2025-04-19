<?php

include($_SERVER['DOCUMENT_ROOT'] . '/autoload.php');

$content = file_get_contents("php://input");
$update = json_decode($content, true);

// Exemplo: Responde a comandos
if (isset($update["message"]["text"])) {
    $chatId = $update["message"]["chat"]["id"];
    $text = $update["message"]["text"];

    if ($text === "/start") {
        file_get_contents("https://api.telegram.org/bot" . getenv('TELEGRAM_API') . "/sendMessage?chat_id=$chatId&text=Bem-vindo ao assistente!");
    }
}