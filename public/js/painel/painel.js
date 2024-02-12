var componenteSetup = document.getElementById('setup');
var sessionID = 'd67d8ab4f4c10bf22aa353e27879133c';
/**
 * Verifica a conexão (se o qrcode já foi escaneado)
 */
function verificaConexao() {
    fetch(`/api/session/status/${sessionID}`, {
    method: 'GET',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        console.log(data)

        if (data.state == "CONNECTED") {
            componenteSetup.style.visibility = 'hidden'
            alert("oi")
        }
    })
    .catch(error => {
      
    });
    
}


function getIdSession() {
    fetch(`/getIdSession`, {
    method: 'GET',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        console.log(data)

    })
    .catch(error => {
      
    });
    
}

document.addEventListener('DOMContentLoaded', getIdSession);