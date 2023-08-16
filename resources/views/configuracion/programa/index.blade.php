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
  
  #botonSubir2 {
     
     background-color: #B40F7F;
     color: white;
    
     border: 2px solid #B40F7F;
     border-radius: 25px;
     cursor: pointer;
     width:250px;
   height:50px;
   font-size: 20px;
 }
 #botonSubir2:hover {
   background-color: #74AB36;
     color: white;
     border: 2px solid #74AB36;  
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
            width: 8%; /* Tamaño en píxeles o porcentaje */
        }
</style> 
@endsection


  @if(Auth::user()->authorizepermisos(['Programa', 'Ver']) ) 
  <div id="miDiv"></div>
  <div class="contenedor">
    <h3 class="titulo1 h11">Lista de Programas</h3>
      <a href="{{ route('programa.create') }}">
       <button type="button" class="btn btn-primary" id="botonSubir2"  >
        <i class="fas fa-project-diagram"></i>{{ __('Añadir Programa') }}
       </button>
      </a>
  </div>
  <div class="container"> 
    <div class="alert alert-info" role="alert" >
      El boton <i class="fas fa-user-edit"></i> es para editar la información.
      @if (Auth::user()->authorizepermisos(['Programa', 'Editar']))
            
      Si desea eliminar usuarios <i class="fas fa-user-times"></i>      
            
      @endif </div>  
     
     
  </div>  
    
  <table class="cell-border compact hover" id="myTable" style="width:100%;" >
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Descripción</th>
         <th>Opcines</th>
                
      </tr>
    </thead>
    <tbody>
     @if (count($programa))
     @foreach ($programa as $P)
     
     <tr>
       
      <td>{{$P->interventionarea_name}}</td>
      <td>{{$P->interventionarea_description}}</td>
      
       <td class="small-cell" >
        @if(Auth::user()->authorizepermisos(['Programa', 'Editar']) ) 
          
          <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar" href="{{ route('programa.edit',$P->id) }}" >
            <i class="fas fa-user-edit"></i>  
           </a>   
           
           
           
        @else
        <button type="button" class="btn btn-warning"><i class="fas fa-exclamation-triangle"></i></button>
       @endif
       @if(Auth::user()->authorizepermisos(['Programa', 'Ver informacion']) ) 
          <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver" href="{{ route('programa.show',$P->id) }}" >
            <i class="far fa-eye"></i>
           </a>  
          @endif 
         
      <!-- Button trigger modal delete-->
      @if(Auth::user()->authorizepermisos(['Programa', 'Eliminar']) ) 
      <form method="POST" enctype="multipart/form-data" action="{{ route('programa.destroy', $P->id) }}" class="d-inline">
        @csrf 
       
       @if ($P->deleted==0)
       <button type="button" class="btn btn-danger btn-sm text-white" title="Eliminar" data-bs-toggle="modal" data-bs-target="#Delete{{$P->id}}" data-toggle="tooltip" data-placement="top">
               <i class="fas fa-folder-minus"></i>
      </button>
        @else
            @if ($P->deleted==1)
            <button type="button" class="btn btn-secondary btn-sm text-white" title="Activar" data-bs-toggle="modal" data-bs-target="#Delete{{$P->id}}" data-toggle="tooltip" data-placement="top">
       
              <i class="fas fa-folder-plus"></i>
          </button>
            @endif
        @endif
       
     
      
      <!-- Modal -->
      <div class="modal fade" id="Delete{{$P->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">¿Desea realizar la acción?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Realmente decea eliminar a la sucursal 
        {{$P->interventionarea_name}}.
      
      
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      
              <button type="submit"  class="btn btn-danger   text-white">Aceptar <i class="far fa-trash-alt"></i></button>
      
       
       
      </div>
      </div>
      </div>
      </div>
      </form>

          
      @endif
   
     
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
        toastr_call("success","Cambio realizado.","activacion correcta");
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
    if (status === 'activate') {
      alertaNormal();
    }
    
  
  </script>

@endsection