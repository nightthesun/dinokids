@extends('layouts.app')

@section('estilo')
<style>
body{
    font-size:0.9rem;
}
</style>
@endsection
@section('content')
@include('layouts.sidebar', ['hide'=>'0']) 
<div class="container-fluid">
    <div class="row mt-4 p-4">
        <div class="col-7">
            <div class="table-responsive mt-4" style="height:80vh;overflow:auto;">
            <table class = "table table-sm" >
            @if($ventas)         
                <tr>
                    <th>
                        <table class="table table-sm">
                            <thead>
                                <tr class="text-right">
                                    <th>Marca</th>
                                    @foreach($usr as $us => $val)  
                                        <td>{{$val->nomb}}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ventas as $r => $s)  
                                    <tr class="text-right table-bordered">
                                        <td class="bold">{{$s->marca}}</td>
                                        @foreach($usr as $us => $val)  
                                        <td>{{$s->$us}}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </th>                        
                </tr>                                
            @endif  
            </table> 
            </div> 
        </div>
        <div class="col-5">
            <div id="resumen" style="width:90%;height:100%;margin:auto;"></div>
        </div>
    </div>
</div>

@endsection

@section('mis_scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>
<script>
$(document).ready(function() 
{  
    $(".page-wrapper").removeClass("toggled"); 
    var op= function opciones(user)
    {
        var resum = {!! json_encode($resum_tot) !!};
        console.log(resum);
        var chartDom = document.getElementById(user);
        var pastel = echarts.init(chartDom);
        var option = {
            tooltip: {
                trigger: 'item'
            },
            series: [
                {
                    name: 'name',
                    type: 'pie',
                    radius: '50%',
                    data: resum,
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };
        return option && pastel.setOption(option);     
    }
    var option = op('resumen');
});
</script>
@endsection
