<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>WhatsMark</title>
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
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
                <li><a href="/painel">Inicio</a></li>
                <li><a href="#">Conta</a></li>
                <li><a href="/logout">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main id="main">
    <div class="container">
    <div class='row'>
            <aside>
                <ul>
                    <li><a href="/painel"><i class="bi bi-house-door-fill"></i>Inicio</a></li>
                    <li><a href="/tutorial"><i class="bi bi-rocket-takeoff"></i></i>Setup</a></li>
                    <li class="submenu-item"><a href="/campanhas">
                            <i class="bi bi-send"></i>Campanhas
                            <ul class="submenu">
                                <li><i class="bi bi-person"></i><a href="/contatos">Contatos</a></li>
                                <li><i class="bi bi-journal-check"></i><a href="/templates">Templates</a></li>
                            </ul>
                        </a>
                    </li>
                    <li><a href="/meus-planos"><i class="bi bi-stars"></i>Meus Planos</a></li>
                </ul>
            </aside>
        <div class="col">
        @yield('conteudo')
        </div>

    </div>
</div>
    </main>

    <footer>
        &copy; 2024 WhatsMark - Todos os direitos reservados
    </footer>

</body>
</html>