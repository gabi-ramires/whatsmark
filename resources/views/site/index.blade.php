@extends('site/navsite')

@section('conteudo')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="{{ asset('css/index-site.css') }}">

<div class="container tela-login index-site">

        <div class='slogan'>
            <span>
                Transformando conexões em oportunidades: <strong>Envie mensagens em massa no WhatsApp com facilidade.</strong>
            </span>

        </div>
        <div class="produtos">
            <div class="card">
                <h2>WhatsMark I</h2>
                <p><i class="bi bi-check-lg"></i> Envios em massa por Whatsapp</p>
                <p><i class="bi bi-check-lg"></i> Agendamentos de envios</p>
                <p><i class="bi bi-check-lg"></i> Criação de campanhas</p>
                <p><i class="bi bi-check-lg"></i> Listas de contatos</p>
                <p><i class="bi bi-check-lg"></i> <strong>1.000 envios</strong> mensais</p>

                <div class='preco'>
                    <span><strong>R$ 24,90</strong> / mês</span>
                </div>

                <div class='contratar'>
                    <button id='whats-i'>Contratar</button>
                </div>
            </div>
            <div class="card">
                <h2>WhatsMark II</h2>
                <p><i class="bi bi-check-lg"></i> Envios em massa por Whatsapp</p>
                <p><i class="bi bi-check-lg"></i> Agendamentos de envios</p>
                <p><i class="bi bi-check-lg"></i> Criação de campanhas</p>
                <p><i class="bi bi-check-lg"></i> Listas de contatos</p>
                <p><i class="bi bi-check-lg"></i> <strong>2.000 envios</strong> mensais</p>

                <div class='preco'>
                    <span><strong>R$ 49,90</strong> / mês</span>
                </div>

                <div class='contratar'>
                    <button id='whats-ii'>Contratar</button>
                </div>
                
            </div>
            <div class="card">
                <h2>WhatsMark III</h2>
                <p><i class="bi bi-check-lg"></i> Envios em massa por Whatsapp</p>
                <p><i class="bi bi-check-lg"></i> Agendamentos de envios</p>
                <p><i class="bi bi-check-lg"></i> Criação de campanhas</p>
                <p><i class="bi bi-check-lg"></i> Listas de contatos</p>
                <p><i class="bi bi-check-lg"></i> <strong>5.000 envios</strong> mensais</p>

                <div class='preco'>
                    <span><strong>R$ 124,90</strong> / mês</span>
                </div>

                <div class='contratar'>
                    <button id='whats-iii'>Contratar</button>
                </div>
            </div>
        </div>
</div>

<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script>
// Clicou em contratar
$("button").click(function (){
    var slug = $(this).attr('id');

    window.location.href = "/carrinho?produto=" + slug;
})

</script>

@endsection
