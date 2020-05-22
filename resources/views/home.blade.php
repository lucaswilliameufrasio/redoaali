
@extends('templates.master')
@section('titulo', 'Inicio')

@section('content-view')
@include('templates.navbar')
<div class="home">
    <div>
        @if(session()->has('success_message'))
        <div class="alert alert-success">
            {{session()->get('success_message')}}
        </div>
        @endif
        @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light backgroundimage">
        <div class="col-md-5 p-lg-5 mx-auto my-5 textohomeimage">

            <h1 class="display-4 font-weight-normal">Salve Vidas, Doe Alimentos</h1>
            @if (!Auth::user())
            <p class="lead font-weight-normal">Cadastre-se e faça sua primeira doação, é grátis.</p>
            <a class="btn btn-dark" href="{{ url('/cadastrar-opcao') }}">Cadastrar-se</a>
            @endif
            @auth
            <h3 class="lead font-weight-normal">Bem vindo, {{Auth::user()->representative_name}}.</h3>
            <a class="btn btn-dark" href="{{ url('/cadastrarprodutos') }}">Doar</a>
            @endauth
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-8 p-lg-5 mx-auto my-5">
            <h1 class="display-4 font-weight-normal">Qual o objetivo do ReDoaAli?</h1>
            <p class="lead font-weight-normal">O objetivo do RedoaAli é conectar de mercados, comércios, supermercados e feiras que desejam doar alimentos, mais especificamente hortaliças, que não estejam
                "apresentáveis" para
                venda a instituições, ONG's, Entidades Públicas que desejam receber esses alimentos.</p> </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>
</div>

@endsection