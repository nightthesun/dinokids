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
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('empleados.show', $computadoras->id_empleado) }}">Atras</a>
                        </div>
                    </div>
                    <div class="card-body">
                      <h3>Componentes</h3>
                      <div class="cpu w-50">
                        <div class="table-responsive">
                          <table class="table table-striped table-hover">
                            <thead class="thead">
                              <tr>
                                <th>Tipo</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Caracteristicas</th>
                                <th>Estado</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              @if ($componentes != null)
                              @foreach ($componentes as $componente)
                                  <tr>
                                    <td>{{ $componente->tipo }}</td>
                                    <td>{{ $componente->marca }}</td>
                                    <td>{{ $componente->modelo }}</td>
                                    <td>{{ $componente->caracteristicas }}</td>
                                    <td>{{ $componente->estado }}</td>
                                  </tr>
                              @endforeach 
                              @endif
                            </tbody>
                          </table>
                        </div>
                      </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
