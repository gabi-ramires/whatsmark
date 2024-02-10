
@extends('painel/nav-painel')

@section('conteudo')

<link rel="stylesheet" href="{{ asset('css/tutorial.css') }}">
<div class="whatsmark">
    <div class='row'>
        <div class="col">
            <div class='card'>
                <h2>1. Inicie sua sessão</h2>
                <button id='btn' onclick='startSession()'>Iniciar</button><br>
                <div>
                    <span>Status: </span><strong><span id='sessao' style="color: red">Não iniciado</span></strong>
                </div>
                <div>
                    <span>Session ID: </span><strong><span id='sessionId'>42342</span></strong>
                </div>                
            </div>

        </div>
        <div class="col">
            <div class='card'>
                <h2>2. Escaneie o QR Code abaixo</h2>
                <button onclick="carregaQrCode()">Gerar</button><br>
                <div>
                    <span>Status: </span><strong><span id='status' style="color: red">Desconectado</span></strong>
                </div><br>
                <div class='qrcode'>
                    <img id='imagem' src="" width="250px">    
                </div>
                                
            </div>

        </div>
        <div class="col">
            <div class='card'>
                <h2>3. Realize seu primeiro envio</h2><br>
                <form id="myForm">
                    <label>Telefone:</label><br>
                    <input id="phone" value="555180187026" width="100%">
                    <br><br>
                    <label>Mensagem:</label><br>
                    <textarea id="message" cols='22'>Mensagem de teste</textarea>
                    <br><br>
                    <div class='submit'>
                        <input id="submit" type="submit" width="100%">   
                    </div>
                    <div id="log" class='retorno'>
                        <span>Aguardando seu envio ...</span>
                    </div>
                    
                </form>            
            </div>

        </div>

    </div>
</div>

<script src="{{ asset('js/painel/tutorial.js') }}"></script>



@endsection