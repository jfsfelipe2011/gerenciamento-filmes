@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Alugueis</li>
            </ol>
        </nav>
        <div class="row" style="margin-bottom:3%">
            <div class="col-10">
                <h3>Lista de Alugueis</h3>
            </div>
            <div class="col-2">
                <a class="btn btn-primary" href="{{ route('rents.create') }}">Novo Aluguel</a>
            </div>
        </div>
        <div class="row">
            @include('success.success-form')
            @include('errors.errors')

            <table class="table table-striped" style="text-align:center">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Filmes</th>
                    <th>Inicio</th>
                    <th>Fim</th>
                    <th>Valor</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rents as $rent)
                    <tr>
                        <td>{{ $rent->id }}</td>
                        <td>{{ $rent->customer->name }}</td>
                        <td>
                            <ul class="list-inline list-small">
                                @if(count($rent->films) > 0)
                                    @foreach($rent->films as $film)
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
                        <td>{{ $rent->start_date }}</td>
                        <td>{{ $rent->end_date }}</td>
                        <td>{{ $rent->value }}</td>
                        <td>
                            <ul class="list-inline list-small">
                                <li>
                                    <a class="btn btn-link btn-link-small"
                                       href="{{ route('rents.show', ['rent' => $rent->id]) }}">Ver</a>
                                </li>
                                <li>
                                    <a class="btn btn-link btn-link-small"
                                       href="{{ route('rents.edit', ['rent' => $rent->id]) }}">Editar</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('rents.destroy', ['rent' => $rent->id]) }}">
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

            {{ $rents->links() }}
        </div>
    </div>
@endsection
