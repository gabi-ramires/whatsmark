@extends('painel/nav-painel')

@section('conteudo')

<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<div class='col index'>
    <h2>Bem vinda, Gabriela!</h2>
    <div class='col'>
        <div class='componenteIndex'>
            <div class="textoComponente" >
                <span>Você ainda não configurou o seu número de telefone no serviço de WhatsMark</span>
            </div>
            <a href="/tutorial"><button>Configurar</button></a>
        </div>


    </div>

</div>

@endsection


