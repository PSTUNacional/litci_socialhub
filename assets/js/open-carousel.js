let debug = false
function dd(message) {
    if (debug == true) {
        console.log(message)
    }
}

/*==================================

    Variables

==================================*/

let id;

/*==================================

    Elements

==================================*/

const placeholders = {
    spanish: {
        timezone: 'es-ES',
        site: 'www.litci.org/es',
        siteCta: 'Leer más en',
        instagram: '@lit.ci',
        next: 'Arrastra y lee',
        bulletin: 'Boletín',
        slide6: {
            headline: 'Si este contenido\nte resulta útil',
            title: 'Aprovecha y síguenos',
            paragraph: 'Para no perderte los nuevos materiales',
        },
        finalCta: 'Leea mas en:'
    },
    portuguese: {
        timezone: 'pt-BR',
        site: 'www.litci.org/pt',
        siteCta: 'Leia mais em:',
        instagram: '@litqi.oficial',
        next: 'Arraste e leia',
        bulletin: 'Informativo',
        slide6: {
            headline: 'Se esse conteúdo\nfaz sentido para você',
            title: 'Aproveita e já segue a gente',
            paragraph: 'Para não perder os novos materiais'
        },
        finalCta: 'Leia mais em:'
    },
    english: {
        timezone: 'en-US',
        site: "www.litci.org/en",
        siteCta: "Read more at:",
        instagram: "@iwl.fi",
        next: "Swipe and read",
        bulletin: 'Bulletin',
        slide6: {
            headline: "If this content\nmakes sense to you",
            title: "Go ahead and follow us",
            paragraph: "So you don't miss new materials"
        },
        finalCta: "Read more at:"
    }
}

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

const bigArrow = `<div class="bigArrow-container"><?xml version="1.0" encoding="UTF-8"?>
<svg id="bigArrow" data-name="Camada 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 440 120">
  <polygon class="cls-1" points="440 60 360 0 360 20 0 20 0 100 360 100 360 120 440 60"/>
</svg></div>`
/*==================================

    Functions

==================================*/

function insertComponent(component, place) {
    dd('Creating component ' + component, debug)
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

function renderFooter(site, next, cta, slide) {
    const footer = `<p>${cta}
                    <svg width="32" height="28" viewBox="0 0 32 28" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="10,0 32,14 10,28" fill="var(--main-color)" />
                    </svg>
                    <span>${site}</span>
                </p>
                <div class="next">
                    ${next}
                    <svg width="100" height="24" viewBox="0 0 100 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="10" y="10" width="70" height="4" fill="var(--black)" />
                        <polygon points="70,2 95,12 70,22" fill="var(--black)" />
                    </svg>
                 </div>`

    insertComponent(footer, '#' + slide + ' .footer')
}

function renderHeader(instagram, slide, language) {
    instagram = placeholders[language]['instagram'];
    timezone = placeholders[language]['timezone'];
    bulletin = placeholders[language]['bulletin'];
    let date = new Date();
    var today = date.toLocaleDateString(timezone, {
        day: "2-digit",
        month: "short",
        year: "numeric"
    });

    const header = `<p>${bulletin} <span>${instagram}</span></p>
                    <img class="logo" src="./assets/img/lit_logo_white.png"/>
                    <p class="date">${today}</p>`

    insertComponent(header, '#' + slide + ' .header')
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

function createForm(id, headline, title, size, paragraph, image = false) {

    dd('Render slide ' + id, debug)
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


    dd('Render form image ' + id, debug)
    if (image) {
        const imageLabel = document.createElement('label');
        imageLabel.setAttribute('for', 'image-' + id);
        imageLabel.innerText = 'Select a image';
        f.appendChild(imageLabel)

        const imageInput = document.createElement('input')
        imageInput.name = 'imageInput';
        imageInput.id = 'imageInput-' + id;
        imageInput.type = 'file';
        imageInput.accept = 'image/*';
        f.appendChild(imageInput);

        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const objectUrl = URL.createObjectURL(file);
                changeImage(`${id}`, objectUrl)
            }


        });
    }

    return f;
}

