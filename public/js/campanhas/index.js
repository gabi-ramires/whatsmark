
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
        let contatosStr = "";

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
                    <i class="bi bi-pencil blue openModal" onclick='abrirModal(${id})'>E</i>
                    <i class="bi bi-download">D</i>
                    <i class="bi bi-trash-fill red">R</i>
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
  modal.style.display = 'none'; // Esconde o modal
});

// Quando o usuário clica fora do modal, fecha o modal
window.addEventListener('click', function(event) {
  if (event.target == modal) {
    modal.style.display = 'none'; // Esconde o modal
  }
});



var aux = 0;
/**
 *  Abre modal da lista selecionada
 * @param {int} id 
 */
function abrirModal(id){
    modal.style.display = 'block';
    let corpoContatos = document.getElementById('contatos');
    console.log(id)
 
    var name = '';
    var whats = '';
    corpoContatos.innerHTML = '';

    contatosSalvos.forEach(lista => {
        if (lista.id == id) {
            console.log(lista.name);
            $('#nomelista input').val(lista.name);
            $('#idLista').val(id)

            let contatos = JSON.parse(lista.contacts);


            contatos.forEach(contato => {
                console.log(contato)
                name = contato.nome;
                whats = contato.whatsapp;

                corpoContatos.innerHTML += `
                <tr id="${aux}" class="contact">
                    <td style="display:none"><input name="id" value="${id}"></td>
                    <td><input type='text' name="contacts[${aux}][name]" value="${name}"></td>
                    <td><input type='number' name="contacts[${aux}][whatsapp]" value="${whats}"></td>
                    <td><i class="bi bi-trash-fill red" onclick="removecontato(${aux})">R</i></td>
                </tr>
                `;

                aux = aux + 1;
                console.log("aux: "+aux)
            });

        }
    });

    $("#add-contact").click(function() {

        addcontato(id)
    })
    
    
}


/**
 *  Adiciona novo contato na lista
 */
function addcontato(id) {
    let corpoContatos = document.getElementById('contatos');
    
    corpoContatos.innerHTML += `
    <tr id="${aux}" class="contact">
        <td style="display:none"><input name="id" value="${id}"></td>
        <td><input type='text' name="contacts[${aux}][name]" value=""></td>
        <td><input type='number' name="contacts[${aux}][whatsapp]" value=""></td>
        <td><i class="bi bi-trash-fill red" onclick="removecontato(${aux})">R</i></td>
    </tr>
    `;

    aux = aux + 1;

    console.log("aux: "+aux)
}

function removecontato(id) {
    $("#"+id+"").remove();
}