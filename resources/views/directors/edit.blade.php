@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin-bottom:3%">
            <h3>Editar Diretor</h3>
            <a class="btn btn-primary" style="margin-left:70%" href="{{ route('directors.index') }}">Voltar</a>
        </div>

        @include('errors.errors-form')

        {!! Form::model($director, ['route' => ['directors.update','director' => $director->id],
            'class' => 'form', 'method' => 'PUT']) !!}
        @include('directors.form')

        <div class="form-group">
            {!! Form::submit('Alterar Diretor',['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@endsection
