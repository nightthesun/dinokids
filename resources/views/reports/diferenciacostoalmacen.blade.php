@extends('layouts.app')
@section('estilo')
<style>
  #tableex_processing {
    padding-top: 10%;
    z-index: -50;
  }

  th {
    text-align: center;
  }

  .bg-ingreso {
    background-color: rgba(174, 255, 208, 0.3) !important;
  }

  .bg-egreso {
    background-color: rgba(111, 178, 255, 0.3) !important;
  }
</style>
@endsection
@section('content')
@include('layouts.sidebar', ['hide'=>'0'])
<div class="container-fluid">
  <div class="row d-flex mt-1">
    <div class="col-10 offset-md-1 text-end">
      <div class="mb-2 row d-flex justify-content-start">
        <!--label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm text-right">Desde:</label>
                <div class="col-sm-2">
                <input id="fini" type="date" class="form-control form-control-sm " name="fini" value ="{{date('Y-m-d')}}">
                </div>
                <label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm text-right">Hasta:</label>
                <div class="col-sm-2">
                <input id="ffin" type="date" class="form-control form-control-sm " name="ffin" value ="{{date('Y-m-d')}}">
                </div-->
        <label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm text-right">Linea:</label>
        <div class="col-sm-3">
          <select name="marc" id="marc" class="form-select form-select-sm">
            <!--option value="0">Todos</option-->
            @foreach ($marcas as $marc)
            <option value="{{$marc->maconMarc}}" @if($marc->maconMarc == '113|25') selected @endif>{{$marc->maconNomb}}</option>
            @endforeach
          </select>
        </div>
        <label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm text-right">Entre:</label>
        <div class="col-sm-3">
          <input id="fini" type="date" class="form-control form-control-sm " name="fini" value="{{date('Y-m-d')}}">
        </div>
        <div class="col-sm-3">
          <input id="ffin" type="date" class="form-control form-control-sm " name="ffin" value="{{date('Y-m-d')}}">
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="text-center w-100 border-bottom mt-3">
        <h5 id="title_prod">Marca</h5>
      </div>
      <table class="cell-border compact hover" id="detalle_costo" style="width:100%; font-size:0.8rem;">
      </table>
    </div>
  </div>
  <!-- The Modal -->
  <div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h6 class="modal-title"></h6> -->
        <span class="close h5">&times;</span>
      </div>
      <div class="modal-body" style="font-size: 13px;">
        <table id="table_detalle" class="cell-border compact hover" style="width:100%">
          <thead>
            <tr>
              <td>Codigo</td>
              <td>Descripcion</td>
              <td>U.M.</td>
              <td>Fecha</td>
              <td>AC1</td>
              <td>AC2</td>
              <td>AlmProd</td>
              <td>Ballivian</td>
              <td>Handal</td>
              <td>Mariscal</td>
              <td>Calacoto</td>
              <td>SanMiguel</td>
              <td>Promedio</td>
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
  $(document).ready(function() {
    var createTable = function detalleTableProduct() {
      var marc = $('#marc').val();
      var fini = $('#fini').val();
      var ffin = $('#ffin').val();

      var table = $('#detalle_costo').DataTable({
        paging: false,
        searching: false,
        order: false,
        bFilter: false,
        ajax: {
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "{{route('diferenciacostoalmacen.store')}}",
          type: "post",
          dataType: 'json',
          data: {
            marc: marc,
            fini: fini,
            ffin: ffin,
          },
          /*success: function (data) {
              console.log(data);
          },
          error: function (data) {
              console.log(data);
          }*/
        },
        serverSide: true,
        processing: true,
        columns: [{
            data: 'intrdCpro',
            title: 'Codigo'
          },
          {
            data: 'inproNomb',
            title: 'Descripcion'
          },
          {
            data: 'inumeAbre',
            title: 'U.M.'
          },
          {
            data: 'AC1',
            title: 'AC1',
            className: 'dt-body-right'
          },
          {
            data: 'AC2',
            title: 'AC2',
            className: 'dt-body-right'
          },
          {
            data: 'AlmProd',
            title: 'AlmProd',
            className: 'dt-body-right'
          },
          {
            data: 'Ballivian',
            title: 'Ballivian',
            className: 'dt-body-right'
          },
          {
            data: 'Handal',
            title: 'Handal',
            className: 'dt-body-right'
          },
          {
            data: 'Mariscal',
            title: 'Mariscal',
            className: 'dt-body-right'
          },
          {
            data: 'Calacoto',
            title: 'Calacoto',
            className: 'dt-body-right'
          },
          {
            data: 'SanMiguel',
            title: 'SanMiguel',
            className: 'dt-body-right'
          },
          {
            data: 'Promedio',
            title: 'Promedio',
            className: 'dt-body-right bg-info'
          },
        ],
        scrollY: "65vh",
        scrollX: true,
        scrollCollapse: true,
        drawCallback: function(settings) {
          var maconMarc = this.api().ajax.json().producto.maconMarc;
          var maconNomb = this.api().ajax.json().producto.maconNomb;
          $('#title_prod').text("Linea: " + maconNomb);
        },
        "columnDefs": [{
          "targets": 0,
          "render": function(data, type, row, meta) {
            var link = '<a class="enlace_cuenta" id ="' + data + '" style="cursor:pointer;">' + data + '</a>'
            return link;
          }
        }],
        dom: 'Bfrtip',
        buttons: [
          'excel'
        ],
      });
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
        url: "{{route('diferenciacostoalmacendetalle.store')}}",
        type: 'POST',
        dataType: 'json',
        data: {
          id,
          fini: fini,
          ffin: ffin,
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
                data: 'intrdCpro',
              },
              {
                data: 'inproNomb',
              },
              {
                data: 'inumeAbre',
              },
              {
                data: 'fecha',
              },
              {
                data: 'AC1',
                className: 'dt-body-right'
              },
              {
                data: 'AC2',
                className: 'dt-body-right'
              },
              {
                data: 'AlmProd',
                className: 'dt-body-right'
              },
              {
                data: 'Ballivian',
                className: 'dt-body-right'
              },
              {
                data: 'Handal',
                className: 'dt-body-right'
              },
              {
                data: 'Mariscal',
                className: 'dt-body-right'
              },
              {
                data: 'Calacoto',
                className: 'dt-body-right'
              },
              {
                data: 'SanMiguel',
                className: 'dt-body-right'
              },
              {
                data: 'Promedio',
                className: 'dt-body-right bg-info'
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
      //var marcTT = ctable.table.row( $(this).parents('tr') ).data();
      //$('#tableex').DataTable().clear();
      //$('#tableex').DataTable().destroy();
      //ctable = createTable(ctable.estado, ctable.filtro, 'xProducto', marcTT.idmarca); 
    }
    createTable();

    $('#marc').on('change', function() {
      $('#tableex').DataTable().clear();
      $('#tableex').DataTable().destroy();
      $('#detalle_costo').DataTable().clear();
      $('#detalle_costo').DataTable().destroy();
      createTable();
    });
    $('#fini').on('change', function() {
      $('#tableex').DataTable().clear();
      $('#tableex').DataTable().destroy();
      $('#detalle_costo').DataTable().clear();
      $('#detalle_costo').DataTable().destroy();
      createTable();
    });
    $('#ffin').on('change', function() {
      $('#tableex').DataTable().clear();
      $('#tableex').DataTable().destroy();
      $('#detalle_costo').DataTable().clear();
      $('#detalle_costo').DataTable().destroy();
      createTable();
    });
    setTimeout(function() {
      $(".page-wrapper").removeClass("toggled");
    }, 500);
    
  });
</script>
@endsection