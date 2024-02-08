var status = document.getElementById('status')
// Pegar o elemento span pelo ID
var sessionIdElement = document.getElementById('sessionId');
// Obter o valor dentro do elemento span
var sessionID = sessionIdElement.innerText;

function startSession() {

    alert(sessionID);

    fetch(`/api/session/start/${sessionID}`, {
    method: 'GET',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'x-api-key': 'comunidadezdg.com.br'
    }
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        console.log(data)

    })
    .catch(error => {
        console.error(error);
    });

}

// Definir a função a ser chamada quando a página é carregada
function onPageLoad() {
    var status = document.getElementById('status')
    fetch(`/api/session/status/42342`, {
    method: 'GET',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'x-api-key': 'comunidadezdg.com.br'
    }
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        console.log(data)

        if (data.state == "CONNECTED") {
            status.innerText = 'Iniciada';
            status.style.color = 'green';
        }
    })
    .catch(error => {
      
    });
}

function carregaQrCode(){
    fetch(`/api/session/qr/42342/image`, {
        method: 'GET',
        headers: {
            'Accept': 'image/png', 
            'x-api-key': 'comunidadezdg.com.br'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao carregar a imagem.');
        }
        return response.blob(); // Converte a resposta em um objeto Blob
    })
    .then(blob => {
        console.log(blob)
        var url = URL.createObjectURL(blob);
        var imagem = document.getElementById('imagem');
        imagem.src = url;
        console.log(imagem.src)
    })
    .catch(error => {
        console.error('Erro:', error);
    });
}


document.getElementById("myForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Impede o envio padrão do formulário

    // Extrai os valores do formulário
    var phone = document.getElementById("phone").value;
    var message = document.getElementById("message").value;

    // Monta o objeto com os dados do telefone e da mensagem
    var data = {
    "chatId": phone+"@c.us",
    "contentType": "string",
    "content": message
    };

    var body = JSON.stringify(data)

    
    fetch(`/api/client/sendMessage/42342/${body}`, {
    method: 'POST',
    headers: {
        'Accept': '*/*',
        'Content-Type': 'application/json',
        'x-api-key': 'comunidadezdg.com.br'
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

});



// Adicionar um ouvinte de evento para o evento DOMContentLoaded
document.addEventListener('DOMContentLoaded', onPageLoad);
document.addEventListener('DOMContentLoaded', carregaQrCode);


