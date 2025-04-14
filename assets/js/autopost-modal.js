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

    place = document.getElementById('captions-list');
    place.innerHTML = `<div class="loader"></div>`

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

        // Add custom caption option
        card = document.createElement('label')
        card.classList.add('card-selector')
        card.classList.add('custom')
        card.innerHTML = `
            <input type="radio" name="caption" value="custom" />
                <div class="card-selector-content">
                <div style="display:flex; gap:16px; align-items:center;">
                    <span class="icon"><i class="material-icons">check_circle</i></span>
                    <p>Custom caption</p>
                    </div>
                    <textarea id="custom-caption" style="width:100%; padding: 8px" rows="5" placeholder="Write your caption here..."></textarea>
                </div>
            `
        place.appendChild(card)

        // Select first caption by default
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

    // Set Loader
    let loader = document.querySelector('#step-3 #loader');
    loader.style.display = 'flex';
    changeStep('step-3')

    
    let link = document.querySelector('#postSelector option:checked').getAttribute('data-link');
    let account = document.querySelector('#step-1 input:checked').value;;
    let imageUploaded = await saveTempImage('bannerFourPlace');
    let caption = document.querySelector('#captions-list input:checked').value;
    if (caption == 'custom') {
        caption = document.querySelector('#custom-caption').value;
    }

    let facebook = true
    let instagram = true

    if(!imageUploaded) {
        alert('Erro ao enviar imagem temporária.');
        return;
    }

    formData = new FormData();
    formData.append('account', account)
    formData.append('facebook', facebook)
    formData.append('instagram', instagram)
    formData.append('caption', caption)
    formData.append('link', link)

    fetch('/src/Controller/AutoPostController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        // Hide loader
        loader.style.display = 'none';
        let resultContainer = document.querySelector('#step-3 #result');
        resultContainer.style.display = 'flex';
        document.querySelector('#step-3 .actions').style.display = 'flex';
        
        if (result.facebook.status == 'success'|| result.instagram.status == 'success') {
            document.querySelector('#step-3 #result h3').innerText = 'Post published successfully!';
        } else if (result.facebook.status == 'error'|| result.instagram.status == 'error'){
            document.querySelector('#step-3 #result h3').innerText = 'Post not published =/';
        } else {
            document.querySelector('#step-3 #result h3').innerText = 'Post published partially';
        }

        facebook ? document.querySelector('#step-3 #result .facebook').style.display = 'block' : '';
        instagram ? document.querySelector('#step-3 #result .instagram').style.display = 'block' : '';

        document.querySelector('#step-3 #result .facebook p').innerText = result.facebook.message;
        document.querySelector('#step-3 #result .instagram p').innerText = result.instagram.message;
    })
}