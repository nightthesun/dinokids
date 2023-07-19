@extends('layouts.app')
@section('estilo')
<style>
    .list-group-item{
        padding: 0;
    }
</style>
@endsection
@section('content')
@include('layouts.sidebar', ['hide'=>'0']) 
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 border">
            <form method="POST" target="_blank" action="{{ route('reportevts.store') }}">
                @csrf
                <div class="row my-2">
                    <h3 class="text-center text-primary">RESUMEN VENTAS POR SEGMENTO</h3>
                </div>
                <div class="row mb-4 px-4 d-flex justify-content-center">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white">Desde</span>
                        <input type="date" class="form-control form-control-sm" name="mfini" value="2021-03-01" min="2021-03-01">
                        <span class="input-group-text bg-white">Hasta</span>
                        <input type="date" class="form-control form-control-sm" name="mffin" value="{{date('Y-m-d')}}">
                        <button class="btn btn-sm btn-primary" type="submit" name="rango" value="true">Generar</button>
                    </div>
                </div>
                <div class="row">
                @for ($i=$fini; $i < $ffin; $i = strtotime(date('d-m-Y',$i) .'+1 month'))            
                    <div class="col-3 mb-2">
                        <button type="submit" class="btn btn-primary w-100" name="mes" value="{{date('m-Y',$i)}}">
                            {{$meses[date('m',$i)]}} {{date('Y',$i)}}
                        </button>
                    </div>
                @endfor
                </div>
                <div class="controles-form-esq-der">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#grafModal">
                        <i class="far fa-chart-bar"></i>
                    </button>
                </div>
                <div class="modal fade" id="grafModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <!--div class="modal-header">
                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div-->
                            <div class="modal-body" style="height:85vh;overflow:auto;">
                                <div class="row">
                                    @foreach ($grupos as $ugK => $uG)
                                        @if(!isset($uG['const']))
                                            <div class="col-3 text-center my-2" style="font-size:0.75rem">
                                                <div class="card">
                                                    <div class="card-header">
                                                        {{$uG['name']}}
                                                    </div>
                                                    <ul class="list-group list-group-flush" id="{{$uG['id']}}">
                                                        @if(isset($uG['udata']))
                                                            @foreach ($uG['udata'] as $ud)
                                                                <li class="list-group-item" style="cursor:pointer" id="{{$ud->adusrCusr}}">{{$ud->adusrNomb}}</li>  
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <input type="hidden" name="grupos" id="grupos" value="">
            </form>
        </div>
    </div>
</div>

@endsection
@section('mis_scripts')
<script>
    $(document).ready(function(){
        var grupos = {!! json_encode($grupos) !!};
        //console.log(grupos);
        function sortableCrear(item){
            var items = document.getElementById(item);
            new Sortable(items, {
                group: 'grupo', // set both lists to same group
                animation: 150,
                onAdd: function (/**Event*/evt) {   
                    var gru =grupos.find(function(elem){
                        return elem.id == evt.from.id;
                    });

                    gru.udata.forEach(function(item, index){
                        if(item.adusrCusr == evt.item.id){
                            var gruto =grupos.find(function(elem){
                                return elem.id == evt.to.id;
                            });
                            gruto.udata.push(item);
                            gru.udata.splice(index, 1);
                            var index = gru.usrs.indexOf(parseInt(evt.item.id));
                            if (index !== -1) {
                                gru.usrs.splice(index, 1);
                            }
                            gruto.usrs.push(parseInt(item.adusrCusr));
                        }
                    });   
                    $('#grupos').val(JSON.stringify(grupos));              
                },
            });
        }
        grupos.forEach( function(valor, indice, array) {
            if(valor.const == undefined){
                sortableCrear(valor.id);
            }
            //sortableCrear(valor);
        });
        $('#grupos').val(JSON.stringify(grupos));
        $(".page-wrapper").removeClass("toggled"); 
    });

</script>
@endsection
