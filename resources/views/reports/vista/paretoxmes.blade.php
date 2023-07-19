@extends('layouts.app')
@section('estilo')

<style>
  .categoria_max {
    max-width: 120px !important;
    text-overflow: ellipsis;
  }
  .color_mes_1 {
    background-color: #fabfb7;
  }
  .color_mes_2 {
    background-color: #fdf9c4;
  }
  .color_mes_3 {
    background-color: #ffda9e;
  }
  .color_mes_4 {
    background-color: #c5c6c8;
  }
  .color_mes_5 {
    background-color: #b2e2f2;
  }
  .color_mes_6 {
    background-color: #ffe4e1;
  }
  .color_mes_7 {
    background-color: #d8f8e1;
  }
  .color_mes_8 {
    background-color: #fcb7af;
  }
  .color_mes_9 {
    background-color: #b0f2c2;
  }
  .color_mes_10 {
    background-color: #b0c2f2;
  }
  .color_mes_11 {
    background-color: #a2edce;
  }
  .color_mes_12 {
    background-color: #dcd9f8;
  }
  .color_mes_pareto {
    background-color: #b2dafa;
  }
</style>
@endsection
@section('content')
@include('layouts.sidebar', ['hide'=>'0'])
<div class="container-fluid">
  <div class="row justify-content-center mt-4">
    <div class="col">
      <table id="example" class="cell-border compact hover" style="width:100%">
      <thead>
        <tr>
          <th colspan="4"></th>
          @foreach ($mes_num as $key => $value)
          @if ($value == 1)
          <th colspan="12" class="text-center color_mes_1">ENERO</th>
          @if (Auth::user()->tienePermiso(42, 10))
          <th colspan="18"></th>
          @endif
          @endif
          @if ($value == 2)
          <th colspan="12" class="text-center color_mes_2">FEBRERO</th>
          @if (Auth::user()->tienePermiso(42, 10))
          <th colspan="18"></th>
          @endif
          @endif
          @if ($value == 3)
          <th colspan="12" class="text-center color_mes_3">MARZO</th>
          @if (Auth::user()->tienePermiso(42, 10))
          <th colspan="18"></th>
          @endif
          @endif
          @if ($value == 4)
          <th colspan="12" class="text-center color_mes_4">ABRIL</th>
          @if (Auth::user()->tienePermiso(42, 10))
          <th colspan="18"></th>
          @endif
          @endif
          @if ($value == 5)
          <th colspan="12" class="text-center color_mes_5">MAYO</th>
          @if (Auth::user()->tienePermiso(42, 10))
          <th colspan="18"></th>
          @endif
          @endif
          @if ($value == 6)
          <th colspan="12" class="text-center color_mes_6">JUNIO</th>
          @if (Auth::user()->tienePermiso(42, 10))
          <th colspan="18"></th>
          @endif
          @endif
          @if ($value == 7)
          <th colspan="12" class="text-center color_mes_7">JULIO</th>
          @if (Auth::user()->tienePermiso(42, 10))
          <th colspan="18"></th>
          @endif
          @endif
          @if ($value == 8)
          <th colspan="12" class="text-center color_mes_8">AGOSTO</th>
          @if (Auth::user()->tienePermiso(42, 10))
          <th colspan="18"></th>
          @endif
          @endif
          @if ($value == 9)
          <th colspan="12" class="text-center color_mes_9">SEPTIEMBRE</th>
          @if (Auth::user()->tienePermiso(42, 10))
          <th colspan="18"></th>
          @endif
          @endif
          @if ($value == 10)
          <th colspan="12" class="text-center color_mes_10">OCTUBRE</th>
          @if (Auth::user()->tienePermiso(42, 10))
          <th colspan="18"></th>
          @endif
          @endif
          @if ($value == 11)
          <th colspan="12" class="text-center color_mes_11">NOVIEMBRE</th>
          @if (Auth::user()->tienePermiso(42, 10))
          <th colspan="18"></th>
          @endif
          @endif
          @if ($value == 12)
          <th colspan="12" class="text-center color_mes_12">DICIEMBRE</th>
          @if (Auth::user()->tienePermiso(42, 10))
          <th colspan="18"></th>
          @endif
          @endif
          @endforeach
        </tr>
        <tr>
          <th colspan="4"></th>
          @foreach ($mes_num as $key => $value)
          <th colspan="4" class="text-center color_mes_{{$value}}" style="border-left: 1px solid black;">RETAIL</th>
          <th colspan="4" class="text-center color_mes_{{$value}}" style="border-left: 1px solid black;">INSTITUCIONAL</th>
          <th colspan="4" class="text-center color_mes_{{$value}}" style="border-left: 1px solid black;">MAYORISTA</th>
          @if (Auth::user()->tienePermiso(42, 10))
          <th colspan="18" class="text-center color_mes_pareto" style="border-left: 1px solid black;">PARETO</th>
          @endif
          @endforeach
        </tr>
        <tr>
          <th colspan="4"></th>
          @foreach ($mes_num as $key => $value)
          <th colspan="2" class="text-center color_mes_{{$value}}" style="border-left: 1px solid black;">2021</th>
          <th colspan="2" class="text-center color_mes_{{$value}}" style="border-left: 1px solid black;">2022</th>
          <th colspan="2" class="text-center color_mes_{{$value}}" style="border-left: 1px solid black;">2021</th>
          <th colspan="2" class="text-center color_mes_{{$value}}" style="border-left: 1px solid black;">2022</th>
          <th colspan="2" class="text-center color_mes_{{$value}}" style="border-left: 1px solid black;">2021</th>
          <th colspan="2" class="text-center color_mes_{{$value}}" style="border-left: 1px solid black;">2022</th>
          @if (Auth::user()->tienePermiso(42, 10))
          <th colspan="9" class="text-center color_mes_pareto" style="border-left: 1px solid black;">2021</th>
          <th colspan="9" class="text-center color_mes_pareto" style="border-left: 1px solid black;">2022</th>
          @endif
          @endforeach
        </tr>
        <tr>
          @foreach ($titulos as $ti)
          <th>{{$ti['title']}}</th>
          @endforeach
        </tr>
      </thead>
        <tfoot>
          @foreach ($titulos as $ti)
          <th @if(isset($ti['tip']))class="{{$ti['tip']}}" @endif>@if(isset($ti['tip']) && $ti['tip'] == 'filtro'){{$ti['title']}}@endif</th>
          @endforeach
        </tfoot>
      </table>
    </div>
  </div>
