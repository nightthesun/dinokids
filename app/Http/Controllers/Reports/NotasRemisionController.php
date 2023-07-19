<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use PDF;
use Auth;

class NotasRemisionController extends Controller
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
        if(Auth::user()->authorizePermisos(['Notas De Remisión', 'Ver usuarios DualBiz']))
        {
            $usuario= "";
        }
        else if (Auth::user()->authorizePermisos(['Notas De Remisión', 'Ver usuarios OAS']))
        {
            $users= User::where('dbiz_user','<>',NULL)->get()->pluck('dbiz_user')->toArray();
            $users= implode(",", $users);
            $usuario ="AND adusrCusr IN (".$users.")";
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
        AND (adusrCusr IN 
        (
            SELECT vtvtaCusr
            FROM vtvta
            GROUP BY vtvtaCusr
        ))
        ORDER BY adusrNomb";
        $usr = DB::connection('sqlsrv')->select(DB::raw($query));
        $user = collect($usr);
        return view('reports.notasremision', compact('user'));
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
        else if (Auth::user()->authorizePermisos(['Notas De Remisión', 'Rango de Fechas']))
        {
            $fini = date("d/m/Y", strtotime($request->fini));
            $ffin = date("d/m/Y", strtotime($request->ffin));
            $fecha = "AND (vtvtaFent BETWEEN '".$fini."' AND '".$ffin."')";
        }
        else
        {
            $fini = date("d/m/Y",strtotime("1/1/1900"));
            $ffin = date("d/m/Y", strtotime($request->ffin));
            //return dd($ffin);
            $fecha = "AND (vtvtaFent = '".$ffin."')";
        }
        $user_id = $request->user;
        $facturas = "" ;
        if(!$request->facturadas)
        {
            $facturas = "AND imlvtNvta IS NULL";
        }
        $vari = "DECLARE @usuario INT
        SELECT @usuario =".$user_id;
        $not = 
        " SELECT 
            CONVERT(varchar,vtvtaFent,103) as 'Fecha',
            vtvtaCent as 'NroCli',
            vtvtaNomC as 'Cliente', 
            vtvtaNtra as 'NroTrans',
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
            cast (cptrdImpt as decimal(10,2)) as 'ImptC',
            CASE
            WHEN imlvtNvta IS NULL THEN 'NO'
            WHEN imlvtNvta IS NOT NULL THEN 'SI'
            END as facturado,
            CONVERT(varchar,imlvtFech,103) as 'FechaFac'
            FROM vtvta      
            LEFT JOIN bd_admOlimpia.dbo.admon ON (admonCmon=vtvtaMtra AND admonMdel=0)    
            LEFT JOIN bd_admOlimpia.dbo.adusr ON (adusrCusr=vtvtaCusr AND adusrMdel=0)
            JOIN inloc ON (inlocCloc=vtvtaCloc AND inlocMdel=0)   
            JOIN inalm ON (inalmCalm=vtvtaCalm AND inalmMdel=0)
            LEFT JOIN cptra ON cptraNtrI = vtvtaNtra
            LEFT JOIN cptrd ON cptrdNtra = cptraNtra --Detalle Cobro	
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
            ON imlvtnvta = vtvtantra AND imlvtmdel=0	
            WHERE 
            --imlvtNvta IS NULL -- tiene factura
            vtvtaMdel = 0
            ".$facturas."
            ".$fecha."
            AND vtvtaCusr = @usuario -- Usuario
        ";

        $not_anu = 
        "SELECT 
        CONVERT(varchar,vtvtaFent,103) as 'Fecha',
        vtvtaCent as 'NroCli',
        vtvtaNomC as 'Cliente', 
        vtvtaNtra as 'NroTrans',
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
        cast (cptrdImpt as decimal(10,2)) as 'ImptC',
        CASE
        WHEN imlvtNvta IS NULL THEN 'NO'
        WHEN imlvtNvta IS NOT NULL THEN 'SI'
        END as facturado,
        CONVERT(varchar,imlvtFech,103) as 'FechaFac'
        FROM vtvta      
        LEFT JOIN bd_admOlimpia.dbo.admon ON (admonCmon=vtvtaMtra AND admonMdel=0)    
        LEFT JOIN bd_admOlimpia.dbo.adusr ON (adusrCusr=vtvtaCusr AND adusrMdel=0)
        JOIN inloc ON (inlocCloc=vtvtaCloc AND inlocMdel=0)   
        JOIN inalm ON (inalmCalm=vtvtaCalm AND inalmMdel=0)
        LEFT JOIN cptra ON cptraNtrI = vtvtaNtra
        LEFT JOIN cptrd ON cptrdNtra = cptraNtra --Detalle Cobro	
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
        ON imlvtnvta = vtvtantra AND imlvtmdel=0	
        WHERE 
        --imlvtNvta IS NULL -- tiene factura
        vtvtaMdel = 9
        ".$facturas."
        ".$fecha."
        AND vtvtaCusr = @usuario -- Usuario
        ";
        $q1 = DB::connection('sqlsrv')->select(DB::raw($vari . $not));
        $q2 = DB::connection('sqlsrv')->select(DB::raw($vari . $not_anu));
        $query = "SELECT * FROM bd_admOlimpia.dbo.adusr WHERE adusrCusr =".$user_id;
        $usr = DB::connection('sqlsrv')->select(DB::raw($query));
        $pdf = \PDF::loadView('reports.pdf.notasremision', compact('q1','q2','usr', 'ffin','fini'))
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
