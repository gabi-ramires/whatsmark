@extends('site/navsite')

@section('conteudo')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<div class="container tela-login">
    <div class='row'>
        <div class="col">
            <div class=login>
                <form id='form-cadastro'>
                    <h2>CADASTRE-SE</h2>
                    <div class="input-container">
                        <input id="nome" type="text" placeholder="Nome" class="input-with-icon">
                        <i class="bi bi-emoji-smile input-icon"></i>
                    </div>
                    <div class="input-container">
                        <input id="email" type="email" placeholder="Email" class="input-with-icon">
                        <i class="bi bi-envelope input-icon"></i>
                    </div>
                    <div class="input-container">
                        <input id="senha" type='password' placeholder="Senha" class="input-with-icon">
                        <i class="bi bi-lock input-icon"></i>
                    </div>
                    <div class="input-container">
                        <input id="repete-senha" type='password' placeholder="Repetir senha" class="input-with-icon">
                        <i class="bi bi-lock input-icon"></i>
                    </div>

        
                    <input id="submit" type="submit" value="Cadastrar">
                </form>
                
            </div>
        </div>


    </div>
</div>

<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/cadastro.js') }}"></script>


@endsection
