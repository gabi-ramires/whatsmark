
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



/***********************************************************************
 *                          CADASTRO
 *   Descrição: Funções para realizar o cadastro
 *   
 ***********************************************************************/
// Cadastro
$('#form-cadastro').submit(function(event) {
    // Impedir o envio do formulário padrão
    event.preventDefault();

    var formData = {
        name: $('#nome').val(),
        email: $('#email').val(),
        password: $('#senha').val(),
        repeatPassword: $('#repete-senha').val(),
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

            // faz aparecer o componente
            $("#retorno-cadastro").css("visibility", "visible");

            // adiciona a cor verde no componente
            $("#retorno-cadastro").removeClass("retorno-registro-red");
            $("#retorno-cadastro").addClass("retorno-registro-green");

            // mensagem
            $("#msg").text("Cadastro realizado com sucesso!")

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

        },
        error: function(xhr, status, error) {
            console.error('There was a problem with the ajax operation:', error);

            // faz aparecer o componente
            $("#retorno-cadastro").css("visibility", "visible");

            // adiciona a cor vermelha no componente
            $("#retorno-cadastro").removeClass("retorno-registro-green");
            $("#retorno-cadastro").addClass("retorno-registro-red");

            // mensagem
            $("#msg").text("Não foi possível realizar o cadastro.")

            // muda para icone de erro
            $("#retorno-cadastro i").removeClass("bi bi-check-circle")
            $("#retorno-cadastro i").addClass("bi bi-x-circle")
            
        }
    });
});

// Verifica se nome está preenchido
$('#nome').on('input',function(){
    var nome = $('#nome').val();
    if (nome.trim() !== ""){
        //some mensagem de erro
        $(".nome").css("visibility", "hidden");

        //cor verde no input
        $("#nome").removeClass("error")
        $("#nome").addClass("sucess")
        
        // cor verde no icone
        $(".bi-emoji-smile").removeClass("error-icon")
        $(".bi-emoji-smile").addClass("sucess-icon")
    } else {
        // aparece a mensagem de erro
        $(".nome").css("visibility", "visible");
        $(".nome span").text("Nome inválido");

        // cor vermelha no input
        $("#nome").removeClass("sucess")
        $("#nome").addClass("error")

        // cor vermelha no icone
        $(".bi-emoji-smile").removeClass("sucess-icon")
        $(".bi-emoji-smile").addClass("error-icon")

    }
})

// Verifica se email já existe no banco
$('#email').on('input',function(){
    var email = $('#email').val();
    if (email.trim() !== ""){
        var formData = {
            email: email
        };

        $.ajax({
            url: '/verification',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(data) {
                console.log(data)
                //some mensagem de erro
                $(".email").css("visibility", "hidden");

                //cor verde no input
                $("#email").removeClass("error")
                $("#email").addClass("sucess")
                
                // cor verde no icone
                $(".bi-envelope").removeClass("error-icon")
                $(".bi-envelope").addClass("sucess-icon")

            },
            error: function(xhr, status, error) {
                console.error('There was a problem with the ajax operation:', error);
                // aparece a mensagem de erro
                $(".email").css("visibility", "visible");
                $(".email span").text("Email não disponível");

                // cor vermelha no input
                $("#email").removeClass("sucess")
                $("#email").addClass("error")

                // cor vermelha no icone
                $(".bi-envelope").removeClass("sucess-icon")
                $(".bi-envelope").addClass("error-icon")
            }
        });
    }
})

// Verifica se senha está preenchida e com 8 caracteres
$('#senha').on('input',function(){
    var senha = $('#senha').val();
    if (senha.length >=  8){
        //some mensagem de erro
        $(".senha").css("visibility", "hidden");

        //cor verde no input
        $("#senha").removeClass("error")
        $("#senha").addClass("sucess")
        
        // cor verde no icone
        $(".bi-lock").removeClass("error-icon")
        $(".bi-lock").addClass("sucess-icon")
    } else {
        // aparece a mensagem de erro
        $(".senha").css("visibility", "visible");
        $(".senha span").text("Mínimo de 8 caracteres");

        // cor vermelha no input
        $("#senha").removeClass("sucess")
        $("#senha").addClass("error")

        // cor vermelha no icone
        $(".bi-lock").removeClass("sucess-icon")
        $(".bi-lock").addClass("error-icon")

    }
})

// Verifica se senha está preenchida e com 8 caracteres
$('#repete-senha').on('input',function(){
    var senha = $('#senha').val();
    var repeteSenha = $('#repete-senha').val();

    if (senha == repeteSenha){
        //some mensagem de erro
        $(".repete-senha").css("visibility", "hidden");

        //cor verde no input
        $("#repete-senha").removeClass("error")
        $("#repete-senha").addClass("sucess")
        
        // cor verde no icone
        $(".bi-lock-fill").removeClass("error-icon")
        $(".bi-lock-fill").addClass("sucess-icon")
    } else {
        // aparece a mensagem de erro
        $(".repete-senha").css("visibility", "visible");
        $(".repete-senha span").text("As senhas precisam ser iguais.");

        // cor vermelha no input
        $("#repete-senha").removeClass("sucess")
        $("#repete-senha").addClass("error")

        // cor vermelha no icone
        $(".bi-lock-fill").removeClass("sucess-icon")
        $(".bi-lock-fill").addClass("error-icon")

    }
})

//Clicou em login, verifica se veio do carrinho
$("#login").click(function() {
    
    if(veioDoCarrinho) {
        window.location.href = '/login?produto='+veioDoCarrinho+'';
    } else {
        window.location.href = '/login';
    }
})
