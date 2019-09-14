@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="margin-bottom:3%">
        <h3>Nova Categoria</h3>
        <a class="btn btn-primary" style="margin-left:70%" href="{{ route('categories.index') }}">Voltar</a>
    </div>

    @include('errors.errors-form')

    {!! Form::open(['route' => 'categories.store', 'class' => 'form']) !!}
        @include('categories.form')

        <div class="form-group">
            {!! Form::submit('Criar Categoria',['class' => 'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}
</div>
@endsection
