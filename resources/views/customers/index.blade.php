@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Clientes</li>
        </ol>
    </nav>
    <div class="row" style="margin-bottom:3%">
        <div class="col-10">
            <h3>Lista de Clientes</h3>
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
                <th>Endereço</th>
                <th>Documento</th>
                <th>Pagamento</th>
                <th>Ação</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->document_formatted }}</td>
                    <td>{{ $customer->payment_formatted }}</td>
                    <td>
                        <ul class="list-inline list-small">
                            <li>
                                <a class="btn btn-link btn-link-small"
                                   href="#">Ver Aluguéis</a>
                            </li>
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $customers->links() }}
    </div>
</div>
@endsection
