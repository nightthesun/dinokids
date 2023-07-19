<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Ventas Inst/May</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body{
            font-size:0.8rem;
        }
    </style>
</head>
<body>
    <table style="width:100%">
        <tr valign= "middle"> 
            <td style="width: 20%;">
                <img alt="foto" src="{{asset('imagenes/logo.png')}}" style="width: 100%;
                height: auto;"/>      
            </td>
            <td style="width: 60%; text-align: center;">
                <h4>NOTAS DE REMISION</h4>       
                <b>Vendedor:</b> {{$usr[0]->adusrNomb}}
                <p><b>Fecha:</b> {{$ffin}}</p>                 
            </td>
            <td style="width: 20%; text-align: right;">                
            </td>
        </tr>                       
    </table>
    <H3 class="mt-5">Notas de Remision</H3>
    <table class = "table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th>Fecha</th>
                <th>Nro. Cliente</th>
                <th>Cliente</th>
                <th>Nro.Trans</th>
                <th>Total</th>
                <th>Moneda</th>
                <th>Usuario</th>
                <th>Local</th>
                <th>Almacen</th>
                <th>Tipo Cobro</th>
                <th>Impt Cobro</th>
                <th>Fac</th>
                <th>FechaFac</th>
            </tr>
        </thead>
        <tbody>
        @if($q1)
            @foreach($q1 as $f)
                <tr>
                    <td style="text-align:center" class="bold">{{$f->Fecha}}</td>                    
                    <td style="text-align:center" class="bold">{{$f->NroCli}}</td>
                    <td style="text-align:center" class="bold">{{$f->Cliente}}</td>
                    <td style="text-align:center" class="bold">{{$f->NroTrans}}</td>
                    <td style="text-align:center" class="bold">{{$f->Total}}</td>
                    <td style="text-align:center" class="bold">{{$f->Moneda}}</td>
                    <td style="text-align:center" class="bold">{{$f->Usuario}}</td>
                    <td style="text-align:center" class="bold">{{$f->Local}}</td>
                    <td style="text-align:center" class="bold">{{$f->Almacen}}</td>
                    <td style="text-align:center" class="bold">{{$f->Tipo}}</td>
                    <td style="text-align:center" class="bold">{{$f->ImptC}}</td>
                    <td style="text-align:center" class="bold">{{$f->facturado}}</td>
                    <td style="text-align:center" class="bold">{{$f->FechaFac}}</td>
                </tr>
            @endforeach
        @endif  
        </tbody>
    </table>
    <H3 class="mt-5">Notanas de Remision Anuladas</H3>
    <table class = "table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th>Fecha</th>
                <th>Nro. Cliente</th>
                <th>Cliente</th>
                <th>Nro.Trans</th>
                <th>Total</th>
                <th>Moneda</th>
                <th>Usuario</th>
                <th>Local</th>
                <th>Almacen</th>
                <th>Tipo Cobro</th>
                <th>Impt Cobro</th>
                <th>Fac</th>
                <th>FechaFac</th>
            </tr>
        </thead>
        <tbody>
        @if($q2)
            @foreach($q2 as $f)
                <tr>
                    <td style="text-align:center" class="bold">{{$f->Fecha}}</td>                    
                    <td style="text-align:center" class="bold">{{$f->NroCli}}</td>
                    <td style="text-align:center" class="bold">{{$f->Cliente}}</td>
                    <td style="text-align:center" class="bold">{{$f->NroTrans}}</td>
                    <td style="text-align:center" class="bold">{{$f->Total}}</td>
                    <td style="text-align:center" class="bold">{{$f->Moneda}}</td>
                    <td style="text-align:center" class="bold">{{$f->Usuario}}</td>
                    <td style="text-align:center" class="bold">{{$f->Local}}</td>
                    <td style="text-align:center" class="bold">{{$f->Almacen}}</td>
                    <td style="text-align:center" class="bold">{{$f->Tipo}}</td>
                    <td style="text-align:center" class="bold">{{$f->ImptC}}</td>
                    <td style="text-align:center" class="bold">{{$f->facturado}}</td>
                    <td style="text-align:center" class="bold">{{$f->FechaFac}}</td>
                </tr>
            @endforeach
        @endif  
        </tbody>
    </table>     
</body>
</html>

