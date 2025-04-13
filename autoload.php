<?php

if (!defined('ENV_LOADED')) {
    define('ENV_LOADED', true);

    $dotenvPath = __DIR__ . '/src/Config/.env';

    if (!file_exists($dotenvPath)) {
        die('Arquivo .env não encontrado.');
    }

    $lines = file($dotenvPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#')) {
            continue; // Ignora linhas vazias e comentários
        }

        if (!str_contains($line, '=')) {
            continue; // Ignora linhas inválidas
        }

        [$name, $value] = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value, " \t\n\r\0\x0B\"'");

        // Define as variáveis no ambiente
        putenv("$name=$value");
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }
}



spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class);
    $path = str_replace('SH', '', $path);
    $path = $_SERVER['DOCUMENT_ROOT'] . '/src' . $path . '.php';
    require_once realpath($path);
});

function get_component($component)
{
    include($_SERVER['DOCUMENT_ROOT'] . '/views/components/' . $component . '.php');
}

function formatDate($rawdate, $showTime = false)
{
    $monthList = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dez"];
    $date = strtotime($rawdate);
    $year = date('Y', $date);
    $month = $monthList[date('n', $date) - 1];
    $day = date('d', $date);
    $time = date('H:i', $date);

    if ($showTime == true) {
        $result = "$month $day of $year, $time";
    } else {
        $result = "$month $day of $year";
    }

    return $result;
}

function renderTablePagination($totalResults, $perPage, $page)
{

    $totalPages = ceil($totalResults / $perPage);

    if ($page != 1) {
        $previous = $page - 1;
        echo '<button data-page="1"><i class="material-icons">first_page</i></button>';
        echo '<button data-page="' . $previous . '"><i class="material-icons">chevron_left</i></button>';
    }

    if ($totalPages <= 6) {
        for ($i = 0; $i < $totalPages; $i++) {
            $p = $i + 1;
            $isCurrent = ($p == $page) ? 'active' : '';
            echo '<button data-page="' . $p . '" class="' . $isCurrent . '">' . $p . '</button>';
        }
    } elseif ($totalPages > 6 && $page <= 3) {
        for ($i = 0; $i < ($page + 3); $i++) {
            $p = $i + 1;
            $isCurrent = ($p == $page) ? 'active' : '';
            echo '<button data-page="' . $p . '" class="' . $isCurrent . '">' . $p . '</button>';
        }
        echo '<span> ... </span>';
    } elseif ($totalPages > 6 && $page > 3 && $page < ($totalPages - 2)) {
        echo '<span> ... </span>';
        for ($i = ($page - 3); $i < ($page + 2); $i++) {
            $p = $i + 1;
            $isCurrent = ($p == $page) ? 'active' : '';
            echo '<button data-page="' . $p . '" class="' . $isCurrent . '">' . $p . '</button>';
        }
        echo '<span> ... </span>';
    } elseif ($totalPages > 6 && $page > 3 && $page >= ($totalPages - 2)) {
        echo '<span> ... </span>';
        for ($i = ($page - 5); $i < $totalPages; $i++) {
            $p = $i + 1;
            $isCurrent = ($p == $page) ? 'active' : '';
            echo '<button data-page="' . $p . '" class="' . $isCurrent . '">' . $p . '</button>';
        }
    }

    if ($page != $totalPages) {
        $next = $page + 1;
        echo '<button data-page="' . $next . '"><i class="material-icons">chevron_right</i></button>';
        echo '<button data-page="' . $totalPages . '"><i class="material-icons">last_page</i></button>';
    }
}

function renderLanguageIcon($langId)
{
    $icon = '';
    switch ($langId) {
        case 1:
            $icon = '<span class="fi fi-gb fis"></span>';
            break;
        case 2:
            $icon = '<span class="fi fi-es fis" aria-label="Spanish"></span>';
            break;
        case 3:
            $icon = '<span class="fi fi-br fis"></span>';
            break;
        case 4:
            $icon = '<span class="fi fi-fr fis"></span>';
            break;
        case 5:
            $icons = '<span class="fi fi-de fis"></span>';
            break;
        case 6:
            $icons = '<span class="fi fi-ru fis"></span>';
            break;
        case 7:
            $icons = '<span class="fi fi-ua fis"></span>';
            break;
        case 8:
            $icons = '<span class="fi fi-ps fis"></span>';
            break;
    }
    return $icon;
}
