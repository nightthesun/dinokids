@extends('layouts.app')
@section('static', 'statick-side')
@section('content')
@include('layouts.sidebar', ['hide'=>'1'])
<div class="container mb-5">
  <div class="row d-flex justify-content-center my-3">
    <div class="col-lg-6 col-sm-12 d-flex align-items-center justify-content-center">
      <h3 class="text-center text-primary">Registro de Perfil de Funcionario</h3>
    </div>
  </div>
  <form method="POST" enctype="multipart/form-data" action="{{ route('perfil.update', $perfil->id) }}">
    @csrf
    <input name="_method" type="hidden" value="PATCH">
    <div class="row">
      <div class="col-2">
        <div class="form-group row d-flex">
          <div class="col">
            <a id="elim_image" style="position: absolute; right:20px;cursor:pointer; font-size: 1.3rem; display: none;" class="text-danger"><i class="fas fa-times-circle"></i></a>
            @if($perfil->foto)
            <img alt="foto" id="output" class="img-fluid border border-primary rounded" src="{{ asset($perfil->foto) }}" />
            <input type="hidden" id="check_f" name="check_f" value="actual">
            @else
            <img alt="foto" id="output" class="img-fluid border border-primary rounded" src="{{asset('imagenes/log.png')}}" />
            <input type="hidden" id="check_f" name="check_f" value="false">
            @endif
          </div>
        </div>
        <div class="file-input row">
          <div class="col">
            <input type="file" accept="image/*" name="foto" id="foto" onchange="loadFile(event)" class="file-input__input" />
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

      <div class="col-10 border border-primary rounded p-4">
        <h3 class="mt-3">Datos Personales</h3>
        <div class="mb-2 row d-flex">
          <label for="nombre" class="col-md-2 col-form-label">
            {{ __('Nombres') }}
          </label>
          <div class="col-md-4">
            <input id="nombre" value="{{$perfil->nombre}}" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus>
            @error('nombre')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <label for="paterno" class="col-md-2 col-form-label">
            {{ __('Apellido Paterno') }}
          </label>
          <div class="col-md-4">
            <input id="paterno" value="{{$perfil->paterno}}" type="text" class="form-control @error('paterno') is-invalid @enderror" name="paterno" value="{{ old('paterno') }}" required autocomplete="paterno">
            @error('paterno')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>
        <div class="mb-2 row d-flex">
          <label for="materno" class="col-md-2 col-form-label">
            {{ __('Apellido Materno') }}
          </label>
          <div class="col-md-4">
            <input id="materno" type="text" value="{{$perfil->materno}}" class="form-control @error('materno') is-invalid @enderror" name="materno" value="{{ old('materno') }}" autocomplete="materno">
            @error('materno')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <label for="ci" class="col-md-2 col-form-label">{{ __('CI') }}</label>
          <div class="col-md-2">
            <input id="ci" type="ci" value="{{$perfil->ci}}" class="form-control @error('ci') is-invalid @enderror" name="ci" value="{{ old('ci') }}" autocomplete="ci">
            @error('ci')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="col-md-2 pl-0">
            <select name="ci_e" id="ci_e" class="form-control">
              <option value="LP" @if($perfil->ci_e=='LP') selected @endif>LP</option>
              <option value="OR" @if($perfil->ci_e=='OR') selected @endif>OR</option>
              <option value="CB" @if($perfil->ci_e=='CB') selected @endif>CB</option>
              <option value="CH" @if($perfil->ci_e=='CH') selected @endif>CH</option>
              <option value="PT" @if($perfil->ci_e=='PT') selected @endif>PT</option>
              <option value="TJ" @if($perfil->ci_e=='TJ') selected @endif>TJ</option>
              <option value="SC" @if($perfil->ci_e=='SC') selected @endif>SC</option>
              <option value="BE" @if($perfil->ci_e=='BE') selected @endif>BE</option>
              <option value="PD" @if($perfil->ci_e=='PD') selected @endif>PD</option>
              <option value="Otro" @if($perfil->ci_e=='Otro') selected @endif>Otro</option>
            </select>
          </div>
        </div>
        <div class="mb-2 row d-flex">
          <label for="fecha_nac" class="col-2 col-form-label">
            {{ __('Fecha de Nacimiento') }}
          </label>
          <div class="col-md-4">
            <input id="fecha_nac" value="{{$perfil->fecha_nac}}" type="date" class="form-control @error('fecha_nac') is-invalid @enderror" name="fecha_nac" value="{{ old('fecha_nac') }}" autocomplete="fecha_nac" autofocus>
            @error('fecha_nac')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>
        <h3>Datos de Coorporativos</h3>
        <div class="mb-2 row d-flex">
          <label for="rol" class="col-2 col-form-label">{{ __('Unidad') }}</label>
          <div class="col-md-4">
            <select name="unidad_id" id=unidad_id class="form-control">
              <option value="" disabled selected>Seleccione Unidad</option>
              @foreach(App\Unidad::orderBy('nombre')->get() as $u)
              <option value="{{$u->id}}" @if($u->id==$perfil->unidad_id) selected @endif>{{$u->nombre}}</option>
              @endforeach
            </select>
          </div>
          <label for="area_id" class="col-2 col-form-label">{{ __('Area') }}</label>
          <div class="col-md-4">
            <select name="area_id" id="area_id" class="form-control">
              <option value="" disabled selected>Seleccione Area</option>
              @foreach(App\Area::orderBy('nombre')->get() as $u)
              <option value="{{$u->id}}" @if($u->id==$perfil->area_id) selected @endif>{{$u->nombre}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="mb-2 row d-flex">
          <label for="cargo" class="col-2 col-form-label">{{ __('Cargo') }}</label>
          <div class="col-md-4">
            <select name="cargo" id="cargo" class="form-control">
              <option value="" disabled selected>Seleccione Cargo</option>
              @foreach($cargos as $c)
              
              <option value="{{ $c->NombreCargo}}"  @if($perfil->cargo == $c->NombreCargo)
              selected @endif>{{ $c->NombreCargo}}</option>
            
            @endforeach




             
          </div>
          <label for="corp_email" class="col-2 col-form-label">
            {{ __('Correo Coporativo') }}
          </label>
          <div class="col-md-4">
            <input id="corp_email" value="{{$perfil->corp_email}}" type="email" class="form-control @error('corp_email') is-invalid @enderror" name="corp_email" value="{{ old('corp_email') }}" autocomplete="corp_email" autofocus>
            @error('corp_email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>
        <div class="mb-2 row d-flex">
          <label for="corp_telf" class="col-2 col-form-label">{{ __('Telefono') }}</label>
          <div class="col-md-2">
            <input id="corp_telf" value="{{$perfil->corp_telf}}" type="text" class="form-control @error('corp_telf') is-invalid @enderror" name="corp_telf" value="{{ old('corp_telf') }}" autocomplete="corp_telf" autofocus>
            @error('corp_telf')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <label for="corp_int" class="col col-form-label" style="flex: 0 0 3.3333333333%; max-width: 3.3333333333%;">{{ __('Int.') }}</label>
          <div class="col" style="flex: 0 0 13.3333333333%; max-width: 13.3333333333%;">
            <input id="corp_int" value="{{$perfil->corp_int}}" type="text" class="form-control @error('corp_int') is-invalid @enderror" name="corp_int" value="{{ old('corp_int') }}" autocomplete="corp_int" autofocus>
            @error('corp_int')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <label for="corp_celu" class="col-2 col-form-label">{{ __('Numero Celular') }}</label>
          <div class="col-md-4">
            <input id="corp_celu" value="{{$perfil->corp_celu}}" type="text" class="form-control @error('corp_celu') is-invalid @enderror" name="corp_celu" value="{{ old('corp_celu') }}" autocomplete="corp_celu" autofocus>
            @error('corp_celu')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>
        <div class="mb-2 row d-flex">
          <label for="fecha_ingreso" class="col-2 col-form-label">{{ __('Fecha de Ingreso') }}</label>
          <div class="col-md-4">
            <input id="fecha_ingreso" value="{{$perfil->fecha_ingreso}}" type="date" class="form-control @error('fecha_ingreso') is-invalid @enderror" name="fecha_ingreso" value="{{ old('fecha_ingreso') }}" autocomplete="fecha_ingreso" autofocus>
            @error('fecha_ingreso')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          {{-- 
               <label for="dias_vacacion_
          tomadas" class="col-3 col-form-label">{{ __('Registrar Dias') }}</label>
          <div class="col-md-3">
            <input id="registrar_dias" value="" type="number" class="form-control @error('registrar_dias') is-invalid @enderror" name="registrar_dias" autocomplete="registrar_dias" autofocus>
            @error('registrar_dias')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
            --}}
       
        </div>
        <div class="mb-2 row d-flex">
          <label for="dias_vacacion" class="col-3 col-form-label">{{ __('Dias de Vacacion a la fecha') }}</label>
          <div class="col-md-3">
            <input id="dias_vacacion_a" style="border: none; outset:none; background-color: white" value="{{$perfil->dias_vacacion}}" type="number" class="form-control @error('dias_vacacion') is-invalid @enderror" value="{{ old('dias_vacacion') }}" autocomplete="dias_vacacion" disabled>
            <input id="dias_vacacion" value="{{$perfil->dias_vacacion}}" type="" class="form-control @error('dias_vacacion') is-invalid @enderror d-none" name="dias_vacacion" value="{{ old('dias_vacacion') }}" autocomplete="dias_vacacion" autofocus>
            @error('dias_vacacion')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>
        <div class="mb-2 row d-flex">
          <label for="dias_vacacion_
          tomadas" class="col-3 col-form-label">{{ __('Dias de Vacacion Tomadas') }} :</label>
          <div class="col-md-3">
            <input id="dias_vacacion_tomadas_a" style="border: none; outset:none; background-color: white" value="{{ $dias_tomados[0]->suma }}" type="number" class="form-control @error('dias_vacacion_tomadas') is-invalid @enderror" autocomplete="dias_vacacion_tomadas" autofocus disabled>
            <input id="dias_vacacion_tomadas" value="{{ $dias_tomados[0]->suma }}" type="number" class="form-control @error('dias_vacacion_tomadas') is-invalid @enderror d-none" name="dias_vacacion_tomadas" autocomplete="dias_vacacion_tomadas" autofocus>
            @error('dias_vacacion')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>
        <div class="mb-2 row d-flex">
          <label for="dias_vacacion_
          tomadas" class="col-3 col-form-label">{{ __('Saldo Dias de Vacacion') }}</label>
          <div class="col-md-3">
            <input id="saldo_dias_a" style="border: none; outset:none; background-color: white" value="" type="number" class="form-control @error('saldo_dias') is-invalid @enderror" autocomplete="saldo_dias" disabled>
            <input id="saldo_dias" value="" type="number" name="saldo_dias" class="form-control @error('saldo_dias') is-invalid @enderror d-none" autocomplete="saldo_dias">
            @error('saldo_dias')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>
        <h3>Datos de Contacto</h3>
        <div class="row">
          <div class="col-6">
            <div class="mb-2 row d-flex">
              <label for="telf" class="col-4 col-form-label">
                {{ __('Telefono') }}
              </label>
              <div class="col-md-8">
                <input id="telf" value="{{$perfil->telf}}" type="tel" class="form-control @error('telf') is-invalid @enderror" name="telf" value="{{ old('telf') }}" autocomplete="telf" autofocus>
                @error('telf')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="mb-2 row d-flex">
              <label for="direc" class="col-4 col-form-label">
                {{ __('Domicilio') }}
              </label>
              <div class="col-md-8">
                <input id="direc" type="text" value="{{$perfil->direc}}" class="form-control @error('direc') is-invalid @enderror" name="direc" value="{{ old('direc') }}" autocomplete="direc" autofocus>
                @error('direc')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="mb-2 row d-flex">
              <label for="celu" class="col-4 col-form-label">
                {{ __('Celular') }}
              </label>
              <div class="col-md-8">
                <input id="celu" type="tel" value="{{$perfil->celu}}" class="form-control @error('celu') is-invalid @enderror" name="celu" value="{{ old('celu') }}" autocomplete="celu" autofocus>
                @error('celu')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="mb-2 row d-flex">
              <label for="email" class="col-4 col-form-label">
                {{ __('Correo') }}
              </label>
              <div class="col-md-8">
                <input id="email" type="tel" value="{{$perfil->email}}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
          </div>
        </div>
        <div class="controles-form">
          <button type="submit" class="btn btn-primary btn-sm">
            Guardar <i class="fas fa-save"></i>
          </button>
        </div>
      </div>
    </div>
  </form>
</div>

@endsection
@section('mis_scripts')
<script src="http://momentjs.com/downloads/moment.min.js"></script>
<script>
  $(document).ready(function() {
    var foto = "{{$perfil->foto}}";
    if (foto !== "") {
      $("#elim_image").show();
    }
    var val1 = $("#dias_vacacion").val();
    var val2 = $("#dias_vacacion_tomadas").val();
    $("#saldo_dias_a").val(val1 - val2);
    $("#saldo_dias").val(Math.round(val1) - Math.round(val2));
  });
  var loadFile = function(event) {
    var image = document.getElementById('output');
    image.src = URL.createObjectURL(event.target.files[0]);
    var foto = $("#foto").val();
    $('#check_f').val('true');
    if (foto !== "") {
      $("#elim_image").show();
    }
  };
  $("#elim_image").click(function() {
    $("#foto").val('');
    $('#check_f').val('false');
    var image = document.getElementById('output');
    image.src = "{{asset('imagenes/log.jpg')}}";
    $("#elim_image").hide();
  });

  document.getElementById("fecha_ingreso").addEventListener("blur", function(e) {




//datos de entrada
var f1=365*4;
var f2=365*10;


// Crear una nueva instancia del objeto Date
var fechaActual = new Date();

// Obtener la fecha en formato legible para humanos
//var fechaEnTexto1 = fechaActual.toLocaleDateString();
var fechaEnTexto=fechaActual.toISOString().substring(0, 10);

var inputFecha = document.getElementById("fecha_ingreso");

// Obtener el valor del input
var valorFecha = inputFecha.value;

// Crear una instancia de Date utilizando el valor del input
var fecha = new Date(valorFecha);



// Definir las dos fechas
var fecha1 = new Date(fechaEnTexto);
var fecha2 = new Date(valorFecha);

// Restar las fechas en milisegundos y convertir el resultado en días
var resultadoEnDias = Math.round((fecha1.getTime() - fecha2.getTime()) / (1000 * 60 * 60 * 24));
console.log("La fecha de hoy es " + resultadoEnDias +" f1:" +f1);

if (resultadoEnDias >=f1) {
  if (resultadoEnDias >= f2) {
           $("#dias_vacacion_a").val(30);
    $("#dias_vacacion").val(30);
    console.log(dias_vacacion);
  } else {
   

    $("#dias_vacacion_a").val(20);
    $("#dias_vacacion").val(20);
    console.log(dias_vacacion);
  }
} 
else{
    if (resultadoEnDias>=365) {
      $("#dias_vacacion_a").val(15);
    $("#dias_vacacion").val(15);
    console.log(dias_vacacion);
   
    } else {
      $("#dias_vacacion_a").val(0);
    $("#dias_vacacion").val(0);
    console.log(dias_vacacion);
   
    }
  
}




  });
</script>
@endsection