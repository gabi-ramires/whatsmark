
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
        console.error(error);
    }
}




/**
 * Abre/fecha emojis
 */
$('.em').click(function() {
    var ID = $(this).attr('id');
    var id = ID.toLowerCase();

    // Fecha todos os emojis que estão abertos
    $('.emojis').not(`#${id}`).hide();

    // Abre/fecha o emoji atual
    $(`#${id}`).toggle();
});



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
        data.forEach((lista, index) => {
            var option = $('<option>', {
                value: lista.id,
                text: lista.name
            });

            // Definindo a primeira opção como selecionada por padrão
            if (index === 0) {
                option.attr('selected', 'selected');
            }

            $('#select').append(option);
        });


        // 2 - Obtendo o ID da option selecionada
        var id = $('#select').val();
        var textoSelecionado = $('#select').find('option:selected').text();
        $('#nome-contato').text(textoSelecionado)

        $('#select').on('change', function() {
            id = $(this).val();
            textoSelecionado = $(this).find('option:selected').text();
            $('#nome-contato').text(textoSelecionado)
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
            if(data.success) {
                // faz aparecer o componente
                $("#retorno-envio").css("visibility", "visible");

                // adiciona a cor verde no componente
                $("#retorno-envio").removeClass("retorno-envio-red");
                $("#retorno-envio").addClass("retorno-envio-green");

                // mensagem
                $("#msg").text("Envio realizado com sucesso!")

                // muda para icone de sucesso
                $("#retorno-envio i").removeClass("bi bi-x-circle")
                $("#retorno-envio i").addClass("bi bi-check-circle")
                
            } else {
                // faz aparecer o componente
                $("#retorno-envio").css("visibility", "visible");

                // adiciona a cor vermelha no componente
                $("#retorno-envio").removeClass("retorno-envio-green");
                $("#retorno-envio").addClass("retorno-envio-red");

                // mensagem
                $("#msg").text("Erro ao atualizar envio.")

                // muda para icone de sucesso
                $("#retorno-envio i").removeClass("bi bi-check-circle")
                $("#retorno-envio i").addClass("bi bi-x-circle")
            }
        })
        .catch(error => {
            console.error('Ocorreu um erro:', error);
        });

    });
}


/**
 * Agendar mensagem de whats
 */
$("#envio-agendado").click(function(){
    var listaContatos;
    (async () => {

        // Busca as listas
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
            id = $("#select").val();

            data.forEach(lista => {
                if(id == lista.id){
                    listaContatos = lista.contacts;

                    listaContatos = JSON.stringify(listaContatos);
                }
            });
        })
        
        var texto = $('#textarea').val()
        var data = $("#data-agendada").val()
        var idSession = await getIdSession();

        fetch(`/api/client/sendMessageAgendado/${idSession}`, {
            method: 'POST',
            headers: {
                'accept': '*/*',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "chatId": "555180187026@c.us",
                "contentType": "string",
                "content": texto,
                "lista" : listaContatos,
                "data": data
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao agendar a mensagem');
            }
            return response.json();
        })
        .then(data => {
            console.log(data)
            if(data.status) {
                // faz aparecer o componente
                $("#retorno-envio").css("visibility", "visible");

                // adiciona a cor verde no componente
                $("#retorno-envio").removeClass("retorno-envio-red");
                $("#retorno-envio").addClass("retorno-envio-green");

                // mensagem
                $("#msg").text("Envio agendado com sucesso!")

                // muda para icone de sucesso
                $("#retorno-envio i").removeClass("bi bi-x-circle")
                $("#retorno-envio i").addClass("bi bi-check-circle")
                
            } else {
                // faz aparecer o componente
                $("#retorno-envio").css("visibility", "visible");

                // adiciona a cor vermelha no componente
                $("#retorno-envio").removeClass("retorno-envio-green");
                $("#retorno-envio").addClass("retorno-envio-red");

                // mensagem
                $("#msg").text("Erro ao agendar envio.")

                // muda para icone de sucesso
                $("#retorno-envio i").removeClass("bi bi-check-circle")
                $("#retorno-envio i").addClass("bi bi-x-circle")
            }
        })
        .catch(error => {
            console.error('Ocorreu um erro:', error);
        });

    })();

})


/**
 * Liga/desliga a tela do celular
 */
var ligado = true
$("#botao-liga-desliga").click(function(){
    if (ligado) {
        ligado = false;
        $(".screen").css('background-color','black')
        $(".screen").css('z-index','-1')

    } else {
        ligado = true
        $(".screen").css('background-color','white')
        $(".screen").css('z-index','0')     
    }

})

