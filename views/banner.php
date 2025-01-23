<?php

include($_SERVER['DOCUMENT_ROOT'] . '/autoload.php');

get_component('header');
?>
<style>
    #hidden {
        width: 0px;
        height: 0px;
        overflow: hidden;
    }

    #bannerOne,
    #bannerFour,
    #story {
        background-color: rgb(22, 23, 19);
        flex-direction: column;
        display: flex;
        color: #fff;
        font-family: sans-serif;
        font-size: 24px;
        line-height: 1.2;
        position: relative;
    }

    #bannerOne {
        width: 1080px;
        height: 1080px;
    }

    #bannerFour {
        width: 1080px;
        height: 1350px;
    }

    #story {
        width: 1080px;
        height: 1920px;
    }

    .lit-logo {
        position: absolute;
        top: 96px;
        left: 96px;
        z-index: 999;
        max-width: 96px;
    }

    #bannerOnePlace canvas,
    #bannerFourPlace canvas,
    #storyPlace canvas {
        max-width: 400px;
    }

    .safearea {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 24px;
        margin-top: -24px;
    }

    #bannerOne .safearea {
        padding: 0 96px 96px 96px;
    }

    #bannerFour .safearea {
        padding: 0 96px 96px 96px;
    }

    #story .safearea {
        padding: 0 96px 320px 96px;
    }

    .picture-container {
        width: 100%;
        height: 100%;
        display: block;
        max-height: 65%;
        border-radius: 0 0 48px 48px;
        background-size: cover;
        background-position: center;
    }

    .catbadge {
        background-color: #c00;
        padding: 8px 24px;
        font-weight: bold;
        border-radius: 8px;
        display: inline-block;
        width: fit-content;
    }

    .banner-title {
        font-size: 3em;
        color: #fff;
    }

    p {
        font-weight: 100;
        color: #fff9
    }

    p b {
        font-weight: 700;
        color: #fff;
    }

    #bannerOnePlace canvas,
    #bannerFourPlace canvas,
    #storyPlace canvas {
        max-width: 100%;
    }

    #bannerFourPlace,
    #storyPlace {
        display: none;
    }

    #bannerOnePlace h4,
    #bannerFourPlace h4,
    #storyPlace h4 {
        width: 400px;
        height: 400px;
        border-radius: 8px;
        background-color: var(--gray-100);
        color: var(--gray-300);
        text-align: center;
        justify-content: center;
        align-items: center;
        display: flex;
        padding: 24px;
        max-width: 100%;
    }

    .banner-result {
        display: flex;
        flex-direction: column;
        gap: var(--gap);
    }


    input,
    select {
        padding: 8px 12px;
        border-radius: 4px;
        background-color: #fff;
        border: 1px solid var(--gray-300);
    }

    .button {
        height: 40px;
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        outline: none;
        cursor: pointer;
    }

    .button.primary {
        background-color: var(--primary);
        color: #fff;
    }

    @media only screen and (max-width:720px) {
        #bannerPlace canvas {
            max-width: 100%;
        }
    }
</style>
</head>

