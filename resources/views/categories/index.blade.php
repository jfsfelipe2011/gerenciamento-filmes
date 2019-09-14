@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="margin-bottom:3%">
        <h3>Lista de Categorias</h3>
        <a class="btn btn-primary" style="margin-left:70%" href="{{ route('categories.create') }}">Nova Categoria</a>
    </div>
    <div class="row">
        @include('success.success-form')
        @include('errors.errors')

        <table class="table table-striped" style="text-align:center">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <ul class="list-inline list-small">
                            <li>
                                <a class="btn btn-link btn-link-small"
                                   href="{{ route('categories.edit', ['category' => $category->id]) }}">Editar</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('categories.destroy',
                                ['category' => $category->id]) }}">
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

        {{ $categories->links() }}
    </div>
</div>
@endsection
