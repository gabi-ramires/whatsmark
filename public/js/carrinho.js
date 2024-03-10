$(document).ready(function(){
    // Evento de clique no botão de rádio Pix
    $("#finalizar-compra").click(function(){
        if($("#pix").is(":checked")) {
            
            // Desaparece carrinho
            $("#carrinho").css('display','none');

            // Aparece o pix
            $("#pagamento-pix").css('display','block');

            // Pega o slug recebido do carrinho
            var slug = $('#finalizar-compra').attr('name');
            console.log(slug)

            // Pega o userId recebido do carrinho
            var userId = $('#finalizar-compra').attr('data');
            console.log(userId)


            // Pega o cpf recebido do carrinho
            var cpf = $('#cpf').val();
            console.log(cpf)

            //Requisição para gerar pedido
            pedido(userId, cpf, slug)
            
        }
    });


});

//Requisição para gerar pedido
function pedido(userId, cpf, slug) {
    fetch('/pedido', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
                'userId': userId,
                'cpf': cpf,
                'slug': slug 
        })
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        if(data.success){

            //Criando a imagem do QR Code
            var img = $('<img>');
            img.attr('src', 'data:image/png;base64,'+data.qr_code_64);
            $('#pagamento-pix').append(img);

            //Expiracao
            $("#expiracao").html(data.data_expiracao)
        }

    })
    .catch(error => {
        console.error(error);
    });
}


