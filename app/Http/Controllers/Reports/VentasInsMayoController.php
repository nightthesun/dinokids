<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use PDF;
use Auth;

class VentasInsMayoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->tienePermiso(7, 1)){
            if(Auth::user()->tienePermiso(7, 5))
            {
                $usuario= "";
            }
            else if (Auth::user()->tienePermiso(7, 4))
            {
                $users= User::where('dbiz_user','<>',NULL)->get()->pluck('dbiz_user')->toArray();
                $usuario ="AND adusrCusr IN (".implode(",", $users).")";
            }
            else{
                if(Auth::user()->dbiz_user == null)
                {
                    $usuario= "AND adusrCusr = null";
                }
                else
                {
                $usuario= "AND adusrCusr = ".Auth::user()->dbiz_user;
                }
            }
            $query = 
            "SELECT * 
            FROM bd_admOlimpia.dbo.adusr 
            WHERE adusrMdel = 0 ".$usuario."
            AND 
            (
                adusrCusr IN 
                (
                    SELECT vtvtaCusr
                    FROM vtvta
                    GROUP BY vtvtaCusr
                )
                OR adusrCusr IN (47)
            )
            ORDER BY adusrNomb";

            $usr = DB::connection('sqlsrv')->select(DB::raw($query));
            $user = collect($usr);
            return view('reports.ventasinsmayo', compact('user'));
        }
        return redirect()->back();
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
        if(!$request->user)
        {
            $error = "Ningun usuario fue seleccionado para generar el reporte";
            return view("errors.error_variable", compact('error'));
        }
        $ffin = date("d/m/Y", strtotime($request->ffin));
        if(Auth::user()->tienePermiso(7, 7))
        {
            $fini = date("d/m/Y", strtotime($request->fini));
        } 
        else
        {
            $fini = $ffin;
        }         
        $user_id = $request->user;
        $vari = "DECLARE @usuario INT,@fini DATE,@ffin DATE
        SELECT @usuario =".$user_id.", @fini = '".$fini."', @ffin = '".$ffin."'";
        $fac = 
        " SELECT 
            CONVERT(varchar,imLvtFech,103) as 'Fecha',
            vtvtaNomC as 'Cliente', 
            vtvtaNtra as 'NroTrans',
            imLvtNNit as 'NIT',
            imlvtRsoc as 'Razon',
            imLvtNrfc as 'NroFac',
            imLvtEsfc as 'EstadoFac',
            REPLACE(cast (round(vtvtaTotT,2) as decimal(10,2)),',', '.') as 'Total',
            admonAbrv 'Moneda',
            adusrNomb as 'Usuario',
            inlocNomb as 'Local',  
            inalmNomb as 'Almacen',
            ISNULL 
            (
                CASE cptrdTtra 
                    WHEN 10 Then 'EFECTIVO' 
                    WHEN 11 THEN 'CXC' 
                    WHEN 12 THEN 'BANCO'
                    WHEN 13 THEN 'TARJETA' 
                    WHEN 15 THEN 'MOT. CONTABLE'    
                    WHEN 16 THEN 'COMPENSACION' 
                    WHEN 17 THEN 'OP. PENDIENTE' 
                END
                , 
                CASE  
                    WHEN cptraCajS > 0 THEN 'EFECTIVO'
                    WHEN cptraCxcS > 0 THEN 'CXC'
                    WHEN cptraBanS > 0 THEN 'BANCO'		
                    WHEN cptraMcnS > 0 THEN 'MOT. CONTABLE'
                    WHEN cptraTarS > 0 THEN 'TARJETA'
                    WHEN cptraCheS > 0 THEN 'CHEQUE'
                    WHEN cptraCmpS > 0 THEN 'COMPENSACION'
                    WHEN cptraOpPd > 0 THEN 'OP. PENDIENTE'
                END
            ) as 'Tipo',
            cast (cptrdImpt as decimal(10,2)) as 'ImptC'
            FROM vtvta      
            LEFT JOIN bd_admOlimpia.dbo.admon ON (admonCmon=vtvtaMtra AND admonMdel=0)    
            LEFT JOIN bd_admOlimpia.dbo.adusr ON (adusrCusr=vtvtaCusr AND adusrMdel=0)
            JOIN inloc ON (inlocCloc=vtvtaCloc AND inlocMdel=0)   
            JOIN inalm ON (inalmCalm=vtvtaCalm AND inalmMdel=0)
            LEFT JOIN cptra ON cptraNtrI = vtvtaNtra
            LEFT JOIN cptrd ON cptrdNtra = cptraNtra --Detalle Cobro
            JOIN 
            (
                SELECT 
                imLvtNlvt, imLvtNNit,
                imLvtRsoc, imLvtNrfc,
                imlvtNvta, imLvtEsfc,
                imLvtMdel, imLvtFech
                FROM imlvt WHERE imlvtNvta <> 0
                UNION
                (
                    SELECT 
                        imLvtNlvt, imLvtNNit,
                        imLvtRsoc, imLvtNrfc,				
                        vtVxFNvta as imlvtNvta,
                        imLvtEsfc, imLvtMdel,
                        imLvtFech
                    FROM imlvt 
                    JOIN vtVxF ON imLvtNlvt = vtVxFLvta
                )
            )as imlvt 
            ON imlvtnvta = vtvtantra AND imlvtmdel=0	
            WHERE 
            --imlvtNvta IS NOT NULL -- tiene factura
            vtvtaMdel = 0 AND imLvtEsfc = 'v'--Valida
            AND (imLvtFech BETWEEN @fini AND @ffin)
            AND vtvtaCusr = @usuario -- Usuario
            AND cptrdTtra <> 11
        ";

        $fac_cred = 
        "SELECT 
        CONVERT(varchar,imLvtFech,103) as 'Fecha',
        vtvtaNomC as 'Cliente', 
        vtvtaNtra as 'NroTrans',
        imLvtNNit as 'NIT',
        imlvtRsoc as 'Razon',
        imLvtNrfc as 'NroFac',
        imLvtEsfc as 'EstadoFac',
        REPLACE(cast(round(vtvtaTotT,2) as decimal(10,2)),',', '.') as 'Total',
        --(vtvtaImpT - vtvtaDesT) as '_Total',
        admonAbrv 'Moneda',
        adusrNomb as 'Usuario',
            CASE cptrdTtra 
                WHEN 10 Then 'EFECTIVO' 
                WHEN 11 THEN 'CXC' 
                WHEN 12 THEN 'BANCO'
                WHEN 13 THEN 'TARJETA' 
                WHEN 15 THEN 'MOT. CONTABLE'    
                WHEN 16 THEN 'COMPENSACION' 
                WHEN 17 THEN 'OP. PENDIENTE' 
            END
         as 'Tipoc',
        REPLACE(cast (round(cptrdImpt,2) as decimal(10,2)),',', '.') as 'ImptC'
        FROM vtvta      
        LEFT JOIN bd_admOlimpia.dbo.admon ON (admonCmon=vtvtaMtra AND admonMdel=0)    
        LEFT JOIN bd_admOlimpia.dbo.adusr ON (adusrCusr=vtvtaCusr AND adusrMdel=0)
        JOIN inloc ON (inlocCloc=vtvtaCloc AND inlocMdel=0)   
        JOIN inalm ON (inalmCalm=vtvtaCalm AND inalmMdel=0)
        LEFT JOIN cptra ON cptraNtrI = vtvtaNtra --AND cptraMdel = 0)
        LEFT JOIN cptrd ON cptrdNtra = cptraNtra --AND cptrdMdel = 0 --Detalle Cobro
        JOIN 
        (
            SELECT 
            imLvtNlvt, imLvtNNit,
            imLvtRsoc, imLvtNrfc,
            imlvtNvta, imLvtEsfc,
            imLvtMdel, imLvtFech
            FROM imlvt WHERE imlvtNvta <> 0
            UNION
            (
                SELECT 
                    imLvtNlvt, imLvtNNit,
                    imLvtRsoc, imLvtNrfc,				
                    vtVxFNvta as imlvtNvta,
                    imLvtEsfc, imLvtMdel,
                    imLvtFech
                FROM imlvt 
                JOIN vtVxF ON imLvtNlvt = vtVxFLvta
            )
        )as imlvt 
        ON imlvtnvta = vtvtantra AND imlvtmdel=0
        WHERE 
        imlvtNvta IS NOT NULL -- tiene factura
        AND vtvtaMdel = 0 AND imLvtEsfc = 'v'--Valida
        AND (imLvtFech BETWEEN @fini AND @ffin)
        AND vtvtaCusr = @usuario -- Usuario
        AND cptrdTtra = 11";

        $fac_anu = 
        "SELECT 
            CONVERT(varchar,imLvtFech,103) as 'Fecha',
            vtvtaNomC as 'Cliente', 
            vtvtaNtra as 'NroTrans',
            imLvtNNit as 'NIT',
            imlvtRsoc as 'Razon',
            imLvtNrfc as 'NroFac',
            imLvtEsfc as 'EstadoFac',
            REPLACE(cast(round(vtvtaTotT,2) as decimal(10,2)),',', '.') as 'Total',
            --(vtvtaImpT - vtvtaDesT) as '_Total',
            admonAbrv 'Moneda',
            adusrNomb as 'Usuario',
            CASE cptra.Tipo
                WHEN 'cptraCajS' THEN 'EFECTIVO'
                WHEN 'cptraCxcS' THEN 'CXC'
                WHEN 'cptraBanS' THEN 'BANCO'		
                WHEN 'cptraMcnS' THEN 'MOT. CONTABLE'
                WHEN 'cptraTarS' THEN 'TARJETA'
                WHEN 'cptraCheS' THEN 'CHEQUE'
                WHEN 'cptraCmpS' THEN 'COMPENSACION'
                WHEN 'cptraOpPd' THEN 'OP. PENDIENTE'
            END
             as 'Tipo',
             cast(round(cptra.Monto,2) as decimal(10,2)) as 'Monto'
            FROM vtvta      
            LEFT JOIN bd_admOlimpia.dbo.admon ON (admonCmon=vtvtaMtra AND admonMdel=0)    
            LEFT JOIN bd_admOlimpia.dbo.adusr ON (adusrCusr=vtvtaCusr AND adusrMdel=0)
            JOIN inloc ON (inlocCloc=vtvtaCloc AND inlocMdel=0)   
            JOIN inalm ON (inalmCalm=vtvtaCalm AND inalmMdel=0)
            --LEFT JOIN cptra ON cptraNtrI = vtvtaNtra --AND cptraMdel = 0)
            LEFT JOIN 
            (
                SELECT cptraNtra, cptraNtrI, Tipo, Monto FROM cptra
                UNPIVOT
                (	Monto
                    FOR [Tipo] 
                    IN ([cptraCajS], [cptraBanS], [cptraCxcS], 
                        [cptraMcnS], [cptraTarS], [cptraCheS], 
                        [cptraCmpS], [cptraOpPd])
                ) as Porta
                WHERE Monto > 0
            ) as cptra
            ON cptraNtrI = vtvtaNtra
            --LEFT JOIN cptrd ON cptrdNtra = cptraNtra --AND cptrdMdel = 0 --Detalle Cobro
            LEFT JOIN 
            (
                SELECT 
                imLvtNlvt, imLvtNNit,
                imLvtRsoc, imLvtNrfc,
                imlvtNvta, imLvtEsfc,
                imLvtMdel, imLvtFech
                FROM imlvt WHERE imlvtNvta <> 0
                UNION
                (
                    SELECT 
                        imLvtNlvt, imLvtNNit,
                        imLvtRsoc, imLvtNrfc,				
                        vtVxFNvta as imlvtNvta,
                        imLvtEsfc, imLvtMdel,
                        imLvtFech
                    FROM imlvt 
                    JOIN vtVxF ON imLvtNlvt = vtVxFLvta
                )
            )as imlvt 
            ON imlvtnvta = vtvtantra
            WHERE 
            imlvtNvta IS NOT NULL -- tiene factura
            AND imlvtMdel = 9 AND imLvtEsfc = 'a'--Valida
            AND (imLvtFech BETWEEN @fini AND @ffin)
            AND vtvtaCusr = @usuario -- Usuario
            AND (cptra.Tipo = 'cptraCajS' OR cptra.Tipo = 'cptraCxcS')
        ";
        $cobro_caja = 
        "SELECT
            CONVERT(varchar,cptraFtra,103) as 'Fecha',
            cptrdGlos as 'Glosa', 	
            cptraNent as 'Cliente',
            imlvtNrfc as 'NroFac',
            CASE cptrdTtra 
            When 10 Then 'EFECTIVO' 
            WHEN 11 THEN 'CXC' 
            WHEN 12	THEN 'BANCO - '+ maconNomb
            WHEN 13 THEN 'TARJETA' 
            WHEN 15 THEN 'MOT. CONTABLE' 
            WHEN 16 THEN 'COMPENSACION' 
            WHEN 17 THEN 'OP. PENDIENTE'
            END
            as 'TipoPago',
            cptrdDoce as 'DocExt', 
            banco.crentNomb as 'Banco',
            cptraNtri as 'TransInicial',
            REPLACE(cast(round(cptrdImpT,2) as decimal(10,2)),',', '.') as 'Importe', 
            admonAbrv as 'Mon',
            adusrNomb as 'Usuario'
            FROM cptrd 
            JOIN cptra ON cptraNtra = cptrdNtra
            LEFT JOIN cbCba ON cbCbaCcba = cptrdCcba AND cbcbaMdel = 0
            LEFT JOIN crEnt as banco ON cbcbaCent = banco.crentCent
            LEFT JOIN macon ON maconCcon = 120 AND cptrdTban=maconItem
            LEFT JOIN bd_admOlimpia.dbo.admon ON (admonCmon=cptrdMtra AND admonMdel=0)    
            LEFT JOIN bd_admOlimpia.dbo.adusr ON (adusrCusr=cptrdCusr AND adusrMdel=0)  
            LEFT JOIN 
            (
                SELECT 
                imLvtNlvt, imLvtNNit,
                imLvtRsoc, imLvtNrfc,
                imlvtNvta, imLvtEsfc,
                imLvtMdel, imLvtFech
                FROM imlvt WHERE imlvtNvta <> 0
                UNION
                (
                    SELECT 
                        imLvtNlvt, imLvtNNit,
                        imLvtRsoc, imLvtNrfc,				
                        vtVxFNvta as imlvtNvta,
                        imLvtEsfc, imLvtMdel,
                        imLvtFech
                    FROM imlvt 
                    JOIN vtVxF ON imLvtNlvt = vtVxFLvta
                )
            )as imlvt 
            ON imlvtnvta = cptraNtrI AND imlvtmdel=0	
            WHERE cptraTtra = 21 AND cptrdTtra <> 11
            AND cptrdCusr = @usuario
            AND (cptraFtra BETWEEN @fini AND @ffin)
        ";
        $cobros_cxc =
        "SELECT 
        --liqdCNtra, 
        CONVERT(varchar,liqXCFtra,103) as 'Fecha',
        cxcTrGlos as 'Glosa', 
        --cxcTrCcto, 
        cxcTrNcto as 'Cliente',
        ISNULL(cob.NroFac, '-') as 'NroFac',
        STUFF(( 
            SELECT  ', ' + 
            CASE cptrdTtra 
            When 10 Then 'EFECTIVO' 
            WHEN 11 THEN 'CXC' 
            WHEN 12 THEN 'BANCO - ' + maconNomb
            WHEN 13 THEN 'TARJETA' 
            WHEN 15 THEN 'MOT. CONTABLE' 
            WHEN 16 THEN 'COMPENSACION' 
            WHEN 17 THEN 'OP. PENDIENTE' 
            END           
            FROM cptrd   
            JOIN cptra ON cptraNtra = cptrdNTra
            LEFT JOIN macon ON maconCcon = 120 AND cptrdTban=maconItem
            WHERE liqdCNtra= cptraNtrI And cptraMdel=0  
            GROUP BY cptrdTtra, maconNomb
            ORDER BY 1 FOR XML PATH('')
        ),1 ,1, '') as TipoPago,
        ISNULL(
        STUFF(( 
            SELECT  ', ' + CONVERT(varchar,cptrdDoce)         
            FROM cptrd   
            JOIN cptra ON cptraNtra = cptrdNTra
            WHERE liqdCNtra= cptraNtrI And cptraMdel=0 
            AND cptrdTtra = 12
            GROUP BY cptrdDoce
            ORDER BY 1 FOR XML PATH('')
        ),1 ,1, ''),'-') as DocExt,
        ISNULL(
        STUFF(( 
            SELECT  ', ' + crentNomb        
            FROM cptrd   
            JOIN cptra ON cptraNtra = cptrdNTra
            LEFT JOIN cbCba ON cbCbaCcba = cptrdCcba AND cbcbaMdel = 0
            LEFT JOIN crEnt as banco ON cbcbaCent = banco.crentCent
            WHERE liqdCNtra= cptraNtrI And cptraMdel=0 AND 
            cptrdTtra = 12
            GROUP BY crentNomb
            ORDER BY 1 FOR XML PATH('')
        ),1 ,1, ''),'-') as Banco,
        --liqdCNtcc,	
        cxcTrNtrI as 'TransInicial',
        REPLACE(cast(round(liqdCAcmt,2) as decimal(10,2)),',', '.') as 'Importe', 
        liqdCMcta as 'Mon',        
        
        --cxcTrImpt as 'Impt CXC',
        adusrNomb as 'Usuario',
        REPLACE(cast(round((cxcTrImpt - cxcTrAcmt),2) as Numeric (10,2)),',', '.')
        as 'Saldo', liqxCNtra as 'LiqIni'
        --,cxcTrMtra 'Moneda'
        FROM liqdC
        JOIN cxcTr ON cxcTrNtra = liqdCNtcc AND cxcTrMdel = 0
        LEFT JOIN liqXC ON liqXCNtra = liqdCNtra
        LEFT JOIN cptra ON cptraNtrI = liqXCNtra
        LEFT JOIN bd_admOlimpia.dbo.adusr ON (adusrCusr=cptraCusr AND adusrMdel=0) 
        LEFT JOIN
        (
        SELECT	
            imlvtNrfc as 'NroFac',
            cptraNtrI
            FROM cptrd 
            LEFT JOIN cptra ON cptraNtra = cptrdNtra
            LEFT JOIN cxcTr ON cxcTrNtra = cptrdNtrD
            LEFT JOIN 
            (
                SELECT 
                imLvtNlvt, imLvtNNit,
                imLvtRsoc, imLvtNrfc,
                imlvtNvta, imLvtEsfc,
                imLvtMdel, imLvtFech
                FROM imlvt WHERE imlvtNvta <> 0
                UNION
                (
                    SELECT 
                        imLvtNlvt, imLvtNNit,
                        imLvtRsoc, imLvtNrfc,				
                        vtVxFNvta as imlvtNvta,
                        imLvtEsfc, imLvtMdel,
                        imLvtFech
                    FROM imlvt 
                    JOIN vtVxF ON imLvtNlvt = vtVxFLvta
                )
            )as imlvt 
            ON imLvtNvta = cxcTrNtrI AND imLvtMdel = 0
            LEFT JOIN cbCba ON cbCbaCcba = cptrdCcba AND cbcbaMdel = 0
            LEFT JOIN crEnt as banco ON cbcbaCent = banco.crentCent
            LEFT JOIN macon ON maconCcon = 120 AND cptrdTban=maconItem
            LEFT JOIN bd_admOlimpia.dbo.admon ON (admonCmon=cptrdMtra AND admonMdel=0)    
            LEFT JOIN bd_admOlimpia.dbo.adusr ON (adusrCusr=cptrdCusr AND adusrMdel=0)  
            WHERE cptraTtra = 21 AND cptrdTtra = 11
        ) as cob
        ON cob.cptraNtrI = cxcTrNtrI
        WHERE liqdCMdel= 0 
        AND (liqXCFtra BETWEEN @fini AND @ffin)
        AND cptraCusr = @usuario
        "; 
        $q1 = DB::connection('sqlsrv')->select(DB::raw($vari . $fac));
        //return dd($q1);
        $t1=[];
        foreach ($q1 as $tt) {
            if (!array_key_exists($tt->Tipo, $t1)) 
            {
                $t1[$tt->Tipo]= $tt->ImptC + 0;
            }
            else
            {
                $t1[$tt->Tipo]= $tt->ImptC+$t1[$tt->Tipo];
            }
        }
        $q2 = DB::connection('sqlsrv')->select(DB::raw($vari . $fac_cred));
        foreach ($q2 as $tt) {
            if (!array_key_exists($tt->Tipoc, $t1)) 
            {
                $t1[$tt->Tipoc]= $tt->ImptC + 0;
            }
            else
            {
                $t1[$tt->Tipoc]= $tt->ImptC+$t1[$tt->Tipoc];
            }
        }
        //return dd($t1);
        $q3 = DB::connection('sqlsrv')->select(DB::raw($vari . $fac_anu));
        $q4 = DB::connection('sqlsrv')->select(DB::raw($vari . $cobro_caja));
        $t4=[];
        foreach ($q4 as $tt) {
            if (!array_key_exists($tt->TipoPago, $t4)) 
            {
                $t4[$tt->TipoPago]= $tt->Importe;
            }
            else
            {
                $t4[$tt->TipoPago]= $tt->Importe+$t4[$tt->TipoPago];
            }
        }
        $q5 = DB::connection('sqlsrv')->select(DB::raw($vari . $cobros_cxc));
        foreach ($q5 as $tt) {
            if (!array_key_exists($tt->TipoPago, $t4)) 
            {
                $t4[$tt->TipoPago]= $tt->Importe + 0;
            }
            else
            {
                $t4[$tt->TipoPago]= $tt->Importe+$t4[$tt->TipoPago];
            }
        }
        $query = "SELECT * FROM bd_admOlimpia.dbo.adusr WHERE adusrCusr =".$user_id;
        $usr = DB::connection('sqlsrv')->select(DB::raw($query));
        $pdf = \PDF::loadView('reports.pdf.ventasinsmayo', compact('q1', 'q2', 'q3', 'q4', 'q5', 't1', 't4','usr', 'fini','ffin'))
        ->setOrientation('landscape')
        ->setPaper('letter')
        ->setOption('footer-right','Pag [page] de [toPage]')
        ->setOption('footer-font-size',8)
        ->setOption('margin-left','5')
        ->setOption('margin-right','5')
        ->setOption('margin-top','10')
        ->setOption('margin-bottom','20');
        return $pdf->inline('Ventas_'.$user_id.'.pdf');
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
