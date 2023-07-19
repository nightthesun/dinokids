@extends('layouts.app')

@section('mi_estilo')   
<style>
    .container-fluid
    {
        font-size: 0.8rem;
    }

    /* The Modal (background) */
    .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    }

    /* Modal Content */
    .modal-content {
    position: relative;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 80%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    }

    /* The Close Button */
    .close {
    cursor:pointer;
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
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">TRASPASO: 31000000</h6>
                <span class="close h5" >&times;</span>                    
            </div>
            <div class="modal-body">
                <table class="mb-3 w-100" style="font-size:0.75rem;">
                    <tr id="cabe">
                        <td><b>NRO TRANS.:</b> <span></span></td>
                        <td><b>FECHA:</b> <span></span></td>
                        <td colspan = 2><b>GLOSA:</b> <span></span></td>
                    </tr>
                    <tr id="cabe2">
                        <td><b>NRO. EGRESO:</b> <span></span></td>
                        <td><b>ALMACEN ORIGEN:</b> <span></span></td>
                        <td><b>NRO. INGRESO:</b> <span></span></td>
                        <td><b>ALMACEN DESTINO:</b> <span></span></td>
                    </tr>
                    <tr id="cabe3">
                        <td><b>SOLICITANTE:</b> <span></span></td>
                        <td><b>RESPONSABLE:</b> <span></span></td>
                        <td><b>TIPO:</b> <span></span></td>
                    </tr>
                </table>
                <table id="table_detalle" class="cell-border compact hover" style="width:100%">
                    <thead>
                        <tr>
                            <td>Item</td>
                            <td>Codigo</td>
                            <td>Descripcion</td>
                            <td>Cantidad</td>
                            <td>UM</td>
                        </tr>
                    </thead>
                </table>
            </div>
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
    var table = $('#datatable').DataTable( 
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
                    var link = '<a class="enlace_taspaso" id ="'+data+'" style="cursor:pointer;">'+data+'</a>'
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

    
    // When the user clicks on <span> (x), close the modal
    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    // When the user clicks the button, open the modal 
    span.onclick = function() {
    $('#myModal').fadeOut();
    }
    table.on( 'click','a.enlace_taspaso', function () {
        console.log("TEST");
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
            paging:false,
            success: function (data) {
                // Get the modal
                var cab = data.cabecera[0];
                $('#cabe span:eq(0)').text(id);
                $('#cabe span:eq(1)').text(cab.Fecha);
                $('#cabe span:eq(2)').text(cab.Glosa);                

                $('#cabe2 span:eq(0)').text(cab.TransEgreso);
                $('#cabe2 span:eq(1)').text(cab.AlmacenOrigen);
                $('#cabe2 span:eq(2)').text(cab.TransIngreso);
                $('#cabe2 span:eq(3)').text(cab.AlmacenDestino);

                $('#cabe3 span:eq(0)').text(cab.Solicitante);                
                $('#cabe3 span:eq(1)').text(cab.Responsable);
                $('#cabe3 span:eq(2)').text(cab.Tipo);

                $('#table_detalle').DataTable().clear();
                $('#table_detalle').DataTable().destroy();
                $('#table_detalle').DataTable({
                    data:data.detalle,
                    columns: [
                        { data: 'Item'},
                        { data: 'Codigo'},
                        { data: 'Descrip'},
                        { data: 'Cantidad'},
                        { data: 'UM'}
                    ],
                });
                $('#myModal').fadeIn();

            },
            error: function (data) {
                console.log(data);
            }
        });
    });
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == document.getElementById('myModal')) {
            $('#myModal').fadeOut();
        }
    }
} );
</script>
@endsection
