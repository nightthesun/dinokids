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
<div class="container">
    <div class="row justify-content-center mt-4 p-5 border">
        <div class="col">
                <table style="width:100%">
                    <tr valign= "middle"> 
                        <td style="width: 20%;">
                            <img alt="foto" src="{{asset('imagenes/logo.png')}}" style="width: 100%;
                            height: auto;"/>      
                        </td>
                        <td style="width: 60%; text-align: center;">
                            <h3 class="text-center">RESUMEN DE VENTAS</h3>
                            <h6 class="text-center">DEL {{$fini}} AL {{$ffin}}</h6>               
                        </td>
                        <td style="width: 20%; text-align: right;">                
                        </td>
                    </tr>                       
                </table>
                <div class="table-responsive" style="height:400px;overflow:auto;">
                <table class = "table table-sm" >
                @if($resumen)   
                    @foreach($resumen as $r => $s)                                
                        <thead>
                            <tr><th>VENTAS {{$r}}</th></tr>
                            <tr class="text-right table-bordered">
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th>Efectivo</th>
                                <th>Banco</th>
                                <th>CXC</th>
                                <th>Tarjeta</th>
                                <th>MotCont</th>
                                <th>Otros</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($s as $i)
                                <tr class="text-right table-bordered">
                                    <td class="bold">{{$i->grupo}}</td>
                                    <td class="bold">{{$i->moneda}}</td>
                                    <td class="bold">{{$i->tot}}</td>
                                    <td class="bold">{{$i->efe}}</td>
                                    <td class="bold">{{$i->ban}}</td>
                                    <td class="bold">{{$i->cxc}}</td>
                                    <td class="bold">{{$i->tar}}</td>
                                    <td class="bold">{{$i->mot}}</td>
                                    <td class="bold">{{$i->otr}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endforeach
                @endif  
                </table> 
                </div> 
        </div>
    </div>
</div>s
@endsection

@section('mis_scripts')
<script>
$(".page-wrapper").removeClass("toggled"); 
</script>
@endsection
