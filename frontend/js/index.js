const titel = document.getElementById('titel')
const fsk = document.getElementById('fsk')
const jahr = document.getElementById('jahr')
const genre1 = document.getElementById('genre1')
const genre2 = document.getElementById('genre2')
const genre3 = document.getElementById('genre3')
const laenge = document.getElementById('länge')
const file = document.getElementById('file')
const submitBtn = document.getElementById('submit-btn')
const overlay = document.getElementById('overlay')
const modal = document.getElementById('modal')
const fehlerHeader = document.getElementById('fehler-header')
const fehlerMessage = document.getElementById('fehler-message')
const modalBtn = document.getElementById('modal-btn')
const searchBtn = document.getElementById('search-btn')
const editBtn = document.getElementById('edit-btn')
const deleteBtn = document.getElementById('delete-btn')
let data = ''
const filmeListe = document.getElementById('filme-liste')
let movieId = ''
const loadIcon = document.getElementById('load-icon');

fillGenreSelectors()
disableEditDeleteButtons()

submitBtn.onclick = function () {
    disableEditDeleteButtons()

    if (EingabenSindOk()) {
        SpeichereFilm();
        maskeLeeren();
    }
}

searchBtn.onclick = async function () {
    await sucheFilm();
    fuelleFilmeListe();
    enableEditDeleteButtons()
    this.style.display = 'none'
    loadIcon.style.display = 'block'
}

editBtn.onclick = async function () {
    if (EingabenSindOk()) {
        await updateFilmeDB();
        maskeLeeren()
        await sucheFilm();
    }
}

deleteBtn.onclick = async function () {
    await loescheFilm()
    maskeLeeren()
    await sucheFilm();
}

modalBtn.onclick = function () {
    overlay.style.display = 'none';
    modal.style.display = 'none';
}

loadIcon.onclick = async function () {
    await sucheFilm();
    fuelleFilmeListe();
}

function getMovieDataFromId(pFilmeId) {
    for (let i = 0; i < data.length; i++) {de
        let current = data[i]

        if (current.FilmeId == pFilmeId) {
            return current;
        }
    }
}

function EingabenSindOk() {

    let errormessage = '';

    if (errormessage === '' && titel.value === "") {
        errormessage = 'Titel fehlt';
        titel.classList.add('input-invalid');
    } else {
        titel.classList.remove('input-invalid');
    }

    if (errormessage === '' && fsk.value === "") {
        errormessage = 'Altersfreigabe fehlt';
        fsk.classList.add('input-invalid');
    } else {
        fsk.classList.remove('input-invalid');
    }

    if (errormessage === '' && jahr.value === "" || jahr.value < 0) {
        errormessage = 'Jahr fehlt oder ungeeignete Eingabe';
        jahr.classList.add('input-invalid');
    } else {
        jahr.classList.remove('input-invalid');
    }

    if (errormessage === '' && genre1.value === "") {
        errormessage = 'Genre1 fehlt';
        genre1.classList.add('input-invalid');
    } else {
        genre1.classList.remove('input-invalid');
    }

    if (errormessage === '' && genre2.value === "") {
        errormessage = 'Genre2 fehlt';
        genre2.classList.add('input-invalid');
    } else {
        genre2.classList.remove('input-invalid');
    }

    if (errormessage === '' && genre3.value === "") {
        errormessage = 'Genre3 fehlt';
        genre3.classList.add('input-invalid');
    } else {
        genre3.classList.remove('input-invalid');
    }

    if (errormessage === '' && länge.value === "" || länge.value < 0) {
        errormessage = 'Länge fehlt oder ungeeignete Eingabe';
        länge.classList.add('input-invalid');
    } else {
        länge.classList.remove('input-invalid');
    }

    // if(errormessage === '' && file.files === ""){
    //     errormessage = 'File fehlt';
    //     file.style.classList.add('input-invalid');
    // }else{
    //     file.classList.remove('input-invalid');
    // }

    if (errormessage !== '') {
        console.log(errormessage);
    }

    return errormessage === '' ? true : false;
}

async function SpeichereFilm() {

    let obj = {
        'titel': titel.value,
        'altersfreigabe': fsk.value,
        'erscheinungsjahr': jahr.value,
        'genres':
            [
                genre1.value,
                genre2.value,
                genre3.value
            ],
        'filmlaenge': laenge.value,
        'file': file.files[0]
    }

    let jsn = JSON.stringify(obj);

    let response = await fetch('http://localhost//MFDB/add_movie.php', {
        "method": 'POST',
        "headers": {
            'Accept': 'application/json'
        },
        "body": jsn
    })


    console.log(response);

    // Prüfen ob der response 'ok' ist 

    data = await response.json();

    showMessage('http-status: ' + response.status, data.errormessage, response.ok == true ? true : false);
}


