<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Perfil;
use App\Permiso;
use App\Modulo;
use App\SubModulo;
use App\Program;
use Illuminate\Support\Facades\Storage;
use App\Unidad;
use DateTime;

use Illuminate\Support\Facades\DB;
use Session;
use App\VacacionForm;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;



class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->authorizePermisos(['Programa', 'Ver'])) {
        
            $query_reg_programa = 'SELECT *
           FROM `reg_interventionareas` i
           ORDER BY id ';
           
                
                $programa = DB::select($query_reg_programa);
         
                $user = Auth::user();
         
                $usuario=User::orderBy('id','DESC')->get();
                return view('configuracion.programa.index',compact('usuario','user','programa'));  
          
        } else {
          return redirect()->route('errors.permisos');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $var="Existo";
        
        return view('configuracion.programa.create', compact('var'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        if($request->numberCell== null){
            $mensajeError = 'Ocurrió un error al procesar la solicitud, revice de programa o la dirección. Por favor, inténtalo de nuevo.';
            Session::flash('error', $mensajeError);
            return redirect()->back();
            exit;
          }
        
          
          try {
           
            $user = Auth::user()->id;
          
          $fecha_actual = new DateTime();
          $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
         
        
              
         
          $numberFile=$request->numberCell;
         
        
          for ($i=0; $i <sizeof($numberFile) ; $i++) {
            if($request->description[$i]==null){
                $des="sin datos";
            } else{
                $des=$request->description[$i];
            }
          
            DB::table('reg_interventionareas')->insert([
              'interventionarea_name' => $request->numberCell[$i],
              'interventionarea_description' => $des,
              'created_user_id' => $user,
              'created_date' => $fecha_actual,
              'deleted' => 0,
        
              ]);
          }
          
       
      
      
          return redirect()->back()->with('status', 'success');
        
        } catch (\Throwable $th) {
            throw $th;
           
            //return redirect()->route('perfil.create')->with('jsonDatos',$jsonDatos)->with('jsonDatos',$jsonDatos);
                //return view('configuracion.perfiles.create', compact('jsonDatos'));
                return redirect()->back()->with('status', 'error');
         
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
        if (Auth::user()->authorizePermisos(['Programa', 'Ver informacion'])) {
        
            $query_reg_interventionareas = "SELECT i.id, i.interventionarea_name , i.interventionarea_description , u.name as creaU,uu.name as modiU,uuu.name as eliU, i.created_date as creaF, i.modified_date as modiF,i.deleted_date as eliF
           
            FROM `reg_interventionareas` i
            left join users u on  i.created_user_id=u.id	
			left join users uu on  i.modified_user=uu.id	
			left join users uuu on  i.deleted_user_id=uuu.id
            where i.id = '$id'
         limit 1";
                $programa = DB::select($query_reg_interventionareas);
                $user = Auth::user();
                $usuario=User::orderBy('id','DESC')->get();
                return view('configuracion.programa.show',compact('usuario','user','programa'));  
          
        } else {
          return redirect()->route('errors.permisos');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->authorizePermisos(['Programa', 'Editar'])) {
        
            $query_reg_interventionareas = "SELECT *
            FROM `reg_interventionareas` i
            where id = '$id'
         limit 1";
                $programa = DB::select($query_reg_interventionareas);
                $user = Auth::user();
                $usuario=User::orderBy('id','DESC')->get();
                return view('configuracion.programa.edit',compact('usuario','user','programa'));  
          
        } else {
          return redirect()->route('errors.permisos');
        }
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
        
        if (Auth::user()->number_modif<=0) {
            return redirect()->back()->with('status', 'edit');
          } else {
            if( $request->numberCell== null){
              $mensajeError = 'Ocurrió un error al procesar la solicitud, revice el programa o la dirección. Por favor, inténtalo de nuevo.';
              Session::flash('error', $mensajeError);
              return redirect()->back();
              exit;
            }
          
            
            try {
             
              $user = Auth::user()->id;
            
            $fecha_actual = new DateTime();
            $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
         
          
       
        
              DB::table('reg_interventionareas')
              ->where('id',$id) 
              ->update([
                'interventionarea_name' => $request->numberCell,
           
                'interventionarea_description' => $request->description,
                'modified_user' => $user,
                'modified_date' => $fecha_actual,
              
                ]);
            
            
          
           
            return redirect()->back()->with('status', 'success');
          
          } catch (\Throwable $th) {
              throw $th;
             
              //return redirect()->route('perfil.create')->with('jsonDatos',$jsonDatos)->with('jsonDatos',$jsonDatos);
                  //return view('configuracion.perfiles.create', compact('jsonDatos'));
                  return redirect()->back()->with('status', 'error');
           
            }
          }
       
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
