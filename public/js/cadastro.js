
/***********************************************************************
 *                          DIVERSAS
 *   Descrição: Funções para uma melhor usabilidade
 *   
 ***********************************************************************/

// Armazenar os placeholders originais quando a página carregar
var originalPlaceholders = {};

$(document).ready(function() {
    $('.input-with-icon').each(function() {
        var id = $(this).attr('id');
        var placeholder = $(this).attr('placeholder');
        originalPlaceholders[id] = placeholder;
    });
});

// Remover placeholder quando o campo receber foco
$('#nome, #email, #senha, #repete-senha').focus(function() {
    var valor = $(this).val();
    if (valor == ""){
        $(this).attr('placeholder', '');
    }
});

// Restaurar placeholder quando o campo perder foco e estiver vazio
$('#nome, #email, #senha, #repete-senha').blur(function() {
    var valor = $(this).val();
    var id = $(this).attr('id'); // Acessando o id do elemento
    if (valor == ""){
        $(this).attr('placeholder', originalPlaceholders[id]); // Restaurando o placeholder original
    }
});

/***********************************************************************
 *                          CADASTRO
 *   Descrição: Funções para realizar o cadastro
 *   
 ***********************************************************************/

$('#form-cadastro').submit(function(event) {
    // Impedir o envio do formulário padrão
    event.preventDefault();

    var formData = {
        name: $('#nome').val(),
        email: $('#email').val(),
        password: $('#senha').val(),
        // Adicionar o token CSRF
        _token: $('meta[name="csrf-token"]').attr('content')
    };

    $.ajax({
        url: '/register',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function(data) {
            console.log(data);
            window.location.href = '/painel';
        },
        error: function(xhr, status, error) {
            console.error('There was a problem with the ajax operation:', error);
        }
    });
});

