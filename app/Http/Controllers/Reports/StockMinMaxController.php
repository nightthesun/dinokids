<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use App\Stockventa;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockExport;
use App\TempStockParam;

class StockMinMaxController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (Auth::user()->tienePermiso(30, 1)) {
      $alm_q =
        "SELECT 
            CASE 
            WHEN inalmCalm IN (40,47) THEN 'AC2'
            -- WHEN inalmCalm IN (39,46) THEN 'AC1'
            WHEN inalmCalm IN (43) THEN 'Planta'
            -- WHEN inalmCalm IN (4,13) THEN 'Handal'
            -- WHEN inalmCalm IN (7,10) THEN 'Ballivian'
            -- WHEN inalmCalm IN (6,30) THEN 'Mariscal'
            -- WHEN inalmCalm IN (5,29) THEN 'Calacoto'
            -- WHEN inalmCalm IN (45) THEN 'SantaCruz'
            -- WHEN inalmCalm IN (55) THEN 'Feria'
            -- WHEN inalmCalm IN (56) THEN 'Contratos'
            -- WHEN inalmCalm IN (43) THEN 'Produccion'
            -- WHEN inalmCalm IN (54) THEN 'VMovil1'
            ELSE 'Sin Grupo'
            END as grupo,
            CASE 
            WHEN inalmCalm IN (40,43,47) THEN 1
            ELSE 0
            END as estado,
            inalmCalm, 
            inalmNomb 
            FROM inalm 
            WHERE inalmMdel = 0 AND inalmStat = 1 AND inalmCalm NOT IN (42, 44, 51,36,38,52)
            ORDER BY estado DESC, inalmNomb";

      $almacen = DB::connection('sqlsrv')->select(DB::raw($alm_q));
      $almacen_grupo = [];
      foreach ($almacen as $key => $value) {
        if (!array_key_exists($value->grupo, $almacen_grupo)) {
          $almacen_grupo[$value->grupo] = [$almacen[$key]];
        } else {
          $almacen_grupo[$value->grupo][] = $almacen[$key];
        }
      }
      return view('reports.stockminmax', compact('almacen', 'almacen_grupo'));
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
    if (!Auth::user()->tienePermiso(30, 9)) {
      $almxu = TempStockParam::where('user_id', Auth::user()->id)->get('alm_id');
      $almxua = [];
      foreach ($almxu as $key => $value) {
        $almxua[] = $value->alm_id;
      }
      if ($almxua) {
        $almacenes = $almxua;
      } else {
        return redirect()->back();
      }
    } else {
      $almacenes = $request->almacen;
    }

