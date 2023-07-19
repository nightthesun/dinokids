@extends('layouts.app')
@section('estilo')

<style>
    .categoria_max
    {
        max-width: 120px !important;
        text-overflow: ellipsis;
    }
    .pedido_max{
      width: 100px;
      display: flex;
      flex-direction: row;
    }
    
    .sumtotal{
      display: none;
    }
</style>
@endsection
@section('content')
@include('layouts.sidebar', ['hide'=>'0']) 
<div class="container-fluid">
    <div class="row justify-content-center mt-4">
        <div class="col">
            <table id="example" class="cell-border compact hover" style="width:100%">
                <tfoot>
                    @foreach ($titulos as $ti)
                        <th @if(isset($ti['tip']))class="{{$ti['tip']}}"@endif >@if(isset($ti['tip']) && $ti['tip'] == 'filtro'){{$ti['title']}}@endif</th>
                    @endforeach
                </tfoot>
            </table>         
        </div>
        <div class="w-50">
            <form action="{{ route('stockventa.historia') }}" method="POST" target="_blank">
                @csrf
                <table id='example2' class="table">
                    <thead>
                      <tr>
                        <th scope="col">Categoria</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">U.M.</th>
                        <th scope="col">Cantidad</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <input class="d-none" type="text" value='{{Auth::user()->id}}' name="cod_user">
                <input class="d-none" type="text" value='Almacen {{$nombAlmacen}}' name="alm_destino">
                <div class="mb-1">
                    <select class="form-select" aria-label="Default select example" name="alm_origen">
                        <option value="Almacen AC2">Almacen AC2</option>
                        <option value="Almacen Planta">Almacen Planta</option>
                        <option value="Almacen Ballivian">Almacen Ballivian</option>
                        <option value="Almacen Calacoto">Almacen Calacoto</option>
                        <option value="Almacen Handal">Almacen Handal</option>
                        <option value="Almacen Mariscal">Almacen Mariscal</option>
                    </select>
                </div>
                <div class="">
                  <button id="" type="submit" class="btn btn-success" name="gen" value='export'>Solicitar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('mis_scripts')
<script>
var json_data2 = {!! json_encode($array) !!};
const btn1 = document.getElementById('btn1');
const table1 = document.getElementById('example');
const table2 = document.getElementById('example2');
let id = 0;
let id2 = 0;

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
    $('#example tfoot th').each( function () {
        if($(this).hasClass('filtro'))
        {
          var title = $(this).text();
          $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%;"/>' );
        }
    } );
    $('#example').DataTable( 
    {
        data: json_data2,
        columns: titulos,
        fnCreatedRow: function( rowEl, data) {
            $(rowEl).attr('id', id++);
        },
        "pageLength": 25, 
        "columnDefs": [
            // { className: "categoria_max", "targets": [0] },
            // { className: "punto_referencia", "targets": [7] },
            { className: "pedido_max", "targets":[14] },
            { className: "sumtotal", "targets":[15] },
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
    
    $("#example").on('click', '.btnAdd', function() {
        var prodCat = '';
        var item = $(this).closest("tr")   // Finds the closest row <tr         // Retrieves the text within <td>
                        .attr('id');
        console.log(item);
        if (document.getElementById(json_data2[item].codigo).value != 0){
            const row = table2.insertRow();
            row.setAttribute('id', id2++);
            row.innerHTML = `
            <td><input class="form-control" type="text" name="catprod2[]" placeholder="Tipo" value="${json_data2[item].categoria}"></td>
            <td><input class="form-control" type="text" name="codprod2[]" placeholder="Tipo" value="${json_data2[item].codigo}"></td>
            <td><input class="form-control" type="text" name="desprod2[]" placeholder="Tipo" value="${json_data2[item].descripcion}"></td>
            <td><input class="form-control" type="text" name="umprod2[]" placeholder="Tipo" value="${json_data2[item].umprod}"></td>
            <td><input class="form-control" type="text" name="canprod2[]" placeholder="Tipo" value="${document.getElementById(json_data2[item].codigo).value}"></td>
            <td><td>
            `;
            const removeBtn = document.createElement('button');
            removeBtn.classList.add('btn', 'btn-danger');
            removeBtn.innerHTML = '<i class="fa fa-trash"></i>';
            removeBtn.onclick = function(e){
            removeTodo(row.getAttribute('id'));
            }
            row.children[5].appendChild(removeBtn);    // Outputs the answer
        };
        function removeTodo(id){
            document.getElementById(id).remove();
        }
    }); 

    $(".page-wrapper").removeClass("toggled");
} );

</script>
@endsection
