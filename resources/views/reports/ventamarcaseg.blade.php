@extends('layouts.app')
@section('estilo')
<style>
    #tableex_processing
    {
        padding-top: 10%;
        z-index: -50;
    }
    th{
        text-align: center;
    }
    .no-hover:hover{
        background-color: #fff;
        color: #355296;
    }
    .color0, .color9{
        background:rgb(84, 112, 198,0.3)}
    .color1{
        background:rgb(145, 204, 117,0.3)}
    .color2{
    background:rgb(250, 200, 88,0.3) }
    .color3{
    background:rgb(238, 102, 102,0.3) }
    .color4{
    background:rgb(115, 192, 222,0.3) }
    .color5{
    background:rgb(59, 162, 114,0.3) }
    .color6{
    background:rgb(252, 132, 82,0.3) }
    .color7{
    background:rgb(154, 96, 180,0.3)} 
    .color8{
    background:rgb(234, 124, 204,0.3)}
    .cellborders{
        border: 1px solid #000;
    }
    .cellbordersh{
        border: 1px solid #000;
    }
    .bg-margutil{
      background-color: #ff00003d !important;
    }
    table{
        border-collapse: collapse !important;
    }
</style>
@endsection
@section('content')
@include('layouts.sidebar', ['hide'=>'0']) 
<div class="container-fluid">
    <div class="row d-flex mt-2">
        <div class="offset-md-1 col-4">
            <p id="title"></p>
        </div>
        <div class="col-5 text-end">
            <div class="mb-2 row d-flex justify-content-center">
                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Desde:</label>
                <div class="col-sm-4">
                <input id="fini" type="date" class="form-control form-control-sm " name="fini" value ="{{date('Y-m-d')}}">
                </div>
                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Hasta:</label>
                <div class="col-sm-4">
                <input id="ffin" type="date" class="form-control form-control-sm " name="ffin" value ="{{date('Y-m-d')}}">
                </div>
            </div> 
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-8 tabla_cont">
            <div class="row mb-2">
                <div class="col-12 d-flex">
                    <form action="{{route('ventamarcauser.index')}}" method="GET">
                        @csrf
                        @if(!isset($sucur))
                            <input type="hidden" name = "sucur" value="sucur">
                        @endif
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white">Reporte Por </span>
                            @if(!isset($sucur))
                                <button class="btn btn-sm btn-outline-primary no-hover">Segmento</button>
                            @else
                                <button class="btn btn-sm btn-outline-primary no-hover">Sucursal</button>
                            @endif
                            <!--button type="button" class="btn btn-sm btn-outline-primary no-hover" id="test" value="xGrupo">
                                xGrupo
                            </button-->
                            <select class="btn btn-sm btn-outline-primary no-hover ms-2" id="test">
                                <option value="xSegmento" class="text-start">Segmento</option>
                                <option value="xGrupo" class="text-start">Grupo</option>
                                <option value="xUsuario" class="text-start">Usuario</option>
                            </select>
                            <!--select class="btn btn-sm btn-outline-primary no-hover" id="test">
                                <option value="Marca" class="text-start">Marcas</option>
                                <option value="Producto" class="text-start">Productos</option>
                                <option value="Cliente" class="text-start">Clientes</option>
                            </select-->
                            <span class="input-group-text bg-white ms-2 d-none" id="paretoByspan">Pareto Por </span>
                            <select class="btn btn-sm btn-outline-primary no-hover d-none" id="paretoBy">
                                <option value="sumtot" class="text-start">Total</option>
                                <option value="sumtot_can" class="text-start">Cantidad</option>
                                <option value="mutil" class="text-start">Margen</option>
                                <option value="sumtotneto" class="text-start">Total Neto</option>
                            </select>

                            <span class="input-group-text bg-white ms-2 d-none" id="margenByspan">Margen U. Por </span>
                            <select class="btn btn-sm btn-outline-primary no-hover d-none" id="margenBy">
                                <option value="sumtot" class="text-start">Total</option>
                                <option value="sumtotneto" class="text-start">Total Neto</option>
                            </select>
                        </div> 
                    </form>          
                </div>
            </div>
            <table class="display cell-border compact responsive" id="tableex" style="width:100%;font-size:0.7rem">
            </table>
        </div>
        <div class="col-4 px-4 graficos" style="height:85vh;">
            <div class="row">
                <div class="col-6">
                    <div class="form-check form-check-inline">
                        <input type="radio" class="btn-check" name="options-outlined" id="graficoxmarca" autocomplete="off">
                        <label id ="graficoxmarcatext" class="btn btn-sm btn-outline-primary" for="graficoxmarca">Marca</label>
                        <input type="radio" class="btn-check" name="options-outlined" id="graficoxvendedor" autocomplete="off" checked>
                        <label class="btn  btn-sm btn-outline-primary" for="graficoxvendedor">Vendedor</label>
                    </div>
                </div>
            </div>
            <div class="row" style="height:55%;overflow:auto;">
                <div id="resumen" style="width:100%;height:80%;margin:auto;"></div>
            </div>
            <!--div class="row" style="height:45%;overflow:auto;border-top: 1px solid rgba(12,64,148,0.34);">
                <div id="barras" style="height:95%;margin:auto;"></div>
            </div-->
            <div class="row pareto_class d-none" style="height:35%;overflow:auto;border-top: 1px solid rgba(12,64,148,0.34);">
                <table class="display cell-border compact" id="pareto_A" style="width:100%;font-size:0.75rem">
                </table>
            </div>
        </div>
    </div>
    <div class="controles-form-esq">
        <!--button type="submit" class="btn btn-primary mx-2" name="gen" value="export">
            PDF <i class="fas fa-file-pdf"></i>
        </button-->
        <button type="button" class="btn btn-sm btn-danger" id="atras">
            <i class="fas fa-arrow-left"></i>
        </button>
        <button type="button" class="btn btn-sm btn-primary" id="actualizar">
            <i class="fas fa-redo-alt"></i>
        </button>
        <button type="button" class="btn btn-sm btn-outline-primary excel-export" name="gen" value="excel">
            Excel
        </button>
        @if(Auth::user()->tienePermiso(15,10))
            <input type="checkbox" class="btn-check" id="pareto" autocomplete="off">
            <label class="btn btn-sm btn-outline-primary" for="pareto">Pareto</label>
        @endif
        <input type="checkbox" class="btn-check" id="showchart" checked autocomplete="off">
        <label class="btn btn-sm btn-outline-primary" for="showchart">Graficos</label>
    </div>
    <div class="controles-form-esq-der">
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fas fa-wrench"></i>
        </button>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#grafModal">
            <i class="far fa-chart-bar"></i>
        </button>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">CONFIGURACION</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="height:75vh;overflow:auto;">
                    <div class="row" id="config_users">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach ($capas as $c =>$capa)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if($c == 'Segmento') active @endif " id="{{$c}}-tab" data-bs-toggle="tab" data-bs-target="#{{$c}}" type="button" role="tab" aria-controls="{{$c}}" aria-selected="false">{{$c}}</button>
                                </li>  
                            @endforeach
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @foreach ($capas as $c => $cap)
                                <div class="tab-pane fade @if($c == 'Segmento') show active @endif" id="{{$c}}" role="tabpanel" aria-labelledby="{{$c}}-tab">
                                    {{$c}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <div class="modal fade" id="grafModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!--div class="modal-header">
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div-->
                <div class="modal-body" style="height:85vh;overflow:auto;">
                    <div class="row">
                        <ul class="nav nav-tabs" id="graf" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nav-link-sm active" id="primerosB-tab" data-bs-toggle="tab" data-bs-target="#primerosB" 
                                type="button" role="tab" aria-controls="primerosB" aria-selected="false">Barras</button>
                            </li>  
                            @if(Auth::user()->tienePermiso(15,10))
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link disabled" id="paretoG-tab" data-bs-toggle="tab" data-bs-target="#paretoG" 
                                    type="button" role="tab" aria-controls="paretoG" aria-selected="false">Pareto</button>
                                </li>  
                            @endif
                        </ul>
                        <div class="tab-content" id="graft">
                            <div class="tab-pane fade show active" id="primerosB" role="tabpanel" aria-labelledby="primerosB-tab">
                                <div class="row d-flex justify-content-center">
                                    <div id="barras" class="mt-4" style="width:1000px;height:65vh"></div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="paretoG" role="tabpanel" aria-labelledby="paretoG-tab">
                                <div class="row d-flex justify-content-center">
                                    <div id="paretoGraf" class="mt-4" style="width:1000px;height:65vh"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection
@section('mis_scripts')
<script>    
    $(document).ready(function() 
    {   
        //ADD COMMAS - Añadir Comas
        function addCommas(nStr) {
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
        //ADD COMMAS END
        function mixanalisys()
        {  
            $(".excel-export").click(function(e){     
                $('#tableex').DataTable().buttons(0).trigger();
            });
            $("#pareto").click(function(){
                actualizarTable();
                if($("#pareto").is(":checked")){
                    $("#paretoBy").removeClass("d-none");
                    $("#paretoByspan").removeClass("d-none");
                    $("#margenBy").removeClass("d-none");
                    $("#margenByspan").removeClass("d-none");
                }
                else{
                    $("#paretoBy").addClass("d-none");
                    $("#paretoByspan").addClass("d-none");
                    $("#margenBy").addClass("d-none");
                    $("#margenByspan").addClass("d-none");
                }
            });
            $("#showchart").click(function(e){
                if($("#showchart").is(':checked')){
                    $(".tabla_cont").addClass("col-8");
                    $(".tabla_cont").removeClass("col-12");
                    $(".graficos").removeClass("d-none");
                    $("#tableex").DataTable().columns.adjust();
                }
                else{
                    $(".tabla_cont").removeClass("col-8");
                    $(".tabla_cont").addClass("col-12");
                    $(".graficos").addClass("d-none");
                    $("#tableex").DataTable().columns.adjust();
                }
            });
            var users = {!! json_encode($user) !!};
            var capas = {!! json_encode($capas) !!};
            var sucur = {!! json_encode($sucur) !!};
            //GRAFICO PIE
            var pie= function Pie(user, dataG)
            {
                var chartDom = document.getElementById(user);
                var pastel = echarts.init(chartDom);
                var option = {
                    tooltip: {
                        trigger: 'item',
                        formatter: '{b} : {c} ({d}%)',
                        position: 'top'
                    },
                    textStyle:{fontSize: 9},
                    color: 
                    ['#5470c6', 
                    '#91cc75', 
                    '#fac858', 
                    '#ee6666', 
                    '#73c0de', 
                    '#3ba272', 
                    '#fc8452', 
                    '#9a60b4', 
                    '#ea7ccc'],
                    series: [
                        {
                            name: 'name',
                            type: 'pie',
                            radius: '70%',
                            data: dataG,
                            emphasis: {
                                itemStyle: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }
                    ]
                };
                return option && pastel.setOption(option);     
            }
            //END GRAFICO PIE

            //GRAFICO BARRAS 
            var barras= function Gbarras(BarraN, BarraV,BarraO)
            {
                var chartDom = document.getElementById('barras');
                var myChart = echarts.init(chartDom);
                var option;

                option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    legend:{},
                    colorBy: 'series',
                    grid: {
                        left: '15%',
                        right: '16%',
                        bottom: '13%',
                        containLabel: false
                    },
                    xAxis: {
                        type: 'value',
                        boundaryGap: [0, 0.0001],
                        showMaxLabel: true
                    },
                    yAxis: {
                        type: 'category',
                        data: BarraN
                    },
                    series: BarraO,
                };
                option && myChart.setOption(option, true);
            }
            //END GRAFICO BARRAS


            //CREAR TABLA
            var createTable = function(estado, filtro, xmp, marc, client)
            {                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('ventamarcauser.getdatos')}}",
                    type: 'POST',
                    data: {client, marc},
                    dataType: 'json',
                    success: function (data) {
                        let title = '<span class="badge bg-dark">'+(estado ? estado.toUpperCase() : '') +'</span>';
                        title += ' <span class="badge bg-primary">'+ (filtro ? filtro: 'TODOS') +'</span>';
                        title += ' <span class="badge bg-primary">'+ (xmp ? xmp.toUpperCase() : 'TODOS') +'</span>';
                        title += ' <span class="badge bg-primary">'+ (marc ? data.marc.maconNomb : 'TODOS') +'</span>';
                        title += ' <span class="badge bg-primary">'+ (client ? data.client.crentNomb : 'TODOS') +'</span>';
                        $("#title").html(title);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
                $("#tableex thead").remove();
                $('#tableex tfoot').remove();
                var usuarios =[], grupos = [], piepag = '', cabeza = '';
                var anterior = capas[estado].ant;
                var siguiente = capas[estado].sig;

                if(xmp == "xProducto"){
                    var titulos =
                    [
                        {title:'PRODUCTOS', data:'marca',name:'PRODUCTOS'},
                        {title:'DESC', data:'descr',name:'descr'},
                        {title:'U.M.', data:'unidad',name:'unidad'}
                    ];
                }
                else if(xmp == "xCliente"){
                    var titulos = [{title:'CLIENTES', data:'marca', name:'CLIENTES'}];
                }  
                else{
                    var titulos = [{title:'MARCA', data:'marca', name:'MARCA'}];
                } 

                if(filtro == undefined){
                  let cont_alm = 57;
                    Object.entries(users).forEach(([key, value])=> {
                        if(grupos.find(el=>el === value[estado])!=value[estado] ){
                            grupos.push(value[estado]);
                            if(xmp == "xProducto"){
                                titulos.push({title:'Cant', data:value[estado]+'_can', name:value[estado], className: 'dt-body-right', cantidad:true});
                                titulos.push({title:'Total', data:value[estado], name:value[estado], className: 'dt-body-right'});
                                piepag=piepag+'<td class="cellbordersh"></td>';
                            }
                            else{
                                titulos.push({title:value[estado], data:value[estado], name:value[estado], className: 'dt-body-right'});
                            }
                            piepag=piepag+'<td style="font-weight: bold;" class="cellbordersh"></td>';               
                        }
                        usuarios.push({"Grupo":value[estado], 'user_id':value.adusrCusr}); 
                        if(capas[anterior] == undefined){
                            filtro_ant = undefined;
                        }  
                        else{
                            filtro_ant = value[capas[anterior].ant];
                        }              
                    });
                }
                else{
                  let cont_alm = 57;
                    Object.entries(users).forEach(([key, value])=> {
                        if(value[anterior]==filtro){
                            if(grupos.find(el=>el === value[estado])!=value[estado] )
                            {
                                grupos.push(value[estado]);
                                if(xmp == "xProducto"){
                                    titulos.push({title:'Cant', data:value[estado]+'_can', name:value[estado], className: 'dt-body-right', cantidad:true});
                                    titulos.push({title:'Total', data:value[estado], name:value[estado], className: 'dt-body-right'});
                                    piepag=piepag+'<td></td>';
                                }
                                else{
                                    titulos.push({title:value[estado], data:value[estado], name:value[estado], className: 'dt-body-right'});
                                }
                                piepag=piepag+'<td style="font-weight: bold;" class="cellbordersh"></td>';                  
                            }
                            var cont_alm = 56;
                            if(value.adusrCusr != 63 && value.adusrCusr != 64) {
                              usuarios.push({"Grupo":value[estado], 'user_id':value.adusrCusr}); 
                            } else if (value.adusrCusr == 63){
                              usuarios.push({"Grupo":value[estado], 'user_id':cont_alm});
                              cont_alm++;
                            } else if (value.adusrCusr == 64){
                              usuarios.push({"Grupo":value[estado], 'user_id':cont_alm});
                              cont_alm++; 
                            }
                            if(capas[anterior] == undefined){
                                filtro_ant = undefined;
                            }  
                            else{
                                filtro_ant = value[capas[anterior].ant];
                            }              
                        }
                    });        
                }
                if(xmp == "xProducto"){
                    $('#tableex').append('<tfoot id="footer" class="text-end"><tr><td></td><td></td><td></td>'+piepag+'<td style="font-weight: bold;" class="cellborders"></td><td style="font-weight: bold;" class="cellborders"></td><td style="font-weight: bold;" class="cellborders"></td><td style="font-weight: bold;" class="cellborders"></td></tr></tfoot>');
                }
                else if(xmp == "xCliente"){
                    $('#tableex').append('<tfoot id="footer" class="text-end"><tr><td></td>'+piepag+'<td></td></td><td style="font-weight: bold;" class="cellborders"></tr></tfoot>');
                }
                else{
                    $('#tableex').append('<tfoot id="footer" class="text-end"><tr><td></td>'+piepag+'<td style="font-weight: bold;" class="cellborders"></td></td><td style="font-weight: bold;" class="cellborders"><td style="font-weight: bold;" class="cellborders"></td style="font-weight: bold;" class="cellborders"></tr></tfoot>');
                }
                if(xmp == "xProducto"){
                    titulos.push({title:'COST.U', data:'costou', name:'COST.U', className: 'dt-body-right'});
                    titulos.push({title:'CANT', data:'sumtot_can', name:'CANT', className: 'dt-body-right'});
                    titulos.push({title:'TOTAL', data:'sumtotf', name:'TOTAL', className: 'dt-body-right'});   
                    titulos.push({title:'TOTAL.N', data:'sumtotn', name:'TOTAL.N', className: 'dt-body-right'});                
                }
                else if ((xmp == "xMarca")){
                    titulos.push({title:'CANT', data:'sumtot_can', name:'CANT', className: 'dt-body-right'});
                    titulos.push({title:'TOTAL', data:'sumtotf', name:'TOTAL', className: 'dt-body-right'});
                    titulos.push({title:'TOTAL.N', data:'sumtotn', name:'TOTAL.N', className: 'dt-body-right'});
                }
                else{
                    titulos.push({title:'TOTAL', data:'sumtotf', name:'TOTAL', className: 'dt-body-right'}); 
                    titulos.push({title:'TOTAL.N', data:'sumtotn', name:'TOTAL.N', className: 'dt-body-right'}); 
                }
                if($("#pareto").is(':checked')){
                    if(xmp != "xCliente")
                    {
                        titulos.push({title:'M.UTIL', data:'margutil', name:'M.UTIL', className: 'dt-body-right'});
                        titulos.push({title:'PORC.M.UTIL', data:'margutil_porc', name:'PORC.M.UTIL', className: 'dt-body-right',
                            render: function (data) {
                              return data+' %';
                            }
                        });
                    }
                    titulos.push({title:'PARTI', data:'part', name:'partic', className: 'dt-body-right',
                        render: function (data) {
                            return data+' %';
                        },
                    });
                    titulos.push({title:'PARTI.ACUM.', data:'partA', name:'particAcum', className: 'dt-body-right',
                        render: function (data) {
                            return data+' %';
                        }
                    });
                    titulos.push({title:'CLASE', data:'clas', name:'clas', className: 'dt-body-center'},{name:'sumtot', data:'sumtot', visible:false});
                    $(".pareto_class").removeClass("d-none");
                    if ((xmp == "xCliente")){
                        $('#tableex #footer td:last').after('<td></td><td></td>');
                    }
                    else{
                        $('#tableex #footer td:last').after('<td></td><td></td><td></td><td></td><td></td>');
                    }
                    $("#paretoG-tab").removeClass("disabled");
                }
                else{
                    $(".pareto_class").addClass("d-none");
                    $("#paretoG-tab").addClass("disabled");
                }
                // console.log(titulos);
                console.log(usuarios);
                    var table = $('#tableex').DataTable({
                        searching: false,
                        paging:false,
                        info:false,
                        ordering: false,
                        responsive: true,
                        dom: 'frtip',
                        buttons: {
                            buttons:[
                                {
                                    extend:'excelHtml5',
                                    titleAttr: 'Export Excel',
                                    title:'Reporte Ventas '+estado+xmp+' del '+fini+' Al '+ffin,
                                    filename: 'Reporte Ventas '+estado+xmp+' del '+fini+' Al '+ffin,
                                    exportOptions: 
                                    {
                                        format: 
                                        {
                                            header:  function (data, columnIdx) {
                                                if(xmp == "xProducto")
                                                {
                                                    
                                                    return titulos[columnIdx].name + ': ' + data;
                                                }
                                                else
                                                {
                                                    return data;
                                                }
                                            }
                                        }
                                    },
                                }
                            ]
                        },                
                        ajax: 
                        {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url:"{{route('ventamarcauser.general')}}",
                            type: "post",
                            data: function(d){
                                d.usuarios = usuarios;
                                d.fini = $('#fini').val();
                                d.ffin = $('#ffin').val();
                                d.grupos = grupos;
                                d.xmp = xmp;
                                d.marc = marc;
                                d.client = client;
                                d.pareto = $("#pareto").is(':checked');
                                d.paretoBy = $("#paretoBy").val();
                                d.margenBy = $("#margenBy").val();
                            },
                            dataType: 'json',
                            /*success: function (data) {
                                console.log(data);
                            },
                            error: function (data) {
                                console.log(data);
                            }*/
                        },
                        serverSide: true,
                        processing: true,
                        columns:titulos, 
                        "columnDefs": [
                            {
                                "targets": 0,
                                "render": function ( data, type, row, meta ) 
                                {
                                    var link = '<a class="'+xmp+'_prod" id="'+data+'" style="cursor:pointer;">'+data+'</a>'
                                    return link;
                                }
                            },
                        ],    
                        scrollY: "67vh",
                        scrollX:true,
                        scrollCollapse: true,
                        createdRow: function(row, data, dataIndex){
                          if (data.margutil < 0) {
                            $(row).addClass( 'bg-margutil' );
                          }
                        },
                        drawCallback: function( settings ) {
                            if($.fn.DataTable.isDataTable( '#pareto_A')){
                                $("#pareto_A").DataTable().clear().destroy();
                            }
                            $("#pareto_A").DataTable({
                                searching: false,
                                ordering: false,
                                info: false,
                                data:this.api().ajax.json().pareto,
                                paging:false,
                                columns: [
                                    { data: "clas", title: "CLASE" ,className: "text-center"},
                                    { data: "ene", title: "N" ,className: "text-end"},
                                    { data: "particN", title: "PART." ,className: "text-end"},
                                    { data: "Ventas", title: "VENTAS" ,className: "text-end"},
                                    { data: "particVentas", title: "PARTIC.V" ,className: "text-end"},
                                ],
                            });
                            var columnas = this.api().columns().data();
                            var dataG = [];
                            var BarraN= [];
                            var BarraV = [];
                            var BarraO = [];
                            var BarraG_V = [];
                            var total = 0, total_can = 0; total_cost = 0;
                            var sumtot
                            var ParaOrdenar = this.api().rows().data();
                            ParaOrdenar = ParaOrdenar.sort(function(a, b) {
                                if (parseFloat(a.sumtot.replace(/,/g, '')) === parseFloat(b.sumtot.replace(/,/g, ''))) {
                                    return 0;
                                }
                                else {
                                    return (parseFloat(a.sumtot.replace(/,/g, '')) > parseFloat(b.sumtot.replace(/,/g, ''))) ? -1 : 1;                            
                                }
                            });
                            if(ParaOrdenar.length<3){
                                var cont = ParaOrdenar.length;
                            }
                            else{
                                var cont = 3;
                            }
                            for (let i = 0; i < cont; i++){
                                BarraO.push({'name':ParaOrdenar[i].marca, 
                                'type':'bar',
                                'data':[]});
                            }
                            var colors =
                            [
                                'rgb(84, 112, 198,0.3)', 
                                'rgb(145, 204, 117,0.3)', 
                                'rgb(250, 200, 88,0.3)', 
                                'rgb(238, 102, 102,0.3)', 
                                'rgb(115, 192, 222,0.3)', 
                                'rgb(59, 162, 114,0.3)', 
                                'rgb(252, 132, 82,0.3)', 
                                'rgb(154, 96, 180,0.3)', 
                                'rgb(234, 124, 204,0.3)'
                            ];
                            let colorcount = 0;
                            for (let i = 0; i < columnas.length; i++){
                                if(columnas.column(i).title()!='MARCA'
                                &&columnas.column(i).title()!='TOTAL'
                                &&columnas.column(i).title()!='TOTAL.N'
                                &&columnas.column(i).title()!='COST.U'
                                &&columnas.column(i).title()!='COST'
                                &&columnas.column(i).title()!='PRODUCTOS'
                                &&columnas.column(i).title()!='DESC'
                                &&columnas.column(i).title()!='U.M.'
                                &&columnas.column(i).title()!='CLIENTES'
                                &&columnas.column(i).title()!='CANT'
                                &&columnas.column(i).title()!='PARTI'
                                &&columnas.column(i).title()!='PARTI.ACUM.'
                                &&columnas.column(i).title()!='CLASE'
                                &&columnas.column(i).title()!='PORC.M.UTIL'
                                &&columnas.column(i).title()!='M.UTIL'
                                &&columnas.column(i).title()!='')
                                {       
                                    if(columnas.column(i).data().sum()==0)
                                    {
                                    columnas.column(i).visible(false);
                                    }
                                    else
                                    { 
                                        if(xmp == "xProducto"){
                                            suma = Math.round((columnas.column(i).data().sum() + Number.EPSILON) * 100) / 100;
                                            
                                            if(!titulos[i].cantidad){
                                                $(columnas.column(i).header()).
                                                css('background-color', colors[colorcount]).
                                                addClass("cellborders");     
                                                cabeza = cabeza + '<th colspan="2" class="sorting_disabled cabeza cellborders color'+colorcount+'" rowspan="1" style="cursor: pointer; border-top: 1px solid">'+titulos[i].name+'</th>';             
                                                colorcount++;
                                                dataG.push({name:titulos[i].name,
                                                value:suma});
                                                BarraN.push(titulos[i].name);
                                                BarraV.push(suma);
                                                
                                                //Barra1.push();  
                                                for (let j = cont-1; j >= 0; j--) {
                                                    if(ParaOrdenar[j][titulos[i].name])
                                                    {
                                                        BarraO[j].data.push(parseFloat(ParaOrdenar[j][titulos[i].name].replace(/,/g, ''))); 
                                                    }                                        
                                                }  
                                                total = total+suma;  
                                            }  
                                            else if(titulos[i].cantidad){
                                                $(columnas.column(i).header()).
                                                css('background-color', colors[colorcount]).addClass("cellborders");
                                                if(colorcount==0)
                                                {
                                                    $(columnas.column(i).header()).addClass("cellborders");
                                                }  
                                                total_can = total_can+suma;
                                            }   
                                            $(this.api().column(i).footer()).html(addCommas(suma));  
                                                                        
                                        }   
                                        else{
                                            suma = Math.round((columnas.column(i).data().sum() + Number.EPSILON) * 100) / 100;
                                            $(columnas.column(i).header()).
                                            css('background-color', colors[colorcount]).
                                            addClass("cellborders");
                                            colorcount++;
                                            dataG.push({name:columnas.column(i).title(),
                                            value:suma});
                                            BarraN.push(columnas.column(i).title());
                                            BarraV.push(suma);
                            
                                            //Barra1.push();
                                            $(this.api().column(i).footer()).html(addCommas(suma));
                                            total = total+suma;
                                            for (let j = cont-1; j >= 0; j--) {
                                                BarraO[j].data.push(parseFloat(ParaOrdenar[j][columnas.column(i).title()])); 
                                            }  
                                        }
                                    }  
                                }   
                                else if(columnas.column(i).title()=='COST.U'){
                                    
                                    total_cost = Math.round((this.api().column("COST.U:name").data().sum() + Number.EPSILON) * 100) / 100;
                                }                     
                            }    
                            if(xmp == "xProducto"){
                                if($("#pareto").is(':checked'))
                                {
                                    $(this.api().table().header()).prepend('<tr class="subcab" role="row"><td class="sorting_disabled cabeza" rowspan="1" colspan="3" style="cursor: pointer;"></td>'+cabeza+'<th class="sorting_disabled cabeza" rowspan="1" colspan="4" style="cursor: pointer;">TOTALES</th><th colspan=2 class="text-center">MARGEN UTIL</th><th colspan=3 class="text-center">PARETO</th></tr>');
                                }
                                else{
                                    $(this.api().table().header()).prepend('<tr class="subcab" role="row"><td class="sorting_disabled cabeza" rowspan="1" colspan="3" style="cursor: pointer;"></td>'+cabeza+'<td class="sorting_disabled cabeza" rowspan="1" colspan="4" style="cursor: pointer;"></td></tr>');
                                }
                                $('#tableex_wrapper thead .subcab').on( 'click','th', function () 
                                {
                                    let filt = this.innerText;
                                    if(filt != 'TOTAL' && filt !='MARCA'&& filt !='PRODUCTOS'&& filt !='CLIENTES'
                                    &&filt !='Total'&& filt!='Cant'&&filt!='PARTI'&&filt!='PARTI.ACUM.'
                                    &&filt!='CLASE')
                                    {
                                        if(ctable.siguiente != undefined)
                                        {
                                            $('#tableex').DataTable().clear();
                                            $('#tableex').DataTable().destroy();
                                            ctable = createTable(ctable.siguiente,filt, ctable.xmp);
                                        }
                                    }
                                });
                            }
                            var prod = this.api().column(0).data();//
                            var tot = this.api().column("sumtot:name").data();
                            var part= this.api().column("particAcum:name").data();
                            var totF = [];
                            if(tot != undefined){
                                for (let i = 0; i < tot.length; i++) {
                                    totF.push(Math.round((parseFloat(tot[i].replace(/,/g, ''))+ Number.EPSILON) * 100) / 100);
                                }
                            }
                            paretoChart(prod, totF, part);
                            if ($('input#graficoxmarca').is(':checked')) {   
                                var tab = ParaOrdenar;
                                dataG=[];
                                max = 20;
                                if(xmp == "xProducto" && tab.length > max)
                                {                            
                                    for (let i = 0; i < max; i++) {
                                        dataG.push({name: tab[i].marca, value:parseFloat(tab[i].sumtot.replace(/,/g, ''))});
                                    }
                                }
                                else{
                                    for (let i = 0; i < tab.length; i++) {
                                        dataG.push({name: tab[i].marca, value:parseFloat(tab[i].sumtot.replace(/,/g, ''))});
                                    }
                                }
                            }                   

                            if(xmp == "xProducto"){

                                $(this.api().column("COST.U:name").footer()).html(addCommas(Math.round((total_cost+ Number.EPSILON) * 100) / 100));
                                $(this.api().column("CANT:name").footer()).html(parseFloat(this.api().column("CANT:name").data().sum()));
                                $(this.api().column("TOTAL:name").footer()).html(addCommas(Math.round((total+ Number.EPSILON) * 100) / 100));  
                                $(this.api().column("TOTAL.N:name").footer()).html(addCommas(Math.round((this.api().column("TOTAL.N:name").data().sum()+ Number.EPSILON) * 100) / 100));                        
                            }
                            else if(xmp == "xMarca")
                            {
                                $(this.api().column("CANT:name").footer()).html(parseFloat(this.api().column("CANT:name").data().sum()));
                                $(this.api().column("TOTAL:name").footer()).html(addCommas(Math.round((total+ Number.EPSILON) * 100) / 100));
                                $(this.api().column("TOTAL.N:name").footer()).html(addCommas(Math.round((this.api().column("TOTAL.N:name").data().sum()+ Number.EPSILON) * 100) / 100));
                            } 
                            else{
                                $(this.api().column("TOTAL:name").footer()).html(addCommas(Math.round((total+ Number.EPSILON) * 100) / 100));
                                $(this.api().column("TOTAL.N:name").footer()).html(addCommas(Math.round((this.api().column("TOTAL.N:name").data().sum()+ Number.EPSILON) * 100) / 100)); 
                            }     
                            if($("#pareto").is(':checked'))
                            {
                                $(this.api().column("M.UTIL:name").footer()).html(addCommas(Math.round((this.api().column("M.UTIL:name").data().sum()+ Number.EPSILON) * 100) / 100));           
                            }   
            
                            // Output the data for the visible rows to the browser's console
                            pie('resumen', dataG);
                            barras(BarraN, BarraV, BarraO);
                        }
                    });
                    
                    for (let i = 0; i < table.columns().data().length; i++) 
                    {
                        if(table.column(i).title()!='TOTAL')
                        {
                            $(table.column(i).header()).addClass('cabeza');
                            $(table.column(i).header()).css('cursor','pointer');
                        }
                    }

                    $('table thead tr').on( 'click', 'th', function () 
                    {
                        var filt = this.innerText;
                        if(filt == 'MARCA')
                        {
                            $('#tableex').DataTable().clear();
                            $('#tableex').DataTable().destroy();
                            ctable = createTable(ctable.estado,ctable.filtro, 'xProducto');
                            $("#graficoxmarcatext").html('Producto');
                        }
                        else if(filt == 'PRODUCTOS')
                        {
                            $('#tableex').DataTable().clear();
                            $('#tableex').DataTable().destroy();
                            ctable = createTable(ctable.estado,ctable.filtro, 'xCliente');
                            $("#graficoxmarcatext").html('Cliente');
                        }
                        else if(filt == 'CLIENTES')
                        {
                            $('#tableex').DataTable().clear();
                            $('#tableex').DataTable().destroy();
                            ctable = createTable(ctable.estado,ctable.filtro, 'xMarca');
                            $("#graficoxmarcatext").html('Marca');
                        }
                        else if(filt != 'TOTAL' && filt !='MARCA'&& filt !='PRODUCTOS'&& filt !='CLIENTES'
                                && filt!='CANT'&&filt != 'COST'&&filt!= 'PARTI'&&filt!='PARTI.ACUM.'
                                &&filt!='CLASE' && filt != 'PORC.M.UTIL' && filt != 'M.UTIL'
                                &&filt != 'COST.U'
                                )
                        {
                            if(ctable.siguiente != undefined)
                            {
                                $('#tableex').DataTable().clear();
                                $('#tableex').DataTable().destroy();
                                ctable = createTable(ctable.siguiente,filt, ctable.xmp);
                            }
                        }
                    } );
                    $('#tableex tbody').on( 'click', '.xMarca_prod', function () {
                        var xmpth = $('table thead tr th')[0].innerText;
                        if(xmpth=="MARCA")
                        {
                            var marcTT = ctable.table.row( $(this).parents('tr') ).data();
                            $('#tableex').DataTable().clear();
                            $('#tableex').DataTable().destroy();
                            ctable = createTable(ctable.estado, ctable.filtro, 'xProducto', marcTT.idmarca, ctable.client);
                        }  
                    } );
                    $('#tableex tbody').on( 'click', '.xCliente_prod', function () {
                        var xmpth = $('table thead tr th')[0].innerText;
                        if(xmpth=="CLIENTES")
                        {
                            var clienTT = ctable.table.row( $(this).parents('tr') ).data();
                            $('#tableex').DataTable().clear();
                            $('#tableex').DataTable().destroy();
                            ctable = createTable(ctable.estado, ctable.filtro, 'xMarca', ctable.marc, clienTT.idmarca);
                        }    
                    } );
                    return {table, estado, anterior, siguiente, filtro, usuarios, filtro_ant, marc, xmp, client};
                }
                var ctable = createTable("Segmento", undefined, "xMarca");
                var table = ctable.table;

                //cuando se completa evento ajax
                
                table.on( 'xhr', function () {
                    var json = table.ajax.json();
                } );
                //END cuando se completa evento ajax

                function actualizarTable(){
                    $('#tableex').DataTable().clear();
                    $('#tableex').DataTable().destroy();
                    ctable = createTable(ctable.estado,ctable.filtro, ctable.xmp);
                    //ctable = createTable(ctable.Segmento,ctable.grupo, ctable.usuario, undefined);
                }
                //UPDATE
                var actualizar = $("#actualizar").click(function(e){
                    actualizarTable();
                });
                
                $('#fini').on('change', function(){
                    actualizarTable();
                });
                $('#ffin').on('change', function(){
                    actualizarTable();
                });
                $('#graficoxmarca').on('click', function(){
                    actualizarTable();
                });
                $('#graficoxvendedor').on('click', function(){
                    actualizarTable();
                });
                //END UPDATE
                //BACK
                $("#atras").click(function (e) 
                {
                    if(ctable.marc != undefined){
                        $('#tableex').DataTable().clear();
                        $('#tableex').DataTable().destroy();
                        ctable = createTable(ctable.estado,ctable.filtro, ctable.xmp);
                    }
                    else{
                        if(ctable.anterior != undefined)
                        {
                            $('#tableex').DataTable().clear();
                            $('#tableex').DataTable().destroy();
                            ctable = createTable(ctable.anterior,ctable.filtro_ant,ctable.xmp);
                        } 
                        else
                        {
                            window.location.href ="{!!route('inicio')!!}";
                        }  
                    }
                                
                });
                //END BACK

                //TEST
                var actualizar = $("#test").on('change', function(e){
                    var est = $("#test").val();
                    $('#tableex').DataTable().clear();
                    $('#tableex').DataTable().destroy(); 
                    if(est == 'xSegmento'){
                        ctable = createTable('Segmento',undefined , ctable.xmp);
                        //$("#test").val('xGrupo');
                        //$("#test").html('xGrupo');
                    }
                    else if(est == 'xGrupo'){
                        
                        ctable = createTable('Grupo',undefined , ctable.xmp);
                        //$("#test").val('xUsuario');
                        //$("#test").html('xUsuario');
                    }
                    else if(est == 'xUsuario'){
                        ctable = createTable('Usuario',undefined , ctable.xmp);
                        //$("#test").val('xSegmento')
                        //$("#test").html('xSegmento');
                    }
                });
                //END TEST

                $("#paretoBy").on('change', function(e){
                    actualizarTable();
                });

                $("#margenBy").on('change', function(e){
                    actualizarTable();
                });

                function paretoChart(prod, tot,part){
                    var chartDom = document.getElementById('paretoGraf');
                    var myChart = echarts.init(chartDom);
                    var option;

                    option = {
                    tooltip: {
                            trigger: 'axis',
                            axisPointer: {
                            type: 'cross',
                            crossStyle: {
                                color: '#999'
                            }
                        }
                    },
                    grid: {
                        containLabel: true
                    },
                    toolbox: {
                        feature: {
                            saveAsImage: { show: true }
                        }
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: prod,
                            axisPointer: {
                                type: 'shadow'
                            }
                        }
                    ],
                    yAxis: [
                        {
                        type: 'value',
                        name: 'Ventas',
                        boundaryGap: [0, 0.0001],
                        },
                        {
                            type: 'value',
                            name: 'Procentaje',
                            interval: 10,
                            axisLabel: {
                                formatter: '{value} %'
                            }
                        }
                    ],
                    series: [
                        {
                        name: 'Ventas',
                        type: 'bar',
                        data: tot,
                        },
                        {
                        name: 'Procentaje',
                        type: 'line',
                        yAxisIndex: 1,
                        data: part,
                        markLine: {
                            data: 
                            [
                                { 
                                    yAxis: '80',
                                },
                                { 
                                    yAxis: '96',
                                },
                                { 
                                    yAxis: '100',
                                }
                            ],
                            symbol: 'none',
                            lineStyle: {
                                normal: {
                                    color: '#000',
                                    type: 'solid',
                                    width: 1
                                }
                            },
                            label:{
                                show:false,
                            }
                        },
                        },
                    ]
                    };
                    option && myChart.setOption(option);
                }
                $(".page-wrapper").removeClass("toggled"); 
            }   
            mixanalisys();    
        });
</script>
@endsection
