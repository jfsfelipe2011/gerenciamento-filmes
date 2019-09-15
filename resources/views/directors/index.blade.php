@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Diretores</li>
        </ol>
    </nav>
    <div class="row" style="margin-bottom:3%">
        <div class="col-10">
            <h3>Lista de Diretores</h3>
        </div>
        <div class="col-2">
            <a class="btn btn-primary" href="{{ route('directors.create') }}">Novo Diretor</a>
        </div>
    </div>
    <div class="row">
        @include('success.success-form')
        @include('errors.errors')

        <table class="table table-striped" style="text-align:center">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Data de Nascimento</th>
                <th>Data de Falecimento</th>
                <th>Quantidade de Oscars</th>
                <th>Filmes</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tbody>
            @foreach($directors as $director)
                <tr>
                    <td>{{ $director->id }}</td>
                    <td>{{ $director->name }}</td>
                    <td>{{ $director->date_of_birth_formatted }}</td>
                    <td>{{ $director->date_of_death_formatted }}</td>
                    <td>{{ $director->oscar }}</td>
                    <td>
                        <ul class="list-inline list-small">
                            @if(count($director->films) > 0)
                                @foreach($director->films as $film)
                                    <li>
                                        <a class="btn btn-link btn-link-small"
                                           href="{{ route('films.show', ['film' => $film->id]) }}">{{ $film->name }}</a>
                                    </li>
                                @endforeach
                            @else
                                <li>Nenhum cadastrado</li>
                            @endif
                        </ul>
                    </td>
                    <td>
                        <ul class="list-inline list-small">
                            <li>
                                <a class="btn btn-link btn-link-small"
                                   href="{{ route('directors.edit', ['actor' => $director->id]) }}">Editar</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('directors.destroy', ['actor' => $director->id]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-link btn-link-small" type="submit">Excluir</button>
                                </form>
                            </li>
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $directors->links() }}
    </div>
</div>
@endsection
