<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Traspaso</title>
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
            <h1 class="text-center" style="font-weight: bold; font-size: 3rem; letter-spacing: 3px">Traspaso</h1>
            <table style="width:100%">
                <tr valign= "middle"> 
                    <td style="width: 20%;">
                        <img alt="foto" src="{{asset('imagenes/logo.png')}}" style="width: 100%;
                        height: auto;"/>      
                    </td>
                    <td style="">
                        <div style="display: table; margin: 0.3cm; width: 100%">
                            <div style="display: table-cell;">
                                <div style="font-size: 1.5em">
                                    <label for="" style="font-weight: bold">Almacen origen: </label>
                                    <span>{{$alm_origen}}</span>
                                </div>
                                <div style="font-size: 1.5em">
                                    <label for="" style="font-weight: bold">Fecha: </label>
                                    <span>{{$fffin}}</span>
                                </div>
                            </div>
                            <div style="display: table-cell; font-size: 1.5em">
                                <label for="" style="font-weight: bold">Almacen destino: </label>
                                <span>{{$alm_destino}}</span>
                            </div>
                        </div>
                    </td>
                    <td style="width: 20%; text-align: right;">
                        <h4 style="text-align: left; margin-left: 0.5cm;">N°</h4>
                    </td>
                </tr>                       
            </table>
            <table class="table table-sm table-bordered mt-4" style="font-size: 1.3em">
            <thead>
            <tr>
                <th>Categoria</th>
                <th>Codigo</th>
                <th>Descirpcion</th>
                <th>U.M.</th>
                <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($query as $item)
                <tr>
                    <td>{{$item->catprod}}</td>
                    <td>{{$item->codprod}}</td>
                    <td>{{$item->desprod}}</td>
                    <td>{{$item->umprod}}</td>
                    <td>{{$item->canprod}}</td>
                </tr>
            @endforeach         
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