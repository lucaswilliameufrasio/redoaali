@extends('templates.master')
@section('titulo', 'Detalhes do Produto')
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
    <div class="list-group">
        <h1 class="cadastroprodutotitulo">Detalhes do produto</h1>
        <div class="card card-body list-group-item detalhesprodutolista">
            @foreach($enderecos as $endereco)
            @if($produtos->id_local  == $endereco->id )
            <h4 class="title">Nome: {{$produtos->name_product}}</h4>
            <p class="mb-1 amount">Quantidade: {{$produtos->amount}} disponível(eis)</p>
            <p class="mb-1"><strong>Dados para retirada do produto</strong></p>
            <p class="mb-1">Local: {{$endereco->name_place}}</p>
            <p class="mb-1">Endereço: <input id="endereco-formatado" type="text" class="mb-1 semborda" name="endereco-formatado" value="{{ $endereco->address}}" required readonly></p>
            <input id="address" type="text" class="mb-1" name="address" value="{{ $endereco->address}}"hidden>
            <p class="mb-1">Data: {{date('d/m/Y', strtotime($produtos->datadisponivel))}}</p>
            <p class="mb-1">Horário: de {{$produtos->horarioinicial}} a {{$produtos->horariofinal}}</p>
            <input  class="form-control" type="hidden" id="latitude" name="latitude" value={{ $endereco->lat }}  readonly>
            <input  class="form-control" type="hidden" id="longitude" name="longitude" value={{ $endereco->lng }}  readonly>

            <div class="adicionarcarrinho">
                <div class="form-inline">
                    <div class="form-group mb-2">
                        <form action="{{ route('carrinho.store') }}" method="POST" style="margin-bottom:2px;">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$produtos->id}}">
                            <input type="hidden" name="name_product" value="{{$produtos->name_product}}">
                            <input type="hidden" name="userowner_id" value="{{$produtos->userowner_id}}">
                            <button type="submit" class="btn btn-primary btn-sm">Adicionar ao Carrinho</button>
                        </form>	
                    </div>
                    <div class="form-group mb-2">
                        <button class="btn btn-sm btn-secondary  btn-showmapreserva" style="margin-bottom:2px; margin-left: 2px;" id="search-address" type="button" data-toggle="collapse" data-target="#collapsemap_{{$endereco->id}}" aria-expanded="false" aria-controls="collapseExample">
                            Ver no mapa
                        </button>
                    </div>
                </div>
                <div class="collapse" id="collapsemap_{{$endereco->id}}">
                    <div class="card card-body mapa-box">
                        <div id="map" style="height:300px;"></div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
@section('js-view')
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEhgz0HABu0APQhRF6izxaMeDLnNTr5u0&callback=initMap">
</script>
<script type="text/javascript" src="{{ asset('js/googlemapsapigeocode.js') }}"></script>
@endsection
@endsection