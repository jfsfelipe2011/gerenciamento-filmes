<div class="form-group">
    {!! Form::label('name', 'Nome') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Descrição') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 6, 'cols' => 4]) !!}
</div>

<div class="form-group">
    {!! Form::label('image', 'Imagem') !!}
    {!! Form::file('image', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('duration', 'Duração(Min)') !!}
    {!! Form::number('duration', null, ['class' => 'form-control', 'min' => 10]) !!}
</div>

<div class="form-group">
    {!! Form::label('release_date', 'Data de Lançamento') !!}
    {!! Form::date('release_date', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('category_id', 'Categoria') !!}
    {!! Form::select('category_id', \App\Category::pluck('name', 'id'), null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('actors', 'Elenco') !!}
    {!! Form::select('actors[]', \App\Actor::pluck('name', 'id'), null,
    ['class' => 'form-control', 'multiple' => 'multiple']) !!}
</div>

<div class="form-group">
    {!! Form::label('directors', 'Diretores') !!}
    {!! Form::select('directors[]', \App\Director::pluck('name', 'id'), null,
    ['class' => 'form-control', 'multiple' => 'multiple']) !!}
</div>
