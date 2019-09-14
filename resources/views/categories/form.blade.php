<div class="form-group">
    {!! Form::label('name', 'Nome') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Descrição') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 10, 'cols' => 4]) !!}
</div>
