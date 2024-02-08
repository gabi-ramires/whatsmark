@extends('default')

@section('content')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<div class="container tela-login">
    <div class='row'>
        <div class="col">
            <div class=login>
                <form>
                    <h2>ACESSAR CONTA</h2>
                    <div class="input-container">
                        <input type="text" placeholder="Usuário" class="input-with-icon">
                        <i class="bi bi-envelope input-icon"></i>
                    </div>
                    <div class="input-container">
                        <input type='password' placeholder="Senha" class="input-with-icon">
                        <i class="bi bi-lock input-icon"></i>
                    </div>
                    <a href="#"><span>Esqueci a senha</span></a>

                    <input id="submit" type="submit" value="Entrar">
                </form>
            </div>
        </div>


    </div>
</div>

@endsection
