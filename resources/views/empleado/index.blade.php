@extends('layouts.app')
@section('title', 'Inicio')
@section('static', 'statick-side')
@section('content')
@include('layouts.sidebar', ['hide'=>'1']) 
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">

            <span id="card_title">
              {{ __('Empleado') }}
            </span>

            {{-- <div class="float-right">
              <a href="{{ route('equipos.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                {{ __('Crear Nuevo') }}
              </a>
            </div> --}}
            <div class="">
              <form class="d-flex gap-2" action="{{ route('empleados.index') }}" method="">
                <select class="form-control" id="buscar" name="buscar">
                  <option value="1">Nombre</option>
                  <option value="2">CI</option>
                </select>
                <input id="dato" name="dato" class="form-control" type="search" placeholder="Buscar" aria-label="Search">
                <button class="btn btn-primary" type="submit">Buscar</button>
              </form>
            </div>
          </div>
        </div>
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
        @endif
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="thead">
                <tr>
                  <th>No</th>
                  <th>Nombre</th>
                  <th>Paterno</th>
                  <th>Materno</th>
                  <th>C.I.</th>
                  <th>Cargo</th>
                  <th>Area</th>
                  <th>Unidad</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($empleados as $empleado)
                <tr>
                  <td>{{ ++$i }}</td>
                  <td>{{ $empleado->nombre }}</td>
                  <td>{{ $empleado->paterno }}</td>
                  <td>{{ $empleado->materno }}</td>
                  <td>{{ $empleado->ci }}</td>
                  <td>{{ $empleado->cargo }}</td>
                  <td>Area</td>
                  <td>{{ $empleado->unidad->nombre }}</td>
                  <td>
                    <form action="{{ route('empleados.destroy',$empleado->id) }}" method="POST">
                      <a class="btn btn-sm btn-primary " href="{{ route('empleados.show',$empleado->id) }}"><i class="fa fa-fw fa-eye"></i></a>
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i></button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      {!! $empleados->links() !!}
    </div>
  </div>
</div>
@endsection
