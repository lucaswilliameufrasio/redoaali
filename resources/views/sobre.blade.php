@extends('templates.master')
@section('titulo', 'Sobre')
@section('content-view')
@include('templates.navbar')
<div class="container">
    <div class="container-fluid sobre-page">
        <h3>Sobre o Projeto RedoaAli</h3>
        <img src="{{ asset('img/imagemprojeto.png') }}" class="img-fluid" alt="Logomarca RedoaAli">

        <p>O Redoaali é um sistema desenvolvido na disciplina de programação WEB ofertada para a turma de
            BSI2017 e tem a finalidade de conectar Supermercados, Atacados, Feiras que desejam doar alimentos com instituições/ONG's
            que desejam receber essa doação.</p>
    </div>
</div>
@endsection