<body>
    <?php get_component('nav'); ?>

    <main>
        <div class="page-header">
            <h1>Banner Generator</h1>
        </div>
        <div class="container">
            <div class="card sidemenu">
                <form action="" class="bulletin-generator" style="margin:0">
                    <label for="">Select a source</label>
                    <select name="" id="sourceSelector">
                        <option value="pt">Portuguese</option>
                        <option value="es">Spanish</option>
                    </select>

                    <h4 class="form-section-header">Select a post</h4>
                    <select name="" id="postSelector"></select>
                </form>
            </div>
            <div class="card banner-result">
                <div id="bannerOnePlace">
                    <h4>Select a post to render a banner =)</h4>
                </div>
                <div id="bannerFourPlace">
                    <h4>Select a post to render a banner =)</h4>
                </div>
                <div id="storyPlace">
                    <h4>Select a post to render a banner =)</h4>
                </div>
                <div style="display:flex; gap:12px;">
                    <button class="button primary" type="button" onclick="download('bannerOnePlace', 'LIT-Banner-Square')">Banner 1:1</button>
                    <button class="button primary" type="button" onclick="download('bannerFourPlace', 'LIT-Banner-FourByFive')">Banner 4:5</button>
                    <button class="button primary" type="button" onclick="download('storyPlace', 'LIT-Story')">Story</button>
                </div>
            </div>
        </div>
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

    </main>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script>
        const bannerPlace = document.getElementById('bannerPlace');
        let source = 'pt';
        let cta = 'Leia em <b>litci.org</b>';

        // Atualiza a fonte selecionada
        document.getElementById('sourceSelector').addEventListener('change', (e) => {
            source = e.target.value;
            fetchPosts();
        });

        async function fetchPosts() {
            const api = getApiSource(source);
            const posts = await fetch(api).then(response => response.json());
            const postlist = document.getElementById('postSelector');
            postlist.innerHTML = '';

            posts.forEach(post => {
                const opt = document.createElement('option');
                opt.value = post.id;
                opt.innerText = post.title.rendered;
                postlist.appendChild(opt);
            });

            postlist.addEventListener('change', (e) => renderBanner(e.target.value));
            renderBanner(postlist.value);
        }

        function getApiSource(source) {
            switch (source) {
                case 'es':
                    cta = 'Lea en <b>litci.org/es</b>';
                    return 'https://litci.org/es/wp-json/wp/v2/posts';
                case 'pt':
                default:
                    cta = 'Leia em <b>litci.org/pt</b>';
                    return 'https://litci.org/pt/wp-json/wp/v2/posts';
            }
        }

        async function renderBanner(id) {
            const postApi = `${getApiSource(source)}?include=${id}`;
            const banners = await fetch(postApi).then(response => response.json());
            const banner = banners[0];

            const places = ['bannerOne', 'bannerFour', 'story'].map(id => document.getElementById(id));
            places.forEach(place => {
                const img = place.querySelector('.picture-container');
                img.style.backgroundImage = `url(${banner.fimg_url})`;

                const category = banner.categories_names[0] === 'Destacado' ? banner.categories_names[1] : banner.categories_names[0];
                place.querySelector('.catbadge').innerHTML = category;

                const title = place.querySelector('.banner-title');
                title.innerHTML = banner.title.rendered;

                const minHeight = 200;
                const maxHeight = 280;
                let fontSize = 72;
                adjustFontSize(title, fontSize, minHeight, maxHeight);
            });

            ['bannerOne', 'bannerFour', 'story'].forEach((source, index) => {
                createImage(source, `${source}Place`, index === 2 ? 1080 : 1350, 1080);
            });
        }

        function adjustFontSize(element, fontSize, minHeight, maxHeight) {
            while (element.offsetHeight < minHeight && fontSize < 100) {
                fontSize++;
                element.style.fontSize = `${fontSize}px`;
            }
            while (element.offsetHeight > maxHeight && fontSize > 30) {
                fontSize--;
                element.style.fontSize = `${fontSize}px`;
            }
        }

        function createImage(source, target, w, h) {
            html2canvas(document.getElementById(source), {
                allowTaint: true,
                useCORS: true,
                width: w,
                height: h,
                scale: 1
            }).then(canvas => {
                const targetElement = document.getElementById(target);
                targetElement.innerHTML = '';
                canvas.style.width = "auto";
                canvas.style.height = "auto";
                targetElement.appendChild(canvas);
            });
        }

        function download(source, name) {
            const canvas = document.getElementById(source).querySelector('canvas');
            const filename = `${name}.png`;
            const dataURL = canvas.toDataURL('image/png');
            const link = document.createElement('a');
            link.href = dataURL;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        fetchPosts();
    </script>
</body>