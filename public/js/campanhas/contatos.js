
var contatosSalvos = [];
getLists()

/**
 * Busca todas listas do usuário
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
        var name = '';
        var whats = '';
        let corpoListas = document.getElementById('corpo-listas');
        corpoListas.innerHTML = "";
        let contatosStr = "";
        contatosSalvos = [];

        data.forEach(lista => {
            console.log(lista)
            let id = lista.id;
            let nome = lista.name;
            let contatos = JSON.parse(lista.contacts);
            contatosSalvos.push(lista)

            contatos.forEach(contato => {
                name = contato.nome;
                whats = contato.whatsapp;
                contatosStr += `[${name}: ${whats}] `;
            });

            corpoListas.innerHTML += `
            <tr id='${id}'>
                <td>${nome}</td>
                <td>Abrir planilha</td>
                <td>
                    <i class="bi bi-pencil blue openModal" onclick='abrirModal(${id})'></i>
                    <i class="bi bi-download"></i>
                    <i class="bi bi-trash-fill red"></i>
                </td>
            </tr>
            `;
        });
    })
    .catch(error => {
      console.log(error)
    });
    
}


// Seleciona todos os botões que devem abrir o modal
var btns = document.querySelectorAll('.openModal');

// Seleciona o modal
var modal = document.getElementById('myModal');

// Adiciona um event listener para cada botão
btns.forEach(btn => {
    abrirModal();
});

// Seleciona o elemento de fechar do modal
var span = document.querySelector('.close');

// Quando o usuário clica no 'x', fecha o modal
span.addEventListener('click', function() {
  modal.style.display = 'none';
  aux = 0;
});

// Quando o usuário clica fora do modal, fecha o modal
window.addEventListener('click', function(event) {
  if (event.target == modal) {
    modal.style.display = 'none';
    aux = 0 ;
  }
});



var aux = 0;
/**
 *  Abre modal da lista selecionada
 * @param {int} id 
 */
function abrirModal(id){
    getLists();

    modal.style.display = 'block';
    let corpoContatos = document.getElementById('contatos');
    //console.log(id)
 
    var name = '';
    var whats = '';
    corpoContatos.innerHTML = '';

    contatosSalvos.forEach(lista => {
        if (lista.id == id) {
            //console.log(lista.name);
            $('#nomelista input').val(lista.name);
            $('#idLista').val(id)

            let contatos = JSON.parse(lista.contacts);


            contatos.forEach(contato => {
                //console.log(contato)
                name = contato.nome;
                whats = contato.whatsapp;

                corpoContatos.innerHTML += `
                <tr id="${aux}" class="contact">
                    <td style="display:none"><input name="id" value="${id}"></td>
                    <td><input type='text' name="contacts[${aux}][name]" value="${name}"></td>
                    <td><input type='number' name="contacts[${aux}][whatsapp]" value="${whats}"></td>
                    <td><i class="bi bi-trash-fill red" onclick="removecontato(${aux})"></i></td>
                </tr>
                `;

                aux = aux + 1;
                //console.log("aux: "+aux)
            });

        }
    });

    $("#add-contact").off("click").on("click", function(event) {
        event.preventDefault();
        addcontato(id)

    })
    
}


/**
 *  Adiciona novo input contato
 */
function addcontato(id) {

    let corpoContatos = document.getElementById('contatos');
    
    corpoContatos.innerHTML += `
    <tr id="${aux}" class="contact">
        <td style="display:none"><input name="id" value="${id}"></td>
        <td><input type='text' name="contacts[${aux}][name]" value=""></td>
        <td><input type='number' name="contacts[${aux}][whatsapp]" value=""></td>
        <td><i class="bi bi-trash-fill red" onclick="removecontato(${aux})"></i></td>
    </tr>
    `;

    aux = aux + 1;

    //console.log("aux: "+aux)
}

/**
 *  Remove input contato
 */
function removecontato(id) {
    $("#"+id+"").remove();
}


/**
 *  Recupera o resultado do envio do formulário
 */
document.addEventListener('DOMContentLoaded', function() {
    // Seleciona o formulário pelo ID
    const form = document.getElementById('form-salvar-lista');

    // Adiciona um evento de submissão ao formulário
    form.addEventListener('submit', function(event) {
        // Impede o comportamento padrão de envio do formulário
        event.preventDefault();

        // Obtém os dados do formulário
        const formData = new FormData(form);

        // Envia uma requisição assíncrona utilizando fetch
        fetch(form.action, {
            method: form.method,
            body: formData
        })
        .then(response => response.json())
        .then(data => {

            console.log(data);

            modal.style.display = 'none';

            if(data.status) {
                // faz aparecer o componente
                $("#retorno-lista").css("visibility", "visible");

                // adiciona a cor verde no componente
                $("#retorno-lista").removeClass("retorno-lista-red");
                $("#retorno-lista").addClass("retorno-lista-green");

                // mensagem
                $("#msg").text("Lista atualizada com sucesso!")

                // muda para icone de sucesso
                $("#retorno-lista i").removeClass("bi bi-x-circle")
                $("#retorno-lista i").addClass("bi bi-check-circle")
                
            } else {
                // faz aparecer o componente
                $("#retorno-lista").css("visibility", "visible");

                // adiciona a cor vermelha no componente
                $("#retorno-lista").removeClass("retorno-lista-green");
                $("#retorno-lista").addClass("retorno-lista-red");

                // mensagem
                $("#msg").text("Erro ao atualizar lista.")

                // muda para icone de sucesso
                $("#retorno-lista i").removeClass("bi bi-check-circle")
                $("#retorno-lista i").addClass("bi bi-x-circle")
            }

            setTimeout(function() {
                $("#retorno-lista").css("visibility", "hidden");
            }, 3000);

        })
        .catch(error => {
            console.error('Erro ao enviar a requisição:', error);

        });
    });
});

