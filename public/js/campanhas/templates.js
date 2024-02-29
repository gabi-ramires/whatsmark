

/**
 * Abre/fecha emojis
 */
$('.em').click(function() {
    var ID = $(this).attr('id');
    var id = ID.toLowerCase()

    $(`#${id}`).toggle();
})


/**
 * Adiciona emoji selecionado na caixa
 */
$('.emoji-large').click(function() {
    var conteudo = $(this).text();
    var conteudoAtual = $('#textarea').val();
    $('#textarea').val(conteudoAtual + conteudo);

    // Atualiza frame do celular
    $('#texto-whats').html($('#textarea').val());
    var contentu = $('#textarea').val().replace(/\n/g, '<br>'); // Substitui todas as quebras de linha por <br>
    $('#texto-whats').html(contentu);
})


/**
 * Atualiza frame celular
 */
$('#textarea').on('input', function() {
    $('#textarea').on('input', function() {
        var content = $(this).val()
        .replace(/\n/g, '<br>') // Substitui quebras de linha por <br>
        .replace(/\*([^*]*)\*/g, function(match, group1) {
            return '<strong>' + group1 + '</strong>';
        });
        $('#texto-whats').html(content);
    });
    

    $('.received').css('display', 'none');
});

/**
 * Adiciona quebra de linha no frame do celular
 */
$('#textarea').keydown(function(e) {
    if (e.which === 13) {
        console.log('apertou')
        var content = $(this).val();
        $('#texto-whats').html(content + '</br>');
    }
});


var listas = []
/**
 * Busca todas listas do usuário e adiciona no array listas
 */
function getLists() {

    fetch(`/getLists`, {
    method: 'POST',
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
        listas.push(data)

        // 1 - Montando select da lista
        data.forEach(lista => {
            $('#select').append($('<option>', {
                value: lista.id,
                text: lista.name
            }));
        });

        // 2 - Obtendo o ID da option selecionada
        var id = $('#select').val();
        $('#select').on('change', function() {
            id = $(this).val();
        });


        // 3 - Ação ao clicar em Enviar
        $('#submit').click(function() {
            enviarWhats(data,id)
        })
        
    })
    .catch(error => {
      console.log(error)
    });

}


getLists();


/**
 * Enviar a mensagem de whats
 */
function enviarWhats(lista,id) {
    var texto = $('#textarea').val()
    var contatos = ''

    event.preventDefault(); // Impede o envio padrão do formulário

    lista.forEach(elemento => {
        if (id == elemento.id) {
            contatos = elemento.contacts
        }
    });

    // Transforma todos os contatos em array
    contatos = JSON.parse(contatos);
    console.log(contatos)

    contatos.forEach(contato => {
        let nome = contato.nome
        let phone = contato.whatsapp

        fetch(`/api/client/sendMessage/a1d0c6e83f027327d8461063f4ac58a6`, {
            method: 'POST',
            headers: {
                'accept': '*/*',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "chatId": phone+"@c.us",
                "contentType": "string",
                "content": texto
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
        })
        .catch(error => {
            console.error('Ocorreu um erro:', error);
        });

    });
}
