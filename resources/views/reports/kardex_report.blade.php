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
        <div class="col-sm-2">
          <input type="text" id="buscar" class="form-control form-control-sm" placeholder="Buscar...">
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-2" style="width: 9%;">
      <table class="cell-border compact hover" id="tableex" style="width:100%;font-size:0.9rem">
      </table>
    </div>
    <div class="col-10" style="width: 91%;">
      <div class="text-center w-100 border-bottom mt-3">
        <h5 id="title_prod">Producto</h5>
      </div>
      <table class="cell-border compact" id="detalle_costo" style="width:100%; font-size:0.8rem;">
        <thead>
          @if(Auth::user()->tienePermiso(23, 11))
          <tr>
            <th rowspan="2"></th>
            <th rowspan="2"></th>
            <th colspan="3" class="bg-success">Entradas</th>
            <th colspan="3" class="bg-warning">Salidas</th>
            <th colspan="3" class="bg-info">Saldos</th>
          </tr>
          @else
          <tr>
            <th rowspan="2"></th>
            <th rowspan="2"></th>
            <th colspan="1" class="bg-success">Entradas</th>
            <th colspan="1" class="bg-warning">Salidas</th>
            <th colspan="1" class="bg-info">Saldos</th>
          </tr>
          @endif
          @if(Auth::user()->tienePermiso(23, 11))
          <tr>
            <th>NroTrans</th>
            <th>Fecha</th>
            <th>Cant</th>
            <th>P.U.</th>
            <th>P.T.</th>
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
          </tr>
          @else
          <tr>
            <th>NroTrans</th>
            <th>Fecha</th>
            <th>Cant</th>
            <th>Cant</th>
            <th>Cant</th>
          </tr>
          @endif
        </thead>
        <tfoot>
          @if(Auth::user()->tienePermiso(23, 11))
          <tr>
            <th></th>
            <th>TOTAL</th>
            <td class="sumCANA bg-success text-end"></td>
            <td></td>
            <td class="sumTOTA bg-success text-end"></td>
            <td class="sumCANB bg-warning text-end"></td>
            <td></td>
            <td class="sumTOTB bg-warning text-end"></td>
            <td class="sumCANC bg-info text-end"></td>
            <td></td>
            <td class="sumTOTC bg-info text-end"></td>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
          @else
          <tr>
            <th></th>
            <th>TOTAL</th>
            <td class="sumCANA bg-success text-end"></td>
            <td class="sumCANB bg-warning text-end"></td>
            <td class="sumCANC bg-info text-end"></td>
            <th></th>
            <th></th>
          </tr>
          @endif
        </tfoot>
      </table>
    </div>
  </div>
  <button id="actualizar">actualizar Totales</button>
</div>
@endsection
@section('mis_scripts')
<script>
  var titulos = {!!json_encode($titulos) !!};
  var permiso = {!!json_encode($permiso) !!};
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
          url: "{{route('kardexreport.products')}}",
          type: "post",
          dataType: 'json',
          data: {
            alm: alm
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
          "render": function(data, type, row, meta) {
            var link = '<a class="producto" id="' + data + '" style="cursor:pointer;">' + data + '</a>'
            return link;
          }
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
          url: "{{route('kardexreport.store')}}",
          type: "post",
          dataType: 'json',
          data: {
            prod: prod,
            alm: alm
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
        createdRow: function(row, data, dataIndex) {
          if (data.Ttra == 1) {
            $(row).addClass('bg-ingreso');
          } else {
            $(row).addClass('bg-egreso');
          }

          //console.log(row.getElementsByTagName('td')[7]);
          if (data._Diferencia == 0) {
            let td = $(this).DataTable().cell(dataIndex, 15).node();
            $(td).addClass('text-success');
          } else {
            let td = $(this).DataTable().cell(dataIndex, 15).node();
            $(td).addClass('text-danger');
          }
        },
        drawCallback: function(settings) {
          var prod = this.api().ajax.json().producto.Produ;
          var desc = this.api().ajax.json().producto.ProdNomb;
          var sumCANC = this.api().ajax.json().array._SalCan;
          var sumTOTT = this.api().ajax.json().array._SalTot;

          $('#title_prod').text(prod + ' - ' + desc);

          function totales() {
            //var sum = table.column(4).data();
            //var tab = table.rows( { selected: true, search: 'applied' } ).data();
            //console.log(tab); 
            if (permiso == true) {
              var sumCANA = table2.column(2, {
                search: 'applied'
              }).data().sum();
              var sumTOTA = table2.column(4, {
                search: 'applied'
              }).data().sum();
              var sumCANB = table2.column(5, {
                search: 'applied'
              }).data().sum();
              var sumTOTB = table2.column(7, {
                search: 'applied'
              }).data().sum();
              sumCANA = Math.round((sumCANA + Number.EPSILON) * 100) / 100;
              sumTOTA = Math.round((sumTOTA + Number.EPSILON) * 100) / 100;
              sumCANB = Math.round((sumCANB + Number.EPSILON) * 100) / 100;
              sumTOTB = Math.round((sumTOTB + Number.EPSILON) * 100) / 100;
              $('.dataTables_scrollFootInner .sumCANA').html(sumCANA.toFixed(0));
              $('.dataTables_scrollFootInner .sumTOTA').html(sumTOTA.toFixed(2));
              $('.dataTables_scrollFootInner .sumCANB').html(sumCANB.toFixed(0));
              $('.dataTables_scrollFootInner .sumTOTB').html(sumTOTB.toFixed(2));
              $('.dataTables_scrollFootInner .sumCANC').text(sumCANC.toFixed(0));
              $('.dataTables_scrollFootInner .sumTOTC').text(sumTOTT.toFixed(2));
            } else {
              var sumCANA = table2.column(2, {
                search: 'applied'
              }).data().sum();
              var sumCANB = table2.column(3, {
                search: 'applied'
              }).data().sum();
              sumCANA = Math.round((sumCANA + Number.EPSILON) * 100) / 100;
              sumCANB = Math.round((sumCANB + Number.EPSILON) * 100) / 100;
              $('.dataTables_scrollFootInner .sumCANA').html(sumCANA.toFixed(0));
              $('.dataTables_scrollFootInner .sumCANB').html(sumCANB.toFixed(0));
              $('.dataTables_scrollFootInner .sumCANC').text(sumCANC.toFixed(0));
            }
          }
          totales();
          $('#example_filter label input').on('keyup change', function() {
            totales();
          });
          $('#example_filter label input').on('change', function() {
            totales();
          });
        },
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
    $('#tableex tbody').on('click', '.producto', function() {
      var prod = $(this).attr('id');
      $('#title_prod').text(prod);
      detalleProduct(prod);
    });
    $('#buscar').on('keyup', function() {
      $('#tableex').DataTable().search(this.value).draw();
    });
    $(".page-wrapper").removeClass("toggled");
  });
</script>
@endsection