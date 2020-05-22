@extends('templates.master')

@section('titulo', 'Detalhes da Reserva')

@section('content-view')
@include('templates.navbar')
<div class="container">
    @if (session()->has('success_message'))
    <div class="alert alert-success">
        {{ session()->get('success_message') }}
    </div>
    @endif

    @if(count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

<div class="container">
    <div class="list-group">
        <h1 class="cadastroprodutotitulo">Detalhes da Reserva ID: {{$reserva->id}}</h1>
        <div class="card card-body list-group-item detalhesprodutolista">
            <h4 class="title">Produtos da Reserva</h4>
            <hr>
            @foreach ($produtos as $produto)
            @if ($reserva->id == $produto->reserva_id && $produto->produto_id != null)
            <p class="mb-1 amount">Nome do Produto: {{ $produto->name_product }}</p>
            <p class="mb-1">Quantidade: {{ $produto->amount }}</p>
            <hr>
            @endif

            @endforeach
        </div>
    </div>
</div> <!-- end order-container -->
</div>
<div class="spacer"></div>
</div>
</div>

@endsection

