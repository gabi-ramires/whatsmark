<?php

    $userId = Auth::id();
    $taLogado = false;
    if($userId) {
        $taLogado = true;
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WhatsMark</title>
    <link rel="stylesheet" href="{{ asset('css/navsite.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aside.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


</head>
<body>
    <header>
        <div class='logo'>
            <img src="{{ asset('img/fox.png') }}" width="100px">
            <a href='/'><img src="{{ asset('img/whats.png') }}" width="220px"></a>
            
        </div>
        <nav>
            <ul>
                <li><a href="/">Página Inicial</a></li>
                <li><a href="/sobre">Sobre</a></li>
                <?php if(!$taLogado): ?>                
                <li><a href="/cadastro">Cadastro</a></li>
                <li><a href="/login">Login</a></li>
                <?php else: ?>
                <li><a href="/painel">Painel&nbsp; <i class="bi bi-box-arrow-right"></i></a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main id="main">
        @yield('conteudo')
    </main>

    <footer>
        &copy; 2024 WhatsMark - Todos os direitos reservados
    </footer>

</body>
</html>