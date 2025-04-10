//////////////////////////////////////////////////////////////
//////////////////  GERAL   //////////////////
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
            opt.setAttribute('data-link', post.link); // Guarda o link diretamente no elemento
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
async function copyToClipboard(event, hidden = false) {
    let textToCopy;
    if (!hidden) {
        textToCopy = event.currentTarget.innerText;
    } else {
        targetSelector = event.currentTarget.getAttribute('data-target');
        textToCopy = document.getElementById(targetSelector).innerText;
    }

    try {
        await navigator.clipboard.writeText(textToCopy);
        alert('Texto copiado para a área de transferência!');
    } catch (error) {
        console.error('Erro ao copiar:', error);
    }
}

async function renderAll(post) {
    await renderBanner(post.value);
    await renderText(post.value);
    await renderLink(post.getAttribute('data-link'));
}

// Busca um post específico na api do site utilizando a slug
async function fetchPostBySlug(site, slug) {
    try {
        const apiUrl = `${getApiSource(site)}?slug=${slug}`;
        const response = await fetch(apiUrl);
        if (!response.ok) throw new Error("Erro ao carregar o post com slug");
        const posts = await response.json();
        if (!posts.length) {
            console.warn("Nenhum post encontrado para a slug fornecida.");
            return null;
        }
        return posts[0];  // Retorna o primeiro (geralmente o único) post encontrado
    } catch (error) {
        console.error("Erro ao buscar post por slug:", error);
        return null;
    }
}

//Carrega os posts e lê a URL pra procurar parâmetros. Se tiver, carrega o texto
document.addEventListener("DOMContentLoaded", async () => {
    // Vincula o listener para mudanças no select de posts
    document.getElementById('postSelector').addEventListener('change', async (e) => {
        const selectedOption = e.target.selectedOptions[0];
        await renderAll(selectedOption);
    });

    // Carrega a lista completa de posts para preencher o menu (select)
    await fetchPosts();

    // Verifica se existem os parâmetros 'site' e 'slug' na URL
    const params = new URLSearchParams(window.location.search);
    const siteParam = params.get("site");
    const slugParam = params.get("slug");

    if (siteParam && slugParam) {
        // Atualiza a variável global 'source' com o site passado na URL
        source = siteParam;

        // Busca o post utilizando a função de busca por slug
        const post = await fetchPostBySlug(source, slugParam);
        if (post) {
            const postSelector = document.getElementById('postSelector');
            // Procura se o post já existe no select
            let option = postSelector.querySelector(`option[value="${post.id}"]`);
            if (!option) {
                // Caso não exista, cria uma nova opção e adiciona ao select
                option = document.createElement('option');
                option.value = post.id;
                option.innerText = post.title.rendered;
                option.setAttribute('data-link', post.link);
                postSelector.appendChild(option);
            }
            // Atualiza a seleção para o post encontrado
            postSelector.value = post.id;
            // Renderiza o post específico, sobrescrevendo o post renderizado inicialmente (se houver)
            await renderAll(option);
        } else {
            console.warn("Post com a slug fornecida não foi encontrado.");
        }
    }
});

//////////////////////////////////////////////////////////////
//////////////////  BANNER  //////////////////
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

//////////////////////////////////////////////////////////////
//////////////////  TEXTO   //////////////////
//////////////////////////////////////////////////////////////

// Função principal que busca os dados e formata o texto
async function renderText(postId) {
    try {
        const postData = await fetchPostData(postId);
        if (!postData) return;

        const categoryName = await getCategoryName(postData.categories[0]);
        const emoji = await getEmojiByCategory(postData.categories[0]);
        const {
            author,
            firstParagraph
        } = extractAuthorAndFirstParagraph(postData.content.rendered);
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

    return {
        author: author || "",
        firstParagraph: firstParagraph || ""
    };
}

//////////////////////////////////////////////////////////////
//////////////////   LINK   //////////////////
//////////////////////////////////////////////////////////////

// Encurta as URL
async function shortenUrl(url) {
    const apiUrl = 'https://bit.litci.org/src/Api/CreateLink.php';

    try {
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                url
            })
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

document.querySelectorAll('#links-grid button').forEach(button => {
    button.addEventListener('click', (event) => {
        copyToClipboard(event, true);
    });
}
);