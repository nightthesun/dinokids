<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('tipo') }}
            {{ Form::text('tipo', $componente->tipo, ['class' => 'form-control' . ($errors->has('tipo') ? ' is-invalid' : ''), 'placeholder' => 'Tipo']) }}
            {!! $errors->first('tipo', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('marca') }}
            {{ Form::text('marca', $componente->marca, ['class' => 'form-control' . ($errors->has('marca') ? ' is-invalid' : ''), 'placeholder' => 'Marca']) }}
            {!! $errors->first('marca', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('modelo') }}
            {{ Form::text('modelo', $componente->modelo, ['class' => 'form-control' . ($errors->has('modelo') ? ' is-invalid' : ''), 'placeholder' => 'Modelo']) }}
            {!! $errors->first('modelo', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('caracteristicas') }}
            {{ Form::text('caracteristicas', $componente->caracteristicas, ['class' => 'form-control' . ($errors->has('caracteristicas') ? ' is-invalid' : ''), 'placeholder' => 'Caracteristicas']) }}
            {!! $errors->first('caracteristicas', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('estado') }}
            {{ Form::text('estado', $componente->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
            {!! $errors->first('estado', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_compu') }}
            {{ Form::text('id_compu', $componente->id_compu, ['class' => 'form-control' . ($errors->has('id_compu') ? ' is-invalid' : ''), 'placeholder' => 'Id Compu']) }}
            {!! $errors->first('id_compu', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>