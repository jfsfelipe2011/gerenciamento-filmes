@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin-bottom:3%">
            <h3>Editar Ator</h3>
            <a class="btn btn-primary" style="margin-left:70%" href="{{ route('actors.index') }}">Voltar</a>
        </div>

        @include('errors.errors-form')

        {!! Form::model($actor, ['route' => ['actors.update','actor' => $actor->id],
            'class' => 'form', 'method' => 'PUT']) !!}
        @include('actors.form')

        <div class="form-group">
            {!! Form::submit('Alterar Ator',['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@endsection
