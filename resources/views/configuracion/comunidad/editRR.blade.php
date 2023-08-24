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
.borde2 {
  border-width: 1px;
  border-style: solid;
  border-color: #8092a1;
  border-radius: 0px;
  
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
@if(Auth::user()->authorizepermisos(['Relacion', 'Ver']) && Auth::user()->authorizepermisos(['Relacion', 'Editar']) )
    <!-- Mostrar mensaje de éxito -->
<div id="miDiv"></div>
<div style="padding: 6rem; padding-top:0.5rem;">
  <div class="row d-flex justify-content-center mb-3">
    <div class="col-lg-6 col-sm-12 d-flex align-items-center justify-content-center">
      <h3 class="text-center titulo1">Editar parentesco</h3>
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
  <form method="POST" enctype="multipart/form-data" action="{{ route('relacion.update',$principalsEdit[0]->idRR) }}">
    @method('PUT')
    @csrf

    <input name="_method" type="hidden" value="PATCH">
    <div class="row">
      

      <div class="col-12 borde1">
        
        
        <div class="form-group row d-flex">


<h3 style="padding-top: 10px">Datos de relación</h3>
<h4>Ficha anterior</h4>
<div class="row">
    <div class="col-6">
        <div class="card border-secondary mb-3" style="max-width: 18rem;">
            <div class="card-header">Tutor</div>
            <div class="card-body text-secondary">
            
              @foreach ($id_tutors as $item)
              <p class="card-text">- {{$item->first_name." ".$item->last_name1." ".$item->last_name2}}.</p> 
              @endforeach
              
            </div>
          </div>
    </div>
    <div class="col-6">
        <div class="card border-secondary mb-3" style="max-width: 18rem;">
            @if ($tamañoE==1)
            <div class="card-header">Estudiante</div>
            @else
            <div class="card-header">Estudiantes</div>
            @endif
            <div class="card-body text-secondary">
              @foreach ($id_students as $item)
              <p class="card-text">- {{$item->first_name." ".$item->last_name1." ".$item->last_name2}}.</p> 
              @endforeach
                
            </div>
          </div>
    </div>
</div>
<div class="container" style="padding-top: 10px">
    <div class="row">
        <div class="col-6 borde2">
            <h4 style="padding-top: 10px">Tutores</h4>
            <table class="cell-border compact hover" id="myTable2" style="width:100%;" >
                <thead>
                  <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>CI</th>
                    <th>Parentesco</th>
                    <th>Tutor Principal</th>
                     
                            
                  </tr>
                </thead>
                <tbody>
                 
                 @if (count($reg_tutors))
                 @foreach ($reg_tutors as $p)
                 
                <tr>
                   <td>
                 
                    <div class="form-check">
                        @if ($p->id_people==$principalsEdit[0]->id_tutor)
                        <input class="tutor-check-input" type="checkbox" value="{{$p->id_people}}" id="{{$p->id_people}}" name="tutor[]" checked> 
                        @else
                            @if (($p->id_people==$principalsEdit[1]->id_tutor))
                                <input class="tutor-check-input" type="checkbox" value="{{$p->id_people}}" id="{{$p->id_people}}" name="tutor[]" checked> 
                            @else
                                @if (($p->id_people==$principalsEdit[2]->id_tutor))
                                <input class="tutor-check-input" type="checkbox" value="{{$p->id_people}}" id="{{$p->id_people}}" name="tutor[]" checked>
                                @else
                                <input class="tutor-check-input" type="checkbox" value="{{$p->id_people}}" id="{{$p->id_people}}" name="tutor[]" >   
                                @endif
                            @endif
                        
                        @endif
                    </div>
                </td>
                   <td class="studentCheckbox">{{$p->first_name." ".$p->last_name1." ".$p->last_name2}}</td>
                   <td class="studentCheckbox">{{$p->ci}}</td> 
                   <td class="studentCheckbox">{{$p->parentesco}}</td>
                   <td>
                    <div class="form-check">
                        @if ($p->id_people==$principalsEdit[0]->id_Principal)
                        <input class="form-check-input" type="radio" value="{{$p->id_people}}" name="principal" id="principal" checked required > 
                        @else
                        <input class="form-check-input" type="radio" value="{{$p->id_people}}" name="principal" id="principal"required > 
                        @endif
                     </div>
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
      </div>
      
      <div class="col-6 borde2">
        <h4 style="padding-top: 10px">Estudiantes</h4>
            <table class="cell-border compact hover" id="myTable" style="width:100%;" >
                <thead>
                  <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Edad</th>
                  </tr>
                </thead>
                <tbody>
                 @if (count($reg_students))
                 @for ($i = 0; $i < $tamañoE; $i++)
                     
                 
                 @foreach ($reg_students as $p)
                    @if ($id_students[$i]->id==$p->id_student)
                    <tr>
                        <td>
                         <div class="form-check">
     
                         <input class="student-check-input" type="checkbox" value="{{$p->id_student}}" id="{{$p->id_student}}"  name="estudiante[]" checked>
                         
                       </div>
                     </td>
                        <td>{{$p->first_name." ".$p->last_name1." ".$p->last_name2}}</td>
                        <td>{{$p->age}}</td>
                        
                     </tr>
                    @else
                    <tr>
                     
                        <td>
                         <div class="form-check">
     
                         <input class="student-check-input" type="checkbox" value="{{$p->id_student}}" id="{{$p->id_student}}"  name="estudiante[]">
                         
                       </div>
                     </td>
                        <td>{{$p->first_name." ".$p->last_name1." ".$p->last_name2}}</td>
                        <td>{{$p->age}}</td>
                        
                     </tr>
                    @endif
                  @endforeach
              @endfor
                 @else
                 <tr>
                  <td>No hay registro !!</td>
                </tr> 
                 @endif
                </tbody>  
              </table>
      </div>
      
    </div>
  </div>


  <div class="alert alert-info" role="alert">
    Recuerde que solo puede marcar 3 tutores como maximo.
  </div>

  

   
  <div class="container" style="padding-bottom: 10px">
    <div class="row">
      <div class="col-6">
        
        <h5 style="padding-top: 10px">Tutores para selecciónar:</h5>
  <div id="selectedTutorsContainer" ></div>
  
  <table id="selectedTutors" hidden>
      <tbody>
        </tbody>
      </table>
  
      </div>
      <div class="col-6">
        <h5 style="padding-top: 10px">Estudiantes Seleccionados</h5>
        <div id="selectedStudentsContainer" ></div>
        <table id="selectedStudents" hidden>
            <tbody>
            </tbody>
        </table>
      </div>
      <br>
    <hr style="padding-top: 2px">
      <div class="mb-3">
       
        <label for="observacion" class="col col-form-label">
          {{ __('Observación:') }}
  </label>
          <input id="observacion" type="text" value="{{$principalsEdit[0]->observation}}" class="form-control @error('observacion') is-invalid @enderror" name="observacion" value="{{ old('observacion') }}" >
          @error('observacion')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>  
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
  </div>


  </form>
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
            
                { width:"10%", "targets": 0 }
            ],
     
            "paging": false,
            "order": [[0, 'asc']],
            "aoColumnDefs": [
      { "bSortable": false, "aTargets": [0] } // Deshabilitar la ordenación en la columna de checks
    ],
    "orderMulti": false, // Evitar la ordenación múltiple
    "fnDrawCallback": function() {
      $('#myTable tbody tr').sort(function(a, b) {
        var checkA = $('input[type="checkbox"]', a).prop('checked');
        var checkB = $('input[type="checkbox"]', b).prop('checked');
        return checkA === checkB ? 0 : (checkA ? -1 : 1);
      }).appendTo('#myTable tbody');
    },
 
                "scrollX":true,
                "scrollY": "150px",
                "scrollCollapse": true, 
                "FixedHeader":true,
          
        } );
    } );
    
    </script>
    <script>
        $(document).ready(function() 
        {  
            $('#myTable2 tfoot th').each( function () {
                if($(this).attr("class")!="#N/A")
                {
                  var title = $(this).text();
                  $(this).html( '<input type="text" placeholder="'+title+'" />' );
                }
            } );
            var table = $('#myTable2').DataTable( 
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
                    { width:"10%", "targets": 0 }
                ],
                "paging": false,
            "order": [[0, 'asc']],
            "aoColumnDefs": [
      { "bSortable": false, "aTargets": [0] } // Deshabilitar la ordenación en la columna de checks
    ],
    "orderMulti": false, // Evitar la ordenación múltiple
    "fnDrawCallback": function() {
      $('#myTable2 tbody tr').sort(function(a, b) {
        var checkA = $('input[type="checkbox"]', a).prop('checked');
        var checkB = $('input[type="checkbox"]', b).prop('checked');
        return checkA === checkB ? 0 : (checkA ? -1 : 1);
      }).appendTo('#myTable2 tbody');
    },
                "paging": false,
                   
                "scrollX":true,
                "scrollY": "150px",
                "scrollCollapse": true, 
                "FixedHeader":true,
              
            } );
        } );
        
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
    title: 'Registro de correcto',
    text: 'Precione el boton para continuar',
