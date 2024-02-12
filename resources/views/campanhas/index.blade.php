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
<div class='col campanhas'>
    <h2>Campanhas</h2>
</div>


@endsection