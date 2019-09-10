@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3>Novo Ator</h3>
        <a class="btn btn-primary" style="margin-left:70%" href="{{ route('actors.index') }}">Voltar</a>
    </div>

    @include('errors.errors-form')

    @include('actors.form')
</div>
@endsection