function changeImage(id, imageUrl) {
    dd('Id on ChangeImage is: ' + id, debug)
    const img = document.querySelector(`#${id} .ogimage img`);
    if (!img) return;

    // cria uma promessa para esperar a imagem carregar apenas uma vez
    const waitForLoad = new Promise((resolve, reject) => {
        img.addEventListener('load', resolve, { once: true });
        img.addEventListener('error', reject, { once: true });
    });

    img.src = imageUrl;

    waitForLoad.then(() => {
        console.log(`Imagem de #${id} carregada, processando object-fit...`);
        processImagesWithObjectFit(document.querySelector(`#${id}`));
    }).catch(err => {
        console.error("Erro ao carregar imagem:", err);
    });
}
function renderLargeIcons() {
    el = document.createElement('div')
    el.className = 'icons-container'

    const icons = {
        comment: `<?xml version="1.0" encoding="utf-8"?>
<svg version="1.1" id="icon_comment" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<path d="M499.8,243.14c-0.24,44.49-8.81,81.01-24.99,116.06c-3.18,6.89-3.78,16.89-1.41,24.09c11.84,36.01,25.39,71.46,37.47,107.4
	c1.91,5.68,1.47,14.58-1.9,18.76c-2.45,3.04-12.2,2.55-17.55,0.57c-34.1-12.62-67.66-26.74-101.95-38.81
	c-8-2.81-19.47-2.44-27.06,1.21C211.08,545.28,37.71,459.47,4.6,294.78C-23.02,157.39,76.98,18.99,215.86,2.39
	c138.45-16.55,256.78,70.84,280.99,207.87C499.11,223.01,499.21,236.14,499.8,243.14z M479.31,478.01
	c-2.41-7.95-3.73-12.97-5.44-17.86c-8.44-24.04-16.43-48.26-25.71-71.98c-5.13-13.1-5.03-24.21,1.99-36.95
	c17.64-31.97,25.43-67.01,25.16-103.27c-0.98-136.71-121.9-241.19-257.43-220.4C123.56,42.03,60.41,97.18,34.39,188.58
	C8.48,279.54,33.62,359.5,105.7,420.24c73.31,61.78,156.91,70.37,243.83,29.61c17.9-8.39,32.12-10.86,50.07-2.16
	c19.97,9.68,41.34,16.5,62.13,24.47C466.54,473.99,471.5,475.43,479.31,478.01z"/>
</svg>
`,
        like: `<?xml version="1.0" encoding="utf-8"?>
<svg version="1.1" id="icon_like" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<path d="M256.02,91.31c5.43-6.8,9.3-11.74,13.27-16.6c35.23-43.1,88.89-60.52,137.39-44.63c61.06,20.01,100.61,67.82,104.7,124.04
	c5.13,70.41-21.59,128.1-71.65,174.88c-55.92,52.25-114.35,101.81-171.41,152.84c-9.26,8.28-16.18,7.5-25.13-0.51
	C186.51,430.6,128.4,381.4,72.9,329.43C20.03,279.93-8.09,219.14,2.05,144.84C9.69,88.84,51.8,43.2,111.67,28.7
	c55.25-13.38,99.5,6.46,134.24,49.91C248.89,82.34,251.87,86.09,256.02,91.31z M255.24,461.82c2.95-1.98,5.1-3.1,6.86-4.66
	c54.76-48.5,110.59-95.87,163.85-145.95c39.95-37.56,63.65-83.82,63.83-140.9c0.22-71.84-63.82-131.9-133.45-122.58
	c-40.39,5.41-65.88,31.18-85.86,64.08c-11.76,19.36-17.32,19.42-28.77,0.38c-16.76-27.84-37.74-50.96-70.02-60.95
	C95.77,27.75,15.37,98.51,22.18,180.3c4.85,58.29,32.56,102.92,74.1,140.98c22.65,20.75,45.99,40.74,69.02,61.08
	C195.2,408.77,225.09,435.19,255.24,461.82z"/>
</svg>
`,
        save: `<?xml version="1.0" encoding="utf-8"?>
<svg version="1.1" id="icon_save" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<path d="M479.58,255.64c0.01,75.56,0.01,151.11,0.01,226.67c0,3.41,0.89,7.16-0.23,10.16c-2.38,6.39-4.55,15.94-9.16,17.58
	c-4.95,1.76-14.15-2.44-18.84-6.85c-44.76-42.07-88.96-84.73-133.32-127.23c-16.84-16.13-34.27-31.71-50.26-48.64
	c-9.6-10.16-15.57-8.31-24.72,0.57c-58.81,57.01-118.12,113.49-177.3,170.12c-4.1,3.93-7.85,8.69-12.72,11.27
	c-9.89,5.23-17.95,3.26-20.12-9.1c-0.97-5.54-0.81-11.32-0.81-16.99c-0.04-152.24-0.05-304.48,0-456.73
	C32.11,1.85,33.93,0.04,58.01,0.03c132.12-0.04,264.23-0.04,396.35-0.01c23.03,0.01,25.15,2.09,25.17,25.55
	C479.62,102.26,479.57,178.95,479.58,255.64z M59.13,466.94c7.56-6.6,12.26-10.4,16.62-14.57
	c53.42-51.11,106.8-102.27,160.16-153.44c18.28-17.53,21.05-17.59,38.82-0.56c52.97,50.76,105.94,101.52,158.96,152.23
	c5.03,4.81,10.38,9.29,18.21,16.25c0.88-9.19,1.75-14.07,1.76-18.95c0.07-134.62-0.2-269.24,0.38-403.86
	c0.07-16.01-6.26-18.47-20.2-18.42c-117.86,0.44-235.73,0.24-353.6,0.25c-22.38,0-22.56,0.04-22.57,22.38
	c-0.06,132.35-0.05,264.7,0.01,397.04C57.68,451.24,58.45,457.18,59.13,466.94z"/>
</svg>
`,
        share: `<?xml version="1.0" encoding="utf-8"?>
<svg version="1.1" id="icon_share" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<path d="M256.59,27.73c78.35,0,156.69-0.03,235.04,0.02c21.71,0.01,25.21,6.12,14.55,25.27
	c-77.52,139.19-154.98,278.4-232.92,417.35c-3.33,5.93-11.17,9.33-16.91,13.91c-3.67-5.92-9.35-11.42-10.71-17.83
	c-16.66-78.81-32.5-157.79-49.19-236.59c-1.41-6.66-6.23-13.63-11.4-18.32C126.71,158.65,67.94,106.22,9.5,53.41
	c-4.2-3.8-9.18-9.34-9.47-14.32c-0.65-11.16,8.52-11.4,17-11.39c50.72,0.07,101.45,0.03,152.17,0.02
	C198.33,27.73,227.46,27.73,256.59,27.73z M465.74,78.36c-0.96-0.94-1.92-1.88-2.88-2.82c-4.32,2.29-8.73,4.41-12.93,6.89
	c-72.62,42.83-145.05,85.99-217.99,128.27c-11.33,6.57-13.53,13.41-10.94,25.31c9.37,43.03,17.86,86.26,26.79,129.39
	c4.82,23.29,9.88,46.54,14.83,69.8c1.31,0.24,2.62,0.48,3.92,0.71C332.93,316.73,399.34,197.54,465.74,78.36z M46.63,51.55
	c-0.57,1.21-1.14,2.42-1.72,3.62c3.44,2.87,6.97,5.62,10.29,8.61c46.27,41.58,92.76,82.93,138.57,125.01
	c9.39,8.62,16.25,9.23,27.14,2.7c73.13-43.88,146.68-87.06,220.05-130.55c3.47-2.06,6.51-4.84,12.56-9.4
	C315.19,51.55,180.91,51.55,46.63,51.55z"/>
</svg>
`,
    }

    Object.keys(icons).forEach(icon => {
        i = document.createElement('div')
        i.innerHTML = icons[icon]
        el.appendChild(i)
    })

    document.querySelector('#slide6 .middle').appendChild(el)

}
/*==================================

    Cycle

==================================*/

