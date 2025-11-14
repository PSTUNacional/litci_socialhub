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

    public function createCarousel($url, $language)
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
                    Chapéu: Uma única palavra.
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
                    Título: o título original da matéria
                    Parágrafo: Frase de Impacto Uma frase final de impacto para fechamento.

                    O tom do carrossel deve ser crítico, informativo e polêmico, alinhado com um público de 18 a 35 anos, com baixa formação acadêmica, mas interessado em política e questões contemporâneas. O conteúdo deve evitar ser meramente conjuntural e focar em debates estratégicos e estruturais. 

                    O texto deve ser escrito em $language

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

    public function createOpenCarousel($content, $format, $language)
    {

        $formatMap = [
            'conjuncture' => <<<PRODUCT
                                Este carrossel deve capturar a atenção do público a partir de uma análise mais geral da realidade, e tentar convencer ele da nossa posição que está no texto do site lá em baixo.
                                slide1: Exposição direta da tese,
                                slide2: Explicar detalhes da nossa tese,
                                slide3, 4 e 5: Cada slide tem um elemento da conjuntura, entre os mais importantes, que sustenta a nossa tese,
                                slide6: Deixar em branco é só um CTA de engajamento,
                                slide7: Todo texto se contrapõe a outro, ainda que de forma velada, então traga a visão que estamos nos diferenciando e explique por que ela está errada,
                                slide8: Exposição direta da nossa conclusão sobre a conjuntura,
                                slide9: Aqui, queremos aguçar uma curiosidade mais profunda no leitor que só se resolve lendo o texto no site.
                                PRODUCT,

            'process' => <<<PRODUCT
                                Este carrossel deve capturar a atenção do público sobre uma pauta quente do momento e tentar convencer ele da nossa posição que está no texto do site lá em baixo.
                                slide1: Exposição direta de qual o fato que mudou o processo que estamos lidando,
                                slide2: Explicar melhor exatamente o que aconteceu e sobre o quê estamos nos posicionando,
                                slide3, 4 e 5: Cada slide tem um elemento do processo analisado que sustenta a nossa conclusão,
                                slide6: Deixar em branco é só um CTA de engajamento,
                                slide7: Todo texto se contrapõe a outro, ainda que de forma velada, então traga a visão que estamos nos diferenciando e explique por que ela está errada,
                                slide8: Exposição direta da nossa conclusão,
                                slide9: Aqui, queremos aguçar uma curiosidade mais profunda no leitor que só se resolve lendo o texto no site.
                                PRODUCT,
            'history' => <<<PRODUCT
                                Este carrossel deve capturar a atenção do público a partir de um fato histórico que possui um paralelo com o debate da nossa conjuntura. Se o texto do site já não estiver nesse formato, então haverá um texto adicional que ajudará a pensar esse paralelo.
                                slide1: Exposição direta de qual o fato da história estamos lidando,
                                slide2: Explicar melhor exatamente o que ocorreu no passado e qual lição estamos querendo extrair dele,
                                slide3, 4 e 5: Cada slide tem um elemento da história que sustenta a nossa conclusão,
                                slide6: Deixar em branco é só um CTA de engajamento,
                                slide7: Exposição direta da nossa conclusão sobre o fato histórico,
                                slide8: Paralelo com o presente, mostrando que nossa conclusão reforça (ou contradiz) o que está acontecendo,
                                slide9: Aqui, queremos aguçar uma curiosidade mais profunda no leitor que só se resolve lendo o texto no site.
                                PRODUCT,
            'polemic' => <<<PRODUCT
                                Este carrossel deve capturar a atenção do público a partir de uma polêmica com outra organização. Essa polêmica pode ser de divergência na política conjuntural, no programa ou na teoria. Se o texto do site já não estiver nesse formato, então haverá um texto adicional que ajudará a pensar esse paralelo.
                                slide1: Exposição direta de qual a tese que estamos combatendo,
                                slide2: Explicar melhor qual é essa tese deixando claro que somos contra,
                                slide3, 4 e 5: Cada slide tem um argumento que sustenta a tese que consideramos errada, e nossa resposta a cada um deles,
                                slide6: Deixar em branco é só um CTA de engajamento,
                                slide7: Exposição direta de por que essa tese está errada, segundo a argumentação,
                                slide8: Exposição da nossa tese alternativa a esse erro,
                                slide9: Aqui, queremos aguçar uma curiosidade mais profunda no leitor que só se resolve lendo o texto no site.
                                PRODUCT,

            'news' => <<<PRODUCT
                                Este carrossel deve capturar a atenção do público a partir de uma notícia que reforça uma análise feita em nosso site. Ao final, além do texto no site que contém a nossa análise, haverá um texto adicional com a notícia que devemos expor no carrossel.
                                slide1: Manchete,
                                slide2: Lide,
                                slide3, 4 e 5: Cada slide tem um elemento de contexto, ou seja, outros fatos, que ajudam a dar sentido para a nossa notícia,
                                slide6: Deixar em branco é só um CTA de engajamento,
                                slide7: Reforço da nossa análise presente no texto do site,
                                slide8: Reflexão que estimula a audiência a se fazer perguntas mais profundas,
                                slide9: Aqui, queremos amarrar essa curiosidade mais profunda do leitor, indicando o texto do site que a resolve.
                                PRODUCT,
        ];

        $formatFinal = $formatMap[$format];

        $prompt = <<<PROMPT
                    Objetivo
                    Você vai criar um roteiro para carrossel do Instagram com base nos textos ao final. A ideia é capturar a atenção da audiência e despertar uma curiosidade mais profunda sobre a discussão no leitor, gerando a vontade de ir ao site ler o nosso texto completo. O roteiro deve ser escrito em $language

                    ---

                    Formato
                    Retorne estritamente um JSON contendo os slides na seguinte forma:
                    {
                    "slide1": {
                        "headline": "{{Uma única palavra}}",
                        "title": "{{Título com 3 a 7 palavras, curto e impactante}}",
                        "paragraph": "{{Parágrafo curto, introduzindo e cativando o interesse do usuário}}"
                    },
                    "slide2": {
                        "headline": "{{Uma única palavra}}",
                        "title": "{{Título com 3 a 7 palavras}}",
                        "paragraph": "{{Introdução do assunto com aproximadamente 270 caracteres}}"
                    },
                    "slide3": {
                        "headline": "{{Uma única palavra}}",
                        "title": null,
                        "paragraph": "{{Aproximadamente 270 caracteres}}"
                    },
                    "slide4": {
                        "headline": "{{Uma única palavra}}",
                        "title": "{{Título com 3 a 7 palavras}}",
                        "paragraph": "{{Parágrafo curtíssimo, aproximadamente 150 caracteres}}"
                    },
                    "slide5": {
                        "headline": "{{Uma única palavra}}",
                        "title": "{{Título com 3 a 7 palavras}}",
                        "paragraph": "{{Aproximadamente 270 caracteres}}"
                    },
                    "slide6": {
                        "headline": null,
                        "title": null,
                        "paragraph": null
                    },
                    "slide7": {
                        "headline": "{{Uma única palavra}}",
                        "title": null,
                        "paragraph": "{{Aproximadamente 270 caracteres}}"
                    },
                    "slide8": {
                        "headline": "{{Uma única palavra}}",
                        "title": "{{Título com 3 a 7 palavras}}",
                        "paragraph": "{{Aproximadamente 270 caracteres}}"
                    },
                    "slide9": {
                        "headline": null,
                        "title": "{{Use aqui o título da matéria do site}}",
                        "paragraph": "{{Escreva uma frase final de impacto para fechamento}}"
                    }
                    }

                    Os slides devem conter o seguinte conteúdo:

                    $formatFinal

                    ---

                    Aviso
                    O tom do carrossel deve ser crítico, informativo e polêmico, alinhado com um público de 18 a 35 anos, com baixa formação acadêmica, mas interessado em política e questões contemporâneas e internacionais.

                    ---

                    Contexto
                    Aqui está o texto do site para o carrossel: $content
                PROMPT;

        $response = $this->chatWithGpt($prompt);
        $content = $response['choices'][0]['message']['content'];

        if (!isset($content)) {
            throw new Exception("Resposta inesperada da OpenAI.");
        }

        return $content;
    }

    public function translateCarousel($content, $language)
    {
        $prompt = <<<PROMPT
            Translate this JSON to $language.
            Return only the new JSON;

            JSON to translate:
            $content
            PROMPT;

        $response = $this->chatWithGpt($prompt);
        $content = $response['choices'][0]['message']['content'];

        if (!isset($content)) {
            throw new Exception("Resposta inesperada da OpenAI.");
        }

        return $content;
    }
}
