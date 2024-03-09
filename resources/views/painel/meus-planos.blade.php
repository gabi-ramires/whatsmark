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
?>

@extends('painel/nav-painel')

@section('conteudo')

<div id="vue" class="container">
    @verbatim
    <div class='row'>
        <div class="col">
            <h2>Meus Planos</h2>
    
            <div v-if="temPlanoContratado">
                Você tem plano contratado!
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