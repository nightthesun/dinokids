@extends('layouts.app')
@section('estilo')

<style>
  .tra_max {
    max-width: 70px !important;
  }
  .cod_max {
    max-width: 68px !important;
  }
  .des_max {
    max-width: 70px !important;
  }
  .almacen_max {
    max-width: 70px !important;
  }
  .cant_max {
    max-width: 68px !important;
  }
  .usu_max {
    max-width: 86px !important;
  }
  .glosa_max {
    max-width: 98px !important;
  }
</style>
@endsection
@section('content')
@include('layouts.sidebar', ['hide'=>'0'])
<div class="container-fluid">
  <div class="row justify-content-center mt-4">
    <div class="col">
      <table id="example" class="cell-border compact hover" style="width:100%; font-size: 12px;">
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
  var json_data = {!!json_encode($query) !!};
  var titulos = {!!json_encode($titulos) !!};
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
      "pageLength": 25,
      "columnDefs": [
        {
          className: "tra_max",
          "targets": 1
        },
        {
          className: "cod_max",
          "targets": 3
        },
        {
          className: "des_max",
          "targets": 4
        },
        {
          className: "almacen_max",
          "targets": 6
        },
        {
          className: "dt-right cant_max",
          "targets": 7
        },
        {
          className: "dt-right",
          "targets": 8
        },
        {
          className: "usu_max",
          "targets": 10
        },
        {
          className: "glosa_max",
          "targets": 11
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