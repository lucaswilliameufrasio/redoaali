@extends('templates.master')
@section('titulo', 'Meus Endereços')
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
                <a href="{{ route('usuario.enderecos') }}" class="list-group-item list-group-item-action">Endereços</a>
            </div> 
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Endereços Cadastrados</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome do Local</th>
                                    <th scope="col">Endereço</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enderecos as $endereco)
                                <tr>
                                    <th scope="row">{{$idendereco = $endereco->id}}</th>
                                    <td scope="row">{{$endereco->name_place}}</td>
                                    <td scope="row">{{$endereco->address}}</td>
                                    <td scope="row">{{$endereco->type}}</td>
                                    <td scope="row"><a href="{{ route('endereco.editar', $idendereco)}}" style="color: inherit;"><i class="far fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <form action="{{ route('endereco.deleta', $idendereco) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{method_field('DELETE')}}
                                            <button type="submit"><i class=""><i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group row">
                        <div class="mx-auto">
                            <a role="button" class="btn btn-primary" href="{{ route('cadastrolocalform')}}">Adicionar endereço</a>

                            {{-- <a role="button" class="btn btn-info" href="{{ route('endereco.editar') }}">Atualizar Endereço</a> --}}
                        </div> 
                    </div>
                    {{-- <form action="{{ route('usuario.editar', Auth::user()->id) }}" method="POST">
                    <div class="form-group row">
                        <label for="business_name" class="col-4 col-form-label">Nome da Empresa/Instituição/ONG</label> 
                        <div class="col-8">
                            <input id="business_name" name="business_name" value="{{Auth::user()->business_name}}" class="form-control here" type="text">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="representative_name" class="col-4 col-form-label">Nome do Representante</label> 
                        <div class="col-8">
                            <input id="representative_name" name="representative_name" value="{{Auth::user()->representative_name}}" class="form-control here" type="text">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cnpj" class="col-4 col-form-label">CNPJ</label> 
                        <div class="col-8">
                            <input id="cnpj" name="cnpj" value="{{Auth::user()->cnpj}}" class="form-control here" required="required" type="text">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-4 col-form-label">E-mail</label> 
                        <div class="col-8">
                            <input id="email" name="email" value="{{Auth::user()->email}}" class="form-control here" required="required" type="text">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-4 col-8">
                            <button name="submit" type="submit" class="btn btn-primary">Atualizar perfil</button>
                        </div>
                    </div>
                    </form> --}}
                </div>
            </div>

        </div>
    </div>
</div>
</div>
</div>
@endsection