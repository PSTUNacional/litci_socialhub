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
            console.log('Method id: ',method)
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
            }
            console.log('HeaderText is: ',headerText)
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
