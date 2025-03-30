async function createCity(name, state,id) {
    let response = await sendRequest({ action: 'addCity', data: { name: name, active: state,id: id } });
    if(response.result === true) {
        document.getElementById("dialog-container").click();
        await updateCities();
    }else{
        alert(response.message);
    }
}

async function editCity(id){
    let response = await sendRequest({action:'deleteCity',data: {id:id}});
    if(response === true) {
        await updateCities();
    }else{
        alert(response.message);
    }
}

async function deleteCity(id){
    let response = await sendRequest({action:'deleteCity',data: {id:id}});
    if(response.result === true) {
        await updateCities();
    }else{
        alert(response.message);
    }
}

async function updateActiveCity(id,state){
    let response = await sendRequest({action:'updateActiveCity',data: {id:id,active:!state}});
    if(response.result === true) {
        await updateCities();
    }else{
        alert(response.message);
    }
}

function sendRequest(body) {
    return fetch(prepareUrl(), {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(body)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Ошибка HTTP: ${response.status}`);
            }
            return response.json();
        })
        .catch(error => {
            console.error("Ошибка при выполнении запроса:", error);
            throw error; // Прокидываем ошибку дальше
        });
}

async function updateCities() {
    document.getElementById("main_body").innerHTML = await fetch(prepareUrl(), {method:"GET"}).then(response => {
        return response.text();
    });
}

function prepareUrl(){
    const currentUrl = window.location.href;
    const urlWithoutHash = currentUrl.split("#")[0];
    let url = currentUrl;
    if (window.location.hash) {
        const hashParams = window.location.hash.substring(1);
        url = `${urlWithoutHash}?${hashParams}`;
    }
    return url;
}
