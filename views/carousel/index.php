<?php
include($_SERVER['DOCUMENT_ROOT'] . '/autoload.php');
get_component('header');
?>
<link rel="stylesheet" href="./assets/css/carousel.css">
</head>

<body>
    <?php get_component('nav'); ?>
    <main>
        <div class="page-header">
            <h1>Carousel Generator</h1>
        </div>
        <div class="container" style="display:flex; flex-direction: column; gap:var(--gap)">
            <div class="card" style="height:fit-content">
                <form action="" class="carousel-generator" style="margin:0">
                    <h4 class="form-section-header">Select a source</h4>
                    <select name="" id="sourceSelector">
                        <option value="es">Spanish</option>
                        <option value="pt">Portuguese</option>
                    </select>
                    <h4 class="form-section-header">Select a post</h4>
                    <select name="" id="postSelector"></select>
                </form>
                <div style="display:flex; gap: var(--gap-medium); flex-direction: row; margin-top:var(--gap-large)">
                    <button class="button primary" role="button" onclick="renderCarousel()">Gerar carrossel</button>
                    <button class="button secondary" role="button" id="editText">Editar texto</button>
                </div>
            </div>
            <div id="carousel-container">
            </div>
        </div>
    </main>
    <script src='./assets/js/carousel.js'></script>
</body>