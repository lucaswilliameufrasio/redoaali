@extends('templates.master')
@section('titulo', 'Cadastro de Produto')
@section('content-view')
@include('templates.navbar')
<div class="container">
    <h3 class="cadastroprodutotitulo">Cadastro de Produto</h3>
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
    <div class="alert alert-success  alert-dismissible fade show">
        <strong>Informação!</strong> Data, Horario Inicial e Final, referem-se, respectivamente, a disponibilidade para que o beneficiário possa buscar os produtos.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <form method="POST" action="{{ route('/cadastrarprodutos') }}">
        @csrf
        <div class="form-group">
            <input type="hidden" class="form-control" id="user_owner" name="user_owner" value="{{Auth::user()->id}}" readonly>
        </div>
        <div class="form-group row">
            <label for="name_product" class="col-md-4 col-form-label text-md-right">{{ __('Nome do Produto') }}</label>

            <div class="col-md-6">
                <input id="name_product" type="text" class="form-control{{ $errors->has('name_product') ? ' é inválido' : '' }}" name="name_product" value="{{ old('name_product') }}" required autofocus>
                @if ($errors->has('name_product'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name_product') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Quantidade') }}</label>

            <div class="col-md-6">
                <input id="amount" type="number" class="form-control{{ $errors->has('amount') ? ' é inválido' : '' }}" name="amount" value="{{ old('amount') }}" required autofocus>

                @if ($errors->has('amount'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('amount') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="id_local" class="col-md-4 col-form-label text-md-right">{{ __('Endereço') }}</label>
            <div class="col-md-6">
                <select id='id_local'class="form-control{{ $errors->has('id_local') ? ' é inválido' : '' }}" name="id_local"> 
                    @foreach($enderecos as $endereco)
                    <option  value="{{$endereco->id}}"> {{$endereco->name_place}}: {{$endereco->address}}</option>
                    @endforeach
                </select>
                @if ($errors->has('id_local'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('id_local') }}</strong>
                </span>
                @endif
            </div>

        </div>
        <div class="form-group row">

            <label for="datadisponivel" class="col-md-4 col-form-label text-md-right">{{ __('Data') }}</label>
            <div class="col-md-6">
                <input id="datadisponivel" type="date" class="form-control{{ $errors->has('datadisponivel') ? ' é inválido' : '' }}" name="datadisponivel" value="{{ old('datadisponivel') }}" required autofocus>
                @if ($errors->has('datadisponivel'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('datadisponivel') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">

            <label for="horarioinicial" class="col-md-4 col-form-label text-md-right">{{ __('Horario Inicial') }}</label>
            <div class="col-md-6">
                <input id="horarioinicial" type="time" class="form-control{{ $errors->has('horarioinicial') ? ' é inválido' : '' }}" name="horarioinicial" value="{{ old('horarioinicial') }}" required autofocus>
                @if ($errors->has('horarioinicial'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('horarioinicial') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">

            <label for="horariofinal" class="col-md-4 col-form-label text-md-right">{{ __('Horario Final') }}</label>
            <div class="col-md-6">
                <input id="horarioinicial" type="time" class="form-control{{ $errors->has('horariofinal') ? ' é inválido' : '' }}" name="horariofinal" value="{{ old('horariofinal') }}" required autofocus>
                @if ($errors->has('horariofinal'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('horariofinal') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-6  botao-concluir-cadastro">
                <button class="btn btn-primary">Cadastrar</button>
            </div>
    </form>
</div>
@endsection