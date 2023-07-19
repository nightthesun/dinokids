<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CuentasPorPagarExport;

class CuentasPorPagarController extends Controller
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
    if (Auth::user()->authorizePermisos(['Cuentas Por Cobrar', 'Ver usuarios DualBiz'])) {
      $usuario = "";
    } else if (Auth::user()->authorizePermisos(['Cuentas Por Cobrar', 'Ver usuarios OAS'])) {
      $users = User::where('dbiz_user', '<>', NULL)->get()->pluck('dbiz_user')->toArray();
      $users = implode(",", $users);
      $usuario = "AND adusrCusr IN (" . $users . ")";
    } else {
      if (Auth::user()->dbiz_user == null) {
        $usuario = "AND adusrCusr = null";
      } else {
        $usuario = "AND adusrCusr = " . Auth::user()->dbiz_user;
      }
    }
    $query =
      "SELECT * 
        FROM bd_admOlimpia.dbo.adusr 
        WHERE adusrMdel = 0 " . $usuario . "
        AND (adusrCusr IN 
        (
            SELECT cxpTrCcbr
            FROM cxpTr
            GROUP BY cxpTrCcbr
        ))
        ORDER BY adusrNomb";
    $user = DB::connection('sqlsrv')->select(DB::raw($query));
    return view('reports.cuentasporpagar', compact('user'));
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
    $user = "AND cxpTrCcbr IS NULL";
    $cliente = "";
    if ($request->cliente) {
      $cliente = "AND cxpTrNcto LIKE '%" . $request->cliente . "%'";
    }
    if ($request->options) {
      $user = "AND cxpTrCcbr IN (" . implode(",", $request->options) . ")";
    }
    $estado2 = "";
    if ($request->estado2 == 1) {
      $estado2 = "AND DATEDIFF(DAY, cxpTrFtra, '" . date("d/m/Y") . "') <= 30";
    } elseif ($request->estado2 == 2) {
      $estado2 = "AND DATEDIFF(DAY, cxpTrFtra, '" . date("d/m/Y") . "') <= (30 + 15) AND DATEDIFF(DAY, cxpTrFtra, '" . date("d/m/Y") . "') > (30)";
    } elseif ($request->estado2 == 3) {
      $estado2 = "AND DATEDIFF(DAY, cxpTrFtra, '" . date("d/m/Y") . "') > (30 + 15)";
    }
    $fechaA = date("d/m/Y");
    $fil = "";
    $fecha = date("d/m/Y", strtotime($request->ffin));
    $fecha1 = date("d/m/Y", strtotime($request->ffin1));
    $fecha2 = date("d/m/Y", strtotime($request->ffin2));
    if ($request->checkfecha == 1) {
      $fil = "AND liqXPFtra <= '" . $fecha . "'";
    } elseif ($request->checkfecha == 2) {
      $fil = "AND liqXCFtra BETWEEN '" . $fecha1 . "' AND '" . $fecha2 . "'";
    }
    $saldo0 = "";
    if ($request->saldo0 != "on") {
      $saldo0 = "AND REPLACE(cast((ISNULL(cxpTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2)),',', '.') != '0.00'";
    }

    $fil2 = "DECLARE @fechaA DATE
        SELECT @fechaA = '" . date("d/m/Y") . "'";
    $query =
      "SELECT
        cxpTrNtra as 'Cod',
        cxpTrNcto as 'Proveedor',
        /*isnull(imLvtRsoc,'-') as Rsocial,
        isnull(imLvtNNit,'-') as Nit,*/
        CONVERT(varchar,cxpTrFtra,103) as 'Fecha',
        CONVERT(varchar,DATEADD(day, 30/*DiasPlazo*/, cxpTrFtra), 103) as 'FechaVenc',
        --CONVERT(varchar,cxcTrFppg,103) as 'FPrimP',
        cast(cxpTrImpt as decimal(10,2))as 'ImporteCXP',
        REPLACE(cast(ISNULL(cobros.AcuentaF,0) as decimal(10,2)),',', '.') as 'ACuenta',
        REPLACE(cast((ISNULL(cxpTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2)),',', '.') as 'Saldo',
        --isnull(CONVERT(varchar,cobros.FechaCuenta),'-') AS FechaCobro,
        --REPLACE(cast(cxcTrAcmt as decimal(10,2)),',', '.') as 'ACuenta',
        cxpTrGlos as 'Glosa',
        adusrNomb as 'Usuario',
        admonAbrv as 'Moneda',
        --cutcuDesc as 'TipodeCuenta',
        --cxcTrNtrI as 'TransIni',
        cxpTrNtrI as 'NroCompra',
        --imlvt.imLvtNrfc as 'NroFac',
        inlocNomb as 'Local',
        --DiasPlazo,
        CASE 
        WHEN DATEDIFF(DAY, cxpTrFtra, @fechaA) <= 30/*DiasPlazo*/ THEN 'VIGENTE'
        WHEN DATEDIFF(DAY, cxpTrFtra, @fechaA) <= (30/*DiasPlazo*/ + 15) THEN 'VENCIDO'
        WHEN DATEDIFF(DAY, cxpTrFtra, @fechaA) > (30/*DiasPlazo*/ + 15) THEN 'MORA'
        END as estado
        FROM cxpTr 
        JOIN bd_admOlimpia.dbo.admon ON admonCmon = cxpTrMtra AND admonMdel = 0
        JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cxpTrCcbr AND adusrMdel = 0
        JOIN inloc ON inlocCloc = cxpTrCloc AND inlocMdel = 0
        JOIN cutcu ON cutcuCtcu = cxpTrCtcu AND cutcuMdel = 0      
        --//CXC generadas por VENTAS
        /*JOIN
        (
        SELECT *
        FROM cptra 
        JOIN cptrd ON cptrdNtra = cptraNtra AND cptrdTtra = 11
        WHERE cptraTtra = 21 AND cptraMdel = 0
        ) cptra
        ON cptrdNtrD = cxcTrNtra*/
        --//CXC generadas por VENTAS 
        /*LEFT JOIN
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
        ON (imLvtNvta = cxpTrNtrI) AND imLvtMdel = 0*/
        LEFT JOIN 
        (
            SELECT 
            crentCent,
            maprfDplz as 'DiasPlazo'
            FROM crEnt
            LEFT JOIN maprf ON maprfCprf = crentClsf AND maPrfMdel = 0
            WHERE crentMdel = 0 AND crentStat = 0
        ) as crent
        ON crentCent = cxpTrCcto
        --COBROS DE CXC
                
        LEFT JOIN
        (
            SELECT liqdPNtcp, SUM(liqdpAcmt) as AcuentaF
            FROM liqdP
            JOIN liqXP ON liqdPNtra = liqXPNtra
            WHERE liqXPMdel = 0 
            ".$fil."
            GROUP BY liqdPNtcp
        )as cobros
        ON cobros.liqdPNtcp = cxpTrNtra
        WHERE (cxpTrImpt - cxpTrAcmt) <> 0 AND cxpTrMdel = 0
        " . $saldo0 . "
        " . $user . "
        " . $cliente . "
        " . $estado2 . "
        ";
    $cxp = DB::connection('sqlsrv')->select(DB::raw($fil2 . $query));
    // dd($query);
    $sum = DB::connection('sqlsrv')
      ->select(DB::raw(
        $fil2 .
          "SELECT 
        REPLACE(sumImporteCXP,',', '.') as sumImporteCXP, 
        REPLACE(sumACuenta,',', '.') as sumACuenta, 
        REPLACE(sumSaldo,',', '.') as sumSaldo        
        FROM (
        SELECT 
        SUM(cast(ImporteCXP as decimal(10,2))) over() as sumImporteCXP, 
        SUM(cast(ACuenta as decimal(10,2))) over() as sumACuenta, 
        SUM(cast(Saldo as decimal(10,2))) over() as sumSaldo
        FROM (" . $query . ") as cxp
        ) 
        as sum GROUP BY sumImporteCXP,sumACuenta,sumSaldo"
      ));
    $sum_estado = DB::connection('sqlsrv')
      ->select(DB::raw($fil2 . "SELECT 
        REPLACE(SUM(cast(ImporteCXP as decimal(10,2))),',', '.') as ImporteCXP, 
        REPLACE(SUM(cast(ACuenta as decimal(10,2))),',', '.') as ACuenta, 
        REPLACE(SUM(cast(Saldo as decimal(10,2))),',', '.') as Saldo,
        estado
        FROM (" . $query . ") as cxp 
        GROUP BY estado"));
    $requestFecha = $request->checkfecha;
    $titulos =
      [
        ['name' => 'codigo', 'data' => 'codigo', 'title' => 'Codigo', 'tip' => 'filtro'],
        ['name' => 'proveedor', 'data' => 'proveedor', 'title' => 'Proveedor', 'tip' => 'filtro'],
        [],
        [],
        [],
        [],
        [],
        [],
        ['name' => 'usuario', 'data' => 'usuario', 'title' => 'Usuario', 'tip' => 'filtro'],
        [],
        [],
        ['name' => 'local', 'data' => 'local', 'title' => 'Local', 'tip' => 'filtro'],
        ['name' => 'estado', 'data' => 'estado', 'title' => 'Estado', 'tip' => 'filtro'],
      ];
    if ($request->gen == "export") {
      $pdf = \PDF::loadView('reports.pdf.cuentasporpagar', compact('cxp', 'sum', 'sum_estado', 'fecha1', 'fecha2', 'fecha', 'requestFecha'))
        ->setOrientation('landscape')
        ->setPaper('letter')
        ->setOption('footer-right', 'Pag [page] de [toPage]')
        ->setOption('footer-font-size', 8);
      return $pdf->inline('Cuentas Por Cobrar Entre_' . $fecha1 . ' - ' . $fecha2 . '.pdf');
    } elseif ($request->gen == "excel") {
      $export = new CuentasPorPagarExport($cxp, $request->checkfecha, $fecha, $fecha1, $fecha2);
      return Excel::download($export, 'Cuentas Por Cobrar.xlsx');
    } else if ($request->gen == "ver") {
      return view('reports.vista.cuentasporpagar', compact('cxp', 'sum', 'sum_estado', 'titulos'));
    }
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
