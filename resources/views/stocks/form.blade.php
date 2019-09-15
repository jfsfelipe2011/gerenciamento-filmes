<div class="form-group">
    {!! Form::label('value', 'Valor') !!}
    {!! Form::text('value', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('quantity', 'Quantidade de Filmes') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control', 'min' => 1]) !!}
</div>

@if(!isset($stock))
<div class="form-group">
    {!! Form::label('film_id', 'Filme') !!}
    {!! Form::select('film_id', \App\Film::getFilmsNotStock(), null, ['class' => 'form-control']) !!}
</div>
@else
<div class="form-group">
    {!! Form::label('film_id', 'Filme') !!}
    {!! Form::text('film_id', $stock->film->name, ['class' => 'form-control', 'disabled' => true]) !!}
    {!! Form::hidden('film_id', $stock->film->id) !!}
</div>
@endif
