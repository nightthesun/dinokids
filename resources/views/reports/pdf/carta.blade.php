<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        #imagen{
            font-family: Arial;
margin: 50px;
margin-bottom: 10px;
margin-top: 90px;
padding: 0;
border-width: 0; 

        }
      #margen     {
        font-family: Arial;
margin: 50px;
margin-bottom: 10px;
padding: 0;
border-width: 0;
}
#margenBottom  {
        font-family: Arial;
margin: 50px;
margin-bottom: 8px;
margin-top: 10px;
padding: 0;
border-width: 0;
}
.text-justify {
  text-align: justify;
  text-indent: 60px;
  font-size: 17px;
}
        body{
            font-size:0.8rem;
            font-family: Arial;
        }
        .raya {
border-bottom: 1px solid #000000;
}

.contenedor-imagenes {
  display: flex;
padding-left: 170px;
}
.separador{
    padding-left: 30px;
}
.contenedor-imagenes img:first-child {
  margin-right: 50px;

}
.letra{
    font-family: Arial;
}
.imagenT1{
    padding-top: 70px;
}
.imagenT2{
    padding-top: 70px;
    padding-right: 50px;
}
    </style>
</head>
<body>

        
    
    
    <div id="margen">
    @foreach ($arraycxcCarta as $key=> $v)
        
        <h5 class="letra">La Paz {{$fechaH}}</h5>       
        <h5 class="letra">LYPO/ADM//COB/[001-2022]</h5>
            <H3 class="letra; mt-5">Señor Cliente</H3>
            <H3 class="letra">{{$key}}</H3>
 
            <H3 class="letra">Presente.-</H3>
            <H3 style="text-align: right" class="letra"><strong> Ref.: <span class="raya;letra">CONFIRMACION DE SALDO CLIENTES</strong> </span> </H3>
            <H3 class="letra;mt-5" style="">Distinguidos cliente:</H3>
            <br>
            @if($v)
            @foreach ($totalS[$key] as $y => $t) 
              
            <p style="padding-top: 20px;text-indent: 25px;font-size: 17px" class="letra"> Como resultado de la Auditoria Interna realizada al {{$fechaC}}, nuestros libros contables registran un saldo por cobrar de $us. {{$t->SaldoDolar}} ({{$cadenaDL1[0]}}) 
                 ,su equivalente al tipo de cambio actual de BS. {{$t->SaldoBS}} ({{$cadenaBS1[0]}}), detallado de la siguiente manera:
           
            </p> 
            @endforeach   
           @endif      
    </div> 
    <h4 style="text-align: center; padding-top: 8px;"> <strong class="letra">ESTADO DE CUENTA CLIENTE</strong></h4>
    <h4 style="text-align: center; font-size: 12px"> <strong class="letra" >Al: {{$fechaC}}</strong></h4>
    
  <table class = "table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <td colspan="3" style="text-align: center;background: #d8d8e4; font-size: 17px" class="letra">FECHA</td>
                <td style="background: #c8c8ea;"></td>
                <td colspan="3"  style="border-inline-color: initial   text-align: center;background: #c8c8ea; font-size: 17px" class="letra">IMPORTE EN DOLARES</td>
                <td colspan="3" style="text-align: center;background: #d8d8e4; font-size: 17px" class="letra">IMPORTE EN BOLIVIANOS</td>
            </tr>
            <tr>
           
            <td style="text-align: center;background: #d8d8e4;" class="letra">FACTURADO</td>
            <TD style="text-align: center;background: #d8d8e4;" class="letra">NRO. FACTURA</TD>
            <td style="text-align: center;background: #d8d8e4;" class="letra">VENCIMIENTO</td>
            <td style="text-align: center;background: #c8c8ea;" class="letra">ESTADO</td>
            <td style="text-align: center;background: #c8c8ea;" class="letra">IMPORTE</td>
            <td style="text-align: center;background: #c8c8ea;" class="letra">A CUENTA</td>
            <td style="text-align: center;background: #c8c8ea;" class="letra" >SALDO</td>
            <td style="text-align: center;background: #d8d8e4;" class="letra">IMPORTE</td>
            <td style="text-align: center;background: #d8d8e4;" class="letra">A CUENTA</td>
            <td style="text-align: center;background: #d8d8e4;" class="letra">SALDO</td>
            </tr>
        </thead>

        <tbody>
            @if($v)
      
            @foreach($v as $h => $i)
            <tr>
                <td style="text-align: center" class="letra">{{$i->Fecha}}</td>
                <td style="text-align: center" class="letra">{{$i->NroFac}}</td>
                <td style="text-align: center" class="letra">{{$i->FechaVenc}}</td>
                <td style="text-align: center" class="letra">{{$i->estado}}</td>
                <td style="text-align: center" class="letra">{{$i->ImporteCXCDolar}}</td>
                <td style="text-align: center" class="letra">{{$i->ACuentaDolar}}</td>
                <td style="text-align: center" class="letra">{{$i->SaldoDolar}}</td>
                <td style="text-align: center" class="letra">{{$i->ImporteCXCBS}}</td>
                <td style="text-align: center" class="letra">{{$i->ACuentaBS}}</td>
                <td style="text-align: center" class="letra">{{$i->SaldoBS}}</td>
            </tr>
             @endforeach
            @endif

           @foreach ($totalS[$key] as $y => $t) 
           <tr>
            <td style="text-align: center;border: none;" colspan="3"></td>
            
            <td style="text-align: center;" class="letra">TOTALES</td>
            <td style="text-align: center" class="letra">{{$t->ImporteCXCDolar}}</td>
            <td style="text-align: center" class="letra">{{$t->ACuentaDolar}}</td>
            <td style="text-align: center" class="letra">{{$t->SaldoDolar}}</td>
            <td style="text-align: center" class="letra">{{$t->ImporteCXCBS}}</td>
            <td style="text-align: center" class="letra">{{$t->ACuentaBS}}</td>
            <td style="text-align: center" class="letra">{{$t->SaldoBS}}</td>
           
        </tr>
           @endforeach

        </tbody>
        </tfoot>
        
    </table>
   <p style="padding-top: 20px;text-indent: 25px;font-size: 17px" >Agradecemos comunicar cualquier observación, adjuntando el debido respaldo, caso contrario daremos por confimado el saldo mencionado.</p>
   
   <p style="padding-top: 20px;text-indent: 25px;font-size: 17px">Por lo tanto, corresponde de su parte la debida atención a nuestro requerimiento. Sin otro particular, enviamos un cordial saludo.</p>
   

    <div class="contenedor-imagenes">
         <img alt="foto" src="{{asset('imagenes/firma/fdemo.png')}}" style="width: 60px; " class="imagenT1"/>   
         <img alt="foto" src="{{asset('imagenes/firma/fdemo.png')}}" style="width: 120px; " class="imagenT2"/>   
    </div>


    @endforeach
  

   
  
   

     
  
 


   
</body>


</html>

