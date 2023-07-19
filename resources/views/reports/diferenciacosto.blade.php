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
    .bg-ingreso
    {
        background-color: rgba(174, 255, 208, 0.3) !important;
    }
    .bg-egreso
    {
        background-color: rgba(111, 178, 255, 0.3) !important;
    }
</style>
@endsection
@section('content')
@include('layouts.sidebar', ['hide'=>'0']) 
<div class="container-fluid">
    <div class="row d-flex mt-1">
        <div class="col-10 offset-md-1 text-end">
            <div class="mb-2 row d-flex justify-content-start">
                <!--label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm text-right">Desde:</label>
                <div class="col-sm-2">
                <input id="fini" type="date" class="form-control form-control-sm " name="fini" value ="{{date('Y-m-d')}}">
                </div>
                <label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm text-right">Hasta:</label>
                <div class="col-sm-2">
                <input id="ffin" type="date" class="form-control form-control-sm " name="ffin" value ="{{date('Y-m-d')}}">
                </div-->
                <label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm text-right">Almacen:</label>
                <div class="col-sm-3">
                    <select name="alm" id="alm" class="form-select form-select-sm" >
                        <!--option value="0">Todos</option-->
                        @foreach ($almacenes as $alm)
                            <option value="{{$alm->id}}" @if($alm->id == '47') selected @endif>{{$alm->alm}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <input type="text" id="buscar" class="form-control form-control-sm" placeholder="Buscar...">
                </div>
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <table class="cell-border compact hover" id="tableex" style="width:100%;font-size:0.9rem">
            </table>
        </div>
        <div class="col-8">
            <div class="text-center w-100 border-bottom mt-3"><h5 id="title_prod">Producto</h5></div>
            <table class="cell-border compact" id="detalle_costo" style="width:100%; font-size:0.8rem;">
            </table>
        </div>
    </div>
</div>
@endsection
@section('mis_scripts')
<script>
    $(document).ready(function() 
    {   
        var createTable = function createDataTable(){
            var alm = $('#alm').val();
            var table = $('#tableex').DataTable({
                paging:false,     
                searching:true, 
                dom: "ltpir", 
                ajax: 
                {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{route('difereciacosto.products')}}",
                    type: "post",
                    dataType: 'json',
                    data:{alm:alm}
                    /*success: function (data) {
                        console.log(data);
                    },
                    error: function (data) {
                        console.log(data);
                    }*/
                },
                serverSide: true,
                processing: true, 
                columns:[
                    {data:'Prod', title:'Producto'},
                    {data:'costo', title:'Costo', className: 'dt-body-right'},
                    //{data:'dif', title:'Diferencia'},
                    {data:'difmax', title:'Dif', className: 'dt-body-right'},
                    {data:'ingresos', title:'Ing', className: 'dt-body-right text-success'},
                    {data:'salidas', title:'Sal', className: 'dt-body-right text-danger'},
                ], 
                columnDefs: [
                    {
                        "targets": 0,
                        "render": function ( data, type, row, meta ) 
                        {
                            var link = '<a class="producto" id="'+data+'" style="cursor:pointer;">'+data+'</a>'
                            return link;
                        }
                    },
                ], 
                order: [[ 2, "desc" ]],
                scrollY: "80vh",
                scrollX:true,
                scrollCollapse: true,
                drawCallback: function( settings ) {
                    //$('#title_prod').text(prim.Prod);
                    if(!$.fn.DataTable.isDataTable( '#detalle_costo')){
                        let  tabla = this.api(); 
                        var prim = this.api().row(0).data();
                        detalleProduct(prim.Prod);
                    }            
                },
            });
        }  
        var detalleProduct = function detalleTableProduct(prod){
            var alm = $('#alm').val();
            if($.fn.DataTable.isDataTable( '#detalle_costo' ))
            {
                $('#detalle_costo').DataTable().clear();
                $('#detalle_costo').DataTable().destroy();
                //$("#detalle_costo thead").remove();
                //$('#detalle_costo tfoot').remove();
            }
            
            var table2 = $('#detalle_costo').DataTable({
                paging:false,     
                searching:false,    
                order: false, 
                bFilter: false,   
                ajax: 
                {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{route('difereciacosto.store')}}",
                    type: "post",
                    dataType: 'json',
                    data:{prod:prod, alm:alm},
                    /*success: function (data) {
                        console.log(data);
                    },
                    error: function (data) {
                        console.log(data);
                    }*/
                },
                serverSide: true,
                processing: true, 
                columns:[
                    {data:'_Ntra', title:'NroTrans'},
                    {data:'_Ftra', title:'Fecha'},
                    {data:'_Canb', title:'Cant', className: 'dt-body-right'},
                    {data:'_CantAcum', title:'Cant Acum', className: 'dt-body-right'},
                    {data:'_CostUnit', title:'Cost Unit', className: 'dt-body-right'},
                    {data:'_CostAvg', title:'Cost Prom', className: 'dt-body-right'},   
                    {data:'_CTmi', title:'Costo Val', className: 'dt-body-right'},                    
                    {data:'_CostAcum', title:'Costo Acum', className: 'dt-body-right'}, 
                    {data:'_Diferencia', title:'Dif', className: 'dt-body-right'},                    
                    {data:'_Ntri', title:'Trans Ini', className: 'dt-body-right'},
                    {data:'_TmovN', title:'Tipo de Mov', className: 'dt-body-center'},                  
                ], 
                scrollY: "65vh",
                scrollX:true,
                scrollCollapse: true,
                createdRow: function( row, data, dataIndex ) {
                    if ( data.Ttra == 1 ) {
                        $(row).addClass( 'bg-ingreso' );
                    }
                    else{
                        $(row).addClass( 'bg-egreso' );
                    }
                    //console.log(row.getElementsByTagName('td')[7]);
                    if (data._Diferencia == 0 ) {
                        let td = $(this).DataTable().cell(dataIndex,8).node();
                        $(td).addClass('text-success');
                    }
                    else{
                        let td = $(this).DataTable().cell(dataIndex,8).node();
                        $(td).addClass('text-danger');
                    }
                },
                drawCallback: function( settings ) {
                    var prod = this.api().ajax.json().producto.Produ;
                    var desc = this.api().ajax.json().producto.ProdNomb;
                    $('#title_prod').text(prod + ' - ' + desc);                    
                },
            });
            //var marcTT = ctable.table.row( $(this).parents('tr') ).data();
            //$('#tableex').DataTable().clear();
            //$('#tableex').DataTable().destroy();
            //ctable = createTable(ctable.estado, ctable.filtro, 'xProducto', marcTT.idmarca); 
        }
        createTable();

        $('#alm').on ('change', function () {
            $('#tableex').DataTable().clear();
            $('#tableex').DataTable().destroy();
            $('#detalle_costo').DataTable().clear();
            $('#detalle_costo').DataTable().destroy();
            createTable();
        });
        $('#tableex tbody').on( 'click', '.producto', function () {
            var prod = $(this).attr('id');
            $('#title_prod').text(prod);
            detalleProduct(prod);            
        } );
        $('#buscar').on( 'keyup', function () {
            $('#tableex').DataTable().search( this.value ).draw();
        } );
        $(".page-wrapper").removeClass("toggled");        
    });
</script>
@endsection
