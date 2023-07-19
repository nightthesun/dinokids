<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reporte De Ventas</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
    body {
      font-size: 1rem;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col">
        <table style="width:100%">
          <tr valign="middle">
            <td style="width: 20%;">
              <img alt="foto" src="{{asset('imagenes/logo.png')}}" style="width: 100%;
                        height: auto;" />
            </td>
            <td style="width: 60%; text-align: center;">
              <h3 class="text-center">REPORTE DE VENTAS </h3>
              <h6 class="text-center">DEL {{$fini}} AL {{$ffin}}</h6>
            </td>
            <td style="width: 20%; text-align: right;">
            </td>
          </tr>
        </table>
        <table class="table table-sm table-bordered">
          <thead>
            <tr>
              <th>Codigo</th>
              <th>Fecha</th>
              <th>ImpTotal</th>
              <th>DesTotal</th>
              <th>Total</th>
              <th>NomCliente</th>
              <th>RazonSocial</th>
              <th>Nit</th>
              <th>Factura</th>
              <th>Usuario</th>
              <th>Almacen</th>
            </tr>
          </thead>
          <tbody>
            @if($venta)
            @foreach($venta as $c)
            <tr>
              <th>{{$c->vtvtaNtra}} </th>
              <th>{{$c->fecha}}</th>
              <th>{{$c->ImpT}}</th>
              <th>{{$c->DesT}}</th>
              <th>{{$c->total}}</th>
              <th>{{$c->vtvtaNomC}}</th>
              <th>{{$c->imLvtRsoc}}</th>
              <th>{{$c->imLvtNNit}}</th>
              <th>{{$c->factura}}</th>
              <th>{{$c->adusrNomb}}</th>
              <th>{{$c->inalmNomb}}</th>
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