@extends('templates.master')
@section('titulo', 'Cadastro de Local')
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
    <div class="form-row  buscar-endereco">
        <div class="form-group">
            <input class="form-control" id="address" type="textbox" value="Santarém-Pa">
        </div>
        <div class="form-group ">
            <input class="form-control btn btn-secondary" id="search-address" type="button" value="Buscar Endereço">
        </div>
    </div>
    <form class="formulario-cadastrarlocal" action="{{ route('cadastrarlocal') }}" method="POST">
        {{ csrf_field() }}
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="name_place">Nome do Local</label>
                <input class="form-control" type="text" id="name_place" name="name_place" value="{{ old('name_place') }}">
            </div>
            <div class="form-group col-md-8">
                <label for="">Endereço</label>
                <input class="form-control" type="text" id="endereco-formatado" name="endereco-formatado" value="{{ old('endereco-formatado') }}" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="">Tipo de Local</label> <br>
                <select class="form-control" id='type' name="type" value="{{ old('type') }}"> 
                    <option value='supermercado' SELECTED>Supermercado</option>
                    <option value='Feira'>Feira</option>
                </select>
            </div>
            <input  class="form-control" type="hidden" id="latitude" name="lat" value="{{ old('latitude') }}" readonly>
            <input  class="form-control" type="hidden" id="longitude" name="lng" value="{{ old('longitude') }}" readonly><br>
        </div>
        <button type="submit" class="btn btn-primary botao-cadastrolocalconfirma">Cadastrar Local</button>
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