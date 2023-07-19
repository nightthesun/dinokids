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
        <label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm text-right">Almacen:</label>
        <div class="col-sm-3">
          <select name="alm" id="alm" class="form-select form-select-sm">
            <!--option value="0">Todos</option-->
            @foreach ($almacenes as $alm)
            <option value="{{$alm->id}}" @if($alm->id == '47') selected @endif>{{$alm->alm}}</option>
            @endforeach
          </select>
        </div>
        <label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm text-right">Entre:</label>
        <div class="col-sm-3">
          <input id="ffin1" type="date" class="form-control form-control-sm " name="ffin1" value="{{date('Y-m-d')}}">
        </div>
        <div class="col-sm-3">
          <input id="ffin2" type="date" class="form-control form-control-sm " name="ffin2" value="{{date('Y-m-d')}}">
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-2 d-none">
      <table class="cell-border compact hover" id="tableex" style="width:100%;font-size:0.9rem">
      </table>
    </div>
    <div class="col-12">
      <table class="cell-border compact" id="detalle_costo" style="width:100%; font-size:0.8rem;">
        <thead>
          <tr>
            <th rowspan="2"></th>
            <th rowspan="2"></th>
            <th rowspan="1"></th>
            <th rowspan="1"></th>
            <th colspan="3" class="bg-success">Entradas</th>
            <th colspan="3" class="bg-warning">Salidas</th>
          </tr>
          <tr>
            <th>CodPro</th>
            <th>Descr</th>
            <th>NroTrans</th>
            <th>Fecha</th>
            <th>Cant</th>
            <th>P.U.</th>
            <th>P.T.</th>
            <th>Cant</th>
            <th>P.U.</th>
            <th>P.T.</th>
            <th>Cost Prom</th>
            <th>Costo Val</th>
            <th>Costo Acum</th>
            <th>Dif</th>
            <th>Glosa</th>
            <th>Almacen</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <button id="actualizar">actualizar Totales</button>
</div>
@endsection
@section('mis_scripts')
<script>
  var titulos = {!!json_encode($titulos) !!};
  $(document).ready(function() {
    var createTable = function createDataTable() {
      var alm = $('#alm').val();
      var table = $('#tableex').DataTable({
        paging: false,
        searching: true,
        dom: "ltpir",
        ajax: {
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "{{route('kardexalmacen.products')}}",
          type: "post",
          dataType: 'json',
          data: {
            alm: alm,
          }
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
            data: 'Prod',
            title: 'Producto'
          },
          // {data:'costo', title:'Costo', className: 'dt-body-right'},
          // {data:'difmax', title:'Dif', className: 'dt-body-right'},
          {
            data: 'ingresos',
            title: 'Ing',
            className: 'dt-body-right text-success d-none'
          },
          {
            data: 'salidas',
            title: 'Sal',
            className: 'dt-body-right text-danger d-none'
          },
        ],
        columnDefs: [{
          "targets": 0,
          // "render": function(data, type, row, meta) {
          //   var link = '<a class="producto" id="' + data + '" style="cursor:pointer;">' + data + '</a>'
          //   return link;
          // }
        }, ],
        order: [
          [2, "desc"]
        ],
        scrollY: "80vh",
        scrollX: true,
        scrollCollapse: true,
        drawCallback: function(settings) {
          //$('#title_prod').text(prim.Prod);
          if (!$.fn.DataTable.isDataTable('#detalle_costo')) {
            let tabla = this.api();
            var prim = this.api().row(0).data();
            detalleProduct(prim.Prod);
          }
        },
      });
    }
    var detalleProduct = function detalleTableProduct(prod) {
      var alm = $('#alm').val();
      var ffin1 = $('#ffin1').val();
      var ffin2 = $('#ffin2').val();
      if ($.fn.DataTable.isDataTable('#detalle_costo')) {
        $('#detalle_costo').DataTable().clear();
        $('#detalle_costo').DataTable().destroy();
        //$("#detalle_costo thead").remove();
        //$('#detalle_costo tfoot').remove();
      }

      var table2 = $('#detalle_costo').DataTable({
        paging: false,
        searching: false,
        order: false,
        bFilter: false,
        ajax: {
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "{{route('kardexalmacen.store')}}",
          type: "post",
          dataType: 'json',
          data: {
            prod: prod,
            alm: alm,
            ffin1: ffin1,
            ffin2: ffin2,
          },
          /*success: function (data) {
              console.log(data);
          },
          error: function (data) {
              console.log(data);
          }*/
        },
        dom: 'Bfrtip',
        buttons: [
          'excel'
        ],
        serverSide: true,
        processing: true,
        columns: titulos,
        scrollY: "65vh",
        scrollX: true,
        scrollCollapse: true,
        // createdRow: function(row, data, dataIndex) {
        //   if (data.Ttra == 1) {
        //     $(row).addClass('bg-ingreso');
        //   } else {
        //     $(row).addClass('bg-egreso');
        //   }

        //   //console.log(row.getElementsByTagName('td')[7]);
        // },
      });
      //var marcTT = ctable.table.row( $(this).parents('tr') ).data();
      //$('#tableex').DataTable().clear();
      //$('#tableex').DataTable().destroy();
      //ctable = createTable(ctable.estado, ctable.filtro, 'xProducto', marcTT.idmarca); 
    }
    createTable();

    $('#alm').on('change', function() {
      $('#tableex').DataTable().clear();
      $('#tableex').DataTable().destroy();
      $('#detalle_costo').DataTable().clear();
      $('#detalle_costo').DataTable().destroy();
      createTable();
    });
    $('#ffin1').on('change', function() {
      $('#tableex').DataTable().clear();
      $('#tableex').DataTable().destroy();
      $('#detalle_costo').DataTable().clear();
      $('#detalle_costo').DataTable().destroy();
      createTable();
    });
    $('#ffin2').on('change', function() {
      $('#tableex').DataTable().clear();
      $('#tableex').DataTable().destroy();
      $('#detalle_costo').DataTable().clear();
      $('#detalle_costo').DataTable().destroy();
      createTable();
    });
    $(".page-wrapper").removeClass("toggled");
  });
</script>
@endsection