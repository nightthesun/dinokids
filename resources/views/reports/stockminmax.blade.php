@extends('layouts.app')
@section('static', 'statick-side')
@section('content')
@include('layouts.sidebar', ['hide'=>'1']) 

<div class="container">  
    <form method="POST" action="{{ route('stockminmax.store') }}">
        @csrf 
        <div class="row mt-4 justify-content-center">
            <div class="col-md-4">
                <div class="container border rounded">
                    <div class="row text-center my-3">
                        <h5 class="text-primary">REPORTE DE STOCK ACTUAL</h5>
                    </div>
                    <div class="mb-2 row d-flex justify-content-center">
                            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm text-right">Al:</label>
                        <div class="col-sm-7">
                            <input id="fecha_fin" type="date" class="form-control form-control-sm"  
                                @if(!Auth::user()->tienePermiso(5,6)) 
                                    disabled
                                @endif 
                                name="fecha_fin" value ="{{date('Y-m-d')}}">
                        </div>
                    </div>
                    <div class="mb-2 row d-flex justify-content-center">
                        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm text-right">Categoria:</label>
                        <div class="col-sm-7">
                            <input id="categoria" type="text" class="form-control form-control-sm" name="categoria">
                        </div>
                    </div>
                    <div class="mb-2 row d-flex justify-content-center">
                        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm text-right">Producto:</label>
                        <div class="col-sm-7">
                            <input id="producto" type="text" class="form-control form-control-sm" name="producto">
                        </div>
                    </div>
                    <div class="px-3 mb-2 row">
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="stock02" name="stock0" checked> 
                                <label class="form-check-label" for="stock02">Mostrar productos con stock 0</label>
                            </div>
                        </div>
                        <!-- <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="codBarras" name="codBarras"> 
                                <label class="form-check-label" for="codBarras">Mostrar Codigos de Barra</label>
                            </div>
                        </div> -->
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-12 text-center d-block gap-2">
                            <button type="submit" class="btn btn-primary" name="gen" value="ver">
                                {{ __('Ver') }}
                            </button>
                            <button type="submit" class="btn btn-primary" name="gen" value="export">
                                {{ __('Exportar') }}
                            </button>                            
                        </div>
                    </div>
                </div>
                <div class="controles-form-esq-der  @if(!Auth::user()->tienePermiso(5,9)) d-none @endif">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="fas fa-tools"></i>
                    </button>
                </div>
            </div>

            <div class="col-8
            @if(!Auth::user()->tienePermiso(5,9))
                d-none
            @endif d-none">
                <div class="container-fluid border rounded p-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                        type="checkbox" id="flexSwitchCheckChecked" name="almacen_check">
                        <label class="form-check-label" for="flexSwitchCheckChecked">
                            ALMACENES
                        </label>                         
                    </div>
                    <div class="row p-2" style="height:80vh;overflow:auto; font-size:0.8rem">
                        @foreach($almacen_grupo as $k => $alm)
                            <div class="col-6 px-3 py-1">
                                <h6 class="mb-1">{{$k}}</h6>
                                <ul id="seg" class="list-group list-group-flush">
                                    @foreach($alm as $l => $a)
                                    <li class="list-group-item" id="{{$k}}">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" 
                                            type="checkbox" id="{{$a->inalmCalm}}" value ="{{$a->inalmCalm}}" name="almacen[]"
                                            @if($a->estado == 1)
                                            checked @endif>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">
                                                {{$a->inalmNomb}}
                                            </label>   
                                        </div>                                                     
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="modal-body">
                                <div class="list-group" style="height:400px;overflow:auto; font-size:0.8rem">
                                    @foreach (App\User::get() as $u)
                                        <a href="#" class="list-group-item list-group-item-action usuarios_param" id = "{{$u->id}}">
                                            {{$u->perfiles->nombre}}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="container p-4 mt-4" style="height:400px;overflow:auto; font-size:0.8rem">
                            @foreach($almacen_grupo as $k => $alm)
                                <h6 class="mb-1">{{$k}}</h6>
                                <ul id="almxg" class="list-group list-group-flush">
                                    @foreach($alm as $l => $a)
                                    <li class="list-group-item" id="{{$k}}">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input almxu" 
                                            type="checkbox" id="palm_{{$a->inalmCalm}}" value ="{{$a->inalmCalm}}" name="almxu[]">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">
                                                {{$a->inalmNomb}}
                                            </label>   
                                        </div>                                                     
                                    </li>
                                    @endforeach
                                </ul>
                            @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <input type='hidden' name='grupos' value="{{(serialize($almacen_grupo))}}" />
    </form>
</div>
@endsection
@section('mis_scripts')
<script>
    $(document).ready(function(){
        $(".usuarios_param").click(function(){
            $(".usuarios_param").removeClass("active");
            $(this).toggleClass("active");
            var user = $(this).attr("id");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('stock.store_almxu')}}",
                type: 'POST',
                data: {user, show:true},
                dataType: 'json',
                success: function (data) {

                    $(".almxu").each(function(){
                        $(this).prop('checked', false);
                    });
                    for(var i = 0; i < data.length; i++){
                        $("#palm_"+data[i].alm_id).prop("checked", true);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                }
            }); 
        });
    });
    $('.almxu').change(function(){
        $()
        var user = $(".usuarios_param.active").attr("id");
        var alm = $(this).val();
        var state = $(this).is(':checked');
        if(user != undefined)
        {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('stock.store_almxu')}}",
                type: 'POST',
                data: {user, alm, state},
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                }
            }); 
        }
    });
</script>
@endsection
