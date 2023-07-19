@extends('layouts.app')
<style>
  table.dataTable {
    font-size: 0.9em;
  }
  .categoria_max {
    max-width: 300px !important;
    text-overflow: ellipsis;
  }
  .dataTables_scrollBody {
    max-height: 450px !important;
  }
</style>
@section('content')
@include('layouts.sidebar', ['hide'=>'0'])
<div class="container-fluid">
  <div class="row justify-content-center mt-4">
    <div class="col-md-12">
      <table id="example" class="cell-border compact hover" style="width:100%">
      </table>
    </div>
  </div>
  <!-- The Modal -->
  <div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content" style="width: 80%; margin: auto;">
      <div class="modal-header">
        <!-- <h6 class="modal-title"></h6> -->
        <span class="close h5">&times;</span>
      </div>
      <div class="modal-body">
        <table id="table_detalle" class="cell-border compact hover" style="width:100%">
          <thead>
            <tr>
              <td>Codigo</td>
              <td>CodProducto</td>
              <td>Descripcion</td>
              <td>PrecioUni</td>
              <td>Cantidad</td>
              <td>PrecioTotal</td>
              <td>%Descuento</td>
              <td>Descuento</td>
              <td>ImpTotal</td>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<button id="actualizar">actualizar Totales</button>
@endsection
@section('mis_scripts')
<script>
  var json_data = {!!json_encode($venta)!!};
  $(document).ready(function() {
    var height = screen.height - 500 + 'px';
    var table = $('#example').DataTable({
      data: json_data,
      columns: [{
          data: 'vtvtaNtra',
          title: 'Codigo'
        },
        {
          data: 'fecha',
          title: 'Fecha'
        },
        {
          data: 'vtvtaNomC',
          title: 'NomCliente'
        },
        {
          data: 'imLvtRsoc',
          title: 'RazonSocial'
        },
        {
          data: 'imLvtNNit',
          title: 'Nit'
        },
        {
          data: 'factura',
          title: 'Factura'
        },
        {
          data: 'ImpT',
          title: 'ImpTotal'
        },
        {
          data: 'DesPor',
          title: '%Descuento'
        },
        {
          data: 'DesT',
          title: 'DesTotal'
        },
        {
          data: 'total',
          title: 'Total'
        },
        {
          data: 'adusrNomb',
          title: 'Usuario'
        },
        {
          data: 'inalmNomb',
          title: 'Almacen'
        },
      ],
      "pageLength": 100,
      "columnDefs": [{
          "targets": 0,
          "render": function(data, type, row, meta) {
            var link = '<a class="enlace_cuenta" id ="' + data + '" style="cursor:pointer;">' + data + '</a>'
            return link;
          }
        },
        {
          className: "dt-right",
          "targets": [1, 2, 3, 4]
        },
      ],
      "language": {
        "emptyTable": "Tabla Vacia",
        "info": "Se muestran del _START_ al _END_ de _TOTAL_ registros",
        "infoEmpty": "Se muestran del 0 al 0 de 0 Registros",
        "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
        "lengthMenu": "Se muestran _MENU_ registros",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "No se encontro ningun registro",
        "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
        }
      },
      "scrollX": false,
      "scrollY": height,
      "scrollCollapse": true,
    });
    setTimeout(function() {
      $(".page-wrapper").removeClass("toggled");
    }, 500);
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
      $('#myModal').fadeOut();
    }
    table.on('click', 'a.enlace_cuenta', function() {
      console.log("TEST");
      var id = $(this).attr('id');
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{route('reporteventasdetalle.store')}}",
        type: 'POST',
        dataType: 'json',
        data: {
          id
        },
        paging: false,
        success: function(data) {
          // Get the modal}
          $('#table_detalle').DataTable().clear();
          $('#table_detalle').DataTable().destroy();
          $('#table_detalle').DataTable({
            data: data.detalle,
            columns: [
              {
                data: 'vtvtdNtra',
                title: 'Codigo'
              },
              {
                data: 'inproCpro',
                title: 'CodProducto'
              },
              {
                data: 'inproNomb',
                title: 'Descripcion'
              },
              {
                data: 'ImpU',
                title: 'PrecioUni'
              },
              {
                data: 'vtvtdCant',
                title: 'Cantidad'
              },
              {
                data: 'ImpT',
                title: 'PrecioTotal'
              },
              {
                data: 'DesPor',
                title: '%Descuento'
              },
              {
                data: 'DesT',
                title: 'Descuento'
              },
              {
                data: 'total',
                title: 'ImpTotal'
              },
            ],
          });
          $('#myModal').fadeIn();
        },
        error: function(data) {
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
  });
</script>
@endsection