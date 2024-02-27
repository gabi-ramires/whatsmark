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
    <div id="retorno-lista" class='retorno-lista-green' style='visibility: hidden'>
        <i class="bi bi-check-circle"></i>
        <span id='msg'>Lista atualizada com sucesso!</span>
    </div>

    <!-- CARD DE LISTAS -->
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

        <button class='openModal' onclick='abrirModalNovaLista()'>Criar nova lista</button>
    </div>

    <!-- MODAL EDIÇÃO CONTATOS-->
    <div id="myModal" class="modal">
        <div class="modal-content card">
            <form  id="form-salvar-lista" method="POST" action="{{ route('lists.update') }}">
                <div id='nomelista' class="nome-lista">
                    <h3>
                        <input id="nomeLista" name="name" value="">
                        <input id="idLista" name='idLista' value="" style="display:none">
                    </h3>
                    <span class="close" data-dismiss="modal">&times;</span>
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
                <button id='submit' class='submit' type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <!-- MODAL NOVA LISTA-->
    <div id="modalNovaLista" class="modal">
        <div class="modal-content card">
        <form   id="form-criar-lista" method="POST" action="{{ route('lists.criar') }}">
        <div class="nome-lista">
            <span class="close2" data-dismiss="modal">&times;</span>
        </div>
       
        <input type="text" name="name" id="name" placeholder="Nome da lista" required><br>
            @csrf
            <br>

            <div id="contacts">
                <div class='row' class="contact">
                <table class='tabela-contatos'>
                        <thead>
                            <tr>
                                <th style="display:none">Id</th>
                                <th>Nome</th>
                                <th>WhatsApp</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id='contatos2'>
                            <tr id='0' class="contact">
                                <td><input type="text" name="contacts[0][name]" placeholder="Nome" value="" required></td>
                                <td><input type="number" name="contacts[0][whatsapp]" placeholder="55 44 1234-5678" value="" required></td>
                                <td><i class="bi bi-trash-fill red" onclick="removecontato(0)"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <button  id="add-contact2">+ Contato</button>

            <button  class='submit' type="submit" >Criar Lista</button>
        </form>
        </div>
    </div>

    

<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/campanhas/contatos.js') }}"></script>



</div>



@endsection