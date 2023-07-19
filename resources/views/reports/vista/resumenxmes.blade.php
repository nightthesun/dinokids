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

  .subTitulos{
    background-color: #bdeeb4 !important;
  }

  #app {
    display: none;
  }

  .contenedor_tabla::-webkit-scrollbar {
    -webkit-appearance: none;
    color: red;
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
      <h3 class="text-center">COMPARATIVO DE VENTAS</h3>
    </div>
  </div>
  <div class="contenedor_tabla" style="overflow: scroll; height: 85vh; font-size: 12px; width: 100%;">
    <table id="table_ventas" class="table table-striped table-bordered table-sm table-responsive" style="font-size: 12px; width: 100%;">
      <thead class="text-white" style="background-color: #283056;">
        <TR class="text-uppercase" style="letter-spacing: 4px; font-size: 1rem;">
          <TH colspan="1" class="text-center"></TH>
  
          @foreach ($options as $k => $value)
  
          <TH colspan="7" class="text-center">{{$value}}</TH>
          @endforeach
          <TH colspan="7" class="text-center" style="background-color: #284556;">COMPARATIVO ANUAL</TH>
        </TR>
        <TR  style="letter-spacing: 3px; font-size: 0.8rem;">
          <TH colspan="1" class="text-center"></TH>
          @foreach ($options as $k => $value)
          <TH colspan="1" class="text-center">2019</TH>
          <TH colspan="1" class="text-center">2020</TH>
          <TH colspan="1" class="text-center">2021</TH>
          <TH colspan="1" class="text-center">2022</TH>
          <TH colspan="1" class="text-center">2023</TH>
          <TH colspan="1" class="text-center" style="background-color: #2f5628;">C/Factura</TH>
          <TH colspan="1" class="text-center" style="background-color: #2f5628;">S/Factura</TH>
          @endforeach
          <TH colspan="1" class="text-center" style="background-color: #284556;">2019</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">2020</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">2021</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">2022</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">2023</TH>
          <TH colspan="1" class="text-center" style="background-color: #2f5628;">C/Factura</TH>
          <TH colspan="1" class="text-center" style="background-color: #2f5628;">S/Factura</TH>
        </TR>
        <TR class="d-none">
          <Td colspan="1" class="text-center"></Td>
          @foreach ($options as $k => $value)
          <Td colspan="1" class="text-center">{{$value}}</Td>
          <Td colspan="1" class="text-center">{{$value}}</Td>
          <Td colspan="1" class="text-center">{{$value}}</Td>
          <Td colspan="1" class="text-center">{{$value}}</Td>
          <Td colspan="1" class="text-center">{{$value}}</Td>
          <Td colspan="1" class="text-center">{{$value}}</Td>
          <Td colspan="1" class="text-center">{{$value}}</Td>
          @endforeach
          <Td colspan="1" class="text-center" style="background-color: #284556;">Comparativo Anual</Td>
          <Td colspan="1" class="text-center" style="background-color: #284556;">Comparativo Anual</Td>
          <Td colspan="1" class="text-center" style="background-color: #284556;">Comparativo Anual</Td>
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
          <TH colspan="1" class="text-center">2019</TH>
          <TH colspan="1" class="text-center">2020</TH>
          <TH colspan="1" class="text-center">2021</TH>
          <TH colspan="1" class="text-center">2022</TH>
          <TH colspan="1" class="text-center">2023</TH>
          <TH colspan="1" class="text-center">C/Factura</TH>
          <TH colspan="1" class="text-center">S/Factura</TH>
          @endforeach
          <TH colspan="1" class="text-center" style="background-color: #284556;">2019</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">2020</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">2021</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">2022</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">2023</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">C/Factura</TH>
          <TH colspan="1" class="text-center" style="background-color: #284556;">S/Factura</TH>
        </TR>
        <tr class="bg-primary text-end text-white" style="font-weight: bold;">
          <td class="text-start" style="width: 14%;">SUMA GENERAL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
          
          @if ($value=="Enero")
          <td>2,753,203.51</td>
          <td>3,501,978.87</td>
          <td>1,661,741.90</td>
          @endif
  
          @if ($value=="Febrero")
          <td>3,690,534.65</td>
          <td>3,339,620.77</td>
          <td>2,938,376.85</td>
          @endif
  
          @if ($value=="Marzo")
          <td>1,929,459.84</td>
          <td>1,269,142.77</td>
          @endif
  
          @if ($value=="Abril")
          <td>1,581,310.05</td>
          <td>111,057.54</td>
          @endif
  
          @if ($value=="Mayo")
          <td>1,958,141.59</td>
          <td>289,676.01</td>
          @endif
  
          @if ($value=="Junio")
          <td>1,563,195.93</td>
          <td>1,504,953.56</td>
          @endif
  
          @if ($value=="Julio")
          <td>1,575,554.74</td>
          <td>1,168,345.80</td>
          @endif
  
          @if ($value=="Agosto")
          <td>1,590,542.15</td>
          <td>929,566.97</td>
          @endif
  
          @if ($value=="Septiembre")
          <td>2,025,149.27</td>
          <td>1,392,327.09</td>
          @endif
  
          @if ($value=="Octubre")
          <td>1,425,608.71</td>
          <td>1,482,422.55</td>
          @endif
  
          @if ($value=="Noviembre")
          <td>1,317,562.52</td>
          <td>2,212,951.67</td>
          @endif
  
          @if ($value=="Diciembre")
          <td>1,803,605.94</td>
          <td>1,695,077.25</td>
          @endif
          
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $total_general[0]->$val1}}</td>
          @endif
          <td>{{ $total_general[0]->$val2}}</td>
          <td>{{ $total_general[0]->$val3}}</td>
          <td style="background-color: #3b9635;">{{ $total_general[0]->$val4}}</td>
          <td style="background-color: #3b9635;">{{ $total_general[0]->$val5}}</td>
          @endforeach
          <td>{{ number_format($sumGeneral19, 2) }}</td>
          <td>{{ number_format($sumGeneral20, 2) }}</td>
          <td>{{ number_format($total_general[0]->Tot1 + $sumGeneral21, 2) }}</td>
          <td>{{ $total_general[0]->Tot2}}</td>
          <td>{{ $total_general[0]->Tot3}}</td>
          <td style="background-color: #3b9635;">{{ $total_general[0]->Tot4}}</td>
          <td style="background-color: #3b9635;">{{ $total_general[0]->Tot5}}</td>
        </tr>
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">SUCURSAL BALLIVIAN</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          <td>407,460.98</td>
          <td>231,746.39</td>
          <td>142,423.02</td>
          @endif
  
          @if ($value=="Febrero")
          <td>588,532.16</td>
          <td>507,731.51</td>
          <td>306,473.91</td>
          @endif
  
          @if ($value=="Marzo")
          <td>190,795.80</td>
          <td>128,066.42 </td>
          @endif
  
          @if ($value=="Abril")
          <td>161,199.49</td>
          <td>0.00</td>
          @endif
  
          @if ($value=="Mayo")
          <td>130,247.12</td>
          <td>723.02</td>
          @endif
  
          @if ($value=="Junio")
          <td>150,236.76</td>
          <td>113,389.69</td>
          @endif
  
          @if ($value=="Julio")
          <td>141,357.51</td>
          <td>92,619.62</td>
          @endif
  
          @if ($value=="Agosto")
          <td>159,763.92</td>
          <td>76,494.68</td>
          @endif
  
          @if ($value=="Septiembre")
          <td>209,057.39</td>
          <td>116,231.47</td>
          @endif
  
          @if ($value=="Octubre")
          <td>132,808.72</td>
          <td>95,066.21</td>
          @endif
  
          @if ($value=="Noviembre")
          <td>128,258.66</td>
          <td>195,058.58</td>
          @endif
  
          @if ($value=="Diciembre")
          <td>169,932.69</td>
          <td>137,845.04</td>
          @endif
   
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $total[0]['BALLIVIAN'][0]->$val1 }}</td>
          @endif
          <td>{{ $total[0]['BALLIVIAN'][0]->$val2 }}</td>
          <td>{{ $total[0]['BALLIVIAN'][0]->$val3 }}</td>
          <td class="subTitulos">{{ $total[0]['BALLIVIAN'][0]->$val4 }}</td>
          <td class="subTitulos">{{ $total[0]['BALLIVIAN'][0]->$val5 }}</td>
          @endforeach
  
          <td>{{ number_format($sumBall19, 2) }}</td>
          <td>{{ number_format($sumBall20, 2) }}</td>
  
          <td>{{ number_format($total[0]['BALLIVIAN'][0]->Tot1 + $sumBall21, 2) }}</td>
          <td>{{ $total[0]['BALLIVIAN'][0]->Tot2 }}</td>
          <td>{{ $total[0]['BALLIVIAN'][0]->Tot3 }}</td>
          <td class="subTitulos">{{ $total[0]['BALLIVIAN'][0]->Tot4 }}</td>
          <td class="subTitulos">{{ $total[0]['BALLIVIAN'][0]->Tot5 }}</td>
        </tr>
        @foreach ($total_seg[0]['BALLIVIAN'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          @if ($val->adusrNomb=="CAJERO FERIA 2")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="AUXILIAR III")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO FERIA")
          <td>176,193.96</td>
          <td>14,004.66 </td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO BALLIVIAN")
          <td>34,681.10</td>
          <td>51,279.30</td>
          <td>11,546.90</td>
          @endif
          @if ($val->adusrNomb=="INS BALLIVIAN")
          <td>10,541.11</td>
          <td>11,060.06</td>
          <td>20,685.00</td>
          @endif
          @if ($val->adusrNomb=="JOSE TICONIPA")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="KEVIN ALIAGA")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
          @if ($value=="Febrero")
          @if ($val->adusrNomb=="CAJERO FERIA 2")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="AUXILIAR III")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO FERIA")
          <td>87,893.05</td>
          <td>29,623.95</td>
          <td>4,201.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO BALLIVIAN")
          <td>226,669.10</td>
          <td>244,799.70</td>
          <td>136,346.80</td>
          @endif
          @if ($val->adusrNomb=="INS BALLIVIAN")
          <td>4,982.37</td>
          <td>14,108.67</td>
          <td>4,530.41</td>
          @endif
          @if ($val->adusrNomb=="JOSE TICONIPA")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="KEVIN ALIAGA")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
          @if ($value=="Marzo")
          @if ($val->adusrNomb=="CAJERO FERIA 2")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="AUXILIAR III")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO FERIA")
          <td>13,517.70</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO BALLIVIAN")
          <td>53,699.00</td>
          <td>37,423.20</td>
          @endif
          @if ($val->adusrNomb=="INS BALLIVIAN")
          <td>5,025.15</td>
          <td>31,481.55</td>
          @endif
          @if ($val->adusrNomb=="JOSE TICONIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="KEVIN ALIAGA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
          @if ($value=="Abril")
          @if ($val->adusrNomb=="CAJERO FERIA 2")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="AUXILIAR III")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO FERIA")
          <td>5,163.70</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO BALLIVIAN")
          <td>20,797.80</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="INS BALLIVIAN")
          <td>7,765.69</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="JOSE TICONIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="KEVIN ALIAGA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
          @if ($value=="Mayo")
          @if ($val->adusrNomb=="CAJERO FERIA 2")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="AUXILIAR III")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO FERIA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO BALLIVIAN")
          <td>18,148.70</td>
          <td>611.30</td>
          @endif
          @if ($val->adusrNomb=="INS BALLIVIAN")
          <td>10,391.18</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="JOSE TICONIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="KEVIN ALIAGA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
          @if ($value=="Junio")
          @if ($val->adusrNomb=="CAJERO FERIA 2")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="AUXILIAR III")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO FERIA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO BALLIVIAN")
          <td>9,921.65</td>
          <td>13,355.80</td>
          @endif
          @if ($val->adusrNomb=="INS BALLIVIAN")
          <td>34,635.60</td>
          <td>4,043.40</td>
          @endif
          @if ($val->adusrNomb=="JOSE TICONIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="KEVIN ALIAGA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
          @if ($value=="Julio")
          @if ($val->adusrNomb=="CAJERO FERIA 2")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="AUXILIAR III")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO FERIA")
          <td>0.00</td>
          <td>0.00 </td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO BALLIVIAN")
          <td>13,390.90</td>
          <td>6,754.60</td>
          @endif
          @if ($val->adusrNomb=="INS BALLIVIAN")
          <td>5,667.62</td>
          <td>36,627.93</td>
          @endif
          @if ($val->adusrNomb=="JOSE TICONIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="KEVIN ALIAGA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
          @if ($value=="Agosto")
          @if ($val->adusrNomb=="CAJERO FERIA 2")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="AUXILIAR III")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO FERIA")
          <td>39,651.95</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO BALLIVIAN")
          <td>9,987.60</td>
          <td>6,584.40</td>
          @endif
          @if ($val->adusrNomb=="INS BALLIVIAN")
          <td>6,171.23</td>
          <td>12,191.53</td>
          @endif
          @if ($val->adusrNomb=="JOSE TICONIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="KEVIN ALIAGA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
          @if ($value=="Septiembre")
          @if ($val->adusrNomb=="CAJERO FERIA 2")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="AUXILIAR III")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO FERIA")
          <td>6,011.16</td>
          <td>0,00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO BALLIVIAN")
          <td>29,328.05</td>
          <td>9,148.90</td>
          @endif
          @if ($val->adusrNomb=="INS BALLIVIAN")
          <td>51,452.55</td>
          <td>14,319.95</td>
          @endif
          @if ($val->adusrNomb=="JOSE TICONIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="KEVIN ALIAGA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
          @if ($value=="Octubre")
          @if ($val->adusrNomb=="CAJERO FERIA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO FERIA 2")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="AUXILIAR III")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO BALLIVIAN")
          <td>13,426.50</td>
          <td>14,298.98</td>
          @endif
          @if ($val->adusrNomb=="INS BALLIVIAN")
          <td>9,205.80</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="JOSE TICONIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="KEVIN ALIAGA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
          @if ($value=="Noviembre")
          @if ($val->adusrNomb=="CAJERO FERIA 2")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="AUXILIAR III")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO FERIA")
          <td>0.00</td>
          <td>0.00 </td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO BALLIVIAN")
          <td>3,546.10</td>
          <td>12,334.70</td>
          @endif
          @if ($val->adusrNomb=="INS BALLIVIAN")
          <td>23,525.70</td>
          <td>770.06</td>
          @endif
          @if ($val->adusrNomb=="JOSE TICONIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="KEVIN ALIAGA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
          @if ($value=="Diciembre")
          @if ($val->adusrNomb=="CAJERO FERIA 2")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="AUXILIAR III")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO FERIA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO BALLIVIAN")
          <td>11,672.55</td>
          <td>8,234.82</td>
          @endif
          @if ($val->adusrNomb=="INS BALLIVIAN")
          <td>14,567.71</td>
          <td>12,965.31</td>
          @endif
          @if ($val->adusrNomb=="JOSE TICONIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="KEVIN ALIAGA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $val->$val1 }}</td>
          @endif
  
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          <td>{{ $val->$val5 }}</td>
          @endforeach
  
          @if ($val->adusrNomb=="CAJERO FERIA 2")
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ number_format($total_seg[0]['BALLIVIAN'][0]->Tot1, 2) }}</td>
          @endif
          @if ($val->adusrNomb=="AUXILIAR III")
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ number_format($total_seg[0]['BALLIVIAN'][1]->Tot1, 2) }}</td>
          @endif
          @if ($val->adusrNomb=="CAJERO FERIA")
          <td>{{ number_format($arrayball19['feria'], 2) }}</td>
          <td>{{ number_format($arrayball20['feria'], 2) }}</td>
          <td>{{ number_format($total_seg[0]['BALLIVIAN'][0]->Tot1 + $arrayball21['feria'], 2) }}</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO BALLIVIAN")
          <td>{{ number_format($arrayball19['libros'], 2) }}</td>
          <td>{{ number_format($arrayball20['libros'], 2) }}</td>
          <td>{{ number_format($total_seg[0]['BALLIVIAN'][1]->Tot1 + $arrayball21['libros'], 2) }}</td>
          @endif
          @if ($val->adusrNomb=="INS BALLIVIAN")
          <td>{{ number_format($arrayball19['instit'], 2) }}</td>
          <td>{{ number_format($arrayball20['instit'], 2) }}</td>
          <td>{{ number_format($total_seg[0]['BALLIVIAN'][2]->Tot1 + $arrayball21['instit'], 2) }}</td>
          @endif
          
          @if ($val->adusrNomb=="JOSE TICONIPA")
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ number_format($total_seg[0]['BALLIVIAN'][3]->Tot1, 2) }}</td>
          @endif
          @if ($val->adusrNomb=="KEVIN ALIAGA")
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ number_format($total_seg[0]['BALLIVIAN'][4]->Tot1, 2) }}</td>
          @endif
  
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->Tot3 }}</td>
          <td>{{ $val->Tot4 }}</td>
          <td>{{ $val->Tot5 }}</td>
        </tr>
        @endforeach
        <tr class="text-end">
          <td class="text-start">RETAIL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
          @if ($value=="Enero")
          <td>186,044.81</td>
          <td>155,402.37</td>
          <td>110,191.12</td>
          @endif
          @if ($value=="Febrero")
          <td>268,987.64</td>
          <td>219,199.19</td>
          <td>161,395.70</td>
          @endif
          @if ($value=="Marzo")
          <td>118,553.95</td>
          <td>59,161.67</td>
          @endif
          @if ($value=="Abril")
          <td>127,472.30</td>
          <td>0.00</td>
          @endif
          @if ($value=="Mayo")
          <td>101,707.24</td>
          <td>111.72</td>
          @endif
          @if ($value=="Junio")
          <td>105,679.51</td>
          <td>95,990.49</td>
          @endif
          @if ($value=="Julio")
          <td>122,298.99</td>
          <td>49,237.09</td>
          @endif
          @if ($value=="Agosto")
          <td>103,953.14</td>
          <td>57,718.75</td>
          @endif
          @if ($value=="Septiembre")
          <td>122,265.63</td>
          <td>92,762.62</td>
          @endif
          @if ($value=="Octubre")
          <td>110,176.42</td>
          <td>80,767.23</td>
          @endif
          @if ($value=="Noviembre")
          <td>101,186.86</td>
          <td>181,953.82</td>
          @endif
          @if ($value=="Diciembre")
          <td>143,692.43</td>
          <td>116,644.91</td>
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->$val1 }}</td>
          @endif
  
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->$val2 }}</td>
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->$val3 }}</td>
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->$val4 }}</td>
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->$val5 }}</td>
          @endforeach
          <td>{{ number_format($arrayball19['retail'], 2) }}</td>
          <td>{{ number_format($arrayball20['retail'], 2) }}</td>
          <td>{{ number_format($total_retail[0]['BALLIVIAN'][0]->Tot1 + $arrayball21['retail'], 2) }}</td>
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->Tot2 }}</td>
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->Tot3 }}</td>
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->Tot4 }}</td>
          <td>{{ $total_retail[0]['BALLIVIAN'][0]->Tot5 }}</td>
        </tr>
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">SUCURSAL HANDAL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          <td>365,871.20</td>
          <td>446,943.12</td>
          <td>251,026.85</td>
          @endif
  
          @if ($value=="Febrero")
          <td>750,550.51</td>
          <td>540,448.50</td>
          <td>475.077,05</td>
          @endif
  
          @if ($value=="Marzo")
          <td>391,014.96</td>
          <td>163,066.58</td>
          @endif
  
          @if ($value=="Abril")
          <td>312,358.73</td>
          <td>91,052.94</td>
          @endif
  
          @if ($value=="Mayo")
          <td>230,742.98</td>
          <td>91,253.36</td>
          @endif
  
          @if ($value=="Junio")
          <td>261,394.47</td>
          <td>205,317.17</td>
          @endif
  
          @if ($value=="Julio")
          <td>337,662.17</td>
          <td>192,982.81</td>
          @endif
  
          @if ($value=="Agosto")
          <td>292,224.92</td>
          <td>236,323.71</td>
          @endif
  
          @if ($value=="Septiembre")
          <td>461,092.81</td>
          <td>326,442.01</td>
          @endif
  
          @if ($value=="Octubre")
          <td>262,614.06</td>
          <td>229,725.70</td>
          @endif
  
          @if ($value=="Noviembre")
          <td>323,432.98</td>
          <td>353,419.29</td>
          @endif
  
          @if ($value=="Diciembre")
          <td>334,012.23</td>
          <td>346,684.02</td>
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $total[1]['HANDAL'][0]->$val1 }}</td>
          @endif
  
          <td>{{ $total[1]['HANDAL'][0]->$val2 }}</td>
          <td>{{ $total[1]['HANDAL'][0]->$val3 }}</td>
          <td class="subTitulos">{{ $total[1]['HANDAL'][0]->$val4 }}</td>
          <td class="subTitulos">{{ $total[1]['HANDAL'][0]->$val5 }}</td>
          @endforeach
          <td>{{ number_format($sumHandal19, 2) }}</td>
          <td>{{ number_format($sumHandal20, 2) }}</td>
          <td>{{ number_format($total[1]['HANDAL'][0]->Tot1 + $sumHandal21, 2) }}</td>
          <td>{{ $total[1]['HANDAL'][0]->Tot2 }}</td>
          <td>{{ $total[1]['HANDAL'][0]->Tot3 }}</td>
          <td class="subTitulos">{{ $total[1]['HANDAL'][0]->Tot4 }}</td>
          <td class="subTitulos">{{ $total[1]['HANDAL'][0]->Tot5 }}</td>
        </tr>
        @foreach ($total_seg[1]['HANDAL'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          @if ($val->adusrNomb=="BENIGNA TINTA")
          <td>73,374.55</td>
          <td>160,477.72</td>
          <td>90,191.79</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO HANDAL")
          <td>18,352.20</td>
          <td>19,246.50</td>
          <td>3,183.52</td>
          @endif
          @endif
  
          @if ($value=="Febrero")
          @if ($val->adusrNomb=="BENIGNA TINTA")
          <td>270,253.50</td>
          <td>136,762.07</td>
          <td>239,354.23</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO HANDAL")
          <td>60,403.77</td>
          <td>97,490.70</td>
          <td>3,038.60</td>
          @endif
          @endif
  
          @if ($value=="Marzo")
          @if ($val->adusrNomb=="BENIGNA TINTA")
          <td>216,752.61</td>
          <td>65,483.02</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO HANDAL")
          <td>7,239.30</td>
          <td>5,770.00</td>
          @endif
          @endif
  
          @if ($value=="Abril")
          @if ($val->adusrNomb=="BENIGNA TINTA")
          <td>129,993.47</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO HANDAL")
          <td>3,360.31</td>
          <td>0.00</td>
          @endif
          @endif
          
          @if ($value=="Mayo")
          @if ($val->adusrNomb=="BENIGNA TINTA")
          <td>91,146.81</td>
          <td>5,100.10</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO HANDAL")
          <td>3,440.80</td>
          <td>90.00</td>
          @endif
          @endif
  
          @if ($value=="Junio")
          @if ($val->adusrNomb=="BENIGNA TINTA")
          <td>136,632.02</td>
          <td>106,952.12</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO HANDAL")
          <td>901.60</td>
          <td>3,616.65</td>
          @endif
          @endif
  
          @if ($value=="Julio")
          @if ($val->adusrNomb=="BENIGNA TINTA")
          <td>159,797.08</td>
          <td>90,941.95</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO HANDAL")
          <td>1,668.10</td>
          <td>10,415.88</td>
          @endif
          @endif
  
          @if ($value=="Agosto")
          @if ($val->adusrNomb=="BENIGNA TINTA")
          <td>124,563.32</td>
          <td>150,566.17</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO HANDAL")
          <td>4,047.00</td>
          <td>4,053.50</td>
          @endif
          @endif
  
          @if ($value=="Septiembre")
          @if ($val->adusrNomb=="BENIGNA TINTA")
          <td>299,600.39</td>
          <td>171,282.83</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO HANDAL")
          <td>4,327.40</td>
          <td>4,324.60</td>
          @endif
          @endif
          
          @if ($value=="Octubre")
          @if ($val->adusrNomb=="BENIGNA TINTA")
          <td>144,152.54</td>
          <td>97,242.09</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO HANDAL")
          <td>2,957.05</td>
          <td>4,062.69</td>
          @endif
          @endif
  
          @if ($value=="Noviembre")
          @if ($val->adusrNomb=="BENIGNA TINTA")
          <td>164,127.86</td>
          <td>174,335.79</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO HANDAL")
          <td>2,860.50</td>
          <td>3,023.73</td>
          @endif
          @endif
  
          @if ($value=="Diciembre")
          @if ($val->adusrNomb=="BENIGNA TINTA")
          <td>143,224.22</td>
          <td>160,743.31</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO HANDAL")
          <td>4,111.47</td>
          <td>8,234.82</td>
          @endif
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $val->$val1 }}</td>
          @endif
  
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          <td>{{ $val->$val5 }}</td>
          @endforeach
          @if ($val->adusrNomb=="CAJERO LIBRO HANDAL")
          <td>{{ number_format($arrayHandal19['libros'], 2) }}</td>
          <td>{{ number_format($arrayHandal20['libros'], 2) }}</td>
          <td>{{ number_format($total_seg[1]['HANDAL'][0]->Tot1 + $arrayHandal21['libros'], 2) }}</td>
          @endif
          @if ($val->adusrNomb=="BENIGNA TINTA")
          <td>{{ number_format($arrayHandal19['instit'], 2) }}</td>
          <td>{{ number_format($arrayHandal20['instit'], 2) }}</td>
          <td>{{ number_format($total_seg[1]['HANDAL'][1]->Tot1 + $arrayHandal21['instit'], 2) }}</td>
          @endif
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->Tot3 }}</td>
          <td>{{ $val->Tot4 }}</td>
          <td>{{ $val->Tot5 }}</td>
        </tr>
        @endforeach
        <tr class="text-end">
          <td class="text-start">RETAIL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          <td>274,144.45</td>
          <td>267,218.90</td>
          <td>157,651.54</td>
          @endif
          @if ($value=="Febrero")
          <td>419,893.24</td>
          <td>306,195.73</td>
          <td>232,684.22</td>
          @endif
  
          @if ($value=="Marzo")
          <td>167,023.05</td>
          <td>91,813.56</td>
          @endif
  
          @if ($value=="Abril")
          <td>179,004.95</td>
          <td>91,052.94</td>
          @endif
  
          @if ($value=="Mayo")
          <td>136,155.37</td>
          <td>86,063.26</td>
          @endif
  
          @if ($value=="Junio")
          <td>123,860.85</td>
          <td>94,748.40</td>
          @endif
  
          @if ($value=="Julio")
          <td>176,196.99</td>
          <td>91,624.98</td>
          @endif
  
          @if ($value=="Agosto")
          <td>163,614.60</td>
          <td>81,704.04</td>
          @endif
  
          @if ($value=="Septiembre")
          <td>157,165.02</td>
          <td>150,834.58</td>
          @endif
  
          @if ($value=="Octubre")
          <td>115,504.47</td>
          <td>128,420.92</td>
          @endif
  
          @if ($value=="Noviembre")
          <td>156,444.62</td>
          <td>176,059.77</td>
          @endif
  
          @if ($value=="Diciembre")
          <td>186,676.54</td>
          <td>177,705.89</td>
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $total_retail[1]['HANDAL'][0]->$val1 }}</td>
          @endif
  
          <td>{{ $total_retail[1]['HANDAL'][0]->$val2 }}</td>
          <td>{{ $total_retail[1]['HANDAL'][0]->$val3 }}</td>
          <td>{{ $total_retail[1]['HANDAL'][0]->$val4 }}</td>
          <td>{{ $total_retail[1]['HANDAL'][0]->$val5 }}</td>
          @endforeach
          <td>{{ number_format($arrayHandal19['retail'], 2) }}</td>
          <td>{{ number_format($arrayHandal20['retail'], 2) }}</td>
          <td>{{ number_format($total_retail[1]['HANDAL'][0]->Tot1 + $arrayHandal21['retail'], 2) }}</td>
          <td>{{ $total_retail[1]['HANDAL'][0]->Tot2 }}</td>
          <td>{{ $total_retail[1]['HANDAL'][0]->Tot3 }}</td>
          <td>{{ $total_retail[1]['HANDAL'][0]->Tot4 }}</td>
          <td>{{ $total_retail[1]['HANDAL'][0]->Tot5 }}</td>
        </tr>
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">SUCURSAL MARISCAL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          <td>174,490.36</td>
          <td>262,379.54</td>
          <td>233,336.14</td>
          @endif
  
          @if ($value=="Febrero")
          <td>447,578.47</td>
          <td>430,920.20</td>
          <td>345,331.05</td>
          @endif
  
          @if ($value=="Marzo")
          <td>270,316.53</td>
          <td>221,743.66</td>
          @endif
  
          @if ($value=="Abril")
          <td>274,469.37</td>
          <td>19,580.20</td>
          @endif
  
          @if ($value=="Mayo")
          <td>435,706.08</td>
          <td>32,775.03</td>
          @endif
  
          @if ($value=="Junio")
          <td>380,626.32</td>
          <td>242,005.93</td>
          @endif
  
          @if ($value=="Julio")
          <td>257,768.41</td>
          <td>271,506.99</td>
          @endif
  
          @if ($value=="Agosto")
          <td>288,075.86</td>
          <td>232,889.40</td>
          @endif
  
          @if ($value=="Septiembre")
          <td>305,573.93</td>
          <td>263,863.58</td>
          @endif
  
          @if ($value=="Octubre")
          <td>283,797.88</td>
          <td>303,518.34</td>
          @endif
  
          @if ($value=="Noviembre")
          <td>282,362.07</td>
          <td>398,042.85</td>
          @endif
  
          @if ($value=="Diciembre")
          <td>435,544.63</td>
          <td>341,017.44</td>
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $total[2]['MARISCAL'][0]->$val1 }}</td>
          @endif
  
          <td>{{ $total[2]['MARISCAL'][0]->$val2 }}</td>
          <td>{{ $total[2]['MARISCAL'][0]->$val3 }}</td>
          <td class="subTitulos">{{ $total[2]['MARISCAL'][0]->$val4 }}</td>
          <td class="subTitulos">{{ $total[2]['MARISCAL'][0]->$val5 }}</td>
          @endforeach
          <td>{{ number_format($sumMariscal19, 2) }}</td>
          <td>{{ number_format($sumMariscal20, 2) }}</td>
          <td>{{ number_format($total[2]['MARISCAL'][0]->Tot1 + $sumMariscal21, 2) }}</td>
          <td>{{ $total[2]['MARISCAL'][0]->Tot2 }}</td>
          <td>{{ $total[2]['MARISCAL'][0]->Tot3 }}</td>
          <td class="subTitulos">{{ $total[2]['MARISCAL'][0]->Tot4 }}</td>
          <td class="subTitulos">{{ $total[2]['MARISCAL'][0]->Tot5 }}</td>
        </tr>
        @foreach ($total_seg[2]['MARISCAL'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          @if ($val->adusrNomb=="CAJERO LIBRO MARISCAL")
          <td>415.80</td>
          <td>589.90</td>
          <td>187.20</td>
          @endif
          @if ($val->adusrNomb=="INS MARISCAL")
          <td>34,817.38</td>
          <td>57,344.91</td>
          <td>94,396.88</td>
          @endif
          @endif
          @if ($value=="Febrero")
          @if ($val->adusrNomb=="CAJERO LIBRO MARISCAL")
          <td>4,106.75</td>
          <td>3,765.70</td>
          <td>1,088.10</td>
          @endif
          @if ($val->adusrNomb=="INS MARISCAL")
          <td>187,834.00</td>
          <td>156,969.00</td>
          <td>93,447.16</td>
          @endif
          @endif
          @if ($value=="Marzo")
          @if ($val->adusrNomb=="CAJERO LIBRO MARISCAL")
          <td>390.00</td>
          <td>273.80</td>
          @endif
          @if ($val->adusrNomb=="INS MARISCAL")
          <td>142,814.11</td>
          <td>107,689.41</td>
          @endif
          @endif
          @if ($value=="Abril")
          @if ($val->adusrNomb=="CAJERO LIBRO MARISCAL")
          <td>431.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="INS MARISCAL")
          <td>145,192.65</td>
          <td>19,580.20</td>
          @endif
          @endif
          @if ($value=="Mayo")
          @if ($val->adusrNomb=="CAJERO LIBRO MARISCAL")
          <td>224.00</td>
          <td>18.80</td>
          @endif
          @if ($val->adusrNomb=="INS MARISCAL")
          <td>289,214.41</td>
          <td>18,782.01</td>
          @endif
          @endif
          @if ($value=="Junio")
          @if ($val->adusrNomb=="CAJERO LIBRO MARISCAL")
          <td>0.00</td>
          <td>570.00</td>
          @endif
          @if ($val->adusrNomb=="INS MARISCAL")
          <td>272,603.11</td>
          <td>119,480.03</td>
          @endif
          @endif
          @if ($value=="Julio")
          @if ($val->adusrNomb=="CAJERO LIBRO MARISCAL")
          <td>50.00</td>
          <td>154.30</td>
          @endif
          @if ($val->adusrNomb=="INS MARISCAL")
          <td>120,757.42</td>
          <td>172,539.19</td>
          @endif
          @endif
          @if ($value=="Agosto")
          @if ($val->adusrNomb=="CAJERO LIBRO MARISCAL")
          <td>103.50</td>
          <td>201.70</td>
          @endif
          @if ($val->adusrNomb=="INS MARISCAL")
          <td>155,312.17</td>
          <td>121,706.24</td>
          @endif
          @endif
          @if ($value=="Septiembre")
          @if ($val->adusrNomb=="CAJERO LIBRO MARISCAL")
          <td>132.00</td>
          <td>545.30</td>
          @endif
          @if ($val->adusrNomb=="INS MARISCAL")
          <td>159,496.19</td>
          <td>121,652.88</td>
          @endif
          @endif
          @if ($value=="Octubre")
          @if ($val->adusrNomb=="CAJERO LIBRO MARISCAL")
          <td>151.00</td>
          <td>358.30</td>
          @endif
          @if ($val->adusrNomb=="INS MARISCAL")
          <td>166,601.43</td>
          <td>162,944.47</td>
          @endif
          @endif
          @if ($value=="Noviembre")
          @if ($val->adusrNomb=="CAJERO LIBRO MARISCAL")
          <td>176.76</td>
          <td>66.15</td>
          @endif
          @if ($val->adusrNomb=="INS MARISCAL")
          <td>145,672.90</td>
          <td>225,398.67</td>
          @endif
          @endif
          @if ($value=="Diciembre")
          @if ($val->adusrNomb=="CAJERO LIBRO MARISCAL")
          <td>174.24</td>
          <td>174.80</td>
          @endif
          @if ($val->adusrNomb=="INS MARISCAL")
          <td>261,670.65</td>
          <td>145,605.58</td>
          @endif
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $val->$val1 }}</td>
          @endif
  
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          <td>{{ $val->$val5 }}</td>
          @endforeach
          @if ($val->adusrNomb=="CAJERO LIBRO MARISCAL")
          <td>{{ number_format($arrayMariscal19['libros'], 2) }}</td>
          <td>{{ number_format($arrayMariscal20['libros'], 2) }}</td>
          <td>{{ number_format($total_seg[2]['MARISCAL'][0]->Tot1 + $arrayMariscal21['libros'], 2) }}</td>
          @endif
          @if ($val->adusrNomb=="INS MARISCAL")
          <td>{{ number_format($arrayMariscal19['instit'], 2) }}</td>
          <td>{{ number_format($arrayMariscal20['instit'], 2) }}</td>
          <td>{{ number_format($total_seg[2]['MARISCAL'][1]->Tot1 + $arrayMariscal21['instit'], 2) }}</td>
          @endif
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->Tot3 }}</td>
          <td>{{ $val->Tot4 }}</td>
          <td>{{ $val->Tot5 }}</td>
        </tr>
        @endforeach
        <tr class="text-end">
          <td class="text-start">RETAIL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
          @if ($value=="Enero")
          <td>139,257.18</td>
          <td>204,444.73</td>
          <td>138,752.06</td>
          @endif
          @if ($value=="Febrero")
          <td>255,637.72</td>
          <td>270,185.50</td>
          <td>250,795.79</td>
          @endif
          @if ($value=="Marzo")
          <td>127,112.42</td>
          <td>113,780.45</td>
          @endif
          @if ($value=="Abril")
          <td>128,845.72</td>
          <td>0.00</td>
          @endif
          @if ($value=="Mayo")
          <td>146,267.67</td>
          <td>13,974.22</td>
          @endif
          @if ($value=="Junio")
          <td>108,023.21</td>
          <td>121,955.90</td>
          @endif
          @if ($value=="Julio")
          <td>136,960.99</td>
          <td>98,813.50</td>
          @endif
          @if ($value=="Agosto")
          <td>132,660.19</td>
          <td>110,981.46</td>
          @endif
          @if ($value=="Septiembre")
          <td>145,945.74</td>
          <td>141,665.40</td>
          @endif
          @if ($value=="Octubre")
          <td>117,045.45</td>
          <td>140,215.57</td>
          @endif
          @if ($value=="Noviembre")
          <td>136,512.41</td>
          <td>172,578.03</td>
          @endif
          @if ($value=="Diciembre")
          <td>173,699.74</td>
          <td>195,237.06</td>
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $total_retail[2]['MARISCAL'][0]->$val1 }}</td>
          @endif
  
          <td>{{ $total_retail[2]['MARISCAL'][0]->$val2 }}</td>
          <td>{{ $total_retail[2]['MARISCAL'][0]->$val3 }}</td>
          <td>{{ $total_retail[2]['MARISCAL'][0]->$val4 }}</td>
          <td>{{ $total_retail[2]['MARISCAL'][0]->$val5 }}</td>
          @endforeach
          <td>{{ number_format($arrayMariscal19['retail'], 2) }}</td>
          <td>{{ number_format($arrayMariscal20['retail'], 2) }}</td>
          <td>{{ number_format($total_retail[2]['MARISCAL'][0]->Tot1 + $arrayMariscal21['retail'], 2) }}</td>
          <td>{{ $total_retail[2]['MARISCAL'][0]->Tot2 }}</td>
          <td>{{ $total_retail[2]['MARISCAL'][0]->Tot3 }}</td>
          <td>{{ $total_retail[2]['MARISCAL'][0]->Tot4 }}</td>
          <td>{{ $total_retail[2]['MARISCAL'][0]->Tot5 }}</td>
        </tr>
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">SUCURSAL CALACOTO</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          <td>431,002.91</td>
          <td>367,932.12</td>
          <td>277,216.22</td>
          @endif
  
          @if ($value=="Febrero")
          <td>321,350.67</td>
          <td>251,731.07</td>
          <td>210,242.86</td>
          @endif
  
          @if ($value=="Marzo")
          <td>152,780.51</td>
          <td>120,489.82</td>
          @endif
  
          @if ($value=="Abril")
          <td>171,044.31</td>
          <td>0.00</td>
          @endif
  
          @if ($value=="Mayo")
          <td>144,657.75</td>
          <td>22,310.85</td>
          @endif
  
          @if ($value=="Junio")
          <td>154,966.25</td>
          <td>190,837.66</td>
          @endif
  
          @if ($value=="Julio")
          <td>160,657.85</td>
          <td>114,993.14</td>
          @endif
  
          @if ($value=="Agosto")
          <td>179,289.79</td>
          <td>93,971.41</td>
          @endif
  
          @if ($value=="Septiembre")
          <td>182,272.83</td>
          <td>174,341.20</td>
          @endif
  
          @if ($value=="Octubre")
          <td>164,866.44</td>
          <td>169,909.82</td>
          @endif
  
          @if ($value=="Noviembre")
          <td>169,845.02</td>
          <td>503,427.90</td>
          @endif
  
          @if ($value=="Diciembre")
          <td>213,576.56</td>
          <td>226,486.50</td>
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $total[3]['CALACOTO'][0]->$val1 }}</td>
          @endif
  
          <td>{{ $total[3]['CALACOTO'][0]->$val2 }}</td>
          <td>{{ $total[3]['CALACOTO'][0]->$val3 }}</td>
          <td class="subTitulos">{{ $total[3]['CALACOTO'][0]->$val4 }}</td>
          <td class="subTitulos">{{ $total[3]['CALACOTO'][0]->$val5 }}</td>
          @endforeach
          <td>{{ number_format($sumCalacoto19, 2) }}</td>
          <td>{{ number_format($sumCalacoto20, 2) }}</td>
          <td>{{ number_format($total[3]['CALACOTO'][0]->Tot1 + $sumCalacoto21, 2) }}</td>
          <td>{{ $total[3]['CALACOTO'][0]->Tot2 }}</td>
          <td>{{ $total[3]['CALACOTO'][0]->Tot3 }}</td>
          <td class="subTitulos">{{ $total[3]['CALACOTO'][0]->Tot4 }}</td>
          <td class="subTitulos">{{ $total[3]['CALACOTO'][0]->Tot5 }}</td>
        </tr>
        @foreach ($total_seg[3]['CALACOTO'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          @if ($val->adusrNomb=="CAJERO LIBRO CALACOTO")
          <td>49,711.20</td>
          <td>5,368.45</td>
          <td>3,167.52</td>
          @endif
          @endif
  
          @if ($value=="Febrero")
          @if ($val->adusrNomb=="CAJERO LIBRO CALACOTO")
          <td>33,861.30</td>
          <td>5,002.50</td>
          <td>2,191.83</td>
          @endif
          @endif
  
          @if ($value=="Marzo")
          @if ($val->adusrNomb=="CAJERO LIBRO CALACOTO")
          <td>2,289.25</td>
          <td>2,860.40</td>
          @endif
          @endif
  
          @if ($value=="Abril")
          @if ($val->adusrNomb=="CAJERO LIBRO CALACOTO")
          <td>2,398.98</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value=="Mayo")
          @if ($val->adusrNomb=="CAJERO LIBRO CALACOTO")
          <td>2,322.10</td>
          <td>388.34</td>
          @endif
          @endif
  
          @if ($value=="Junio")
          @if ($val->adusrNomb=="CAJERO LIBRO CALACOTO")
          <td>2,719.30</td>
          <td>3,084.50</td>
          @endif
          @endif
  
          @if ($value=="Julio")
          @if ($val->adusrNomb=="CAJERO LIBRO CALACOTO")
          <td>2,316.40</td>
          <td>2,842.30</td>
          @endif
          @endif
  
          @if ($value=="Agosto")
          @if ($val->adusrNomb=="CAJERO LIBRO CALACOTO")
          <td>4,454.60</td>
          <td>2,346.40</td>
          @endif
          @endif
  
          @if ($value=="Septiembre")
          @if ($val->adusrNomb=="CAJERO LIBRO CALACOTO")
          <td>4,347.50</td>
          <td>2,806.10</td>
          @endif
          @endif
  
          @if ($value=="Octubre")
          @if ($val->adusrNomb=="CAJERO LIBRO CALACOTO")
          <td>3,448.80</td>
          <td>4,499.08</td>
          @endif
          @endif
  
          @if ($value=="Noviembre")
          @if ($val->adusrNomb=="CAJERO LIBRO CALACOTO")
          <td>2,425.60</td>
          <td>4,263.41</td>
          @endif
          @endif
  
          @if ($value=="Diciembre")
          @if ($val->adusrNomb=="CAJERO LIBRO CALACOTO")
          <td>4,893.07</td>
          <td>4,401.70</td>
          @endif
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero"&&$val->adusrNomb="CAJERO LIBRO CALACOTO")
          <td>{{ $val->$val1 }}</td>
          @endif
          @if ($val->adusrNomb=="CAJERO LIBRO CALACOTO")
          <td>{{ $val->$val2 }} </td>
          <td>{{ $val->$val3 }} </td>
          <td>{{ $val->$val4 }} </td>
          <td>{{ $val->$val5 }} </td>
          @endif
  
          @endforeach
          <td>{{ number_format($arrayCalacoto19['libros'], 2) }}</td>
          <td>{{ number_format($arrayCalacoto20['libros'], 2) }}</td>
          <td>{{ number_format($total_seg[3]['CALACOTO'][0]->Tot1 + $arrayCalacoto21['libros'], 2) }}</td>
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->Tot3 }}</td>
          <td>{{ $val->Tot4 }}</td>
          <td>{{ $val->Tot5 }}</td>
        </tr>
        @endforeach
        <tr class="text-end">
          <td class="text-start">INS CALACOTO</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
          @if ($value=="Enero")
          <td>58,658.03</td>
          <td>59,036.27</td>
          <td>34,969.61</td>
          @endif
          @if ($value=="Febrero")
          <td>36,515.78</td>
          <td>50,183.76</td>
          <td>34,207.79</td>
          @endif
          @if ($value=="Marzo")
          <td>50,105.12</td>
          <td>40,103.23</td>
          @endif
          @if ($value=="Abril")
          <td>58,344.25</td>
          <td>0.00
          </td>
          @endif
          @if ($value=="Mayo")
          <td>45,640.09
          </td>
          <td>11,217.54
          </td>
          @endif
          @if ($value=="Junio")
          <td>72,011.68</td>
          <td>114,254.97</td>
          @endif
          @if ($value=="Julio")
          <td>48,594.34
          </td>
          <td>35,625.82
          </td>
          @endif
          @if ($value=="Agosto")
          <td>54,947.39
          </td>
          <td>25,847.90</td>
          @endif
          @if ($value=="Septiembre")
          <td>68,784.07</td>
          <td>79,222.62
          </td>
          @endif
          @if ($value=="Octubre")
          <td>50,196.26</td>
          <td>50,408.32</td>
          @endif
          @if ($value=="Noviembre")
          <td>58,692.88</td>
          <td>369,001.97</td>
          @endif
          @if ($value=="Diciembre")
          <td>66,394.85</td>
          <td>64,804.62</td>
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $total_retail_calacoto[0]->$val1 }}</td>
          @endif
          <td>{{ $total_retail_calacoto[0]->$val2}}</td>
          <td>{{ $total_retail_calacoto[0]->$val3}}</td>
          <td>{{ $total_retail_calacoto[0]->$val4}}</td>
          <td>{{ $total_retail_calacoto[0]->$val5}}</td>
          @endforeach
          <td>{{ number_format($arrayCalacoto19['instit'], 2) }}</td>
          <td>{{ number_format($arrayCalacoto20['instit'], 2) }}</td>
          <td>{{ number_format($total_retail_calacoto[0]->Tot1 + $arrayCalacoto21['instit'], 2) }}</td>
          <td>{{ $total_retail_calacoto[0]->Tot2 }}</td>
          <td>{{ $total_retail_calacoto[0]->Tot3 }}</td>
          <td>{{ $total_retail_calacoto[0]->Tot4 }}</td>
          <td>{{ $total_retail_calacoto[0]->Tot5 }}</td>
        </tr>
        <tr class="text-end">
          <td class="text-start">RETAIL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          <td>322,633.68</td>
          <td>303,527.40</td>
          <td>239,079.09</td>
          @endif
  
          @if ($value=="Febrero")
          <td>250,973.59</td>
          <td>196,544.81</td>
          <td>173,843.24</td>
          @endif
  
          @if ($value=="Marzo")
          <td>100,386.14</td>
          <td>77,526.19</td>
          @endif
  
          @if ($value=="Abril")
          <td>110,301.08</td>
          <td>0.00</td>
          @endif
  
          @if ($value=="Mayo")
          <td>96,695.56</td>
          <td>10,704.97</td>
          @endif
  
          @if ($value=="Junio")
          <td>80,235.27</td>
          <td>73,498.19</td>
          @endif
  
          @if ($value=="Julio")
          <td>109,747.11</td>
          <td>76,525.02</td>
          @endif
          
          @if ($value=="Agosto")
          <td>119,887.80</td>
          <td>65,777.11</td>
          @endif
  
          @if ($value=="Septiembre")
          <td>109,141.26</td>
          <td>92,312.48</td>
          @endif
  
          @if ($value=="Octubre")
          <td>111,221.38</td>
          <td>115,002.42</td>
          @endif
  
          @if ($value=="Noviembre")
          <td>108,726.54</td>
          <td>130,162.52</td>
          @endif
  
          @if ($value=="Diciembre")
          <td>142,288.64</td>
          <td>157,280.18</td>
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $total_retail[3]['CALACOTO'][0]->$val1 }}</td>
          @endif
  
          <td>{{ $total_retail[3]['CALACOTO'][0]->$val2 }}</td>
          <td>{{ $total_retail[3]['CALACOTO'][0]->$val3 }}</td>
          <td>{{ $total_retail[3]['CALACOTO'][0]->$val4 }}</td>
          <td>{{ $total_retail[3]['CALACOTO'][0]->$val5 }}</td>
          @endforeach
          <td>{{ number_format($arrayCalacoto19['retail'], 2) }}</td>
          <td>{{ number_format($arrayCalacoto20['retail'], 2) }}</td>
          <td>{{ number_format($total_retail[3]['CALACOTO'][0]->Tot1 + $arrayCalacoto21['retail'], 2) }}</td>
          <td>{{ $total_retail[3]['CALACOTO'][0]->Tot2 }}</td>
          <td>{{ $total_retail[3]['CALACOTO'][0]->Tot3 }}</td>
          <td>{{ $total_retail[3]['CALACOTO'][0]->Tot4 }}</td>
          <td>{{ $total_retail[3]['CALACOTO'][0]->Tot5 }}</td>
        </tr>
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">SUCURSAL SAN MIGUEL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ $total[4]['SAN MIGUEL'][0]->$val1 }}</td>
          <td>{{ $total[4]['SAN MIGUEL'][0]->$val2 }}</td>
          <td>{{ $total[4]['SAN MIGUEL'][0]->$val3 }}</td>
          <td class="subTitulos">{{ $total[4]['SAN MIGUEL'][0]->$val4 }}</td>
          <td class="subTitulos">{{ $total[4]['SAN MIGUEL'][0]->$val5 }}</td>
          @endforeach
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ $total[4]['SAN MIGUEL'][0]->Tot1 }}</td>
          <td>{{ $total[4]['SAN MIGUEL'][0]->Tot2 }}</td>
          <td>{{ $total[4]['SAN MIGUEL'][0]->Tot3 }}</td>
          <td class="subTitulos">{{ $total[4]['SAN MIGUEL'][0]->Tot4 }}</td>
          <td class="subTitulos">{{ $total[4]['SAN MIGUEL'][0]->Tot5 }}</td>
        </tr>
        @foreach ($total_seg[4]['SAN MIGUEL'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp

          <td>0.00</td>
          <td>0.00</td>
          <td>{{ $val->$val1 }}</td>
          <td>{{ $val->$val2 }} </td>
          <td>{{ $val->$val3 }} </td>
          <td>{{ $val->$val4 }} </td>
          <td>{{ $val->$val5 }} </td>
  
          @endforeach
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ number_format($total_seg[4]['SAN MIGUEL'][0]->Tot1, 2) }}</td>
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->Tot3 }}</td>
          <td>{{ $val->Tot4 }}</td>
          <td>{{ $val->Tot5 }}</td>
        </tr>
        @endforeach
        <tr class="text-end">
          <td class="text-start">RETAIL</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->$val1 }}</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->$val2 }}</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->$val3 }}</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->$val4 }}</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->$val5 }}</td>
          @endforeach
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ number_format($total_retail[4]['SAN MIGUEL'][0]->Tot1, 2) }}</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->Tot2 }}</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->Tot3 }}</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->Tot4 }}</td>
          <td>{{ $total_retail[4]['SAN MIGUEL'][0]->Tot5 }}</td>
        </tr>
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">INSTITUCIONALES</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          <td>106,973.76</td>
          <td>737,633.37</td>
          <td>135,904.77</td>
          @endif
  
          @if ($value=="Febrero")
          <td>362,241.11</td>
          <td>161,443.21</td>
          <td>598,482.91</td>
          @endif
  
          @if ($value=="Marzo")
          <td>426,600.08</td>
          <td>303,031.53</td>
          @endif
  
          @if ($value=="Abril")
          <td>319,573.34</td>
          <td>424.40</td>
          @endif
  
          @if ($value=="Mayo")
          <td>746,222.24</td>
          <td>142,613.75</td>
          @endif
  
          @if ($value=="Junio")
          <td>200,365.44</td>
          <td>383,195.24</td>
          @endif
  
          @if ($value=="Julio")
          <td>247,754.08</td>
          <td>358,715.37</td>
          @endif
  
          @if ($value=="Agosto")
          <td>190,111.89</td>
          <td>166,726.07</td>
          @endif
  
          @if ($value=="Septiembre")
          <td>411,384.46</td>
          <td>189,648.22</td>
          @endif
  
          @if ($value=="Octubre")
          <td>373,622.32</td>
          <td>410,201.86</td>
          @endif
  
          @if ($value=="Noviembre")
          <td>197,243.59</td>
          <td>481,983.61</td>
          @endif
  
          @if ($value=="Diciembre")
          <td>217,437.55</td>
          <td>435,495.75</td>
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $total[5]['INSTITUCIONALES'][0]->$val1 }}</td>
          @endif
          <td>{{ $total[5]['INSTITUCIONALES'][0]->$val2 }}</td>
          <td>{{ $total[5]['INSTITUCIONALES'][0]->$val3 }}</td>
          <td class="subTitulos">{{ $total[5]['INSTITUCIONALES'][0]->$val4 }}</td>
          <td class="subTitulos">{{ $total[5]['INSTITUCIONALES'][0]->$val5 }}</td>
          @endforeach
          <td>{{ number_format($sumInstitucional19, 2) }}</td>
          <td>{{ number_format($sumInstitucional20, 2) }}</td>
          <td>{{ number_format($total[5]['INSTITUCIONALES'][0]->Tot1 + $sumInstitucional21, 2) }}</td>
          <td>{{ $total[5]['INSTITUCIONALES'][0]->Tot2 }}</td>
          <td>{{ $total[5]['INSTITUCIONALES'][0]->Tot3 }}</td>
          <td class="subTitulos">{{ $total[5]['INSTITUCIONALES'][0]->Tot4 }}</td>
          <td class="subTitulos">{{ $total[5]['INSTITUCIONALES'][0]->Tot5 }}</td>
        </tr>
        @foreach ($total_seg[5]['INSTITUCIONALES'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          @if ($val->adusrNomb=="CONTRATOS INSTITUCIONALES")
          <td>51,983.30</td>
          <td>168,035.32</td>
          <td>91,924.15</td>
          @endif
          @if ($val->adusrNomb=="GUADALUPE AMBA")
          <td>35,646.87</td>
          <td>558,566.78</td>
          <td>36,014.22</td>
          @endif
          @if ($val->adusrNomb=="INES VELASQUEZ")
          <td>19,343.59</td>
          <td>11,031.27</td>
          <td>7,966.40</td>
          @endif
          @if ($val->adusrNomb=="JULIO MANCILLA")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="MAGDY VILLARROEL")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="RODRIGO DURAN")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="VENTA MÓVIL 1")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value=="Febrero")
          @if ($val->adusrNomb=="CONTRATOS INSTITUCIONALES")
          <td>163,569.13</td>
          <td>43,661.58</td>
          <td>41,587.36</td>
          @endif
          @if ($val->adusrNomb=="GUADALUPE AMBA")
          <td>152,593.01</td>
          <td>45,122.43</td>
          <td>528,808.22</td>
          @endif
          @if ($val->adusrNomb=="INES VELASQUEZ")
          <td>46,078.97</td>
          <td>72,659.20</td>
          <td>28,087.33</td>
          @endif
          @if ($val->adusrNomb=="JULIO MANCILLA")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="MAGDY VILLARROEL")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="RODRIGO DURAN")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="VENTA MÓVIL 1")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value=="Marzo")
          @if ($val->adusrNomb=="CONTRATOS INSTITUCIONALES")
          <td>242,920.12</td>
          <td>11,419.55</td>
          @endif
          @if ($val->adusrNomb=="GUADALUPE AMBA")
          <td>149,090.63</td>
          <td>246,745.56</td>
          @endif
          @if ($val->adusrNomb=="INES VELASQUEZ")
          <td>34,589.33</td>
          <td>44,866.42</td>
          @endif
          @if ($val->adusrNomb=="JULIO MANCILLA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="MAGDY VILLARROEL")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="RODRIGO DURAN")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="VENTA MÓVIL 1")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value=="Abril")
          @if ($val->adusrNomb=="CONTRATOS INSTITUCIONALES")
          <td>100,498.15</td>
          <td>424.40</td>
          @endif
          @if ($val->adusrNomb=="GUADALUPE AMBA")
          <td>77,952.13</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="INES VELASQUEZ")
          <td>141,123.06</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="JULIO MANCILLA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="MAGDY VILLARROEL")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="RODRIGO DURAN")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="VENTA MÓVIL 1")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value=="Mayo")
          @if ($val->adusrNomb=="CONTRATOS INSTITUCIONALES")
          <td>218,356.84</td>
          <td>133,308.65</td>
          @endif
          @if ($val->adusrNomb=="GUADALUPE AMBA")
          <td>230,941.47</td>
          <td>9,305.10</td>
          @endif
          @if ($val->adusrNomb=="INES VELASQUEZ")
          <td>296,923.93</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="JULIO MANCILLA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="MAGDY VILLARROEL")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="RODRIGO DURAN")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="VENTA MÓVIL 1")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value=="Junio")
          @if ($val->adusrNomb=="CONTRATOS INSTITUCIONALES")
          <td>101,918.35</td>
          <td>175,994.54</td>
          @endif
          @if ($val->adusrNomb=="GUADALUPE AMBA")
          <td>59,090.49</td>
          <td>155,482.44</td>
          @endif
          @if ($val->adusrNomb=="INES VELASQUEZ")
          <td>39,356.60</td>
          <td>51,718.26</td>
          @endif
          @if ($val->adusrNomb=="JULIO MANCILLA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="MAGDY VILLARROEL")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="RODRIGO DURAN")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="VENTA MÓVIL 1")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value=="Julio")
          @if ($val->adusrNomb=="CONTRATOS INSTITUCIONALES")
          <td>139,081.04</td>
          <td>239,691.90</td>
          @endif
          @if ($val->adusrNomb=="GUADALUPE AMBA")
          <td>70,894.69</td>
          <td>27,380.93</td>
          @endif
          @if ($val->adusrNomb=="INES VELASQUEZ")
          <td>37,778.35</td>
          <td>91,642.54</td>
          @endif
          @if ($val->adusrNomb=="JULIO MANCILLA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="MAGDY VILLARROEL")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="RODRIGO DURAN")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="VENTA MÓVIL 1")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value=="Agosto")
          @if ($val->adusrNomb=="CONTRATOS INSTITUCIONALES")
          <td>110,767.28</td>
          <td>49,067.00</td>
          @endif
          @if ($val->adusrNomb=="GUADALUPE AMBA")
          <td>36,046.11</td>
          <td>100,105.90</td>
          @endif
          @if ($val->adusrNomb=="INES VELASQUEZ")
          <td>43,298.50</td>
          <td>17,553.17</td>
          @endif
          @if ($val->adusrNomb=="JULIO MANCILLA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="MAGDY VILLARROEL")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="RODRIGO DURAN")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="VENTA MÓVIL 1")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value=="Septiembre")
          @if ($val->adusrNomb=="CONTRATOS INSTITUCIONALES")
          <td>156,364.41</td>
          <td>51,939.07</td>
          @endif
          @if ($val->adusrNomb=="GUADALUPE AMBA")
          <td>131,789.30</td>
          <td>54,232.90</td>
          @endif
          @if ($val->adusrNomb=="INES VELASQUEZ")
          <td>123,230.75</td>
          <td>83,476.25</td>
          @endif
          @if ($val->adusrNomb=="JULIO MANCILLA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="MAGDY VILLARROEL")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="RODRIGO DURAN")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="VENTA MÓVIL 1")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value=="Octubre")
          @if ($val->adusrNomb=="CONTRATOS INSTITUCIONALES")
          <td>168,512.94</td>
          <td>154,449.40</td>
          @endif
          @if ($val->adusrNomb=="GUADALUPE AMBA")
          <td>199,752.18</td>
          <td>135,060.62</td>
          @endif
          @if ($val->adusrNomb=="INES VELASQUEZ")
          <td>5,357.20</td>
          <td>120,691.84</td>
          @endif
          @if ($val->adusrNomb=="JULIO MANCILLA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="MAGDY VILLARROEL")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="RODRIGO DURAN")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="VENTA MÓVIL 1")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value=="Noviembre")
          @if ($val->adusrNomb=="CONTRATOS INSTITUCIONALES")
          <td>67,193.29</td>
          <td>127,393.64</td>
          @endif
          @if ($val->adusrNomb=="GUADALUPE AMBA")
          <td>112,426.35</td>
          <td>281,941.17</td>
          @endif
          @if ($val->adusrNomb=="INES VELASQUEZ")
          <td>17,623.95</td>
          <td>72,648.80</td>
          @endif
          @if ($val->adusrNomb=="JULIO MANCILLA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="MAGDY VILLARROEL")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="RODRIGO DURAN")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="VENTA MÓVIL 1")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value=="Diciembre")
          @if ($val->adusrNomb=="CONTRATOS INSTITUCIONALES")
          <td>165,125.38</td>
          <td>250,303.45</td>
          @endif
          @if ($val->adusrNomb=="GUADALUPE AMBA")
          <td>30,234.92</td>
          <td>139,206.17</td>
          @endif
          @if ($val->adusrNomb=="INES VELASQUEZ")
          <td>22,077.25</td>
          <td>45,986.13</td>
          @endif
          @if ($val->adusrNomb=="JULIO MANCILLA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="MAGDY VILLARROEL")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="RODRIGO DURAN")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="VENTA MÓVIL 1")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $val->$val1 }}</td>
          @endif
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          <td>{{ $val->$val5 }}</td>
          @endforeach
  
          @if ($val->adusrNomb=="CONTRATOS INSTITUCIONALES")
          <td>{{ number_format($arrayInstitucional19['contra'], 2) }}</td>
          <td>{{ number_format($arrayInstitucional20['contra'], 2) }}</td>
          <td>{{ number_format($total_seg[5]['INSTITUCIONALES'][0]->Tot1 + $arrayInstitucional21['contra'], 2) }}</td>
          @endif
          @if ($val->adusrNomb=="GUADALUPE AMBA")
          <td>{{ number_format($arrayInstitucional19['gamba'], 2) }}</td>
          <td>{{ number_format($arrayInstitucional20['gamba'], 2) }}</td>
          <td>{{ number_format($total_seg[5]['INSTITUCIONALES'][1]->Tot1 + $arrayInstitucional21['gamba'], 2) }}</td>
          @endif
          @if ($val->adusrNomb=="INES VELASQUEZ")
          <td>{{ number_format($arrayInstitucional19['velasquez'], 2) }}</td>
          <td>{{ number_format($arrayInstitucional20['velasquez'], 2) }}</td>
          <td>{{ number_format($total_seg[5]['INSTITUCIONALES'][2]->Tot1 + $arrayInstitucional21['velasquez'], 2) }}</td>
          @endif
          @if ($val->adusrNomb=="JULIO MANCILLA")
          <td>0.00</td>
          <td>0.00</td>
          <td>{{number_format($total_seg[5]['INSTITUCIONALES'][3]->Tot1, 2)}}</td>
          @endif
          @if ($val->adusrNomb=="MAGDY VILLARROEL")
          <td>0.00</td>
          <td>0.00</td>
          <td>{{number_format($total_seg[5]['INSTITUCIONALES'][4]->Tot1, 2)}}</td>
          @endif
          @if ($val->adusrNomb=="RODRIGO DURAN")
          <td>0.00</td>
          <td>0.00</td>
          <td>{{number_format($total_seg[5]['INSTITUCIONALES'][5]->Tot1, 2)}}</td>
          @endif
          @if ($val->adusrNomb=="VENTA MÓVIL 1")
          <td>0.00</td>
          <td>0.00</td>
          <td>{{number_format($total_seg[5]['INSTITUCIONALES'][6]->Tot1, 2)}}</td>
          @endif
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->Tot3 }}</td>
          <td>{{ $val->Tot4 }}</td>
          <td>{{ $val->Tot5 }}</td>
        </tr>
        @endforeach
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">MAYORISTAS</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          <td>872,951.20</td>
          <td>958,431.29</td>
          <td>464,965.60</td>
          @endif
  
          @if ($value=="Febrero")
          <td>1,107,627.53</td>
          <td>1,115,366.34</td>
          <td>810,403.87</td>
          @endif
  
          @if ($value=="Marzo")
          <td>453,364.12</td>
          <td>290,832.78</td>
          @endif
  
          @if ($value=="Abril")
          <td>294,276.21</td>
          <td>0.00</td>
          @endif
  
          @if ($value=="Mayo")
          <td>245,674.08</td>
          <td>0.00</td>
          @endif
  
          @if ($value=="Junio")
          <td>382,916.79</td>
          <td>324,971.27</td>
          @endif
  
          @if ($value=="Julio")
          <td>386,164.72</td>
          <td>100,837.07</td>
          @endif
  
          @if ($value=="Agosto")
          <td>395,024.87</td>
          <td>80,678.10</td>
          @endif
  
          @if ($value=="Septiembre")
          <td>404,356.15</td>
          <td>239,272.61</td>
          @endif
  
          @if ($value=="Octubre")
          <td>171,837.61</td>
          <td>230,244.92</td>
          @endif
  
          @if ($value=="Noviembre")
          <td>186,285.16</td>
          <td>197,517.54</td>
          @endif
  
          @if ($value=="Diciembre")
          <td>402,186.98</td>
          <td>155,063.40</td>
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $total[6]['MAYORISTAS'][0]->$val1 }}</td>
          @endif
          <td>{{ $total[6]['MAYORISTAS'][0]->$val2 }}</td>
          <td>{{ $total[6]['MAYORISTAS'][0]->$val3 }}</td>
          <td class="subTitulos">{{ $total[6]['MAYORISTAS'][0]->$val4 }}</td>
          <td class="subTitulos">{{ $total[6]['MAYORISTAS'][0]->$val5 }}</td>
          @endforeach
          <td>{{ number_format($sumMayoristas19, 2) }}</td>
          <td>{{ number_format($sumMayoristas20, 2) }}</td>
          <td>{{ number_format($total[6]['MAYORISTAS'][0]->Tot1 + $sumMayoristas21, 2) }}</td>
          <td>{{ $total[6]['MAYORISTAS'][0]->Tot2 }}</td>
          <td>{{ $total[6]['MAYORISTAS'][0]->Tot3 }}</td>
          <td class="subTitulos">{{ $total[6]['MAYORISTAS'][0]->Tot4 }}</td>
          <td class="subTitulos">{{ $total[6]['MAYORISTAS'][0]->Tot5 }}</td>
        </tr>
        @foreach ($total_seg[6]['MAYORISTAS'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          @if ($val->adusrNomb=="DAVID CUTIPA")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DAVID MAMANI")
          <td>234,000.10</td>
          <td>132,259.06</td>
          <td>171,059.50</td>
          @endif
          @if ($val->adusrNomb=="ERWIN VILLARROEL")
          <td>167,879.50</td>
          <td>131,158.13</td>
          <td>60,634.90</td>
          @endif
          @if ($val->adusrNomb=="JAVIER MACHICADO")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="ROSALIA TICONA")
          <td>471,071.60</td>
          <td>695,014.10</td>
          <td>233,271.20</td>
          @endif
          @endif
  
          @if ($value=="Febrero")
          @if ($val->adusrNomb=="DAVID CUTIPA")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DAVID MAMANI")
          <td>97,270.11</td>
          <td>270,771.12</td>
          <td>136,383.62</td>
          @endif
          @if ($val->adusrNomb=="ERWIN VILLARROEL")
          <td>115,210.32</td>
          <td>61,972.40</td>
          <td>81,860.45</td>
          @endif
          @if ($val->adusrNomb=="JAVIER MACHICADO")
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="ROSALIA TICONA")
          <td>895,147.10</td>
          <td>782,622.82</td>
          <td>592,159.80</td>
          @endif
          @endif
  
          @if ($value=="Marzo")
          @if ($val->adusrNomb=="DAVID CUTIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DAVID MAMANI")
          <td>40,934.00</td>
          <td>60,769.78</td>
          @endif
          @if ($val->adusrNomb=="ERWIN VILLARROEL")
          <td>96,938.26</td>
          <td>12,931.50</td>
          @endif
          @if ($val->adusrNomb=="JAVIER MACHICADO")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="ROSALIA TICONA")
          <td>315,491.86</td>
          <td>217,131.50</td>
          @endif
          @endif
  
          @if ($value=="Abril")
          @if ($val->adusrNomb=="DAVID CUTIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DAVID MAMANI")
          <td>169,941.29</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="ERWIN VILLARROEL")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="JAVIER MACHICADO")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="ROSALIA TICONA")
          <td>124,334.92</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value=="Mayo")
          @if ($val->adusrNomb=="DAVID CUTIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DAVID MAMANI")
          <td>112,117.20</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="ERWIN VILLARROEL")
          <td>2,893.60</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="JAVIER MACHICADO")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="ROSALIA TICONA")
          <td>130,663.28</td>
          <td>0.00</td>
          @endif
          @endif
  
          @if ($value=="Junio")
          @if ($val->adusrNomb=="DAVID CUTIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DAVID MAMANI")
          <td>111,963.41</td>
          <td>68,675.90</td>
          @endif
          @if ($val->adusrNomb=="ERWIN VILLARROEL")
          <td>161,885.18</td>
          <td>17,493.67</td>
          @endif
          @if ($val->adusrNomb=="JAVIER MACHICADO")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="ROSALIA TICONA")
          <td>109,068.20</td>
          <td>238,801.70</td>
          @endif
          @endif
  
          @if ($value=="Julio")
          @if ($val->adusrNomb=="DAVID CUTIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DAVID MAMANI")
          <td>164,138.92</td>
          <td>59,022.65</td>
          @endif
          @if ($val->adusrNomb=="ERWIN VILLARROEL")
          <td>97,510.00</td>
          <td>16,667.70</td>
          @endif
          @if ($val->adusrNomb=="JAVIER MACHICADO")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="ROSALIA TICONA")
          <td>124,515.80</td>
          <td>25,146.72</td>
          @endif
          @endif
  
          @if ($value=="Agosto")
          @if ($val->adusrNomb=="DAVID CUTIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DAVID MAMANI")
          <td>164,484.67</td>
          <td>35,017.10</td>
          @endif
          @if ($val->adusrNomb=="ERWIN VILLARROEL")
          <td>0.00</td>
          <td>4,194.90</td>
          @endif
          @if ($val->adusrNomb=="JAVIER MACHICADO")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="ROSALIA TICONA")
          <td>230,540.20</td>
          <td>41,466.10</td>
          @endif
          @endif
  
          @if ($value=="Septiembre")
          @if ($val->adusrNomb=="DAVID CUTIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DAVID MAMANI")
          <td>132,193.47</td>
          <td>86,120.45</td>
          @endif
          @if ($val->adusrNomb=="ERWIN VILLARROEL")
          <td>42,805.86</td>
          <td>56,978.16</td>
          @endif
          @if ($val->adusrNomb=="JAVIER MACHICADO")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="ROSALIA TICONA")
          <td>229,356.82</td>
          <td>96,174.00</td>
          @endif
          @endif
  
          @if ($value=="Octubre")
          @if ($val->adusrNomb=="DAVID CUTIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DAVID MAMANI")
          <td>37,255.96</td>
          <td>126,435.72</td>
          @endif
          @if ($val->adusrNomb=="ERWIN VILLARROEL")
          <td>35,214.65</td>
          <td>21,349.70</td>
          @endif
          @if ($val->adusrNomb=="JAVIER MACHICADO")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="ROSALIA TICONA")
          <td>99,367.00</td>
          <td>82,459.50</td>
          @endif
          @endif
  
          @if ($value=="Noviembre")
          @if ($val->adusrNomb=="DAVID CUTIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DAVID MAMANI")
          <td>106,371.44</td>
          <td>99,285.34</td>
          @endif
          @if ($val->adusrNomb=="ERWIN VILLARROEL")
          <td>13,531.92</td>
          <td>24,973.50</td>
          @endif
          @if ($val->adusrNomb=="JAVIER MACHICADO")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="ROSALIA TICONA")
          <td>66,381.80</td>
          <td>73,258.70</td>
          @endif
          @endif
  
          @if ($value=="Diciembre")
          @if ($val->adusrNomb=="DAVID CUTIPA")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DAVID MAMANI")
          <td>104,609.00</td>
          <td>52,637.50</td>
          @endif
          @if ($val->adusrNomb=="ERWIN VILLARROEL")
          <td>59,859.44</td>
          <td>38,963.50</td>
          @endif
          @if ($val->adusrNomb=="JAVIER MACHICADO")
          <td>0.00</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="ROSALIA TICONA")
          <td>237,718.54</td>
          <td>63,462.40</td>
          @endif
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $val->$val1 }}</td>
          @endif
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          <td>{{ $val->$val5 }}</td>
          @endforeach
          @if ($val->adusrNomb=="DAVID CUTIPA")
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ number_format($total_seg[6]['MAYORISTAS'][0]->Tot1 + $arrayMayoristas21['cutipa'], 2) }}</td>
          @endif
          @if ($val->adusrNomb=="DAVID MAMANI")
          <td>{{ number_format($arrayMayoristas19['mamani'], 2) }} </td>
          <td>{{ number_format($arrayMayoristas20['mamani'], 2) }} </td>
          <td>{{ number_format($total_seg[6]['MAYORISTAS'][1]->Tot1 + $arrayMayoristas21['mamani'], 2) }} </td>
          @endif
          @if ($val->adusrNomb=="ERWIN VILLARROEL")
          <td>{{ number_format($arrayMayoristas19['villarroel'], 2) }} </td>
          <td>{{ number_format($arrayMayoristas20['villarroel'], 2) }} </td>
          <td>{{ number_format($total_seg[6]['MAYORISTAS'][2]->Tot1 + $arrayMayoristas21['villarroel'], 2) }} </td>
          @endif
          @if ($val->adusrNomb=="JAVIER MACHICADO")
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ number_format($total_seg[6]['MAYORISTAS'][3]->Tot1, 2) }}</td>
          @endif
          @if ($val->adusrNomb=="ROSALIA TICONA")
          <td>{{ number_format($arrayMayoristas19['ticona'], 2) }} </td>
          <td>{{ number_format($arrayMayoristas20['ticona'], 2) }} </td>
          <td>{{ number_format($total_seg[6]['MAYORISTAS'][4]->Tot1 + $arrayMayoristas21['ticona'], 2) }} </td>
          @endif
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->Tot3 }}</td>
          <td>{{ $val->Tot4 }}</td>
          <td>{{ $val->Tot5 }}</td>
        </tr>
        @endforeach
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">SANTA CRUZ</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          <td>394,453.10</td>
          <td>496,913.04</td>
          <td>156,869.30</td>
          @endif
  
          @if ($value=="Febrero")
          <td>112,654.20</td>
          <td>331,979.94</td>
          <td>192,365.20</td>
          @endif
  
          @if ($value=="Marzo")
          <td>44,587.84</td>
          <td>41,911.98</td>
          @endif
  
          @if ($value=="Abril")
          <td>48,388.60</td>
          <td>0.00</td>
          @endif
  
          @if ($value=="Mayo")
          <td>24,891.34</td>
          <td>0.00</td>
          @endif
  
          @if ($value=="Junio")
          <td>32,689.90</td>
          <td>45,236.60</td>
          @endif
  
          @if ($value=="Julio")
          <td>44,190.00</td>
          <td>36,690.80</td>
          @endif
  
          @if ($value=="Agosto")
          <td>86,050.90</td>
          <td>42,483.60</td>
          @endif
  
          @if ($value=="Septiembre")
          <td>51,411.70</td>
          <td>82,528.00</td>
          @endif
  
          @if ($value=="Octubre")
          <td>36,061.68</td>
          <td>43,755.70</td>
          @endif
  
          @if ($value=="Noviembre")
          <td>30,135.04</td>
          <td>83,501.90</td>
          @endif
  
          @if ($value=="Diciembre")
          <td>30,915.30</td>
          <td>52,485.10</td>
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $total[7]['SANTA CRUZ'][0]->$val1 }}</td>
          @endif
          <td>{{ $total[7]['SANTA CRUZ'][0]->$val2 }}</td>
          <td>{{ $total[7]['SANTA CRUZ'][0]->$val3 }}</td>
          <td class="subTitulos">{{ $total[7]['SANTA CRUZ'][0]->$val4 }}</td>
          <td class="subTitulos">{{ $total[7]['SANTA CRUZ'][0]->$val5 }}</td>
          @endforeach
          <td>{{ number_format($sumSC19, 2) }}</td>
          <td>{{ number_format($sumSC20, 2) }}</td>
          <td>{{ number_format($total[7]['SANTA CRUZ'][0]->Tot1 + $sumSC21, 2) }}</td>
          <td>{{ $total[7]['SANTA CRUZ'][0]->Tot2 }}</td>
          <td>{{ $total[7]['SANTA CRUZ'][0]->Tot3 }}</td>
          <td class="subTitulos">{{ $total[7]['SANTA CRUZ'][0]->Tot4 }}</td>
          <td class="subTitulos">{{ $total[7]['SANTA CRUZ'][0]->Tot5 }}</td>
        </tr>
        @foreach ($total_seg[7]['SANTA CRUZ'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->adusrNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
  
          @if ($value=="Enero")
          @if ($val->adusrNomb=="CARMELA ESCOBAR")
          <td>80,553.50</td>
          <td>89,986.96</td>
          <td>77,633.50</td>
          @endif
          @if ($val->adusrNomb=="DANI CALDERON")
          <td>313,899.60</td>
          <td>406,926.08</td>
          <td>79,235.80</td>
          @endif
          @endif
  
          @if ($value=="Febrero")
          @if ($val->adusrNomb=="CARMELA ESCOBAR")
          <td>28,458.00</td>
          <td>76,304.52</td>
          <td>89,201.20</td>
          @endif
          @if ($val->adusrNomb=="DANI CALDERON")
          <td>84,196.20</td>
          <td>255,675.42</td>
          <td>103,164.00</td>
          @endif
          @endif
          @if ($value=="Marzo")
          @if ($val->adusrNomb=="CARMELA ESCOBAR")
          <td>24,318.24</td>
          <td>31,766.00</td>
          @endif
          @if ($val->adusrNomb=="DANI CALDERON")
          <td>20,269.60</td>
          <td>10,145.98</td>
          @endif
          @endif
          @if ($value=="Abril")
          @if ($val->adusrNomb=="CARMELA ESCOBAR")
          <td>31,478.60</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DANI CALDERON")
          <td>16,910.00</td>
          <td>0.00</td>
          @endif
          @endif
          @if ($value=="Mayo")
          @if ($val->adusrNomb=="CARMELA ESCOBAR")
          <td>8,283.20</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DANI CALDERON")
          <td>16,608.14</td>
          <td>0.00</td>
          @endif
          @endif
          @if ($value=="Junio")
          @if ($val->adusrNomb=="CARMELA ESCOBAR")
          <td>8,648.30</td>
          <td>0.00</td>
          @endif
          @if ($val->adusrNomb=="DANI CALDERON")
          <td>24,041.60</td>
          <td>45,236.60</td>
          @endif
          @endif
          @if ($value=="Julio")
          @if ($val->adusrNomb=="CARMELA ESCOBAR")
          <td>20,896.90</td>
          <td>8,814.20</td>
          @endif
          @if ($val->adusrNomb=="DANI CALDERON")
          <td>23,293.10</td>
          <td>27,876.60</td>
          @endif
          @endif
          @if ($value=="Agosto")
          @if ($val->adusrNomb=="CARMELA ESCOBAR")
          <td>57,877.20</td>
          <td>18,145.60</td>
          @endif
          @if ($val->adusrNomb=="DANI CALDERON")
          <td>28,173.70</td>
          <td>24,338.00</td>
          @endif
          @endif
          @if ($value=="Septiembre")
          @if ($val->adusrNomb=="CARMELA ESCOBAR")
          <td>25,290.00</td>
          <td>28,367.20</td>
          @endif
          @if ($val->adusrNomb=="DANI CALDERON")
          <td>26,121.70</td>
          <td>54,160.80</td>
          @endif
          @endif
          @if ($value=="Octubre")
          @if ($val->adusrNomb=="CARMELA ESCOBAR")
          <td>21,738.48</td>
          <td>25,743.70</td>
          @endif
          @if ($val->adusrNomb=="DANI CALDERON")
          <td>14,323.20</td>
          <td>18,012.00</td>
          @endif
          @endif
          @if ($value=="Noviembre")
          @if ($val->adusrNomb=="CARMELA ESCOBAR")
          <td>9,464.04</td>
          <td>19,773.50</td>
          @endif
          @if ($val->adusrNomb=="DANI CALDERON")
          <td>20,671.00</td>
          <td>63,728.40</td>
          @endif
          @endif
          @if ($value=="Diciembre")
          @if ($val->adusrNomb=="CARMELA ESCOBAR")
          <td>8,762.00</td>
          <td>16,035.40</td>
          @endif
          @if ($val->adusrNomb=="DANI CALDERON")
          <td>22,153.30</td>
          <td>36,449.70</td>
          @endif
          @endif
  
          @if ($value!="Enero"&&$value!="Febrero")
          <td>{{ $val->$val1 }}</td>
          @endif
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          <td>{{ $val->$val5 }}</td>
          @endforeach
          @if ($val->adusrNomb=="CARMELA ESCOBAR")
          <td>{{ number_format($arraySC19['escobar'], 2) }}</td>
          <td>{{ number_format($arraySC20['escobar'], 2) }}</td>
          <td>{{ number_format($total_seg[7]['SANTA CRUZ'][0]->Tot1 + $arraySC21['escobar'], 2) }}</td>
          @endif
          @if ($val->adusrNomb=="DANI CALDERON")
          <td>{{ number_format($arraySC19['calderon'], 2) }}</td>
          <td>{{ number_format($arraySC20['calderon'], 2) }}</td>
          <td>{{ number_format($total_seg[7]['SANTA CRUZ'][1]->Tot1 + $arraySC21['calderon'], 2) }}</td>
          @endif
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->Tot3 }}</td>
          <td>{{ $val->Tot4 }}</td>
          <td>{{ $val->Tot5 }}</td>
        </tr>
        @endforeach
  
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">REGIONAL 1</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ $total_regional[0]['REGIONAL1'][0]->$val1 }}</td>
          <td>{{ $total_regional[0]['REGIONAL1'][0]->$val2 }}</td>
          <td>{{ $total_regional[0]['REGIONAL1'][0]->$val3 }}</td>
          <td class="subTitulos">{{ $total_regional[0]['REGIONAL1'][0]->$val4 }}</td>
          <td class="subTitulos">{{ $total_regional[0]['REGIONAL1'][0]->$val5 }}</td>
          @endforeach
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ $total_regional[0]['REGIONAL1'][0]->Tot1 }}</td>
          <td>{{ $total_regional[0]['REGIONAL1'][0]->Tot2 }}</td>
          <td>{{ $total_regional[0]['REGIONAL1'][0]->Tot3 }}</td>
          <td class="subTitulos">{{ $total_regional[0]['REGIONAL1'][0]->Tot4 }}</td>
          <td class="subTitulos">{{ $total_regional[0]['REGIONAL1'][0]->Tot5 }}</td>
        </tr>
        @foreach ($total_seg_regional[0]['REGIONAL1'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->inalmNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
          
          <td>0.00</td>
          <td>0.00</td>
  
          <td>{{ $val->$val1 }}</td>
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          <td>{{ $val->$val5 }}</td>
          @endforeach
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ $val->Tot1 }}</td>
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->Tot3 }}</td>
          <td>{{ $val->Tot4 }}</td>
          <td>{{ $val->Tot5 }}</td>
        </tr>
        @endforeach
        <tr class="text-end" style="font-weight: bold; background-color: rgb(190 205 251);">
          <td class="text-start">REGIONAL 2</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ $total_regional[1]['REGIONAL2'][0]->$val1 }}</td>
          <td>{{ $total_regional[1]['REGIONAL2'][0]->$val2 }}</td>
          <td>{{ $total_regional[1]['REGIONAL2'][0]->$val3 }}</td>
          <td class="subTitulos">{{ $total_regional[1]['REGIONAL2'][0]->$val4 }}</td>
          <td class="subTitulos">{{ $total_regional[1]['REGIONAL2'][0]->$val5 }}</td>
          @endforeach
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ $total_regional[1]['REGIONAL2'][0]->Tot1 }}</td>
          <td>{{ $total_regional[1]['REGIONAL2'][0]->Tot2 }}</td>
          <td>{{ $total_regional[1]['REGIONAL2'][0]->Tot3 }}</td>
          <td class="subTitulos">{{ $total_regional[1]['REGIONAL2'][0]->Tot4 }}</td>
          <td class="subTitulos">{{ $total_regional[1]['REGIONAL2'][0]->Tot5 }}</td>
        </tr>
        @foreach ($total_seg_regional[1]['REGIONAL2'] as $val)
        <tr class="text-end">
          <td class="text-start">{{ $val->inalmNomb }}</td>
          @foreach ($options as $k => $value)
          @php
          $val1 = $value."1";
          $val2 = $value."2";
          $val3 = $value."3";
          $val4 = $value."4";
          $val5 = $value."5";
          @endphp
          
          <td>0.00</td>
          <td>0.00</td>
  
          <td>{{ $val->$val1 }}</td>
          <td>{{ $val->$val2 }}</td>
          <td>{{ $val->$val3 }}</td>
          <td>{{ $val->$val4 }}</td>
          <td>{{ $val->$val5 }}</td>
          @endforeach
          <td>0.00</td>
          <td>0.00</td>
          <td>{{ $val->Tot1 }}</td>
          <td>{{ $val->Tot2 }}</td>
          <td>{{ $val->Tot3 }}</td>
          <td>{{ $val->Tot4 }}</td>
          <td>{{ $val->Tot5 }}</td>
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
                cells: [2,4,5,13,17,21,25,28,36,42,45,48],                     
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
