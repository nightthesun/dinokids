<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('marca') }}
            {{ Form::text('marca', $historia->marca, ['class' => 'form-control' . ($errors->has('marca') ? ' is-invalid' : ''), 'placeholder' => 'Marca']) }}
            {!! $errors->first('marca', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('tipo') }}
            {{ Form::text('tipo', $historia->tipo, ['class' => 'form-control' . ($errors->has('tipo') ? ' is-invalid' : ''), 'placeholder' => 'Tipo']) }}
            {!! $errors->first('tipo', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('modelo') }}
            {{ Form::text('modelo', $historia->modelo, ['class' => 'form-control' . ($errors->has('modelo') ? ' is-invalid' : ''), 'placeholder' => 'Modelo']) }}
            {!! $errors->first('modelo', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('ns') }}
            {{ Form::text('ns', $historia->ns, ['class' => 'form-control' . ($errors->has('ns') ? ' is-invalid' : ''), 'placeholder' => 'Ns']) }}
            {!! $errors->first('ns', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('caracteristicas') }}
            {{ Form::text('caracteristicas', $historia->caracteristicas, ['class' => 'form-control' . ($errors->has('caracteristicas') ? ' is-invalid' : ''), 'placeholder' => 'Caracteristicas']) }}
            {!! $errors->first('caracteristicas', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('estado') }}
            {{ Form::text('estado', $historia->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
            {!! $errors->first('estado', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_empleado') }}
            {{ Form::text('id_empleado', $historia->id_empleado, ['class' => 'form-control' . ($errors->has('id_empleado') ? ' is-invalid' : ''), 'placeholder' => 'Id Empleado']) }}
            {!! $errors->first('id_empleado', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
