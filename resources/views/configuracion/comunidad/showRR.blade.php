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


.message-container {
            text-align: center;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

</style> 

@endsection

@section('content')
@include('layouts.sidebar', ['hide'=>'0'])
@if(Auth::user()->authorizepermisos(['Relacion', 'Ver']))
    <!-- Mostrar mensaje de éxito -->
<div id="miDiv"></div>
<div style="padding: 6rem; padding-top:0.5rem;">
  <div class="row d-flex justify-content-center mb-3">
    <div class="col-lg-6 col-sm-12 d-flex align-items-center justify-content-center">
      <h3 class="text-center titulo1">Vista de relacion</h3>
      <a href="{{ url('/') }}">
        <button type="button" class="btn btn-primary align-self-end" id="botonSalir"  data-bs-toggle="tooltip" data-bs-placement="right" title="Regresar al inicio" >
            <i class="fas fa-house-user"></i>
          </button> 
      </a>
      <a href="{{ route('relacion.index') }}">
        <button type="button" class="btn btn-primary align-self-end" id="botonSalir"  data-bs-toggle="tooltip" data-bs-placement="right" title="volver a lista" >
          <i class="far fa-address-book"></i>
          </button> 
      </a>
    </div>
  </div>
  
<h3>Tutor principal: {{$tutor[0]->first_name." ".$tutor[0]->last_name1." ".$tutor[0]->last_name2}}</h3>

<h4>Codigo: {{$tutor[0]->relationship}}</h4>
    <div class="row">
      

      <div class="col-12 borde1">
        <h3 class="mt-3">Datos de grupo tutor</h3>
        <div class="form-group row d-flex">

<div class="row">
  
  @foreach ($relacion as $key => $item)
      
  

  <div class="col">
    <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
        <div class="card-header">{{$item->parentesco}}</div>
        <div class="card-body">
          <h5 class="card-title">{{$item->first_name}}</h5>
          <p class="card-text">{{$item->last_name1." ".$item->last_name2}}.</p>
        </div>
      </div>
   </div>
 @endforeach

</div>

<div class="row">
    <h3 class="mt-3">Datos de estudiante</h3>
   @foreach ($estudiante as $key => $item)
          
   
        <div class="col">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">Estudiante</div>
                <div class="card-body">
                  <h5 class="card-title">{{$item->first_name}}</h5>
                  <p class="card-text">{{$item->last_name1." ".$item->last_name2}}.</p>
                </div>
              </div>
        </div>
        @endforeach
</div>


 
      </div>
    </div>
  
</div>
@else
<div class="message-container">
  <h1>Sin Permisos</h1>
  <p>Lo siento, no tienes permisos para acceder a esta página.</p>
</div>
@endif






@endsection
@section('mis_scripts')
<script src="http://momentjs.com/downloads/moment.min.js"></script>

@endsection

