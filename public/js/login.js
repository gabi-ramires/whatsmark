
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
            if(data.success) {
                // faz aparecer o componente
                $("#retorno-cadastro").css("visibility", "visible");

                // adiciona a cor verde no componente
                $("#retorno-cadastro").removeClass("retorno-registro-red");
                $("#retorno-cadastro").addClass("retorno-registro-green");

                // mensagem
                $("#msg").text("Login realizado com sucesso!")

                // muda para icone de sucesso
                $("#retorno-cadastro i").removeClass("bi bi-x-circle")
                $("#retorno-cadastro i").addClass("bi bi-check-circle")
                
                if(veioDoCarrinho) {
                    // Redireciona para o carrinho
                    setTimeout(function() {
                        window.location.href = '/carrinho?produto='+veioDoCarrinho+'';
                    }, 1000);
                } else {
                    // Redireciona para o painel
                    setTimeout(function() {
                        window.location.href = '/painel';
                    }, 1000);
                }

                // Criando cookie
                document.cookie = "usuarioLogado=true; expires=Thu, 18 Dec 2025 12:00:00 UTC; path=/";

            }
        },
        error: function(xhr, status, error) {
            console.error('There was a problem with the ajax operation:', error);
            // faz aparecer o componente
            $("#retorno-cadastro").css("visibility", "visible");

            // adiciona a cor vermelha no componente
            $("#retorno-cadastro").removeClass("retorno-registro-green");
            $("#retorno-cadastro").addClass("retorno-registro-red");

            // mensagem
            $("#msg").text("Email ou senha incorretos.")

            // muda para icone de erro
            $("#retorno-cadastro i").removeClass("bi bi-check-circle")
            $("#retorno-cadastro i").addClass("bi bi-x-circle")
        }
    });
});

// Função para obter o valor de um parâmetro na URL por nome
function obterParametroUrl(nome) {
    var queryString = window.location.search.substring(1);
    var parametros = queryString.split("&");
    for (var i = 0; i < parametros.length; i++) {
        var parametro = parametros[i].split("=");
        if (parametro[0] === nome) {
            return parametro[1];
        }
    }
    return null;
}
var veioDoCarrinho = obterParametroUrl('produto');