function renderSlides(carouselContent, language) {

    site = placeholders[language]['site']
    instagram = placeholders[language]['instagram']
    next = placeholders[language]['next']
    siteCta = placeholders[language]['siteCta']
    carouselContent['slide6'] = placeholders[language]['slide6']
    carouselContent['slide9']['headline'] = placeholders[language]['finalCta']

    document.querySelector('#carousel-container').innerHTML = ''

    let slides = ['slide1', 'slide2', 'slide3', 'slide4', 'slide5', 'slide6', 'slide7', 'slide8', 'slide9']

    slides.forEach(slide => {
        var id = slide
        insertComponent(slideTemplate, '#carousel-container')

        currentElement = document.querySelector('#carousel-container .slide-section:last-child .slide-container .slide-item')
        currentElement.id = id
        currentElement.style.transform = 'translate(-50%, -50%) scale(var(--scale))'

        renderFooter(site, next, siteCta, slide)
        renderHeader(instagram, slide, language)

        let content = carouselContent[slide]

        if (slide === 'slide9') {
            el = document.createElement('img');
            el.src = '/assets/img/lit_logo_white.png';

            document.querySelector('#' + slide + ' .middle').appendChild(el)
        }
        if (content.headline) {
            el = createComponent('headline', content.headline)
            insertComponent(el, '#' + slide + ' .middle')
        }

        if (slide === 'slide6') {
            renderLargeIcons()
        }

        if (content.title) {
            el = createComponent('title', content.title)
            insertComponent(el, '#' + slide + ' .middle')
        }

        if (content.paragraph) {
            el = createComponent('paragraph', content.paragraph)
            insertComponent(el, '#' + slide + ' .middle')
        }

        if (slide === 'slide6' || slide === 'slide5') {
            insertComponent(bigArrow, '#' + slide + ' .back')
        }

        if (slide === 'slide1' || slide === 'slide9') {
            dd('Slide is 1 or 9? True', debug)
            insertComponent(createForm(slide, content.headline, content.title, null, content.paragraph, true), '#carousel-container .slide-section:last-child')
        } else {
            dd('Slide is 1 or 9? False', debug)
            insertComponent(createForm(slide, content.headline, content.title, null, content.paragraph), '#carousel-container .slide-section:last-child')
        }

    })

    createOgImage(ogimage, 'slide1')
    createOgImage(ogimage, 'slide9')

    document.querySelector('#slide9 .ogimage').style.height = document.querySelector('#slide9 .paragraph').offsetTop + 'px'

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
        [300, 'right', 'dark', '50%', '#slide6'],
        // [300, 'right', 'dark', '50%', '#slide4'],
        // [300, 'left', 'dark', '50%', '#slide6'],
        [300, 'left', 'light', '50%', '#slide7'],
        [300, 'right', 'dark', '75%', '#slide8'],

    ]

    bars.forEach(([height, side, color, position, place]) => {
        insertBar(height, side, color, position, place)
    })

    // Calc height of slide4 title to fit
    s4Headline = document.querySelector('#slide5 .headline').offsetHeight
    s4Title = document.querySelector('#slide5 h1').offsetHeight
    s4Height = s4Headline + s4Title
    s3BarPosition = (s4Height / 2) + 188
    insertBar(s4Height, 'right', 'dark', s3BarPosition + 'px', '#slide4')
    insertBar(s4Height, 'left', 'dark', s3BarPosition + 'px', '#slide6')

    // Activate page functions
    setPageButtons()
}
/*==================================

    Page Functions

==================================*/

