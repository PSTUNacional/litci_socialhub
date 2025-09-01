

/*==================================

    Variables

==================================*/

let id;
let site;
let instagram;

let date = new Date();
var today = date.toLocaleDateString("pt-BR", {
    day: "2-digit",
    month: "short",
    year: "numeric"
});

/*==================================

    Elements

==================================*/

const slideTemplate = ` <div class="slide-section">
            <div class="slide-container"><div class="slide-item">
                <div class="front">
                    <div class="header">
                    </div>
                    <div class="footer">
                    </div>
                </div>
                <div class="middle"></div>
                <div class="back">
                </div>
            </div>
            </div>
            </div>`

const textForm = `<form id=s>
                    <label for="headline">Headline</label>
                    <input type="text" name="headline" value="">
                    <label for="title">Title</label>
                    <input type="text" name="headline" value="">
                    <label for="paragrpa">Paragraph</label>
                    <textarea type="text" name="headline" value=""></textarea>
                </form>`

const header = `<p>Informativo <span>${instagram}</span></p>
                <p class="date">${today}</p>`
const footer = `<p>Leia em
                    <svg width="32" height="28" viewBox="0 0 32 28" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="10,0 32,14 10,28" fill="var(--main-color)" />
                    </svg>
                    <span>${site}</span>
                </p>
                <div class="next">
                    Arraste e leia
                    <svg width="100" height="24" viewBox="0 0 100 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="10" y="10" width="70" height="4" fill="var(--black)" />
                        <polygon points="70,2 95,12 70,22" fill="var(--black)" />
                    </svg>
                 </div>`

const bigArrow = `<svg id="bigArrow" xmlns="http://www.w3.org/2000/svg" height="120" width="450" viewBox="0 0 440 120" style="margin-top:860px">
                        <rect fill="var(--main-dark)" x="0" height="80" y="20" style="/*! opacity: 0.1; */" width="360"></rect>
                        <polygon fill="var(--main-dark" points="360,0 440,60 360,120"></polygon>
                    </svg>`
/*==================================

    Functions

==================================*/

function insertComponent(component, place) {
    const target = document.querySelector(place);
    if (!target) {
        console.warn(`Elemento "${place}" não encontrado.`);
        return;
    }

    if (typeof component === "string") {
        target.insertAdjacentHTML("beforeend", component);
    } else if (component instanceof HTMLElement) {
        target.appendChild(component);
    } else {
        console.warn("Tipo de componente não suportado.");
    }
}

function createComponent(type, content) {
    let el;
    const map = {
        title: 'h1',
        headline: 'h3',
    };
    let element = map[type] || 'p';

    el = document.createElement(element)
    el.className = type
    el.innerText = content;

    return el
}

function insertCircle(vertical, horizontal, color, place) {
    let c = document.createElement('div')
    c.classList.add('circle')
    c.classList.add(vertical)
    c.classList.add(horizontal)
    c.classList.add(color)

    const target = document.querySelector(place)
    target.appendChild(c)

}

function createOgImage(url, place) {
    let el = document.createElement('div')
    el.className = 'ogimage'
    el.innerHTML = `<img src='${url}'/>`
    document.querySelector('#' + place + ' .back').appendChild(el)
}

function insertBar(height, side, color, position, place) {
    let el = document.createElement('div')
    el.classList.add('bar')
    el.classList.add(side)
    el.classList.add(color)
    el.style.height = height + 'px'
    el.style.top = position

    tp = place + ' .back'
    target = document.querySelector(tp)
    target.appendChild(el)
}

