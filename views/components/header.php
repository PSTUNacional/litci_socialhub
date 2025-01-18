<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:title" content="Social Hub | IWL-FI" />

    <?php
    if(ENV == 'dev')
    {
        ?>
        <link rel="stylesheet" href="/socialhub/assets/css/style.css">
        <?php
    } else {
        ?>
        <link rel="stylesheet" href="/assets/css/style.css">
        <?php
    }
    ?>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css" />