<?php

include($_SERVER['DOCUMENT_ROOT'] . '/autoload.php');

get_component('header');
?>
<link rel="stylesheet" href="/assets/css/post.css">
</head>

<body>
    <?php get_component('nav'); ?>

    <main>
        <div id="modal-container">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/views/components/autopost-modal.php'); ?>
        </div>
        <div class="page-header">
            <h1>Banner Generator</h1>
        </div>

        <section class="main-container">
            <!--Menu-->
            <div class="container card sidemenu">
                <div class="column">
                    <h3 class="section-header">Select a post</h3>
                    <form action="" class="bulletin-generator" style="margin:0">
                        <h4 class="form-section-header">Select a source</h4>
                        <select name="" id="sourceSelector">
                            <option value="es">Spanish</option>
                            <option value="pt">Portuguese</option>
                        </select>

                        <h4 class="form-section-header">Select a post</h4>
                        <select name="" id="postSelector"></select>
                    </form>
                </div>
            </div>
            <section class="content card container">
                <div class="column va-top">
                    <div class="banner-result">
                        <div id="bannerOnePlace">
                            <h4>Select a post to render a banner =)</h4>
                        </div>
                        <div id="bannerFourPlace">
                            <h4>Select a post to render a banner =)</h4>
                        </div>
                        <div id="storyPlace">
                            <h4>Select a post to render a banner =)</h4>
                        </div>
                    </div>
                </div>
                <div class="column va-top">
                    <div class="autopost" style="display:none">
                        <h4>Automatic post in social media?</h4>
                        <button type="button" class="button primary" onclick="autoPostStart()">Auto-post</button>
                    </div>
                    <h3 class="section-header">Banner</h3>
                    <div style="display:flex; gap:12px;">
                        <button class="button secondary" type="button" onclick="download('bannerOnePlace', 'LIT-Banner-Square')">Banner 1:1</button>
                        <button class="button secondary" type="button" onclick="download('bannerFourPlace', 'LIT-Banner-FourByFive')">Banner 4:5</button>
                        <button class="button secondary" type="button" onclick="download('storyPlace', 'LIT-Story')">Story</button>
                    </div>
                    <h3 class="section-header">Excerpt <span class="info">Click to copy</span></h3>
                    <div class="text-item active">
                        <div id="text" class="light-card" onclick="copyToClipboard(event)">Generating text...</div>
                    </div>
                    <h3 class="section-header">Short Links <span class="info">Click to copy</span></h3>
                    <div class="link-item active">
                        <div id="links-grid">
                        <button type="button" data-target="all" class="light-card">All links</button>
                        <button type="button" data-target="whatsapp-channel" class="light-card">WhatsApp Channel</button>
                        <button type="button" data-target="instagram-story" class="light-card">Instagram Story</button>
                        <button type="button" data-target="facebook-post" class="light-card">Facebook Post</button>
                        <button type="button" data-target="facebook-story" class="light-card">Facebook Story</button>
                        <button type="button" data-target="twitter-post" class="light-card">Twitter</button>
                        <button type="button" data-target="telegram-channel" class="light-card">Telegram Channel</button>
                        </div>
                        <div id="all" class="link-item" >Generating link...</div>
                        <div id="whatsapp-channel" class="link-item" ></div>
                        <div id="instagram-story" class="link-item" ></div>
                        <div id="facebook-post" class="link-item" ></div>
                        <div id="facebook-story" class="link-item" ></div>
                        <div id="twitter-post" class="link-item" ></div>
                        <div id="telegram-channel" class="link-item" ></div>
                    </div>
                </div>
            </section>
        </section>
    </main>

    <div id="hidden">
        <div id="bannerOne">
            <img src="../assets/img/logo_white_shadow.png" alt="" class="lit-logo">
            <div alt="" class="picture-container"></div>
            <div class="safearea">
                <div class="catbadge"></div>
                <h1 class="banner-title"></h1>
                <p>Leia em <b>litci.org</b></p>
            </div>
        </div>
        <div id="bannerFour">
            <img src="../assets/img/logo_white_shadow.png" alt="" class="lit-logo">
            <div alt="" class="picture-container"></div>
            <div class="safearea">
                <div class="catbadge"></div>
                <h1 class="banner-title"></h1>
                <p>Leia em <b>litci.org</b></p>
            </div>
        </div>
        <div id="story">
            <img src="../assets/img/logo_white_shadow.png" alt="" class="lit-logo">
            <div alt="" class="picture-container"></div>
            <div class="safearea">
                <div class="catbadge"></div>
                <h1 class="banner-title"></h1>
                <p>Leia em <b>litci.org</b></p>
            </div>
        </div>
    </div>

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="/assets/js/posts.js"></script>
    <script src="/assets/js/autopost-modal.js"></script>
</body>