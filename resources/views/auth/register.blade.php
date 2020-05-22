@extends('templates.master')
@section('content-view')
@include('templates.navbar')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cadastro') }}</div>

                <div class="card-body">
                    @csrf
                    <form action="{{ route('/cadastrar') }}">
                        <div class="row">
                            <div class="col text-center"> 
                                <button type="submit" name = "submit" value = "doador" class="btn btn-primary registeroptionone"> {{__('Cadastrar Doador') }}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center"> 
                                <button type="submit" name = "submit" value = "beneficiario" class="btn btn-primary registeroptiontwo">{{__('Cadastrar Beneficiário') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
