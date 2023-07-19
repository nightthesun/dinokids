@extends('layouts.app')
@section('estilo')
<style>
  body {
    font-size: 1.0rem;
  }
  .derecha td,
  .derecha th {
    text-align: end;
  }

  #table_ventas thead {
    position: sticky;
    top: 0;
    z-index: 10;
  }
  #table_ventas_filter {
    margin-right: 30px;
    position: sticky;
    top: 0;
    z-index: 10;
  }
  #encabezado {
    position: sticky;
    list-style-type: none;
    margin: 0;
    padding: 10;
    top: 10;
    z-index: 10;
  }

  #app {
    display: none;
  }
</style>
@endsection
@section('content')
<div id="encabezado">
  @include('layouts.sidebar2', ['hide'=>'0']) 
</div>

<div class="mt-4 mb-3" style="width: 90%; height: 670px; margin: auto;">
  <div>
    <div style="width: 10%;">
      <img alt="foto" src="{{asset('imagenes/logo.png')}}" style="width: 120%;
                              height: auto;" />
    </div>
    <div>
      <h3 class="text-center">ESTADO DE RESULTADO 2023</h3>
    </div>
  </div>
  <div style="overflow: scroll; height: 85vh; font-size: 12px; width: 100%;">
    <table id="table_ventas" class="table table-striped table-bordered table-sm table-responsive" style="font-size: 12px; width: 100%;">
      <thead class="text-white" style="background-color: #283056;">
        <TR class="text-uppercase" style="letter-spacing: 4px; font-size: 1rem;">
          <TH colspan="1" class="text-center"></TH>
  
          @foreach ($options as $k => $value)
  
          <TH colspan="4" class="text-center">{{$value}}</TH>
          @endforeach
          <TH colspan="4" class="text-center" style="background-color: #284556;">COMPARATIVO ANUAL</TH>
        </TR>
        <TR style="letter-spacing: 3px; font-size: 0.8rem;">
          <TH colspan="1" class="text-center"></TH>
          @foreach ($options as $k => $value)
          <TH colspan="1" class="text-center">COSTO TOTAL</TH>
          <TH colspan="1" class="text-center">VENTA TOTAL</TH>
          <TH colspan="1" class="text-center">DESC. Y DEVOL.</TH>
          <TH colspan="1" class="text-center">DIF. DE CAMBIO</TH>
          @endforeach
          <TH colspan="1" class="text-center" style="background-color: #284556;">COSTO TOTAL</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">VENTA TOTAL</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">DESC. Y DEVOL.</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">DIF. DE CAMBIO</TH>
        </TR>
        <TR class="d-none">
          <Td colspan="1" class="text-center"></Td>
          @foreach ($options as $k => $value)
          <Td colspan="1" class="text-center">{{$value}}</Td>
          <Td colspan="1" class="text-center">{{$value}}</Td>
          <Td colspan="1" class="text-center">{{$value}}</Td>
          <Td colspan="1" class="text-center">{{$value}}</Td>
          @endforeach
          <Td colspan="1" class="text-center" style="background-color: #284556;">Comparativo Anual</Td>
          <Td colspan="1" class="text-center" style="background-color: #284556;">Comparativo Anual</Td>
          <Td colspan="1" class="text-center" style="background-color: #284556;">Comparativo Anual</Td>
          <Td colspan="1" class="text-center" style="background-color: #284556;">Comparativo Anual</Td>
        </TR>
      </thead>
      <tbody>
        <TR class="d-none">
          <TH colspan="1" class="text-center"></TH>
          @foreach ($options as $k => $value)
          <TH colspan="1" class="text-center">COSTO</TH>
          <TH colspan="1" class="text-center">VENTA</TH>
          <TH colspan="1" class="text-center">DESC. Y DEVOL.</TH>
          <TH colspan="1" class="text-center">DIF. DE CAMBIO</TH>
          @endforeach
          <TH colspan="1" class="text-center" style="background-color: #284556;">COSTO</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">VENTA</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">DESC. Y DEVOL.</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">DIF. DE CAMBIO</TH>
        </TR>
        <tr class="bg-primary text-end text-white" style="font-weight: bold;">
          <td class="text-start" style="width: 14%;">SUMA GENERAL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
          
          <td>{{ $total_general[0]->$val1}}</td>
          <td>{{ $total_general[0]->$val2}}</td>
          <td>{{ $total_general[0]->$val3}}</td>
          <td>{{ $total_general[0]->$val4}}</td>
          @endforeach
          <td>{{ $total_general[0]->TotC2}}</td>
          <td>{{ $total_general[0]->Tot2}}</td>
          <td>{{ $total_general[0]->TotVDesc}}</td>
          <td>{{ $total_general[0]->TotImp}}</td>
        </tr>
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">SUCURSAL BALLIVIAN</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
  
          <td>{{ $total[0]['BALLIVIAN'][0]->$val1 }}</td>
          <td>{{ $total[0]['BALLIVIAN'][0]->$val2 }}</td>
          <td>{{ $total[0]['BALLIVIAN'][0]->$val3 }}</td>
          <td>{{ $total[0]['BALLIVIAN'][0]->$val4 }}</td>
          @endforeach
  
          <td>{{ $total[0]['BALLIVIAN'][0]->TotC2 }}</td>
          <td>{{ $total[0]['BALLIVIAN'][0]->Tot2 }}</td>
          <td>{{ $total[0]['BALLIVIAN'][0]->TotVDesc }}</td>
          <td>{{ $total[0]['BALLIVIAN'][0]->TotImp }}</td>
        </tr>
        @foreach ($total_seg[0]['BALLIVIAN'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
  
          <td>{{ $val->$val1 }}</td>
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          @endforeach
          
          <td>{{ $val->TotC2 }}</td>
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->TotVDesc }}</td>
          <td>{{ $val->TotImp }}</td>
        </tr>
        @endforeach
        <tr class="text-end">
          <td class="text-start">RETAIL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
          
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->$val1 }}</td>
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->$val2 }}</td>
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->$val3 }}</td>
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->$val4 }}</td>
          @endforeach
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->TotC2 }}</td>
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->Tot2 }}</td>
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->TotVDesc }}</td>
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->TotImp }}</td>
        </tr>
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">SUCURSAL HANDAL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
  
          <td>{{ $total[1]['HANDAL'][0]->$val1 }}</td>
          <td>{{ $total[1]['HANDAL'][0]->$val2 }}</td>
          <td>{{ $total[1]['HANDAL'][0]->$val3 }}</td>
          <td>{{ $total[1]['HANDAL'][0]->$val4 }}</td>
          @endforeach
          <td>{{ $total[1]['HANDAL'][0]->TotC2 }}</td>
          <td>{{ $total[1]['HANDAL'][0]->Tot2 }}</td>
          <td>{{ $total[1]['HANDAL'][0]->TotVDesc }}</td>
          <td>{{ $total[1]['HANDAL'][0]->TotImp }}</td>
        </tr>
        @foreach ($total_seg[1]['HANDAL'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
          <!--datp-->

          <td>{{ $val->$val1 }}</td>
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          @endforeach
          <td>{{ $val->TotC2 }}</td>
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->TotVDesc }}</td>
          <td>{{ $val->TotImp }}</td>
        </tr>
        @endforeach
        <tr class="text-end">
          <td class="text-start">RETAIL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
  
          <td>{{ $total_retail[1]['HANDAL'][0]->$val1 }}</td>
          <td>{{ $total_retail[1]['HANDAL'][0]->$val2 }}</td>
          <td>{{ $total_retail[1]['HANDAL'][0]->$val3 }}</td>
          <td>{{ $total_retail[1]['HANDAL'][0]->$val4 }}</td>
          @endforeach
          <td>{{ $total_retail[1]['HANDAL'][0]->TotC2 }}</td>
          <td>{{ $total_retail[1]['HANDAL'][0]->Tot2 }}</td>
          <td>{{ $total_retail[1]['HANDAL'][0]->TotVDesc }}</td>
          <td>{{ $total_retail[1]['HANDAL'][0]->TotImp }}</td>
        </tr>
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">SUCURSAL MARISCAL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
  
          <td>{{ $total[2]['MARISCAL'][0]->$val1 }}</td>
          <td>{{ $total[2]['MARISCAL'][0]->$val2 }}</td>
          <td>{{ $total[2]['MARISCAL'][0]->$val3 }}</td>
          <td>{{ $total[2]['MARISCAL'][0]->$val4 }}</td>
          @endforeach
          <td>{{ $total[2]['MARISCAL'][0]->TotC2 }}</td>
          <td>{{ $total[2]['MARISCAL'][0]->Tot2 }}</td>
          <td>{{ $total[2]['MARISCAL'][0]->TotVDesc }}</td>
          <td>{{ $total[2]['MARISCAL'][0]->TotImp }}</td>
        </tr>
        @foreach ($total_seg[2]['MARISCAL'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp

          <td>{{ $val->$val1 }}</td>
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          @endforeach
          <td>{{ $val->TotC2 }}</td>
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->TotVDesc }}</td>
          <td>{{ $val->TotImp }}</td>
        </tr>
        @endforeach
        <tr class="text-end">
          <td class="text-start">RETAIL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
          
          <td>{{ $total_retail[2]['MARISCAL'][0]->$val1 }}</td>
          <td>{{ $total_retail[2]['MARISCAL'][0]->$val2 }}</td>
          <td>{{ $total_retail[2]['MARISCAL'][0]->$val3 }}</td>
          <td>{{ $total_retail[2]['MARISCAL'][0]->$val4 }}</td>
          @endforeach
          <td>{{ $total_retail[2]['MARISCAL'][0]->TotC2 }}</td>
          <td>{{ $total_retail[2]['MARISCAL'][0]->Tot2 }}</td>
          <td>{{ $total_retail[2]['MARISCAL'][0]->TotVDesc }}</td>
          <td>{{ $total_retail[2]['MARISCAL'][0]->TotImp }}</td>
        </tr>
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">SUCURSAL CALACOTO</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
  
          <td>{{ $total[3]['CALACOTO'][0]->$val1 }}</td>
          <td>{{ $total[3]['CALACOTO'][0]->$val2 }}</td>
          <td>{{ $total[3]['CALACOTO'][0]->$val3 }}</td>
          <td>{{ $total[3]['CALACOTO'][0]->$val4 }}</td>
          @endforeach
          <td>{{ $total[3]['CALACOTO'][0]->TotC2 }}</td>
          <td>{{ $total[3]['CALACOTO'][0]->Tot2 }}</td>
          <td>{{ $total[3]['CALACOTO'][0]->TotVDesc }}</td>
          <td>{{ $total[3]['CALACOTO'][0]->TotImp }}</td>
        </tr>
        @foreach ($total_seg[3]['CALACOTO'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
  
          <td>{{ $val->$val1 }}</td>
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
  
          @endforeach
          <td>{{ $val->TotC2 }}</td>
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->TotVDesc }}</td>
          <td>{{ $val->TotImp }}</td>
        </tr>
        @endforeach
        <tr class="text-end">
          <td class="text-start">INS CALACOTO</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
          
          <td>{{ $total_retail_calacoto[0]->$val1 }}</td>
          <td>{{ $total_retail_calacoto[0]->$val2}}</td>
          <td>{{ $total_retail_calacoto[0]->$val3}}</td>
          <td>{{ $total_retail_calacoto[0]->$val4}}</td>
          @endforeach
          <td>{{ $total_retail_calacoto[0]->TotC2 }}</td>
          <td>{{ $total_retail_calacoto[0]->Tot2 }}</td>
          <td>{{ $total_retail_calacoto[0]->TotVDesc }}</td>
          <td>{{ $total_retail_calacoto[0]->TotImp }}</td>
        </tr>
        <tr class="text-end">
          <td class="text-start">RETAIL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
  
          <td>{{ $total_retail[3]['CALACOTO'][0]->$val1 }}</td>
          <td>{{ $total_retail[3]['CALACOTO'][0]->$val2 }}</td>
          <td>{{ $total_retail[3]['CALACOTO'][0]->$val3 }}</td>
          <td>{{ $total_retail[3]['CALACOTO'][0]->$val4 }}</td>
          @endforeach
          <td>{{ $total_retail[3]['CALACOTO'][0]->TotC2 }}</td>
          <td>{{ $total_retail[3]['CALACOTO'][0]->Tot2 }}</td>
          <td>{{ $total_retail[3]['CALACOTO'][0]->TotVDesc }}</td>
          <td>{{ $total_retail[3]['CALACOTO'][0]->TotImp }}</td>
        </tr>
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">SUCURSAL SAN MIGUEL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
          <td>{{ $total[4]['SAN MIGUEL'][0]->$val1 }}</td>
          <td>{{ $total[4]['SAN MIGUEL'][0]->$val2 }}</td>
          <td>{{ $total[4]['SAN MIGUEL'][0]->$val3 }}</td>
          <td>{{ $total[4]['SAN MIGUEL'][0]->$val4 }}</td>
          @endforeach
          <td>{{ $total[4]['SAN MIGUEL'][0]->TotC2 }}</td>
          <td>{{ $total[4]['SAN MIGUEL'][0]->Tot2 }}</td>
          <td>{{ $total[4]['SAN MIGUEL'][0]->TotVDesc }}</td>
          <td>{{ $total[4]['SAN MIGUEL'][0]->TotImp }}</td>
        </tr>
        @foreach ($total_seg[4]['SAN MIGUEL'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
          <td>{{ $val->$val1 }}</td>
          <td>{{ $val->$val2 }} </td>
          <td>{{ $val->$val3 }} </td>
          <td>{{ $val->$val4 }} </td>
          @endforeach
          <td>{{ $val->TotC2 }}</td>
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->TotVDesc }}</td>
          <td>{{ $val->TotImp }}</td>
        </tr>
        @endforeach
        <tr class="text-end">
          <td class="text-start">RETAIL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->$val1 }}</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->$val2 }}</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->$val3 }}</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->$val4 }}</td>
          @endforeach
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->TotC2 }}</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->Tot2 }}</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->TotVDesc }}</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->TotImp }}</td>
        </tr>
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">INSTITUCIONALES</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
  
          <td>{{ $total[5]['INSTITUCIONALES'][0]->$val1 }}</td>
          <td>{{ $total[5]['INSTITUCIONALES'][0]->$val2 }}</td>
          <td>{{ $total[5]['INSTITUCIONALES'][0]->$val3 }}</td>
          <td>{{ $total[5]['INSTITUCIONALES'][0]->$val4 }}</td>
          @endforeach
          <td>{{ $total[5]['INSTITUCIONALES'][0]->TotC2 }}</td>
          <td>{{ $total[5]['INSTITUCIONALES'][0]->Tot2 }}</td>
          <td>{{ $total[5]['INSTITUCIONALES'][0]->TotVDesc }}</td>
          <td>{{ $total[5]['INSTITUCIONALES'][0]->TotImp }}</td>
        </tr>
        @foreach ($total_seg[5]['INSTITUCIONALES'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
  
          <td>{{ $val->$val1 }}</td>
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          @endforeach
          <td>{{ $val->TotC2 }}</td>
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->TotVDesc }}</td>
          <td>{{ $val->TotImp }}</td>
        </tr>
        @endforeach
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">MAYORISTAS</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
  
          <td>{{ $total[6]['MAYORISTAS'][0]->$val1 }}</td>
          <td>{{ $total[6]['MAYORISTAS'][0]->$val2 }}</td>
          <td>{{ $total[6]['MAYORISTAS'][0]->$val3 }}</td>
          <td>{{ $total[6]['MAYORISTAS'][0]->$val4 }}</td>
          @endforeach
          <td>{{ $total[6]['MAYORISTAS'][0]->TotC2 }}</td>
          <td>{{ $total[6]['MAYORISTAS'][0]->Tot2 }}</td>
          <td>{{ $total[6]['MAYORISTAS'][0]->TotVDesc }}</td>
          <td>{{ $total[6]['MAYORISTAS'][0]->TotImp }}</td>
        </tr>
        @foreach ($total_seg[6]['MAYORISTAS'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
  
          <td>{{ $val->$val1 }}</td>
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          @endforeach
          <td>{{ $val->TotC2 }}</td>
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->TotVDesc }}</td>
          <td>{{ $val->TotImp }}</td>
        </tr>
        @endforeach
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">SANTA CRUZ</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
          <td>{{ $total[7]['SANTA CRUZ'][0]->$val1 }}</td>
          <td>{{ $total[7]['SANTA CRUZ'][0]->$val2 }}</td>
          <td>{{ $total[7]['SANTA CRUZ'][0]->$val3 }}</td>
          <td>{{ $total[7]['SANTA CRUZ'][0]->$val4 }}</td>
          @endforeach
          <td>{{ $total[7]['SANTA CRUZ'][0]->TotC2 }}</td>
          <td>{{ $total[7]['SANTA CRUZ'][0]->Tot2 }}</td>
          <td>{{ $total[7]['SANTA CRUZ'][0]->TotVDesc }}</td>
          <td>{{ $total[7]['SANTA CRUZ'][0]->TotImp }}</td>
        </tr>
        @foreach ($total_seg[7]['SANTA CRUZ'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
          <td>{{ $val->$val1 }}</td>
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          @endforeach
          <td>{{ $val->TotC2 }}</td>
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->TotVDesc }}</td>
          <td>{{ $val->TotImp }}</td>
        </tr>
        @endforeach
  
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">REGIONAL 1</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
          <td>{{ $total_regional[0]['REGIONAL1'][0]->$val1 }}</td>
          <td>{{ $total_regional[0]['REGIONAL1'][0]->$val2 }}</td>
          <td>{{ $total_regional[0]['REGIONAL1'][0]->$val3 }}</td>
          <td>{{ $total_regional[0]['REGIONAL1'][0]->$val4 }}</td>
          @endforeach
          <td>{{ $total_regional[0]['REGIONAL1'][0]->TotC2 }}</td>
          <td>{{ $total_regional[0]['REGIONAL1'][0]->Tot2 }}</td>
          <td>{{ $total_regional[0]['REGIONAL1'][0]->TotVDesc }}</td>
          <td>{{ $total_regional[0]['REGIONAL1'][0]->TotImp }}</td>
        </tr>
        @foreach ($total_seg_regional[0]['REGIONAL1'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->inalmNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
          <td>{{ $val->$val1 }}</td>
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          @endforeach
          <td>{{ $val->TotC2 }}</td>
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->TotVDesc }}</td>
          <td>{{ $val->TotImp }}</td>
        </tr>
        @endforeach
 
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">REGIONAL 2</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
          <td>{{ $total_regional[1]['REGIONAL2'][0]->$val1 }}</td>
          <td>{{ $total_regional[1]['REGIONAL2'][0]->$val2 }}</td>
          <td>{{ $total_regional[1]['REGIONAL2'][0]->$val3 }}</td>
          <td>{{ $total_regional[1]['REGIONAL2'][0]->$val4 }}</td>
          @endforeach
          <td>{{ $total_regional[1]['REGIONAL2'][0]->TotC2 }}</td>
          <td>{{ $total_regional[1]['REGIONAL2'][0]->Tot2 }}</td>
          <td>{{ $total_regional[1]['REGIONAL2'][0]->TotVDesc }}</td>
          <td>{{ $total_regional[1]['REGIONAL2'][0]->TotImp }}</td>
        </tr>
        @foreach ($total_seg_regional[1]['REGIONAL2'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->inalmNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."C2";
          $val2 = $value."2";
          $val3 = $value."VDesc";
          $val4 = $value."Imp";
          @endphp
          <td>{{ $val->$val1 }}</td>
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          @endforeach
          <td>{{ $val->TotC2 }}</td>
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->TotVDesc }}</td>
          <td>{{ $val->TotImp }}</td>
        </tr>
        @endforeach


     


      </tbody>
    </table>
  </div>
</div>

@section('mis_scripts')



<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.2/js/buttons.html5.styles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.2/js/buttons.html5.styles.templates.min.js"></script>

<script>
    
  $(document).ready(function() {
    $('#table_ventas').DataTable({
      "ordering": false,
      dom: 'Bfrtip',
      buttons: {
        dom: {
          button: {
            className: 'btn'
          }
        },
        buttons: [{
         
            
          extend: "excel",
          text: 'Exportar a Excel',
          className: 'btn btn-outline-primary mb-4',
          excelStyles: {                      
                cells: [2,4,5,17,21,25,29,32,40,47,50,53],                     
                style: {                      
                    font: {                     
                        name: "Arial",         
                        size: "12",         
                        color: "FFFFFF",       
                        b: false,             
                    },
                    fill: {                     
                        pattern: {              
                            color: "548236",   
                        }
                    }
                }
            },
      
        }]
      },
      "aLengthMenu": [100],
      "paging": false,
      "info": false,
      searching: false,
    });
  });


  var sum = 0;
  $('.ss').each(function() {
    sum += parseFloat($(this).text().replace(/,/g, ''), 10);
  });
  $("#t").val(sum.toFixed(2));

  
</script>

@endsection
