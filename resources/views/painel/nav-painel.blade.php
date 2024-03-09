<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>WhatsMark</title>
    <script src="{{ asset('js/vue.js') }}"></script>
    
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
                    <a href="/painel"><li><i class="bi bi-house-door-fill"></i>Inicio</li></a>
                    <a href="/tutorial"><li><i class="bi bi-rocket-takeoff"></i>Setup</li></a>
                    <a href="#" class="submenu-item">
                        <li><i class="bi bi-send"></i>Campanhas<i id='flecha' class="bi bi-chevron-right"></i></li></a>
                            <ul class="submenu">
                                <a href="/dashboard"><li><i class="bi bi-graph-up-arrow"></i>Dashboard</li></a>
                                <a href="/contatos"><li><i class="bi bi-person"></i>Contatos</li></a>
                                <a href="/nova-campanha"><li><i class="bi bi-plus-lg"></i>Campanha</li></a>
                            </ul>
                    <a href="/meus-planos"><li><i class="bi bi-stars"></i>Meus Planos</li></a>
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
<script>
    $(".submenu-item").click(function(){
        $(".submenu").toggle();
        $(this).toggleClass("submenu-clicked");
        $(this).find("#flecha").toggleClass("bi-chevron-down bi-chevron-right");
    })
</script>

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
</body>
</html>