    //return dd(implode("+",$alma_total));
    $pvp_sql = "";
    $pvp = false;
    $titulos =
      [
        ['name' => 'categoria', 'data' => 'categoria', 'title' => 'Categoria', 'tip' => 'filtro'],
        ['name' => 'codigo', 'data' => 'codigo', 'title' => 'Codigo', 'tip' => 'filtro'],
        ['name' => 'descripcion', 'data' => 'descripcion', 'title' => 'Descripcion', 'tip' => 'filtro'],
        ['name' => 'umprod', 'data' => 'umprod', 'title' => 'U.M.', 'tip' => 'filtro_select'],
        ['name' => 'maxpro', 'data' => 'maxpro', 'title' => 'MAX', 'tip' => 'filtro_select'],
        ['name' => 'minpro', 'data' => 'minpro', 'title' => 'MIN', 'tip' => 'filtro_select'],
      ];
    $titulos_excel =
      [
        'Categoria',
        'Codigo',
        'Descripcion',
        'U.M,',
      ];
    $codBarras = '';
    if ($request->codBarras != null) {
      $codBarras = "inpro.inproCodi as 'CodBarras',";
      $titulos[] = ['name' => 'CodBarras', 'data' => 'CodBarras', 'title' => 'Cod. Barras', 'tip' => 'filtro'];
      $titulos_excel[] = 'Cod. Barras';
    }
    $ffin = date("d/m/Y");
    if ($request->fecha_fin) {
      $ffin = date("d/m/Y", strtotime($request->fecha_fin));
    }
    $categ = "";
    if ($request->categoria) {
      $categ = "AND   marc.maconNomb LIKE '%" . $request->categoria . "%'";
    }
    $prod = "";
    if ($request->producto) {
      $prod = "AND (inpro.inproCpro LIKE '%" . $request->producto . "%'
            OR inpro.inproNomb LIKE '%" . $request->producto . "%')";
    }
    $stock = "";
    $stocki = "";
    if ($request->stock0 == null) {
      $stock = "AND (stocks.Total IS NOT NULL)";
      $stocki = "AND stocks.Total <> 0";
    }
    $grup_tit = [];
    $grup_t = [];
    foreach (unserialize($request->grupos) as $key => $value) {
      if ($key == 'Sin Grupo') {
        foreach ($value as $k => $v) {
          if (array_search($v->inalmCalm, $almacenes)) {
            $grup_tit[] = "ISNULL([" . $v->inalmCalm . "],0) as [" . $v->inalmCalm . "]";
            $grup_t[] = "CAST(ISNULL([" . $v->inalmCalm . "],0) as varchar) as [" . $v->inalmNomb . "]";
            $titulos[] = ['name' => $v->inalmNomb, 'data' => $v->inalmNomb, 'title' => $v->inalmNomb, 'tip' => 'decimal'];
            $titulos_excel[] = $v->inalmNomb;
          }
        }
      } else {
        $temp = [];
        foreach ($value as $k => $v) {
          if (array_search($v->inalmCalm, $almacenes) !== false) {
            $temp[] = "ISNULL([" . $v->inalmCalm . "],0)";
          }
        }
        if ($temp != null) {
          $grup_tit[] = implode("+", $temp) . " as [" . $key . "]";
          $grup_t[] = "CAST(ISNULL([" . $key . "],0) as varchar) as [" . $key . "]";

          $titulos[] = ['name' => $key, 'data' => $key, 'title' => $key, 'tip' => 'decimal'];
          $titulos_excel[] = $key;
        }
      }
    }
    //return dd($request->all());
    $alma = [];
    $alma_total = [];
    foreach ($almacenes as $value) {
      $alma[] = "[" . $value . "]";
      $alma_total[] = "ISNULL([" . $value . "],0)";;
    }

    $query =
      "SELECT
        marc.maconNomb as categoria,
        inpro.inproCpro as codigo, 
        inpro.inproNomb as descripcion, 
        umpro.inumeAbre as umprod,
        inpro.inproSmax as maxpro,
		    inpro.inproSmin AS minpro,
        " . $codBarras . "       
        " . implode(",", $grup_t) . ",
		CAST(ISNULL(Total,0) as varchar) as Total
        FROM (
            SELECT * FROM inpro
        ) as inpro 
        
        LEFT JOIN inume as umpro ON umpro.inumeCume = inpro.inproCumb

        LEFT JOIN 
        (
            SELECT 
            convert(varchar,maconCcon)+'|'+convert(varchar,maconItem) as maconMarc, 
            maconNomb 
            FROM macon 
            WHERE maconCcon = 113
        ) as marc
        ON inpro.inproMarc = marc.maconMarc
        LEFT JOIN
		(
			SELECT
			intrdCpro,
            " . implode(",", $grup_tit) . ",
			" . implode("+", $alma_total) . " as 'Total'
			FROM
			(
				SELECT 
				intrdCpro, intraCalm, SUM(intrdCanb) as cant
				FROM intra
				JOIN intrd ON intraNtra = intrdNtra
				WHERE intraMdel = 0 AND intrdMdel = 0
                AND intraFtra <= '" . $ffin . "'
				GROUP BY intrdCpro, intraCalm
			) as sotck
			pivot
			(
			  SUM(cant)
			  for intraCalm IN (" . implode(",", $alma) . ")
			) as ptv
		) as stocks
		ON stocks.intrdCpro = inpro.inproCpro  " . $stocki . "
        WHERE 
        inproMdel = 0 AND inproStat = 0
        --AND   marc.maconNomb LIKE '%%'
        --AND (inpro.inproCpro LIKE '%%' OR inpro.inproNomb LIKE '%%')
        --AND stocks.Total
        " . $categ . "
        " . $prod . "
        " . $stock . "
        ORDER BY inpro.inproCpro";
    //return dd($query);
    $test = DB::connection('sqlsrv')->select(DB::raw($query));
    $textMax = [];
    $textMin = [];
    foreach ($test as $val){
      if ($val->AC2 <= $val->minpro){
        $textMin[] = ['categoria' => $val->categoria, 'codigo' => $val->codigo, 'descripcion' => $val->descripcion, 'umprod' => $val->umprod, 'maxpro' => $val->maxpro, 'minpro' => $val->minpro, 'AC2' => $val->AC2, 'Planta' => $val->Planta, 'Total' => $val->Total];
      } else {
        $textMax[] = ['categoria' => $val->categoria, 'codigo' => $val->codigo, 'descripcion' => $val->descripcion, 'umprod' => $val->umprod, 'maxpro' => $val->maxpro, 'minpro' => $val->minpro, 'AC2' => $val->AC2, 'Planta' => $val->Planta, 'Total' => $val->Total];
      }
    }
    $titulos[] = ['name' => 'Total', 'data' => 'Total', 'title' => 'Total', 'tip' => 'decimal'];
    $titulos_excel[] = 'Total';
    if ($request->gen == "export") {
      //return dd($pvp);
      $export = new StockExport($test, $titulos_excel);
      return Excel::download($export, 'Reporte de Stock Actual.xlsx');
    } else {
      //return dd($titulos);
      return view('reports.vista.stockminmax', compact('textMax', 'textMin', 'titulos'));
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

  public function store_almxu(Request $request)
    {
        if($request->show == true)
        {
            $almsxu = TempStockParam::where('user_id',$request->user)->get();
            return response()->json($almsxu);
        }
        else
        {
            //return response()->json($request->state);
            if($request->state == "true")
            {
                $data = TempStockParam::create([
                    'user_id'=>$request->user,
                    'alm_id'=> $request->alm,
                ]);
                return response()->json($data);
            }
            else
            {
                $test = TempStockParam::where('user_id',$request->user)->where('alm_id', $request->alm)->delete();
                return response()->json($test);
            }
        }
    }
}
