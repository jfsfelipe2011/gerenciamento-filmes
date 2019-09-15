@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Filmes</li>
            </ol>
        </nav>
        <div class="row" style="margin-bottom:3%">
            <div class="col-10">
                <h3>Lista de Filmes</h3>
            </div>
            <div class="col-2">
                <a class="btn btn-primary" href="{{ route('films.create') }}">Novo Filme</a>
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
                    <th>Imagem</th>
                    <th>Categoria</th>
                    <th>Elenco</th>
                    <th>Diretor(s)</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                @foreach($films as $film)
                    <tr>
                        <td>{{ $film->id }}</td>
                        <td>{{ $film->name }}</td>
                        <td>
                            @if(is_null($film->image))
                                Não informado
                            @else
                                <img src="{{ url("storage/$film->image") }}" height="250" width="200">
                            @endif
                        </td>
                        <td>{{ $film->category->name }}</td>
                        <td>
                            <ul class="list-inline list-small">
                                @if(count($film->actors) > 0)
                                    @foreach($film->actors as $actor)
                                        <li>
                                            {{ $actor->name }}
                                        </li>
                                    @endforeach
                                @else
                                    <li>Nenhum cadastrado</li>
                                @endif
                            </ul>
                        </td>
                        <td>
                            <ul class="list-inline list-small">
                                @if(count($film->directors) > 0)
                                    @foreach($film->directors as $director)
                                        <li>
                                            {{ $director->name }}
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
                                       href="{{ route('films.show', ['film' => $film->id]) }}">Ver</a>
                                </li>
                                <li>
                                    <a class="btn btn-link btn-link-small"
                                       href="{{ route('films.edit', ['film' => $film->id]) }}">Editar</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('films.destroy', ['film' => $film->id]) }}">
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

            {{ $films->links() }}
        </div>
    </div>
@endsection

