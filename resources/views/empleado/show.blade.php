@extends('layouts.app')
@section('title', 'Inicio')
@section('static', 'statick-side')
@section('content')
@include('layouts.sidebar', ['hide'=>'1']) 
<section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          {{-- <div class="float-left">
            <span class="card-title">Show Empleado</span>
          </div> --}}
          <div class="float-right">
            <a class="btn btn-primary" href="{{ route('empleados.index') }}"> Atras</a>
          </div>
        </div>
        <div class="d-flex justify-content-between">
          <div class="card-body">
            <div class="form-group">
              <strong>Nombre:</strong>
              {{ $empleado->nombre }}
            </div>
            <div class="form-group">
              <strong>Paterno:</strong>
              {{ $empleado->paterno }}
            </div>
            <div class="form-group">
              <strong>Materno:</strong>
              {{ $empleado->materno }}
            </div>
            <div class="form-group">
              <strong>C.I.:</strong>
              {{ $empleado->ci }}
            </div>
            <div class="form-group">
              <strong>Area:</strong>
              area
            </div>
            <div class="form-group">
              <strong>Cargo:</strong>
              {{ $empleado->cargo }}
            </div>
            <div class="form-group">
              <strong>Sucursal:</strong>
              {{ $empleado->unidad->nombre }}
            </div>
            {{-- <a class="btn btn-sm btn-success" href="{{ route('empleados.edit',$empleado->id) }}"><i class="fas fa-user-edit"></i></a> --}}
          </div>
          <div class="visible-print text-center">
              {!!
                QrCode::
                    //format('png')->
                    size(200)  //defino el tamaño
                    //->backgroundColor(250, 240, 215) //defino el fondo
                    ->color(0, 0, 0)
                    ->margin(1)  //defino el margen
                    ->generate($qr) /** genero el codigo qr **/
              !!}
          </div>
        </div>
        <div class="card-body">
          <h3>Ordenadores</h3>
          <div class="cpu w-50">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead class="thead">
                  <tr>
                    <th>Tipo</th>
                    <th>IP</th>
                    <th>Estado</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($cpus as $cpu)
                      <tr>
                        <td>{{ $cpu->tipo }}</td>
                        <td>{{ $cpu->ip }}</td>
                        <td>{{ $cpu->estado }}</td>
                        <td>
                          <form action="" method="POST">
                            {{-- <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#myModal4{{ $cpu->id }}"><i class="fa fa-fw fa-eye"></i></button> --}}
                            <a href="{{ route('componentes.show', $cpu->id) }}" class="btn btn-secondary btn-sm"><i class="fa fa-fw fa-eye"></i></a>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#myModal3{{ $cpu->id }}"><i class="fas fa-exchange-alt"></i></button>
                            {{-- <a class="btn btn-sm btn-success" href=""><i class="fas fa-edit"></i></a> --}}
                            @csrf
                            @method('DELETE')
                            {{-- <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i></button> --}}
                          </form>
                        </td>
                      </tr>
                      @include ('empleado.myModal3')
                  @endforeach 
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="card-body">
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#myModal2{{ $empleado->id }}">Crear Ordenador</button>
        </div>
        @include ('empleado.myModal2')
        <div class="card-body">
          <h3>Otros</h3>
          @if ($count > 0)
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="thead">
                <tr>
                  <th>Marca</th>
                  <th>Tipo</th>
                  <th>Modelo</th>
                  <th>Ns</th>
                  <th>Caracteristicas</th>
                  <th>Estado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($equipos as $equipo)
                  <tr>
                    <td>{{ $equipo->marca }}</td>
                    <td>{{ $equipo->tipo }}</td>
                    <td>{{ $equipo->modelo }}</td>
                    <td>{{ $equipo->ns }}</td>
                    <td>{{ $equipo->caracteristicas }}</td>
                    <td>{{ $equipo->estado }}</td>
                    <td>
                      <form action="{{ route('equipos.destroy',$equipo->id) }}" method="POST">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#myModal{{ $equipo->id }}"><i class="fas fa-exchange-alt"></i></button>
                        <a class="btn btn-sm btn-success" href="{{ route('equipos.edit',$equipo->id) }}"><i class="fas fa-edit"></i></a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i></button>
                      </form>
                    </td>
                  </tr>
                  @include ('empleado.myModal')
                @endforeach
              </tbody>
            </table>
            <a href="{{ route('equipos.creates',$empleado->id) }}" class="btn btn-primary btn-sm float-right" data-placement="left">
              {{ __('Crear Nuevo') }}
            </a>
          </div>
          @else
          <h3>Sin registro de equipos</h3>
          <a href="{{ route('equipos.creates',$empleado->id) }}" class="btn btn-primary btn-sm float-right" data-placement="left">
            {{ __('Crear Nuevo') }}
          </a>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
