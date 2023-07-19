<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CuentasPorCobrarTotalExport;
use PhpParser\Node\Stmt\Foreach_;

class CuentasPorCobrarTotalController extends Controller
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
            --WHERE cxcTrCcbr IN (2,18,19,21,39,40,55,63,64)
            GROUP BY cxcTrCcbr
        ))
        ORDER BY adusrNomb";
    $user = DB::connection('sqlsrv')->select(DB::raw($query));
    return view('reports.cuentasporcobrartotal', compact('user'));
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
    $user_venta = "AND vtvtaCusr IS NULL";
    $cliente_venta = "";
    if ($request->cliente) {
      $cliente = "AND crentNomb LIKE '%" . $request->cliente . "%'";
    }
    if ($request->options) {
      $user = "AND cxcTrCcbr IN (" . implode(",", $request->options) . ")";
    }
    if ($request->exampleRadios == "option1") {
      $fecha_excel = "Entre '" . date("d/m/Y", strtotime($request->fini)) . "' y '" . date("d/m/Y", strtotime($request->ffin)) . "'";
      $fecha = "AND vtvtaFtra BETWEEN '" . date("d/m/Y", strtotime($request->fini)) . "' AND '" . date("d/m/Y", strtotime($request->ffin)) . "'";
    } else {
      $fecha_excel = "Al '" . date("d/m/Y", strtotime($request->fal)) . "'";
      $fecha = "AND vtvtaFtra <= '" . date("d/m/Y", strtotime($request->fal)) . "'";
    }
    $fecha_cons = date("d/m/Y");
    if ($request->gen == "ver") {
      $query1 = "
      SELECT
      cxcTrImpt,
      CASE
      WHEN cobros.liqXCFtra <= DATEADD(DAY,5,venta.vtvtaFtra) then 'cont'
      else 'cred'
      END as Estado,
      CONVERT(date, cobros.liqXCFtra) as Fecha,
      ISNULL(cobros.AcuentaF,0) as 'ACuenta',
      adusrCusr,
      adusrNomb,
      inlocCloc,
      inlocNomb
      INTO #cxc1
      FROM cxcTr
      LEFT JOIN cptra ON cptraNtrI = cxcTrNtrI
      LEFT JOIN inloc ON inlocCloc = cxcTrCloc
      JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cxcTrCcbr AND adusrMdel = 0
      LEFT JOIN crEnt ON crentCent = cxcTrCcto
      LEFT JOIN
      (
          SELECT *
        FROM vtVta
        LEFT JOIN imLvt ON imlvtNvta = vtvtaNtra
        WHERe vtvtaMdel = 0
        " . $fecha . "
      )as venta ON (imLvtNvta = cxcTrNtrI) AND imLvtMdel = 0
      LEFT JOIN
      (
          SELECT liqdCNtcc, liqdCAcmt as AcuentaF, liqXCFtra, liqXCGlos--,SUM(liqdCAcmt) as AcuentaF
          FROM liqdC
          JOIN liqXC ON liqdCNtra = liqXCNtra
          WHERE liqXCMdel = 0 
      )as cobros ON cobros.liqdCNtcc = cxcTrNtra
      WHERE cxcTrMdel = 0
      AND (cxcTrImpt - cxcTrAcmt) >= 0.5
      " . $user . "
      " . $cliente . "
      ORDER BY imlvtNvta
    ";
      $insert1 = DB::connection('sqlsrv')->unprepared(DB::raw($query1));
      $movimientos1 = DB::connection('sqlsrv')
        ->select(DB::raw(
          "SELECT
        adusrCusr AS id_usuario_1,
        adusrNomb AS nomb_user_1,
        inlocCloc AS id_local_1,
        inlocNomb AS local_1,
        REPLACE(cast(SUM(ISNULL(cxcTrImpt,0)) as decimal(10,2)),',', '.') AS importeCXC_1,
        REPLACE(cast(SUM(ISNULL(cont,0)) as decimal(10,2)),',', '.') AS cont_1,
        REPLACE(cast(SUM(ISNULL(cred,0)) as decimal(10,2)),',', '.') AS cred_1,
        REPLACE(cast(SUM(ISNULL(cxcTrImpt,0) - ISNULL(cont,0) - ISNULL(cred,0)) as decimal(10,2)),',', '.') AS saldo_1
        FROM (
            SELECT
            Estado,
            ACuenta,
          adusrCusr,
            adusrNomb,
            inlocCloc,
            inlocNomb,
            cxcTrImpt
            FROM #cxc1
            --GROUP BY cxcTrCcto,Cliente,Estado,ACuenta,adusrNomb,inlocNomb,Rsocial,Nit
        ) AS sumcxc
        PIVOT
        (
            SUM(ACuenta)
            FOR Estado IN ([cred],[cont])
        ) AS pivotable
        --where adusrCusr = 46
        GROUP BY adusrCusr,adusrNomb,inlocNomb,inlocCloc
        ORDER BY adusrCusr
        "
        ));
      $query2 = "
      SELECT
      cxcTrNtra,
      cxcTrCcto,
      LTRIM(RTRIM(crentNomb)) AS 'Cliente',
      maprfDplz AS 'DiasPlazo',
      cxcTrImpt,
      CASE
      WHEN cobros.liqXCFtra <= DATEADD(DAY,5,venta.vtvtaFtra) THEN 'cont'
      ELSE 'cred'
      END as Estado,
      CONVERT(DATE, cobros.liqXCFtra) AS Fecha,
      ISNULL(cobros.AcuentaF,0) AS 'ACuenta',
      adusrCusr,
      adusrNomb,
      inlocCloc,
      inlocNomb,
      cxcTrFtra,
      CASE
        WHEN DATEDIFF(DAY, cxcTrFtra, '" . $fecha_cons . "') <= maprfDplz/*DiasPlazo*/ THEN 'VIGENTE'
        WHEN DATEDIFF(DAY, cxcTrFtra, '" . $fecha_cons . "') <= (maprfDplz/*DiasPlazo*/ + 15) THEN 'VENCIDO'
        WHEN DATEDIFF(DAY, cxcTrFtra, '" . $fecha_cons . "') > (maprfDplz/*DiasPlazo*/ + 15) THEN 'MORA'
      END as estado2
      INTO #cxc2
      FROM cxcTr
      LEFT JOIN cptra ON cptraNtrI = cxcTrNtrI
      LEFT JOIN inloc ON inlocCloc = cxcTrCloc
      JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cxcTrCcbr AND adusrMdel = 0
      LEFT JOIN crEnt ON crentCent = cxcTrCcto
      LEFT JOIN maPrf ON crentClsf = maprfCprf
      LEFT JOIN
      (
          SELECT *
        FROM vtVta
        LEFT JOIN imLvt ON imlvtNvta = vtvtaNtra
        WHERe vtvtaMdel = 0
        " . $fecha . "
        )as venta ON (imLvtNvta = cxcTrNtrI) AND imLvtMdel = 0
      LEFT JOIN
      (
        SELECT liqdCNtcc, liqdCAcmt as AcuentaF, liqXCFtra, liqXCGlos--,SUM(liqdCAcmt) as AcuentaF
        FROM liqdC
        JOIN liqXC ON liqdCNtra = liqXCNtra
        WHERE liqXCMdel = 0 
      )as cobros ON cobros.liqdCNtcc = cxcTrNtra
      WHERE cxcTrMdel = 0
      AND (cxcTrImpt - cxcTrAcmt) >= 0.5
      " . $user . "
      " . $cliente . "
    ";
      $insert2 = DB::connection('sqlsrv')->unprepared(DB::raw($query2));
      $movimientos2 = DB::connection('sqlsrv')
        ->select(DB::raw(
          "WITH source AS (
          SELECT
          cxcTrNtra,
          cxcTrCcto,
          Cliente,
          DiasPlazo,
          Estado,
          ACuenta,
          adusrCusr,
          adusrNomb,
          inlocCloc,
          inlocNomb,
          cxcTrImpt,
          estado2
          FROM #cxc2
          ), pivote1 AS (
          SELECT
          cxcTrNtra,
          cxcTrCcto AS id_cliente_2,
          Cliente AS nomb_cliente_2,
          DiasPlazo,
          adusrCusr AS id_usuario_2,
          adusrNomb AS nomb_user_2,
          inlocCloc AS id_local_2,
          inlocNomb AS local_2,
          cxcTrImpt,
          SUM(ISNULL(cont,0)) AS cont_2,
          SUM(ISNULL(cred,0)) AS cred_2,
          SUM(ISNULL(cxcTrImpt,0) - ISNULL(cont,0) - ISNULL(cred,0)) AS saldo_2
          FROM (
              SELECT
            cxcTrNtra,
              cxcTrCcto,
              Cliente,
              DiasPlazo,
              Estado,
              ACuenta,
              adusrCusr,
              adusrNomb,
              inlocCloc,
              inlocNomb,
              ISNULL(cxcTrImpt,0) AS cxcTrImpt
              FROM source
          ) AS sumcxc
          PIVOT
          (
              SUM(ACuenta)
              FOR Estado IN ([cred],[cont])
          ) AS pivotable
          GROUP BY cxcTrNtra,cxcTrCcto,Cliente,adusrCusr,adusrNomb,inlocNomb,inlocCloc,DiasPlazo,cxcTrImpt
          ), pivote2 AS (
          SELECT
          cxcTrNtra,
          cxcTrCcto AS id_cliente_2,
          Cliente AS nomb_cliente_2,
          DiasPlazo,
          adusrCusr AS id_usuario_2,
          adusrNomb AS nomb_user_2,
          inlocCloc AS id_local_2,
          inlocNomb AS local_2,
          REPLACE(cast(cxcTrImpt as decimal(10,2)),',', '.') AS importeCXC_2,
          /*REPLACE(cast(SUM(ISNULL([VIGENTE],0)) as decimal(10,2)),',', '.') AS VIGENTE,
          REPLACE(cast(SUM(ISNULL([VENCIDO],0)) as decimal(10,2)),',', '.') AS VENCIDO,
          REPLACE(cast(SUM(ISNULL([MORA],0)) as decimal(10,2)),',', '.') AS MORA*/
          SUM(ISNULL([VIGENTE],0)) AS VIGENTE,
          SUM(ISNULL([VENCIDO],0)) AS VENCIDO,
          SUM(ISNULL([MORA],0)) AS MORA
          FROM (
              SELECT
              cxcTrNtra,
              cxcTrCcto,
              Cliente,
              DiasPlazo,
              --ACuenta,
              adusrCusr,
              adusrNomb,
              inlocCloc,
              inlocNomb,
              ISNULL(cxcTrImpt,0) AS cxcTrImpt,
              cxcTrImpt - sum(ACuenta) AS saldo_estado,
              estado2
              FROM source
            GROUP BY cxcTrNtra,cxcTrCcto,Cliente,DiasPlazo,adusrCusr,adusrNomb,inlocCloc,inlocNomb,cxcTrImpt,estado2
          ) AS sumcxc
          PIVOT
          (
              SUM(saldo_estado)
              FOR estado2 IN ([VIGENTE],[VENCIDO],[MORA])
          ) AS pivotable
          GROUP BY cxcTrNtra,cxcTrCcto,Cliente,DiasPlazo,adusrCusr,adusrNomb,inlocNomb,inlocCloc,cxcTrImpt
          )
          SELECT
          p1.id_cliente_2 AS id_cliente_2,
          p1.nomb_cliente_2 AS nomb_cliente_2,
          p1.id_usuario_2 AS id_usuario_2,
          p1.nomb_user_2 AS nomb_user_2,
          p1.id_local_2 AS id_local_2,
          p1.local_2 AS local_2,
          p1.DiasPlazo AS DiasPlazo,
          REPLACE(cast(SUM(p1.cxcTrImpt) as decimal(10,2)),',', '.') AS importeCXC_2,
          REPLACE(cast(SUM(ISNULL(p1.cont_2,0)) as decimal(10,2)),',', '.') AS cont_2,
          REPLACE(cast(SUM(ISNULL(p1.cred_2,0)) as decimal(10,2)),',', '.') AS cred_2,
          REPLACE(cast(SUM(ISNULL(p1.saldo_2,0)) as decimal(10,2)),',', '.') AS saldo_2,
          REPLACE(cast(SUM(ISNULL(p2.VIGENTE,0)) as decimal(10,2)),',', '.') AS VIGENTE,
          REPLACE(cast(SUM(ISNULL(p2.VENCIDO,0)) as decimal(10,2)),',', '.') AS VENCIDO,
          REPLACE(cast(SUM(ISNULL(p2.MORA,0)) as decimal(10,2)),',', '.') AS MORA
          FROM pivote1 p1 FULL JOIN pivote2 p2
          ON p1.cxcTrNtra = p2.cxcTrNtra
          GROUP BY p1.id_cliente_2,p1.nomb_cliente_2,p1.id_usuario_2,p1.nomb_user_2,p1.id_local_2,p1.local_2,p1.DiasPlazo
        "
        ));
      $query3 = "
      SELECT
      ISNULL(fechaNR,'-') AS 'fechaNR',
      ISNULL(vtvtaNtra,'-') AS 'vtvtaNtra',
      cxcTrCcto AS 'id_cliente_3',
      Cliente,
      ISNULL(fechaFC,'-') AS 'fechaFC',
      ISNULL(imLvtNrfc,'-') AS 'imLvtNrfc',
      ISNULL(fechaVenc,'-') AS 'fechaVenc',
      ISNULL(Glosa,'-') AS Glosa,
      Rsocial,
      Nit,
      importeCxC,
      ISNULL(fechaAC,'-') AS fechaAC,
      REPLACE(cast(ISNULL(cont,0) as decimal(10,2)),',', '.') AS cont,
      REPLACE(cast(ISNULL(cred,0) as decimal(10,2)),',', '.') AS cred,
      inlocCloc AS 'id_local_3',
      inlocNomb AS 'local_3',
      adusrCusr AS 'id_usuario_3',
      adusrNomb,
      ISNULL(dif_dias_1,'-') AS dif_dias_1,
      ISNULL(dif_dias_2,'-') AS dif_dias_2,
      estado2
      FROM (
        SELECT
        CONVERT(varchar,venta.vtvtaFtra,103) AS fechaNR,
        venta.vtvtaNtra,
        cxcTrCcto,
        crentNomb AS 'Cliente',
        CONVERT(varchar,venta.imLvtFech,103) AS fechaFC,
        venta.imLvtNrfc,
        CONVERT(varchar,cxcTrFtra,103) AS fechaVenc,
        cobros.liqXCGlos AS 'Glosa',
        isnull(imLvtRsoc,'-') AS Rsocial,
        isnull(imLvtNNit,'-') AS Nit,
        cast(cxcTrImpt AS decimal(10,2))AS 'importeCxC',
        CASE
        WHEN cobros.liqXCFtra <= DATEADD(DAY,10,venta.vtvtaFtra) THEN 'cont'
        ELSE 'cred'
        END AS Estado,
        CONVERT(varchar,cobros.liqXCFtra,103) AS fechaAC,
        ISNULL(cobros.AcuentaF,0) AS 'ACuenta',
        inlocCloc,
        inlocNomb,
        adusrCusr,
        adusrNomb,
        DATEDIFF(DAY,venta.vtvtaFtra,cobros.liqXCFtra) AS dif_dias_1,
        DATEDIFF(DAY,venta.vtvtaFtra,'" . $fecha_cons . "') AS dif_dias_2,
        CASE
          WHEN DATEDIFF(DAY, cxcTrFtra, '" . $fecha_cons . "') <= maprfDplz/*DiasPlazo*/ THEN 'VIGENTE'
          WHEN DATEDIFF(DAY, cxcTrFtra, '" . $fecha_cons . "') <= ( maprfDplz/*DiasPlazo*/ + 15) THEN 'VENCIDO'
          WHEN DATEDIFF(DAY, cxcTrFtra, '" . $fecha_cons . "') > ( maprfDplz/*DiasPlazo*/ + 15) THEN 'MORA'
        END as estado2
        FROM cxcTr
        LEFT JOIN cptra ON cptraNtrI = cxcTrNtrI
        LEFT JOIN inloc ON inlocCloc = cxcTrCloc
        LEFT JOIN crEnt ON crentCent = cxcTrCcto
        LEFT JOIN maPrf ON crentClsf = maprfCprf
        JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cxcTrCcbr AND adusrMdel = 0
        LEFT JOIN
        (
        SELECT *
        FROM vtVta
        LEFT JOIN imLvt ON imlvtNvta = vtvtaNtra
        WHERe vtvtaMdel = 0
        " . $fecha . "
        )AS venta ON (imLvtNvta = cxcTrNtrI) AND imLvtMdel = 0
        LEFT JOIN
        (
        SELECT liqdCNtcc, liqdCAcmt AS AcuentaF, liqXCFtra, liqXCGlos--,SUM(liqdCAcmt) as AcuentaF
        FROM liqdC
        JOIN liqXC ON liqdCNtra = liqXCNtra
        WHERE liqXCMdel = 0 
        --GROUP BY liqdCNtcc
        )AS cobros ON cobros.liqdCNtcc = cxcTrNtra
        WHERE cxcTrMdel = 0
        AND (cxcTrImpt - cxcTrAcmt) >= 0.5
        " . $user . "
        " . $cliente . "
      ) AS pivotdetalle
      PIVOT
      (
        SUM(ACuenta)
        FOR Estado IN ([cont],[cred])
      ) AS pivotable
      ORDER BY imLvtNrfc
      ";
      $movimientos3 = DB::connection('sqlsrv')->select(DB::raw($query3));
      $query4 = "
      SELECT
      vtvtdNtra,
      ISNULL(maconNomb,'-') AS maconNomb,
      CASE
        WHEN inproCpro IS NULL THEN sesrvCsrv
        ELSE inproCpro
      END AS codigo,
      CASE
        WHEN inproNomb IS NULL THEN sesrvNomb
        ELSE inproNomb
      END AS descripcion,
      ISNULL(inumeAbre,'-') AS inumeAbre,
      REPLACE(cast(vtvtdCant as decimal(10,0)),',', '.') AS vtvtdCant,
      REPLACE(cast(vtvtdCosT/vtvtdCant as decimal(10,3)),',', '.') AS cost_u,
      REPLACE(cast(vtvtdCosT as decimal(10,3)),',', '.') AS cost_t,
      REPLACE(cast(vtvtdImpT/vtvtdCant as decimal(10,2)),',', '.') AS prec_u,
      REPLACE(cast(vtvtdImpT as decimal(10,2)),',', '.') AS prec_t,
      REPLACE(cast(vtvtdDesT as decimal(10,2)),',', '.') AS desc_t,
      REPLACE(cast(vtvtdDesT*100/vtvtdImpT as decimal(10,2)),',', '.') AS desc_p,
      REPLACE(cast(vtvtdImpT - vtvtdDesT as decimal(10,2)),',', '.') AS total
      FROM vtVta
      LEFT JOIN vtVtd ON vtvtaNtra = vtvtdNtra
      LEFT JOIN cxcTr ON cxcTrNtrI = vtvtaNtra
      LEFT JOIN inpro ON inproCpro = vtvtdCpro
      LEFT JOIN inume ON inumeCume = inproCumb
      LEFT JOIN crEnt ON crentCent = cxcTrCcto
      LEFT JOIN sesrv ON sesrvCsrv = vtvtdCpro
      LEFT JOIN 
      (
          SELECT 
          convert(varchar,maconCcon)+'|'+convert(varchar,maconItem) as maconMarc, 
          maconNomb 
          FROM macon 
          WHERE maconCcon = 113
      ) as marc
      ON inproMarc = maconMarc
      WHERE vtvtaMdel = 0
      AND (cxcTrImpt - cxcTrAcmt) <> 0
      " . $fecha . "
      " . $user . "
      " . $cliente . "
      ";
      $movimientos4 = DB::connection('sqlsrv')->select(DB::raw($query4));
      // dd($movimientos1);
      // dd($movimientos2);
      // dd($movimientos3);
      $test3 = [];
      foreach ($movimientos3 as $key => $value) {
        foreach ($movimientos4 as $i => $j) {
          if ($value->vtvtaNtra == $j->vtvtdNtra) {
            $test3[$value->vtvtaNtra][] = ['maconNomb' => $j->maconNomb, 'codigo' => $j->codigo, 'descripcion' => $j->descripcion, 'inumeAbre' => $j->inumeAbre, 'vtvtdCant' => $j->vtvtdCant, 'cost_u' => $j->cost_u, 'cost_t' => $j->cost_t, 'prec_u' => $j->prec_u, 'prec_t' => $j->prec_t, 'desc_t' => $j->desc_t, 'desc_p' => $j->desc_p, 'total' => $j->total];
          }
        }
      }
      $test3[0] = "";
      $test2 = [];
      foreach ($movimientos2 as $key => $value) {
        foreach ($movimientos3 as $i => $j) {
          if ($value->id_cliente_2 == $j->id_cliente_3 && $value->id_usuario_2 == $j->id_usuario_3 && $value->id_local_2 == $j->id_local_3) {
            $test2[$value->id_cliente_2 . $value->id_usuario_2 . $value->id_local_2][] = ['id_usuario_3' => $j->id_usuario_3, 'fechaNR' => $j->fechaNR, 'vtvtaNtra' => $j->vtvtaNtra, 'fechaFC' => $j->fechaFC, 'imLvtNrfc' => $j->imLvtNrfc, 'fechaVenc' => $j->fechaVenc, 'Glosa' => $j->Glosa, 'Rsocial' => $j->Rsocial, 'Nit' => $j->Nit, 'importeCxC' => $j->importeCxC, 'fechaAC' => $j->fechaAC, 'cont' => $j->cont, 'cred' => $j->cred, 'dif_dias_1' => $j->dif_dias_1, 'dif_dias_2' => $j->dif_dias_2, 'estado2' => $j->estado2, 'vista3' => $test3[$j->vtvtaNtra]];
          }
        }
      }
      foreach ($movimientos1 as $key => $value) {
        // dd($value->id_usuario_1);
        foreach ($movimientos2 as $i => $j) {
          // dd($value->id_usuario_1 == $j->id_usuario_2);
          if ($value->id_usuario_1 == $j->id_usuario_2 && $value->id_local_1 == $j->id_local_2) {
            $test[$value->id_usuario_1 . $value->id_local_1][] = ['id_usuario_2' => $j->id_usuario_2, 'id_cliente_2' => $j->id_cliente_2, 'nomb_cliente_2' => $j->nomb_cliente_2, 'DiasPlazo' => $j->DiasPlazo, 'importeCXC_2' => $j->importeCXC_2, 'cont_2' => $j->cont_2, 'cred_2' => $j->cred_2, 'saldo_2' => $j->saldo_2, 'vigente' => $j->VIGENTE, 'vencido' => $j->VENCIDO, 'mora' => $j->MORA, 'vista2' => $test2[$j->id_cliente_2 . $j->id_usuario_2 . $j->id_local_2]];
          }
        }
      }
      $array = [];
      foreach ($movimientos1 as $key => $value) {
        $array[] = ['id_usuario_1' => $value->id_usuario_1, 'nomb_user_1' => $value->nomb_user_1, 'id_local_1' => $value->id_local_1, 'local_1' => $value->local_1, 'importeCXC_1' => $value->importeCXC_1, 'cont_1' => $value->cont_1, 'cred_1' => $value->cred_1, 'saldo_1' => $value->saldo_1, 'vista1' => $test[$value->id_usuario_1 . $value->id_local_1]];
      }
      // dd($array);

      return view('reports.vista.cuentasporcobrartotal', compact('array'));
    } else if ($request->gen == "excel") {
      $query_excel = "
        SELECT
        ISNULL(fechaNR,'-') AS 'fechaNR',
        ISNULL(vtvtaNtra,'-') AS 'vtvtaNtra',
        cxcTrCcto,
        Cliente,
        ISNULL(fechaFC,'-') AS 'fechaFC',
        ISNULL(imLvtNrfc,'-') AS 'imLvtNrfc',
        ISNULL(fechaVenc,'-') AS 'fechaVenc',
        Glosa,
        Rsocial,
        Nit,
        maprfDplz AS 'DiasPlazo',
        ImporteCXC,
        ISNULL(fechaAC,'-') AS fechaAC,
        REPLACE(cast(ISNULL(cont,0) as decimal(10,2)),',', '.') AS cont,
        REPLACE(cast(ISNULL(cred,0) as decimal(10,2)),',', '.') AS cred,
        inlocNomb,
        adusrNomb,
        ISNULL(dif_dias_1,'-') AS dif_dias_1,
        ISNULL(dif_dias_2,'-') AS dif_dias_2,
        estado2
        FROM (
          SELECT
          CONVERT(varchar,venta.vtvtaFtra,103) AS fechaNR,
          venta.vtvtaNtra,
          cxcTrCcto,
          crentNomb AS 'Cliente',
          CONVERT(varchar,venta.imLvtFech,103) AS fechaFC,
          venta.imLvtNrfc,
          CONVERT(varchar,cxcTrFtra,103) AS fechaVenc,
          cobros.liqXCGlos AS 'Glosa',
          isnull(imLvtRsoc,'-') AS Rsocial,
          isnull(imLvtNNit,'-') AS Nit,
          maprfDplz,
          cast(cxcTrImpt AS decimal(10,2))AS 'ImporteCXC',
          CASE
          WHEN cobros.liqXCFtra <= DATEADD(DAY,10,venta.vtvtaFtra) THEN 'cont'
          ELSE 'cred'
          END AS Estado,
          CONVERT(varchar,cobros.liqXCFtra,103) AS fechaAC,
          ISNULL(cobros.AcuentaF,0) AS 'ACuenta',
          adusrNomb,
          inlocNomb,
          DATEDIFF(DAY,venta.vtvtaFtra,cobros.liqXCFtra) AS dif_dias_1,
          DATEDIFF(DAY,venta.vtvtaFtra,'" . $fecha_cons . "') AS dif_dias_2,
          CASE
            WHEN DATEDIFF(DAY, cxcTrFtra, '" . $fecha_cons . "') <= maprfDplz/*DiasPlazo*/ THEN 'VIGENTE'
            WHEN DATEDIFF(DAY, cxcTrFtra, '" . $fecha_cons . "') <= ( maprfDplz/*DiasPlazo*/ + 15) THEN 'VENCIDO'
            WHEN DATEDIFF(DAY, cxcTrFtra, '" . $fecha_cons . "') > ( maprfDplz/*DiasPlazo*/ + 15) THEN 'MORA'
          END as estado2
          FROM cxcTr
          LEFT JOIN cptra ON cptraNtrI = cxcTrNtrI
          LEFT JOIN inloc ON inlocCloc = cxcTrCloc
          LEFT JOIN crEnt ON crentCent = cxcTrCcto
          LEFT JOIN maPrf ON crentClsf = maprfCprf
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cxcTrCcbr AND adusrMdel = 0
          LEFT JOIN
          (
            SELECT *
            FROM vtVta
            LEFT JOIN imLvt ON imlvtNvta = vtvtaNtra
            WHERe vtvtaMdel = 0
            " . $fecha . "
          )AS venta ON (imLvtNvta = cxcTrNtrI) AND imLvtMdel = 0
          LEFT JOIN
          (
            SELECT liqdCNtcc, liqdCAcmt AS AcuentaF, liqXCFtra, liqXCGlos--,SUM(liqdCAcmt) as AcuentaF
            FROM liqdC
            JOIN liqXC ON liqdCNtra = liqXCNtra
            WHERE liqXCMdel = 0 
            --GROUP BY liqdCNtcc
          )AS cobros ON cobros.liqdCNtcc = cxcTrNtra
          WHERE cxcTrMdel = 0
          AND (cxcTrImpt - cxcTrAcmt) <> 0
          " . $user . "
          " . $cliente . "
        ) AS pivotdetalle
        PIVOT
        (
            SUM(ACuenta)
            FOR Estado IN ([cont],[cred])
        ) AS pivotable
        ORDER BY fechaNR
      ";
      // dd($query_excel);
      $sql_excel = DB::connection('sqlsrv')->select(DB::raw($query_excel));
      $export = new CuentasPorCobrarTotalExport($sql_excel, $fecha_excel);
      return Excel::download($export, 'Cuentas Por Cobrar Total.xlsx');
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
