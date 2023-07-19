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

  .color_vista1 {
    background-color: #6096B4;
  }

  .color_vista2 {
    background-color: #93BFCF;
  }

  .color_vista3 {
    background-color: #BDCDD6;
  }

  .color_vista4 {
    background-color: #EEE9DA;
  }

  .dataTables_wrapper {
    padding-left: 7px;
  }

  #example_wrapper {
    padding-left: 0px;
  }

  .font-weight-bold {
    font-weight: bold;
  }
</style>
@section('content')
@include('layouts.sidebar', ['hide'=>'0'])


<div class="container-fluid">
  <div class=" row d-flex justify-content-center my-3">
    <div class="d-flex align-items-center justify-content-center">
      <h3 class="text-primary">REPORTE DE CUENTAS POR COBRAR TOTAL</h3>
    </div>
  </div>
  <div class="row justify-content-center mt-4">
    <div class="col-md-12">
      <table id="example" class="display" style="width:100%">
        <thead>
          <tr>
            <th></th>
            <th>Usuario</th>
            <th>Local</th>
            <th>ImporteCxC</th>
            <th>Contado</th>
            <th>Credito</th>
            <th>Saldo</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
@endsection

@section('mis_scripts')
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.2/js/buttons.html5.styles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.2/js/buttons.html5.styles.templates.min.js"></script>
<script>
  var array = {!!json_encode($array) !!};
  /* Formatting function for row details - modify as you need */
  function format(d) {
    function format2(s) {
      function format3(a) {
        let tabla3 = `<table cellpadding="5" cellspacing="0" style="border-collapse: separate; font-size: 14px; margin: 0px; width: 100%; padding-left: 35px;">
        <thead>
        <tr style="background-color: #EEE9DA;">
          <th>Categoria</strong></th>
          <th>Codigo</th>
          <th>Descripcion</th>
          <th>U.M.</th>
          <th>Cantidad</th>
          <th>Cost_U</th>
          <th>Cost_T</th>
          <th>Prec_U</th>
          <th>Imp</th>
          <th>Desc_T</th>
          <th>Desc_%</th>
          <th>Imp_T</th>
        </tr>
        </thead>
        <tbody>`;
        a.vista3.forEach(element => {
          tabla3 += `<tr>
          <td class="color_vista4">${element.maconNomb}</td>
          <td class="color_vista4">${element.codigo}</td>
          <td class="color_vista4">${element.descripcion}</td>
          <td class="color_vista4">${element.inumeAbre}</td>
          <td class="dt-right color_vista4">${element.vtvtdCant}</td>
          <td class="dt-right color_vista4">${element.cost_u}</td>
          <td class="dt-right color_vista4">${element.cost_t}</td>
          <td class="dt-right color_vista4">${element.prec_u}</td>
          <td class="dt-right color_vista4">${element.prec_t}</td>
          <td class="dt-right color_vista4">${element.desc_t}</td>
          <td class="dt-right color_vista4">${element.desc_p} %</td>
          <td class="dt-right color_vista4 font-weight-bold">${element.total}</td>
        </tr>`;
        });
        tabla3 += `</tbody></table>`;
        return tabla3;
      }
      // Inicializar HTML
      id_table2 = 'example' + s.id_usuario_2 + s.id_cliente_2;
      let tabla2 = `<table id="${id_table2}" cellpadding="5" cellspacing="0" style="border-collapse: separate; font-size: 14px; margin: 0px; width: 100%;">
      <thead>
      <tr style="background-color: #BDCDD6;">
        <th></th>
        <th>FechaNR</strong></th>
        <th>NotaRemision</th>
        <th>FechaFactura</th>
        <th>NFactura</th>
        <th>FechaVenc</th>
        <th>Glosa</th>
        <th>RazonSocial</th>
        <th>Nit</th>
        <th>ImporteCxC</th>
        <th>FechaACuenta</th>
        <th>Contado</th>
        <th>Credito</th>
        <th>DifDias_1</th>
        <th>DifDias_2</th>
        <th>Estado</th>
      </tr>
      </thead>
      </table>`;
      $(document).ready(function() {
        var table3 = $('#' + id_table2).DataTable({
          data: s.vista2,
          columns: [{
              className: 'dt-control3 color_vista3 text-center',
              orderable: false,
              data: null,
              defaultContent: '<i class="fas fa-plus"></i>',
            },
            {
              data: 'fechaNR',
              className: 'color_vista3'
            },
            {
              data: 'vtvtaNtra',
              className: 'color_vista3 dt-right'
            },
            {
              data: 'fechaFC',
              className: 'color_vista3 dt-right'
            },
            {
              data: 'imLvtNrfc',
              className: 'color_vista3 dt-right'
            },
            {
              data: 'fechaVenc',
              className: 'color_vista3 dt-right'
            },
            {
              data: 'Glosa',
              className: 'color_vista3 dt-right'
            },
            {
              data: 'Rsocial',
              className: 'color_vista3 dt-right'
            },
            {
              data: 'Nit',
              className: 'color_vista3 dt-right'
            },
            {
              data: 'importeCxC',
              className: 'color_vista3 font-weight-bold dt-right'
            },
            {
              data: 'fechaAC',
              className: 'color_vista3 dt-right'
            },
            {
              data: 'cont',
              className: 'color_vista3 font-weight-bold dt-right'
            },
            {
              data: 'cred',
              className: 'color_vista3 dt-right font-weight-bold'
            },
            {
              data: 'dif_dias_1',
              className: 'color_vista3 dt-right font-weight-bold'
            },
            {
              data: 'dif_dias_2',
              className: 'color_vista3 dt-right font-weight-bold'
            },
            {
              data: 'estado2',
              className: 'color_vista3 dt-right font-weight-bold'
            },
          ],
          // order: [
          //   [1, 'asc']
          // ],
          // dom: 'Bfrtip',
          // buttons: {
          //   dom: {
          //     button: {
          //       className: 'btn'
          //     }
          //   },
          //   buttons: [{
          //     extend: "excel",
          //     text: 'Exportar a Excel',
          //     className: 'btn btn-outline-success mb-4',
          //   }]
          // },
          "bLengthChange" : true,
          "pageLength": 25,
          dom: 'Blfrtip',
        buttons: [
            'excel'
        ],
          language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
              "first": "Primero",
              "last": "Ultimo",
              "next": "Siguiente",
              "previous": "Anterior"
            }
          },
        });
        // Add event listener for opening and closing details
        $('#' + id_table2 + ' tbody').on('click', 'td.dt-control3', function() {
          var tr = $(this).closest('tr');
          var row = table3.row(tr);

          if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
          } else {
            // Open this row
            row.child(format3(row.data())).show();
            tr.addClass('shown');
          }
        });
      });
      return tabla2;
    }

    // Inicializar HTML

    var id_table = 'example' + d.id_usuario_1 + d.id_local_1;
    let tabla = `<table id="${id_table}" cellpadding="5" cellspacing="0" style="border-collapse: separate; font-size: 14px; margin: 0px; width: 100%">
      <thead>
      <tr>
        <th></th>
        <th>Nombre de Cliente</strong></th>
        <th>DiasPlazo</th>
        <th>ImporteCxC</th>
        <th>Contado</th>
        <th>Credito</th>
        <th>Saldo</th>
        <th>Vigente</th>
        <th>Vencido</th>
        <th>Mora</th>
      </tr>
      </thead>
    </table>`;
    // Recorrer facturas para agregar cada fila

    $(document).ready(function() {
      var table2 = $('#' + id_table).DataTable({
        data: d.vista1,
        columns: [{
            className: 'dt-control2 color_vista2 text-center',
            orderable: false,
            data: null,
            defaultContent: '<i class="fas fa-plus"></i>',
          },
          {
            data: 'nomb_cliente_2',
            className: 'color_vista2'
          },
          {
            data: 'DiasPlazo',
            className: 'color_vista2'
          },
          {
            data: 'importeCXC_2',
            className: 'color_vista2 dt-right'
          },
          {
            data: 'cont_2',
            className: 'color_vista2 dt-right'
          },
          {
            data: 'cred_2',
            className: 'color_vista2 dt-right'
          },
          {
            data: 'saldo_2',
            className: 'color_vista2 dt-right font-weight-bold'
          },
          {
            data: 'vigente',
            className: 'color_vista2 dt-right font-weight-bold'
          },
          {
            data: 'vencido',
            className: 'color_vista2 dt-right font-weight-bold'
          },
          {
            data: 'mora',
            className: 'color_vista2 dt-right font-weight-bold'
          },
        ],
        // order: [
        //   [1, 'asc']
        // ],
        "pageLength": 25,
        language: {
          "decimal": "",
          "emptyTable": "No hay información",
          "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
          "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
          "infoFiltered": "(Filtrado de _MAX_ total entradas)",
          "infoPostFix": "",
          "thousands": ",",
          "lengthMenu": "Mostrar _MENU_ Entradas",
          "loadingRecords": "Cargando...",
          "processing": "Procesando...",
          "search": "Buscar:",
          "zeroRecords": "Sin resultados encontrados",
          "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
          }
        },
        dom: 'Blfrtip',
        buttons: [
            'excel'
        ],
      });
      // Add event listener for opening and closing details
      $('#' + id_table + ' tbody').on('click', 'td.dt-control2', function() {
        var tr = $(this).closest('tr');
        var row = table2.row(tr);

        if (row.child.isShown()) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
        } else {
          // Open this row
          row.child(format2(row.data())).show();
          tr.addClass('shown');
        }
      });
    });
    return tabla;
  }

  $(document).ready(function() {
    var table = $('#example').DataTable({
      data: array,
      columns: [{
          className: 'dt-control color_vista1 text-center',
          orderable: false,
          data: null,
          defaultContent: '<i class="fas fa-plus"></i>',
        },
        {
          data: 'nomb_user_1',
          className: 'color_vista1'
        },
        {
          data: 'local_1',
          className: 'color_vista1'
        },
        {
          data: 'importeCXC_1',
          className: 'color_vista1 dt-right'
        },
        {
          data: 'cont_1',
          className: 'color_vista1 dt-right'
        },
        {
          data: 'cred_1',
          className: 'color_vista1 dt-right'
        },
        {
          data: 'saldo_1',
          className: 'color_vista1 dt-right font-weight-bold'
        },
      ],
      // order: [
      //   [1, 'asc']
      // ],
      "pageLength": 100,
      language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
        }
      },
    });
    // Add event listener for opening and closing details
    $('#example tbody').on('click', 'td.dt-control', function() {
      var tr = $(this).closest('tr');
      var row = table.row(tr);

      if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
      } else {
        // Open this row
        row.child(format(row.data())).show();
        tr.addClass('shown');
      }
    });
    $(".page-wrapper").removeClass("toggled");
  });
</script>
@endsection