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
    $contratos = DB::table('contratos')
    ->where('user_id', $user->id)
    ->get();

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

?>

@extends('painel/nav-painel')

@section('conteudo')
<link rel="stylesheet" href="{{ asset('css/meus-planos.css') }}">
<div id="vue" class="container">
    @verbatim
    <div class='row'>
        <div class="col">
            <h2>Meus Planos</h2>
    
            <div v-if="temPlanoContratado">
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
            <div v-else>
                Você não tem nenhum plano contratado.
            </div>
        </div>


    </div>
    @endverbatim
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script>
var app = new Vue({
    el: '#vue',
    data: {
        temPlanoContratado: ''
    },
    methods: {
        temPlano: async function () {
            try {
                const response = await fetch('/verificaSeTemPlano/a1d0c6e83f027327d8461063f4ac58a6', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                if (!response.ok) {
                    throw new Error('Erro ao obter os envios');
                }
                const temPlano = await response.json();

                if (temPlano.success) {
                    this.temPlanoContratado = true;
                }
            } catch (error) {
                temPlano = error.message;
            }
        }
    },
    mounted: function(){
            try {
                this.temPlano();
            } catch (error) {
                console.error("Erro durante a inicialização");
            }
        },
});

</script>

<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>



@endsection