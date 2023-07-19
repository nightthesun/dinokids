@extends('layouts.app')
@section('static', 'statick-side')
@section('content') 
@include('layouts.sidebar', ['hide'=>'1']) 
    <div class="container-fluid"> 
          <div class="row my-3">
            <div class="col">
              <h5>FUNCIONARIOS 
                <a href="{{ route('perfil.create') }}" >
                  <i class="fas fa-plus"></i>
                </a>
              </h5>
            </div>
          </div>
            <!--table class="table table-hover table-sm table-bordered" -->
            <table class="cell-border compact hover" id="example" style="width:100%">
             <thead>
                <th>Nombre</th>
                <th>CI</th>
                <th>Area</th>
                <th>Unidad</th>
                @if(Auth::user()->authorizepermisos(['Funcionarios','editar'])) 
                <th>Opciones</th>
                @endif
             </thead>
             <tbody>
              @if($perfil->count())
              @foreach($perfil as $p)
              <tr>
                <td>{{$p->nombre." ".$p->paterno." ". $p->materno}}</td>
                <td>{{$p->ci}} {{$p->ci_e}}</td>
                @if($p->area)
                  <td>{{$p->area->nombre}}</td>
                @else
                  <td class="text-danger">No Asignada</td>
                @endif
                @if($p->unidad)
                  <td>{{$p->unidad->nombre}}</td>
                @else
                  <td class="text-danger">No Asignada</td>
                @endif
                @if(Auth::user()->authorizepermisos(['Funcionarios','Ver'])) 
                <td>
                  <a class="btn btn-primary btn-sm" href="{{route('perfil.edit', $p->id)}}" >
                    <span class="glyphicon glyphicon-pencil">
                      <i class="far fa-address-card"></i>
                    </span>
                  </a>
                  @if($p->user)
                    <a class="btn btn-primary btn-sm" href="{{action('UsuarioController@edit', $p->user->id)}}" ><span class="glyphicon glyphicon-pencil"><i class="fas fa-user-cog"></i></span></a>
                    <a class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-pencil"><i class="fas fa-minus"></i></a>
                  @else
                    <a class="@if(!$p->ci) disabled @endif
                    btn btn-success btn-sm"
                    href="{{action('UsuarioController@create', $p->id)}}" >
                    <span class="glyphicon glyphicon-pencil"><i class="fas fa-plus"></i></a>
                  @endif
                 </td>  
                 @endif              
               </tr>
               @endforeach
               @else
               <tr>
                <td>No hay registro !!</td>
              </tr>
              @endif
            </tbody>
            <tfoot>
              <tr>
                <th>Nombre</th>
                <th>CI</th>
                <th>Area</th>
                <th>Unidad</th>
                <th class="#N/A"></th>
              </tr>
            </tfoot>
          </table>            
    </div>          
@endsection
@section('mis_scripts')
<script>
$(document).ready(function() 
{  
    $('#example tfoot th').each( function () {
        if($(this).attr("class")!="#N/A")
        {
          var title = $(this).text();
          $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%"/>' );
        }
    } );
    $('#example').DataTable( 
    {
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
        "columnDefs": [
            { width:"15%", "targets": 2 }
        ],
        "pageLength": 50,
        "scrollX":false,
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
} );

</script>
@endsection
