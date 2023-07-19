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
                <h4>VENTAS INSTITUCIONAL/MAYORISTA</h4>       
                <b>Vendedor:</b> {{$usr[0]->adusrNomb}}
                <p><b>Fecha:</b> {{$ffin}}</p>                 
            </td>
            <td style="width: 20%; text-align: right;">                
            </td>
        </tr>                       
    </table>
    <H3 class="mt-5">Facturas al Contado</H3>
    <table class = "table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Nro.Trans</th>
                <th>NIT</th>
                <th>Razon</th>
                <th>Nro. Fac</th>
                <th>Est. Fac</th>
                <th>Total</th>
                <th>Moneda</th>
                <th>Usuario</th>
                <th>Local</th>
                <th>Almacen</th>
                <th>Tipo Cobro</th>
                <th>Impt Cobro</th>
            </tr>
        </thead>
        <tbody>
        @if($q1)
            @foreach($q1 as $f)
                <tr>
                    <td style="text-align:center" class="bold">{{$f->Fecha}}</td>
                    <td style="text-align:center" class="bold">{{$f->Cliente}}</td>
                    <td style="text-align:center" class="bold">{{$f->NroTrans}}</td>
                    <td style="text-align:center" class="bold">{{$f->NIT}}</td>
                    <td style="text-align:center" class="bold">{{$f->Razon}}</td>
                    <td style="text-align:center" class="bold">{{$f->NroFac}}</td>
                    <td style="text-align:center" class="bold">{{$f->EstadoFac}}</td>
                    <td style="text-align:center" class="bold">{{$f->Total}}</td>
                    <td style="text-align:center" class="bold">{{$f->Moneda}}</td>
                    <td style="text-align:center" class="bold">{{$f->Usuario}}</td>
                    <td style="text-align:center" class="bold">{{$f->Local}}</td>
                    <td style="text-align:center" class="bold">{{$f->Almacen}}</td>
                    <td style="text-align:center" class="bold">{{$f->Tipo}}</td>
                    <td style="text-align:center" class="bold">{{$f->ImptC}}</td>
                </tr>
            @endforeach
        @endif  
        </tbody>
    </table>    
    <H3 class="mt-5">Facturas a Credito</H3>
    <table class = "table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Nro.Trans</th>
                <th>NIT</th>
                <th>Razon</th>
                <th>Nro. Fac</th>
                <th>Est. Fac</th>
                <th>Total</th>
                <th>Moneda</th>
                <th>Usuario</th>
                <th>Tipo Cobro</th>
                <th>Impt Cobro</th>
            </tr>
        </thead>
        <tbody>
        @if($q2)
            @foreach($q2 as $f)
                <tr>
                    <td style="text-align:center" class="bold">{{$f->Fecha}}</td>
                    <td style="text-align:center" class="bold">{{$f->Cliente}}</td>
                    <td style="text-align:center" class="bold">{{$f->NroTrans}}</td>
                    <td style="text-align:center" class="bold">{{$f->NIT}}</td>
                    <td style="text-align:center" class="bold">{{$f->Razon}}</td>
                    <td style="text-align:center" class="bold">{{$f->NroFac}}</td>
                    <td style="text-align:center" class="bold">{{$f->EstadoFac}}</td>
                    <td style="text-align:center" class="bold">{{$f->Total}}</td>
                    <td style="text-align:center" class="bold">{{$f->Moneda}}</td>
                    <td style="text-align:center" class="bold">{{$f->Usuario}}</td>
                    <td style="text-align:center" class="bold">{{$f->Tipoc}}</td>
                    <td style="text-align:center" class="bold">{{$f->ImptC}}</td>
                </tr>
            @endforeach
        @endif  
        </tbody>
    </table> 
    <H3 class="mt-5">Facturas a Credito y Contado (Anuladas)</H3>
    <table class = "table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Nro.Trans</th>
                <th>NIT</th>
                <th>Razon</th>
                <th>Nro. Fac</th>
                <th>Est. Fac</th>
                <th>Total</th>
                <th>Moneda</th>
                <th>Usuario</th>
                <th>Tipo Cobro</th>
                <th>Impt Cobro</th>
            </tr>
        </thead>
        <tbody>
        @if($q3)
            @foreach($q3 as $f)
                <tr>
                    <td style="text-align:center" class="bold">{{$f->Fecha}}</td>
                    <td style="text-align:center" class="bold">{{$f->Cliente}}</td>
                    <td style="text-align:center" class="bold">{{$f->NroTrans}}</td>
                    <td style="text-align:center" class="bold">{{$f->NIT}}</td>
                    <td style="text-align:center" class="bold">{{$f->Razon}}</td>
                    <td style="text-align:center" class="bold">{{$f->NroFac}}</td>
                    <td style="text-align:center" class="bold">{{$f->EstadoFac}}</td>
                    <td style="text-align:center" class="bold">{{$f->Total}}</td>
                    <td style="text-align:center" class="bold">{{$f->Moneda}}</td>
                    <td style="text-align:center" class="bold">{{$f->Usuario}}</td>
                    <td style="text-align:center" class="bold">{{$f->Tipo}}</td>
                    <td style="text-align:center" class="bold">{{$f->Monto}}</td>
                    <!--td style="text-align:center" class="bold">{{$f->Monto}}</td-->                    
                </tr>
            @endforeach
        @endif  
        </tbody>
    </table> 
    <H3 class="mt-5">Cobranza Al Contado</H3>
    <table class = "table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th>Fecha</th>
                <th>Glosa</th>
                <th>Cliente</th>
                <th>Nro. Fac</th>
                <th>Tipo Pago</th>
                <th>Doc Ext</th>
                <th>Banco</th>
                <th>Trans. Inicial</th>
                <th>Importe</th>
                <th>Mon</th>
                <th>Usuario</th>   
            </tr>
        </thead>
        <tbody>
        @if($q4)
            @foreach($q4 as $f)
                <tr>
                    <td style="text-align:center" class="bold">{{$f->Fecha}}</td>
                    <td style="text-align:center" class="bold">{{$f->Glosa}}</td>
                    <td style="text-align:center" class="bold">{{$f->Cliente}}</td>
                    <td style="text-align:center" class="bold">{{$f->NroFac}}</td>
                    <td style="text-align:center" class="bold">{{$f->TipoPago}}</td>
                    <td style="text-align:center" class="bold">{{$f->DocExt}}</td>
                    <td style="text-align:center" class="bold">{{$f->Banco}}</td>
                    <td style="text-align:center" class="bold">{{$f->TransInicial}}</td>    
                    <td style="text-align:center" class="bold">{{$f->Importe}}</td> 
                    <td style="text-align:center" class="bold">{{$f->Mon}}</td> 
                    <td style="text-align:center" class="bold">{{$f->Usuario}}</td>                    
                </tr>
            @endforeach
        @endif  
        </tbody>
    </table> 
    <H3 class="mt-5">Cobranza Con Documentos de Pago</H3>
    <table class = "table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th>Fecha</th>
                <th>Glosa</th>
                <th>Cliente</th>
                <th>Nro. Fac</th>
                <th>Tipo Pago</th>
                <th>Doc Ext</th>
                <th>Banco</th>
                <th>Trans. Inicial</th>
                <th>Importe</th>
                <th>Mon</th>
                <th>Usuario</th>   
                <th>Sald. Actual</th>    
                <th>Nro Liq.</th>            
            </tr>
        </thead>
        <tbody>
        @if($q5)
            @foreach($q5 as $f)
                <tr class="align-middle">
                    <td style="text-align:center" class="bold">{{$f->Fecha}}</td>
                    <td style="text-align:center" class="bold">{{$f->Glosa}}</td>
                    <td style="text-align:center" class="bold">{{$f->Cliente}}</td>
                    <td style="text-align:center" class="bold">{{$f->NroFac}}</td>
                    <td style="text-align:center" class="bold">{{$f->TipoPago}}</td>
                    <td style="text-align:center" class="bold">{{$f->DocExt}}</td>
                    <td style="text-align:center" class="bold">{{$f->Banco}}</td>
                    <td style="text-align:center" class="bold">{{$f->TransInicial}}</td>    
                    <td style="text-align:center" class="bold">{{$f->Importe}}</td> 
                    <td style="text-align:center" class="bold">{{$f->Mon}}</td> 
                    <td style="text-align:center" class="bold">{{$f->Usuario}}</td>  
                    <td style="text-align:center" class="bold">{{$f->Saldo}}</td>    
                    <td style="text-align:center" class="bold">{{$f->LiqIni}}</td>       
                </tr>
            @endforeach
        @endif  
        </tbody>
    </table> 
    </table> 
    <H3 class="mt-5">Total Venta</H3>
    <table class = "table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th>Tipo de Cobro</th>
                <th>Total</th>            
            </tr>
        </thead>
        <tbody>
        @if($t1)
            @foreach($t1 as $t=>$tot)
                <tr>
                    <td class="text-center">{{$t}}</td>   
                    <td class="text-right">{{$tot}}</td>       
                </tr>
            @endforeach
        @endif  
        </tbody>
    </table> 
    <H3 class="mt-5">Total Cobro</H3>
    <table class = "table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th>Tipo de Cobro</th>
                <th class="text-right">Total</th>            
            </tr>
        </thead>
        <tbody>
        @if($t4)
            @foreach($t4 as $t=>$tot)
                <tr>
                    <td class="text-center">{{$t}}</td>   
                    <td class="text-right">{{$tot}}</td>       
                </tr>
            @endforeach
        @endif  
        </tbody>
    </table> 
</body>
</html>

