<div class="form-group">
    {!! Form::label('name', 'Nome') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('date_of_birth', 'Data de Nascimento') !!}
    {!! Form::date('date_of_birth', new \DateTime(), ['class' => 'form-control']) !!}
</div>