

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
                <td>${id}</td>
                <td>${nome}</td>
                <td>Abrir planilha</td>
                <td>
                    <i class="bi bi-pencil blue openModal" onclick='abrirModal(${id})'></i>
                    <a id="download-${id}"><i class="bi bi-download" onclick='baixaCSV(${id})'></i></a>
                    <i class="bi bi-trash-fill red" onclick="removeLista(${id})"></i>
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
var modalNovaLista = document.getElementById('modalNovaLista');

// Adiciona um event listener para cada botão
btns.forEach(btn => {
   // abrirModal();
});

// Seleciona o elemento de fechar do modal
var span = document.querySelector('.close');
var span2 = document.querySelector('.close2');

// Quando o usuário clica no 'x', fecha o modal
span.addEventListener('click', function() {
  modal.style.display = 'none';
  aux = 0;
});

span2.addEventListener('click', function() {
    modalNovaLista.style.display = 'none';
    aux = 0;
  });

// Quando o usuário clica fora do modal, fecha o modal
window.addEventListener('click', function(event) {
  if (event.target == modal || event.target == modalNovaLista) {
    modal.style.display = 'none';
    modalNovaLista.style.display = 'none';
    aux = 0 ;
  }
});

var aux = 0;
var aux2 = 0;
function abrirModalNovaLista(){

    modalNovaLista.style.display = 'block';

    $("#add-contact2").off("click").on("click", function(event) {
        event.preventDefault();
        addcontato2()

    })
}


/**
 *  Abre modal da lista selecionada
 * @param {int} id 
 */
function abrirModal(id=false){
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

    corpoContatos.insertAdjacentHTML('beforeend', `
    <tr id="${aux}" class="contact">
        <td style="display:none"><input name="id" value="${id}"></td>
        <td><input type='text' name="contacts[${aux}][name]" value=""></td>
        <td><input type='number' name="contacts[${aux}][whatsapp]" value=""></td>
        <td><i class="bi bi-trash-fill red" onclick="removecontato(${aux})"></i></td>
    </tr>
    `);

    aux = aux + 1;

    //console.log("aux: "+aux)
}

/**
 *  Adiciona novo input contato
 */
function addcontato2() {

    let corpoContatos = document.getElementById('contatos2');
    aux2 ++
    
    corpoContatos.insertAdjacentHTML('beforeend', `
    <tr id="${aux2}" class="contact">
        <td style="display:none"><input name="id" value="${aux2}"></td>
        <td><input type='text' name="contacts[${aux2}][name]" placeholder="Nome" required></td>
        <td><input type='number' name="contacts[${aux2}][whatsapp]"  placeholder="55 44 1234-5678" required></td>
        <td><i class="bi bi-trash-fill red" onclick="removecontato(${aux2})"></i></td>
    </tr>
    `);

    console.log("aux2: "+aux2)
}

/**
 *  Remove input contato
 */
function removecontato(id) {
    $("#"+id+"").remove();
}

/**
 * Remove uma lista
 */
function removeLista(id) {

    let nomeLista = "";

    contatosSalvos.forEach(lista => {
        if(id == lista.id) {
            nomeLista = lista.name
        }
    });

    if(confirm(`Confirma a exclusão da lista ${nomeLista}?`)){
        const requestBody = {
            id: id
        };
    
        // Opções da requisição
        const options = {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(requestBody)
        };
    
        // Envia a requisição
        fetch('/delete', options)
            .then(response => {
                // Verifica se a resposta foi bem sucedida
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Erro ao tentar remover a lista');
                }
            })
            .then(data => {
                // Processa a resposta JSON
                console.log(data.message); // Exibe a mensagem retornada pelo servidor
                // Atualize a interface do usuário conforme necessário
            })
            .catch(error => {
                console.error('Erro:', error);
                // Trate o erro conforme necessário
            });
    
            getLists();
    } else {

    }
    
}


/**
 *  Recupera o resultado do envio do formulário "Salvar lista"
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
            getLists();


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



/**
 *  Recupera o resultado do envio do formulário "Criar lista"
 */
document.addEventListener('DOMContentLoaded', function() {
    // Seleciona o formulário pelo ID
    const form = document.getElementById('form-criar-lista');

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

            modalNovaLista.style.display = 'none';
            getLists();

            if(data.status) {
                // faz aparecer o componente
                $("#retorno-lista").css("visibility", "visible");

                // adiciona a cor verde no componente
                $("#retorno-lista").removeClass("retorno-lista-red");
                $("#retorno-lista").addClass("retorno-lista-green");

                // mensagem
                $("#msg").text("Lista criada com sucesso!")

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
                $("#msg").text("Erro ao criar lista.")

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


/**
 * Função para fazer download da lista de contatos em csv
 * @param {int} id 
 */
function baixaCSV(id) {
    console.log(contatosSalvos);
    console.log(id);

    var link = document.getElementById(`download-${id}`);
    var csv = "";
    var nomeLista = "";

    contatosSalvos.forEach(lista => {
        if (id == lista.id) {
            // Convertendo o array de objetos em CSV usando a biblioteca Papaparse
            csv = Papa.unparse(lista.contacts)

            nomeLista = lista.name
        }
    });

    // Criando o URI de dados para o arquivo CSV
    let csvData = 'data:text/csv;charset=utf-8,' + encodeURI(csv);


    // Modificando o atributo href para apontar para os dados CSV
    link.href = csvData;

    // Definindo o nome do arquivo para download
    link.download = `${nomeLista}.csv`;

}