<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>WhatsMark</title>
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
</head>
<body>
    <header>
    <h1>WhatsMark</h1>
        <nav>
            <ul>
                <li><a href="/">Página Inicial</a></li>
                <li><a href="/sobre">Sobre</a></li>
                <li><a href="/whatsmark">WhatsMark</a></li>
            </ul>
        </nav>
    </header>

    <main id="main">
        @yield('content')
    </main>

    <footer>
        &copy; 2024 WhatsMark - Todos os direitos reservados
    </footer>

</body>
</html>