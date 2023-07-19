@extends('layouts.app')
@section('estilo')

<style>
    .categoria_max
    {
        max-width: 120px !important;
        text-overflow: ellipsis;
    }
</style>
@endsection
@section('content')
@include('layouts.sidebar', ['hide'=>'0']) 
<div class="container-fluid">
    <div class="row justify-content-center mt-4">
        <div class="col-6">
          <h3 class="text-center text-primary">En Stock</h3>
            <table id="example1" class="cell-border compact hover" style="width:100%">
                <tfoot>
                    @foreach ($titulos as $ti)
                        <th @if(isset($ti['tip']))class="{{$ti['tip']}}"@endif >@if(isset($ti['tip']) && $ti['tip'] == 'filtro'){{$ti['title']}}@endif</th>
                    @endforeach
                </tfoot>
            </table>                  
        </div>
        <div class="col-6">
          <h3 class="text-center text-primary">Quiebre de Stock</h3>
            <table id="example2" class="cell-border compact hover" style="width:100%">
                <tfoot>
                    @foreach ($titulos as $ti)
                        <th @if(isset($ti['tip']))class="{{$ti['tip']}}"@endif >@if(isset($ti['tip']) && $ti['tip'] == 'filtro'){{$ti['title']}}@endif</th>
                    @endforeach
                </tfoot>
            </table>                  
        </div>
    </div>
</div>
@endsection

@section('mis_scripts')
<script>
var json_data1 = {!! json_encode($textMax) !!};
var json_data2 = {!! json_encode($textMin) !!};
var titulos = {!! json_encode($titulos) !!};
var money = [], decimal = [];
titulos.forEach(function(element, key){
    if(element.tip == 'money')
    {
        money.push(key);
    } 
    if(element.tip == 'decimal')
    {
        decimal.push(key);
    }
});
$(document).ready(function() 
{  
    $('#example1 tfoot th').each( function () {
        if($(this).hasClass('filtro'))
        {
          var title = $(this).text();
          $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%;"/>' );
        }
    } );
    $('#example1').DataTable( 
    {
        data: json_data1,
        columns: titulos,
        "pageLength": 25, 
        "columnDefs": [
            { className: "categoria_max", "targets": [0] },
            { className: "text-success", "targets": [6] },
            { className: "dt-right", "targets":money },
            { className: "dt-right", "targets":decimal },
        ],
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
        "scrollY": "60vh",
        "scrollCollapse": true,
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                if($(this.footer()).hasClass( "filtro_select" ))
                {
                    var column = this;
                    var select = 
                    $('<select class="form-select form-select-sm" style="background-image:none;padding-right:8px;width:auto"><option value="" class="text-secondary">TODOS</option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
    
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
    
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                }
                else if($(this.footer()).hasClass( "filtro" ))
                {
                    var that = this;
                    $( 'input', this.footer() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                        }
                    } );
                }      
            } );
        }
    } );
    $('#example2 tfoot th').each( function () {
        if($(this).hasClass('filtro'))
        {
          var title = $(this).text();
          $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%;"/>' );
        }
    } );
    $('#example2').DataTable( 
    {
        data: json_data2,
        columns: titulos,
        "pageLength": 25, 
        "columnDefs": [
            { className: "categoria_max", "targets": [0] },
            { className: "text-danger", "targets": [6] },
            { className: "dt-right", "targets":money },
            { className: "dt-right", "targets":decimal },
        ],
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
        "scrollY": "60vh",
        "scrollCollapse": true,
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                if($(this.footer()).hasClass( "filtro_select" ))
                {
                    var column = this;
                    var select = 
                    $('<select class="form-select form-select-sm" style="background-image:none;padding-right:8px;width:auto"><option value="" class="text-secondary">TODOS</option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
    
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
    
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                }
                else if($(this.footer()).hasClass( "filtro" ))
                {
                    var that = this;
                    $( 'input', this.footer() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                        }
                    } );
                }      
            } );
        }
    } );
    $(".page-wrapper").removeClass("toggled"); 
} );
</script>
@endsection
