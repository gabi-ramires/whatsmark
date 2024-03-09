@if(!Auth::check())
    <script>window.location.href = "{{ url('/') }}";</script>
@endif
<?php
// Verifica se o usuário está autenticado
$user = Auth::user();
if ($user) {
    $nome = $user->name;
} else {
    header('Location: /');
    exit();
}
?>

@extends('painel/nav-painel')

@section('conteudo')


<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<div class='col index'>
    <h2>Bem vindo(a), <?= $nome; ?></h2>
    <div class='col'>
        <div id='setup' class='componenteIndex' style='display: none'>
            <div class="textoComponente" >
                <span>Você ainda não configurou o seu número de telefone no serviço de WhatsMark</span>
            </div>
            <a href="/tutorial"><button>Configurar</button></a>
        </div>

        <div id='iniciar' class='componenteIndex' style='display: none'>
            <div class="textoComponente" >
                <span>Tudo pronto, agora você já pode criar suas companhas!</span>
            </div>
            <a href="/nova-campanha"><button>Começar</button></a>
        </div>


    </div>

</div>

<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/painel/painel.js') }}"></script>

@endsection




