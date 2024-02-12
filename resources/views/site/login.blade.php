@extends('site/navsite')

@section('conteudo')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<div class="container tela-login">
    <div class='row'>
        <div class="col">
            <div id="retorno-cadastro" class='retorno-registro-green' style='visibility: hidden'>
                <i class="bi bi-check-circle"></i>
                <span id='msg'>Não foi possível realizar o cadastro.</span>
            </div>
            <div class=login>
                <form id="form-login">
                    <h2>ACESSAR CONTA</h2>
                    <div class="input-container">
                        <input id="email" type="email" name="email" placeholder="Email" class="input-with-icon" required>
                        <i class="bi bi-envelope input-icon"></i>
                    </div>
                    <div class="input-container">
                        <input id="password" type='password' name="password"placeholder="Senha" class="input-with-icon" required>
                        <i class="bi bi-lock input-icon"></i>
                    </div>
                        <a href="#"><span>Esqueci a senha</span></a>
                        <a href="/cadastro"><span>Cadastre-se</span></a>   

                
                    <input id="submit" type="submit" value="Entrar">
                </form>
                
            </div>
        </div>


    </div>
</div>

<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/login.js') }}"></script>

@endsection
