<?php

include($_SERVER['DOCUMENT_ROOT'] . '/autoload.php');

use SH\Service\BulletinService;

$bulletin = new BulletinService;


// Verify if parameter exists
if (!isset($_GET['method']) || !isset($_GET['source'])) {

    http_response_code(400);
    echo json_encode([
        "error" => "Bad Request",
        "message" => "One or more parameters are missing."
    ]);
    exit; // Termina o script
}

$method = $_GET['method'];
$source = $_GET['source'];

switch ($source) {
    case "es":
        $result = $bulletin->getBulletinEs($method);
        break;
    case 'pt':
        $result = $bulletin->getBulletinPt($method);
        break;
    case 'en':
        $result = $bulletin->getBulletinEn($method);
        break;
    case 'cr':
        $result = $bulletin->getBulletinCostaRica($method);
        break;
    case 'cl':
        $result = $bulletin->getBulletinColombia($method);
        break;
    case 'ar':
        $result = $bulletin->getBulletinArgentina($method);
        break;
    case 'ch':
        $result = $bulletin->getBulletinChile($method);
        break;
    case 'esp':
        $result = $bulletin->getBulletinSpain($method);
        break;
}

header('Content-Type: application/json');
echo $result;
