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
            "model" => "gpt-4.1-mini",
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

    public function createCarousel($url)
    {
        $prompt = <<<PROMPT
                    Quero criar um carrossel para Instagram baseado em um texto que vou fornecer. O carrossel deve ter a seguinte estrutura detalhada para cada slide:

                    Slide 1: Capa Impactante
                    Chapéu/Editoria: Uma única palavra.
                    Título: Com 3 a 7 palavras, curto e impactante.
                    Parágrafo: Curto, introduzindo e cativando o interesse do usuário.

                    Slide 2: Introdução Chamativa
                    Chapéu: Uma única palavra.
                    Título: Com 3 a 7 palavras.
                    Parágrafo: Desenvolvendo a introdução do assunto com aproximadamente 270 caracteres.

                    Slide 3: Contexto - Parte 1
                    Chapéu: Uma única palavra.
                    Parágrafo: Adicionando contexto ao conteúdo com aproximadamente 270 caracteres.

                    Slide 4: Contexto - Parte 2
                    Título: Com 3 a 7 palavras.
                    Parágrafo: Curtíssimo, complementando o contexto com aproximadamente 150 caracteres.

                    Slide 5: (Reservado)
                    Este slide será deixado em branco ou aguardando instruções futuras sobre seu conteúdo.

                    Slide 6: Conteúdo Principal - Parte 1
                    Chapéu: Uma única palavra.
                    Título: Com 3 a 7 palavras.
                    Parágrafo: Apresentando o cerne da discussão, a parte mais forte do texto com aproximadamente 270 caracteres.

                    Slide 7: Conteúdo Principal - Parte 2
                    Chapéu: Uma única palavra.
                    Parágrafo: Concluindo a discussão principal com um texto direto com aproximadamente 270 caracteres.

                    Slide 8: Conclusão/Chamada
                    Chapéu: Uma única palavra.
                    Título: Com 3 a 7 palavras.
                    Parágrafo: Sumarizando ou preparando para a frase de impacto com aproximadamente 270 caracteres.

                    Slide 9 (ou Último Slide):
                    Frase de Impacto Uma frase final de impacto para fechamento.

                    O tom do carrossel deve ser crítico, informativo e polêmico, alinhado com um público de 18 a 35 anos, com baixa formação acadêmica, mas interessado em política e questões contemporâneas. O conteúdo deve evitar ser meramente conjuntural e focar em debates estratégicos e estruturais. 

                    Retorne estritamente um JSON contendo os slides na seguinte forma:
                    slide1: {
                        headline: string ou null se for vazio,
                        title: string ou null se for vazio,
                        paragraph: 'string ou null se for vazio
                    }

                    Aqui está o texto base para o carrossel: $url
        PROMPT;

        $response = $this->chatWithGpt($prompt);
        $content = $response['choices'][0]['message']['content'];

        if (!isset($content)) {
            throw new Exception("Resposta inesperada da OpenAI.");
        }
        
        return $content;
       
    }
}
