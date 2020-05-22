@section('titulo', 'Meus Produtos')
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
    <div class="list-group">
        <h1 class="cadastroprodutotitulo">Meus Produtos Disponíveis</h1>
        @foreach($produtos as $produto)
        @if ($produto->amount != 0)

        <a class="list-group-item list-group-item-action list-group-item-success flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                @foreach($enderecos as $endereco)
                @if($produto->id_local  == $endereco->id )

                <h5 class="mb-1">Nome do Local: {{$endereco->name_place}}</h5>
                @endif
                @endforeach
            </div>
            <p class="mb-1">Nome do Produto: {{$produto->name_product}}</p>
            <button class="btn btn-warning" style="float: right"  data-toggle="collapse" data-target="#collapse_{{$produto->id}}" >Ver detalhes</button>
            <small>{{$produto->amount}} disponível(eis).</small>
        </a>
        {{ csrf_field() }}
        <div class="collapse" id="collapse_{{$produto->id}}">
            <div class="card card-body listaprodutos">
                @foreach($enderecos as $endereco)
                @if($produto->id_local  == $endereco->id )
                <p class="mb-1">Local: {{$endereco->name_place}}</p>
                <p class="mb-1">Endereço: {{$endereco->address}}</p>
                <p class="mb-1">Data: {{date('d-m-Y', strtotime($produto->datadisponivel))}}</p>
                <p class="mb-1">Horário disponível: {{$produto->horarioinicial}} à {{$produto->horariofinal}}</p>
                <br>
                <input  class="form-control" type="hidden" id="latitude" name="latitude" value={{ $endereco->lat }}  readonly>
                <input  class="form-control" type="hidden" id="longitude" name="longitude" value={{ $endereco->lng }}  readonly>

                <div class="row">
                    <div class="editarprodutobtn">
                        <a href="{{ route('produto.editarprodutoform', $produto->id) }}" type="submit" class="btn btn-sm btn-warning">Editar</a>
                    </div>
                    <div class="deletarproduto">
                        <form action="{{ route('produto.deleta', $produto->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{method_field('DELETE')}}
                            <button type="submit" class="btn btn-sm btn-danger">Deletar <i class="fa fa-trash"></i></button>
                        </form>
                    </div> 
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endif
        @endforeach
        <br>
        <h1 class="cadastroprodutotitulo">Quem reservou?</h1>
        @foreach($produtosreservados as $produto)
        <a class="list-group-item list-group-item-action list-group-item-success flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">             
                <h5 class="mb-1">ID da Reserva: {{$produto->reserva_id}}</h5>
                <form action="{{ route('produto.quemreservou', $produto->reserva_id) }}" method="GET">
                    <button class="btn btn-warning" style="float: right;">Ver detalhes</button>
                </form>
            </div>
            @foreach ($user as $usuario)
            @if ($usuario->id == $produto->id)
            <p class="mb-2">Nome da Instituição/ONG: {{$usuario->business_name}}</p>
            @endif
            @endforeach
            <p class="mb-2">Reserva realizada em: {{date('d/m/Y', strtotime($produto->created_at))}}  {{date('H:i', strtotime($produto->created_at))}}</p>
        </a>     
        @endforeach
    </div>
</div>
@endsection