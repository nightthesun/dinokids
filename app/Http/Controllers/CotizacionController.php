<?php

namespace App\Http\Controllers;

use App\DataForm;
use App\CotizacionForm;
use App\CotizacionEstado;
use App\User;
use App\Scan;
//use App\Notification;
use Notification as not;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\Notificaciones;

class CotizacionController extends Controller
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
        if(Auth::user()->tienePermiso(20,1))
        {
        //Auth::user()->permisos();
        $busca = $request->get('busca');
        $cot=CotizacionForm::orderBy('id', 'DESC')
        ->empresa($busca)
        ->paginate(30);      
        return view("forms.Cotizaciones", compact('cot', 'busca'));
        }
        else{
            return dd("no tiene acceso al formulario");
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
            'nit'=> 'numeric|digits_between:5,25',
            'empresa'=>'required|string|max:255',
            'unid'=>'required|string|max:255',
            'nombre_contac'=>'required|string|max:255',
            'descrip'=>'required|string|max:500',
        ]);
        $cotizacion = CotizacionForm::create([
            'OV'=>$request->OV,
            'n_lic'=>$request->n_lic,
            'nit'=>$request->nit,
            'empresa'=>$request->empresa,
            'unid'=>$request->unid,
            'nombre_resp'=>$request->nombre_resp,
            'nombre_contac'=>$request->nombre_contac,
            'telf_contac'=>$request->telf_contac,            
            'descrip'=>$request->descrip,
            'user_id'=>Auth::user()->id,
        ]);   

        $users = User::where('id', '!=' ,auth()->id())->get();
     
        foreach ($users as $v =>$u) {
                $users->forget($v);
        }
        $text = Auth::user()->nombre ." ". Auth::user()->paterno . " registro una cotización: ". $cotizacion->empresa . ".";
        $dat= [
            "text" => $text,
            "url" => 'cotizacion.edit',
            "user_id"=> auth()->id(),
            "cotizacion_id" => $cotizacion->id,
            "permiso" => 'cotizaciones_form',
        ];
        //$recipient->notify(new Notificaciones($invoice));
        //Not::send($users, new Notificaciones($dat));
        //event(new \App\Events\NotificacionEvent($dat, $users));
        $cotizacion->estados()->create([
            'estado' => 'Pendiente',
        ]);
        //$cotizacion->user()->save(Auth::user());     
        return redirect()->route('cotizacion.create')->with('success','El formulario se envio correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cot=CotizacionForm::find($id);
        $user = $cot->user;
        return view('detalle.Cotizaciones', compact('cot', 'user'));
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
            $cot = CotizacionForm::find($id);
            $cot->telf_contac = $request->telf_contac;
            $cot->OV = $request->OV;
            $cot->nit = $request->nit;
            $cot->nombre_resp=$request->nombre_resp;
            $cot->n_lic=$request->n_lic;
            $cot->save();
            return redirect()->route('cotizacion.edit', $cot->id)->with('success','El formulario se envio correctamente');
    }
    public function estado(Request $request, $id)
    {
        $cot=CotizacionForm::find($id);
        $cot->estados()->create([
            'estado' => $request->estado,
            'descripcion'=>$request->descripcion,
        ]);
        return redirect()->route('cotizacion.edit', $cot->id)->with('success','El formulario se envio correctamente');
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
    public function upload(Request $request, $id)
    {
        $cot = CotizacionForm::find($id);
        if($request->coti)
        {
            $path = $request->file('coti')->store('cotizaciones'); 
            $name = $request->file('coti')->getClientOriginalName();
            $ext = $request->file('coti')->extension();
            $scan = Scan::create([
                'scan' => $path,
                'name' =>$name,
                'ext' =>$ext,
            ]);
            $scan->s_cotizaciones()->attach(CotizacionForm::where('id', $cot->id)->first());
        }
        return redirect()->route('cotizacion.create')->with('success','El formulario se envio correctamente');
        //return Storage::download($path);
    }
    public function download(Request $request, $id)
    {
        $scan = Scan::find($id);     
        return Storage::download($scan->scan, $scan->name);
    }
}
