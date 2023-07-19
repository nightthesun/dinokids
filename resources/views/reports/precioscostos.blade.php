@extends('layouts.app')
@section('static', 'statick-side')
@section('estilo')
 <style>
 .multi-select
 {
    display: block;
    width: 100%;
    font-weight: 400;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    height: auto;
    height: calc(1.5em + 0.5rem + 2px);
    padding: 0.25rem 0.5rem;
    font-size: 0.7875rem;
    line-height: 1.5;
    overflow: hidden;
    white-space: nowrap;
    border-radius: 0.2rem;
    text-align: left; 
 }

 .multi-select-op
 {
    clear: both;
    display: inline-block;
    overflow: hidden;
    white-space: nowrap;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 0.8rem;
    font-weight: 400;
    line-height: 1.6;
    color: #495057;
    background-color: #fff;

    height: auto;
    height: calc(1.5em + 0.5rem + 2px);
    padding: 0.25rem 0.5rem;
    font-size: 0.7875rem;
    line-height: 1.5;
 }
 .scrollable-menu {
    height: auto;
    max-height: 200px;
    overflow-x: scroll;
}
 </style>
@endsection
@section('content')
@include('layouts.sidebar', ['hide'=>'1']) 
<div class="container">
   
    <form method="POST" action="{{ route('precioscostos.store') }}">
    @csrf
        <div class=" row d-flex justify-content-center my-3">
            <div class="d-flex align-items-center justify-content-center">
                <h3 class="text-primary">PRECIOS</h3>
            </div>
        </div>
        <div class="row justify-content-center m-3">
            <div class="col-4">  
                <div class="row d-flex justify-content-center">
                    <h5>FILTROS</h5>
                    <div class="col-12">
                        <div class="mb-2 row d-flex justify-content-center">
                            <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm text-right">Fecha Al:</label>
                            <div class="col-sm-6">
                            <input id="ffin" type="date" class="form-control form-control-sm " name="ffin" value ="{{date('Y-m-d')}}">
                            </div>
                        </div>   
                    </div>
                </div>                
            </div>
            <div class="col-4" id="lista">
                <h5>LISTA DE PRECIOS</h5>
                <div class="px-2 overflow-auto border rounded" style="height:300px">
                <div class="form-check">
                    <label>
                        <input type="checkbox" class="selectall" />
                        TODOS
                    </label>
                </div>
                @foreach($loc_lis as $loc =>$lista)
                    <div class="form-check fw-bold">{{$loc}}</div>
                    @foreach($lista as $lis)
                    <div class="form-check">
                        <label>
                            <input name='lis_options[]' type="checkbox" class="option justone" value='{{$lis->vtLisDesc}}'/> 
                                {{$lis->vtLisDesc}}
                        </label>
                    </div>
                    @endforeach
                @endforeach
                </div>
            </div>
         
        </div>
        <div class="controles-form">
            <button type="submit" class="btn btn-primary mx-2" name="gen" value="export">
                PDF <i class="fas fa-file-pdf"></i>
            </button>
            <button type="submit" class="btn btn-primary mx-2" name="gen" value="ver">
                Ver <i class="fas fa-bullseye"></i>
            </button>
            <button type="submit" class="btn btn-primary mx-2" name="gen" value="excel">
                Excel <i class="far fa-file-excel"></i>
            </button>
        </div>
    </form>
</div>

@endsection
@section('mis_scripts')
<script>
$( ".dropdown-menu" ).click(function() {
    $('.dropdown-menu').parent().is(".open") && e.stopPropagation();
});

$('#lista .selectall').click(function() {
    if ($(this).is(':checked')) {
        $('#lista .option').prop('checked', true);
        var total = $('#lista input[name="options[]"]:checked').length;
        $("#lista .dropdown-text").html('(' + total + ') Selected');
        $("#lista .select-text").html('(TODOS)');
    } else {
        $('#lista .option').prop('checked', false);
        $("#lista .dropdown-text").html('(0) Selected');
        $("#lista .select-text").html('');
    }
});

$('#almacen .selectall').click(function() {
    if ($(this).is(':checked')) {
        $('#almacen .option').prop('checked', true);
        var total = $('#almacen input[name="options[]"]:checked').length;
        $("#almacen .dropdown-text").html('(' + total + ') Selected');
        $("#almacen .select-text").html('(TODOS)');
    } else {
        $('#almacen .option').prop('checked', false);
        $("#almacen .dropdown-text").html('(0) Selected');
        $("#almacen .select-text").html('');
    }
});
</script>
@endsection
