<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .contenedorBottom{
    position: absolute;
    display:block;

}
table {
	width: 10%;
	height: 100%;
}

img.redimension {
  padding-top: 1px;
  position: absolute;

  margin: 0px;
  padding-left: 35px;
    width:890px;
  height:auto;
  color: #000000;
}
        #imagen{
            font-family: Arial;
margin: 35px;
margin-bottom: 10px;
width: 500px;
padding-top: -100px;
padding: 0;
border-width: 0; 

        }
      #margen     {
        font-family: Arial;
margin: 45px;
margin-bottom: 2px;
padding: 0;
border-width: 0;
padding-top: 10px;
}
#margenBottom  {
        font-family: Arial;
margin: 50px;
margin-bottom: 0px;
margin-top: 0px;
padding: 0;
border-width: 0;
}
.text-justify {
  text-align: justify;

  font-size: 0.4cm
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
    <span class="letra" style="font-size: 0.4cm">La Paz {{$fechaH}}</span> 
    <br>      
    <span class="letra" style="font-size: 0.3cm">LYPO /ADM /COB /0{{$conta}} - 2023</span>
    
        <p class="letra" style="font-size: 0.4cm;padding-top: 1.50cm;padding-bottom: 0.1cm;line-height: 140%"
        
        >{{$option}} <br>
        {{$clienteC}}<br>
        <span style="text-decoration: underline">Presente.-</span>
    </p>
       
     
        <H3 style="text-align: right;font-size: 0.4cm" class="letra"> <b>Ref.: <span class="raya;letra" style="text-decoration: underline">ESTADO DE CUENTA CLIENTE</span></b> </H3>
        @if ($option=="Señor")
        <span class="letra;mt-5" style="font-size: 0.4cm;">Distinguido {{$option}}:</span>  
        @endif
        @if ($option=="Señora")
        <span class="letra;mt-5" style="font-size: 0.4cm;">Distinguida {{$option}}:</span>  
        @endif
        @if ($option=="Señores")
        <span class="letra;mt-5" style="font-size: 0.4cm;">Distinguidos {{$option}}:</span>  
        @endif
        <p style="padding-top: 20px; " class="text-justify">
            Por intermedio de la presente, hacemos conocer el estado de cuenta conciliado al {{$fechaC}}. El importe pendiente de pago según nuestros libros contables 
            asciende a USD {{$dolar}} ({{$dolarNu[0]}} {{$dolarNu[1]}} dólares
            americanos), equivalente a Bs. {{$bs}} ({{$bsNu[0]}} {{$bsNu[1]}} bolivianos),
             cuya composición es el siguiente:
          
        </p> 
     
</div>
<h4 style="text-align: center; padding-top: 3px;font-size: 0.4cm;"> <strong class="letra">ESTADO DE CUENTA CLIENTE</strong></h4>
       <h4 style="text-align: center; font-size: 14px"> <strong class="letra" >Al {{$fechaC}}</strong></h4>
    <div style="padding-top: 10px;margin-left: 40px"> 
        <table class = "table table-bordered table-sm"> 
            <thead class="thead-light">
          <tr>
              <td colspan="3" style="text-align: center;background: #d8d8e4; fon
              t-size: 17px" class="letra">FECHA</td>
              <td style="background: #c8c8ea;"></td>
              <td colspan="3"  style="border-inline-color: initial   text-align: center;background: #c8c8ea; font-size: 17px" class="letra">IMPORTE EN DOLARES</td>
              <td colspan="3" style="text-align: center;background: #d8d8e4; font-size: 17px" class="letra">IMPORTE EN BOLIVIANOS</td>
          </tr>
          <tr>
     
              <td style="text-align: center;background: #d8d8e4;font-size: 0.4cm" class="letra">FACTURADO</td>
              <TD style="text-align: center;background: #d8d8e4;font-size: 0.4cm" class="letra">Nro. FACTURA</TD>
              <td style="text-align: center;background: #d8d8e4;font-size: 0.4cm" class="letra">VENCIMIENTO</td>
              <td style="text-align: center;background: #c8c8ea;font-size: 0.4cm " class="letra">ESTADO</td>
              <td style="text-align: center;background: #c8c8ea;font-size: 0.4cm" class="letra">IMPORTE</td>
              <td style="text-align: center;background: #c8c8ea;font-size: 0.4cm" class="letra">A CUENTA</td>
              <td style="text-align: center;background: #c8c8ea;font-size: 0.4cm" class="letra" >SALDO</td>
              <td style="text-align: center;background: #d8d8e4;font-size: 0.4cm" class="letra">IMPORTE</td>
              <td style="text-align: center;background: #d8d8e4;font-size: 0.4cm" class="letra">A CUENTA</td>
              <td style="text-align: center;background: #d8d8e4;font-size: 0.4cm" class="letra">SALDO</td>
              </tr>
          </thead>
          <tbody>
              @foreach ($cxcCarta as $i)
              <tr>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$i->Fecha}}</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$i->NroFac}}</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$i->FechaVenc}}</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$i->estado}}</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$i->ImporteCXCDolar}}</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$i->ACuentaDolar}}</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$i->SaldoDolar}}</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$i->ImporteCXCBS}}</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$i->ACuentaBS}}</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$i->SaldoBS}}</td>
              </tr>
              @endforeach
              @foreach ($totalS as $t)
              <tr>
                  <td style="text-align: center;border: none;" colspan="3"></td>
                  
                  <td style="text-align: center;font-size: 0.4cm" class="letra">TOTALES</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$t->ImporteCXCDolar}}</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$t->ACuentaDolar}}</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$t->SaldoDolar}}</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$t->ImporteCXCBS}}</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$t->ACuentaBS}}</td>
                  <td style="text-align: center;font-size: 0.4cm" class="letra">{{$t->SaldoBS}}</td>
                 
              </tr>  
              @endforeach
              
          </tbody>
  </table>
    </div>     
   
    <div id="margenBottom" >
        <p style="padding-top: 0px;"class="text-justify " >Agradecemos hacernos conocer a la brevedad posible su conformidad, caso contrario adjuntar el respaldo de pagos efectuados y no considerados en el presente estado.</p>
       
    </div>
    <div id="margenBottom" style="position: absolute;margin-top: 10px;word-wrap: break-word">
        <div style="position: relative;" class="contenedorBottom">
            
            <p style="padding-top: 0px;"class="text-justify;">Sin otro en particular, enviamos un cordial saludo.</p>
           <p style="padding-top: 0px;"class="text-justify"> Atentamente,</p>
            <div style="padding-top: 80px;padding-bottom: 0px">
                <p class="text-justify;line-height: 120%">
                    Ernesto Weiberg Jáuregui<br>
                    GERENTE DE ADMINISTRACION Y LOGISTICA <br>
                 
                </p>
                <p style="font-size: 8px;margin-top: 1px;margin-bottom: 0px "class="text-justify line-height: 100%">
                    CC /ARCH <br>
                    ADM/CONT
                </p>
            </div>
        </div>
        
    </div>
  


 
   
    </body> 
    </html>