@extends('templates.master')
@section('titulo', 'Perfil')
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
        <div class="col-md-3 ">
            <div class="list-group ">
                <a href="#" class="list-group-item list-group-item-action active">Painel de Controle</a>
                <a href="{{ route('usuario.perfil') }}" class="list-group-item list-group-item-action">Gerenciamento de Usuário</a>
                @if (Auth::user()->permission_access === 2)
                <a href="{{ route('usuario.enderecos') }}" class="list-group-item list-group-item-action">Endereços</a>
                @endif
            </div> 
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Seu perfil</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('usuario.editar', Auth::user()->id) }}" method="POST">
                                {{ csrf_field() }}
                                {!! method_field('PATCH')!!}
                                <div class="form-group row">
                                    <label for="business_name" class="col-4 col-form-label">Nome da Empresa/Instituição/ONG</label> 
                                    <div class="col-8">
                                        <input id="business_name" name="business_name" value="{{Auth::user()->business_name}}" class="form-control here" type="text" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="representative_name" class="col-4 col-form-label">Nome do Representante</label> 
                                    <div class="col-8">
                                        <input id="representative_name" name="representative_name" value="{{Auth::user()->representative_name}}" class="form-control here" type="text" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cnpj" class="col-4 col-form-label">CNPJ</label> 
                                    <div class="col-8">
                                        <input id="cnpj" name="cnpj" value="{{Auth::user()->cnpj}}" class="form-control here" required="required" type="text" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-4 col-form-label">E-mail</label> 
                                    <div class="col-8">
                                        <input id="email" name="email" value="{{Auth::user()->email}}" class="form-control here" required="required" type="text" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-4 col-8">
                                        <button name="submit" type="submit" class="btn btn-primary">Atualizar perfil</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>		            
                </div>
            </div>
        </div>
    </div>
</div>
@section('js-view')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script>$("#celular").mask("(00) 00000-0000");</script>
<script>$("#telefone").mask("(00) 0000-0000");</script>
<script>$("#cnpj").mask("00.000.000/0000-00");</script>
@endsection
@endsection