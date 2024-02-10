
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
$('#email, #password').focus(function() {
    var valor = $(this).val();
    if (valor == ""){
        $(this).attr('placeholder', '');
    }
});

// Restaurar placeholder quando o campo perder foco e estiver vazio
$('#email, #password').blur(function() {
    var valor = $(this).val();
    var id = $(this).attr('id'); // Acessando o id do elemento
    if (valor == ""){
        $(this).attr('placeholder', originalPlaceholders[id]); // Restaurando o placeholder original
    }
});

/***********************************************************************
 *                          LOGIN
 *   Descrição: Funções para realizar o cadastro
 *   
 ***********************************************************************/

$('#form-login').submit(function(event) {
    // Impedir o envio do formulário padrão
    event.preventDefault();

    var formData = {
        email: $('#email').val(),
        password: $('#password').val(),
        // Adicionar o token CSRF
        _token: $('meta[name="csrf-token"]').attr('content')
    };

    console.log(formData);

    $.ajax({
        url: '/login',
        type: 'POST',
        data: formData,
        success: function(data) {
            console.log(data);
            if(data.redirect) {
                window.location.href = data.redirect;
            }
        },
        error: function(xhr, status, error) {
            console.error('There was a problem with the ajax operation:', error);
        }
    });
});


