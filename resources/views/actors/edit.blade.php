@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('actors.index') }}">Atores</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
            </ol>
        </nav>
        <div class="row" style="margin-bottom:3%">
            <h3>Editar Ator</h3>
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
