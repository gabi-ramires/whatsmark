
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

    var dataAtual = new Date();
    // Obtém o ano, mês e dia atual
    var ano = dataAtual.getFullYear();
    var mes = (dataAtual.getMonth() + 1 < 10 ? '0' : '') + (dataAtual.getMonth() + 1);
    var dia = (dataAtual.getDate() < 10 ? '0' : '') + dataAtual.getDate();

    // Obtém as horas e minutos atuais
    var horas = (dataAtual.getHours() < 10 ? '0' : '') + dataAtual.getHours();
    var minutos = (dataAtual.getMinutes() < 10 ? '0' : '') + dataAtual.getMinutes();

    // Formata a data e hora como uma string no formato "YYYY-MM-DDTHH:MM"
    var dataHoraFormatada = ano + '-' + mes + '-' + dia + 'T' + horas + ':' + minutos;


    var dados = [texto, id,'imediato',dataHoraFormatada]

        fetch(`/api/client/sendCampanha/a1d0c6e83f027327d8461063f4ac58a6`, {
            method: 'POST',
            headers: {
                'accept': '*/*',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "contatos": JSON.stringify(contatos),
                "contentType": "string",
                "content": texto,
                "id_lista": dados[1],
                "tipo_envio": dados[2],
                "horario_envio": dados[3]
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

                $("#textarea").val("");


                logarEnvio(dados)
                
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

}

/**
 * Abrir campo para agendar
 */
$("#agendar").click(function () {
    $("#calendario").css("display","flex")
})

/**
 * Agendar mensagem de whats
 */
$('#form-agendar').submit(function(event) {
    // Impedir o envio do formulário padrão
    event.preventDefault();
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

        var dados = [texto, id,'agendado',data]

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
                "id_lista": dados[1],
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

                $("#textarea").val("");

                logarEnvio(dados)
                
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

function logarEnvio(data) {

    fetch('/storeEnvios', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            "mensagem_enviada": data[0],
            "titulo" : $("#titulo").val(),
            "lista_enviada": data[1],
            "tipo_envio": data[2],
            "horario_envio" : data[3],
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao enviar os dados');
        }
        return response.json();
    })
    .then(data => {
        console.log('Envio registrado com sucesso:', data);
    })
    .catch(error => {
        console.error('Erro:', error);
    });
}

