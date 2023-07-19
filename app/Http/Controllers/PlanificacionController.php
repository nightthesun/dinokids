<?php


namespace App\Http\Controllers;

use Auth;
use App\PlanificacionForm;
use App\DataForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class PlanificacionController extends Controller
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
        //$stor = Storage::disk('public')->put('file.txt', 'Hola como esta');
        //$contents = Storage::get('file.txt');
        //return dd($stor);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $busca = $request->get('busca');
        if(Auth::user()->tienePermiso(21,1))
        {
            $plan=PlanificacionForm::orderBy('fecha', 'DESC')
            ->fecha($busca)
            ->paginate(30);  
            return view("forms.Planificaciones", compact('plan', 'busca'));  
        }
        elseif (Auth::user()->authorizePermisos(['planificacion_p_form'])) 
        {
            $user = Auth::user();
            $plan=PlanificacionForm::orderBy('id', 'DESC')
            ->where([['fecha', '>=', date('Y-m-d')],['user_id', $user->id]])
            ->fechap($busca, $user->id)
            ->paginate(30); 
            return view("forms.Planificaciones", compact('plan' , 'busca'));
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
        if($request->imprev)
        {
            if(date('H:i') > '8:00' || date('H:i')<'16:00')
            {
                    $this->validate($request,[
                        'activ'=>'required|string|max:255',
                    ]);
                $user = Auth::user();
                $plan = PlanificacionForm::create([          
                    'activ'=>$request->activ,  
                    'id_user'=>$user->id,  
                    'fecha'=>date('Y-m-d'),   
                    'user_id'=>$user->id,       
                ]);     
            }
        }
        else
        {
        if(date('H:i') > '13:00' || date('H:i')<'21:00')
            {
                if(date('H:i') > '13:00' || date('H:i')<'21:00')
                {        
                    $this->validate($request,[
                        'activ'=>'required|string|max:255',
                        'fecha'=>'required|after:'.date('Y-m-d'),
                        //'ci'=> 'required|numeric|digits_between:5,20|unique:clientes,ci',
                        //'telf' =>'numeric|digits_between:7,8|nullable',
                        //'lugar_nac'=> 'required|string|max:2',
                        //'nombre'=>'required|string|max:255',
                        //'edad'=> 'required|integer|max:100|min:1',
                        //'ant_oc'=>'nullable','ant_gral'=>'nullable', 'oc_familia'=>'nullable', 'gral_familia'=>'nullable'
                    ]);
                }
                else
                {
                    $this->validate($request,[
                        'activ'=>'required|string|max:255',
                        'fecha'=>'required|after:'.date('Y-m-d'),
                        
                    ]);
                }
                $user = Auth::user();
                $plan = PlanificacionForm::create([          
                    'activ'=>$request->activ,  
                    'id_user'=>$user->id,  
                    'fecha'=>$request->fecha,   
                    'user_id'=>$user->id,       
                ]);     
            }       
        }
        return redirect()->route('planificacion.create')->with('success','El formulario se envio correctamente');
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
        $plan = PlanificacionForm::find($id);

        $plan->coment = $request->coment;
        if($request->est==2)
        { 
            $plan->estado = 0;
        }
        elseif($request->est==1)
        {
            $plan->estado = 1;
        }
        $plan->updated_at=date('Y-m-d H:i:s');
        $plan->save();
        return redirect()->route('planificacion.create')->with('success','El formulario se envio correctamente');
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
    public function nextday(Request $request, $id)
    {
        $plan = PlanificacionForm::find($id);
        $plan->post=1;
        $plan->save();
        $fecha_a = date("Y-m-d",strtotime($plan->fecha."+ 1 days"));
        $user = Auth::user();
            $plan = PlanificacionForm::create([          
                'activ'=>$plan->activ,  
                'user_id'=>$plan->user_id,  
                'fecha'=>$fecha_a,      
                    
            ]);   
        return redirect()->route('planificacion.create')->with('success','El formulario se envio correctamente');
        
    }
    public function finalizar()
    {
        $plan=PlanificacionForm::orderBy('id', 'DESC')
        ->where('fecha', '<=', date('Y-m-d'))
        ->get();
        foreach ($plan as $p) {
            if($p->estado===NULL)
            {
                $p->estado=0;
                $p->post=1;
                $p->coment="El personal no realizo esta tarea";
                $p->save();
            }
            
        }
        return redirect()->route('planificacion.create');

    }
}
