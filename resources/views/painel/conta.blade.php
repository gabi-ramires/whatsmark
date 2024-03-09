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
    $conta = DB::table('users')
    ->where('id', $user->id)
    ->get();

    //dd($conta[0]->name);

    $nome = $conta[0]->name;
    $email = $conta[0]->email;
    $senha = 'rewrew';

?>

@extends('painel/nav-painel')

@section('conteudo')
<link rel="stylesheet" href="{{ asset('css/conta.css') }}">
<div id="vue2" class="container">
    @verbatim
    <div class='row'>
        <div class="col">
            <h2>Minha conta</h2>
    
            <div>
                <div class="info">
                    <h3>Dados pessoais</h3>
                    <span><strong>Nome:</strong> <?php echo $nome ?></span>
                    <span><strong>Email:</strong> <?php echo $email; ?></span>
                    <button @click="abrirForm" v-if="!formAberto">Alterar senha</button>
                    <div v-if="formAberto">
                        <form @submit.prevent="submitForm">
                            <label><strong>Senha atual:</strong> </label>
                            <input type='password' v-model="senhaAtual"><br>
                            <label><strong>Senha nova:</strong> </label>
                            <input type='password' v-model="senhaNova"><br>

                            <input id='submit' type='submit'>
                        </form>
                    </div>
                </div>
                <div v-if="formSubmetido" :class="{ 'retorno-senha-green': success, 'retorno-senha-red': !success }">
                    <i class="bi" :class="{ 'bi-check-circle': success, 'bi-x-circle': !success }"></i>
                    <span id='msg'>{{ message }}</span>
                </div>

            </div>
        </div>


    </div>
    @endverbatim
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script>
var app = new Vue({
    el: '#vue2',
    data: {
        formAberto: false,
        senhaAtual: '',
        senhaNova: '',
        success: '',
        message: '',
        formSubmetido: false
    },
    methods: {
        updatePassword: function (){
            axios.post(`/password`, {
                senhaNova: this.senhaNova,
                senhaAtual: this.senhaAtual
            })
            .then(response => {
                this.success = response.data.success;
                this.message = response.data.message;
                this.formAberto = false;
                this.senhaAtual = ''
                this.senhaNova = ''
            })
            .catch(error => {
                console.error(error);
                this.success = false,
                this.message = 'Erro ao atualizar a senha'
                this.senhaAtual = ''
                this.senhaNova = ''
            });
        },
        abrirForm: function (){
            this.formAberto = true;
        },
        submitForm: function () {

            // colcoar logica de validaçao para ver se a nova senha passa pelas regras

            console.log("Formulário enviado");
            this.updatePassword();
            this.formSubmetido = true;
        }
    }
});

</script>

<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>



@endsection