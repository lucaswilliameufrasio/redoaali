@extends('templates.master')
@section('titulo', 'Produtos Disponíveis')
@section('css-view')
<link rel="stylesheet" href="{{asset('css/cadastrarlocal.css')}}">
@endsection
@section('content-view')
@include('templates.navbar')
<div class="container">
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
    <div class="row">
        @foreach($produtos as $produto)

        @if ($produto->amount != 0)
        <div class="col-md-4" style="padding: 7px;">
            <figure class="card card-product">
                <figcaption class="info-wrap">
                    <h4 class="title">Nome: {{$nomeproduto = $produto->name_product}}</h4>
                    <p class="amount">Quantidade: {{$produto->amount}} disponível(eis)</p>
                    <div class="rating-wrap">
                        <div class="label-rating"></div>
                        <div class="label-rating"></div>
                        <div class="label-rating"></div>
                    </div> <!-- rating-wrap.// -->
                </figcaption>
                <form action="{{ route('carrinho.store') }}" method="POST" style="margin-bottom:2px;">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$produto->id}}">
                    <input type="hidden" name="name_product" value="{{$nomeproduto}}">
                    <input type="hidden" name="userowner_id" value="{{$produto->userowner_id}}">
                    <button type="submit" class="btn btn-primary" style="width:99%;">Adicionar ao Carrinho</button>
                </form>
                <a class="btn btn-warning" href="{{ route('produto.detalhe', $produto->id) }}" style="width:99%;">Ver detalhes</a>
            </figure>
            @else
            <h3>Não há produtos disponíveis.</h3>
            @endif    
        </div> <!-- col // -->

        @endforeach   
    </div> <!-- row.// -->
</div>

@endsection