</div>
@endsection

@section('mis_scripts')
<script>
  var json_data = {!!json_encode($test) !!};
  var titulos = {!!json_encode($titulos) !!};
  var order_asc;
  console.log(titulos.length);
  if (titulos.length > 17) {
    order_asc = [23, 'asc'];
  }
  $(document).ready(function() {
    $('#example tfoot th').each(function() {
      if ($(this).hasClass('filtro')) {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%;"/>');
      }
    });
    $('#example').DataTable({
      data: json_data,
      columns: titulos,
      // "pageLength": 25,
      paging: false,
      "columnDefs": [{
          // className: "dt-right",
          // "targets": [4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]
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
      "scrollX": true,
      "scrollY": "60vh",
      "scrollCollapse": true,
      order: order_asc,
      initComplete: function() {
        // Apply the search
        this.api().columns().every(function() {
          if ($(this.footer()).hasClass("filtro_select")) {
            var column = this;
            var select =
              $('<select class="form-select form-select-sm" style="background-image:none;padding-right:8px;width:auto"><option value="" class="text-secondary">TODOS</option></select>')
              .appendTo($(column.footer()).empty())
              .on('change', function() {
                var val = $.fn.dataTable.util.escapeRegex(
                  $(this).val()
                );

                column
                  .search(val ? '^' + val + '$' : '', true, false)
                  .draw();
              });

            column.data().unique().sort().each(function(d, j) {
              select.append('<option value="' + d + '">' + d + '</option>')
            });
          } else if ($(this.footer()).hasClass("filtro")) {
            var that = this;
            $('input', this.footer()).on('keyup change clear', function() {
              if (that.search() !== this.value) {
                that
                  .search(this.value)
                  .draw();
              }
            });
          }
        });
      }
    });
    $(".page-wrapper").removeClass("toggled");
  });
</script>
@endsection