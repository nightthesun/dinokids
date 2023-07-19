<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;

class CuentasPorPagarDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
        $detalle = "
        SELECT
        liqdPNtcp, liqdPImpC, liqdPAcmt, liqXPGlos, CONVERT(date, liqXPFtra) as Fecha
        FROM liqdP
        JOIN liqXP ON liqdPNtra = liqXPNtra
        WHERE liqdPNtcp = ".$request->id."
        AND liqXPMdel = 0
        ORDER BY Fecha
        ";       
        $t_det = DB::connection('sqlsrv')->select(DB::raw($detalle));
        $detalleList = [];
        if($t_det != []){
          $a1 = $t_det[0]->liqdPImpC;
          foreach($t_det as $i => $val){
            $detalleList[] = ["codigo" => $val->liqdPNtcp, "importe" => $a1, "descuento" => $val->liqdPAcmt, "saldo" => $a1 - $val->liqdPAcmt, "glosa" => $val->liqXPGlos, "fecha" => $val->Fecha];
            $a1 = $detalleList[$i]['saldo'];
          }
        }

        return response()->json(['detalle' => $detalleList]);
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
