@extends('layouts.app')
@section('static', 'statick-side')
@section('estilo')
 
@endsection

@section('content')
@include('layouts.sidebar', ['hide'=>'1']) 
<form method="POST" enctype="multipart/form-data" action="{{ route('usuario.update', $usuario->id) }}">
    @csrf
    <input name="_method" type="hidden" value="PATCH">    
    <div class="container p-4">
        <div class="row">                                     
            <div class="col-4">
                <h5>{{"Funcionario ".$usuario->perfiles->paterno. " ".$usuario->perfiles->nombre}}</h5>
                <div class="row d-flex mb-2">
                    <label for="name" class="col-sm-5 col-form-label col-form-label-sm text-left">
                        Nombre de Usuario:
                    </label>
                    <div class="col-md-7">
                        <input id="name" type="text" value="{{$usuario->name}}" class="form-control form-control-sm  @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row d-flex">
                    <label for="name" class="col-sm-5 col-form-label col-form-label-sm text-left">
                        Usuario DualbizERP:
                    </label>
                    <div class="col-md-7">
                        <select name="dbiz_user" id="dbiz_user" class="form-control form-control-sm">
                            
                            <option value = "{{null}}"  
                            @if(!$usuario->dbiz_user) selected @endif>
                                NINGUNO
                            </option>                            
                            @foreach($dbiz_usr as $u)
                                <option value = "{{$u->adusrCusr}}" 
                                @if($usuario->dbiz_user == $u->adusrCusr) selected @endif>
                                    {{$u->adusrNomb}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-8 border border-primary rounded">
                <div class="container py-3">
                    <h3 class="text-center">Permisos</h3>
                    <div class="row col">
                        <ul class="nav nav-pills mb-3 mt-4" id="pills-tab" role="tablist">
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
                                                    <h6 class='ml-3 text-primary'><b>{{($prog->nombre)}}</b></h6>
                                                </div>
                                                @foreach($prog->permisos as $perm)
                                                <div class="form-group row">
                                                    <div class="col">
                                                        <div class="ml-3 form-check">                        
                                                            <input type="checkbox" class="form-check-input" id="permiso[]" name="permiso[]" value="G{{$prog->id}}.{{$perm->id}}" 
                                                            @if(App\Acceso::where('user_id', $usuario->id)
                                                            ->where('program_id', $prog->id)
                                                            ->where('permiso_id',$perm->id)->first()
                                                            ) checked @endif>
                                                            <label class="form-check-label" for="exampleCheck1"> 
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
        <div class="controles-form">
            <button type="submit" class="btn btn-primary btn-sm">
                Guardar <i class="fas fa-save"></i>
            </button>
            <button type="button" class="btn btn-danger btn-sm text-white" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Resetear Contraseña <i class="fas fa-key"></i>
            </button>
        </div>
    </div>
</form>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Resetear Contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Se cambiar la contraseña del usuario 
        {{$usuario->perfiles->paterno}} {{$usuario->perfiles->materno}} {{$usuario->perfiles->nombre}}
        con nombre de usuario {{$usuario->name}}. La nueva contraseña sera "123".
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
        <form method="POST" enctype="multipart/form-data" action="{{ route('usuario.reset', $usuario->id) }}">
             @csrf
            <button type="submit" class="btn btn-danger text-white">Resetear <i class="fas fa-key"></i></button>
        </form>
       </div>
    </div>
  </div>
</div>
@endsection
@section('mis_scripts')
<script>
var loadFile = function(event) {
	var image = document.getElementById('output');
	image.src = URL.createObjectURL(event.target.files[0]);  
};
</script>
@endsection
