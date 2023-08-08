@extends('layouts.app')
@section('estilo')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>

.contenedorX {
  ...
  display: flex;
  justify-content: center;
}
.borde1 {
  border-width: 1px;
  border-style: solid;
  border-color: #6c757d;
  border-radius: 10px;
  
}
.fondoTitulo{
  background: #EBEEF5;
  margin:auto;
}
.titulo1{
  color: #B40F7F;
  border-width: 1px;
  
}
.borde2 {
  border-width: 1px;
  border-style: solid;
  border-color: #6c757d;
  border-radius: 10px;
  
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
#botonSalir {
   background-color: #F6F7FC;
   color: #B40F7F;
   border: none;
   border-radius: 0%;
   cursor: pointer;
  
   font-size: 40px;
}
#botonSalir:hover {
 background-color: #F6F7FC;
   color: #74AB36;
   border: none;  
   animation: swing 1s ease;
    animation-iteration-count: 1;
    
     @keyframes swing { 
    15% { 
    transform: translateX(5px);
    } 
    30% { 
    transform: translateX(-5px);
    } 
    50% { 
    transform: translateX(3px);
    } 
    65% { 
    transform: translateX(-3px);
    } 
    80% { 
    transform: translateX(2px);
    } 
    100% { 
    transform: translateX(0);
    } 
}
}


/************ALERTAS*************/

/********************************/
/* Cambiar el background-color de la pestaña */


/* Estilos cuando se selecciona la pestaña */
.nav-pills .nav-link {
   /* Cambiar a tu color deseado */
    color: #B40F7F; /* Cambiar a tu color de texto deseado */
}

/* Estilos cuando se selecciona la pestaña */
.nav-pills .nav-link.active {
    background-color: #B40F7F; /* Cambiar a tu color deseado */
    color: white; /* Cambiar a tu color de texto deseado */
}
.text1{
  color: #9e2b7a;
}
.text2{
  color: #9e5988;
}
.miCheckbox {
      /* Establecer aquí el color de fondo cuando el checkbox está marcado */
      background-color: #B40F7F;
      /* Ajustar otros estilos del checkbox, como el tamaño */
      width: 20px;
      height: 20px;
      /* Puedes agregar bordes redondeados para hacerlo más atractivo */
      border-radius: 4px;
      /* Puedes agregar un margen derecho para separar el checkbox de la etiqueta */
      margin-right: 5px;
    }
    .miCheckbox:checked {
      /* Establecer aquí el color de fondo cuando el checkbox está marcado */
      background-color: #F6F7FC;
      box-shadow: 0 4px 8px rgba(97, 238, 3, 0.4);
    }
    /* Estilo para el label asociado al checkbox */
   
</style> 

@endsection

@section('content')
@include('layouts.sidebar', ['hide'=>'0'])


