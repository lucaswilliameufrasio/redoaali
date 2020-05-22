@extends('templates.master')
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
    <h1 class="cadastroprodutotitulo">Lista de Usuarios Cadastrados</h1>
    <h3 class="cadastroprodutotitulo">Em desenvolvimento</h3>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Nome da Empresa/Instituição/ONG</th>
                    <th scope="col">Nome do Representante</th>
                    <th scope="col">CNPJ</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Cadastro Aprovado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->business_name}}</td>
                    <td>{{$user->representative_name}}</td>
                    <td>{{$user->cnpj}}</td>
                    <td>{{$user->email}}</td>
                    <td style="text-align:center;">
                        <form action="{{ route('admin.atualizastatus', $user->id) }}" method="POST">
                            {{ csrf_field() }}
                            {!! method_field('PATCH')!!}
                            <input type="hidden" id="statusconta" name="statusconta" value="{{$user->status}}">
                            @if ($user->status === 0)
                            <button name="submit" type="submit" class="btn btn-success">Validar Conta</button>
                            @else
                            <button name="submit" type="submit" class="btn btn-danger">Bloquear Conta</button>
                            @endif
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection