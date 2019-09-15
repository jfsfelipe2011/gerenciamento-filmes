@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rents.index') }}">Alugueis</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ver</li>
            </ol>
        </nav>
        <div class="row" style="margin-bottom:3%">
            <h3>Aluguel #{{ $rent->id }}</h3>
        </div>
        <div class="row">
            <div class="card" style="width: 100%">
                <div class="card-body">
                    <h5 class="card-title">Cliente: {{ $rent->customer->name }}</h5>
                    @foreach($rent->films as $film)
                        <img src="{{ url("storage/$film->image") }}" height="250" width="200">
                        <p>{{ $film->name }}</p>
                    @endforeach
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Status: {{ $rent->status_formatted }}</li>
                    <li class="list-group-item">De {{ $rent->start_date_formatted }} até {{ $rent->end_date_formatted }}</li>
                    <li class="list-group-item">Dias de aluguel: {{ $rent->daysOfRent() }}</li>
                    <li class="list-group-item">Data de Entrega: {{ $rent->delivery_date_formatted }}</li>
                    <li class="list-group-item">Dias de atraso: {{ $rent->daysOfDelay() }}</li>
                    <li class="list-group-item">Valor: R$ {{ $rent->value }}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
