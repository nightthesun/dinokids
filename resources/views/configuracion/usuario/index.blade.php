@extends('layouts.app')
@section('static', 'statick-side')
@section('content') 
@include('layouts.sidebar', ['hide'=>'1']) 
@section('estilo')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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


       .text-blue {
    color: #B40F7F;
}  

.text-up {
    color: #74AB36;
}
.text-normal {
    color: #413b49bb;
}
.small-cell {
            width: 16%; /* Tamaño en píxeles o porcentaje */
        }
</style> 
@endsection
@if(Auth::check())
  @if (Auth::user()->super_user==1)
  @if(Auth::user()->authorizepermisos(['Usuarios', 'Ver']) ) 
  <div id="miDiv"></div>
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
      Si desea eliminar usuarios <i class="fas fa-user-times"></i> y para bloquear un usuario <i class="fas fa-user-lock"></i>, para aumentar el numero de actualizaciones apretar en boton 
      <i class="fas fa-level-up-alt"></i>, para convertir a super usuario apretar el boton <i class="fas fa-user-astronaut"></i> y para convertir a usuario normal <i class="fas fa-user-alt"></i>. 
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
       <td class="small-cell" >
     
        <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar" href="{{ route('perfil.edit',$user->id) }}" >
          <i class="fas fa-user-edit"></i>
        </a>
        <a class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-placement="top" title="Editar" href="{{action('UsuarioController@edit', $user->id)}}" >
          <i class="fas fa-user-cog"></i>
        </a>
  
  
  
          <!-- Button trigger super usuario -->
          <form method="POST" enctype="multipart/form-data" action="{{ route('usuario.super', $user->id) }}" class="d-inline">
            @csrf 
  
            @if ($user->super_user==1)
            <button type="button" class="btn btn-light btn-sm text-blue" title="Super Usuario" data-bs-toggle="modal" data-bs-target="#Super{{$user->id}}" data-toggle="tooltip" data-placement="top">
              <i class="fas fa-user-alt"></i>
            </button>
            @else
                @if ($user->super_user==0)
                <button type="button" class="btn btn-light btn-sm text-blue" title="Usuario Normal" data-bs-toggle="modal" data-bs-target="#Normal{{$user->id}}" data-toggle="tooltip" data-placement="top">
                 
                  <i class="fas fa-user-astronaut"></i>
                </button>
                @endif
            @endif
       
        
         <!-- Modal  normal-->
    <div class="modal fade" id="Super{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Modo administrador</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Desea convertir a <strong>USUARIO NORMAL</strong> a 
            {{$user->first_name." ".$user->last_name1." ".$user->last_name2}}
            con nombre de usuario {{$user->name}} para que pueda hacer el rol de administrador.
         
    <input type="text" name="super" value="0" hidden>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      
                  <button type="submit"  class="btn btn-dark   text-white"> Aceptar <i class="fas fa-user-shield"></i></button>
      
           
           
          </div>
        </div>
      </div>
    </div>
  
  
     <!-- Modal  super-->
     <div class="modal fade" id="Normal{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Modo administrador</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Desea convertir a <strong>SUPER USUARIO</strong>  a 
            {{$user->first_name." ".$user->last_name1." ".$user->last_name2}}
            con nombre de usuario {{$user->name}} para que pueda hacer el rol normal.
         
    <input type="text" name="super" value="1" hidden>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      
                  <button type="submit"  class="btn btn-dark   text-white"> Aceptar <i class="fas fa-user-shield"></i></button>
      
           
           
          </div>
        </div>
      </div>
    </div>
        </form>
  
   
         <!-- Button trigger edicion -->
         <form method="POST" enctype="multipart/form-data" action="{{ route('usuario.aumento', $user->id) }}" class="d-inline">
          @csrf 
          @if ($user->number_modif==0)
          <button type="button" class="btn btn-light btn-sm text-up" title="Aumentar" data-bs-toggle="modal" data-bs-target="#Aumen{{$user->id}}" data-toggle="tooltip" data-placement="top">
               
            <i class="fas fa-level-up-alt"></i>
          </button>
          @else
              @if ($user->number_modif>1)
              <button type="button" class="btn btn-danger btn-sm text-white" title="Aumentar" data-bs-toggle="modal" data-bs-target="#Aumen{{$user->id}}" data-toggle="tooltip" data-placement="top">
               
                <i class="fas fa-level-up-alt"></i>
              </button> 
              @endif
          @endif
              
         
     
      
       <!-- Modal -->
  <div class="modal fade" id="Aumen{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">¿Desea aumentar la cantidad?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Numero de actualizacion actual: <strong>{{$user->number_modif}}</strong>, de  
          {{$user->first_name." ".$user->last_name1." ".$user->last_name2}}
          con nombre de usuario {{$user->name}} @if ($user->number_modif>1)
           cantidad muy alta
          @else
              agoto su cantidad de ediciones
          @endif.
       
  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    
                <button type="submit"  class="btn btn-dark   text-white"> Aceptar <i class="fas fa-user-shield"></i></button>
    
         
         
        </div>
      </div>
    </div>
  </div>
  
  
   
      </form>
        
      
  
  
  
        <!-- Button trigger modalreset -->
        <form method="POST" enctype="multipart/form-data" action="{{ route('usuario.reset', $user->id) }}" class="d-inline">
          @csrf 
      <button type="button" class="btn btn-dark btn-sm text-white" title="Resetar" data-bs-toggle="modal" data-bs-target="#A{{$user->id}}" data-toggle="tooltip" data-placement="top">
        <i class="fas fa-key"></i>
      </button>
      
       <!-- Modal -->
  <div class="modal fade" id="A{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">¿Desea reiniciar la contraseña?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Se cambiar la contraseña del usuario 
          {{$user->first_name." ".$user->last_name1." ".$user->last_name2}}
          con nombre de usuario {{$user->name}}. La nueva contraseña sera "123".
       
  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    
                <button type="submit"  class="btn btn-dark   text-white">Resetear <i class="fas fa-key"></i></button>
    
         
         
        </div>
      </div>
    </div>
  </div>
      </form>
   <!-- Button trigger modal delete-->
   <form method="POST" enctype="multipart/form-data" action="{{ route('usuario.destroy', $user->id) }}" class="d-inline">
    @csrf 
   
  <button type="button" class="btn btn-danger btn-sm text-white" title="Eliminar" data-bs-toggle="modal" data-bs-target="#Delete{{$user->id}}" data-toggle="tooltip" data-placement="top">
    <i class="fas fa-user-times"></i>
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="Delete{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="staticBackdropLabel">¿Desea reiniciar la contraseña?</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
    Realmente decea eliminar a  
    {{$user->first_name." ".$user->last_name1." ".$user->last_name2}}
    con nombre de usuario {{$user->name}}.
  
  
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
  
          <button type="submit"  class="btn btn-danger   text-white">Eliminar <i class="far fa-trash-alt"></i></button>
  
   
   
  </div>
  </div>
  </div>
  </div>
  </form>
  
        
      
  <!-- Button trigger modal Bloquear-->
  <form method="POST" enctype="multipart/form-data" action="{{ route('usuario.bloqueo', $user->id) }}" class="d-inline" style="margin: 0;padding: 0;">
    @csrf
    @if ($user->blockead_user==0)
    <button type="button" class="btn btn-secondary btn-sm text-white" title="Bloquear" data-bs-toggle="modal" data-bs-target="#Bad1{{$user->id}}" data-toggle="tooltip" data-placement="top">
      <i class="fas fa-user-lock"></i>
    </button>
    @else
    <button type="button" class="btn btn-success btn-sm text-white" title="Desbloquear" data-bs-toggle="modal" data-bs-target="#Bad2{{$user->id}}" data-toggle="tooltip" data-placement="top">
      <i class="fas fa-user-check"></i>
    </button>
          
    @endif 
    
  
  <!-- Modal 1-->
  <div class="modal fade" id="Bad1{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="staticBackdropLabel ">
      
        ¿Desea bloquear a este usuario?
      </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
    Realmente decea bloquear al  
    {{$user->first_name." ".$user->last_name1." ".$user->last_name2}}
    con nombre de usuario {{$user->name}}.
    <input type="text" value="rip" name=ban hidden>
  
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
  
          <button type="submit"   class="btn btn-secondary   text-white">Bloquear <i class="fas fa-user-shield"></i></button>
  
   
   
  </div>
  </div>
  </div>
  </div>
  <!-- Modal 2-->
  <div class="modal fade" id="Bad2{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel ">
        
          ¿Desea desbloquear a este usuario?
        </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      Realmente decea desbloquear al  
      {{$user->first_name." ".$user->last_name1." ".$user->last_name2}}
      con nombre de usuario {{$user->name}}.
      <input type="text" value="pir" name=ban hidden>
    
      
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    
            <button type="submit"   class="btn btn-secondary   text-white">Desbloquear <i class="fas fa-user-shield"></i></button>
    
     
     
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
  
      
  @endif
  @else
  <div class="alert alert-danger" role="alert">
    <p>No tiene permisos para estar aqui , {{ Auth::user()->name }}.</p>
  </div>
    
  @endif
