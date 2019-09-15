@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Estoques</li>
        </ol>
    </nav>
    <div class="row" style="margin-bottom:3%">
        <div class="col-10">
            <h3>Lista de Filmes Estocados</h3>
        </div>
        <div class="col-2">
            <a class="btn btn-primary" href="{{ route('stocks.create') }}">Novo Estoque</a>
        </div>
    </div>
    <div class="row">
        @include('success.success-form')
        @include('errors.errors')

        <table class="table table-striped" style="text-align:center">
            <thead>
            <tr>
                <th>ID</th>
                <th>Filme</th>
                <th>Quantidade</th>
                <th>Valor</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stocks as $stock)
                <tr>
                    <td>{{ $stock->id }}</td>
                    <td>{{ $stock->film->name }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>{{ $stock->value }}</td>
                    <td>
                        <ul class="list-inline list-small">
                            <li>
                                <a class="btn btn-link btn-link-small"
                                   href="{{ route('stocks.add', ['stock' => $stock->id]) }}">Adicionar</a>
                            </li>
                            <li>
                                <a class="btn btn-link btn-link-small"
                                   href="{{ route('stocks.edit', ['stock' => $stock->id]) }}">Editar</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('stocks.destroy', ['stock' => $stock->id]) }}">
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

        {{ $stocks->links() }}
    </div>
</div>
@endsection
