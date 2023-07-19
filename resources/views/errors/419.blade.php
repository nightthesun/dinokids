@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Expiración de pagina'))

<!--TEMPORAAAAAAAAL!!!! :_D-->


<div class="container" style="position:relative;">
    <div class="row d-flex justify-content-center mt-4">
        <div class="col-4 text-center">
            <h5>SU SESION EXPIRO</h5>
            <a href="{{ route('inicio') }}" class="btn btn-primary">Volver a iniciar Session</a>
        </div>
    </div>
</div>

