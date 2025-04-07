<?php
$routes = [
    'banners' => 'views/banner.php',
    'bulletins' => 'views/bulletin.php',
    'texts' => 'views/text.php',
    'links' => 'views/link.php',
    'posts' => 'views/post.php',
    '' => 'views/bulletin.php'
];

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if (file_exists($path) || !array_key_exists($path, $routes)) {
    http_response_code(404);
    include 'views/404.php';
    exit;
}

include $routes[$path];
