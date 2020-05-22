@extends('templates.master')
@section('css-view')
<link rel="stylesheet" href="{{asset('css/cadastrarlocal.css')}}">
@endsection
@section('content-view')
@include('templates.navbar')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cadastro') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('/cadastrar') }}">
                        @csrf
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
                        <div class="form-group row">
                            <label for="business_name" class="col-md-4 col-form-label text-md-right">{{ __('Nome da Empresa') }}</label>

                            <div class="col-md-6">
                                <input id="business_name" type="text" class="form-control{{ $errors->has('business_name') ? 'é inválido.' : '' }}" name="business_name" value="{{ old('business_name') }}" required autofocus>

                                @if ($errors->has('business_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('business_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="representative_name" class="col-md-4 col-form-label text-md-right">{{ __('Nome do representante') }}</label>

                            <div class="col-md-6">
                                <input id="representative_name" type="text" class="form-control{{ $errors->has('representative_name') ? ' is-invalid' : '' }}" name="representative_name" value="{{ old('representative_name') }}" required autofocus>

                                @if ($errors->has('representative_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('representative_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cnpj" class="col-md-4 col-form-label text-md-right">{{ __('CNPJ') }}</label>

                            <div class="col-md-6">
                                <input id="cnpj" type="text" class="form-control{{ $errors->has('cnpj') ? ' é inválido' : '' }}" name="cnpj" value="{{ old('cnpj') }}" required autofocus minlength="14" maxlength="14">

                                @if ($errors->has('cnpj'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('cnpj') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telefone" class="col-md-4 col-form-label text-md-right">{{ __('Telefone') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control{{ $errors->has('telefone') ? ' é inválido' : '' }}" placeholder="DDD Número" id="telefone" name="telefone"  value="{{ old('telefone') }}">
                                <input type="hidden" name="tipo" value="telefone" id="tipo">
                                @if ($errors->has('telefone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('telefone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="celular" class="col-md-4 col-form-label text-md-right">{{ __('Celular') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control{{ $errors->has('celular') ? ' é inválido' : '' }}" placeholder="DDD Número" id="celular" name="celular" value="{{ old('celular') }}">
                                @if ($errors->has('celular'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('celular') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' é invalido' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('senha'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('senha') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Senha') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="permission_access" type="hidden" class="form-control" name="permission_access" value = {{ $permission_access }} required readonly>
                                <input id="status" type="hidden" class="form-control" name="status" value = '0' required readonly>
                            </div>
                        </div>
                        @if($permission_access == 'doador')
                        <hr>
                        <div class="form-group row buscar-endereco">
                            <label for="address" class="col-md-4 col-form-label text-md-right"></label>
                            <input class="form-control col-md-4" id="address" type="textbox" value="Santarém - PA">
                            <div class="col-md-4">
                                <input class="form-control btn btn-secondary " id="search-address" type="button" value="Buscar Endereço"><br>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="endereco-formatado" class="col-md-4 col-form-label text-md-right">{{ __('Endereço') }}</label>

                            <div class="col-md-6">
                                <input id="endereco-formatado" type="text" class="form-control{{ $errors->has('endereco-formatado') ? ' é inválido' : '' }}" name="endereco-formatado" value="{{ old('endereco-formatado') }}" required readonly>

                                @if ($errors->has('endereco-formatado'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('endereco-formatado') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de Local') }}</label> <br>
                            <div class="col-md-6">
                                <select id='type'class="form-control{{ $errors->has('type') ? ' é inválido' : '' }}" name="type" value="{{ old('type') }}"> 
                                    <option value='supermercado' SELECTED>Supermercado</option>
                                    <option value='Atacado'>Atacado</option>
                                    <option value='Feira'>Feira</option>
                                </select>
                            </div>
                            @if ($errors->has('type'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('type') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input  class="form-control" type="hidden" id="latitude" name="latitude" value={{ old('latitude') }} required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input  class="form-control" type="hidden" id="longitude" name="longitude" value={{old('longitude')}} required readonly>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button class="btn btn-secondary btn-showmap" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    Ver no mapa
                                </button>
                            </div>
                        </div>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body mapa-box">
                                <div id="map"></div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4  botaoconcluircadastro">
                                <button type="submit" name = "submit" class="btn btn-primary">
                                    {{ __('Concluir Cadastro') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script>$("#celular").mask("(00) 00000-0000");</script>
<script>$("#telefone").mask("(00) 0000-0000");</script>
<script>$("#cnpj").mask("00.000.000/0000-00");</script>
@if($permission_access == 'doador')
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEhgz0HABu0APQhRF6izxaMeDLnNTr5u0&callback=initMap">
</script>
<script type="text/javascript" src="{{ asset('js/googlemapsapigeocode.js') }}"></script>
@endif
@endsection
