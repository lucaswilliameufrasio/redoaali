@extends('templates.master')
@section('titulo', 'Editar Endereço')
@section('css-view')
<link rel="stylesheet" href="{{asset('css/cadastrarlocal.css')}}">
@endsection
@section('content-view')
@include('templates.navbar')
<div class="container">
    <h3 class="cadastroprodutotitulo">Cadastro de Endereço</h3>
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

    <form class="formulario-cadastrarlocal" action="{{ route('endereco.concluireditar', $endereco->id) }}" method="POST">
        {{ csrf_field() }}
        {!! method_field('PATCH')!!}
        <div class="form-row  buscar-endereco">
            <div class="form-group">
                <input class="form-control" id="address" type="text" value="{{ $endereco->address }}" name="address">
            </div>
            <div class="form-group ">
                <input class="form-control btn btn-secondary" id="search-address" type="button" value="Buscar Endereço">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="name_place">Nome do Local</label>
                <input class="form-control" type="text" id="name_place" name="name_place" value="{{ $endereco->name_place}}">
            </div>
            <div class="form-group col-md-8">
                <label for="">Endereço</label>
                <input class="form-control" type="text" id="endereco-formatado" name="endereco-formatado" value="{{ $endereco->address }}" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="">Tipo de Local</label> <br>
                <select class="form-control" id='type' name="type" value="{{ $endereco->type }}"> 
                    <option value='supermercado'>Supermercado</option>
                    <option value='feira'>Feira</option>
                </select>
            </div>
            <input  class="form-control" type="hidden" id="latitude" name="lat" value="{{ $endereco->lat }}" readonly>
            <input  class="form-control" type="hidden" id="longitude" name="lng" value="{{ $endereco->lng }}" readonly><br>
        </div>
        <button type="submit" class="btn btn-primary botao-cadastrolocalconfirma">Salvar</button>
    </form><br>
    <div id="map">
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/googlemapsapigeocode.js') }}"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEhgz0HABu0APQhRF6izxaMeDLnNTr5u0&callback=initMap">
</script>
</body>
</html>
@endsection