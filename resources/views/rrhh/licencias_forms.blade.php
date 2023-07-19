@extends('layouts.app')
@section('title', 'Inicio')
@section('content') 
  <div class="row d-flex justify-content-center py-4 w-100">
    <div class="container border rounded col-10 bg-light p-4">
    
          <div class="row p-2">
            <div class="col-12"><h3>LICENCIAS</h3></div>
          </div>
          <div class="row pb-4">
            <div class="col">
            </div>
            <div class="col-10 col-sm-9 col-md-7 d-sm-flex justify-content-end">
                <form class="form-inline" action="{{action('UsuarioController@index')}}" method="GET">
                  <select class="form-control mr-sm-2 col-5 col-sm-auto" id="buscar" name="buscar">
                    <option value="1">Nombre</option>
                    <option value="2">CI</option>
                  </select>
                  <input id="busca" name="busca" class="form-control col-4 col-sm-auto ml-auto"type="search" placeholder="Buscar" aria-label="Search">
                  <button class="form-control btn btn-primary col-4 col-sm-auto ml-auto ml-sm-2 d-none d-sm-block" type="submit">Buscar</button>
                </form>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover table-primary" >
             <thead>
                <th>Nombre del solicitante</th>
                <th>CI</th>
                <th>FECHA</th>
                <th>TIPO</th>
                <th>ESTADO</th>
                <th>OPCIONES</th>
             </thead>
             <tbody>
              @if($forms->count())
              @foreach($forms as $f)
              <tr>
                <td>{{$f->user->nombre}} {{$f->user->paterno}} {{$f->user->materno}}</td>
                <td>{{$f->user->ci}}</td>
                <td>{{$f->fecha}}</td>
                <td>{{$f->tipo}}</td>
                <td>{{$f->val==2}}</td>
                <td><a class="btn btn-primary btn-xs" href="{{action('LicenciaController@edit', $f->id)}}" ><span class="glyphicon glyphicon-pencil">Detalle</span></a></td>
               </tr>
               @endforeach
               @else
               <tr>
                <td>No hay registro !!</td>
              </tr>
              @endif
            </tbody>
          </table>
          {{ $forms->links() }}
        </div>
            
    </div>          
  </div>

@endsection
