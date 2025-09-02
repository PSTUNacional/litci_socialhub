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
            <div class="card" style="height:fit-content; display:flex; flex-direction: column; gap:var(--gap)">
                <form action="" class="carousel-generator" style="margin:0">
                    <h4 class="form-section-header">Select a source</h4>
                    <select name="" id="sourceSelector">
                        <option value="es">Spanish</option>
                        <option value="pt">Portuguese</option>
                    </select>
                    <h4 class="form-section-header">Select a post</h4>
                    <select name="" id="postSelector"></select>
                </form>
                <div class="hue-selector">
                    <div class="hue-option">
                        <input type="radio" id="hue0" name="hue" value="0" checked>
                        <label for="hue0" style="background-color: hsl(0, 70%, 50%);"></label>
                    </div>
                    <div class="hue-option">
                        <input type="radio" id="hue40" name="hue" value="40">
                        <label for="hue40" style="background-color: hsl(40, 70%, 50%);"></label>
                    </div>
                    <div class="hue-option">
                        <input type="radio" id="hue80" name="hue" value="80">
                        <label for="hue80" style="background-color: hsl(80, 70%, 50%);"></label>
                    </div>
                    <div class="hue-option">
                        <input type="radio" id="hue120" name="hue" value="120">
                        <label for="hue120" style="background-color: hsl(120, 70%, 40%);"></label>
                    </div>
                    <div class="hue-option">
                        <input type="radio" id="hue160" name="hue" value="160">
                        <label for="hue160" style="background-color: hsl(160, 70%, 50%);"></label>
                    </div>
                    <div class="hue-option">
                        <input type="radio" id="hue200" name="hue" value="200">
                        <label for="hue200" style="background-color: hsl(200, 70%, 50%);"></label>
                    </div>
                    <div class="hue-option">
                        <input type="radio" id="hue240" name="hue" value="240">
                        <label for="hue240" style="background-color: hsl(240, 70%, 50%);"></label>
                    </div>
                    <div class="hue-option">
                        <input type="radio" id="hue280" name="hue" value="280">
                        <label for="hue280" style="background-color: hsl(280, 70%, 50%);"></label>
                    </div>
                    <div class="hue-option">
                        <input type="radio" id="hue320" name="hue" value="320">
                        <label for="hue320" style="background-color: hsl(320, 70%, 50%);"></label>
                    </div>
                </div>
                <div style="display:flex; gap: var(--gap-medium); flex-direction: row;">
                    <button class="button primary" role="button" onclick="renderCarousel()">Generate</button>
                    <button class="button secondary" role="button" id="downloadAllBtn">Download All</button>
                </div>
            </div>
            <div id="carousel-container">
            </div>
        </div>
    </main>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src='./assets/js/carousel.js'></script>
</body>