function createForm(id, headline, title, size, paragraph) {

    headline = headline ? headline : null
    title = title ? title : null
    paragraph = paragraph ? paragraph : null
    size = size ? size : 96

    // Create form
    const f = document.createElement('form');
    f.id = 'form-' + id;
    f.className = 'slide-form';

    // Form Title

    const formTitle = document.createElement('h3')
    formTitle.innerHTML = 'Content for ' + id
    f.appendChild(formTitle)

    // Headline
    if (headline) {
        const headlineLabel = document.createElement('label');
        headlineLabel.setAttribute('for', 'headline-' + id);
        headlineLabel.innerText = 'Headline';
        f.appendChild(headlineLabel);

        const headlineInput = document.createElement('input');
        headlineInput.type = 'text';
        headlineInput.name = 'headline';
        headlineInput.id = 'headline-' + id;
        headlineInput.value = headline
        f.appendChild(headlineInput);
    }

    // Title
    if (title) {
        const titleLabel = document.createElement('label');
        titleLabel.setAttribute('for', 'title-' + id);
        titleLabel.innerText = 'Title';
        f.appendChild(titleLabel);

        const titleInput = document.createElement('input');
        titleInput.type = 'text';
        titleInput.name = 'title';
        titleInput.id = 'title-' + id;
        titleInput.value = title
        f.appendChild(titleInput);

        // Slider
        const sliderLabel = document.createElement('label');
        sliderLabel.setAttribute('for', 'slider-' + id);
        sliderLabel.innerText = 'Title size';
        f.appendChild(sliderLabel);

        const sliderInput = document.createElement('input');
        sliderInput.type = 'range';
        sliderInput.id = 'slider-' + id;
        sliderInput.min = 48;
        sliderInput.max = 128;
        sliderInput.value = 96; // valor inicial
        f.appendChild(sliderInput);
    }

    // Paragraph
    if (paragraph) {
        const paragraphLabel = document.createElement('label');
        paragraphLabel.setAttribute('for', 'paragraph-' + id);
        paragraphLabel.innerText = 'Paragraph';
        f.appendChild(paragraphLabel);

        const paragraphTextarea = document.createElement('textarea');
        paragraphTextarea.name = 'paragraph';
        paragraphTextarea.id = 'paragraph-' + id;
        paragraphTextarea.value = paragraph
        f.appendChild(paragraphTextarea);
    }

    return f;
}
/*==================================

    Cycle

==================================*/

function renderSlides(carouselContent) {
    carouselContent['slide5'] = {
        headline: 'Se esse conteúdo\nfaz sentido para você',
        title: 'Aproveita e já segue a gente',
        paragraph: 'Para não perder os novos materiais'
    }

    let slides = ['slide1', 'slide2', 'slide3', 'slide4', 'slide5', 'slide6', 'slide7', 'slide8', 'slide9']

    slides.forEach(slide => {
        var id = slide
        insertComponent(slideTemplate, '#carousel-container')
        document.querySelector('#carousel-container .slide-section:last-child .slide-container .slide-item').id = id

        insertComponent(footer, '#' + slide + ' .footer')
        insertComponent(header, '#' + slide + ' .header')

        let content = carouselContent[slide]
        if (content.headline) {
            el = createComponent('headline', content.headline)
            insertComponent(el, '#' + slide + ' .middle')
        }

        if (content.title) {
            el = createComponent('title', content.title)
            insertComponent(el, '#' + slide + ' .middle')
        }

        if (content.paragraph) {
            el = createComponent('paragraph', content.paragraph)
            insertComponent(el, '#' + slide + ' .middle')
        }

        if (slide === 'slide5' || slide === 'slide4') {
            insertComponent(bigArrow, '#' + slide + ' .back')
        }
        insertComponent(createForm(slide, content.headline, content.title, null, content.paragraph), '#carousel-container .slide-section:last-child')

    })

    createOgImage(ogimage, 'slide1')
    createOgImage(ogimage, 'slide9')


    const circles = [
        ['top', 'right', 'dark', '#slide2 .back'],
        ['top', 'left', 'light', '#slide3 .back'],
        ['bottom', 'right', 'light', '#slide3 .back'],
        ['bottom', 'left', 'dark', '#slide4 .back'],
        ['top', 'right', 'dark', '#slide5 .back'],
        ['top', 'left', 'dark', '#slide6 .back'],
        ['bottom', 'right', 'light', '#slide7 .back'],
        ['bottom', 'left', 'dark', '#slide8 .back'],
        ['top', 'right', 'dark', '#slide8 .back'],
        ['top', 'left', 'light', '#slide9 .back'],
    ];

    circles.forEach(([vertical, horizontal, theme, selector]) => {
        insertCircle(vertical, horizontal, theme, selector);
    });

    const bars = [
        [300, 'right', 'dark', '50%', '#slide1'],
        [300, 'left', 'dark', '50%', '#slide2'],
        [300, 'right', 'dark', '50%', '#slide2'],
        [300, 'left', 'light', '50%', '#slide3'],
        [300, 'right', 'dark', '50%', '#slide5'],
        [300, 'right', 'dark', '50%', '#slide6'],
        [300, 'left', 'dark', '50%', '#slide6'],
        [300, 'left', 'light', '50%', '#slide7'],
        [300, 'right', 'dark', '75%', '#slide8'],

    ]

    bars.forEach(([height, side, color, position, place]) => {
        insertBar(height, side, color, position, place)
    })


    // Calc height of slide4 title to fit
    s4Headline = document.querySelector('#slide4 .headline').offsetHeight
    s4Title = document.querySelector('#slide4 h1').offsetHeight
    s4Height = s4Headline + s4Title
    s3BarPosition = (s4Height / 2) + 188
    insertBar(s4Height, 'right', 'light', s3BarPosition + 'px', '#slide3')
    insertBar(s4Height, 'left', 'dark', s3BarPosition + 'px', '#slide5')

    // Activate page functions
    setPageButtons()
}
/*==================================

    Page Functions

==================================*/

