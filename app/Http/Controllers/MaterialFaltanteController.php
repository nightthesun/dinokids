<?php

namespace App\Http\Controllers;

use Auth;
use App\MaterialFaltante;
use Illuminate\Http\Request;

class MaterialFaltanteController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $busca = $request->get('busca');
        if(Auth::user()->authorizePermisos(['materialfaltante_form']))
        {
            $mate=MaterialFaltante::orderBy('id', 'DESC')
            ->paginate(30);  
            return view("materialfaltantes", compact('mate', 'busca'));  
        }
        elseif (Auth::user()->authorizePermisos(['materialfaltante_p_form'])) 
        {
            $user = Auth::user();
            $mate=MaterialFaltante::orderBy('id', 'DESC')
            ->paginate(30); 
            return view("materialfaltantes", compact('mate' , 'busca'));
        } 
        else
        {
            return dd("No tiene permiso para estar aqui");
        }
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
            //'codigo'=>'required|string|max:255',
            'material'=>'required|string|max:255', 
            'coment'=>'required|string|max:255',
            //'cantidad'=>'numeric', 
        ]);
        $user = Auth::user();
        $plan = MaterialFaltante::create([          
            'codigo'=>$request->codigo,  
            'material'=>$request->material, 
            'cantidad'=>$request->cantidad, 
            'coment'=>$request->coment, 
            'motivo'=>$request->motivo,  
            'user_id'=>$user->id,       
        ]);        
        return redirect()->route('materialfaltante.create')->with('success','El formulario se envio correctamente');
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
        $mat=MaterialFaltante::find($id);
        $user = $mat->user;
        return view('detalle.materialfaltantes', compact('mat', 'user'));
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
    public function estado(Request $request, $id)
    {
        $mat=MaterialFaltante::find($id);
        $mat->estados()->create([
            'estado' => $request->estado,
            'descripcion'=>$request->descripcion,
            'user_id'=>Auth::user()->id,
        ]);
        return redirect()->route('materialfaltante.create')->with('success','El formulario se envio correctamente');
    }
}
