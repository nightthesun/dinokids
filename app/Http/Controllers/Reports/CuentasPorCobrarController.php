<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CuentasPorCobrarExport;

class CuentasPorCobrarController extends Controller
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
            SELECT cxcTrCcbr
            FROM cxcTr
            GROUP BY cxcTrCcbr
        ))
        ORDER BY adusrNomb";
    $user = DB::connection('sqlsrv')->select(DB::raw($query));
    return view('reports.cuentasporcobrar', compact('user'));
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
    $user = "AND cxcTrCcbr IS NULL";
    $cliente = "";
    if ($request->cliente) {
      $cliente = "AND cxcTrNcto LIKE '%" . $request->cliente . "%'";
    }
    if ($request->options) {
      $user = "AND cxcTrCcbr IN (" . implode(",", $request->options) . ")";
    }
    $estado2 = "";
    if ($request->estado2 == 1) {
      $estado2 = "AND DATEDIFF(DAY, cxcTrFtra, '" . date("d/m/Y") . "') <= 30";
    } elseif ($request->estado2 == 2) {
      $estado2 = "AND DATEDIFF(DAY, cxcTrFtra, '" . date("d/m/Y") . "') <= (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '" . date("d/m/Y") . "') > (30)";
    } elseif ($request->estado2 == 3) {
      $estado2 = "AND DATEDIFF(DAY, cxcTrFtra, '" . date("d/m/Y") . "') > (30 + 15)";
    }
    $fechaA = date("d/m/Y");
    $fil = "";
    $fecha = date("d/m/Y", strtotime($request->ffin));
    $fecha1 = date("d/m/Y", strtotime($request->ffin1));
    $fecha2 = date("d/m/Y", strtotime($request->ffin2));
    if ($request->checkfecha == 1) {
      $fil = "AND liqXCFtra <= '" . $fecha . "'";
    } elseif ($request->checkfecha == 2) {
      $fil = "AND liqXCFtra BETWEEN '" . $fecha1 . "' AND '" . $fecha2 . "'";
    }
    $saldo0 = "";
    if ($request->saldo0 != "on") {
      $saldo0 = "AND cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2)) >= 1";
    }

    $fil2 = "DECLARE @fechaA DATE
        SELECT @fechaA = '" . date("d/m/Y") . "'";
    $query =
      "SELECT
        cxcTrNtra as 'Cod',
        cxcTrNcto as 'Cliente',
        isnull(imLvtRsoc,'-') as Rsocial,
        isnull(imLvtNNit,'-') as Nit,
        CONVERT(varchar,cxcTrFtra,103) as 'Fecha',
        CONVERT(varchar,DATEADD(day, 30/*DiasPlazo*/, cxcTrFtra), 103) as 'FechaVenc',
        --CONVERT(varchar,cxcTrFppg,103) as 'FPrimP',
        cast(cxcTrImpt as decimal(10,2))as 'ImporteCXC',
        REPLACE(cast(ISNULL(cobros.AcuentaF,0) as decimal(10,2)),',', '.') as 'ACuenta',
        REPLACE(cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2)),',', '.') as 'Saldo',
        --isnull(CONVERT(varchar,cobros.FechaCuenta),'-') AS FechaCobro,
        --REPLACE(cast(cxcTrAcmt as decimal(10,2)),',', '.') as 'ACuenta',
        cxcTrGlos as 'Glosa',
        adusrNomb as 'Usuario',
        admonAbrv as 'Moneda',
        --cutcuDesc as 'TipodeCuenta',
        --cxcTrNtrI as 'TransIni',
        cxcTrNtrI as 'NroVenta',
        imlvt.imLvtNrfc as 'NroFac',
        inlocNomb as 'Local',
        --DiasPlazo,
        CASE 
        WHEN DATEDIFF(DAY, cxcTrFtra, @fechaA) <= 30/*DiasPlazo*/ THEN 'VIGENTE'
        WHEN DATEDIFF(DAY, cxcTrFtra, @fechaA) <= (30/*DiasPlazo*/ + 15) THEN 'VENCIDO'
        WHEN DATEDIFF(DAY, cxcTrFtra, @fechaA) > (30/*DiasPlazo*/ + 15) THEN 'MORA'
        END as estado
        FROM cxcTr 
        JOIN bd_admOlimpia.dbo.admon ON admonCmon = cxcTrMtra AND admonMdel = 0
        JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cxcTrCcbr AND adusrMdel = 0
        JOIN inloc ON inlocCloc = cxcTrCloc AND inlocMdel = 0
        JOIN cutcu ON cutcuCtcu = cxcTrCtcu AND cutcuMdel = 0      
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
        ON (imLvtNvta = cxcTrNtrI) AND imLvtMdel = 0
        LEFT JOIN 
        (
          SELECT 
          crentCent,
          maprfDplz as 'DiasPlazo'
          FROM crEnt
          LEFT JOIN maprf ON maprfCprf = crentClsf AND maPrfMdel = 0
          WHERE crentMdel = 0 AND crentStat = 0
        ) as crent
        ON crentCent = cxcTrCcto
        --COBROS DE CXC
        LEFT JOIN
        (
          SELECT liqdCNtcc, SUM(liqdCAcmt) as AcuentaF
          FROM liqdC
          JOIN liqXC ON liqdCNtra = liqXCNtra
          WHERE liqXCMdel = 0 
          " . $fil . "
          GROUP BY liqdCNtcc
        )as cobros
        ON cobros.liqdCNtcc = cxcTrNtra
        WHERE (cxcTrImpt - cxcTrAcmt) <> 0 AND cxcTrMdel = 0
        " . $saldo0 . "
        " . $user . "
        " . $cliente . "
        " . $estado2 . "
        ";
    $cxc = DB::connection('sqlsrv')->select(DB::raw($fil2 . $query));
    $sum = DB::connection('sqlsrv')
      ->select(DB::raw(
          $fil2 .
            "SELECT 
        REPLACE(sumImporteCXC,',', '.') as sumImporteCXC, 
        REPLACE(sumACuenta,',', '.') as sumACuenta, 
        REPLACE(sumSaldo,',', '.') as sumSaldo        
        FROM (
        SELECT 
        SUM(cast(ImporteCXC as decimal(10,2))) over() as sumImporteCXC, 
        SUM(cast(ACuenta as decimal(10,2))) over() as sumACuenta, 
        SUM(cast(Saldo as decimal(10,2))) over() as sumSaldo
        FROM (" . $query . ") as cxc
        ) 
        as sum GROUP BY sumImporteCXC,sumACuenta,sumSaldo"
        ));
    $sum_estado = DB::connection('sqlsrv')
      ->select(DB::raw($fil2 . "SELECT 
        REPLACE(SUM(cast(ImporteCXC as decimal(10,2))),',', '.') as ImporteCXC, 
        REPLACE(SUM(cast(ACuenta as decimal(10,2))),',', '.') as ACuenta, 
        REPLACE(SUM(cast(Saldo as decimal(10,2))),',', '.') as Saldo,
        estado
        FROM (" . $query . ") as cxc 
        GROUP BY estado"));
    $requestFecha = $request->checkfecha;
    if ($request->gen == "export") {
      $pdf = \PDF::loadView('reports.pdf.cuentasporcobrar', compact('cxc', 'sum', 'sum_estado', 'fecha1', 'fecha2', 'fecha', 'requestFecha'))
        ->setOrientation('landscape')
        ->setPaper('letter')
        ->setOption('footer-right', 'Pag [page] de [toPage]')
        ->setOption('footer-font-size', 8);
      return $pdf->inline('Cuentas Por Cobrar Entre_' . $fecha1 . ' - ' . $fecha2 . '.pdf');
    } elseif ($request->gen == "excel") {
      $export = new CuentasPorCobrarExport($cxc, $request->checkfecha, $fecha, $fecha1, $fecha2);
      return Excel::download($export, 'Cuentas Por Cobrar.xlsx');
    } else if ($request->gen == "ver") {
      return view('reports.vista.cuentasporcobrar', compact('cxc', 'sum', 'sum_estado'));
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
