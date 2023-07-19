@extends('layouts.app')

@section('estilo')
 
@endsection

@section('content')
<div style="padding: 6rem; padding-top:2rem;">    
    <div class="row d-flex justify-content-center mb-3">
        <div class="col-lg-6 col-sm-12 d-flex align-items-center justify-content-center">
            <h3 class="text-center text-primary">Modulo</h3>
        </div>
    </div>
    <form method="POST" enctype="multipart/form-data" action="{{ route('modulo.store') }}">
        @csrf
        <div class="row">                            
            <div class="col-12 border border-primary rounded">
                <div class="form-group row d-flex mt-4">
                    <label for="nombre" class="col-md-2 col-form-label">
                        {{ __('Nombre') }}
                    </label>
                    <div class="col-md-4">
                        <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus>
                        @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>                            
                    <label for="paterno" class="col-md-2 col-form-label">
                        {{ __('Descripcion') }}
                    </label>
                    <div class="col-md-4">
                        <input id="paterno" type="text" class="form-control @error('paterno') is-invalid @enderror" name="paterno" value="{{ old('paterno') }}" required autocomplete="paterno">         
                        @error('paterno')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>                        
                <div class="form-group row d-flex justify-content-center">
                    <div class="col-md-10 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Regitrar') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>      
    </form>
</div>

@endsection
@section('mis_scripts')
<script>
var loadFile = function(event) {
	var image = document.getElementById('output');
    image.src = URL.createObjectURL(event.target.files[0]);  
    var foto =$("#foto").val();
    if(foto!=="")
    {
        $("#elim_image").show();
    }
};
$("#elim_image").click(function()
{
    $("#foto").val("");
    var image = document.getElementById('output');
    image.src = "{{asset('imagenes/log.jpg')}}";  
    $("#elim_image").hide();
    
});

</script>
@endsection
