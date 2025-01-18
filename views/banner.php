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

    #banner {
        width: 1080px;
        height: 1350px;
        background-color: rgb(22, 23, 19);
        display: flex;
        flex-direction: column;
        color: #fff;
        font-family: sans-serif;
        font-size: 24px;
        line-height: 1.2;
        position: relative;
    }

    #banner #logo {
        position: absolute;
        top: 96px;
        left: 96px;
        z-index: 999;
        max-width: 96px;
    }

    #bannerPlace canvas {
        max-width: 400px;
    }

    .safearea {
        width: 100%;
        padding: 0 96px 135px 96px;
        display: flex;
        flex-direction: column;
        gap: 24px;
        margin-top: -24px;
    }

    #picture {
        width: 100%;
        height: 100%;
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

    #banner h1 {
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

    #bannerPlace {
        max-width: 400px;
    }

    #bannerPlace h4 {
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
                <div id="bannerPlace">
                    <h4>Select a post to render a banner =)</h4>
                </div>
                <button class="button primary" type="button" onclick="download('bannerPlace', 'LIT-Banner')">Download</button>
            </div>
        </div>
        <div id="hidden">
            <div id="banner">
                <img src="../assets/img/logo_white_shadow.png" alt="" id="logo">
                <div alt="" id="picture"></div>
                <div class="safearea">
                    <div class="catbadge"></div>
                    <h1 id="bannerTitle"></h1>
                    <p>Leia em <b>litci.org</b></p>
                </div>
            </div>
        </div>
    </main>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script>
        const bannerPlace = document.getElementById('bannerPlace')
        let source = 'pt';
        document.getElementById('sourceSelector').addEventListener('change', (e) => {
            source = e.target.value;
            fetchPosts();
        });

        function fetchPosts() {
            switch (source) {
                case 'pt':
                    api = 'https://litci.org/pt/wp-json/wp/v2/posts';
                    break;
                case 'es':
                    api = 'https://litci.org/es/wp-json/wp/v2/posts';
                    break;
                default:
                    api = 'https://litci.org/pt/wp-json/wp/v2/posts';
            }
            fetch(api)
                .then(response => response.json())
                .then(data => {
                    const postlist = document.getElementById('postSelector');
                    postlist.innerHTML = '';
                    data.forEach(post => {
                        const opt = document.createElement('option');
                        opt.value = post.id;
                        opt.innerText = post.title.rendered;
                        postlist.appendChild(opt);
                    });
                })
                .then(() => {
                    bannerList = document.getElementById('postSelector').addEventListener('change', (e) => {
                        renderBanner(e.target.value);
                    });
                })
        }
        fetchPosts();
        renderBanner(document.querySelector('#postSelector').value);

        function renderBanner(id) {
            postApi = api + '?include=' + id;
            fetch(postApi)
                .then(response => response.json())
                .then(banners => {
                    banner = banners[0];

                    img = document.getElementById('picture');
                    img.style.backgroundImage = 'url(' + banner['fimg_url'] + ')';

                    category = banner['categories_names'][0]
                    if (category === 'Destacado') {
                        category = banner['categories_names'][1]
                    }
                    document.querySelector('.catbadge').innerHTML = category;

                    document.querySelector('#banner p b').innerText = 'litci.org/' + source;

                    h1 = document.getElementById('bannerTitle');
                    title = banner['title']['rendered'];
                    h1.innerHTML = title;
                }).then(() => {
                    const minHeight = 200;
                    const maxHeight = 280;
                    let fontSize = 72;

                    function adjustFontSize() {
                        h1.style.fontSize = fontSize + 'px';
                        const h1Height = h1.offsetHeight;

                        if (h1Height < minHeight) {
                            fontSize++;
                            adjustFontSize();
                        } else if (h1Height > maxHeight) {
                            fontSize--;
                            adjustFontSize();
                        }
                    }
                    adjustFontSize();

                    createImage('banner', 'bannerPlace', 1080, 1350)
                })
        }

        function createImage(source, target, w, h) {
            html2canvas(document.getElementById(source), {
                    allowTaint: true,
                    useCORS: true,
                    width: w,
                    height: h,
                    scale: 1
                })
                .then(canvas => {
                    document.getElementById(target).innerHTML = ''
                    canvas.style.width = "auto"
                    canvas.style.height = "auto"
                    document.getElementById(target).appendChild(canvas)
                })
        }

        function download(source, name) {
            canvas = document.getElementById(source).querySelector('canvas')
            filename = name + '.png'
            var dataURL = canvas.toDataURL('image/png');
            // Create a temporary link element
            var link = document.createElement('a');
            link.href = dataURL;
            link.download = filename;

            // Append the link to the document
            document.body.appendChild(link);

            // Trigger the download by simulating a click
            link.click();

            // Remove the link from the document
            document.body.removeChild(link);
        }
    </script>
</body>