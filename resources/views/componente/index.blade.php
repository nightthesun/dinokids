@extends('layouts.app')

@section('template_title')
    Componente
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Componente') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('componentes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
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
                                        
										<th>Tipo</th>
										<th>Marca</th>
										<th>Modelo</th>
										<th>Caracteristicas</th>
										<th>Estado</th>
										<th>Id Compu</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($componentes as $componente)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $componente->tipo }}</td>
											<td>{{ $componente->marca }}</td>
											<td>{{ $componente->modelo }}</td>
											<td>{{ $componente->caracteristicas }}</td>
											<td>{{ $componente->estado }}</td>
											<td>{{ $componente->id_compu }}</td>

                                            <td>
                                                <form action="{{ route('componentes.destroy',$componente->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('componentes.show',$componente->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('componentes.edit',$componente->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $componentes->links() !!}
            </div>
        </div>
    </div>
@endsection
