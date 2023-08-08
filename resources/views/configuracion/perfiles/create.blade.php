@extends('layouts.app')
@section('estilo')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
.borde1 {
  border-width: 1px;
  border-style: solid;
  border-color: #6c757d;
  border-radius: 10px;
  
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
#botonSubir:hover {
  background-color: #B40F7F;
    color: white;
    border: 2px solid #B40F7F;  
    
}
#botonSalir {
   background-color: #ffffff;
   color: #B40F7F;
   border: none;
   border-radius: 0%;
   cursor: pointer;
  
   font-size: 40px;
}
#botonSalir:hover {
 background-color: #ffffff;
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
* {
  box-sizing: border-box;
  padding: 0;
  margin: 0;
  outline: 0;
  direction: ltr;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

body {
  background-color: #ffffff;
  color: #000000;
  padding: 20px;
}

.nova-modal {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 999999999999;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

.nova-modal .nova-alert {
  position: relative;
  width: 70%;
  padding: 20px;
  background-color: #ffffff;
  border-radius: 0px;
  border-radius: 3px;
  text-align: center;
  animation: 0.6s 1 novaAnimate;
  -webkit-animation: 0.6s 1 novaAnimate;
}

@media (min-width: 768px) {
  .nova-modal .nova-alert {
    width: 350px;
  }
}

@keyframes novaAnimate {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.2);
  }
  to {
    transform: none;
  }
}

