@extends('layouts.app')
@section('static', 'statick-side')
@section('content') 
@include('layouts.sidebar', ['hide'=>'1']) 
@section('estilo')
<style>
  .borde1 {
    border-width: 1px;
    border-style: solid;
    border-color: #6c757d;
    border-radius: 10px;
    margin-left: -20%;
    
  }
  .titulo1{
    color: #B40F7F;
    font-weight: bold;
  }
  
  
  #botonSubir {
     
      background-color: #74AB36;
      color: white;
     
      border: 2px solid #74AB36;
      border-radius: 25px;
      cursor: pointer;
      width:200px;
    height:50px;
    font-size: 20px;
  }
  #botonSubir:hover {
    background-color: #B40F7F;
      color: white;
      border: 2px solid #B40F7F;  
  }
  .contenedor {
    padding-top: 20px;
    padding-bottom: 10px;
  display: flex;
  justify-content: space-between; /* Coloca el h1 y el botón en los extremos opuestos */
  align-items: center; /* Centra verticalmente los elementos */
  
}

.h11 {
  margin: 0; /* Elimina el margen predeterminado del h1 */
}
.td2 {
           
          
            text-align: center; /* Alineación horizontal */
          
            color: #74AB36;
        }
        .td3 {
           
          
           text-align: center; /* Alineación horizontal */
         
           color: #B40F7F;
       }
</style> 
@endsection

<div class="contenedor">
  <h3 class="titulo1 h11">Lista de usuarios</h3>
  <a href="{{ route('perfil.create') }}" >
  <button type="button" class="btn btn-primary" id="botonSubir"  >
    <i class="fa fa-user-plus" aria-hidden="true"></i> {{ __('Añadir usuario') }}
   </button>
  </a>
</div>
<div class="container"> 
  <div class="alert alert-info" role="alert" >
    Puede dar acceso al sistema y denegar dichos accesos, en la parte de valido y bloquedo si estan color verde el usuario esta activado por lo contrario estan color rojo no esta activado el usuario:
    el icono de <i class="fas fa-user-edit"></i> es para editar,
    puede dar permiso a los usarios con <i class="fas fa-user-cog"></i>, para resetear contraseña <i class="fas fa-key"></i>.
    Si desea eliminar usuarios <i class="fas fa-user-times"></i> y para bloquear un usuario <i class="fas fa-user-lock"></i>.
    
  </div>  
</div>  
  
<table class="cell-border compact hover" id="myTable" style="width:100%;" >
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Usuario</th>
      <th>Valido</th>
      <th>Bloqueado</th>  
      <th>Opciones</th>
              
    </tr>
  </thead>
  <tbody>
   @if (count($user2))
   @foreach ($user2 as $user)
   <tr>
     <td>{{$user->first_name." ".$user->last_name1." ".$user->last_name2}}</td>
     <td>{{$user->name}}</td>
     @if ($user->val==1)
     <td style="color:green;">SI</i></td>  
     @else
     <td style="color: red;">NO</i></td>   
     @endif
     @if ($user->blockead_user==0)
     <td style="color: green;">NO</i></td>
     @else
     <td style="color: red;">SI</td>
     @endif
     <td>
      <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar" href="{{ route('perfil.edit',$user->id) }}" >
        <i class="fas fa-user-edit"></i>
      </a>
      <a class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-placement="top" title="Editar" href="{{action('UsuarioController@edit', $user->id)}}" >
        <i class="fas fa-user-cog"></i>
      </a>
      <button type="button" data-toggle="tooltip" data-placement="top" title="Resetar" class="btn btn-dark btn-sm text-white" data-toggle="modal" data-target="#exampleModal">
        <i class="fas fa-key"></i>
      </button>
      <button type="button" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm text-white" data-toggle="modal" data-target="#exampleModal">
        <i class="fas fa-user-times"></i>
      </button>
      <button type="button" data-toggle="tooltip" data-placement="top" title="Bloquear" class="btn btn-secondary btn-sm text-white" data-toggle="modal" data-target="#exampleModal">
        <i class="fas fa-user-lock"></i>
      </button>

      
      <form action="{{action('UsuarioController@destroy', $user->id)}}" method="post">
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
    </tr>
@endforeach
   @else
   <tr>
    <td>No hay registro !!</td>
  </tr> 
   @endif
  </tbody>  
</table>


             
@endsection
@section('mis_scripts')
<script>
  $(document).ready(function() 
  {  
      $('#myTable tfoot th').each( function () {
          if($(this).attr("class")!="#N/A")
          {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" />' );
          }
      } );
      var table = $('#myTable').DataTable( 
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