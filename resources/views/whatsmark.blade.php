@extends('default')

@section('content')


<div class="container">
    <div class='row'>
        <div class="col">
            <div class='card'>
                <h2>1. Inicie sua sessão</h2>
                <button id='btn' onclick='startSession()'>Iniciar</button>
                <div>
                    <span>Status: </span><strong><span id='status'>Não iniciado</span></strong>
                </div>
                <div>
                    <span>Session ID: </span><strong><span id='sessionId'>42342</span></strong>
                </div>                
            </div>

        </div>
        <div class="col">
            <div class='card'>
                <h2>2. Escaneie o QR Code abaixo</h2>
                <button onclick="carregaQrCode()">Gerar</button>
                <img id='imagem' src="" width="300px">                
            </div>

        </div>
        <div class="col">
            <div class='card'>
                <h2>3. Realize seu primeiro envio</h2>
                <form id="myForm">
                    <label>Telefone:</label>
                    <input placeholder="555180187026" id="phone" value="555180187026">
                    <br><br>
                    <label>Mensagem:</label>
                    <textarea id="message">Oi</textarea>
                    <br><br>
                    <input type="submit">
                </form>            
            </div>

        </div>

    </div>
</div>

<script src="{{ asset('js/tutorial.js') }}"></script>

@endsection
