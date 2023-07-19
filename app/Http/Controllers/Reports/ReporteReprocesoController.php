<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReprocesoExport;

class ReporteReprocesoController extends Controller
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
    $query2 = "
      SELECT DISTINCT(intraTmov), maTmoNomb
      FROM intra
      LEFT JOIN maTmo ON maTmoItem = intraTmov
      WHERE intraMdel = 0
    ";
    $tmov = DB::connection('sqlsrv')->select(DB::raw($query2));
    return view('reports.reproceso', compact('user','tmov'));
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
    $categ = "";
    if ($request->categoria) {
      $categ = "AND maconNomb LIKE '%" . $request->categoria . "%'";
    }
    $fini = "";
    if ($request->fini) {
      $fini = date("d/m/Y", strtotime($request->fini));
    }
    $ffin = "";
    if ($request->ffin) {
      $ffin = date("d/m/Y", strtotime($request->ffin));
    }
    $tmov = "AND intraTmov IS NULL";
    if ($request->options) {
      $tmov = "AND intraTmov IN (" . implode(",", $request->options) . ")";
    }
    $user = "AND intraCres IS NULL";
    if ($request->options2) {
      $user = "AND intraCres IN (" . implode(",", $request->options2) . ")";
    }
    $prod = "";
    if ($request->producto) {
      $prod = "AND (inproCpro LIKE '%" . $request->producto . "%'
            OR inpro.inproNomb LIKE '%" . $request->producto . "%')";
    }

    $sql_query = "
    SELECT
    CONVERT(varchar,intraHora,113) AS fecha_ori,
    intraNtra,
    maconNomb,
    inproCpro,
    inproNomb,
    inumeAbre,
    inalmNomb,
    intrdCanb,
    CONVERT(varchar, CAST(intrdCTmi/intrdCanb as decimal(10,4)),1) as cost_u,
    CONVERT(varchar,intraFtra,103) AS fecha_red,
    adusrNomb,
    intraGlos,
    maTmoNomb,
    CASE 
      WHEN intrdCanb > 0 THEN 'Ingreso'
      ELSE 'Egreso'
    END AS ing_sal
    FROM intra
    JOIN intrd On (intraNtra = intrdNtra And intrdMdel = 0)
    JOIN inpro On (intrdCpro = inproCpro)
    JOIN inalm On (intraCalm = inalmCalm)
    LEFT JOIN inume as umpro ON umpro.inumeCume = inpro.inproCumb
    JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = intraCres AND adusrMdel = 0
    LEFT JOIN 
    (
        SELECT 
        convert(varchar,maconCcon)+'|'+convert(varchar,maconItem) as maconMarc, 
        maconNomb 
        FROM macon 
        WHERE maconCcon = 113
    ) as marc
    ON inpro.inproMarc = marc.maconMarc
    LEFT JOIN maTmo ON intraTmov = maTmoItem
    WHERE intraMdel = 0
    AND intraHora BETWEEN '" . $fini . "' AND '" . $ffin . "'
    " . $categ . "
    " . $tmov . "
    " . $user . "
    " . $prod . "
    ORDER BY intraHora
    ";
    // dd($sql_query);
    $query = DB::connection('sqlsrv')->select(DB::raw($sql_query));

    $titulos =
      [
        ['name' => 'fecha_ori', 'data' => 'fecha_ori', 'title' => 'FechaOrigen', 'tip' => 'filtro'],
        ['name' => 'intraNtra', 'data' => 'intraNtra', 'title' => 'NTrans', 'tip' => 'filtro'],
        ['name' => 'maconNomb', 'data' => 'maconNomb', 'title' => 'Categoria', 'tip' => 'filtro'],
        ['name' => 'inproCpro', 'data' => 'inproCpro', 'title' => 'Codigo', 'tip' => 'filtro'],
        ['name' => 'inproNomb', 'data' => 'inproNomb', 'title' => 'Descripcion', 'tip' => 'filtro'],
        ['name' => 'inumeAbre', 'data' => 'inumeAbre', 'title' => 'U.M.', 'tip' => 'filtro_select'],
        ['name' => 'inalmNomb', 'data' => 'inalmNomb', 'title' => 'Almacen', 'tip' => 'filtro_select'],
        ['name' => 'intrdCanb', 'data' => 'intrdCanb', 'title' => 'Cantidad'],
        ['name' => 'cost_u', 'data' => 'cost_u', 'title' => 'CostU'],
        ['name' => 'fecha_red', 'data' => 'fecha_red', 'title' => 'FechaRed'],
        ['name' => 'adusrNomb', 'data' => 'adusrNomb', 'title' => 'Usuario', 'tip' => 'filtro_select'],
        ['name' => 'intraGlos', 'data' => 'intraGlos', 'title' => 'Glosa', 'tip' => 'filtro'],
        ['name' => 'maTmoNomb', 'data' => 'maTmoNomb', 'title' => 'TipMov', 'tip' => 'filtro_select'],
        ['name' => 'ing_sal', 'data' => 'ing_sal', 'title' => 'Ingr/Egre', 'tip' => 'filtro_select'],
      ];
    if ($request->gen == "excel") {
      $export = new ReprocesoExport($query,$fini,$ffin);
      return Excel::download($export, 'Reporte Para Reproceso.xlsx');
    } else if ($request->gen == "ver") {
      return view('reports.vista.reproceso', compact('query', 'titulos'));
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
