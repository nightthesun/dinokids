@extends('layouts.app')
@section('static', 'statick-side')
@section('content')
    @include('layouts.sidebar', ['hide'=>'1']) 
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-6 border">
                <form method="POST" target="_blank" action="{{ route('ventasinsmayo.store') }}">
                    @csrf
                    <div class="row text-center my-3">
                        <h5 class="text-primary">VENTAS INSTITUCIONAL/MAYORISTA</h5>
                    </div>
                    @if(Auth::user()->tienePermiso(7,7))
                        <div class="mb-2 row d-flex justify-content-center">    
                            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Desde:</label>
                            <div class="col-sm-6">
                                <input id="fini" type="date" class="form-control form-control-sm " name="fini" value ="{{date('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="mb-2 row d-flex justify-content-center">    
                            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Hasta:</label>
                            <div class="col-sm-6">
                                <input id="ffin" type="date" class="form-control form-control-sm " name="ffin" value ="{{date('Y-m-d')}}">
                            </div>
                        </div> 
                    @else
                        <div class="mb-2 row d-flex justify-content-center">    
                            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Del dia:</label>
                            <div class="col-sm-6">
                                <input id="ffin" type="date" class="form-control form-control-sm " name="ffin" value ="{{date('Y-m-d')}}">
                            </div>
                        </div> 
                    @endif              
                    <div class="mb-2 row d-flex justify-content-center">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Usuario:</label>
                        <div class="col-sm-6">
                            <select name="user" id="user" class="form-control form-control-sm">
                                @if(count($user))
                                    @foreach($user as $u)
                                        <option value = "{{$u->adusrCusr}}">{{$u->adusrNomb}}</option>
                                    @endforeach
                                @else
                                    <option disabled selected>No hay usuarios</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <div class="col-md-12 d-flex justify-content-center d-block gap-2">
                            <button type="submit" class="btn btn-primary btn-sm" name="gen" value="export">
                                {{ __('Exportar a PDF') }}
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm" name="gen" value="ver">
                                {{ __('Ver') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('mis_scripts')
    <script>
    </script>
@endsection
