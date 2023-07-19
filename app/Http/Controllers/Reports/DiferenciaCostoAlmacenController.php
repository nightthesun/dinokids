<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;

class DiferenciaCostoAlmacenController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $query =
      "SELECT 
      convert(varchar,maconCcon)+'|'+convert(varchar,maconItem) as maconMarc, 
      maconNomb 
      FROM macon 
      WHERE maconCcon = 113
			ORDER BY maconNomb";
    $marcas = DB::connection('sqlsrv')->select(DB::raw($query));
    return view('reports.diferenciacostoalmacen', compact('marcas'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $array_list = [];
    $fini = date("d/m/Y", strtotime($request->fini));
    $ffin = date("d/m/Y", strtotime($request->ffin));
    $sql_prodList = "
    SELECT inproCpro AS codigo
    FROM inpro
    --WHERE inproMarc = '".$request->marc."'
    ORDER BY inproCpro
    ";
    $query_prodList = DB::connection('sqlsrv')->select(DB::raw($sql_prodList));
    // dd($query_prodList);
    foreach ($query_prodList as $key => $value) {
      $sql_query = "
        DECLARE @Cpro nvarchar(9)
        SELECT @Cpro = '$value->codigo';
        WITH cte as
        (
        SELECT
        ROW_NUMBER() OVER(PARTITION BY intraCalm ORDER BY intraFtra DESC) RN,
        intrdCpro, inproNomb, inumeAbre, intraCalm,
        Case
            When intrdCanb = 0 Then 0
            Else intrdCTmi/intrdCanb
            End as _CostUnit
        FROM intra
        JOIN intrd On (intraNtra = intrdNtra And intrdMdel = 0)
        JOIN inpro On (intrdCpro = inproCpro)
        JOIN inalm On (intraCalm = inalmCalm)
        LEFT JOIN inume as umpro ON umpro.inumeCume = inpro.inproCumb
        WHERE intraMdel = 0 And intrdCanb <> 0 And inproCpro = @Cpro
        AND intraCalm IN (46,47,43,7,4,6,5,67)
        AND intraFtra BETWEEN '".$fini."' AND '".$ffin."'
        )
        SELECT 
        intrdCpro,
        inproNomb,
        inumeAbre,
        CONVERT(varchar, CAST(ISNULL([46],0) AS decimal(10,4)),1) AS 'AC1',
        CONVERT(varchar, CAST(ISNULL([47],0) AS decimal(10,4)),1) AS 'AC2',
        CONVERT(varchar, CAST(ISNULL([43],0) AS decimal(10,4)),1) AS 'AlmProd',
        CONVERT(varchar, CAST(ISNULL([7],0) AS decimal(10,4)),1) AS 'Ballivian',
        CONVERT(varchar, CAST(ISNULL([4],0) AS decimal(10,4)),1) AS 'Handal',
        CONVERT(varchar, CAST(ISNULL([6],0) AS decimal(10,4)),1) AS 'Mariscal',
        CONVERT(varchar, CAST(ISNULL([5],0) AS decimal(10,4)),1) AS 'Calacoto',
        CONVERT(varchar, CAST(ISNULL([67],0) AS decimal(10,4)),1) AS 'SanMiguel',
        CONVERT(varchar, CAST(ISNULL((ISNULL([46],0)+ISNULL([47],0)+ISNULL([43],0)+ISNULL([7],0)+ISNULL([4],0)+ISNULL([6],0)+ISNULL([5],0)+ISNULL([67],0))/8,0) AS decimal(10,4)),1) AS Promedio
        FROM (
        SELECT *
        FROM cte
        WHERE RN = 1) AS Mov_Prod
        PIVOT (
          SUM(_CostUnit)
          FOR  intraCalm IN ([46],[47],[43],[7],[4],[6],[5],[67])
        ) AS pivotable
        GROUP BY intrdCpro,inproNomb,inumeAbre,[46],[47],[43],[7],[4],[6],[5],[67]
        ";
      $query = DB::connection('sqlsrv')->select(DB::raw($sql_query));
      if($query){
        $array_list[] = $query[0];
      }
    }
    // dd($request->marc);
    $sql_marca = "
      SELECT 
      convert(varchar,maconCcon)+'|'+convert(varchar,maconItem) as maconMarc, 
      maconNomb 
      FROM macon 
      WHERE maconCcon = '113'
      AND maconItem = '".str_replace('113|','',$request->marc)."'
			ORDER BY maconNomb
    ";
    $query_marca = DB::connection('sqlsrv')->select(DB::raw($sql_marca));
    return Datatables::of($array_list)
      ->with([
        "producto" => $query_marca[0],
      ])
      ->make();
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