dismissButton: true,


ConfirmButtonText: 'Aceptar',

});
}
function alertaFallo(){
  new novaAlert({
    icon: 'danger',
    title: 'Registro no realizado ',
    text: 'Contactese al administrador error de base de datos 1000, precione para continuar',
    dismissButton: false,

CancelButtonText: 'Aceptar',

});
}

function alertaFallo1(){
  new novaAlert({
    icon: 'danger',
    title: 'El ingreso de menos o mas tutores',
    text: 'Como maximo y minimo tiene que ser 3 aprete el boton para continuar.',
    dismissButton: false,

CancelButtonText: 'Aceptar',

});
}
function alertaFallo2(){
  new novaAlert({
    icon: 'danger',
    title: 'No ingreso tutores',
    text: 'Debe ingresar como maximo 3 grupos.',
    dismissButton: false,

CancelButtonText: 'Aceptar',

});
}

function alertaFallo3(){
  new novaAlert({
    icon: 'danger',
    title: 'No ingreso estudiantes',
    text: 'Debe ingresar por lo menos uno.',
    dismissButton: false,

CancelButtonText: 'Aceptar',

});
}

function alertaFallo4(){
  new novaAlert({
    icon: 'danger',
    title: 'No escogio al tutor principal',
    text: 'Debe estar en mismog grupo.',
    dismissButton: false,

CancelButtonText: 'Aceptar',

});
}

