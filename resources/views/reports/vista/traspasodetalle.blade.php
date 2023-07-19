@extends('layouts.app')

@section('mi_estilo')   
<style>
    .container-fluid
    {
        font-size: 0.8rem;
    }
</style>
@endsection

@section('content')
@include('layouts.sidebar', ['hide'=>'0']) 
<div class="container-fluid">
    <div class="row justify-content-center mt-4">
        <h4 class="mb-3">TRASPASOS</h4>
        <div class="col-md-12">
            <table id="datatable" class="cell-border compact hover" style="width:100%">
            <tfoot>
                <tr>
                    <th class="categoria_max">NroTrans</th>
                    <th>Fecha</th>
                    <th>Glosa</th>
                    <th>Ingreso</th>
                    <th>Destino</th>    
                    <th>Egreso</th> 
                    <th>Origen</th>           
                    <th>Solcitante</th> 
                    <th>Responsable</th> 
                    <th>Tipo</th>
                </tr>
            </tfoot>
            </table>        
        </div>
    </div>
</div>
@endsection

@section('mis_scripts')
<script>
var json_data = {!! json_encode($traspasos) !!};

$(document).ready(function() 
{  
    $('#datatable tfoot th').each( function () {
        if($(this).attr("class")!="#N/A")
        {
          var title = $(this).text();
          $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%;"/>' );
        }
    } );
    $('#datatable').DataTable( 
    {
        data: json_data,
        columns: [
            { data: 'NroTrans', title: 'NroTrans' },
            { data: 'Fecha', title: 'Fecha'},
            { data: 'Glosa', title: 'Glosa'},
            { data: 'TransaccionEgreso', title: 'Trans. Egreso'},
            { data: 'AlmacenOrigen', title: 'AlmacenOrigen'},
            { data: 'TransaccionIngreso', title: 'Trans. Ingreso'},
            { data: 'AlmacenDestino', title: 'AlmacenDestino'},
            { data: 'Solicitante', title: 'Solicitante'},
            { data: 'Responsable', title: 'Responsable'},            
            { data: 'Tipo', title: 'Tipo'},
        ],
        "pageLength": 25,  
        "columnDefs": [
            { "width": "300px", "targets": 2 },
            {
                "targets": 0,
                "render": function ( data, type, row, meta ) 
                {
                    var link = '<a class="enlace_taspaso" id ="'+data+'">'+data+'</a>'
                    return link;
                }
            },
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
        "scrollX": true,
        "scrollY": '60vh',
        "scrollCollapse": true, 
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    } );
    $(".page-wrapper").removeClass("toggled"); 

    $(".enlace_taspaso").click(function() {
        var id = $(this).attr('id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('traspasosdetalle.store')}}",
            type: 'POST',
            dataType: 'json',
            data:{id},
            success: function (data) {
                var data2 = data;
                return data2;
            },
            error: function (data) {
                console.log(data);
            }
        });
        alert(data2);
    });
} );
</script>
@endsection
