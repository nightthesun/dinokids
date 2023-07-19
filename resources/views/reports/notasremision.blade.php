@extends('layouts.app')
@section('static', 'statick-side')
@section('content')
@include('layouts.sidebar', ['hide'=>'1']) 
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 border">
            <form method="POST" target="_blank" action="{{ route('notasremision.store') }}">
                @csrf
                <div class=" row d-flex justify-content-center my-3">
                    <div class="d-flex align-items-center justify-content-end">
                        <h3 class="text-center text-primary">Notas de Remision</h3>
                    </div>
                </div>
                <div class="row d-flex justify-content-center"><div class="col-10">
                    @if((Auth::user()->authorizePermisos(['Notas De Remisión', 'Rango de Fechas'])))
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
                    @else
                    <div class="form-group row d-flex justify-content-center">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Del:</label>
                        <div class="col-sm-4">
                        <input id="ffin" type="date" class="form-control form-control-sm " name="ffin" value ="{{date('Y-m-d')}}">
                        </div>
                    </div>
                    @endif
                    <div class="form-group row d-flex justify-content-center">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Usuario:</label>
                        <div class="col-sm-6">
                            <select name="user" id="user" class="form-control form-control-sm">
                                @foreach($user as $u)
                                <option value = "{{$u->adusrCusr}}">{{$u->adusrNomb}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row d-flex justify-content-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="facturadas" name="facturadas"> 
                            <label class="form-check-label" for="flexSwitchCheckDefault"> Incluir Notas de Remision Facturadas</label>
                        </div>
                    </div>
                    <!--div class="form-group row d-flex justify-content-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="stock0" name="stock0" checked> 
                            <label class="form-check-label" for="flexSwitchCheckDefault">Productos con stock 0</label>
                        </div>
                    </div-->
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12 d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-primary" name="gen" value="export">
                        {{ __('Exportar a PDF') }}
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