function setPageButtons() {
    // Adiciona evento de clique a cada slide-item
    document.querySelectorAll('.slide-item').forEach(slide => {
        slide.addEventListener('click', (e) => {
            // e.stopPropagation() para evitar que o clique se propague
            // para outros elementos, caso necessário

            // Encontra o formulário correspondente ao slide clicado
            const form = slide.closest('.slide-section').querySelector('.slide-form');
            if (form) {
                // Alterna a classe 'active' apenas no formulário deste slide
                form.classList.toggle('active');
                form.scrollIntoView({
                    behavior: 'smooth', // Adiciona uma animação de rolagem suave
                    block: 'center'   // Alinha o slide no centro da tela
                });
            }
        });
    });
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

            if (idParent == 'slide5') {
                s4Headline = document.querySelector('#slide5 .headline').offsetHeight
                s4Title = document.querySelector('#slide5 h1').offsetHeight
                s4Height = s4Headline + s4Title
                s3BarPosition = (s4Height / 2) + 188

                document.querySelector('#slide4 .bar.right').style.height = s4Height + 'px'
                document.querySelector('#slide6 .bar.left').style.height = s4Height + 'px'

                document.querySelector('#slide4 .bar.right').style.top = s3BarPosition + 'px'
                document.querySelector('#slide6 .bar.left').style.top = s3BarPosition + 'px'

            }

            if (idParent == 'slide9') {
                document.querySelector('#slide9 .ogimage').style.height = document.querySelector('#slide9 .paragraph').offsetTop + 'px'
            }
        });
    });
}


