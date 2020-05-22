@extends('templates.master')

@section('titulo', 'Reserva Concluida')

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
    <h1>Obrigado <br> pela sua reserva!</h1>
    <p>Abaixo estão os dados da reserva</p>
    <div class="spacer"></div>
</div>
@endsection
