@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('actors.index') }}">Atores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Novo</li>
        </ol>
    </nav>
    <div class="row" style="margin-bottom:3%">
        <h3>Novo Ator</h3>
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
