@extends('layouts.app')

@section('template_title')
    {{ $historia->name ?? 'Show Historia' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Historia</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('historias.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Marca:</strong>
                            {{ $historia->marca }}
                        </div>
                        <div class="form-group">
                            <strong>Tipo:</strong>
                            {{ $historia->tipo }}
                        </div>
                        <div class="form-group">
                            <strong>Modelo:</strong>
                            {{ $historia->modelo }}
                        </div>
                        <div class="form-group">
                            <strong>Ns:</strong>
                            {{ $historia->ns }}
                        </div>
                        <div class="form-group">
                            <strong>Caracteristicas:</strong>
                            {{ $historia->caracteristicas }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $historia->estado }}
                        </div>
                        <div class="form-group">
                            <strong>Id Empleado:</strong>
                            {{ $historia->id_empleado }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
