@extends('layouts.app')
<style>
table.dataTable {
  font-size: 0.9em;
}
.categoria_max
    {
        max-width: 300px !important;
        text-overflow: ellipsis;
    }

.dataTables_scrollBody{
  max-height: 530px !important;
}
</style>
@section('content')
@include('layouts.sidebar', ['hide'=>'0']) 


<div class="container-fluid">
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <table id="example" class="cell-border compact hover" style="width:100%">
            <!-- <tfoot class="table tabll-sm border prueba">
              <tr class="text-right">
                <th colspan = 3></th>
                <th>TOTAL</th>
                <td class="sumTCXP bg-success"></td>
                <td class="sumTCuenta bg-warning"></td>
                <td class="sumTSaldo bg-info"></td>
                <th colspan = 5></th>
                <tr class="text-right">
                <td colspan = 3></td>
                <td>VIGENTE</td>
                <td class="sumVigenteCXP bg-success dt-right"></td>            
                <td class="sumVigenteCuenta bg-warning dt-right"></td>
                <td class="sumVigenteSaldo bg-info dt-right"></td>
                <td colspan = 5></td>
                </tr>
                <tr class="text-right">
                <td colspan = 3></td>
                <td>VENCIDO</td>
                <td class="sumVencidoCXP bg-success dt-right"></td>            
                <td class="sumVencidoCuenta bg-warning dt-right"></td>
                <td class="sumVencidoSaldo bg-info dt-right"></td>
                <td colspan = 6></td>
                </tr>
                <tr class="text-right">
                <td colspan = 3></td>
                <td>MORA</td>
                <td class="sumMoraCXP bg-success dt-right"></td>            
                <td class="sumMoraCuenta bg-warning dt-right"></td>
                <td class="sumMoraSaldo bg-info dt-right"></td>
                <td colspan = 6></td>
              </tr>
            </tfoot> -->
              <tfoot>
                  @foreach ($titulos as $ti)
                      <th @if(isset($ti['tip']))class="{{$ti['tip']}}"@endif >@if(isset($ti['tip']) && $ti['tip'] == 'filtro'){{$ti['title']}}@endif</th>
                  @endforeach
              </tfoot>
            </table>        
        </div>
    </div>
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h6 class="modal-title"></h6> -->
                <span class="close h5" >&times;</span>                    
            </div>
            <div class="modal-body">
                <table id="table_detalle" class="cell-border compact hover" style="width:100%">
                    <thead>
                        <tr>
                            <td>Codigo</td>
                            <td>ImporteCXP</td>
                            <td>ACuenta</td>
                            <td>Saldo</td>
                            <td>Glosa</td>
                            <td>Fecha</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- <button id="actualizar">actualizar  Totales</button> -->
@endsection

