@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('stocks.index') }}">Estoques</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
            </ol>
        </nav>
        <div class="row" style="margin-bottom:3%">
            <h3>Editar Estoque</h3>
        </div>

        @include('errors.errors-form')

        {!! Form::model($stock, ['route' => ['stocks.update','stock' => $stock->id],
            'class' => 'form', 'method' => 'PUT']) !!}
        @include('stocks.form')

        <div class="form-group">
            {!! Form::submit('Alterar Estoque',['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@endsection
