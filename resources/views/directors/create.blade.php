@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="margin-bottom:3%">
        <h3>Novo Diretor</h3>
        <a class="btn btn-primary" style="margin-left:70%" href="{{ route('directors.index') }}">Voltar</a>
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
