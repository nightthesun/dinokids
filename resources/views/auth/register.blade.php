@extends('layouts.app')
@section('static', 'statick-side')
@section('estilo')
 
@endsection

@section('content')
@include('layouts.sidebar', ['hide'=>'1']) 
<form method="POST" enctype="multipart/form-data" action="{{ route('usuario.store', $perfil->id) }}">
    @csrf
    <input name="_method" type="hidden" value="PATCH">    
    <div class="container p-4">
        <div class="row">                                     
            <div class="col-4">
                <h5>{{"Funcionario ".$perfil->paterno. " ".$perfil->nombre}}</h5>
                <div class="row d-flex mb-2">
                    <label for="name" class="col-sm-5 col-form-label col-form-label-sm text-left">
                        Nombre de Usuario:
                    </label>
                    <div class="col-md-7">
                        <input id="name" type="text" value="{{$perfil->ci}}" class="form-control form-control-sm  @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
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
                            <option value = "{{null}}" selected>
                                SELECCIONAR
                            </option>                            
                            @foreach($dbiz_usr as $u)
                                <option value = "{{$u->adusrCusr}}">
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
                                                            <input type="checkbox" class="form-check-input" id="permiso[]" name="permiso[]" value="G{{$prog->id}}.{{$perm->id}}">
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
        </div>
    </div>
</form>

@endsection
@section('mis_scripts')
<script>
var loadFile = function(event) {
	var image = document.getElementById('output');
	image.src = URL.createObjectURL(event.target.files[0]);  
};
</script>
@endsection