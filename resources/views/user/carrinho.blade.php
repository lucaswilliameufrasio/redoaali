@extends('templates.master')
@section('titulo', 'Carrinho')
@section('content-view')
@include('templates.navbar')
<div class="container">
        <h1 class="cadastroprodutotitulo">Carrinho</h1>
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
            <div class="col-12">
              @if(Cart::count() > 0)
                  <div class="col-9 mx-auto">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Produto</th>
                                    <th scope="col" class="text-center">Quantidade</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Cart::content() as $item)
                                <tr>
                                        @if($item->model != null)
                                        <td><a href="{{ route('produto.detalhe', $item->model->id) }}">{{$item->model->name_product}}</a></td>
                                        {{-- <td><input class="form-control" type="text" value="1" /></td> --}}
                                        <td>
                                            <div class="mx-auto">
                                            <input type="hidden" id="quantidademaxima" class="quantidademaxima" value="{{$item->model->amount}}">
                                                <select name="qty" id="qty" class="quantidade form-control" data-id="{{ $item->rowId }}">
                                                        @for ($i = 1; $i < ($item->model->amount)+1; $i++)
                                                            <option {{ $item->qty == $i ? 'selected' : '' }}>{{$i}}</option>
                                                        @endfor
                                                </select>
                                            </div>
                                        </td>
                                        {{-- <td class="text-right"><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </button> </td> --}}
                                        <td>
                                            <form action="{{ route('carrinho.deleta', $item->rowId) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{method_field('DELETE')}}
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach

                                <tr>
                                    <td></td>
                                    <td class="text-right"><strong>Total de Itens</strong></td>
                                    <td class="text-center"><strong>{{Cart::count()}}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="col mb-2">
                <div class="col-sm-12 col-md-12 ">
                    <h3 class="row">Nenhum item no carrinho</h3>
                </div>
             </div>
            @endif
            <div class="col-9 mx-auto mb-2">
                <div class="row">
                    <div class="col-sm-12  col-md-6">
                            <a class="btn btn-block btn-light" href="{{ route('produtos.lista') }}">Continuar Reservando</a>
                    </div>
                    <div class="col-sm-12 col-md-6 text-right">
                            {{-- <form action="{{ route('reserva.index') }}" method="GET">
                                    <button type="submit" class="btn btn-block btn-success">Concluir</a>
                            </form> --}}
                            <a href="{{ route('reserva.concluir')}}" class="btn btn-block btn-success">Concluir</a>
                    </div>
                </div>
            </div>
        </div>
</div>
@section('js-view')
<script>
    (function(){
        const classname = document.querySelectorAll('.quantidade')
        Array.from(classname).forEach(function(element){
            element.addEventListener('change', function(){
                const id = element.getAttribute('data-id')
                var quantidademaxima = document.getElementById('quantidademaxima').value
                axios.patch(`/carrinho/${id}`, {
                   quantidade: this.value,
                   quantidademax: quantidademaxima
                 })
                 .then(function (response) {
                //    console.log(response);
                   console.log(quantidademaxima)
                   window.location.href = '{{ route('carrinho.index') }}'
                 })
                 .catch(function (error) {
                   console.log(error);
                   window.location.href = '{{ route('carrinho.index') }}'
                 });
            })
        })
    })();
</script>
@endsection
@endsection