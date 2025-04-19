<?php

include($_SERVER['DOCUMENT_ROOT'] . '/autoload.php');

use SH\Service\Telegram\TelegramService;

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if ($update) {
    $dispatcher = new TelegramService();
    $dispatcher->dispatch($update);
}
