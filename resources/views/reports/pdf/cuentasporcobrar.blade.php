<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuentas Por Cobrar</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<style>
body{
    font-size:1rem;
}
</style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <table style="width:100%">
                <tr valign= "middle"> 
                    <td style="width: 20%;">
                        <img alt="foto" src="{{asset('imagenes/logo.png')}}" style="width: 100%;
                        height: auto;"/>      
                    </td>
                    <td style="width: 60%; text-align: center;">
                      @if ($requestFecha == 2)
                      <h3 class="text-center">RESUMEN DE CUENTAS POR COBRAR</h3>
                      <h6 class="text-center">ENTRE {{$fecha1}} - {{$fecha2}}</h6>               
                      @elseif ($requestFecha == 1)
                      <h3 class="text-center">RESUMEN DE CUENTAS POR COBRAR</h3>
                      <h6 class="text-center">AL {{$fecha}}</h6>               
                      @endif
                    </td>
                    <td style="width: 20%; text-align: right;">                
                    </td>
                </tr>                       
            </table>
            <table class="table table-sm table-bordered">
            <thead>
            <tr>
                <th>Codigo</th>
                <th>Cliente</th>
                <th>RazonSocial</th>
                <th>Nit</th>
                <th>Fecha</th>
                <th>FechaVenc</th>
                <th>ImporteCXC</th>
                <th>ACuenta</th>
                <th>Saldo</th>
                <th>Glosa</th>
                <th>Usuario</th>
                <th>M.</th>
                <th>NVenta</th>
                <th>Num. Fac</th>
                <th>Local</th>
                <th>estado</th>
                </tr>
            </thead>
            <tbody>
            
            @if($cxc)
            @foreach($cxc as $c)
            </tr>
            <th>{{$c->Cod}} </th>
            <th>{{$c->Cliente}}</th>
            <th>{{$c->Rsocial}}</th>
            <th>{{$c->Nit}}</th>
            <th>{{$c->Fecha}}</th>
            <th>{{$c->FechaVenc}}</th>
            <th>{{$c->ImporteCXC}}</th>
            <th>{{$c->ACuenta}}</th>
            <th>{{$c->Saldo}}</th>
            <th>{{$c->Glosa}}</th>
            <th>{{$c->Usuario}}</th>
            <th>{{$c->Moneda}}</th>
            <th>{{$c->NroVenta}}</th>
            <th>{{$c->NroFac}}</th>
            <th>{{$c->Local}}</th>
            <th>{{$c->estado}}</th>
            </tr>
            @endforeach
            @endif
            <tr style="border: none;" class="text-right">
            <th style="border: none;" colspan = 3></th>
            <th style="border: none;">TOTAL</th>
            @if($sum)
            @foreach($sum as $su)
            <td>{{$su->sumImporteCXC}}</td>
            <td>{{$su->sumACuenta}}</td>
            <td>{{$su->sumSaldo}}</td>
            @endforeach
            @endif
            <th colspan = 8></th>
            </tr>
            <tr class="text-right">
            <td colspan = 3></td>
            <th colspan = 4 class="text-center">Resumen Cuentas Por Cobrar</th>
            <td colspan = 8></td>
            </tr>
            @if($sum_estado)
            @foreach($sum_estado as $sume)
            <tr class="text-right">
            <td colspan = 3></td>
            <td>{{$sume->estado}}</td>
            <td>{{$sume->ImporteCXC}}</td>
            <td>{{$sume->ACuenta}}</td>
            <td>{{$sume->Saldo}}</td>
            <td colspan = 8></td>
            </tr>
            @endforeach
            @endif
            </tbody>
            </table>        
        </div>
    </div>
</div>
</div>
    </div>
</div>
</body>
</html>

