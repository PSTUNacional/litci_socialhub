<?php

namespace SH\Service\Telegram\Handlers;

class StartHandler
{
    public function handle(Message $message): void
    {
        $text = "Bem-vindo ao assistente!";
        $message->reply($text);

        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'Opção 1', 'callback_data' => '/boletim'],
                    ['text' => 'Opção 2', 'callback_data' => '/publicar'],
                ],
                [
                    ['text' => 'Opção 3', 'callback_data' => '/ajuda'],
                    ['text' => 'Opção 4', 'callback_data' => '/sobre'],
                ],
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ];
        $message->sendMessage($message->getChatId(), $text, null, null, $keyboard);
    }
}