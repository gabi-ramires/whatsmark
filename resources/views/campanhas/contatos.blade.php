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


<h2>Contatos</h2>
<div class='linha contatos'>

    <div class='coluna card'>
        <table class='tabela-listas'>
        <thead>
            <tr>
                <th>Lista</th>
                <th>Contatos</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id='corpo-listas'>
        <!-- listagem  dinamica das listas -->
        </tbody>
        </table>
    </div>

    <!-- MODAL EDIÇÃO CONTATOS-->
    <div id="myModal" class="modal">
        <div class="modal-content">
        <form  method="POST" action="{{ route('lists.update') }}">
            <div id = 'nomelista' class="nome-lista">
                <h3><input id="nomeLista" name="name" value=""><input id="idLista" name='idLista' value="" style="display:none"></h3><span class="close" data-dismiss="modal">&times;</span>
                
            </div>
                <table class='tabela-contatos'>
                    <thead>
                        <tr>
                            <th style="display:none">Id</th>
                            <th>Nome</th>
                            <th>WhatsApp</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id='contatos'>
                        <!-- listagem  dinamica dos contatos -->
                    </tbody>
                </table>
            <button type="button" id="add-contact">+ Contato</button>
            <button id='submit' type="submit">Salvar</button>
            </form>
        </div>
    </div>

<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/campanhas/index.js') }}"></script>



</div>



@endsection