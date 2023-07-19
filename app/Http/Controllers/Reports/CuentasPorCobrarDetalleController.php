<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;

class CuentasPorCobrarDetalleController extends Controller
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
        liqdCNtcc, liqdcImpC, liqdCAcmt, liqXCGlos, CONVERT(date, liqXCFtra) as Fecha
        FROM liqdC
        JOIN liqXC ON liqdCNtra = liqXCNtra
        WHERE liqdCNtcc = ".$request->id."
        AND liqXCMdel = 0
        ORDER BY Fecha
        ";       
        $t_det = DB::connection('sqlsrv')->select(DB::raw($detalle));
        $detalleList = [];
        if($t_det != []){
          $a1 = $t_det[0]->liqdcImpC;
          foreach($t_det as $i => $val){
            $detalleList[] = ["codigo" => $val->liqdCNtcc, "importe" => $a1, "descuento" => $val->liqdCAcmt, "saldo" => $a1 - $val->liqdCAcmt, "glosa" => $val->liqXCGlos, "fecha" => $val->Fecha];
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