@section('mis_scripts')
<script>
var json_data = {!! json_encode($cxp) !!};
jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
    return this.flatten().reduce( function ( a, b ) {
        if ( typeof a === 'string' ) {
            a = a.replace(/[^\d.-]/g, '') * 1;
        }
        if ( typeof b === 'string' ) {
            b = b.replace(/[^\d.-]/g, '') * 1;
        }
        return a + b;
    }, 0 );
} );
$('#example tfoot th').each( function () {
    if($(this).hasClass('filtro'))
    {
      var title = $(this).text();
      $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%;"/>' );
    }
} );
$(document).ready(function() 
{  
    
    var height = screen.height-500+'px';
    var table = $('#example').DataTable( 
    {
        
        data: json_data,
        columns: [
            { data: 'Cod', title: 'Codigo' },
            { data: 'Proveedor', title: 'Proveedor' },
            // { data: 'Rsocial', title: 'Rsocial' },
            // { data: 'Nit', title: 'Nit' },
            { data: 'Fecha', title: 'Fecha'},
            { data: 'FechaVenc', title: 'FechaVenc'},
            { data: 'ImporteCXP', title: 'ImporteCXP'},
            { data: 'ACuenta', title: 'ACuenta'},
            { data: 'Saldo', title: 'Saldo'},
            { data: 'Glosa', title: 'Glosa'},
            { data: 'Usuario', title: 'Usuario'},
            { data: 'Moneda', title: 'M.'},
            { data: 'NroCompra', title: 'NCompra'},
            // { data: 'NroFac', title: 'Num. Fac'},
            { data: 'Local', title: 'Local'},
            { data: 'estado', title: 'Estado'},
                /*"render": function (data, row) 
                {
                    if (row === "MORA") 
                    {
                        data = 'MORAS';          
                    }
                }*/        
        ],
        "pageLength": 100,  
        "columnDefs": [
          {
                "targets": 0,
                "render": function ( data, type, row, meta ) 
                {
                    var link = '<a class="enlace_cuenta" id ="'+data+'" style="cursor:pointer;">'+data+'</a>'
                    return link;
                }
            },
            { className: "dt-right", "targets":[4,5,6]},
            { className: "sum_total", "targets":[4]},
            { className: "categoria_max", "targets":[1,5]}
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
        "scrollX": false,
        "scrollY": height,
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
    //var sum = table.column(4).data().sum();
    //$("#sum").val(sum);
    function totales() 
    {
        //var sum = table.column(4).data();
        //var tab = table.rows( { selected: true, search: 'applied' } ).data();
        //console.log(tab); 
        var sumTCXP = table.column( 4, {search:'applied'} ).data().sum();
        var sumTCuenta = table.column( 5, {search:'applied'} ).data().sum();
        var sumTSaldo = table.column( 6, {search:'applied'} ).data().sum();
        sumTCXP = Math.round((sumTCXP + Number.EPSILON) * 100) / 100;
        sumTCuenta = Math.round((sumTCuenta + Number.EPSILON) * 100) / 100;
        sumTSaldo = Math.round((sumTSaldo + Number.EPSILON) * 100) / 100;
        $('.dataTables_scrollFootInner .sumTCXP').html(sumTCXP.toFixed(2));
        $('.dataTables_scrollFootInner .sumTCuenta').html(sumTCuenta.toFixed(2));
        $('.dataTables_scrollFootInner .sumTSaldo').html(sumTSaldo.toFixed(2));
        var vigente = table
        .rows({search:'applied'})
        .indexes()
        .filter( function ( value, index ) {
            return 'VIGENTE' === table.row(value).data()['estado'];
        } );
        var vencido = table
        .rows({search:'applied'})
        .indexes()
        .filter( function ( value, index ) {
            return 'VENCIDO' === table.row(value).data()['estado'];
        } );
        var mora = table
        .rows({search:'applied'})
        .indexes()
        .filter( function ( value, index ) {
            return 'MORA' === table.row(value).data()['estado'];
        } );
        sumVigenteCXP = Math.round((table.cells(vigente, 4).data().sum() + Number.EPSILON) * 100) / 100;
        sumVigenteCuenta = Math.round((table.cells(vigente, 5).data().sum() + Number.EPSILON) * 100) / 100;
        sumVigenteCSaldo = Math.round((table.cells(vigente, 6).data().sum() + Number.EPSILON) * 100) / 100;
        $('.dataTables_scrollFootInner .sumVigenteCXP').html(sumVigenteCXP.toFixed(2));
        $('.dataTables_scrollFootInner .sumVigenteCuenta').html(sumVigenteCuenta.toFixed(2));
        $('.dataTables_scrollFootInner .sumVigenteSaldo').html(sumVigenteCSaldo.toFixed(2));

        sumVencidoCXP = Math.round((table.cells(vencido, 4).data().sum() + Number.EPSILON) * 100) / 100;
        sumVencidoCuenta = Math.round((table.cells(vencido, 5).data().sum() + Number.EPSILON) * 100) / 100;
        sumVencidoCSaldo = Math.round((table.cells(vencido, 6).data().sum() + Number.EPSILON) * 100) / 100;
        $('.dataTables_scrollFootInner .sumVencidoCXP').html(sumVencidoCXP.toFixed(2));
        $('.dataTables_scrollFootInner .sumVencidoCuenta').html(sumVencidoCuenta.toFixed(2));
        $('.dataTables_scrollFootInner .sumVencidoSaldo').html(sumVencidoCSaldo.toFixed(2));

        sumMoraCXP = Math.round((table.cells(mora, 4).data().sum() + Number.EPSILON) * 100) / 100;
        sumMoraCuenta = Math.round((table.cells(mora, 5).data().sum() + Number.EPSILON) * 100) / 100;
        sumMoraCSaldo = Math.round((table.cells(mora, 6).data().sum() + Number.EPSILON) * 100) / 100;
        $('.dataTables_scrollFootInner .sumMoraCXP').html(sumMoraCXP.toFixed(2));
        $('.dataTables_scrollFootInner .sumMoraCuenta').html(sumMoraCuenta.toFixed(2));
        $('.dataTables_scrollFootInner .sumMoraSaldo').html(sumMoraCSaldo.toFixed(2));
        
    }
    totales();
    $( '#example_filter label input').on( 'keyup change', function () {
        totales();
    } );
    $( '#example_filter label input').on( 'change', function () {
        totales();
    } );
    setTimeout(function(){
    $(".page-wrapper").removeClass("toggled"); 
  }, 500);
  var span = document.getElementsByClassName("close")[0];
  span.onclick = function() {
    $('#myModal').fadeOut();
    }
  table.on( 'click','a.enlace_cuenta', function () {
        console.log("TEST");
        var id = $(this).attr('id');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('cuentasporpagardetalle.store')}}",
            type: 'POST',
            dataType: 'json',
            data:{id},
            paging:false,
            success: function (data) {
                // Get the modal}
                $('#table_detalle').DataTable().clear();
                $('#table_detalle').DataTable().destroy();
                $('#table_detalle').DataTable({
                    data:data.detalle,
                    columns: [
                        // { data: 'liqdCNtcc'},
                        // { data: 'liqdcImpC',render: $.fn.dataTable.render.number( ',', '.', 2)},
                        // { data: 'liqdCAcmt',render: $.fn.dataTable.render.number( ',', '.', 2)},
                        // { data: 'liqXCGlos'},
                        // { data: 'Fecha'}
                        { data: 'codigo'},
                        { data: 'importe',render: $.fn.dataTable.render.number( ',', '.', 2)},
                        { data: 'descuento',render: $.fn.dataTable.render.number( ',', '.', 2)},
                        { data: 'saldo',render: $.fn.dataTable.render.number( ',', '.', 2)},
                        { data: 'glosa'},
                        { data: 'fecha'}
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
