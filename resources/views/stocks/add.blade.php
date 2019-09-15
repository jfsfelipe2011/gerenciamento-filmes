@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('stocks.index') }}">Estoques</a></li>
                <li class="breadcrumb-item active" aria-current="page">Adicionar</li>
            </ol>
        </nav>
        <div class="row" style="margin-bottom:3%">
            <h3>Adicionar ao Estoque</h3>
        </div>

        @include('errors.errors-form')

        {!! Form::model($stock, ['route' => ['stocks.update.quantity','stock' => $stock->id],
            'class' => 'form', 'method' => 'PUT']) !!}

        <div class="form-group">
            {!! Form::label('film_id', 'Filme') !!}
            {!! Form::text('film_id', $stock->film->name, ['class' => 'form-control', 'disabled' => true]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('quantity', 'Quantidade') !!}
            {!! Form::number('quantity', 1, ['class' => 'form-control', 'min' => 1]) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Adicionar Quantidade',['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@endsection
