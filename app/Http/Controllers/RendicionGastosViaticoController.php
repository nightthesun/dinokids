<?php

namespace App\Http\Controllers;


use Auth;
use App\RendicionGastosViaticoForm;
use App\RendicionGastosViaticoDataForm;
use Illuminate\Http\Request;

class RendicionGastosViaticoController extends Controller
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
            $forms=RendicionGastosViaticoForm::orderBy('id','DESC')
            ->paginate(8);  

            return view('rendiciongastosviatico_forms',compact('forms'));
        }
        else
        {
            $forms=RendicionGastosViaticoForm::where('user_id', $user->id)->orderBy('id','DESC')
            ->paginate(8);  
            return view('rendiciongastosviatico_forms',compact('forms'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("forms.RendicionGastosViatico"); 
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
        $form = RendicionGastosViaticoForm::create([
            'saldo' => $request->saldo,
            'user_id'=>Auth::user()->id,
            'tipo_gasto'=>$request->inlineRadioOptions,
            //'total_asignado'=>0,
            //'saldo_final'=>0,
            //'total_responder'=>0,
        ]);
        
        if(!empty($request->centro_h))
        {
            for ($i=0; $i < count($request->centro_h); $i++) 
            { 
                if($request->fecha_h[$i]!=null&&$request->centro_h[$i]!=null&&
                $request->nrofactura_h[$i]!=null&&$request->nrorecibo_h[$i]!=null&&
                $request->proveedor_h[$i]!=null&&$request->importe_h[$i]!=null&&
                $request->detalle_h[$i]!=null)
                {
                    $gastos= RendicionGastosViaticoDataForm::create([
                        'fecha'=>$request->fecha_h[$i],
                        'centro_c'=>$request->centro_h[$i],
                        'n_fac'=>$request->nrofactura_h[$i],
                        'n_recibo'=>$request->nrorecibo_h[$i],
                        'proveedor'=>$request->proveedor_h[$i],
                        'importe'=>$request->importe_h[$i],
                        'detalle'=>$request->detalle_h[$i],
                        'tipo'=>'h',
                    ]);
                    $form->dataform()->save($gastos);         
                }     
            }
            for ($i=0; $i < count($request->centro_a); $i++) 
            { 
                if($request->fecha_a[$i]!=null&&$request->centro_a[$i]!=null&&
                $request->nrofactura_a[$i]!=null&&$request->nrorecibo_a[$i]!=null&&
                $request->proveedor_a[$i]!=null&&$request->importe_a[$i]!=null&&
                $request->detalle_a[$i]!=null)
                {
                    $gastos= RendicionGastosViaticoDataForm::create([
                        'fecha'=>$request->fecha_a[$i],
                        'centro_c'=>$request->centro_a[$i],
                        'n_fac'=>$request->nrofactura_a[$i],
                        'n_recibo'=>$request->nrorecibo_a[$i],
                        'proveedor'=>$request->proveedor_a[$i],
                        'importe'=>$request->importe_a[$i],
                        'detalle'=>$request->detalle_a[$i],
                        'tipo'=>'a',
                    ]);
                    $form->dataform()->save($gastos);         
                }     
            }
            for ($i=0; $i < count($request->centro_t); $i++) 
            { 
                if($request->fecha_t[$i]!=null&&$request->centro_t[$i]!=null&&
                $request->nrofactura_t[$i]!=null&&$request->nrorecibo_t[$i]!=null&&
                $request->proveedor_t[$i]!=null&&$request->importe_t[$i]!=null&&
                $request->detalle_t[$i]!=null)
                {
                    $gastos= RendicionGastosViaticoDataForm::create([
                        'fecha'=>$request->fecha_t[$i],
                        'centro_c'=>$request->centro_t[$i],
                        'n_fac'=>$request->nrofactura_t[$i],
                        'n_recibo'=>$request->nrorecibo_t[$i],
                        'proveedor'=>$request->proveedor_t[$i],
                        'importe'=>$request->importe_t[$i],
                        'detalle'=>$request->detalle_t[$i],
                        'tipo'=>'t',
                    ]);
                    $form->dataform()->save($gastos);         
                }     
            }
        }

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
