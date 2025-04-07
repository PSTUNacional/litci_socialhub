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
        
        <!--Menu-->
        <div class="card sidemenu">
            <form action="" class="bulletin-generator" style="margin:0">
                <label for="">Select a source</label>
                <select name="" id="sourceSelector">
                    <option value="es">Spanish</option>
                    <option value="pt">Portuguese</option>
                </select>

                <h4 class="form-section-header">Select a post</h4>
                <select name="" id="postSelector"></select>
            </form>
        </div>
        
        
        <!--Banner-->
        <div class="page-header">
            <h1>Banner Generator</h1>
        </div>
        <div class="container">
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
        
        <!--Texto-->
        <div class="page-header">
            <h1>Text Generator</h1>
        </div>
        <div class="container" style="display:flex; gap:var(--gap)">
            <div class="text-container card">
                <div class="text-item active">
                <h5>(Click to copy)</h5>
                <div id="text" class="text-card" onclick="copyToClipboard(event)">Generating text...</div>
                </div>
            </div>
        </div>
        
        <!--Links-->
        <div class="page-header">
            <h1>Link Generator</h1>
        </div>
        <div class="container" style="display:flex; gap:var(--gap)">
            <div class="link-container card">
                <div class="link-item active">
                <h5>(Click to copy)</h5>
            
                <h5>All</h5>
                <div id="all" class="link-card" onclick="copyToClipboard(event)">Generating link...</div>
                
                <h5>Whatsapp Channel</h5>
                <div id="whatsapp-channel" class="link-card" onclick="copyToClipboard(event)">Generating link...</div>
                
                <h5>Instagram Story</h5>
                <div id="instagram-story" class="link-card" onclick="copyToClipboard(event)">Generating link...</div>
                
                <h5>Facebook Post</h5>
                <div id="facebook-post" class="link-card" onclick="copyToClipboard(event)">Generating link...</div>
                
                <h5>Facebook Story</h5>
                <div id="facebook-story" class="link-card" onclick="copyToClipboard(event)">Generating link...</div>
                
                <h5>Twitter Post</h5>
                <div id="twitter-post" class="link-card" onclick="copyToClipboard(event)">Generating link...</div>
                
                <h5>Telegram Channel</h5>
                <div id="telegram-channel" class="link-card" onclick="copyToClipboard(event)">Generating link...</div>
                
                </div>
            </div>
        </div>

    </main>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script>
        
        //////////////////////////////////////////////////////////////
        //////////////////          GERAL           //////////////////
        //////////////////////////////////////////////////////////////
        
        let source = 'es';
        
        // Atualiza os posts da fonte selecionada
        document.getElementById('sourceSelector').addEventListener('change', (e) => {
            source = e.target.value;
            fetchPosts();
        });
        
        // Qual o link da API?
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
        
        // Busca os posts e preenche o select
        async function fetchPosts() {
            try {
                const api = `${getApiSource(source)}?per_page=20`;
                const response = await fetch(api);
                if (!response.ok) throw new Error("Erro ao carregar posts");
                
                const posts = await response.json();
                const postlist = document.getElementById('postSelector');
                postlist.innerHTML = '';
                
                if (posts.length === 0) return;
                
                posts.forEach((post) => {
                    const opt = document.createElement('option');
                    opt.value = post.id;
                    opt.innerText = post.title.rendered;
                    opt.setAttribute('data-link', post.link);  // Guarda o link diretamente no elemento
                    postlist.appendChild(opt);
                });
                
                // Seleciona e exibe o primeiro post automaticamente
                const firstPost = postlist.options[0];
                if (firstPost) {
                    await renderAll(firstPost);
                }
            } catch (error) {
                console.error("Error on fetch posts:", error);
            }
        }
        
        // Renderiza o conteúdo ao selecionar o post
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById('postSelector').addEventListener('change', async (e) => {
                const selectedOption = e.target.selectedOptions[0];
                await renderAll(selectedOption);
            });
            fetchPosts(); // Carrega os posts na inicialização
        });
        
        // Copiar o texto gerado para a área de transferência
        async function copyToClipboard(event) {
            try {
                const textToCopy = event.currentTarget.innerText;
                await navigator.clipboard.writeText(textToCopy);
                alert('Texto copiado para a área de transferência!');
            } catch (error) {
                console.error('Erro ao copiar:', error);
            }
        }
        
        async function renderAll(post){
            await renderBanner(post.value);
            await renderText(post.value);
            await renderLink(post.getAttribute('data-link'));
        }
        
        //////////////////////////////////////////////////////////////
        //////////////////          BANNER          //////////////////
        //////////////////////////////////////////////////////////////
        
        const bannerPlace = document.getElementById('bannerPlace');
        let cta = 'Leia em <b>litci.org</b>';
        
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
                
                createImage(`bannerOne`, `bannerOnePlace`, 1080, 1080);
                createImage(`bannerFour`, `bannerFourPlace`, 1080, 1350);
                createImage(`story`, `storyPlace`, 1080, 1920);
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
        
        //////////////////////////////////////////////////////////////
        //////////////////          TEXTO           //////////////////
        //////////////////////////////////////////////////////////////
        
        // Função principal que busca os dados e formata o texto
        async function renderText(postId) {
            try {
                const postData = await fetchPostData(postId);
                if (!postData) return;
        
                const categoryName = await getCategoryName(postData.categories[0]);
                const emoji = await getEmojiByCategory(postData.categories[0]);
                const { author, firstParagraph } = extractAuthorAndFirstParagraph(postData.content.rendered);
                const formattedMessage = `${emoji} *${categoryName} | ${postData.title.rendered}*\n\n${author ? author + '\n\n' : ''}${firstParagraph}`;
                
                document.getElementById('text').innerText = formattedMessage;
            } catch (error) {
                console.error("Erro ao renderizar texto:", error);
            }
        }
        
        // Busca os dados do post na API
        async function fetchPostData(postId) {
            try {
                const api = `${getApiSource(source)}/${postId}`;
                const response = await fetch(api);
                if (!response.ok) throw new Error("Erro ao carregar post");
        
                return await response.json();
            } catch (error) {
                console.error("Erro ao buscar dados do post:", error);
                return null;
            }
        }
        
        // Busca o nome da categoria principal
        async function getCategoryName(categoryId) {
            try {
                let apiBase = getApiSource(source);
                apiBase = apiBase.substring(0, apiBase.lastIndexOf('/')); // Remove tudo após o último '/'
        
                const api = `${apiBase}/categories/${categoryId}`; // Adiciona o caminho correto para categorias
                const response = await fetch(api);
                if (!response.ok) throw new Error("Erro ao carregar categoria");
        
                const category = await response.json();
                return category.name || "Destaque";
            } catch (error) {
                console.error("Erro ao buscar nome da categoria:", error);
                return "Destaque";
            }
        }
        
        // Busca o emoji correspondente à categoria
        async function getEmojiByCategory(categoryId) {
            try {
                const emojiApi = `https://litci.org/assets/json/emojis-${source}.json`;
                const response = await fetch(emojiApi);
                if (!response.ok) throw new Error("Erro ao carregar emojis");
                const emojis = await response.json();
                const emojiEntry = emojis.find(emoji => String(emoji.id) === String(categoryId));
                //const emojiEntry = emojis.find(emoji => emoji.id === categoryId);
        
                if (!emojiEntry) return "🔴"; // Caso não encontre um emoji
        
                return unicodeToEmoji(emojiEntry.unicode);
            } catch (error) {
                console.error("Erro ao buscar emoji:", error);
                return "🔴";
            }
        }
        
        // Converte unicode para emoji
        function unicodeToEmoji(unicodeStr) {
            return unicodeStr.split(' ').map(code => String.fromCodePoint(parseInt(code.replace('\\u{', '').replace('}', ''), 16))).join('');
        }
        
        // Extrai o autor e o primeiro parágrafo do conteúdo
        function extractAuthorAndFirstParagraph(htmlContent) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(htmlContent, 'text/html');
            const paragraphs = doc.querySelectorAll('p');
        
            let author = "";
            let firstParagraph = "";
        
            for (let paragraph of paragraphs) {
                if (!author && paragraph.textContent.length < 100) {
                    author = paragraph.textContent.trim();
                } else if (paragraph.textContent.length > 100) {
                    firstParagraph = paragraph.textContent.trim();
                    break;
                }
            }
        
            return { author: author || "", firstParagraph: firstParagraph || "" };
        }
        
        //////////////////////////////////////////////////////////////
        //////////////////           LINK           //////////////////
        //////////////////////////////////////////////////////////////
        
        // Encurta as URL
        async function shortenUrl(url) {
            const apiUrl = 'https://bit.litci.org/src/Api/CreateLink.php';
        
            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ url })
                });
        
                const data = await response.json();
                return data.shortlink || 'Erro ao encurtar URL';
            } catch (error) {
                return `Erro ao encurtar: ${error.message}`;
            }
        }
                
        // Função para buscar o link do post e atualizar os links de compartilhamento
        async function renderLink(baseUrl) {
            if (!baseUrl) return;
        
            const utmParams = {
                'whatsapp-channel': '?utm_source=whatsapp&utm_medium=channel',
                'instagram-story': '?utm_source=instagram&utm_medium=story',
                'facebook-post': '?utm_source=facebook&utm_medium=post',
                'facebook-story': '?utm_source=facebook&utm_medium=story',
                'twitter-post': '?utm_source=twitter&utm_medium=post',
                'telegram-channel': '?utm_source=telegram&utm_medium=channel'
            };
            
            let all_links = '';
            
            for (const id of Object.keys(utmParams)) {
                const element = document.getElementById(id);
                
                if (element) {
                    link = await shortenUrl(baseUrl + utmParams[id]);
                    all_links += '\n' + id + ': ' + link;
                    element.innerText = link;
                }
            }
            
            const all_element = document.getElementById("all");
            all_element.innerText = all_links.slice(1); //remove o primeiro \n
            
        }

    </script>
</body>
