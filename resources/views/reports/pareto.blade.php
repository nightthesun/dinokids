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
</style>
@endsection
@section('content')
@include('layouts.sidebar', ['hide'=>'0']) 
<div class="container-fluid">
    <div class="row d-flex mt-2">
        <div class="offset-md-1 col-3">
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
        <div class="col-7">
            <table class="display cell-border compact" id="pareto_table" style="width:100%;font-size:0.75rem">
            </table>
        </div>
        <div class="col-5 px-4" style="height:85vh;">
            <div class="row" style="height:25%;overflow:auto;">
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
        <button type="button" class="btn btn-sm btn-outline-primary" id="test" value="xGrupo">
            xGrupo
        </button>
        <button type="button" class="btn btn-sm btn-outline-primary excel-export" name="gen" value="excel">
            Excel
        </button>
    </div>   
    <div class="controles-form-esq-der">
        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="far fa-chart-bar"></i>
        </button>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">GRAFICO</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="height:82vh;overflow:auto;">
                        <div id="barras" style="width:80vw;height:75vh">
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
        var notifier = new awn.default();
        $("#fini").on("change", function()
        {
            let myPromise = new Promise((resolve, reject) => {
                $("#pareto_table").DataTable().ajax.reload(null, false);
                $("#pareto_A").DataTable().ajax.reload(null, false);
                resolve();
            });
            notifier.async(myPromise, null,
            err => {
                notifier.error('Error', 'Error al actualizar');
            },
            'Cargando...'
            );
        });
        $("#ffin").on("change", function()
        {
            let myPromise = new Promise((resolve, reject) => {
                $("#pareto_table").DataTable().ajax.reload(null, false);
                $("#pareto_A").DataTable().ajax.reload(null, false);
                resolve();
            });
            notifier.async(myPromise, null,
            err => {
                notifier.error('Error', 'Error al actualizar');
            },
            'Cargando...'
            );
        });
        function CrearTabla(){
            $("#pareto_table").DataTable({
                searching: false,
                paging:false,
                info:false,
                ordering: false,
                dom: 'frtip',
                ajax: 
                    {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:"{{route('pareto.store')}}",
                        type: "post",
                        data: function (d) {
                            d.fini = $("#fini").val();
                            d.ffin = $("#ffin").val();
                            d.pareto = "pareto";
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
                columns: [
                    {data: 'prod', name: 'prod', title: 'PRODUCTO'},
                    {data: 'cant', name: 'cant', title: 'CANTIDAD', className: 'text-end'},
                    {data: 'totalf', name: 'totalf', title:'TOTAL', className: 'text-end'},
                    {data: 'partic', name: 'partic', title: 'PARTICIPACION', className: 'text-end'},
                    {data: 'particAcum', name: 'particAcum', title: 'PARTI. ACUMULADA', className: 'text-end'},
                    {data: 'clas', name: 'clas', title: 'CLASE', className: 'text-center'},
                    {data: 'Gtot', name: 'Gtot', visible: false},
                ],

                scrollY: "70vh",
                scrollX:true,
                scrollCollapse: true,
                drawCallback: function(settings){
                    var prod = this.api().column(0).data();
                    var tot = this.api().column("Gtot:name").data();
                    var part= this.api().column(4).data();
                    barras(prod, tot, part);
                }
            });
        }
        CrearTabla();

        var barras= function Gbarras(prod, tot,part)
        {
            var chartDom = document.getElementById('barras');
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
        $("#pareto_A").DataTable({
            searching: false,
            paging:false,
            info:false,
            ordering: false,
            dom: 'frtip',
            ajax: 
                {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{route('pareto.store')}}",
                    type: "post",
                    data: function (d) {
                        d.fini = $("#fini").val();
                        d.ffin = $("#ffin").val();
                        d.pareto = "analisis";
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
            columns: [          
                {data: 'clas', name: 'clas', title: 'CLASE'},
                {data: 'ene', name: 'ene', title: 'N'},
                {data: 'particN', name: 'particN', title: 'PARTI. N'},
                {data: 'Ventas', name: 'Ventas', title: 'VENTAS'},
                {data: 'particVentas', name: 'particVentas', title: 'PARTI. VENTAS'},
            ],
            scrollY: "70vh",
            scrollX:true,
            scrollCollapse: true,
        });
        $(".page-wrapper").removeClass("toggled"); 
    });
</script>
@endsection
