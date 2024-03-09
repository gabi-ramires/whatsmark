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

    // Verifica se usuário tem plano contratado
    use Illuminate\Support\Facades\DB;

    $temContrato = DB::table('contratos')
    ->where('user_id', $user->id)
    ->exists();



    $contratos = DB::table('contratos')
    ->where('user_id', $user->id)
    ->get();

    if ($temContrato) {

        $contratos = json_decode($contratos, true);
        $nomePlano = $contratos[0]['plano_name'];
        $status = $contratos[0]['status'];
        $pagoDe = date('d/m/Y', strtotime($contratos[0]['pagode']));
        $pagoAte = date('d/m/Y', strtotime($contratos[0]['pagoate']));
        $dataCriacao = date('d/m/Y', strtotime($contratos[0]['created_at']));

        // Busca o limite do plano contratado
        $limite = DB::table('planos')
        ->where('id', $contratos[0]['plano_id'])
        ->value('limite_envios');

        // Busca o valor plano contratado
        $valor = DB::table('planos')
        ->where('id', $contratos[0]['plano_id'])
        ->value('valor');

        $valor = number_format($valor, 2, ',', '.');        
    }

?>

@extends('painel/nav-painel')

@section('conteudo')
<link rel="stylesheet" href="{{ asset('css/meus-planos.css') }}">
<div class="container">
    @verbatim
    <div class='row'>
        <div class="col">
            <h2>Meus Planos</h2>

            <?php if($temContrato): ?>
            <div>
                <div class="info">
                    <h3>Plano</h3>
                    <span><strong>Nome:</strong> <?php echo $nomePlano; ?></span>
                    <span><strong>Limite:</strong> <?php echo $limite; ?> envios/mês</span>
                    <span><strong>Status:</strong> <?php echo $status; ?></span>
                    <span><strong>Contratação:</strong> <?php echo $dataCriacao; ?></span>

                    <h3>Cobrança</h3>
                    <span><strong>Valor:</strong> R$ <?php echo $valor; ?></span>
                    <span><strong>Última cobrança:</strong> <?php echo $pagoDe; ?></span>
                    <span><strong>Próxima cobrança:</strong> <?php echo $pagoAte; ?></span>

                    <button>Cancelar plano</button>
                </div>
            </div>
            <?php else: ?>
                <div class="info">
                    Você não tem nenhum plano contratado.
                </div>
            <?php endif; ?>
        </div>


    </div>
    @endverbatim
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>



@endsection