@extends('templates.master')
@section('content-view')
@include('templates.navbar')
<div class="container">
    <h1 class="cadastroprodutotitulo">Lista de Produtos Cadastrados</h1>
    <h3 class="cadastroprodutotitulo">Em desenvolvimento</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Nome do Produto</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Data</th>
                    <th scope="col">Horario</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Excluir</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produtos as $produto)
                <tr>
                    <th scope="row">{{$produto->id}}</th>
                    <td>{{$produto->name_product}}</td>
                    <td>{{$produto->amount}}</td>
                    <td>{{$produto->datadisponivel}}</td>
                    <td>{{$produto->horarioinicial}} a {{$produto->horariofinal}}</td>
                    <td><a href="{{ route('admin.editarproduto', $produto->id) }}" type="submit" class="btn btn-sm btn-warning">Editar <i class="far fa-edit"></i></a>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_{{$produto->id}}">
                            Deletar <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <div class="modal fade" id="modal_{{$produto->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deletar Produto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Você realmente quer deletar o produto {{$produto->name_product}}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <form action="{{ route('admin.deletaproduto', $produto->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{method_field('DELETE')}}
                                <button type="submit" class="btn btn-danger">Sim</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection