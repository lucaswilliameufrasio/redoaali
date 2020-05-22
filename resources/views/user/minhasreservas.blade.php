@extends('templates.master')

@section('titulo', 'Minhas Reservas')

@section('content-view')
@extends('templates.navbar')
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
    @foreach($orders as $order)
    <a class="list-group-item list-group-item-action list-group-item-success flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">             
            <h5 class="mb-1">ID da Reserva: {{$order->id}}</h5>
            <form action="{{ route('reserva.detalhe', $order->id) }}" method="GET">
                <button class="btn btn-warning" style="float: right;">Ver detalhes</button>
            </form>
        </div>
        <p class="mb-2">Reserva realizada em: {{date('d/m/Y', strtotime($order->created_at))}} {{date('H:i', strtotime($order->created_at))}}</p>
    </a>     
    @endforeach
</div>

@endsection

