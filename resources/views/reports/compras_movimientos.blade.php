@extends('layouts.app')
@section('static', 'statick-side')
@section('content')
@include('layouts.sidebar', ['hide'=>'1']) 
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 border">
            <form method="POST" action="{{ route('comprasmov.store') }}">
            @csrf
            <div class=" row text-center my-3">
                <h3 class="text-center text-primary">COMPRAS Y MOVIMIENTOS</h3>
            </div>
            <div class="mb-3 row d-flex justify-content-center">
                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Desde:</label>
                <div class="col-sm-3">
                <input id="fecha_ini" type="date" class="form-control form-control-sm" name="fecha_ini" value ="{{date('Y-m-d')}}">
                </div>
                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Hasta:</label>
                <div class="col-sm-3">
                <input id="fecha_fin" type="date" class="form-control form-control-sm" name="fecha_fin" value ="{{date('Y-m-d')}}">
                </div>
            </div>
            <div class="mb-3 row d-flex justify-content-center">
                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Categoria:</label>
                <div class="col-sm-3">
                    <input id="categoria" type="text" class="form-control form-control-sm" name="categoria">
                </div>
                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Producto:</label>
                <div class="col-sm-3">
                    <input id="producto" type="text" class="form-control form-control-sm" name="producto">
                </div>
            </div>
            <div class="mb-4 row justify-content-center">
                <div class="col-md-6 text-center d-block gap-2">
                    <button type="submit" class="btn btn-primary mr-2" name="gen" value="export">
                        {{ __('Exportar') }}
                    </button>
                    <button type="submit" class="btn btn-primary ml-2" name="gen" value="ver">
                        {{ __('Ver') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('mis_scripts')
<script>
</script>
@endsection
