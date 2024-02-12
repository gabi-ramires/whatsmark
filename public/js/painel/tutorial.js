var status = document.getElementById('status')
// Pegar o elemento span pelo ID
var sessionIdElement = document.getElementById('sessionId');
// Obter o valor dentro do elemento span
var sessionID = sessionIdElement.innerText;

/**
 * Inicia sessão
 */
function startSession() {
    var sessao = document.getElementById('sessao')

    fetch(`/api/session/start/${sessionID}`, {
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

        if (data.error == `Session already exists for: ${sessionID}`) {
            sessao.innerText = 'Iniciada';
            sessao.style.color = 'green';
        }

    })
    .catch(error => {
        console.error(error);
    });

}

/**
 * Verifica a conexão (se o qrcode já foi escaneado)
 */
function verificaConexao() {
    var status = document.getElementById('status')
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
            status.innerText = 'Conectado';
            status.style.color = 'green';
        }
    })
    .catch(error => {
      
    });
    
}


/**
 * Função que carrega o QR Code na tela
 */
function carregaQrCode(){
    fetch(`/api/session/qr/${sessionID}/image`, {
        method: 'GET',
        headers: {
            'Accept': 'image/png'
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
        console.error(error);
    });
}


/**
 * Função que faz o envio teste
 */
document.getElementById("myForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Impede o envio padrão do formulário

    // Extrai os valores do formulário
    var phone = document.getElementById("phone");
    var message = document.getElementById("message");

    var log = document.getElementById("log");
    var novoSpan = document.createElement('span');

   
    fetch(`/api/client/sendMessage/${sessionID}`, {
        method: 'POST',
        headers: {
            'accept': '*/*',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            "chatId": phone.value+"@c.us",
            "contentType": "string",
            "content": message.value
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao enviar a mensagem');
        }
        return response.json();
    })
    .then(data => {
        console.log(data)
        phone.value = "";
        message.value = "";

        if (data.success) {
            novoSpan.textContent = 'WhatsApp enviado com sucesso!';
            novoSpan.style.color = 'green';
            log.appendChild(novoSpan);
        } else {
            novoSpan.textContent = 'Não foi possível enviar ...';
            novoSpan.style.color = 'orange';
            log.appendChild(novoSpan);
        }
    })
    .catch(error => {
        console.error('Ocorreu um erro:', error);
    });


});





// Adicionar um ouvinte de evento para o evento DOMContentLoaded
document.addEventListener('DOMContentLoaded', verificaConexao);
document.addEventListener('DOMContentLoaded', startSession);
document.addEventListener('DOMContentLoaded', carregaQrCode);


// Redirecionar para a rota getIdSession quando a página for carregada
if (window.location.pathname !== '/getIdSession') {
    // Redirecionar para a rota getIdSession quando a página for carregada
    window.onload = function() {
        window.location.href = '/getIdSession';
    };
}




