<?php

namespace SH\Service\Telegram\Handlers;

class Message
{

    private string $apiToken;

    public function __construct(private ?array $update = null)
    {
        $this->apiToken = getenv('TELEGRAM_API');

        if (!$this->apiToken) {
            throw new \RuntimeException('TELEGRAM_API not set in environment variables');
        }
    }

    public function getChatId(): int
    {
        return $this->update['message']['chat']['id'];
    }

    public function getText(): string
    {
        return $this->update['message']['text'] ?? '';
    }

    public function reply(string $text): void
    {
        file_get_contents("https://api.telegram.org/bot" . getenv('TELEGRAM_API') .
            "/sendMessage?chat_id=" . $this->getChatId() . "&text=" . urlencode($text));
    }

    /**
     * Envia uma mensagem para um chat específico
     * Pode incluir um link usando Markdown
     *
     * @param int|string $chatId ID do chat ou username (@usuario)
     * @param string $text Texto da mensagem
     * @param string|null $url Link a ser embutido (opcional)
     * @param string $label Texto clicável do link (opcional)
     * @return array Resposta da API do Telegram
     */
    public function sendMessage(int|string $chatId, string $text, ?string $url = null, ?string $label = 'Clique aqui', $keyboard = null): array
    {
        $urlApi = "https://api.telegram.org/bot{$this->apiToken}/sendMessage";

        if ($url) {
            $text .= " [{$label}]({$url})";
        }

        $data = [
            'chat_id'    => $chatId,
            'text'       => $text,
            'parse_mode' => $url ? 'Markdown' : null,
        ];

        if ($keyboard) {
            $data['reply_markup'] = json_encode($keyboard);
        }

        // Remover valores nulos
        $data = array_filter($data, fn($v) => $v !== null);

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($urlApi, false, $context);

        if ($result === false) {
            throw new \RuntimeException('Erro ao enviar mensagem para o Telegram');
        }

        return json_decode($result, true);
    }

    /**
     * Envia uma imagem (banner) com legenda para um chat específico
     *
     * @param int|string $chatId ID do chat ou username (@usuario)
     * @param string $imageUrl URL da imagem a ser enviada
     * @param string $caption Legenda da imagem
     * @return array Resposta da API do Telegram
     */
    public function sendImage(int|string $chatId, string $imageUrl, string $caption = ''): array
    {
        $url = "https://api.telegram.org/bot{$this->apiToken}/sendPhoto";

        $data = [
            'chat_id' => $chatId,
            'photo'   => $imageUrl,
            'caption' => $caption,
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === false) {
            throw new \RuntimeException('Erro ao enviar imagem para o Telegram');
        }

        return json_decode($result, true);
    }
}
