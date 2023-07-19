@extends('layouts.app')
@section('estilo')
<style>
    .categoria_max
    {
        max-width: 100px !important;
        text-overflow: ellipsis;
    }
</style>
@endsection
@section('content')
@include('layouts.sidebar', ['hide'=>'0']) 
<div class="container-fluid">
    <div class="row justify-content-center mt-4">
        <div class="col">
            <table id="example" class="cell-border compact hover" style="width:100%"></table>         
        </div>
    </div>
</div>
@endsection

@section('mis_scripts')
<script>
var json_data = {!! json_encode($preciocosto) !!};
var titles = {!! json_encode($titles) !!};
$(document).ready(function() 
{  
    var columns = [
    { data: 'codProd', title: 'Codigo' },
    ];
    $('#example').DataTable( 
    {
        data: json_data,
        columns: titles,
        dom: 'Bfrtip',
        buttons: [
            'excel'
        ],
        "pageLength": 25, 
        "language":             
        {
            "emptyTable":     "Tabla Vacia",
            "info":           "Se muestran del _START_ al _END_ de _TOTAL_ registros",
            "infoEmpty":      "Se muestran del 0 al 0 de 0 Registros",
            "infoFiltered":   "(Filtrado de un total de _MAX_ registros)",
            "lengthMenu":     "Se muestran _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "zeroRecords":    "No se encontro ningun registro",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Anterior"
            }
        },
        "scrollX":true,
        "scrollY": '70vh',
        "scrollCollapse": true, 
    } );
    setTimeout(function(){
    $(".page-wrapper").removeClass("toggled"); 
 }, 500);
} );

</script>
@endsection
