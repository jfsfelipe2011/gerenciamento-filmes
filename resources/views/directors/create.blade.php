@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('directors.index') }}">Diretores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Novo</li>
        </ol>
    </nav>
    <div class="row" style="margin-bottom:3%">
        <h3>Novo Diretor</h3>
    </div>

    @include('errors.errors-form')

    {!! Form::open(['route' => 'directors.store', 'class' => 'form']) !!}
        @include('directors.form')

        <div class="form-group">
            {!! Form::submit('Criar Diretor',['class' => 'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}
</div>
@endsection
