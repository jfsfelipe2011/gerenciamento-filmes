@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin-bottom:3%">
            <h3>Editar Categoria</h3>
            <a class="btn btn-primary" style="margin-left:70%" href="{{ route('categories.index') }}">Voltar</a>
        </div>

        @include('errors.errors-form')

        {!! Form::model($category, ['route' => ['categories.update','actor' => $category->id],
            'class' => 'form', 'method' => 'PUT']) !!}
        @include('categories.form')

        <div class="form-group">
            {!! Form::submit('Alterar Categoria',['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@endsection
