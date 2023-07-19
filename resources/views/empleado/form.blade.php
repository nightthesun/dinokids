<div class="box box-info padding-1">
    <div class="box-body">
        <div class="form-group mb-3">
            {{-- {{ Form::label('nombre') }} --}}
            {{ Form::text('nombre', $empleado->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group mb-3">
            {{-- {{ Form::label('paterno') }} --}}
            {{ Form::text('paterno', $empleado->paterno, ['class' => 'form-control' . ($errors->has('paterno') ? ' is-invalid' : ''), 'placeholder' => 'Paterno']) }}
            {!! $errors->first('paterno', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group mb-3">
            {{-- {{ Form::label('materno') }} --}}
            {{ Form::text('materno', $empleado->materno, ['class' => 'form-control' . ($errors->has('materno') ? ' is-invalid' : ''), 'placeholder' => 'Materno']) }}
            {!! $errors->first('materno', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group mb-3">
            {{-- {{ Form::label('C.I.') }} --}}
            {{ Form::text('ci', $empleado->ci, ['class' => 'form-control' . ($errors->has('ci') ? ' is-invalid' : ''), 'placeholder' => 'C.I.']) }}
            {!! $errors->first('ci', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group mb-3">
            {{-- {{ Form::label('area') }} --}}
            {{ Form::text('area', $empleado->area, ['class' => 'form-control' . ($errors->has('area') ? ' is-invalid' : ''), 'placeholder' => 'Area']) }}
            {!! $errors->first('area', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group mb-3">
            {{-- {{ Form::label('cargo') }} --}}
            {{ Form::text('cargo', $empleado->cargo, ['class' => 'form-control' . ($errors->has('cargo') ? ' is-invalid' : ''), 'placeholder' => 'Cargo']) }}
            {!! $errors->first('cargo', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group mb-3">
            {{-- {{ Form::label('sucursal') }} --}}
            {{ Form::text('sucursal', $empleado->sucursal, ['class' => 'form-control' . ($errors->has('sucursal') ? ' is-invalid' : ''), 'placeholder' => 'Sucursal']) }}
            {!! $errors->first('sucursal', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group mb-3">
            {{-- {{ Form::label('IP') }} --}}
            {{ Form::text('ip', $empleado->ip, ['class' => 'form-control' . ($errors->has('ip') ? ' is-invalid' : ''), 'placeholder' => 'IP']) }}
            {!! $errors->first('ip', '<div class="invalid-feedback">:message</p>') !!}
        </div>
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</div>
