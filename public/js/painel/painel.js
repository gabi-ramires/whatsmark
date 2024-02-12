var componenteSetup = document.getElementById('setup');

verificaSeRealizouSetup();

async function verificaSeRealizouSetup() {
    try {
        let sessionId = await getIdSession();
        console.log(sessionId);
        verificaConexao(sessionId);
    } catch (error) {
        console.error('Erro ao verificar se realizou o setup:', error);
    }
}

async function getIdSession() {
    try {
        let response = await fetch(`/getIdSession`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
        let data = await response.json();
        return data.idSession;
    } catch (error) {
        throw error;
    }
}


/**
 * Verifica a conexão (se o qrcode já foi escaneado)
 */
function verificaConexao(sessionID) {
    console.log(sessionID)
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

        if (data.state != "CONNECTED") {
            console.log("Desconectado")
            $('#setup').css("display", "flex");
        } else {
            console.log("Conectado")
            $('#iniciar').css("display", "flex");
        }
    })
    .catch(error => {
      console.log(error)
    });
    
}
