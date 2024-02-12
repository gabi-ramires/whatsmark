@extends('site/navsite')

@section('conteudo')
<link rel="stylesheet" href="{{ asset('css/cadastro.css') }}">
<div class="container tela-cadastro">
    <div class='row'>
        <div class="col">
            <div id="retorno-cadastro" class='retorno-registro-green' style='visibility: hidden'>
                <i class="bi bi-check-circle"></i>
                <span id='msg'>Não foi possível realizar o cadastro.</span>
            </div>
            <div class=login>
                <form id='form-cadastro'>
                    <h2>CADASTRE-SE</h2>
                    <div class="input-container">
                        <input id="nome" type="text" placeholder="Nome" class="input-with-icon" required>
                        <i class="bi bi-emoji-smile input-icon"></i>
                    </div>
                    <div class='danger nome' style='visibility: hidden;'>
                        <span>Mensagem de erro</span>
                    </div>
                    <div class="input-container">
                        <input id="email" type="email" placeholder="Email" class="input-with-icon" required>
                        <i class="bi bi-envelope input-icon"></i>
                    </div>
                    <div class='danger email' style='visibility: hidden;'>
                        <span>Mensagem de erro</span>
                    </div>
                    <div class="input-container">
                        <input id="senha" type='password' placeholder="Senha" class="input-with-icon" required>
                        <i class="bi bi-lock input-icon"></i>
                    </div>
                    <div class='danger senha' style='visibility: hidden;'>
                        <span>Mensagem de erro</span>
                    </div>
                    <div class="input-container">
                        <input id="repete-senha" type='password' placeholder="Repetir senha" class="input-with-icon" required>
                        <i class="bi bi-lock-fill input-icon"></i>
                    </div>
                    <div class='danger repete-senha' style='visibility: hidden;'>
                        <span>Mensagem de erro</span>
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
