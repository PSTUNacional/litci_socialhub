<?php
$url = $_GET['url'] ?? '';
if (!preg_match('#^https://litci\.org/#', $url)) {
    http_response_code(403);
    exit;
}
$image = file_get_contents($url);
header('Content-Type: image/jpeg');
header('Access-Control-Allow-Origin: *');
echo $image;