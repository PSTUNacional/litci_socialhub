<?php

namespace SH\Service;

class OpenAiService
{
    private $apiKey;

    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey ?? getenv('OPENAI_API_KEY');

        if (!$this->apiKey) {
            throw new Exception("API key da OpenAI não definida.");
        }
    }

    public function createCaption($url, $language = 'spanish')
    {

        $prompt = "The following is a prompt for generating social media captions intended for a politically aware and critical audience, focusing on international affairs and geopolitical analysis.
        
        Based on the text provided, write 3 caption suggestions for Facebook or Instagram posts. The tone must be serious and informative, suitable for a political bulletin. Avoid exaggerations, sensationalist phrasing, or clickbait. Each caption must be up to 2000 characters and maintain objectivity.
        
        The captions should be in $language.

        Do not add the link on caption. 
        Return only an array with the results, nothing else.
        
        Base text:\n\n
        $url";

        $response = $this->chatWithGpt($prompt);

        if (!isset($response['choices'][0]['message']['content'])) {
            throw new Exception("Resposta inesperada da OpenAI.");
        }

        return $response['choices'][0]['message']['content'];
    }

    private function chatWithGpt($prompt)
    {
        $endpoint = "https://api.openai.com/v1/chat/completions";

        $postData = [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                ["role" => "system", "content" => "Você é um especialista em redes sociais."],
                ["role" => "user", "content" => $prompt],
            ],
            "temperature" => 0.7,
            "max_tokens" => 4000,
        ];

        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer " . $this->apiKey,
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