.nova-modal .nova-alert div.nova-icon {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.nova-modal .nova-alert div.nova-icon div {
  transform: scale(1.2);
}

.nova-modal .nova-alert .nova-title {
  color: black;
  font-size: large;
}

.nova-modal .nova-alert .nova-text {
  color: #888888;
  font-size: 15px;
  margin: 10px 0px;
}

.nova-modal .nova-alert .nova-btns {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.nova-modal .nova-alert .nova-btns a {
  text-decoration: none;
  padding: 7px 10px;
  flex: 100%;
  font-size: 13px;
  cursor: pointer;
  border-radius: 3px;
}

.nova-modal .nova-alert .nova-btns a.accept {
  background: #74AB36;
  color: #ffffff;
}

.nova-modal .nova-alert .nova-btns a.reject {
  background: #B40F7F;
  color: #ffffff;
}

.nova-modal .nova-alert .dismissButton {
  position: absolute;
  top: 10px;
  left: 10px;
  cursor: pointer;
  font-size: large;
  border: 1px solid rgba(126, 126, 126, 0.5);
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 3px;
  color: rgba(126, 126, 126, 0.5) !important;
}

.nova-modal .nova-alert .dismissButton.hidden {
  display: none;
}

.nova-modal .nova-alert input.nova-input-alert {
  width: 100%;
  padding: 5px 5px;
  margin: 10px 0px;
  border-radius: 3px;
  border: 1px solid rgba(126, 126, 126, 0.5);
  background-color: transparent;
}

.nova-dark-mode {
  background-color: #2b2b2b !important;
}

.nova-dark-mode * {
  color: white !important;
}

/*    animation svg icon    */
.svg-box {
  display: inline-block;
  position: relative;
  width: 150px;
}

.green-stroke {
  stroke: #7CB342;
}

.red-stroke {
  stroke: #FF6245;
}

.yellow-stroke {
  stroke: #FFC107;
}

.circular circle.path {
  stroke-dasharray: 330;
  stroke-dashoffset: 0;
  stroke-linecap: round;
  opacity: 0.4;
  animation: 0.7s draw-circle ease-out;
}

/*------- Checkmark ---------*/
.checkmark {
  stroke-width: 6.25;
  stroke-linecap: round;
  position: absolute;
  top: 56px;
  left: 49px;
  width: 52px;
  height: 40px;
}

.checkmark path {
  animation: 1s draw-check ease-out;
}

@keyframes draw-circle {
  0% {
    stroke-dasharray: 0,330;
    stroke-dashoffset: 0;
    opacity: 1;
  }
  80% {
    stroke-dasharray: 330,330;
    stroke-dashoffset: 0;
    opacity: 1;
  }
  100% {
    opacity: 0.4;
  }
}

@keyframes draw-check {
  0% {
    stroke-dasharray: 49,80;
    stroke-dashoffset: 48;
    opacity: 0;
  }
  50% {
    stroke-dasharray: 49,80;
    stroke-dashoffset: 48;
    opacity: 1;
  }
  100% {
    stroke-dasharray: 130,80;
    stroke-dashoffset: 48;
  }
}

/*---------- Cross ----------*/
.cross {
  stroke-width: 6.25;
  stroke-linecap: round;
  position: absolute;
  top: 54px;
  left: 54px;
  width: 40px;
  height: 40px;
}

.cross .first-line {
  animation: 0.7s draw-first-line ease-out;
}

.cross .second-line {
  animation: 0.7s draw-second-line ease-out;
}

@keyframes draw-first-line {
  0% {
    stroke-dasharray: 0,56;
    stroke-dashoffset: 0;
  }
  50% {
    stroke-dasharray: 0,56;
    stroke-dashoffset: 0;
  }
  100% {
    stroke-dasharray: 56,330;
    stroke-dashoffset: 0;
  }
}

@keyframes draw-second-line {
  0% {
    stroke-dasharray: 0,55;
    stroke-dashoffset: 1;
  }
  50% {
    stroke-dasharray: 0,55;
    stroke-dashoffset: 1;
  }
  100% {
    stroke-dasharray: 55,0;
    stroke-dashoffset: 70;
  }
}

.alert-sign {
  stroke-width: 6.25;
  stroke-linecap: round;
  position: absolute;
  top: 40px;
  left: 68px;
  width: 15px;
  height: 70px;
  animation: 0.5s alert-sign-bounce cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.alert-sign .dot {
  stroke: none;
  fill: #FFC107;
}

@keyframes alert-sign-bounce {
  0% {
    transform: scale(0);
    opacity: 0;
  }
  50% {
    transform: scale(0);
    opacity: 1;
  }
  100% {
    transform: scale(1);
  }
}



/********************************/

</style> 

@endsection

@section('content')
@include('layouts.sidebar', ['hide'=>'0'])

<!-- Mostrar mensaje de éxito -->
<div id="miDiv"></div>


<div style="padding: 6rem; padding-top:0.5rem;">
  <div class="row d-flex justify-content-center mb-3">
    <div class="col-lg-6 col-sm-12 d-flex align-items-center justify-content-center">
      <h3 class="text-center titulo1">Registro de usuario</h3>
      <a href="{{ url('/') }}">
        <button type="button" class="btn btn-primary align-self-end" id="botonSalir"  data-bs-toggle="tooltip" data-bs-placement="right" title="Regresar al inicio" >
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
  <form method="POST" enctype="multipart/form-data" action="{{ route('perfil.store') }}">
    @csrf
    <div class="row">
      <div class="col-2">
        <div class="form-group row d-flex">
          <div class="col">
            <a id="elim_image" style="position: absolute; right:43px;cursor:pointer; font-size: 1.3rem; display: none;" class="text-danger"><i class="fas fa-times-circle"></i></a>
            <img alt="foto" id="output" class="img-fluid borde1 " src="{{asset('imagenes/log.png')}}" />
          </div>
        </div>
        
        <div class="file-input row" style="padding-top: 5px">
          <div class="col">
            <input type="file" accept="image/*" name="foto" id="foto" onchange="loadFile(event)" class="file-input__input " />
            <label class="file-input__label w-100 text-center mb-0" for="foto">
              <span>Subir Imagen</span>
            </label>
            @error('foto')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>
      </div>

      <div class="col-10 borde1">
        <h3 class="mt-3">Datos Personales</h3>
        <div class="form-group row d-flex">


<div class="row">
  <div class="col">
          <label for="nombre" class="col-md-2 col-form-label">
            {{ __('Nombres:') }}
          </label>
          <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
            @error('first_name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
    </div>
  <div class="col">
          <label for="last_name1" class="col col-form-label" style="padding-top: 5px">
            {{ __('Apellido Paterno:') }}
          </label>
           <input id="last_name1" type="text" class="form-control @error('last_name1') is-invalid @enderror" name="last_name1" value="{{ old('last_name1') }}" required autocomplete="last_name1">
            @error('last_name1')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror

  </div>
  <div class="col">
          <label for="last_name2" class="col col-form-label">
            {{ __('Apellido Materno:') }}
          </label>
          <input id="last_name2" type="text" class="form-control @error('last_name1') is-invalid @enderror" name="last_name2" value="{{ old('last_name2') }}" autocomplete="last_name2">
            @error('last_name2')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
  </div>
  <div class="col">
          <label for="ci" class="col col-form-label">
            {{ __('Documento de identidad:') }}
          </label>
          <input id="ci" type="text" class="form-control @error('ci') is-invalid @enderror" name="ci" value="{{ old('ci') }}" autocomplete="ci">
            @error('ci')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
  </div>
</div>

<div class="row" style="padding-top: 1.5%;">
  <div class="col">
    <label for="fecha_nac" class="col col-form-label">
            {{ __('Fecha de Nacimiento:') }}
    </label>
            <input id="fecha_nac" type="date" class="form-control @error('fecha_nac') is-invalid @enderror" name="fecha_nac" onchange="calcularEdad()" value="{{ old('fecha_nac') }}" autocomplete="fecha_nac" autofocus>
            @error('fecha_nac')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
  </div>
  <div class="col" >
    <label for="age" class="col col-form-label">
            {{ __('Edad:') }}
    </label>
  <input id="age" name="age" type="text" value="" class="form-control ">
  </div>
  
  

  <div class="col">
    <label for="gender" class="col col-form-label">
             {{ __('Genero:') }}
    </label>
    <div class="row">
      <div class="col">
        <div class="form-check">
          <input class="form-check-input" type="radio" value="Hombre" name="gender" id="gender1"checked>
            <label class="form-check-label" for="age1">
              {{ __('Hombre') }}
  </label>
</div>
      </div>
      <div class="col" style="">
        <div class="form-check">
          <input class="form-check-input" type="radio" value="Mujer" name="gender" id="gender2" >
          <label class="form-check-label" for="gender2">
                        {{ __('Mujer') }}
          </label>
        </div>
      </div>
    </div>
          

  </div>
  <div class="col" style="padding-left: 10px;padding-right: 10px;">
    <label for="nationality" class="col col-form-label">
      {{ __('Pais') }}
    </label>
    <select class="form-select" id="nationality" name="nationality" aria-label="Default select example"required>
      <option value="">Seleccione un pais</option>
      @foreach ($reg_country as $pais)
        @if ($pais->id==1)
        <option value="{{$pais->id}}" selected>{{$pais->name}}</option>      
        @else
        <option value="{{$pais->id}}">{{$pais->name}}</option>
        @endif
          
      @endforeach
      
    </select>
  </div>
  <div class="col" style="padding-left: 10px;padding-right: 10px;">
    <label for="city" class="col col-form-label">
      {{ __('Ciudad') }}
    </label>
    <select class="form-select" id="city" name="city" aria-label="Default select example"required>
      <option value="">Seleccione una ciudad</option>
      @foreach ($reg_city as $ciudad)
      @if ($ciudad->id==1)
      <option value="{{$ciudad->id}}" selected>{{$ciudad->name}}</option>      
      @else
      <option value="{{$ciudad->id}}">{{$ciudad->name}}</option>
      @endif
        
    @endforeach
    </select>
  </div>
   

</div>
<h3 style="padding-top: 20px">Datos de Coorporativos</h3>
<div class="col-4">
  
 
 
    <label for="type" class="col col-form-label">
      {{ __('Tipo') }}
    </label>
    <select class="form-select" id="type" name="type" aria-label="Default select example"  required>
      <option value="" selected>Seleccione un tipo</option>
      @foreach ($reg_types as $types)
        <option value='{{$types->id}}'>{{$types->name}}</option>   
      
      @endforeach
     
      
    </select>
 

</div>
<div class="col-4">

 
    <label for="branch" class="col col-form-label">
      {{ __('Sucursal') }}
    </label>
    <select class="form-select" id="branch" name="branch" aria-label="Default select example"  required>
      <option value="" selected>Seleccione un tipo</option>
      @foreach ($reg_branch as $sucursal)
        <option value='{{$sucursal->id}}'>{{$sucursal->name}}</option>   
      
      @endforeach
     
      
    </select>

</div>
<h3 style="padding-top: 20px">Datos de domicilio</h3>
      

<div class="table-responsive">
  <table class="table table-striped table-hover"  id="table">
    <thead class="thead">
      <tr>
        <th>Zona</th>
        <th>Calle</th>
        <th>Numero</th>
        <th>Datos adicionales</th>
      </tr>
    </thead>  
      <tbody >
        <tr>
          <td>
            <input class="form-control"  type="text" name="zone[]" placeholder="Zona donde vive" required>
          </td>
          <td>
            <input class="form-control" type="text" name="street[]" placeholder="Calle donde vive" required>
          </td>
          <td>
            <input class="form-control" type="text" name="number[]" placeholder="Numero de la casa" required>
          </td>
          <td>
            <input class="form-control" type="text" name="decriptionAddress[]" placeholder="Puede dejar en blanco esta parte tambien puede llenar datos como ser edificio, etc" >
          </td>
        </tr>
      </tbody>
  </table>
  <div class="form-group">
    <button type="button" class="btn btn-primary mb-2" onclick="agregarFila()" style="height: 35px;width: 35px;">+</button>
    <button type="button" class="btn btn-primary mb-2" onclick="eliminarFila(this)" style="height: 35px;width: 35px;">-</button>
  </div>
</div>
<h3>Datos telefono/celular</h3>
<div class="alert alert-warning" role="alert">
  <span>Recuerde para estos dos casos usar los siguientes codigos en la parte de numero de celular, para personas sin numero celular asignar el codigo "1010" y para menores de edad o estudiantes sin celular  usar el codigo "1000"</span>
</div> 

<div class="table-responsive">
  <table class="table table-striped table-hover"  id="table2">
    <thead class="thead">
      <tr>
        <th>Numero</th>
        <th>Descripción</th>
      </tr>
    </thead>  
      <tbody >
        <tr>
          <td>
            <input class="form-control" type="number" name="numberCell[]" placeholder="Celular" required>
          </td>
          <td>
            <input class="form-control" type="text" name="description[]" placeholder="Puede dejalo en blanco, tambien puede indicar Numero principal, observaciones">
          </td>
        </tr>
      </tbody>
  </table>

  <div class="form-group">
    <button type="button" class="btn btn-primary mb-2" onclick="agregarFilaT()" style="height: 35px;width: 35px;">+</button>
    <button type="button" class="btn btn-primary mb-2" onclick="eliminarFilaT(this)" style="height: 35px;width: 35px;">-</button>
  </div>
</div>
       
        <div class="form-group row d-flex justify-content-center " style="padding-top: 20px;padding-bottom: 10px;">
          <div class="col-md-10 d-flex justify-content-center">
            <button type="submit" class="btn btn-primary" id="botonSubir"  >
              {{ __('Regitrar') }}
            </button>
         
           


          </div>
        </div>
      </div>
    </div>
  </form>
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
  function calcularEdad() {
      const fechaNacimientoInput = document.getElementById('fecha_nac');
      const fechaNacimiento = new Date(fechaNacimientoInput.value);
      const ahora = new Date();
      const diferenciaMilisegundos = ahora - fechaNacimiento;
      const edad = new Date(diferenciaMilisegundos);
      const milisegundosEnAnio = 1000 * 60 * 60 * 24 * 365.25; // Consideramos años bisiestos
      const diferenciaAnios = diferenciaMilisegundos / milisegundosEnAnio;
      const añosEnteros = Math.floor(diferenciaAnios);
  
    document.getElementById('age').value = añosEnteros;
  }

</script>
<script>
  



        /* ********************** start nova alert ********************** */


        const novaAlert = function ({ icon = '', title = '', text = '', darkMode = false, showCancelButton = false, CancelButtonText = 'NO', ConfirmButtonText = 'Aceptar',ConfirmButtonText2 = 'Cancelar', dismissButton = true, input = false, inputPlaceholder = '' }) {


let modal = document.createElement('div');
modal.setAttribute('class', 'nova-modal');
document.body.append(modal);
let alert = document.createElement('div');
alert.setAttribute('class', 'nova-alert')

modal.appendChild(alert);
var svg;

if (darkMode == true) {
    alert.classList.add('nova-dark-mode');
}




if (icon == 'success') {
    svg = `<svg class="circular green-stroke">
        <circle class="path" cx="75" cy="75" r="50" fill="none" stroke-width="5" stroke-miterlimit="10"/>
    </svg>
    <svg class="checkmark green-stroke">
        <g transform="matrix(0.79961,8.65821e-32,8.39584e-32,0.79961,-489.57,-205.679)">
            <path class="checkmark__check" fill="none" d="M616.306,283.025L634.087,300.805L673.361,261.53"/>
        </g>
    </svg>`;
} else if (icon == 'danger') {
    svg = `<svg class="circular red-stroke">
        <circle class="path" cx="75" cy="75" r="50" fill="none" stroke-width="5" stroke-miterlimit="10"/>
    </svg>
    <svg class="cross red-stroke">
        <g transform="matrix(0.79961,8.65821e-32,8.39584e-32,0.79961,-502.652,-204.518)">
            <path class="first-line" d="M634.087,300.805L673.361,261.53" fill="none"/>
        </g>
        <g transform="matrix(-1.28587e-16,-0.79961,0.79961,-1.28587e-16,-204.752,543.031)">
            <path class="second-line" d="M634.087,300.805L673.361,261.53"/>
        </g>
    </svg>`;
} else if (icon == 'warning') {
    svg = `<svg class="circular yellow-stroke">
        <circle class="path" cx="75" cy="75" r="50" fill="none" stroke-width="5" stroke-miterlimit="10"/>
    </svg>
    <svg class="alert-sign yellow-stroke">
        <g transform="matrix(1,0,0,1,-615.516,-257.346)">
            <g transform="matrix(0.56541,-0.56541,0.56541,0.56541,93.7153,495.69)">
                <path class="line" d="M634.087,300.805L673.361,261.53" fill="none"/>
            </g>
            <g transform="matrix(2.27612,-2.46519e-32,0,2.27612,-792.339,-404.147)">
                <circle class="dot" cx="621.52" cy="316.126" r="1.318" />
            </g>
        </g>
    </svg>`;
} else {
    svg = '';
}
var icon_template = ` <div class="nova-icon">
   <div class="svg-box">
     ${svg}
   </div>
</div>`;
var title_and_text = `
<h3 class="nova-title">
  ${title}
</h3>
<p class="nova-text">
${text}
</p>
`;

if (showCancelButton == true) {
    var buttons =
        `
<div class="nova-btns">
<a class="accept">
  ${ConfirmButtonText}
</a>
<a class="reject">
${CancelButtonText}
</a>
</div>
`;
} else {
    var buttons =
        `
<div class="nova-btns">
<a class="accept">
${ConfirmButtonText}
</a>
</div>
`;
}
if (dismissButton == true) {

    var dismissButton = `<a class="dismissButton">
X
</a>`;
} else {
    var dismissButton = `<a class="dismissButton hidden">
X
</a>`;
}


if (input == true) {
    var __input = `<input class="nova-input-alert" placeholder='${inputPlaceholder}'>`;
} else {
    var __input = '';
}


var $content = icon_template + title_and_text + __input + buttons + dismissButton;






alert.innerHTML = $content;




document.querySelector('.nova-alert .reject  , .nova-alert .accept').onclick = closeNova;
document.querySelector('.dismissButton').onclick = closeNova;



function closeNova() {

    alert.remove();
    modal.remove();

}


this.then = function (callback) {


    document.querySelector('.nova-alert .accept').onclick = accept;

    function accept() {





        if (input == true) {


            var inputValue = document.querySelector('.nova-input-alert');
            var val = inputValue.value;
            closeNova();
            callback(e = true, val);

        } else {
            closeNova();
            callback(e = true);
        }



    }

    document.querySelector('.nova-alert .reject').onclick = reject;
    function reject() {
        closeNova();
        callback(e = false);
    }




}



}




/* ********************** end nova alert ********************** */

function alertaAceptar(){
  new novaAlert({
    icon: 'success',
    title: 'Registro de usario correcto',
    text: 'Precione el boton para continuar',
dismissButton: true,


ConfirmButtonText: 'Aceptar',

});
}
function alertaFallo(){
  new novaAlert({
    icon: 'danger',
    title: 'Registro no realizado',
    text: 'Precione el boton para continuar',
    dismissButton: false,

CancelButtonText: 'Aceptar',

});
}


</script>
<script>
  var miDiv = document.getElementById('miDiv');

      var status = "{{ session('status') }}";
      if (status === 'success') {
        alertaAceptar();
      } else if (status === 'error') {
        alertaFallo();
      }
 
</script>
<script>
  function agregarFila() {
    document.getElementById("table").insertRow(-1).innerHTML = ` <td>
            <input class="form-control"  type="text" name="zone[]" placeholder="Zona donde vive" required>
          </td>
          <td>
            <input class="form-control" type="text" name="street[]" placeholder="Calle donde vive" required>
          </td>
          <td>
            <input class="form-control" type="text" name="number[]" placeholder="Numero de la casa" required>
          </td>
          <td>
            <input class="form-control" type="text" name="decriptionAddress[]" placeholder="Puede dejar en blanco esta parte tambien puede llenar datos como ser edificio, etc" >
        </td>`;
  }
  function eliminarFila() {
    var table = document.getElementById("table").deleteRow(2);
  
  }

  
</script>
<script>
  function agregarFilaT() {
    document.getElementById("table2").insertRow(-1).innerHTML = `
    <td>
            <input class="form-control" type="number" name="numberCell[]" placeholder="Celular" required>
          </td>
          <td>
            <input class="form-control" type="text" name="description[]" placeholder="Puede dejalo en blanco, tambien puede indicar Numero principal, observaciones">
         </td>`;
  }
  function eliminarFilaT() {
    var table = document.getElementById("table2").deleteRow(2);
  
  }

  
</script>
@endsection

