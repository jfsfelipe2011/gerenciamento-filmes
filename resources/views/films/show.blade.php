@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('films.index') }}">Filmes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
            </ol>
        </nav>
        <div class="row" style="margin-bottom:3%">
            <h3>{{ $film->name }}</h3>
        </div>
        <div class="row">
            <div class="card" style="width: 100%; height: auto">
                <div class="card-body">
                    @if(is_null($film->image))
                        <div style="background-color: #1b4b72; height: 500px; width: 400px; float: left; color: white;
                        text-align: center; padding-top: 20%; margin-right: 2%">
                            Não informado
                        </div>
                    @else
                        <img src="{{ url("storage/$film->image") }}" height="500" width="400" style="float: left; padding: 2%">
                    @endif
                    <h5 class="card-title">{{ $film->name }}</h5>
                    <p class="card-text">{{ $film->description }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Duração: {{ $film->duration }} mim.</li>
                    <li class="list-group-item">Lançamento: {{ $film->release_date_formatted }}</li>
                    <li class="list-group-item">Categoria: {{ $film->category->name }}</li>
                </ul>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item active">Elenco:</li>
                        @foreach($film->actors as $actor)
                            <li class="list-group-item">{{ $actor->name }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item active">Diretor(s)</li>
                        @foreach($film->directors as $director)
                            <li class="list-group-item">{{ $director->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
