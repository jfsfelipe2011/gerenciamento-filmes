<div class="form-group">
    {!! Form::label('value', 'Valor') !!}
    {!! Form::text('value', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('quantity', 'Quantidade de Filmes') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control', 'min' => 1]) !!}
</div>

<div class="form-group">
    {!! Form::label('film_id', 'Filme') !!}
    {!! Form::select('film_id', \App\Film::pluck('name', 'id'), null, ['class' => 'form-control']) !!}
</div>
