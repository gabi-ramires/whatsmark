<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
                <li><a href="#">Conta</a></li>
                <li><a href="/login">Login</a></li>
            </ul>
        </nav>
    </header>

    <main id="main">
        @yield('login')
    </main>

    <footer>
        &copy; 2024 WhatsMark - Todos os direitos reservados
    </footer>

</body>
</html>