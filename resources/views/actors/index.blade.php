@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="margin-bottom:3%">
        <h3>Lista de Atores</h3>
        <a class="btn btn-primary" style="margin-left:70%" href="{{ route('actors.create') }}">Novo Ator</a>
    </div>
    <div class="row">
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
            @foreach($actors as $actor)
                <tr>
                    <td>{{ $actor->id }}</td>
                    <td>{{ $actor->name }}</td>
                    <td>{{ $actor->date_of_birth_formatted }}</td>
                    <td>{{ $actor->date_of_death_formatted }}</td>
                    <td>{{ $actor->oscar }}</td>
                    <td>
                        <ul class="list-inline list-small">
                            @if(count($actor->films) > 0)
                                @foreach($actor->films as $film)
                                    <li>
                                        <a class="btn btn-link btn-link-small" href="#">{{ $film->name }}</a>
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
                                <a class="btn btn-link btn-link-small" href="#">Editar</a>
                            </li>
                            <li>
                                <form method="POST" action="#">
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

        {{ $actors->links() }}
    </div>
</div>
@endsection
