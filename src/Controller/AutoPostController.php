<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/autoload.php');

use SH\Service\InstagramService;
use SH\Service\FacebookService;

$facebook = new FacebookService();
$instagram = new InstagramService();

// Captura dados do POST
$caption = $_POST['caption'] ?? null;
if (!$caption) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Legenda é obrigatória.'
    ]);
    exit;
}

$link = $_POST['link'] ?? null;
if (!$link) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Link é obrigatório.'
    ]);
    exit;
}

$account = $_POST['account'] ?? null;
if (!$account) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Conta é obrigatória.'
    ]);
    exit;
}

$publishToFacebook = $_POST['facebook'] ?? false;
$publishToInstagram = $_POST['instagram'] ?? false;

// Banner to post
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$path = '/src/Temp/bannerToPost.png';
$imageUrl = $protocol . $host . $path;

// Env
if($account == 'es') {
    $facebookPageId = getenv('FBPAGE_ID_ES');
    $instagramPageId = getenv('IGPAGE_ID_ES');
    $token = getenv('TOKEN_ES');
}

if($account == 'pt')
{
    $facebookPageId = getenv('FBPAGE_ID_PT');
    $instagramPageId = getenv('IGPAGE_ID_PT');
    $token = getenv('TOKEN_PT');
}

// Inicializa respostas
$response = [
    'facebook' => null,
    'instagram' => null,
];

if ($publishToFacebook == 'true') {
    $response['facebook'] = $facebook->postMessage($facebookPageId, $token, $caption, $link);
}

if ($publishToInstagram == 'true') {
    $response['instagram'] = $instagram->postBanner($instagramPageId, $token, $caption, $imageUrl);
}

echo json_encode($response);