const radios = document.querySelectorAll('input[name="hue"]');
radios.forEach(radio => {
    radio.addEventListener('change', e => {
        hue = e.target.value
        document.documentElement.style.setProperty('--hue', hue);

        if (hue == 80 || hue == 120 || hue == 160) {
            document.documentElement.style.setProperty('--brightness', '30%');
        } else {
            document.documentElement.style.setProperty('--brightness', '50%');
        }


    });
});

function setLoadMessage(message) {
    document.querySelector('#loadmessage').innerText = message
}

async function generateText(content, format, language) {
    const API_URL = '../../../api/openai'; 
    const bodyData = {
        method: 'createOpenCarousel',
        content: content,
        format: format,
        language: language
    };

    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(bodyData)
        });

        if (!response.ok) {
            const errorBody = await response.text();
            throw new Error(`Erro na requisição: Status ${response.status}. Detalhes: ${errorBody.substring(0, 100)}`);
        }

        const data = await response.json();
        return data;

    } catch (error) {
        console.error('Erro ao gerar texto:', error.message);
        return { success: false, error: error.message }; 
    }
}

let carouselContent = ''
async function renderCarousel() {
    dd('Starting process...', debug)
    document.querySelector('#carousel-container').innerHTML = `<div class="loader-container"><div class="loader"></div><h3 id="loadmessage"></div></div>`
    setLoadMessage('Starting the carousel production...')

    const language = document.querySelector('input[name="lang"]:checked').value;
    dd('Language is: ' + language, debug)

    const format = document.querySelector('input[name="format"]:checked').value;
    dd('Format is: ' + format, debug)

    const content = document.querySelector('#contentArea').value;

    try {
        ogimage = 'https://tribe-s3-production.imgix.net/C5yUOy3RzAZV9mFvgXoq5?auto=compress,format&dl';
        setLoadMessage('Generating text...')
        carouselContent = await generateText(content, format, language); // Aguarda generateText
        dd('Raw JSON is: ' + carouselContent, debug)

        // Renderiza os slides
        setLoadMessage('Building slides...')
        dd('Building slides...', debug)
        await renderSlides(carouselContent, language); // Aguarda renderSlides, se necessário
    } catch (error) {
        document.querySelector('.loader').remove()
        setLoadMessage('Sorry. Something went wrong.\nTry again...')
        console.error('Erro ao renderizar o carrossel:', error);
    }
}

