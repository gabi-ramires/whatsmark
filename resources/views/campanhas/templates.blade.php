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


<h2>Templates</h2>
<div class='linha contatos templates'>

<div class='card'>
    <div>
        <label>Titulo</label>
        <input type='text'>

        <label>Contatos</label>
        <select id='select'>
            <!-- adiciona dinamicamente -->
        </select>      
    </div>


    <label>Conteúdo</label>

    <!-- SMILEYS -->
    <div id='a' style="display:none" class="flex flex-wrap w-full gap-5"><span class="emoji emoji-large">😀</span><span class="emoji emoji-large">😃</span><span class="emoji emoji-large">😄</span><span class="emoji emoji-large">😁</span><span class="emoji emoji-large">😆</span><span class="emoji emoji-large">😅</span><span class="emoji emoji-large">😂</span><span class="emoji emoji-large">🤣</span><span class="emoji emoji-large">🥲</span><span class="emoji emoji-large">🥹</span><span class="emoji emoji-large">☺️</span><span class="emoji emoji-large">😊</span><span class="emoji emoji-large">😇</span><span class="emoji emoji-large">🙂</span><span class="emoji emoji-large">🙃</span><span class="emoji emoji-large">😉</span><span class="emoji emoji-large">😌</span><span class="emoji emoji-large">😍</span><span class="emoji emoji-large">🥰</span><span class="emoji emoji-large">😘</span><span class="emoji emoji-large">😗</span><span class="emoji emoji-large">😙</span><span class="emoji emoji-large">😚</span><span class="emoji emoji-large">😋</span><span class="emoji emoji-large">😛</span><span class="emoji emoji-large">😝</span><span class="emoji emoji-large">😜</span><span class="emoji emoji-large">🤪</span><span class="emoji emoji-large">🤨</span><span class="emoji emoji-large">🧐</span><span class="emoji emoji-large">🤓</span><span class="emoji emoji-large">😎</span><span class="emoji emoji-large">🥸</span><span class="emoji emoji-large">🤩</span><span class="emoji emoji-large">🥳</span><span class="emoji emoji-large">😏</span><span class="emoji emoji-large">😒</span><span class="emoji emoji-large">😞</span><span class="emoji emoji-large">😔</span><span class="emoji emoji-large">😟</span><span class="emoji emoji-large">😕</span><span class="emoji emoji-large">🙁</span><span class="emoji emoji-large">☹️</span><span class="emoji emoji-large">😣</span><span class="emoji emoji-large">😖</span><span class="emoji emoji-large">😫</span><span class="emoji emoji-large">😩</span><span class="emoji emoji-large">🥺</span><span class="emoji emoji-large">😢</span><span class="emoji emoji-large">😭</span><span class="emoji emoji-large">😮‍💨</span><span class="emoji emoji-large">😤</span><span class="emoji emoji-large">😠</span><span class="emoji emoji-large">😡</span><span class="emoji emoji-large">🤬</span><span class="emoji emoji-large">🤯</span><span class="emoji emoji-large">😳</span><span class="emoji emoji-large">🥵</span><span class="emoji emoji-large">🥶</span><span class="emoji emoji-large">😱</span><span class="emoji emoji-large">😨</span><span class="emoji emoji-large">😰</span><span class="emoji emoji-large">😥</span><span class="emoji emoji-large">😓</span><span class="emoji emoji-large">🫣</span><span class="emoji emoji-large">🤗</span><span class="emoji emoji-large">🫡</span><span class="emoji emoji-large">🤔</span><span class="emoji emoji-large">🫢</span><span class="emoji emoji-large">🤭</span><span class="emoji emoji-large">🤫</span><span class="emoji emoji-large">🤥</span><span class="emoji emoji-large">😶</span><span class="emoji emoji-large">😶‍🌫️</span><span class="emoji emoji-large">😐</span><span class="emoji emoji-large">😑</span><span class="emoji emoji-large">😬</span><span class="emoji emoji-large">🫨</span><span class="emoji emoji-large">🫠</span><span class="emoji emoji-large">🙄</span><span class="emoji emoji-large">😯</span><span class="emoji emoji-large">😦</span><span class="emoji emoji-large">😧</span><span class="emoji emoji-large">😮</span><span class="emoji emoji-large">😲</span><span class="emoji emoji-large">🥱</span><span class="emoji emoji-large">😴</span><span class="emoji emoji-large">🤤</span><span class="emoji emoji-large">😪</span><span class="emoji emoji-large">😵</span><span class="emoji emoji-large">😵‍💫</span><span class="emoji emoji-large">🫥</span><span class="emoji emoji-large">🤐</span><span class="emoji emoji-large">🥴</span><span class="emoji emoji-large">🤢</span><span class="emoji emoji-large">🤮</span><span class="emoji emoji-large">🤧</span><span class="emoji emoji-large">😷</span><span class="emoji emoji-large">🤒</span><span class="emoji emoji-large">🤕</span><span class="emoji emoji-large">🤑</span><span class="emoji emoji-large">🤠</span><span class="emoji emoji-large">😈</span><span class="emoji emoji-large">👿</span><span class="emoji emoji-large">👹</span><span class="emoji emoji-large">👺</span><span class="emoji emoji-large">🤡</span><span class="emoji emoji-large">💩</span><span class="emoji emoji-large">👻</span><span class="emoji emoji-large">💀</span><span class="emoji emoji-large">☠️</span><span class="emoji emoji-large">👽</span><span class="emoji emoji-large">👾</span><span class="emoji emoji-large">🤖</span><span class="emoji emoji-large">🎃</span><span class="emoji emoji-large">😺</span><span class="emoji emoji-large">😸</span><span class="emoji emoji-large">😹</span><span class="emoji emoji-large">😻</span><span class="emoji emoji-large">😼</span><span class="emoji emoji-large">😽</span><span class="emoji emoji-large">🙀</span><span class="emoji emoji-large">😿</span><span class="emoji emoji-large">😾</span></div>

    <!-- GESTOS -->
    <div id='b' style="display:none" class="flex flex-wrap w-full gap-5"><span class="emoji emoji-large">👋</span><span class="emoji emoji-large">🤚</span><span class="emoji emoji-large">🖐</span><span class="emoji emoji-large">✋</span><span class="emoji emoji-large">🖖</span><span class="emoji emoji-large">👌</span><span class="emoji emoji-large">🤌</span><span class="emoji emoji-large">🤏</span><span class="emoji emoji-large">✌️</span><span class="emoji emoji-large">🤞</span><span class="emoji emoji-large">🫰</span><span class="emoji emoji-large">🤟</span><span class="emoji emoji-large">🤘</span><span class="emoji emoji-large">🤙</span><span class="emoji emoji-large">🫵</span><span class="emoji emoji-large">🫱</span><span class="emoji emoji-large">🫲</span><span class="emoji emoji-large">🫸</span><span class="emoji emoji-large">🫷</span><span class="emoji emoji-large">🫳</span><span class="emoji emoji-large">🫴</span><span class="emoji emoji-large">👈</span><span class="emoji emoji-large">👉</span><span class="emoji emoji-large">👆</span><span class="emoji emoji-large">🖕</span><span class="emoji emoji-large">👇</span><span class="emoji emoji-large">☝️</span><span class="emoji emoji-large">👍</span><span class="emoji emoji-large">👎</span><span class="emoji emoji-large">✊</span><span class="emoji emoji-large">👊</span><span class="emoji emoji-large">🤛</span><span class="emoji emoji-large">🤜</span><span class="emoji emoji-large">👏</span><span class="emoji emoji-large">🫶</span><span class="emoji emoji-large">🙌</span><span class="emoji emoji-large">👐</span><span class="emoji emoji-large">🤲</span><span class="emoji emoji-large">🤝</span><span class="emoji emoji-large">🙏</span><span class="emoji emoji-large">✍️</span><span class="emoji emoji-large">💅</span><span class="emoji emoji-large">🤳</span><span class="emoji emoji-large">💪</span><span class="emoji emoji-large">🦾</span><span class="emoji emoji-large">🦵</span><span class="emoji emoji-large">🦿</span><span class="emoji emoji-large">🦶</span><span class="emoji emoji-large">👣</span><span class="emoji emoji-large">👂</span><span class="emoji emoji-large">🦻</span><span class="emoji emoji-large">👃</span><span class="emoji emoji-large">🫀</span><span class="emoji emoji-large">🫁</span><span class="emoji emoji-large">🧠</span><span class="emoji emoji-large">🦷</span><span class="emoji emoji-large">🦴</span><span class="emoji emoji-large">👀</span><span class="emoji emoji-large">👁</span><span class="emoji emoji-large">👅</span><span class="emoji emoji-large">👄</span><span class="emoji emoji-large">🫦</span><span class="emoji emoji-large">💋</span><span class="emoji emoji-large">🩸</span></div>

    <div class='options-emojis'>
        <span id='A' class='em'>😀</span>
        <span id='B' class='em'>👋</span>
    </div>
    
    <textarea id='textarea' cols='20'>Seja bem vindo ao *WhatsMark*! 😎

Crie suas campanhas com imagens, emojis, botões e muito mais! 🤩🚀</textarea>

    <input id='submit' type='submit'>
</div>

<div class="cellphone">
    <div class="screen">
        <div class='whats'>
            <div class="header">Nome do Contato</div>
            <div class="message-area">
                <div class="message sent"><span id='texto-whats' >Seja bem vindo ao <b>WhatsMark</b>! 😎<br><br>Crie suas campanhas com imagens, emojis, botões e muito mais! 🤩🚀
</span></div>
                <div class="message received">Legal, vou fazer agora 😃 </div>
            </div>
            <!-- 
            <div class="message-input">
                <input type="text" placeholder="Digite sua mensagem...">
                <button><i class="bi bi-send"></i></button>
            </div>
            -->
        </div>
    </div>
    <div class="button home"></div>
</div>



<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/campanhas/templates.js') }}"></script>


</div>



@endsection