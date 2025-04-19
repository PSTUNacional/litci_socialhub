<?php

namespace SH\Service\Telegram ;

use SH\Service\Telegram\Handlers\Message;

class TelegramService
{

    public function sendMessage(int|string $chatId, string $text, ?string $url = null, string $label = 'Clique aqui'): array
    {
        $message = new Message();
        return $message->sendMessage($chatId, $text, $url, $label);
    }

    public function sendImage(int|string $chatId, string $imageUrl, string $caption = ''): array
    {
        $message = new Message();
        return $message->sendImage($chatId, $imageUrl, $caption);
    }

    /**
     * This is the decision tree handler
     */

    public function dispatch(array $update): void
    {
        $message = new Message($update);
        $text = $message->getText();

        switch(true){
            case str_starts_with($text, '/start'):
                (new Handlers\StartHandler())->handle($message);
                break;

            case str_starts_with($text, '/help'):
                $message->reply('Comandos disponíveis: /start, /help');
                break;

            default:
                $message->reply('Comando não reconhecido. Use /help para ver os comandos disponíveis.');
                break;
        }
    }
}