async function processImagesWithObjectFit(elementOrImg, maxWidth = 1080) {
    let images;
    if (elementOrImg.tagName === "IMG") {
        images = [elementOrImg];
    } else {
        images = elementOrImg.querySelectorAll('img');
    }

    const promises = Array.from(images).map(img => {
        const style = window.getComputedStyle(img);
        if (style.objectFit !== 'cover') return Promise.resolve();

        return new Promise((resolve, reject) => {
            const imgEl = new Image();
            imgEl.crossOrigin = 'anonymous';
            imgEl.src = img.src;

            imgEl.onload = () => {
                const container = img;
                const containerRect = container.getBoundingClientRect();
                const containerRatio = containerRect.width / containerRect.height;
                const imgRatio = imgEl.naturalWidth / imgEl.naturalHeight;

                // Redimensiona largura para não travar
                let canvasWidth = Math.min(imgEl.naturalWidth, maxWidth);
                let canvasHeight = canvasWidth / containerRatio;

                const tempCanvas = document.createElement('canvas');
                tempCanvas.width = canvasWidth;
                tempCanvas.height = canvasHeight;
                const ctx = tempCanvas.getContext('2d');

                let sx, sy, sWidth, sHeight;

                if (imgRatio > containerRatio) {
                    sHeight = imgEl.naturalHeight;
                    sWidth = sHeight * containerRatio;
                    sx = (imgEl.naturalWidth - sWidth) / 2;
                    sy = 0;
                } else {
                    sWidth = imgEl.naturalWidth;
                    sHeight = sWidth / containerRatio;
                    sx = 0;
                    sy = (imgEl.naturalHeight - sHeight) / 2;
                }

                ctx.drawImage(imgEl, sx, sy, sWidth, sHeight, 0, 0, canvasWidth, canvasHeight);

                img.src = tempCanvas.toDataURL('image/png');
                resolve();
            };

            imgEl.onerror = reject;
        });
    });

    await Promise.all(promises);
}

async function createDataURLs(slides, w, h) {
    const dataURLs = [];

    for (let i = 0; i < slides.length; i++) {
        const el = document.getElementById(slides[i]);
        if (!el) continue;

        const originalTransform = el.style.transform;
        el.style.transform = 'translate(-50%, -50%) scale(1)';

        if (slides[i] === 'slide1' || slides[i] === 'slide9') {
            await processImagesWithObjectFit(el);
        }

        el.getBoundingClientRect();
        await new Promise(requestAnimationFrame);

        const canvas = await html2canvas(el, {
            allowTaint: true,
            useCORS: true,
            width: w,
            height: h,
            scale: 1
        });
        dataURLs.push(canvas.toDataURL("image/png"));

        el.style.transform = originalTransform;
    }

    return dataURLs;
}

document.getElementById('downloadAllBtn').addEventListener('click', async () => {
    const slides = ['slide1', 'slide2', 'slide3', 'slide4', 'slide5', 'slide6', 'slide7', 'slide8', 'slide9'];
    const dataURLs = await createDataURLs(slides, 1080, 1350);

    const formData = new FormData();
    for (const [i, dataURL] of dataURLs.entries()) {
        const blob = await (await fetch(dataURL)).blob();
        formData.append(`slide_${i + 1}`, blob, `slide_${i + 1}.png`);
    }

    const response = await fetch('../../src/Service/CarouselService.php', {
        method: 'POST',
        body: formData
    });

    const blob = await response.blob();
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'slides.zip';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
});

