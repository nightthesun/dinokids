@extends('layouts.app')
@section('static', 'statick-side')
@section('content') 
@include('layouts.sidebar', ['hide'=>'1']) 
    <div class="container">    
          <div class="row my-3">
            <div class="col">
              <h5>USUARIOS 
                <a href="{{ route('perfil.create') }}" >
                  <i class="fas fa-plus"></i>
                </a>
              </h5>
            </div>
          </div>
          <table class="cell-border compact hover" id="example" style="width:100%;" >
            <thead>
              <th>Funcionario</th>
              <th>Nombre Usuario</th>
              <th>Usuario Dualbiz</th>
              @if(Auth::user()->authorizepermisos(['Usuarios','Editar'])) 
              <th>Opciones</th>
              @endif
            </thead>
            <tbody>
            @if($usuario->count())
            @foreach($usuario as $usua)
            <tr>
              <td>{{$usua->perfiles->nombre." ".$usua->perfiles->paterno." ". $usua->perfiles->materno}}</td>
              <td>{{$usua->name}}</td>
            
              @if(Auth::user()->authorizepermisos(['Usuarios', 'Ver'])) 
                <td>
                  <a class="btn btn-primary btn-sm" href="{{action('UsuarioController@edit', $usua->id)}}" >
                    <i class="fas fa-edit"></i>
                  </a>
                  <button type="button" class="btn btn-danger btn-sm text-white" data-toggle="modal" data-target="#exampleModal">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                  <form action="{{action('UsuarioController@destroy', $usua->id)}}" method="post">
                  {{csrf_field()}}
                  
                  <input name="_method" type="hidden" value="DELETE">
                    
                    <div class="modal fade text-dark" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Eliminacion</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            ¿Esta Seguro de Eliminar La informacion de este Cliente?
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-danger" type="submit">Eliminar<span class="glyphicon glyphicon-trash"></span></button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
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
              <th>Funcionario</th>
              <th>Nombre Usuario</th>
           
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
          $(this).html( '<input type="text" placeholder="'+title+'" />' );
        }
    } );
    var table = $('#example').DataTable( 
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
            { width:"10%", "targets": 3 }
        ],
        "pageLength": 50,
        "scrollX":true,
        "scrollY": "60vh",
        "scrollCollapse": true, 
        "FixedHeader":true,
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