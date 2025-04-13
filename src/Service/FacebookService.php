<?php

namespace SH\Service;
class FacebookService
{
    public function postMessage($pageId, $token, $message, $link = null)
    {
        // Endpoint para postar na página
        $url = "https://graph.facebook.com/v17.0/" . $pageId . "/feed";

        // Dados da postagem
        $data = [
            'message' => $message,
            'access_token' => $token,
        ];

        if ($link) {
            $data['link'] = $link;
        }


        // Realizza o cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['id'])) {
            return [
                'status' => 'success',
                'message' => 'Post publicado com sucesso.',
                'post_id' => $result['id']
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Erro ao publicar no Facebook.',
                'details' => $result
            ];
    }
