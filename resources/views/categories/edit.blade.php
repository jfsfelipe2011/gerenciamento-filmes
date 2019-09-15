@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categorias</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </ol>
        <div class="row" style="margin-bottom:3%">
            <h3>Editar Categoria</h3>
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