function setPageButtons() {
    document.getElementById('editText').addEventListener('click', () => {
        document.querySelectorAll('.slide-form').forEach(el => {
            el.classList.toggle('active')
        })
    })

    document.querySelectorAll('#carousel-container input[type=text], #carousel-container textarea').forEach(el => {
        el.addEventListener('input', () => {
            const newValue = el.value;
            const [elementClass, idParent] = el.id.split('-');
            target = '#' + idParent + ' .' + elementClass
            document.querySelector(target).innerText = newValue
        });
    });

    document.querySelectorAll('#carousel-container input[type=range]').forEach(el => {
        el.addEventListener('input', () => {
            const newValue = el.value;
            const [elementClass, idParent] = el.id.split('-');
            target = '#' + idParent + ' h1'

            document.querySelector(target).style.fontSize = newValue + 'px'

            if (idParent == 'slide4') {
                s4Headline = document.querySelector('#slide4 .headline').offsetHeight
                s4Title = document.querySelector('#slide4 h1').offsetHeight
                s4Height = s4Headline + s4Title
                s3BarPosition = (s4Height / 2) + 188

                document.querySelector('#slide3 .bar.right').style.height = s4Height + 'px'
                document.querySelector('#slide5 .bar.left').style.height = s4Height + 'px'

                document.querySelector('#slide3 .bar.right').style.top = s3BarPosition + 'px'
                document.querySelector('#slide5 .bar.left').style.top = s3BarPosition + 'px'

            }
        });
    });
}

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
            return 'https://litci.org/es/wp-json/wp/v2/posts';
        case 'pt':
        default:
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

    } catch (error) {
        console.error("Error on fetch posts:", error);
    }
}

// Renderiza o conteúdo ao selecionar o post
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('postSelector').addEventListener('change', async (e) => {
        const selectedOption = e.target.selectedOptions[0];
    });
    fetchPosts(); // Carrega os posts na inicialização
});


async function generateText(content) {
    const formData = new FormData();
    formData.append('method', 'createCarousel');
    formData.append('content', content);

    try {
        const response = await fetch('../../../api/openai', {
            method: 'POST',
            body: formData
        })

        if (!response.ok) throw new Error("Erro na requisição");

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Erro na requisição:', error);
        return null;
    }
}


async function renderCarousel() {

    document.querySelector('#carousel-container').innerHTML = ''

    const postId = document.querySelector("#postSelector").value
    const source = document.getElementById('sourceSelector').value

    switch (source) {
        case "es":
            site = 'www.litci.org/es'
            instagram = '@lit.ci'
            break;
        case 'pt':
            site = 'www.litci.org/pt'
            instagram = '@litqi.oficial'
            break;
        default:
            site = 'www.litci.org'
            instagram = '@lit.ci'
    }

    apiBase = getApiSource(source)
    apiUrl = apiBase + '/' + postId
    console.log('API Base: ', apiUrl)
    postJson = await fetch(apiUrl).then(resp => resp.json())

    ogimage = postJson['fimg_url']

    const carouselContent = await generateText(apiUrl)
    console.log(carouselContent);

    console.log('Instagram is: ', instagram)
    renderSlides(carouselContent)
}