async function sucheFilm() {

    let response = await fetch('http://localhost/mfdb/get_movies.php', {
        "method": 'POST',
        "headers": {
            'Accept': 'application/json'
        },
    })

    // Prüfen ob der response 'ok' ist

    data = await response.json();

    console.log(data);

    // showMessage('http-status: ' + response.status, '', response.ok == true ? true : false);
}

function fuelleFilmeListe() {

    filmeListe.innerHTML = '';

    for (let i = 0; i < data.length; i++) {
        let zeile = data[i];

        let tr = document.createElement('tr')
        tr.classList.add('movie-entry')
        tr.dataset.filmeid = zeile.FilmeId;  // fragen??
        let td1 = document.createElement('td')
        let td2 = document.createElement('td')
        td1.innerText = zeile.FilmeId;
        td2.innerText = zeile.Titel;

        tr.appendChild(td1)
        tr.appendChild(td2)

        tr.onclick = function () {
            movieId = zeile.FilmeId;
            let movieData = getMovieDataFromId(zeile.FilmeId)
            // Eingabe Maske füllen
            titel.value = movieData.Titel;
            fsk.value = movieData.Altersfreigabe;
            jahr.value = movieData.Erscheinungsjahr;
            genre1.value = movieData.Genre1;
            genre2.value = movieData.Genre2;
            genre3.value = movieData.Genre3;
            laenge.value = movieData.Filmlaenge;
            // file.files[0] = movieData.File;
        }
        filmeListe.appendChild(tr);

    }
}

async function loescheFilm() {

    let obj = {
        'id': movieId
    }

    let jsn = JSON.stringify(obj);

    let response = await fetch('http://localhost//MFDB/delete_movie.php', {
        "method": 'POST',
        "headers": {
            'Accept': 'application/json'
        },
        "body": jsn
    })

    console.log(response);

    // Prüfen ob der response 'ok' ist 

    data = await response.json();

    showMessage('http-status: ' + response.status, data.errormessage, response.ok == true ? true : false);
}

async function updateFilmeDB() {

    let obj = {
        'id': movieId,
        'titel': titel.value,
        'altersfreigabe': fsk.value,
        'erscheinungsjahr': jahr.value,
        'genres':
            [
                genre1.value,
                genre2.value,
                genre3.value
            ],
        'filmlaenge': laenge.value,
        'file': file.files[0]
    }

    let jsn = JSON.stringify(obj);

    let response = await fetch('http://localhost//MFDB/update_movie.php', {
        "method": 'POST',
        "headers": {
            'Accept': 'application/json'
        },
        "body": jsn
    })

    console.log(response);

    // Prüfen ob der response 'ok' ist 

    data = await response.json();

    showMessage('http-status: ' + response.status, data.errormessage, response.ok == true ? true : false);

}


function showMessage(fehler, msg, success) {
    overlay.style.display = 'block';
    modal.style.display = 'block';
    fehlerHeader.innerText = fehler;
    fehlerMessage.innerText = msg;

    if (success) {
        modalBtn.classList.remove('btn-modal-error');
        modalBtn.classList.add('btn-modal-success');
    } else {
        modalBtn.classList.remove('btn-modal-success');
        modalBtn.classList.add('btn-modal-error');
    }
}

async function fillGenreSelectors() {

    let fileContent = await fetch('data/genres.json');

    if (!fileContent.ok) {
        alert('Genres konnten nicht abgerufen werden!');
        return;
    }

    try {
        let obj = await fileContent.json();   // fileContent => response object
        obj.genres.forEach(element => {
            let option = document.createElement('option'); // option html tag (selector) 
            option.value = element;
            option.innerText = element;
            genre1.appendChild(option);  //kind element anfügen
        })

        obj.genres.forEach(element => {
            let option = document.createElement('option');
            option.value = element;
            option.innerText = element;
            genre2.appendChild(option);
        })

        obj.genres.forEach(element => {
            let option = document.createElement('option');
            option.value = element;
            option.innerText = element;
            genre3.appendChild(option);
        })
    } catch (error) {
        alert("Genres konnten nicht geparst werden!");
        alert(error);
    }
}

function disableEditDeleteButtons() {
    editBtn.disabled = true;
    deleteBtn.disabled = true;
    editBtn.classList.remove('btn-background-blue');
    deleteBtn.classList.remove('delete-btn-background');
}

function enableEditDeleteButtons() {
    editBtn.disabled = false;
    deleteBtn.disabled = false;
    editBtn.classList.add('btn-background-blue');
    deleteBtn.classList.add('delete-btn-background');
}

function maskeLeeren() {
    titel.value = ""
    fsk.value = ""
    jahr.value = ""
    genre1.value = ""
    genre2.value = ""
    genre3.value = ""
    länge.value = ""
    file.value = ""
}