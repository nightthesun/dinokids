@extends('layouts.app')
@section('static', 'statick-side')
@section('content')
@include('layouts.sidebar', ['hide'=>'1']) 
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 border">
            <form method="POST" target="_blank" action="{{ route('resumenventastotal.store') }}">
                @csrf
                <div class=" row d-flex justify-content-center my-3">
                    <div class="d-flex align-items-center justify-content-end">
                        <h3 class="text-center text-primary">RESUMEN TOTAL DE VENTAS</h3>
                    </div>
                </div>
                <div class="row d-flex justify-content-center"><div class="col-10">
                    <div class="form-group row d-flex justify-content-center">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Desde:</label>
                        <div class="col-sm-4">
                        <input id="fini" type="date" class="form-control form-control-sm " name="fini" value ="{{date('Y-m-d')}}">
                        </div>
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Hasta:</label>
                        <div class="col-sm-4">
                        <input id="ffin" type="date" class="form-control form-control-sm " name="ffin" value ="{{date('Y-m-d')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12 d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-primary mx-2" name="gen" value="export">
                        {{ __('Exportar PDF') }}
                    </button>
                    <button type="submit" class="btn btn-primary mx-2" name="gen" value="ver">
                        {{ __('Ver') }}
                    </button>
                    <!--<button type="submit" class="btn btn-primary mx-2" name="gen" value="excel">
                        {{ __('Exportar EXCEL') }}
                    </button>-->
                    
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
