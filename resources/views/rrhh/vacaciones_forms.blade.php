@extends('layouts.app')
@section('title', 'Inicio')
@section('content') 
  <div class="row d-flex justify-content-center py-4 w-100">
    <div class="container border rounded col-10 bg-light p-4">
    
          <div class="row p-2">
            <div class="col-12">
              <h4>VACACIONES 
                <a href="{{ route('vacacion.create') }}" >
                  <i class="fas fa-plus"></i>
                </a>
              </h4>   
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover table-primary" >
             <thead>
                <th>Nombre del solicitante</th>
                <th>CI</th>
                <th>FECHA Y HORA</th>
                <th>ESTADO</th>
                <th>OPCIONES</th>
             </thead>
             <tbody>
              @if($forms->count())
              @foreach($forms as $f)
              <tr>
                <td>{{$f->user->nombre}} {{$f->user->paterno}} {{$f->user->materno}}</td>
                <td>{{$f->user->ci}}</td>
                <td>{{$f->created_at}}</td>
                <td></td>
                <td><a class="btn btn-primary btn-xs" href="{{action('VacacionController@edit', $f->id)}}" ><span class="glyphicon glyphicon-pencil">Detalle</span></a></td>
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
