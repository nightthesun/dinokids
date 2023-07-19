<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteVentasExport;

class ReporteVentasController extends Controller
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
            SELECT vtvtaCusr
            FROM vtVta
            GROUP BY vtvtaCusr
        ))
        ORDER BY adusrNomb";
    $user = DB::connection('sqlsrv')->select(DB::raw($query));
    return view('reports.reporteventas', compact('user'));
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
    $user = "AND adusrCusr IS NULL";
    $cliente = "";
    if ($request->cliente) {
      $cliente = "AND vtvtaNomC LIKE '%" . $request->cliente . "%'";
    }
    if ($request->options) {
      $user = "AND adusrCusr IN (" . implode(",", $request->options) . ")";
    }
    $fini = date("d/m/Y", strtotime($request->fini));
    $ffin = date("d/m/Y", strtotime($request->ffin));

    $query =
      "
      SELECT
      vtvtaNtra,
      CONVERT(varchar,vtvtaFtra,103) AS fecha,
      CONVERT(VARCHAR, cast(SUM(vtvtdImpT) as money),1) AS ImpT,
      CONVERT(VARCHAR, cast(SUM(vtvtdDesT) as money),1) AS DesT,
      CONVERT(VARCHAR, cast((SUM(vtvtdDesT) * 100 / SUM(vtvtdImpT)) as money),1) AS DesPor,
      CONVERT(VARCHAR, cast((SUM(vtvtdImpT) - SUM(vtvtdDesT)) as money),1) AS total,
      vtvtaNomC,
      imLvtRsoc,
      imLvtNNit,
      ISNULL(imLvtNrfc,'-') AS factura,
      adusrNomb,
      inalmNomb
      FROM vtVta
      JOIN vtVtd ON vtvtdNtra = vtvtantra
      LEFT JOIN inalm ON inalmCalm = vtvtaCalm
      LEFT JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
      LEFT JOIN imLvt ON imlvtNvta = vtvtaNtra
      WHERE vtvtaMdel = 0
      AND vtvtaFtra BETWEEN '".$fini."' AND '".$ffin."'
      ".$user."
      ".$cliente."
      GROUP BY vtvtaNtra,vtvtaFtra,vtvtaNomC,imLvtRsoc,imLvtNNit,imLvtNrfc,adusrNomb,inalmNomb
      ORDER BY vtvtaFtra
      ";
    $venta = DB::connection('sqlsrv')->select(DB::raw($query));
    if ($request->gen == "export") {
      $pdf = \PDF::loadView('reports.pdf.reporteventas', compact('venta', 'fini', 'ffin'))
        ->setOrientation('landscape')
        ->setPaper('letter')
        ->setOption('footer-right', 'Pag [page] de [toPage]')
        ->setOption('footer-font-size', 8);
      return $pdf->inline('Reporte de Ventas entre: ' . $fini . ' - ' . $ffin . '.pdf');
    } elseif ($request->gen == "excel") {
      $export = new ReporteVentasExport($venta, $fini, $ffin);
      return Excel::download($export, 'Reporte de Ventas.xlsx');
    } else if ($request->gen == "ver") {
      return view('reports.vista.reporteventas', compact('venta'));
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
