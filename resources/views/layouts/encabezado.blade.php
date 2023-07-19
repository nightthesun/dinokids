<div class="row d-flex justify-content-between">
    <div class="col-lg-3 col-sm-6">
        <img alt="foto" class="img-fluid w-75" src="{{asset('imagenes/logo.png')}}"/>
    </div>
    @if(isset($nro))
    <div class="col-lg-3 d-flex align-items-center justify-content-end">
        <h4 style="color:red">Nro. </h4>                                
    </div>
    @endif
</div>
<div class="row d-flex justify-content-center mb-5">
    <div class="col-lg-6 col-sm-12 d-flex align-items-center justify-content-center">
        <h3 class="text-center text-primary">{{$titulo}}</h3>
    </div>
</div>