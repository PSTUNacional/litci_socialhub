<?php
$routes = [
    'banners'    => 'views/banner.php',
    'bulletins'  => 'views/bulletin.php',
    'carousels'  => 'views/carousel/index.php',
    'texts'      => 'views/text.php',
    'links'      => 'views/link.php',
    'posts'      => 'views/post.php',
    ''           => 'views/bulletin.php'
];

// Lista de identificadores para múltiplos sites (ex: pt, es, site1, site2, site3)
$multiSiteRoutes = ['pt', 'es', 'site1', 'site2', 'site3'];

/**
 * Gera a URL de redirecionamento para a rota /post com os parâmetros site e slug.
 *
 * @param string $site Identificador do site.
 * @param string $slug Slug extraído da URL.
 * @return string URL de redirecionamento.
 */
function generatePostsUrl($site, $slug) {
    return "/posts?site=" . urlencode($site) . "&slug=" . urlencode($slug);
}

// Primeiro, separamos a URL dos parâmetros da query
$uri = $_SERVER['REQUEST_URI'];
$partsUri = explode('?', $uri);
$cleanUri = $partsUri[0];

// Remove barras extras do início e fim da URL
$path = trim($cleanUri, '/');

// Divide o caminho pelos '/'
$pathParts = array_values(array_filter(explode('/', $path)));

// Se o primeiro segmento for um dos identificadores dos sites
if (isset($pathParts[0]) && in_array($pathParts[0], $multiSiteRoutes)) {
    $site = $pathParts[0];
    // Seleciona apenas o último segmento do caminho como slug
    $slug = end($pathParts);
    
    // Redireciona diretamente para /post usando a função geradora de URL
    header("Location: " . generatePostsUrl($site, $slug));
    exit;
}

// Roteamento normal para os demais casos
if (file_exists($path) || !array_key_exists($path, $routes)) {
    http_response_code(404);
    include 'views/404.php';
    exit;
}

include $routes[$path];