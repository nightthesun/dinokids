@extends('layouts.app')

@section('template_title')
Historia
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div style="display: flex; justify-content: space-between; align-items: center;">

            <span id="card_title">
              {{ __('Historial') }}
            </span>

            <div class="float-right">
              <!-- <a href="{{ route('historias.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                {{ __('Create New') }}
              </a> -->
            </div>
            <div class="">
              <form class="d-flex gap-2" action="{{ route('historias.index') }}" method="">
                <select class="form-control" id="buscar" name="buscar">
                  <option value="1">Marca</option>
                  <option value="2">Modelo</option>
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

                  <th>Marca</th>
                  <th>Tipo</th>
                  <th>Modelo</th>
                  <th>Ns</th>
                  <th>Caracteristicas</th>
                  <th>Estado</th>
                  <th>Fecha de Registro</th>

                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($historias as $historia)
                <tr>
                  <td>{{ ++$i }}</td>

                  <td>{{ $historia->marca }}</td>
                  <td>{{ $historia->tipo }}</td>
                  <td>{{ $historia->modelo }}</td>
                  <td>{{ $historia->ns }}</td>
                  <td>{{ $historia->caracteristicas }}</td>
                  <td>{{ $historia->estado }}</td>
                  <td>{{ $historia->created_at }}</td>

                  <td>
                    <form action="{{ route('historias.destroy',$historia->id) }}" method="POST">
                      <!-- <a class="btn btn-sm btn-primary" href="{{ route('historias.show',$historia->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a> -->
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal{{ $historia->empleado->id }}"><i class="fa fa-fw fa-eye"></i></button>
                      <!-- <a class="btn btn-sm btn-success" href="{{ route('historias.edit',$historia->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a> -->
                      @csrf
                      @method('DELETE')
                      <!-- <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button> -->
                    </form>
                  </td>
                </tr>
                @include ('historia.myModal')
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      {!! $historias->links() !!}
    </div>
  </div>
</div>
@endsection