function extractCurrentText() {
    slides = document.querySelectorAll('.slide-item')
    let finalResult = {};
    for (let i = 0; i < 9; i++) {

        if (slides[i]) {
            let index = i + 1
            let name = 'slide' + index;
            let result = {};

            let h = slides[i].querySelector('.headline');
            let p = slides[i].querySelector('.paragraph');
            let t = slides[i].querySelector('.title');

            if (h && h.innerText.trim() !== '') {
                result.headline = h.innerText.trim();
            }

            if (p && p.innerText.trim() !== '') {
                result.paragraph = p.innerText.trim();
            }

            if (t && t.innerText.trim() !== '') {
                result.title = t.innerText.trim();
            }

            finalResult[name] = result;
        }
    }
    return finalResult
}

async function translateCarousel(language) {
    const API_URL = '/api/openai'; 
    let contentRaw = extractCurrentText()
    content = JSON.stringify(contentRaw)

    const bodyData = {
        method: 'translateCarousel',
        content: content,
        language: language
    };

    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(bodyData)
        });

        if (!response.ok) {
            const errorBody = await response.text();
            throw new Error(`Erro na requisição: Status ${response.status}. Detalhes: ${errorBody.substring(0, 100)}`);
        }

        const data = await response.json();
        renderSlides(data, language)

    } catch (error) {
        console.error('Erro ao gerar texto:', error.message);
        return { success: false, error: error.message }; 
    }
}

/**
 * Function to open the SweetAlert2 modal for language selection.
 */

async function openTranslationModal() {
    const inputOptions = {
        'portuguese': 'Portuguese',
        'spanihs': 'Spanish',
        'english': 'English'
    };

    const { value: selectedLanguage } = await Swal.fire({
        title: 'To which language do you want to translate?',
        icon: 'question',
        input: 'radio',
        inputOptions: inputOptions,
        inputValue: 'en',
        showCancelButton: true,
        confirmButtonText: 'Translate',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'custom-confirm-button',
            input: 'custom-input-container'
        },
        inputValidator: (value) => {
            if (!value) {
                return 'You need to choose a language!';
            }
        }
    });

    // Processamento do resultado após a interação do usuário
    if (selectedLanguage) {
        
        // 1. EXIBIR O MODAL DE LOADING
        Swal.fire({
            title: 'Translating...',
            html: 'Please wait while the content is being translated.',
            // Adiciona o spinner de loading nativo do SweetAlert2
            didOpen: () => {
                Swal.showLoading();
            },
            allowOutsideClick: false, // Impede o fechamento acidental
            allowEscapeKey: false,
            showConfirmButton: false // Não mostra o botão de confirmação
        });

        try {
            // 2. EXECUTAR A FUNÇÃO DE TRADUÇÃO (Assíncrona)
            // IMPORTANTE: Certifique-se de que translateCarousel() retorna uma Promise
            await translateCarousel(selectedLanguage);

            // 3. APÓS O SUCESSO: Fechar o loading e mostrar o sucesso
            Swal.close(); // Fecha o modal de loading
          
        } catch (error) {
            // 4. EM CASO DE ERRO: Fechar o loading e mostrar a falha
            Swal.close(); // Fecha o modal de loading
            console.error("Translation failed:", error);

            Swal.fire({
                icon: 'error',
                title: 'Translation Failed',
                text: 'An error occurred during translation. Please try again.',
            });
            
        } 

    } else if (selectedLanguage === undefined) {
        // Se o usuário clicou 'Cancel' ou fora do modal
        Swal.fire({
            icon: 'info',
            title: 'Translation Canceled',
            text: 'No translation will be performed.'
        });
    }
}

// Exemplo de como a função translateCarousel() deve ser (retornando uma Promise)
/*
async function translateCarousel(lang) {
    console.log(`Starting translation to ${lang}...`);
    // Simula uma chamada de API ou operação de tradução demorada
    await new Promise(resolve => setTimeout(resolve, 3000)); 
    console.log("Translation done!");
    // if (lang === 'es') throw new Error("API Limit Reached"); // Simular erro
    return true; 
}
*/
// ----------------------------------------------------
// Exemplo de como chamar a função ao clicar em um botão
// ----------------------------------------------------
document.getElementById('traduzir-btn').addEventListener('click', abrirModalIdioma);