@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="margin-bottom:3%">
        <h3>Novo Ator</h3>
        <a class="btn btn-primary" style="margin-left:70%" href="{{ route('actors.index') }}">Voltar</a>
    </div>

    @include('errors.errors-form')

    {!! Form::open(['route' => 'actors.store', 'class' => 'form']) !!}
        @include('actors.form')

        <div class="form-group">
            {!! Form::submit('Criar Ator',['class' => 'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}
</div>
@endsection
