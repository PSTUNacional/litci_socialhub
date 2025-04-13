var modal = document.getElementById("modal-container");

function openModal() {
    modal.classList.toggle("active")
}

modal.addEventListener("click", openModal)
modal.querySelector('div').addEventListener("click", function (event) {
    event.stopPropagation();
}) 


function changeStep(id){
    document.querySelectorAll('fieldset').forEach((fieldset) => {
        fieldset.style.display = 'none';
    })

    document.getElementById(id).style.display = 'flex';
}


async function renderCaptions(){
    let language
    switch (source){
        case 'es':
            language = 'spanish'
            break;
        case 'pt':
            language = 'portuguese'
            break;
    }

    let link = document.querySelector('#postSelector option:checked').getAttribute('data-link') 

    fetch('/api/openai',{
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
          method: "createcaptions",
          type: "url",
          content: link,
          language: language,
        })
      })
      .then(resp => resp.json())
      .then(data => {
        place = document.getElementById('captions-list');
        place.innerHTML = '';
        data.forEach((caption)=>{
            card = document.createElement('label')
            card.classList.add('card-selector')
            card.innerHTML = `
            <input type="radio" name="caption" value="${caption}" />
                <div class="card-selector-content">
                    <span class="icon"><i class="material-icons">check_circle</i></span>
                    <p>${caption}</p>
                </div>
            `
            place.appendChild(card)
        })
        place.querySelector('input').checked = true;
      })
      .catch(error => console.error('Erro na requisição:', error));

}

function autoPostStart()
{
    openModal()
    changeStep('step-1')
    renderCaptions()
}

async function saveTempImage(source) {
    const canvas = document.getElementById(source).querySelector('canvas');

    return new Promise((resolve, reject) => {
        canvas.toBlob(function(blob) {
            const formData = new FormData();
            const filename = `bannerToPost.png`;

            formData.append('image', blob, filename);

            fetch('/src/Service/TempImageService.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                resolve(result.status);
            })
            .catch(error => {
                console.error('Erro ao enviar imagem:', error);
                reject(error);
            });
        }, 'image/png');
    });
}

async function autoPostPublish() {
    let caption = document.querySelector('input[name="caption"]:checked').value;
    let link = document.querySelector('#postSelector option:checked').getAttribute('data-link');
    let account = document.querySelector('#step-1 input:checked').value;;
    let imageUploaded = await saveTempImage('bannerOnePlace');

    if(!imageUploaded) {
        alert('Erro ao enviar imagem temporária.');
        return;
    }

    formData = new FormData();
    formData.append('account', account)
    formData.append('facebook', true)
    formData.append('instagram', true)
    formData.append('caption', caption)
    formData.append('link', link)

    fetch('/src/Controller/AutoPostController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.status) {
            alert('Postagem agendada com sucesso!');
        } else {
            alert('Erro ao agendar postagem.');
        }
    })
    .catch(error => {
        console.error('Erro ao enviar imagem:', error);
        alert('Erro ao agendar postagem.');
    });
}