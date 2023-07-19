<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Cotizacion </title>
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
                <h4>REPORTE DE COTIZACION </h4>       
                <h5>FECHA: {{$fecha2}}</h5>
                             
            </td>
            <td style="width: 20%; text-align: right;">                
            </td>
        </tr>                       
    </table>
    <H3 class="mt-5">Reporte de Cotizacion</H3>
    <table class = "table table-bordered table-sm">
        <thead class="thead-light">

            <tr>
                <th style="width: 140px; " class="header" scope="col">Fecha Cot</th>
                <th style="width: 100px; "class="header" scope="col">Nro Cot</th>
                <th style="width: 600px; "class="header" scope="col">Cliente</th> 
                <th style="width: 300px; "class="header" scope="col">Fecha NR</th> 
                <th style="width: 160px; "class="header" scope="col">NR</th>
                <th style="width: 190px; "class="header" scope="col">Total Ventas</th>
                
                <th style="width: 10px; "class="header" scope="col">Moneda</th>
                <th style="width: 70px; "class="header" scope="col">Estado NR</th>
                <th style="width: 130px; "class="header" scope="col">Usuario vendedor</th>
                <th style="width: 130px; "class="header" scope="col">Local</th>
                <th style="width: 130px; "class="header" scope="col">Fecha fac</th>
                <th style="width: 130px; "class="header" scope="col">Nro Fac</th>
                <th style="width: 70px; "class="header" scope="col">Estado Fac</th>
    
      
                
            </tr>
        </thead>
        <tbody>
            
                @foreach ($consutas as $item)
                                   
               <tr>

                
                    <td style="text-align:center" class="bold">{{$item->Fecha}}</td> 
                    @if(strval($item->NroCotizacion)==="0")
                    <td style="text-align:center" class="bold">-</td>
                    @else
                    <td style="text-align:center" class="bold">{{$item->NroCotizacion}}</td> 
                    @endif                   
                    
                    <td style="text-align:center" class="bold">{{$item->Cliente}}</td>
                    <td style="text-align:center" class="bold">{{$item->FechaNR}}</td>
                    <td style="text-align:center" class="bold">{{$item->NR}}</td>
                    <td style="text-align:center" class="bold">{{$item->Totalventas}}</td>
                    <td style="text-align:center" class="bold">{{$item->Moneda}}</td>
                    @if ($item->estadoNR ==9)
                    <td style="text-align:center" class="bold">a</td>  
                    @else
                    <td style="text-align:center" class="bold">v</td>    
                    @endif
                    <td style="text-align:center" class="bold">{{$item->Usuario}}</td>
                    <td style="text-align:center" class="bold">{{$item->Local}}</td>
                    @if (is_null($item->FechaFac))
                    <td style="text-align:center" class="bold" >-</td>
                    @else
                    <td style="text-align:center" class="bold">{{$item->FechaFac}}</td>
                    @endif
                                        
                    @if (is_null($item->numerofactura))
                    <td style="text-align:center" class="bold" >-</td>
                    @else
                    <td style="text-align:center" class="bold">{{$item->numerofactura}}</td> 
                    @endif
                    
                    
                    @if (is_null($item->estado))
                    <td style="text-align:center" class="bold" >-</td>
                    @else
                    <td style="text-align:center" class="bold">{{$item->estado}}</td> 
                    @endif
                   
                  
                </tr>
            
                @endforeach            
        </tbody>
    </table>
   
   
</body>
</html>

