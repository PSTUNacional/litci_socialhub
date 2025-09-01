<?php

include($_SERVER['DOCUMENT_ROOT'] . '/autoload.php');

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if($update){
    $telegramService = new SH\Service\Telegram\TelegramService();
    $telegramService->dispatch($update);
}