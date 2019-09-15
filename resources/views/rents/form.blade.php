<div class="form-group">
    {!! Form::label('start_date', 'Data de Inicio') !!}
    {!! Form::date('start_date', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('end_date', 'Data de Fim') !!}
    {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('customer_id', 'Cliente') !!}
    {!! Form::select('customer_id', \App\Customer::pluck('name', 'id'), null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('films', 'Filmes') !!}
    {!! Form::select('films[]', \App\Film::getFilmsForRent(), null,
    ['class' => 'form-control', 'multiple' => 'multiple']) !!}
</div>