@endif
@section('mis_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
      
      } );
  } );
  
  </script>
  <script>
    function alertaBaneado(){
      $("#info").ready(function(){       
        toastr_call("info","Acción","Realizada...");
    }); 
    }
    function alertaFallo(){
      $("#error").ready(function(){       
    toastr_call("error","Error.","...");
    }); 
    }
   function alertaReset(){
    
    $("#success").ready(function(){      
        toastr_call("success","Reset.","Se renicio la contraseña");
    });
    } 
    function a0(){
    
    $("#warning").ready(function(){      
        toastr_call("warning","Se aumento.","...");
    });
    } function a1(){
    
    $("#error").ready(function(){      
        toastr_call("error","Error.","No puede aumentar algo infinito");
    });
    } 
    function alertaNormal(){
    
    $("#success").ready(function(){      
        toastr_call("success","Cambio realizado.","a USUARIO NORMAL");
    });
    }


    function alertaSuper(){
    
    $("#success").ready(function(){      
        toastr_call("success","Cambio realizado.","a SUPER USUARIO");
    });
    }
    function alertaDelete(){
    
    $("#success").ready(function(){      
     
        toastr_call("warning","Eliminacion","Procedida");
    });
    }
   $(document).ready(function() {
    $("#success").click(function(){      
        toastr_call("success","Bien.","Se actualizo los datos con exito");
    });
    $("#info").click(function(){ 
     toastr_call("info","Activated","For your Information");
    });
    $("#warning").click(function(){   
      toastr_call("warning","Not Activated","Wrong Information");
    });
    $("#override").click(function(){ 
      override = {"positionClass": "toast-top-left"};  
      toastr_call("error","Failed","Page not found",override);
    }); 
    $("#error").click(function(){       
    toastr_call("error","Error.","No se modificaron los datos");
    }); 
    $("#remove").click(function(){     
      toastr.remove();
    });
    $("#clear").click(function(){       
      toastr.clear();
    });
  });
  
  function toastr_call(type,title,msg,override)
  {
    toastr[type](msg, title,msg);
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }  
  }
  </script>
  <script>
    var miDiv = document.getElementById('miDiv');
    var status = @json(session('status')); // Asignar la variable de sesión a una variable de JS
  
    if (status === 'success') {
      alertaReset();
    } else if (status === 'error') {
        alertaFallo();
    }
    if (status === 'delete') {
      alertaDelete();
    }
    if (status === 'error') {
      alertaFallo();
    }
    if (status === 'banned') {
      alertaBaneado();
    }
    if (status === 'userNormal') {
      alertaNormal();
    }
    if (status === 'userSuper') {
      alertaSuper();
    }

    if (status === 'aumento0') {
      a0();
    }

    if (status === 'aumento1') {
      a1();
    }
  
  </script>

@endsection