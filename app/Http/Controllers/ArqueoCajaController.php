<?php

namespace App\Http\Controllers;

use App\ArqueoCaja;
use Auth;
use Illuminate\Http\Request;

class ArqueoCajaController extends Controller
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
        $user = Auth::user();
        if(Auth::user()->rol == 'admin')
        {
            $forms=ArqueoCaja::orderBy('id','DESC')
            ->paginate(8);  

            return view('arqueocaja_forms',compact('forms'));
        }
        else
        {
            $forms=ArqueoCajaForm::where('user_id', $user->id)->orderBy('id','DESC')
            ->paginate(8);  
            return view('arqueocaja_forms',compact('forms'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("forms.ArqueoCaja"); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            //'ci'=> 'required|numeric|digits_between:5,20|unique:clientes,ci',
            //'telf' =>'numeric|digits_between:7,8|nullable',
            //'lugar_nac'=> 'required|string|max:2',
            //'nombre'=>'required|string|max:255',
            //'edad'=> 'required|integer|max:100|min:1',
            'unidad'=>'required|string|max:255',
            'moneda'=>'required|string|max:255',
            'responsable'=>'required|string|max:255',
            'caja'=>'required|string|max:255',
            'fecha'=>'required',
            'hora'=>'required',
        ]);
        $arqueo=ArqueoCaja::create([
            'unidad'=>$request->unidad,
            'moneda'=>$request->moneda,
            'responsable'=>$request->responsable,
            'fecha'=>$request->fecha,
            'hora'=>$request->hora,
            'caja'=>$request->caja,
            'cantidad200'=>$request->cantidad200,
            'importe200'=>$request->importe200,
            'cantidad100'=>$request->cantidad100,
            'importe100'=>$request->importe100,
            'cantidad50'=>$request->cantidad50,
            'importe50'=>$request->importe50,
            'cantidad20'=>$request->cantidad20,
            'importe20'=>$request->importe20,
            'cantidad10'=>$request->cantidad10,
            'importe10'=>$request->importe10,
            'BBtotal'=>$request->BBtotal,
            'C5MB'=>$request->C5MB,
            'I5MB'=>$request->I5MB,
            'C2MB'=>$request->C2MB,
            'I2MB'=>$request->I2MB,
            'C1MB'=>$request->C1MB,
            'I1MB'=>$request->I1MB,
            'C05MB'=>$request->C05MB,
            'I05MB'=>$request->I05MB,
            'C02MB'=>$request->C02MB,
            'I02MB'=>$request->I02MB,
            'C01MB'=>$request->C01MB,
            'I01MB'=>$request->I01MB,
            'MBtotal'=>$request->MBtotal,
            'C100BDA'=>$request->C100BDA,
            'I100BDA'=>$request->I100BDA,
            'C50BDA'=>$request->C50BDA,
            'I50BDA'=>$request->I50BDA,
            'C20BDA'=>$request->C20BDA,
            'I20BDA'=>$request->I20BDA,
            'C10BDA'=>$request->C10BDA,
            'I10BDA'=>$request->I10BDA,
            'C5BDA'=>$request->C5BDA,
            'I5BDA'=>$request->I5BDA,
            'DAtotal'=>$request->Datotal,
            'DABtotal'=>$request->DABtotal,
            'OBMtotal'=>$request->OBMtotal,
            'ICC'=>$request->ICC,
            'ICCF'=>$request->ICCF,
            'ICSF'=>$request->ICSF,
            'IOC'=>$request->IOC,
            'CCtotal'=>$request->CCtotal,
            'IDCC'=>$request->IDCC,
            'IDCC1'=>$request->IDCC1,
            'IDCC2'=>$request->IDCC2,
            'IDCC3'=>$request->IDCC3,
            'DCtotal'=>$request->DCtotal,
            'TGB'=>$request->TGB,
            
            'user_id'=>Auth::user()->id,
        ]);
        return redirect()->route('home')->with('success','El formulario se envio correctamente');
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
        $form = ArqueoCaja::find($id);      
        $firma = $form->firmas->where('tipo', 'Superior')->last();
        $firma_rrhh = $form->firmas->where('tipo', 'RRHH')->last();
        return view('detalle.arqueocaja', compact('form', 'firma', 'firma_rrhh'));
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
