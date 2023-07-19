<?php

namespace App\Http\Controllers;

use Auth;
use App\RendicionGastosDataForm;
use App\RendicionGastosTransporteDataForm;
use App\RendicionFondoFijoForm;
use App\RendicionFondoFijoDataForm;
use Illuminate\Http\Request;
use App\User;
use App\Unidad;

class RendicionFondoFijoController extends Controller
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
            $unidades = Unidad::orderBy('nombre','ASC')->paginate(10); 
            return view('fondofijo.index',compact('unidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("fondofijo.create"); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return dd($request->no_recib);
        $user=Auth::user();
        $form = RendicionFondoFijoForm::create([
            'total_asignado'=>0,
            'saldo_final'=>0,
            'total_reponer'=>0,
            'user_id'=>Auth::user()->perfiles->id,
            'unidad'=>Auth::user()->perfiles->sucursal
        ]);        
        if(!empty($request->saldo))
        {
            for ($i=0; $i < count($request->saldo); $i++) 
            { 
                if($request->fecha[$i]!=null&&$request->centro_c[$i]!=null&&
                $request->cuenta_c[$i]!=null&&$request->razon_s[$i]!=null&&
                $request->concepto[$i]!=null&&$request->n_fac[$i]!=null&&
                $request->n_recib[$i]!=null&&$request->debe[$i]!=null&&
                $request->haber[$i]!=null&&$request->saldo[$i]!=null)
                {
                    $gastos= RendicionFondoFijoDataForm::create([
                        'fecha'=>$request->fecha[$i],
                        'centro_c'=>$request->centro_c[$i],
                        'cuenta_c'=>$request->cuenta_c[$i],
                        'razon_s'=>$request->razon_s[$i],
                        'concepto'=>$request->concepto[$i],
                        'n_fac'=>$request->n_fac[$i],
                        'n_recib'=>$request->n_recib[$i],
                        'debe'=>$request->debe[$i],
                        'haber'=>$request->haber[$i],
                        'saldo'=>$request->saldo[$i],
                        'user_id'=>Auth::user()->id,
                    ]);
                    $form->fondodata()->save($gastos);         
                }     
            }
        }
        return redirect()->route('rendicionfondofijo.edit', $form->id);
        
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
        $users = User::all();
        $form = RendicionFondoFijoForm::where([['unidad_id', $id],['estado',0]])->latest()->first();
        if($form!=null)  
        {
            $data = $form->fondodata->where("estado",0); 
            $valid = $form->fondodata->where("estado",1);  
        }   
        else  
        {
            $form = RendicionFondoFijoForm::create([
                'unidad_id'=>$id,
                'estado'=>0
            ]);                       
            $data = NULL;
            $valid = NULL;
        }   
        $forms = RendicionFondoFijoForm::where([['unidad_id', $id],['estado','=',1]])->paginate();
        return view('fondofijo.edit', compact('form', 'forms', 'data', 'valid', 'users'));
    }
    public function valid_edit($id)
    {
        $form = RendicionFondoFijoForm::find($id);   
        $data = $form->fondodata->where("estado",1); 
        //$firma = $form->firmas->where('tipo', 'Superior')->last();
        //$firma_rrhh = $form->firmas->where('tipo', 'RRHH')->last();
        return view('fondofijo.edit', compact('form', 'data'));
    }
    public function validar($id)
    {
        $disp = RendicionFondoFijoDataForm::find($id);
        $disp->estado = 1;
        $disp->save();
        return redirect()->route('rendicionfondofijo.index');
    }
    public function denegar($id)
    {
        $disp = RendicionFondoFijoDataForm::find($id);
        $disp->estado = 10;
        $disp->save();
        return redirect()->route('rendicionfondofijo.index');
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
        $fondo = RendicionFondoFijoForm::find($id);
        $fondo->user_id = $request->usuario;
        $fondo->save();
        return dd($request);
        return redirect()->route('rendicionfondofijo.edit', $fondo->id);
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
    public function pdf($id)
    {
        $form = RendicionFondoFijoForm::find($id); 
        $data = $form->fondodata;
        //return dd($data);
        //$pdf = app('dompdf.wrapper');
        //return storage_path("fonts/light.ttf");
        $pdf = \PDF::setPaper('letter','landscape')->loadView('fondofijo.pdf', compact('form', 'data'));
        return $pdf->stream('archivo.pdf');
    }
}
