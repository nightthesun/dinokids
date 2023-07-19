<?php

namespace App\Http\Controllers;

use App\RendicionGastosTransporteDataForm;
use App\RendicionGastosTransporteForm;

use App\RendicionFondoFijoDataForm;
use App\RendicionFondoFijoForm;
use Auth;
use Illuminate\Http\Request;

class RendicionGastosTransporteController extends Controller
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
            $forms=RendicionGastosTransporteForm::orderBy('id','DESC')
            ->paginate(8);  

            return view('rendiciongastostransporte_forms',compact('forms'));
        }
        else
        {
            $forms=RendicionGastosTransporteForm::where('user_id', $user->id)->orderBy('id','DESC')
            ->paginate(8);  
            return view('rendiciongastostransporte_forms',compact('forms'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $cont)
    {
        return view("gastostransporte.create", compact('cont'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=Auth::user();
        $form = RendicionGastosTransporteForm::create([
            'user_id'=>Auth::user()->id,
        ]);
        $haber =0;
        for ($i=1; $i <= $request->cont; $i++) 
        { 
            $fecha='fecha'.$i;
            $fecha= date("Y-m-d"); 
            $hora_ini='hora_ini'.$i;
            $hora_ini=$request->$hora_ini;
            $hora_fin='hora_fin'.$i;
            $hora_fin=$request->$hora_fin;
            $centro_c='centro_c'.$i;
            $centro_c=$request->$centro_c;  
            $razon_s='razon_s'.$i;
            $razon_s=$request->$razon_s;
            $motivo='motivo'.$i;
            $motivo=$request->$motivo;
            $monto='monto'.$i;
            $monto=$request->$monto;
            $haber=$haber+$monto;
            if($fecha!=null && $hora_ini!=null && $hora_fin!=null && $centro_c!=null   
            && $razon_s!=null&&$motivo!=null&&$monto!=null)
            {
                $gastos= RendicionGastosTransporteDataForm::create([
                    'fecha'=>$fecha,
                    'hora_ini'=>$hora_ini,
                    'hora_fin'=>$hora_fin,
                    'centro_c'=>$centro_c,
                    'razon_s'=>$razon_s,
                    'motivo'=>$motivo,
                    'monto'=>$monto
                ]);
                $form->gastostransportes()->save($gastos);
            }
            
        }
        if(count(RendicionFondoFijoForm::where("unidad", Auth::user()->perfiles->sucursal)->get()))
        {
            $fondofijo=RendicionFondoFijoForm::where([["unidad", Auth::user()->perfiles->sucursal],['estado', 'activo']])->latest()->first();
            $ultimo = RendicionFondoFijoDataForm::where('fondo_id', $fondofijo->id)->latest()->first();
            $ultim_saldo = $ultimo->saldo;
        }
        else{
            return dd("No Existe Fondo Fijo");
        }            
        $fondofijodata = RendicionFondoFijoDataForm::create([
            'fecha'=>date('Y-m-d'),
            'centro_c'=>Auth::user()->sucursal,
            'cuenta_c'=>"Transporte",
            //'razon_s'=>"Gastos de Movilizacion",
            'concepto'=>"Gastos de Movilizacion",
            //'n_fac'=>"",
            //'n_recib'=>"",
            //'debe'=>$request->debe[$i],
            'haber'=>$haber,
            //'saldo'=>"",
            'user_id'=>Auth::user()->id,
            'fondo_id'=>$fondofijo->id,
            'saldo'=>$ultim_saldo - $haber,

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
        $form = RendicionGastosTransporteForm::find($id);   
        $gastos = $form->gastostransportes; 
        $firma = $form->firmas->where('tipo', 'Superior')->last();
        $firma_rrhh = $form->firmas->where('tipo', 'RRHH')->last();
        return view('detalle.RendicionGastostransporte', compact('form', 'firma', 'firma_rrhh', 'gastos'));
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
