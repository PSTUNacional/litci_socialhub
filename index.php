<!-- <?php
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/socialhub/autoload.php'))
{
    include($_SERVER['DOCUMENT_ROOT'] . '/socialhub/autoload.php');
} else {
    include($_SERVER['DOCUMENT_ROOT'] . '/autoload.php');
}
get_component('header');
?>
</head>

<body>
    <?php get_component('nav'); ?>
    <style>
        .radio-card {
            cursor: pointer !important
        }

        form.bulletin-generator input[type=radio] {
            display: none;
        }

        form.bulletin-generator .radio-card div {
            background-color: #fff0;
            border: 1px solid #fff0;
            border-radius: 4px;
            padding: 8px;
        }

        form.bulletin-generator .radio-card:hover div {
            background-color: var(--primary-5);
            border: 1px solid #fff0;
            border-radius: 4px;
            padding: 8px;
        }

        form.bulletin-generator input[type=radio]:checked+div {
            background-color: var(--primary-5);
            border: 1px solid var(--primary);
        }

        form .form-section-header {
            color: var(--gray-900);
            font-size: 0.8em;
            padding-bottom: 4px;
            border-bottom: 1px solid var(--gray-100);
            margin-bottom: -12px;
        }
    </style>
    <main>
        <div class="page-header">
            <h1>Bulletin Generator</h1>
        </div>
        <div class="container" style="display:flex; gap:var(--gap)">
            <div class="card" style="height:fit-content">
                <form action="" class="bulletin-generator" style="margin:0">
                    <h4 class="form-section-header">Source</h4>
                    <div style="display:flex;flex-direction:column">
                        <label for="source-es" class="radio-card">
                            <input type="radio" name="source" id="source-es" value="es" checked>
                            <div>
                                <span class="fi fi-es fis" aria-label="Spanish"></span>
                                Spanish
                            </div>
                        </label>
                        <label for="source-pt" class="radio-card">
                            <input type="radio" name="source" id="source-pt" value="pt">
                            <div>
                                <span class="fi fi-br fis"></span>
                                Portuguese
                            </div>
                        </label>
                        <label for="source-ar" class="radio-card">
                            <input type="radio" name="source" id="source-ar" value="ar">
                            <div>
                                <span class="fi fi-ar fis"></span>
                                PSTU (Argentina)
                            </div>
                        </label>
                        <label for="source-ch" class="radio-card">
                            <input type="radio" name="source" id="source-ch" value="ch">
                            <div>
                                <span class="fi fi-cl fis"></span>
                                MIT (Chile)
                            </div>
                        </label>
                        <label for="source-cl" class="radio-card">
                            <input type="radio" name="source" id="source-cl" value="cl">
                            <div>
                                <span class="fi fi-co fis"></span>
                                PST (Colombia)
                            </div>
                        </label>
                        <label for="source-cr" class="radio-card">
                            <input type="radio" name="source" id="source-cr" value="cr">
                            <div>
                                <span class="fi fi-cr fis"></span>
                                PT (Costa Rica)
                            </div>
                        </label>
                        <label for="source-esp" class="radio-card">
                            <input type="radio" name="source" id="source-esp" value="esp">
                            <div>
                                <span class="fi fi-es fis"></span>
                                Corriente Roja (Estado Espanhol)
                            </div>
                        </label>
                    </div>
                    <h4 class="form-section-header">Method</h4>
                    <div style="display:flex;flex-direction:column;">
                        <label for="method-priority" class="radio-card">
                            <input type="radio" name="method" id="method-priority" value="priority" checked>
                            <div>
                                Priority (* only for Spanish and Portuguese)
                            </div>
                        </label>
                        <label for="method-sevendays" class="radio-card">
                            <input type="radio" name="method" id="method-sevendays" value="lastweek">
                            <div>
                                Seven days
                            </div>
                        </label>
                        <label for="method-lastfive" class="radio-card">
                            <input type="radio" name="method" id="method-lastfive" value="lastfive">
                            <div>
                                Last 5
                            </div>
                        </label>
                        <label for="method-lastten" class="radio-card">
                            <input type="radio" name="method" id="method-lastten" value="lastten">
                            <div>
                                Last 10
                            </div>
                        </label>
                        <label for="method-lasttwenty" class="radio-card">
                            <input type="radio" name="method" id="method-lasttwenty" value="lasttwenty">
                            <div>
                                Last 20
                            </div>
                        </label>
                    </div>
                    <input type="submit" value="Generate" onclick="generateBulletin()" />
                </form>
            </div>
            <div class="bulletin-container card">
                <div class="bulletin-item active">
                    <h5>Click to copy</h5>
                    <div id="bulletin-card" class="bulletin-card" onclick="copyToClipboard(event)">
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function unicodeToEmoji(unicodeStr) {
            let codePoints = unicodeStr.split(' ').map(code => {
                return parseInt(code.replace('\\u{', '').replace('}', ''), 16);
            });
            return String.fromCodePoint(...codePoints);
        }

        const today = new Date();
        const day = String(today.getDate()).padStart(2, '0');
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Janeiro é 0!
        const year = today.getFullYear();

        const formattedDate = day + '/' + month + '/' + year;


        function generateBulletin() {
            event.preventDefault()
            form = document.querySelector('.bulletin-generator')
            source = form.querySelector('input[name=source]:checked').value
            method = form.querySelector('input[name=method]:checked').value

            fetch('./src/Controller/BulletinController.php?source=' + source + '&method=' + method)
                .then(resp => resp.json())
                .then(data => {

                    place = document.querySelector('.bulletin-card')
                    place.innerHTML = '';
                    header = document.createElement('p');
                    console.log('Method id: ', method)
                    switch (source) {
                        case "pt":
                            headerText = unicodeToEmoji('\\u{1F4E2}') + ' *Boletim da Liga Internacional dos Trabalhadores - Quarta Internacional*'
                            break;
                        case "es":
                            headerText = unicodeToEmoji('\\u{1F4E2}') + ' *Boletín de la Liga Internacional de los Trabajadores - Cuarta Internacional*'
                            break;
                        case "cr":
                            headerText = unicodeToEmoji('\\u{1F4E2}') + ' *Boletín del Partido de la Clase Trabajadora - Costa Rica*'
                            break;
                        case "cl":
                            headerText = unicodeToEmoji('\\u{1F4E2}') + ' *Boletín del Partido Socialista de los Trabajadores - Colombia*'
                            break;
                        case "ch":
                            headerText = unicodeToEmoji('\\u{1F4E2}') + ' *Boletín del Movimento Internacional de los Trabajadores - Chile*'
                            break;
                        case "ar":
                            headerText = unicodeToEmoji('\\u{1F4E2}') + ' *Boletín del Partido Socialista de los Trabajadores Unificado - Argentina*'
                            break;
                            case "esp":
                            headerText = unicodeToEmoji('\\u{1F4E2}') + ' *Boletín de la Corriente Roja - Estado Espanhol*'
                            break;
                    }
                    console.log('HeaderText is: ', headerText)
                    header.innerText = headerText + '\n\n' + formattedDate

                    place.append(header)

                    data.forEach(post => {
                        el = document.createElement('p')
                        link = document.createElement('a')
                        link.href =
                            el.innerText = unicodeToEmoji(post['emoji']) + ' *' + post['category'] + '*\n' + post['title'] + '\n' + post['link']

                        place.append(el)
                    })

                    footer = document.createElement('p')
                    footer.innerText = unicodeToEmoji('\\u{1F534}') + ' *Siga-nos em nossos canais*\n\n' + unicodeToEmoji('\\u{1F4E2}') + '*WhatsApp*\nhttps://whatsapp.com/channel/0029VaCFjFDHQbS0dA0Yzb3g\n\n' + unicodeToEmoji('\\u{1F449} \\u{1F3FD}') + '*Site*\nhttps://litci.org/pt\n\n' + unicodeToEmoji('\\u{1F449} \\u{1F3FD}') + '*YouTube*\nhttps://youtube.com/MarxismoVivo\n\n' + unicodeToEmoji('\\u{1F449} \\u{1F3FD}') + '*Facebook*\nhttps://facebook.com/litci.cuartainternacional\n\n' + unicodeToEmoji('\\u{1F449} \\u{1F3FD}') + '*Instagram*\nhttp://instagram.com/lit.ci/\n\n' + unicodeToEmoji('\\u{1F449} \\u{1F3FD}') + '*Twitter*\nhttp://twitter.com/LITCI'

                    place.append(footer)
                })
        }

        function copyToClipboard(event) {
            id = event.currentTarget.id
            const textToCopy = document.getElementById(id).innerText;
            const tempInput = document.createElement('textarea');
            tempInput.value = textToCopy;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            alert('Texto copiado para o clipboard!');
        }
    </script>
</body> -->