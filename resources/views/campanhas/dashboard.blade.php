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

<link rel="stylesheet" href="{{ asset('css/campanhas.css') }}">


<h2>Dashboard</h2>
<div class='linha dashboard'>

    @verbatim
    <div id="app">
        

        <p >Saldo: {{ saldo }}/{{ limite }}</p>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Mensagem</th>
                <th>Lista</th>
                <th>Data</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="envio in envios" :key="envio.id">
                <td>{{ envio.id }}</td>
                <td>{{ envio.titulo }}</td>
                <td>{{ envio.mensagem_enviada }}</td>
                <td>{{ envio.lista_enviada }}</td>
                <td>{{ envio.created_at }}</td>
            </tr>
            </tbody>
        </table>
        
    </div>
    @endverbatim
</div>

<script>
var app = new Vue({
    el: '#app',
    data: {
        saldo: '',
        limite: '',
        envios: []
    },
    methods: {
        getSaldo: async function () {
            try {
                const response = await fetch('/getSaldo', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                if (!response.ok) {
                    throw new Error('Erro ao obter saldo');
                }
                const data = await response.json();
                this.saldo = data;
            } catch (error) {
                this.saldo = error.message;
            }
        },
        getLimite: async function () {
            try {
                const response = await fetch('/getLimite', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                if (!response.ok) {
                    throw new Error('Erro ao obter limite');
                }
                const data = await response.json();
                this.limite = data;
            } catch (error) {
                this.limite = error.message;
            }
        },
        getTodosEnvios: async function () {
            try {
                const response = await fetch('/getTodosEnvios', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                if (!response.ok) {
                    throw new Error('Erro ao obter os envios');
                }
                const data = await response.json();

                this.envios = data

                console.log(this.envios)
            } catch (error) {
                this.envios = error.message;
            }
        }
    },
    mounted: function(){
            try {
                this.getSaldo();
                this.getLimite();
                this.getTodosEnvios();
            } catch (error) {
                console.error("Erro durante a inicialização");
            }
        },
});
</script>

<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/campanhas/dashboard.js') }}"></script>




@endsection