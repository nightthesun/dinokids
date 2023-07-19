<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteVtsExport;

class ReporteVtsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $meses = 
        ['01'=>"Enero",'02'=>"Febrero",
        '03'=>"Marzo",'04'=>"Abril",
        '05'=>"Mayo",'06'=>"Junio",
        '07'=>"Julio", '08'=>"Agosto",
        '09'=>"Septiembre", '10'=>"Octubre",
        '11'=>"Noviembre", '12'=>"Diciembre"];
        $fini=strtotime("01-01-2021");
        $ffin=strtotime(date("d-m-Y"));
        $grupos=[
            ['id'=> 'G0', 'name'=>'SIN GRUPO', 'usrs'=>[]],
            ['id'=> 'C1', 'name'=>'IDRA BALLIVIAN', 'usrs'=>[4], 'loc'=>3, 'tipo'=>'PDV', 'const' => true],
            ['id'=> 'C2', 'name'=>'IDRA HANDAL', 'usrs'=>[4], 'loc'=>4 , 'tipo'=>'PDV', 'const' => true],
            ['id'=> 'C3', 'name'=>'IDRA CALACOTO', 'usrs'=>[4], 'loc'=> 5, 'tipo'=>'PDV', 'const' => true],
            ['id'=> 'C4', 'name'=>'IDRA MARISCAL', 'usrs'=>[4], 'loc'=>6, 'tipo'=>'PDV', 'const' => true],
            ['id'=> 'C5', 'name'=>'IDRA SANMIGUEL', 'usrs'=>[4], 'loc'=>12, 'tipo'=>'PDV', 'const' => true],
            ['id'=> 'L1', 'name'=>'REGIONAL SUCRE', 'usrs'=>[63], 'alm'=>57, 'tipo'=>'MAYO', 'const' => true],
            ['id'=> 'L2', 'name'=>'REGIONAL POTOSI', 'usrs'=>[63], 'alm'=>58, 'tipo'=>'MAYO', 'const' => true],
            ['id'=> 'L3', 'name'=>'REGIONAL TARIJA', 'usrs'=>[64], 'alm'=>59, 'tipo'=>'MAYO', 'const' => true],
            ['id'=> 'L4', 'name'=>'REGIONAL ORURO', 'usrs'=>[64], 'alm'=>60, 'tipo'=>'MAYO', 'const' => true],
            ['id'=> 'L5', 'name'=>'REGIONAL COCHABAMBA', 'usrs'=>[64], 'loc'=>61, 'tipo'=>'MAYO', 'const' => true],
            ['id'=> 'G1','name'=>'CASA MATRIZ VTS', 'usrs'=>[46], 'tipo'=>'INS_SUC'],
            ['id'=> 'G2','name'=>'CASA MATRIZ PDV', 'usrs'=>[49,22,41,3,5,6,9,65,4,23,24,68,56,7,5,60], 'tipo'=>'PDV'],
            ['id'=> 'G3','name'=>'CALACOTO VTS', 'usrs'=>[29,57,74], 'tipo'=>'INS_SUC'],
            ['id'=> 'G4', 'name'=>'CALACOTO PDV', 'usrs'=>[52,32,43], 'tipo'=>'PDV'],
            ['id'=> 'G5', 'name'=>'HANDAL VTS', 'usrs'=>[28], 'tipo'=>'INS_SUC'],
            ['id'=> 'G6', 'name'=>'HANDAL PDV', 'usrs'=>[50,26,42,69], 'tipo'=>'PDV'],
            ['id'=> 'G7', 'name'=>'MARISCAL VTS', 'usrs'=>[37], 'tipo'=>'INS_SUC'],
            ['id'=> 'G8', 'name'=>'MARISCAL PDV', 'usrs'=>[51,44,38,67], 'tipo'=>'PDV'],
            ['id'=> 'G9', 'name'=>'INGAVI VTS', 'usrs'=>[], 'tipo'=>'INS_SUC'],
            ['id'=> 'G10', 'name'=>'INGAVI PDV', 'usrs'=>[], 'tipo'=>'PDV'],
            ['id'=> 'G11', 'name'=>'INSTITUCIONAL 2', 'usrs'=>[17], 'tipo'=>'INS'],
            ['id'=> 'G12', 'name'=>'INSTITUCIONAL 3', 'usrs'=>[16], 'tipo'=>'INS'],
            ['id'=> 'G13', 'name'=>'CONTRATOS', 'usrs'=>[62], 'tipo'=>'INS'],
            ['id'=> 'G14', 'name'=>'FERIAS PDV', 'usrs'=>[61,80], 'tipo'=>'PDV'],
            ['id'=> 'G15', 'name'=>'MAYORISTAS 1', 'usrs'=>[19], 'tipo'=>'MAYO'], 
            ['id'=> 'G16', 'name'=>'MAYORISTAS 2', 'usrs'=>[18], 'tipo'=>'MAYO'],
            ['id'=> 'G17', 'name'=>'MAYORISTAS 3', 'usrs'=>[20], 'tipo'=>'MAYO'],
            ['id'=> 'G18', 'name'=>'DISTRIBUIDOR 1', 'usrs'=>[21], 'tipo'=>'MAYO'],
            ['id'=> 'G19', 'name'=>'MAYORISTAS 5', 'usrs'=>[55], 'tipo'=>'MAYO'],
            ['id'=> 'G20', 'name'=>'SANTA CRUZ VTS', 'usrs'=>[39,40], 'tipo'=>'MAYO'], 
            ['id'=> 'G21', 'name'=>'VENTA MOVIL 1', 'usrs'=>[58], 'tipo'=>'MAYO'],
            ['id'=> 'G22', 'name'=>'SANMIGUEL PDV', 'usrs'=>[76,77,78], 'tipo'=>'PDV'],
        
        ];
        $gruFilt = ''; $gruFiltId = '';
        foreach ($grupos as $k => $v) {
            if($v['usrs'] && !isset($v['const'])){
                $gruFilt .= "WHEN adusrCusr IN (".implode(',',$v['usrs']).") AND  THEN '".$v['name']."'\n";
                $gruFiltId .= "WHEN adusrCusr IN (".implode(',',$v['usrs']).") THEN '".$v['id']."'\n";
            }
        }
        $qusersGroup = "WITH users AS
        (
            SELECT
            CASE
            ".$gruFiltId."
            ELSE 'G0'
            END as idG,   
            adusrCusr, adusrNomb
            FROM bd_admOlimpia.dbo.adusr
            WHERE adusrMdel = 0 AND 
            (adusrCusr IN(
                SELECT vtvtaCusr
                FROM vtVta WHERE vtvtaMdel=0
                GROUP BY vtvtaCusr))
        )
        SELECT * FROM users ORDER BY idG ASC";
        $usersGroup = DB::connection('sqlsrv')->select(DB::raw($qusersGroup));
        $userGroup = collect($usersGroup)->groupBy('idG');

        foreach ($grupos as $k => $v) {      
            if(isset($userGroup[$v['id']]))
            {
                $grupos[$k]['udata'] = $userGroup[$v['id']];
            }
        }
        return view('reports.reportevts', compact('meses', 'fini', 'ffin', 'userGroup','grupos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mes = $request->mes;
        if($request->rango == 'true'){
            $fini = date('d-m-Y',strtotime($request->mfini));
            $ffin = date('d-m-Y',strtotime($request->mffin));
        }
        else{
            $fini = date('01-'.$mes);
            $ffin = date("t-m-Y", strtotime($fini));
        }
        $grupos  = json_decode($request->grupos);

        //TITULOS
        $titulos = [
            'MARCA',
            'CODIGO',
            'DESCRIPCION',
            '',
            'COSTO UNITARIO',
            'PRECIO DE VENTA PDV',
            'PRECIO DE VENTA PDV(IVA)',
            '% Margen Bruto',
        ];

        if(strtotime($fini) < strtotime('01-03-2021') || strtotime($ffin) < strtotime('01-03-2021')){
            $db = env('DB_DATABASE');
            $time = strtotime($fini);
            do {
                $month = date('n', $time);
                $m[] =  $month;
                $time = strtotime('+1 month', $time);
            } 
            while ($time <= strtotime($ffin) && $month < 2);
            $qprods_o = 
            "SELECT * 
            FROM OPENQUERY(OASSERVER, '
            SELECT  
            marca as `categoria`,
            IFNULL(d_cod,prod) as codigo,
            IFNULL(d_desc,descrip) as descripcion
            FROM ".$db.".odoo_prods
            LEFT JOIN ".$db.".dual_odoo_prods ON o_cod = prod
            ') as prods";
        }

        if(strtotime($fini) < strtotime('01-03-2021') && strtotime($ffin) < strtotime('01-03-2021')){
            $productos = DB::connection('DUALBIZ_SERVER')->select(DB::raw($qprods_o)); 
            $qstock_o = 
            "SELECT * 
            FROM OPENQUERY(OASSERVER, '
                SELECT Codigo, Descripcion, UM,
                SUM(stock) as Cantidad,
                0 as ValorInv
                FROM(
                SELECT 
                    cod as Codigo, descrip as Descripcion, 
                    ''UNI''as UM, stock
                    FROM ".$db.".odoo_stocks 
                    LEFT JOIN ".$db.".odoo_prods ON odoo_prods.prod = odoo_stocks.cod
                    WHERE mes IN (".implode(",",$m).")
                ) as st
                GROUP BY Codigo, Descripcion, UM
            ') as stk";
            $stock = DB::connection('DUALBIZ_SERVER')->select(DB::raw($qstock_o));
            foreach ($grupos as $ogk => $og) {
                $qpestañas_o = 
                "SELECT * 
                FROM OPENQUERY(OASSERVER, '
                    SELECT 
                    IFNULL(d_cod, prod) as prod, mon, 
                    SUM(cantidad) as cantidad, 
                    SUM(precioventa) as precioventa, 
                    SUM(descuento) as descuento, 
                    SUM(total) as total
                    FROM (
                        SELECT d_cod, cod as prod,
                        ''BS'' as mon, cantidad, precioventa, descuento, total, grupo
                        FROM ".$db.".odoo_rep_vts
                        LEFT JOIN ".$db.".dual_odoo_prods ON o_cod = cod
                        WHERE grupo = ''".$og->name."''
                        AND mes IN (".implode(",",$m).")
                    ) as vent
                    GROUP BY grupo, prod, mon
                    ORDER BY grupo
                ') as pest";
                $result = DB::connection('DUALBIZ_SERVER')->select(DB::raw($qpestañas_o));

                return dd($result);
                if($result)
                {
                    $reporte[$og->name] = $result;
                    $g[] = $og;
                }
            } 
            //INI
            $grupoxtipo = collect($g)->sortBy('tipo')->groupBy('tipo');
            foreach ($g as $key => $value) {
                $vts_f[]= "[".$value->name."_can], [".$value->name."_tot]";
                $TOT[] = "ISNULL([".$value->name."_tot],0)";
                $CAN[] = "ISNULL([".$value->name."_can],0)";
                $vts_grupos[] = "ISNULL([".$value->name."_can], 0) as [".$value->name."_can], 
                ISNULL([".$value->name."_tot]/NULLIF([".$value->name."_can],0), 0) as [".$value->name."_precuni],
                ISNULL([".$value->name."_tot], 0) as [".$value->name."_tot]";               
                $grupos_head[] = [$value->name, 'tipo'=>'grupo_vts'];  
            }
            foreach ($grupoxtipo as $key => $value) {
                $value = $value->toArray();
                $tipo_sum[$key."_tot"] = "(ISNULL([".implode("_tot],0)+ISNULL([", array_column($value, 'name')). "_tot],0)) as ". $key."_tot";
                $tipo_sum[$key."_can"] = "(ISNULL([".implode("_can],0)+ISNULL([", array_column($value, 'name')). "_can],0)) as ". $key."_can";

                $valorventasxtipo[$key]= $key."_tot"; 
                $cantidadesxtipo[$key]= $key."_can"; 
            }
            foreach ($cantidadesxtipo as $key => $value) {
                $costoventaxtipo[] = "(ISNULL(".$value.",0)*costo) as ".$value."_costo";
            }
            foreach ($valorventasxtipo as $key => $value) {
                $margenutilidadxtipo[] = "((ISNULL(".$value.",0)*0.87)/(NULLIF(cantidad*costo,0))) as ".$value."margenutilidad";
                $margenutilidadxtipo_proc[] = "((0.87)/(NULLIF(cantidad*costo,0))) as ".$value."margenutilidad_porc";
            }
            $qPYC = 
            "SELECT * 
            FROM OPENQUERY(OASSERVER, '
            SELECT
            categ as categoria,
            cod as codigo, 
            descrip as descripcion, 
            '''' as UM,
            precio_orig as PrecioOrigen,
            moneda_orig as MonedaPO,
            '''' as CostoUltComp,
            '''' as MonedaCUC,
            precio_costo as CostoPromedio,
            moneda_Costo as MonedaCP,
            precio_pub as pvp,
            f_ult_ingreso as FechaUltIngreso,
            cant_ult_ingreso as CantUltIngreso,        
            '''' as UMUltIngreso, 
            ref_docum as NroTransInicial,
            '''' as Proveedor,       
            f_ult_venta as FechaUlVenta,
            '''' as TipoCompra
            FROM ".$db.".odoo_pycs
            WHERE mes = ".$m[0]."
            ') as pyc";
            $pyc = DB::connection('DUALBIZ_SERVER')->select(DB::raw($qPYC));

            $qvts = 
            "WITH gru_prod AS 
            (
                SELECT 
                grupo,
                prod, 
                SUM(cantidad) as cantidad, 
                SUM(total) as total
                FROM OPENQUERY(OASSERVER, '
                    SELECT IFNULL(d_cod, cod) as prod,
                    ''BS'' as mon, cantidad, precioventa, descuento, total, grupo
                    FROM ".$db.".odoo_rep_vts
                    LEFT JOIN ".$db.".dual_odoo_prods ON o_cod = cod
                    WHERE mes = ".implode(",",$m)."
                ') as vent
                GROUP BY grupo, prod, mon
            ), vent AS 
            (
                SELECT prod, cant_totl, val
                FROM gru_prod
                CROSS APPLY (VALUES(grupo+'_can', cantidad), (grupo+'_tot', total)) x (cant_totl, val)
            ), ventpiv AS
            (
                SELECT *,
                ".implode(",",$tipo_sum).",
                (".implode("+",$TOT).") as total,
                (".implode("+",$CAN).") as cantidad
                FROM vent
                PIVOT
                (
                SUM(val) 
                FOR cant_totl IN (".implode(",",$vts_f).")
                ) AS p
            )
            SELECT marca, inpro.prod, descrip, 
            0.87 AS [0.87],
            CONVERT(VARCHAR, cast(ISNULL(pyc.costo,0) as money),1) as [costo],
            CONVERT(VARCHAR, cast(ISNULL(pyc.precio,0) as money),1) as [precio],
            CONVERT(VARCHAR, cast(ISNULL((pyc.precio * 0.87),0) as money),1) as [precioIVA],
            CONVERT(VARCHAR, cast(ISNULL(((((pyc.precio * 0.87)-pyc.Costo)/NULLIF(pyc.precio,0))*100),0) as money),1) as [margenBruto],
            ([PDV_tot])/NULLIF([PDV_can],0) as precioVentaPromPDV,
            (0.87-([costo]/(NULLIF(([PDV_tot])/NULLIF([PDV_can],0),0))))*100 as margenbrutoPDV,
            ([INS_tot]+[INS_SUC_tot])/(NULLIF(([INS_can]+[INS_SUC_can]),0)) as precioVentaPromINS,
            (0.87-([costo]/(NULLIF(([INS_tot]+[INS_SUC_tot])/NULLIF([INS_can]+[INS_SUC_can],0),0))))*100 as margenbrutoINS,
            ([MAYO_tot])/(NULLIF([MAYO_can],0)) as precioVentaPromMAYO,
            (0.87-([costo]/(NULLIF(([MAYO_tot])/NULLIF([MAYO_can],0),0))))*100 as margenbrutoMAYO,
            ".implode(",",$vts_grupos).",
            ".implode(",",$cantidadesxtipo).",
            cantidad,
            StockCant,
            ".implode(",",$valorventasxtipo).",
            total,
            StockCant*costo as StockValorado,
            ".implode(",",$costoventaxtipo).",
            (cantidad*costo) as 'cantidadxcosto',
            ".implode(",",$margenutilidadxtipo).",
            (total*0.87)/(NULLIF(cantidad*costo,0)) as 'total_margen',
            ".implode(",",$margenutilidadxtipo_proc).",
            0.87/(NULLIF(cantidad*costo,0)) as 'total_margen_proc'
            FROM ventpiv
            LEFT JOIN 
            (
                SELECT *
                FROM OPENQUERY
                (OASSERVER, 
                'SELECT IFNULL(d_cod, prod) as prod, marca, IFNULL(d_desc, descrip) as descrip 
                FROM ".$db.".odoo_prods
                LEFT JOIN ".$db.".dual_odoo_prods ON o_cod = prod
                ') as odoo_prods
            ) as inpro
            ON inpro.prod = ventpiv.prod
            LEFT JOIN
            (
                SELECT prod, costo, precio 
                FROM OPENQUERY
                (OASSERVER, 
                    'SELECT IFNULL(d_cod, cod) as prod, 
                    MAX(precio_costo) as costo, MAX(precio_pub) as precio
                    FROM ".$db.".odoo_pycs
                    LEFT JOIN ".$db.".dual_odoo_prods ON o_cod = cod
                    GROUP BY d_cod, cod
                ') as odoo_pycs
            ) as pyc
            ON pyc.prod = ventpiv.prod
            LEFT JOIN
            (
                SELECT 
                StockCod,  
                StockCant
                FROM OPENQUERY(OASSERVER, '
                    SELECT IFNULL(d_cod, cod) as StockCod, 
                    MAX(stock) as StockCant
                    FROM ".$db.".odoo_stocks 
                    LEFT JOIN ".$db.".dual_odoo_prods ON o_cod = odoo_stocks.cod
                    WHERE mes = ".$m[0]."
                    GROUP BY d_cod, cod
                ') as stk
            ) as stock
            ON stock.StockCod = inpro.prod
            ORDER BY prod";
            return dd($qvts);
            $ini = DB::connection('DUALBIZ_SERVER')->select(DB::raw($qvts));
        }
        else if(strtotime($fini) >= strtotime('01-03-2021') && strtotime($ffin) >= strtotime('01-03-2021')){
            if(strtotime($fini) <= strtotime('2021-03-01'))
            {
                $ant_fini = date('3-3-2021');
            }
            else{
                $ant_fini = date('d-m-Y', strtotime($fini .'-1 day'));
            }
            $qprods = 
            "SELECT  
            maconNomb as categoria,
            inproCpro as codigo,
            inproNomb as descripcion
            FROM inpro
            LEFT JOIN macon ON inproMarc = CAST(MaconCcon as varchar)+ '|' + CAST(MaconItem as varchar)
            WHERE inproMdel = 0        
            "; 
            $productos = DB::connection('sqlsrv')->select(DB::raw($qprods));
            $qstock = 
            "SELECT * FROM(
                SELECT 
                inproCpro as Codigo, 
                inproNomb as Descripcion, 
                SUM(intrdCanb) as Cantidad, inumeAbre as UM, 
                CAST(ROUND(SUM(intrdCTmi),2) as decimal(32,2)) as ValorInv
                FROM intrd 
                JOIN intra ON intraNtra = intrdNtra 
                JOIN inpro ON inproCpro = intrdCpro AND inproMdel = 0
                JOIN inume ON inumeCume = intrdUmbs AND inumeMdel = 0
                WHERE intrdMdel = 0 AND intraFtra <= '".$ant_fini."'
                GROUP BY inproCpro, inproNomb, inumeAbre--, intraCalm
            ) as stock
            ";
            $stock = DB::connection('sqlsrv')->select(DB::raw($qstock));
            foreach ($grupos as $dg) {
                if(isset($dg->tipo) && $dg->usrs){
                    $loc = '';$alm='';
                    if(isset($dg->loc)){
                        $loc = "AND vtvtaCloc = '".$dg->loc."'";
                    }
                    if(isset($dg->alm)){
                        $alm = "AND vtvtaCalm = '".$dg->alm."'";
                    } 
                    $qpestañas = 
                    "SELECT prod, mon, CAST(ROUND(SUM(cantidad), 2) as decimal(36,2)) as cantidad, 
                    CAST(ROUND(SUM(precioventa), 2) as decimal(36,2)) as precioventa, 
                    CAST(ROUND(SUM(descuento), 2) as decimal(36,2)) as descuento, 
                    CAST(ROUND(SUM(total), 2) as decimal(36,2)) as total
                    FROM(
                        SELECT
                        '".$dg->name."' as grupo, vtvtdCpro as prod,
                        admonAbrv as mon, vtvtdCant as 'cantidad',
                        vtvtdImpT as 'precioventa', vtvtdDesT as 'descuento',
                        vtvtdImpT - vtvtdDesT as total
                        FROM vtVtd 
                        LEFT JOIN inpro ON inproCpro = vtvtdCpro
                        JOIN vtVta ON vtvtaNtra = vtvtdNtra AND vtvtaMdel = 0
                        JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra
                        WHERE  vtvtdMdel = 0 
                        AND vtvtaCusr IN (".implode(",",$dg->usrs).") ".$loc.$alm."
                        AND (vtvtaFtra BETWEEN '".$fini."' AND '".$ffin."') 
                    ) as vent
                    WHERE grupo = '".$dg->name."'
                    GROUP BY grupo, prod, mon
                    ORDER BY grupo";
                    $result = DB::connection('sqlsrv')->select(DB::raw($qpestañas));
                    if($result)
                    {
                        $reporte[$dg->name] = $result;
                        $g[] = $dg;
                    }
                }
            }
            foreach ($grupos as $key => $value){
                if(isset($value->tipo) && $value->usrs){
                    $loc = ''; $alm = '';
                    if(isset($value->loc)){
                        $loc = "AND vtvtaCloc = '".$value->loc."'";
                    }
                    if(isset($value->alm)){
                        $alm = "AND vtvtaCalm = '".$value->alm."'";
                    }
                    $grupos_T[] = "WHEN vtvtaCusr IN (".implode(",",$value->usrs).") ".$loc." ".$alm." THEN '".$value->name."'"; 
                    $grupos_head[] = [$value->name, 'tipo'=>'grupo_vts'];   
                    $vts_grupos[] = "ISNULL([".$value->name."_can], 0) as [".$value->name."_can], 
                    ISNULL([".$value->name."_tot]/NULLIF([".$value->name."_can],0), 0) as [".$value->name."_precuni],
                    ISNULL([".$value->name."_tot], 0) as [".$value->name."_tot]";
                    $vts_f[]= "[".$value->name."_can], [".$value->name."_tot]";
                    $TOT[] = "ISNULL([".$value->name."_tot],0)";
                    $CAN[] = "ISNULL([".$value->name."_can],0)";

                    if(isset($value->tipo))
                    {
                        if(!isset($grupoxtipo[$value->tipo])){
                            $grupoxtipo[$value->tipo]=
                                [
                                    $value->name
                                ];
                        }
                        else{
                            array_push(
                                $grupoxtipo[$value->tipo], 
                                $value->name
                            );
                        }   
                    }          
                } 
            }
            $qPYC = 
            "SELECT
            marc.maconNomb as categoria,
            ISNULL(intrd.intrdCpro, inpro.inproCpro) as codigo, 
            inpro.inproNomb as descripcion, 
            umpro.inumeAbre as 'UM',
            ISNULL(ISNULL(compr.cos, intrd.intrdCTmi/intrd.intrdCanb),0) as 'PrecioOrigen',
            ISNULL(compr.admonAbrv, Minv.admonAbrv ) as 'MonedaPO',
            ISNULL(intrd.intrdCTmi/intrd.intrdCanb,0) as 'CostoUltComp',
            Minv.admonAbrv as 'MonedaCUC',
            ISNULL(cosprom.promcos,0) as 'CostoPromedio',
            Mpromcos.admonAbrv as 'MonedaCP',
            REPLACE(pvp.vtLidPrco,',', '.') as pvp,
            CONVERT(varchar, cym.intraFtra, 103) as 'FechaUltIngreso',
            REPLACE(intrd.intrdCanb,',', '.') as 'CantUltIngreso',        
            inume.inumeAbre as 'UMUltIngreso', 
            cym.intraNtrI as 'NroTransInicial',
            compr.crentNomb as 'Proveedor',       
            CONVERT(varchar, ultv.intraFtra,103) as 'FechaUlVenta',
            (CASE compr.cmOcmCimp 
            WHEN 1 THEN 'IMPORTACION'
            WHEN 0 THEN 'COMPRA LOCAL' END
            ) AS 'TipoCompra'        
            FROM intra as cym  
            --DETALLE DE MOV
            JOIN intrd ON intraNtra = intrdNtra AND intrdMdel = 0
            --Costo Ult Importacion/Compra
            JOIN 
            (
                SELECT  
                numT, cmOcdNtra,cmOcd.cmOcdCpro, cmOcdMtra,  cmOcdCanC, admonAbrv, cmOcmCimp,
                REPLACE(cmOcdCosO/cmOcdCanC,',', '.') as 'cos', cmOcdCumc, inumeAbre, crentNomb
                from cmOcd 
                JOIN cmOcm as cm ON cmOcdNtra = cmOcmNtra AND cmOcmMdel=0  
                RIGHT JOIN
                (
                    select cmOcdCpro, MAX(cmOcdNtra) as Ntrans, MAX(numT) as numT	
                    FROM 
                    (
                        select ISNULL(cmRe.cmrecNtra, cmOcd.cmOcdNtra) as NumT, cmOcd.*, cmOcm.*, ISNULL(cmRe.cmrecFtra, cmocmFocm ) as Fmov, crEnt.crentNomb
                            FROM cmOcm
                            JOIN cmOcd ON cmOcmNtra = cmOcdNtra
                            LEFT JOIN 
                            (
                            SELECT *
                                FROM cmRec 
                                JOIN cmRed ON cmrecNtra = cmredNtra
                            ) as cmRe
                            ON cmOcdNtra = cmRe.cmrecNocm AND cmOcdCpro = cmRedCpro
                            LEFT JOIN crEnt ON crentCent =  cmOcmCprv
                        WHERE (cmocmTcmp = 1 OR cmrecNtra IS NOT NULL ) AND cmocmMdel = 0
                        --AND crEnt.crentNomb	LIKE '%Milcar%'
                    ) as comp
                    WHERE 
                    --comp.Fmov >= '".$fini."' AND 
                    comp.Fmov <= '".$ffin."'
                    --AND comp.cmOcmCimp = 0 -- ES COMPRA LOCAL
                    --AND comp.cmocmCprv <> 2657
                    GROUP BY cmOcdCpro 	
                ) as compr
                ON compr.cmOcdCpro = cmOcd.cmOcdCpro AND Ntrans = cmOcdNtra
                --Moneda
                LEFT JOIN bd_admOlimpia.dbo.admon ON admonCmon =cmOcd.cmOcdMtra
                --Unidades Medida
                LEFT JOIN inume ON inume.inumeCume = cmOcd.cmOcdCumc
                --Proveedores
                LEFT JOIN crEnt ON crentCent =  cmOcmCprv
            ) as compr
            ON compr.cmOcdCpro = intrd.intrdCpro AND compr.numT = cym.intraNtrI
                    
            --Productos
                    
            RIGHT JOIN inpro ON intrd.intrdCpro = inproCpro AND inproMdel = 0
                    
            LEFT JOIN inume as umpro ON umpro.inumeCume = inpro.inproCumb
            --MARCA
            LEFT JOIN macon as marc ON inproMarc = CAST(MaconCcon as varchar)+ '|' + CAST(MaconItem as varchar) AND maconCcon = 113
            --TIPO DE MOV 
            LEFT JOIN matmo on maTmoCmod=3 and maTmoMdel=0 and maTmoItem= cym.intraTmov  
            --Moneda
            LEFT JOIN bd_admOlimpia.dbo.admon as Minv ON intrd.intrdMinv = admonCmon 
            --Unidades Medida
            LEFT JOIN inume ON inume.inumeCume = intrd.intrdUmtr      
            --Costo Promedio
            LEFT JOIN
            (
            SELECT 
                intrdCpro, intrdMinv,
                CASE
                WHEN SUM(intrdCanb) = 0 THEN 0
                ELSE SUM(intrdCTmi)/SUM(intrdCanb)
                END as 'promcos'
                FROM intra  
                JOIN intrd ON intraNtra = intrdNtra AND intrdMdel = 0
                WHERE intraMdel = 0 --AND intraFtra >='".$ffin."'
                GROUP BY intrdCpro, intrdMinv
            ) as cosprom
            ON cosprom.intrdCpro = inpro.inproCpro
            
            --Modena
            LEFT JOIN bd_admOlimpia.dbo.admon as Mpromcos ON cosprom.intrdMinv = Mpromcos.admonCmon
                    
            --fecha ult venta
            LEFT JOIN
            (
            SELECT 
            intrdCpro,
            MAX(intraFtra) as intraFtra
            FROM intra
            JOIN intrd ON intraNtra = intrdNtra AND intrdMdel=0  
            WHERE intraTmov = 90 AND intraFtra >= '".$ffin."'
            GROUP BY intrdCpro	
            ) as ultv
            ON ultv.intrdCpro = inpro.inproCpro
                    
            --Costo Origen
            LEFT JOIN
            (
            SELECT  
                cmOcd.cmOcdCpro, cmOcdMtra,  cmOcdCanC,
                REPLACE(cmOcdCosO/cmOcdCanC,',', '.') as 'cosO'
                from cmOcd 
                JOIN cmOcm as cm ON cmOcdNtra = cmOcmNtra AND cmOcmMdel=0  
                RIGHT JOIN
                (
                    select cmOcdCpro, MAX(cmOcdNtra) as Ntrans		
                    from cmOcd as prodo		
                    JOIN cmOcm as cm ON cmOcdNtra = cmOcmNtra AND cmOcmMdel=0
                    WHERE cmOcdCosO <> 0
                    --AND cm.cmOcmFocm >= '' 
                    AND cm.cmOcmFocm <= '".$ffin."'
                    GROUP BY cmOcdCpro 		
                ) as prodo
                ON prodo.cmOcdCpro = cmOcd.cmOcdCpro AND Ntrans = cmOcdNtra
                WHERE cmOcdCosO <> 0            
            ) as cosO
            ON cosO.cmOcdCpro = inpro.inproCpro --AND cosO.cmOcdNtra = intraNtra
            --Moneda
            LEFT JOIN bd_admOlimpia.dbo.admon as McosO  ON McosO.admonCmon = cosO.cmOcdMtra     
            
            --PVP
            LEFT JOIN 
            (
                SELECT vtLidPrco, vtLidCpro  FROM vtLis JOIN vtLid ON vtLidClis = vtLisClis
                WHERE vtLisDesc = 'RETAIL BALLIVIAN'
            ) as pvp
            ON pvp.vtLidCpro = inpro.inproCpro
            ORDER BY inpro.inproCpro
            ";
            $pyc = DB::connection('sqlsrv')->select(DB::raw($qPYC));

            $grupoxtipo = collect($g)->sortBy('tipo')->groupBy('tipo');
            foreach ($grupoxtipo as $key => $value) {
                $value = $value->toArray();
                $tipo_sum[$key."_tot"] = "(ISNULL([".implode("_tot],0)+ISNULL([", array_column($value, 'name')). "_tot],0)) as ". $key."_tot";
                $tipo_sum[$key."_can"] = "(ISNULL([".implode("_can],0)+ISNULL([", array_column($value, 'name')). "_can],0)) as ". $key."_can";

                $valorventasxtipo[$key]= $key."_tot"; 
                $cantidadesxtipo[$key]= $key."_can"; 
                $margenutilidadxtipo[] = "(ISNULL(".$key."_tot,0)*0.87)-(NULLIF(".$key."_can*costo,0)) as ".$key."margenutilidad";
                $margenutilidadxtipo_proc[] = "((ISNULL(".$key."_tot,0)*0.87)-(NULLIF(".$key."_can*costo,0)))/(NULLIF(cantidad*costo,0))*1 as ".$key."margenutilidad_porc";
                $costoventaxtipo[] = "(ISNULL(".$key."_can,0)*costo) as ".$key."_costo";
            }
            //return dd($margenutilidadxtipo);
            $qvts = 
            "WITH gru_prod AS 
            (
                SELECT 
                grupo,
                prod, 
                SUM(cantidad) as cantidad, 
                SUM(total) as total
                FROM(
                    SELECT
                    CASE
                        ".implode("\n",$grupos_T)."
                    ELSE 'OTROS'
                    END as grupo,  
                    vtvtaCusr,
                    --vtvtaCloc,
                    --vtvtaCalm,
                    vtvtdCpro as prod,
                    admonAbrv as mon,
                    vtvtdCant as 'cantidad',
                    vtvtdImpT as 'precioventa',
                    vtvtdDesT as 'descuento',
                    vtvtdImpT - vtvtdDesT as total
                    FROM vtVtd 
                    LEFT JOIN inpro ON inproCpro = vtvtdCpro
                    JOIN vtVta ON vtvtaNtra = vtvtdNtra AND vtvtaMdel = 0
                    JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra
                    WHERE  vtvtdMdel = 0 
                    --AND vtvtaCusr IN (4) 
                    AND (vtvtaFtra BETWEEN '".$fini."' AND '".$ffin."') 
                ) as vent
                --WHERE grupo = ''
                GROUP BY grupo, prod, mon
            ), vent AS 
            (
                SELECT prod, cant_totl, val
                FROM gru_prod
                CROSS APPLY (VALUES(grupo+'_can', cantidad), (grupo+'_tot', total)) x (cant_totl, val)
            ), ventpiv AS
            (
                SELECT *,
                ".implode(",",$tipo_sum).",
                (".implode("+",$TOT).") as total,
                (".implode("+",$CAN).") as cantidad
                FROM vent
                PIVOT
                (
                SUM(val) 
                FOR cant_totl IN (".implode(",",$vts_f).")
                ) AS p
            )
            SELECT maconNomb, prod, inproNomb as Descrip, 
            0.87 AS [0.87],
            CONVERT(VARCHAR, cast(ISNULL(costo.costo,0) as money),1) as [costo],
            CONVERT(VARCHAR, cast(ISNULL(precio.precio,0) as money),1) as [precio],
            CONVERT(VARCHAR, cast(ISNULL((precio.precio * 0.87),0) as money),1) as [precioIVA],
            CONVERT(VARCHAR, cast(ISNULL(((((precio.precio * 0.87)-costo.Costo)/NULLIF(precio.precio,0))*100),0) as money),1) as [margenBruto],
            ([PDV_tot])/NULLIF([PDV_can],0) as precioVentaPromPDV,
            (0.87-([costo]/(NULLIF(([PDV_tot])/NULLIF([PDV_can],0),0))))*100 as margenbrutoPDV,
            ([INS_tot]+[INS_SUC_tot])/(NULLIF(([INS_can]+[INS_SUC_can]),0)) as precioVentaPromINS,
            (0.87-([costo]/(NULLIF(([INS_tot]+[INS_SUC_tot])/NULLIF([INS_can]+[INS_SUC_can],0),0))))*100 as margenbrutoINS,
            ([MAYO_tot])/(NULLIF([MAYO_can],0)) as precioVentaPromMAYO,
            (0.87-([costo]/(NULLIF(([MAYO_tot])/NULLIF([MAYO_can],0),0))))*100 as margenbrutoMAYO,
            ".implode(",",$vts_grupos).",
            ".implode(",",$cantidadesxtipo).",
            cantidad,
            StockCant,
            ".implode(",",$valorventasxtipo).",
            total,
            StockCant*costo as StockValorado,
            ".implode(",",$costoventaxtipo).",
            (cantidad*costo) as 'cantidadxcosto',
            ".implode(",",$margenutilidadxtipo).",
            (total*0.87)-(NULLIF(cantidad*costo,0)) as 'total_margen',
            ".implode(",",$margenutilidadxtipo_proc).",
            ((total*0.87)-(NULLIF(cantidad*costo,0)))/(NULLIF(cantidad*costo,0))*1 as 'total_margen_proc'
            FROM ventpiv
            LEFT JOIN inpro ON inpro.inproCpro = ventpiv.prod AND inproMdel = 0
            LEFT JOIN macon ON inproMarc = CAST(MaconCcon as varchar)+ '|' + CAST(MaconItem as varchar)
            LEFT JOIN
            (
                SELECT 
                insalCpro as 'CodProd',
                AVG(insalCupb) as 'costo'
                FROM insal
                WHERE insalCupb <> 1
                GROUP BY insalCpro
            ) as costo
            ON costo.CodProd = ventpiv.prod
            LEFT JOIN 
            (
                SELECT 
                vtLidCpro, 
                vtLidPrco as precio
                FROM vtLid 
                WHERE vtLidClis = 1 AND vtLidActv = 1
            ) as precio
            ON precio.vtLidCpro = ventpiv.prod
            LEFT JOIN
            (
                SELECT 
                inproCpro as StockCod,  
                SUM(intrdCanb) as StockCant,
                CAST(ROUND(SUM(intrdCTmi),2) as decimal(32,2)) as ValorInv
                FROM intrd 
                JOIN intra ON intraNtra = intrdNtra 
                JOIN inpro ON inproCpro = intrdCpro AND inproMdel = 0
                JOIN inume ON inumeCume = intrdUmbs AND inumeMdel = 0
                WHERE intrdMdel = 0 AND intraFtra < '".$ant_fini."'
                GROUP BY inproCpro
            ) as stock
            ON stock.StockCod = ventpiv.prod
            ORDER BY prod
            ";      
            
            return dd($qvts);
            $ini = DB::connection('sqlsrv')->select(DB::raw($qvts));
            //return dd($ini);
        }
        else{
            $ant_fini = date('d-m-Y', strtotime($fini .'-1 day'));
            $dual = "DUALBIZ_SERVER.bd_olimpia.dbo";
            $aqprods = 
            "SELECT
            ISNULL(dprods.codigo,oprods.codigo) as codigo,
            ISNULL(dprods.descripcion,oprods.descripcion) as descripcion,
            ISNULL(dprods.categoria,oprods.categoria) as categoria
            FROM(
                SELECT  
                maconNomb as categoria,
                inproCpro as codigo,
                inproNomb as descripcion
                FROM ".$dual.".inpro
                LEFT JOIN macon ON inproMarc = CAST(MaconCcon as varchar)+ '|' + CAST(MaconItem as varchar)
                WHERE inproMdel = 0         
            ) as dprods
            FULL JOIN(".$qprods_o.") as oprods
            ON dprods.codigo = oprods.codigo
            ";
            $productos = DB::connection('DUALBIZ_SERVER')->select(DB::raw($aqprods)); 

            $qstock = 
            "SELECT Codigo, Descripcion, 
            SUM(ISNULL(Cantidad,0)) as Cantidad, 
            SUM(ISNULL(ValorInv,0)) as ValorInv 
            FROM(
                SELECT 
                inproCpro as Codigo, inproNomb as Descripcion, 
                intrdCanb as Cantidad, inumeAbre as UM, intrdCTmi as ValorInv
                FROM ".$dual.".intrd 
                JOIN intra ON intraNtra = intrdNtra 
                JOIN inpro ON inproCpro = intrdCpro AND inproMdel = 0
                JOIN inume ON inumeCume = intrdUmbs AND inumeMdel = 0
                WHERE intrdMdel = 0 AND intraFtra ='".$ant_fini."'
                UNION ALL
                (
                    SELECT * 
                    FROM OPENQUERY(OASSERVER, '
                        SELECT 
                        cod as Codigo, descrip as Descripcion, 
                        0 as UM, stock, 0 as ValorInv
                        FROM ".$db.".odoo_stocks 
                        LEFT JOIN ".$db.".odoo_prods ON odoo_prods.prod = odoo_stocks.cod
                        WHERE mes IN (".$m[0].")
                    ') as stk
                )
            ) as stock
            GROUP BY Codigo, Descripcion
            ";
            $stock = DB::connection('DUALBIZ_SERVER')->select(DB::raw($qstock));

            foreach ($grupos as $tg) {
                if(isset($tg->tipo)){
                    $loc = '';$alm='';$fusrs = 'AND 1=0';
                    if(isset($tg->loc)){
                        $loc = "AND vtvtaCloc = '".$tg->loc."'";
                    }
                    if(isset($tg->alm)){
                        $alm = "AND vtvtaCalm = '".$tg->alm."'";
                    } 
                    if($tg->usrs){
                        $fusrs = "AND vtvtaCusr IN (".implode(",",$tg->usrs).")";
                    }
                    $qpestañas = 
                    "SELECT
                    prod, 
                    CAST(ROUND(SUM(cantidad), 2) as decimal(36,2)) as cantidad, 
                    CAST(ROUND(SUM(precioventa), 2) as decimal(36,2)) as precioventa, 
                    CAST(ROUND(SUM(descuento), 2) as decimal(36,2)) as descuento, 
                    CAST(ROUND(SUM(total), 2) as decimal(36,2)) as total
                    FROM(
                        SELECT grupo, prod, cantidad, precioventa, descuento, total
                        FROM(
                            SELECT
                            '".$tg->name."' as grupo,  
                            vtvtdCpro as prod, vtvtdCant as cantidad, 
                            vtvtdImpT as precioventa, vtvtdDesT as descuento,
                            vtvtdImpT - vtvtdDesT as total
                            FROM  ".$dual.".vtVtd 
                            LEFT JOIN ".$dual.".inpro ON inproCpro = vtvtdCpro
                            JOIN ".$dual.".vtVta ON vtvtaNtra = vtvtdNtra AND vtvtaMdel = 0
                            WHERE vtvtdMdel = 0
                            ".$fusrs.$loc.$alm."
                            AND (vtvtaFtra BETWEEN '".$fini."' AND '".$ffin."') 
                        ) as vent
                        WHERE grupo = '".$tg->name."'
                        UNION ALL(
                            SELECT * 
                            FROM OPENQUERY(OASSERVER, '
                                SELECT grupo, IFNULL(d_cod, cod) as prod,
                                cantidad, precioventa, descuento, total
                                FROM ".$db.".odoo_rep_vts
                                LEFT JOIN ".$db.".dual_odoo_prods ON o_cod = cod
                                WHERE grupo = ''".$tg->name."''
                                AND mes IN (".implode(",",$m).")
                            ') as pest
                        ) 
                    ) as dpest
                    GROUP BY grupo, prod
                    ";
                    $result = DB::connection('DUALBIZ_SERVER')->select(DB::raw($qpestañas));
                    return dd($result);
                    if($result)
                    {
                        $reporte[$tg->name] = $result;
                        $g[] = $tg;
                    }
                }
            }      
            $qPYC = 
            "SELECT * 
            FROM OPENQUERY(OASSERVER, '
            SELECT
            categ as categoria,
            cod as codigo, 
            descrip as descripcion, 
            '''' as UM,
            precio_orig as PrecioOrigen,
            moneda_orig as MonedaPO,
            '''' as CostoUltComp,
            '''' as MonedaCUC,
            precio_costo as CostoPromedio,
            moneda_Costo as MonedaCP,
            precio_pub as pvp,
            f_ult_ingreso as FechaUltIngreso,
            cant_ult_ingreso as CantUltIngreso,        
            '''' as UMUltIngreso, 
            ref_docum as NroTransInicial,
            '''' as Proveedor,       
            f_ult_venta as FechaUlVenta,
            '''' as TipoCompra
            FROM ".$db.".odoo_pycs
            WHERE mes = ".$m[0]."
            ') as pyc";
            $pyc = DB::connection('DUALBIZ_SERVER')->select(DB::raw($qPYC));   
            foreach ($g as $key => $value) {
                $loc = ''; $alm = '';
                if(isset($value->loc)){
                    $loc = "AND vtvtaCloc = ".$value->loc."";
                }
                if(isset($value->alm)){
                    $alm = "AND vtvtaCalm = ".$value->alm."";
                }
                $vts_f[]= "[".$value->name."_can], [".$value->name."_tot]";
                $TOT[] = "ISNULL([".$value->name."_tot],0)";
                $CAN[] = "ISNULL([".$value->name."_can],0)";
                $vts_grupos[] = "ISNULL([".$value->name."_can], 0) as [".$value->name."_can], 
                ISNULL([".$value->name."_tot]/NULLIF([".$value->name."_can],0), 0) as [".$value->name."_precuni],
                ISNULL([".$value->name."_tot], 0) as [".$value->name."_tot]";               
                $grupos_head[] = [$value->name, 'tipo'=>'grupo_vts']; 
                $grupos_T[] = "WHEN vtvtaCusr IN (".implode(",",$value->usrs).") ".$loc." ".$alm." THEN '".$value->name."'";  
            }
            $grupoxtipo = collect($g)->sortBy('tipo')->groupBy('tipo');
            foreach ($grupoxtipo as $key => $value) {
                $value = $value->toArray();               
                $tipo_sum[$key."_tot"] = "(ISNULL([".implode("_tot],0)+ISNULL([", array_column($value, 'name')). "_tot],0)) as ". $key."_tot";
                $tipo_sum[$key."_can"] = "(ISNULL([".implode("_can],0)+ISNULL([", array_column($value, 'name')). "_can],0)) as ". $key."_can";
                $valorventasxtipo[$key]= $key."_tot"; 
                $cantidadesxtipo[$key]= $key."_can"; 
            }
            foreach ($cantidadesxtipo as $key => $value) {
                $costoventaxtipo[] = "(ISNULL(".$value.",0)*costo) as ".$value."_costo";
            }
            foreach ($valorventasxtipo as $key => $value) {
                
                $margenutilidadxtipo[] = "((ISNULL(".$value.",0)*0.87)/(NULLIF(cantidad*costo,0))) as ".$value."margenutilidad";
                $margenutilidadxtipo_proc[] = "((0.87)/(NULLIF(cantidad*costo,0))) as ".$value."margenutilidad_porc";
            }

            $qvts = 
            "WITH gru_prod AS 
            (
                SELECT 
                grupo,
                prod, 
                SUM(cantidad) as cantidad, 
                SUM(total) as total
                FROM 
                (
                    SELECT *
                    FROM OPENQUERY(OASSERVER, '
                        SELECT grupo,
                        IFNULL(d_cod, cod) as prod,
                        cantidad, precioventa, descuento, total
                        FROM ".$db.".odoo_rep_vts
                        LEFT JOIN ".$db.".dual_odoo_prods ON o_cod = cod
                        WHERE mes IN (".implode(",",$m).")
                    ') as vent
                    UNION ALL
                    (
                        SELECT
                        CASE
                        ".implode($grupos_T)."
                        ELSE 'OTROS'
                        END as grupo,  
                        vtvtdCpro as prod,
                        vtvtdCant as 'cantidad',
                        vtvtdImpT as 'precioventa',
                        vtvtdDesT as 'descuento',
                        vtvtdImpT - vtvtdDesT as total
                        FROM vtVtd 
                        LEFT JOIN ".$dual.".inpro ON inproCpro = vtvtdCpro
                        JOIN ".$dual.".vtVta ON vtvtaNtra = vtvtdNtra AND vtvtaMdel = 0
                        WHERE  vtvtdMdel = 0 
                        AND (vtvtaFtra BETWEEN '".$fini."' AND '".$ffin."') 
                    )
                ) as vts
                GROUP BY grupo, prod
            ), vent AS 
            (
                SELECT prod, cant_totl, val
                FROM gru_prod
                CROSS APPLY (VALUES(grupo+'_can', cantidad), (grupo+'_tot', total)) x (cant_totl, val)
            ), ventpiv AS
            (
                SELECT *,
                ".implode(",",$tipo_sum).",
                (".implode("+",$TOT).") as total,
                (".implode("+",$CAN).") as cantidad
                FROM vent
                PIVOT
                (
                SUM(val) 
                FOR cant_totl IN (".implode(",",$vts_f).")
                ) AS p
            )
            SELECT marca, ventpiv.prod, descrip, 
            0.87 AS [0.87],
            CONVERT(VARCHAR, cast(ISNULL(pyc.costo,0) as money),1) as [costo],
            CONVERT(VARCHAR, cast(ISNULL(pyc.precio,0) as money),1) as [precio],
            CONVERT(VARCHAR, cast(ISNULL((pyc.precio * 0.87),0) as money),1) as [precioIVA],
            CONVERT(VARCHAR, cast(ISNULL(((((pyc.precio * 0.87)-pyc.Costo)/NULLIF(pyc.precio,0))*100),0) as money),1) as [margenBruto],
            ([PDV_tot])/NULLIF([PDV_can],0) as precioVentaPromPDV,
            (0.87-([costo]/(NULLIF(([PDV_tot])/NULLIF([PDV_can],0),0))))*100 as margenbrutoPDV,
            ([INS_tot]+[INS_SUC_tot])/(NULLIF(([INS_can]+[INS_SUC_can]),0)) as precioVentaPromINS,
            (0.87-([costo]/(NULLIF(([INS_tot]+[INS_SUC_tot])/NULLIF([INS_can]+[INS_SUC_can],0),0))))*100 as margenbrutoINS,
            ([MAYO_tot])/(NULLIF([MAYO_can],0)) as precioVentaPromMAYO,
            (0.87-([costo]/(NULLIF(([MAYO_tot])/NULLIF([MAYO_can],0),0))))*100 as margenbrutoMAYO,
            ".implode(",",$vts_grupos).",
            ".implode(",",$cantidadesxtipo).",
            cantidad,
            StockCant,
            ".implode(",",$valorventasxtipo).",
            total,
            StockCant*costo as StockValorado,
            ".implode(",",$costoventaxtipo).",
            (cantidad*costo) as 'cantidadxcosto',
            ".implode(",",$margenutilidadxtipo).",
            (total*0.87)/(NULLIF(cantidad*costo,0)) as 'total_margen',
            ".implode(",",$margenutilidadxtipo_proc).",
            0.87/(NULLIF(cantidad*costo,0)) as 'total_margen_proc'
            FROM ventpiv
            LEFT JOIN 
            (
                SELECT
                ISNULL(dprods.codigo,oprods.codigo) as prod,
                ISNULL(dprods.descripcion,oprods.descripcion) as descrip,
                ISNULL(dprods.categoria,oprods.categoria) as marca
                FROM(
                    SELECT  
                    maconNomb as categoria,
                    inproCpro as codigo,
                    inproNomb as descripcion
                    FROM ".$dual.".inpro
                    LEFT JOIN macon ON inproMarc = CAST(MaconCcon as varchar)+ '|' + CAST(MaconItem as varchar)
                    WHERE inproMdel = 0         
                ) as dprods
                FULL JOIN(".$qprods_o.") as oprods
                ON dprods.codigo = oprods.codigo
            ) as inpro
            ON inpro.prod = ventpiv.prod
            LEFT JOIN
            (
                SELECT prod, costo, precio 
                FROM OPENQUERY
                (OASSERVER, 
                    'SELECT IFNULL(d_cod, cod) as prod, 
                    MAX(precio_costo) as costo, MAX(precio_pub) as precio
                    FROM ".$db.".odoo_pycs
                    LEFT JOIN ".$db.".dual_odoo_prods ON o_cod = cod
                    GROUP BY d_cod, cod
                ') as odoo_pycs
            ) as pyc
            ON pyc.prod = ventpiv.prod
            LEFT JOIN
            (
                SELECT 
                StockCod,  
                StockCant
                FROM OPENQUERY(OASSERVER, '
                    SELECT IFNULL(d_cod, cod) as StockCod, 
                    MAX(stock) as StockCant
                    FROM ".$db.".odoo_stocks 
                    LEFT JOIN ".$db.".dual_odoo_prods ON o_cod = odoo_stocks.cod
                    WHERE mes = ".$m[0]."
                    GROUP BY d_cod, cod
                ') as stk
            ) as stock
            ON stock.StockCod = inpro.prod
            ORDER BY prod";
         
            $ini = DB::connection('DUALBIZ_SERVER')->select(DB::raw($qvts));
        }
        //$grupoxtipo = collect($g)->sortBy('tipo')->groupBy('tipo');
        $titulos_2 = [
            'INSTI SUCURSAL', 
            'PDV',                                    
            'INSTITUCIONAL', 
            'MAYORISTA',
            'TOTAL',
            'CANTIDAD STOCK AL',
            'INSTI SUCURSAL',
            'PDV',             
            'INSTITUCIONAL', 
            'MAYORISTA',
            'TOTAL',
            'STOCK VALORADO AL',
            'INSTI SUCURSAL',
            'PDV',             
            'INSTITUCIONAL', 
            'MAYORISTA',
            'TOTAL',
            'INSTI SUCURSAL',
            'PDV',             
            'INSTITUCIONAL', 
            'MAYORISTA',
            'TOTAL',
            'INSTI SUCURSAL',
            'PDV',             
            'INSTITUCIONAL', 
            'MAYORISTA',
            'TOTAL',
        ];
        $tit_marbru = [
            'PRECIO DE VENTA PROMEDIO PDV',
            '% MARGEN BRUTO PROMEDIO PDV',
            'PRECIO DE VENTA PROMEDIO INSTI',
            '% MARGEN BRUTO PROMEDIO INSTI',
            'PRECIO DE VENTA PROMEDIO MAYO',
            '% MARGEN BRUTO PROMEDIO MAYO',
        ];

        $ct_3 = (count((array)$ini[0])-count($titulos)-count($titulos_2)-count($tit_marbru))/3;

        $h_abc = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $h_abc_2 = ['AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'];
        $h_abc_3 = ['BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ'];
        $h_abc_4 = ['CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ'];
        $h_abc_5 = ['DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ'];
        $h_abc_6 = ['EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ'];
        $h_abc = array_merge($h_abc,$h_abc_2,$h_abc_3, $h_abc_4, $h_abc_5, $h_abc_6);
        for($i=0;$i<count($titulos)+count($tit_marbru);$i++){
            $head[] = ' ';
        }
        for($i=0;$i<$ct_3;$i++){
            $titulos_3[] = 'CANTIDAD';
            $titulos_3[] = 'PRECIO UNI.';
            $titulos_3[] = 'TOTAL';
        }
        foreach ($grupos_head as $key => $value) {
            $head[] = $value[0];
            $r3 = $h_abc[array_key_last($head)];
            $head[] = ' ';
            $head[] = ' ';
            $range3[] = $r3.'1:'.$h_abc[array_key_last($head)]."1";
        }
        //return dd($range3);
        $ran4[] = $h_abc[array_key_last($head)+1].'1:'.$h_abc[array_key_last($head)+6]."1";
        $ran4[] = $h_abc[array_key_last($head)+7].'1:'.$h_abc[array_key_last($head)+12]."1";
        $ran4[] = $h_abc[array_key_last($head)+13].'1:'.$h_abc[array_key_last($head)+17]."1";
        $ran4[] = $h_abc[array_key_last($head)+18].'1:'.$h_abc[array_key_last($head)+22]."1";
        $ran4[] = $h_abc[array_key_last($head)+23].'1:'.$h_abc[array_key_last($head)+27]."1";
        //return dd($ran4);
        $head_2 = 
        [
            'CANTIDADES','','','','','',
            'VALOR DE VENTAS','','','','','',
            'COSTO DE VENTAS','','','','',
            'MARGEN DE UTILIDAD','','','','',
            'MARGEN % UTILIDAD','','','','',
        ];
        $head = array_merge($head,$head_2);
        
        $titulos = array_merge($titulos, $tit_marbru, $titulos_3, $titulos_2);           

        ini_set('memory_limit', '-1');
        $export = new ReporteVtsExport($reporte, $productos, $stock, $pyc, $ini, $titulos,$head, $range3, $ran4);   
        return Excel::download($export, 'INVENTARIO CV VS PV POR SEGMENTO '.$mes.'.xlsx');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
