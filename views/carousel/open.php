<?php
include($_SERVER['DOCUMENT_ROOT'] . '/autoload.php');
get_component('header');
?>
<link rel="stylesheet" href="../../assets/css/opencarousel.css">
<style>
    .custom-confirm-button {
        background-color: var(--primary);
    }

    .custom-confirm-button:hover {
        background-color: var(--primary);
        outline: 4px solid var(--primary-50);
    }

    .custom-input-container{
        margin-top: 24px;
        margin-bottom: 24px;
    }

    .custom-input-container label span {
        padding: 8px 16px;
        border-radius: 4px;
        border: 1px solid var(--gray-200);
        cursor: pointer;
    }

    .custom-input-container label input:checked + span {
        padding: 8px 16px;
        border-radius: 4px;
        border: 1px solid var(--primary);
        color: var(--primary);
        background-color: var(--primary-10);
    }

    .custom-input-container label input {
        display: none;
    }
</style>
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
                    <h4 class="form-section-header">Insert the content (URL or Raw Text)</h4>
                    <textarea id="contentArea" rows=10 value="" style="resize:vertical"></textarea>
                    <h4 class="form-section-header">Select a language</h4>
                    <div class="radiobutton-selector">
                        <div>
                            <input type="radio" id="lang-pt" name="lang" value="portuguese" checked>
                            <label for="lang-pt">Portuguese</label>
                        </div>
                        <div>
                            <input type="radio" id="lang-es" name="lang" value="spanish">
                            <label for="lang-es">Spanish</label>
                        </div>
                        <div>
                            <input type="radio" id="lang-en" name="lang" value="english">
                            <label for="lang-en">English</label>
                        </div>
                    </div>
                    <h4 class="form-section-header">Select a Format</h4>
                    <div class="radiobutton-selector">
                        <div>
                            <input type="radio" id="format-a" name="format" value="conjuncture" checked>
                            <label for="format-a">Conjuncture</label>
                        </div>
                        <div>
                            <input type="radio" id="format-b" name="format" value="process">
                            <label for="format-b">Process</label>
                        </div>
                        <div>
                            <input type="radio" id="format-c" name="format" value="history">
                            <label for="format-c">History</label>
                        </div>
                        <div>
                            <input type="radio" id="format-d" name="format" value="polemic">
                            <label for="format-d">Polemic</label>
                        </div>
                        <div>
                            <input type="radio" id="format-e" name="format" value="news">
                            <label for="format-e">News</label>
                        </div>
                    </div>
                    <h4 class="form-section-header">Select a color</h4>
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
                </form>

                <div style="display:flex; gap: var(--gap-medium); flex-direction: row;">
                    <button class="button primary" role="button" onclick="renderCarousel()">Generate</button>
                    <button class="button secondary" role="button" id="downloadAllBtn">Download All</button>
                    <button class="button secondary" role="button" onclick="openTranslationModal()" id="downloadAllBtn">Translate</button>
                </div>
            </div>
            <div id="carousel-container">
            </div>
        </div>
    </main>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src='../../assets/js/open-carousel.js'></script>
</body>