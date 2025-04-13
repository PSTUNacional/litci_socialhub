<?php

namespace SH\Service;

class InstagramService
{
    public function postBanner(
        $pageId,
        $token,
        $message,
        $imageUrl
    ) {
        // Passo 1: Criar o container
        $mediaUrl = "https://graph.facebook.com/v17.0/{$pageId}/media";

        $mediaData = [
            'image_url' => $imageUrl,
            'caption' => $message,
            'access_token' => $token,
        ];

        $mediaId = null;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $mediaUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($mediaData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['id'])) {
            $mediaId = $result['id'];
            echo "Container criado: $mediaId\n";
        } else {
            echo "Erro ao criar container:\n";
            print_r($result);
            exit;
        }

        // Passo 2: Publicar o post no feed
        $publishUrl = "https://graph.facebook.com/v17.0/{$pageId}/media_publish";

        $publishData = [
            'creation_id' => $mediaId,
            'access_token' => $token,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $publishUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($publishData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (!isset($result['id'])) {
            return [
                'status' => 'error',
                'message' => 'Erro ao publicar o post.',
                'details' => $result
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Post publicado com sucesso.',
            'post_id' => $result['id']
        ];
    }
}
