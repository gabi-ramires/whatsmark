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

<link rel="stylesheet" href="{{ asset('css/campanhas.css') }}">
<h2>Campanhas</h2>
<div class='row campanhas'>
    <div class='col'>
        <form class='card' method="POST" action="{{ route('criar') }}">
            <h2>Manualmente</h2>
            @csrf
            <label for="name">Nome da Lista:</label>
            <input type="text" name="name" id="name" required>

            <label for="contacts">Contatos do WhatsApp:</label>
            <div id="contacts">
                <div class='row' class="contact">
                    <input type="text" name="contacts[0][name]" placeholder="Nome" required>
                    <input type="text" name="contacts[0][whatsapp]" placeholder="Número de WhatsApp" required>
                </div>
            </div>
            <button type="button" id="add-contact">+ Contato</button>

            <button type="submit">Criar Lista</button>
        </form>
    </div>
    <div class='col'>
        <form class='card' method="POST" action="{{ route('criar') }}">
            <h2>Subir arquivo</h2>
            @csrf
            <label for="name">Nome da Lista:</label>
            <input type="text" name="name" id="name" required>

            <label for="contacts">Contatos do WhatsApp:</label>
            <div id="contacts">
                <div class="contact">
                    <input id='file' type="file" required>
                </div>
            </div>

            <button type="submit">Criar Lista</button>
        </form>
    </div>


<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/campanhas/contatos.js') }}"></script>


</div>


@endsection