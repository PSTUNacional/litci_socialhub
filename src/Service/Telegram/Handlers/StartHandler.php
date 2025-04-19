<?php

namespace SH\Service\Telegram\Handlers;

class StartHandler
{
    public function handle(Message $message): void
    {
        $text = "Bem-vindo ao assistente!";
        $message->reply($text);

        $keyboard = [
            'keyboard' => [
                [['text' => 'Opção 1'], ['text' => 'Opção 2']],
                [['text' => 'Opção 3'], ['text' => 'Opção 4']],
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ];
        $message->sendMessage($message->getChatId(), $text, null, null, $keyboard);
    }
}