function alertaFallo5(){
  new novaAlert({
    icon: 'danger',
    title: 'El tutor no esta en grupo',
    text: 'Debe escoger el tutor del mismo grupo',
    dismissButton: false,

CancelButtonText: 'Aceptar',

});
}

function alertaFallo6(){
  new novaAlert({
    icon: 'danger',
    title: 'Codigo repetido',
    text: 'Vuelva a ingresa todo de nuevo.',
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
      } 
      if (status === 'error') {
        alertaFallo();
      }
      if (status === 'error1') {
        alertaFallo1();
      }
      if (status === 'error2') {
        alertaFallo2();
      }
      if (status === 'error3') {
        alertaFallo3();
      }
      if (status === 'error4') {
        alertaFallo4();
      }
      if (status === 'error5') {
        alertaFallo5();
      }
      if (status === 'error6') {
        alertaFallo6();
      }
</script>

    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const tutorCheckboxes = document.querySelectorAll('.tutor-check-input');
        const studentCheckboxes = document.querySelectorAll('.student-check-input');
    
        const selectedTutorsContainer = document.getElementById('selectedTutorsContainer');
        const selectedStudentsContainer = document.getElementById('selectedStudentsContainer');
    
        const selectedTutorsTable = document.getElementById('selectedTutors').getElementsByTagName('tbody')[0];
        const selectedStudentsTable = document.getElementById('selectedStudents').getElementsByTagName('tbody')[0];
    
        let selectedTutors =  <?php echo $tamañoT; ?>;
        let selectedStudents = 0;
    
        tutorCheckboxes.forEach(checkbox => {
          
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    if (selectedTutors < 3) {
                        selectedTutors++;
                        const row = this.parentNode.parentNode.parentNode;
                        const cells = row.cells;
                        const tutorName = cells[1].textContent.trim();
    
                        const selectedInfo = `Tutor: ${tutorName}`;
                        selectedTutorsContainer.textContent = selectedInfo;
    
                        const newRow = selectedTutorsTable.insertRow();
                        const cell1 = newRow.insertCell(0);
                        cell1.textContent = tutorName;
                    } else {
                        this.checked = false;
                    }
                } else {
                    selectedTutors--;
                    selectedTutorsContainer.textContent = '';
    
                    selectedTutorsTable.deleteRow(selectedTutorsTable.rows.length - 1);
                }
            });
        });
       
        studentCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    if (selectedStudents < 10) {
                        selectedStudents++;
                        const row = this.parentNode.parentNode.parentNode;
                        const cells = row.cells;
                        const studentName = cells[1].textContent.trim();
    
                        const selectedInfo = `Estudiante: ${studentName}`;
                        selectedStudentsContainer.textContent = selectedInfo;
    
                        const newRow = selectedStudentsTable.insertRow();
                        const cell1 = newRow.insertCell(0);
                        cell1.textContent = studentName;
                    } else {
                        this.checked = false;
                    }
                } else {
                    selectedStudents--;
                    selectedStudentsContainer.textContent = '';
    
                    selectedStudentsTable.deleteRow(selectedStudentsTable.rows.length - 1);
                }
            });
        });
        
      });
    </script>


@endsection

