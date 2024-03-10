@extends('site/navsite')

@section('conteudo')

<?php
use Illuminate\Support\Facades\DB;

// Verifica se o parâmetro 'produto' está presente na URL
if (isset($_GET['produto'])) {
    $slug = $_GET['produto'];
} else {
    ob_clean();
    header('Location: /');
    exit();
}

$userId = Auth::id();
$taLogado = false;

if($userId) {
    $taLogado = true;
} else {
    ob_clean();
    header('Location: /cadastro?produto='.$slug.'');
    exit();
}

//Busca dados do produto no banco
$plano = DB::table('planos')
->where('slug', $slug)
->get();

$plano = $plano[0];
$plano->valor = number_format($plano->valor, 2, ',', '.');

// Busca dados pessoais
$dadosPessoais = DB::table('users')
->where('id', $userId)
->get();

$dadosPessoais = $dadosPessoais[0];

?>


<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="{{ asset('css/index-site.css') }}">
<link rel="stylesheet" href="{{ asset('css/carrinho.css') }}">

<div class="container tela-login carrinho">
    <div>
        <div id='carrinho' class='card'>
            <h2>Carrinho</h2>
            <span><strong>Plano: </strong><?= $plano->nome; ?></span>
            <div class='dados-pessoais'>
                <h4>Dados pessoais</h4>
                <span><strong>Nome: </strong><?= $dadosPessoais->name; ?></span>
                <span><strong>Email: </strong><?= $dadosPessoais->email; ?></span>
                <span><strong>CPF: </strong><input type="number" id="cpf" name="cpf" pattern="[0-9]{11}" title="CPF deve conter exatamente 11 dígitos" min="11" max="11" autocomplete="off" required>
                </span>

                <h4>Pagamento</h4>
                <form>
                    <input type="radio" id="pix" name="metodoPagamento" value="pix">
                    <label for="pix">Pix</label>

                    <input type="radio" id="cartao" name="metodoPagamento" value="cartao" disabled>
                    <label class='em-breve' for="cartao">Cartão de Crédito <span style='color: red !important;'>*</span></label>

                </form>
                <span class='valor-total'>Total: R$ <?= $plano->valor; ?></span>
                <button type='submit' id='finalizar-compra' data='<?=$userId;?>' name='<?=$plano->slug;?>'>Finalizar compra</button>
                <span style='font-size: smaller'><span style='color: red'>*</span> Em breve o pagamento por cartão de crédito será liberado.</span>
            </div>
        </div>

        <!-- PAGAMENTO PIX -->
        <div id='pagamento-pix' class='card' style='display: none'>
            <h2>Pagamento pix</h2>

            <span>Expira em <span id='expiracao'></span></span>

        </div>
    </div>
</div>


<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/carrinho.js') }}"></script>
@endsection