<div id="miDiv"></div>
<div class="contenedorX">
 
    <!-- Contenido del div -->
    <div style="padding: 6rem; padding-top:0.5rem;">
      <div class="row d-flex justify-content-center mb-3">
        <div class="col-lg-6 col-sm-12 d-flex align-items-center justify-content-center">
          <h3 class="text-center titulo1">Permisos</h3>
          <a href="{{ url('/') }}">
            <button type="button" class="btn btn-primary align-self-end" id="botonSalir"  data-bs-toggle="tooltip" data-bs-placement="right" title="Volver a pagina principal" >
                <i class="fas fa-house-user"></i>
              </button> 
          </a>
          <a href="{{ route('usuario.index') }}">
            <button type="button" class="btn btn-primary align-self-end" id="botonSalir"  data-bs-toggle="tooltip" data-bs-placement="right" title="volver a lista" >
              <i class="far fa-address-book"></i>
              </button> 
          </a> 
        </div>
      </div>
      <form method="POST" enctype="multipart/form-data" action="{{ route('usuario.update', $userX[0]->idpersona) }}">
        @method('PUT')
        @csrf
    
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
         
    
          <div class="col-12 borde1">
            <div class="row">
              <div class="col">
                <h3 class="mt-3">
                  <label style="font-size: 20px">{{"Nombre:"." ".$userX[0]->nombre." ".$userX[0]->apeP." ".$userX[0]->apeM}}</label>
                </h3>
              </div>
                <div class="col">
                  <h3 class="mt-3">
                    <label style="font-size: 20px">{{"Usuario:"." ".$userX[0]->userName}}</label>
                  </h3>  
              </div>
            </div>
     





           <hr>
          <div class="container p-1" >
            <div class="row">
              <div class="col-12  rounded">
                <div class="container">
                  <div class="row col">
                   <ul class="nav nav-pills mb-3 mt-10"  id="pills-tab" role="tablist">
                    @foreach($modulo as $modu)
                  
                    @if(count($modu->submodulos)||count($modu->programs))
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if ($loop->first) active @endif" id="pills-{{$modu->id}}-tab" 
                            data-bs-toggle="pill" href="#pills-{{$modu->id}}" role="tab" 
                            aria-controls="pills-{{$modu->id}}" aria-selected="@if ($loop->first) true @else false @endif">
                                {{($modu->nombre)}}
                            </a>
                        </li>
                    @endif
                @endforeach  
                
                    </ul>
                  </div>
                  
                  <div class="tab-content" id="pills-tabContent">
                    @foreach($modulo as $modu)
                      @if(count($modu->programs))
                            <div class="tab-pane fade show @if ($loop->first) active @endif" id="pills-{{($modu->id)}}" role="tabpanel" aria-labelledby="pills-{{($modu->id)}}-tab">
                                <div class="row">
                                 
                                    @foreach($modu->programs as $prog)                                   
                                        <div class="col-4 mb-3">
                                            <div class="form-group row">
                                                <h6 class='ml-3 text1'><b>{{($prog->nombre)}}</b></h6>
                                            </div>
                                            @foreach($prog->permisos as $perm)
                                            <div class="form-group row">
                                                <div class="col">
                                                    <div class="ml-3 form-check">  
                                                      <input type="checkbox" class="form-check-input " style="color: #6c757d" id="permiso[]" name="permiso[]" value="G{{$prog->id}}.{{$perm->id}}" 
                                                      @if(App\Acceso::where('user_id', $usuario->id)
                                                      ->where('program_id', $prog->id)
                                                      ->where('permiso_id',$perm->id)->first()
                                                      ) checked
                                                       @endif>
                                                        <label class="form-check-label text2" for="exampleCheck1"> 
                                                            {{$perm->p}} 
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>                
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach 
                </div>
                </div>
              </div>  
            </div>

          </div>
            
        </form>
          
   
           
            <div class="form-group row d-flex justify-content-center " style="padding-top: 20px;padding-bottom: 10px;">
              <div class="col-md-10 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary" id="botonSubir"  >
                  {{ __('Agregas permisos') }}
                </button>
             
               
    
    
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  
</div>



@endsection
@section('mis_scripts')
<script src="http://momentjs.com/downloads/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
 var loadFile = function(event) {
    var image = document.getElementById('output');
    image.src = URL.createObjectURL(event.target.files[0]);
    var foto = $("#foto").val();
    if (foto !== "") {
      $("#elim_image").show();
    }
  };
  $("#elim_image").click(function() {
    $("#foto").val("");
    var image = document.getElementById('output');
    image.src = "{{asset('imagenes/log.png')}}";
    $("#elim_image").hide();
  });
</script>

<script>
  function alertaFallo(){
    $("#error").ready(function(){       
  toastr_call("error","Error.","No se modificaron los datos");
  }); 
  }
 function alertaAceptar(){
  
  $("#success").ready(function(){      
      toastr_call("success","Bien.","Se actualizo los datos con exito");
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
      alertaAceptar();
      //alert('¡Operación exitosa!');
  } else if (status === 'error') {
      //alertaFallo();
      alert('¡La operación falló!');
  }
</script>


@endsection

