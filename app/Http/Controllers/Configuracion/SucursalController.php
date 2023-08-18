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
//use DB;
use Illuminate\Support\Facades\DB;
use Session;
use App\VacacionForm;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;
use Illuminate\Support\Facades\Hash;
class SucursalController extends Controller
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
        
    if (Auth::user()->authorizePermisos(['Sucursal', 'Ver'])) {
        
        $query_reg_branch = 'SELECT a.id, a.name as nameDres, a.description as descripS, a.deleted as elim
       FROM `reg_branch` a
       ORDER BY a.id ';
       
            
            $branch = DB::select($query_reg_branch);
     
            $user = Auth::user();
     
            $usuario=User::orderBy('id','DESC')->get();
            return view('configuracion.sucursal.index',compact('usuario','user','branch'));  
      
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
        
         return view('configuracion.sucursal.create', compact('var'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->zone == null || $request->street== null || $request->number == null || $request->numberCell== null){
            $mensajeError = 'Ocurrió un error al procesar la solicitud, revice los telefono o la dirección. Por favor, inténtalo de nuevo.';
            Session::flash('error', $mensajeError);
            return redirect()->back();
            exit;
          }
        
          
          try {
           
            $user = Auth::user()->id;
          
          $fecha_actual = new DateTime();
          $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
         
          
         $data = $request->validate([
            'name' => 'required|max:255',
            'descripcion' => 'nullable',
            
          ]);
      
         $id_gente= DB::table('reg_branch')->insertGetId([
            'name' => $data['name'],
            'description' => $data['descripcion'],
            'created_user_id' => $user,
            'created_date' => $fecha_actual,
            'deleted' => 0,
          ]);
          // Obtener el ID generado en la inserción en la tabla reg_people
          
         
              
          $streetFile=$request->zone;
          $numberFile=$request->numberCell;
          for ($i=0; $i <sizeof($streetFile) ; $i++) { 
            DB::table('reg_address')->insert([
              'zone' => $request->zone[$i],
              'street' => $request->street[$i],
              'number' => $request->number[$i],
              'created_user_id' => $user,
              'created_date' => $fecha_actual,
              'deleted' => 0,
              'id_people'=>$id_gente,
              'descripcion'=>$request->decriptionAddress[$i],
              ]);
          }
        
          for ($i=0; $i <sizeof($numberFile) ; $i++) {
            if($request->description[$i]==null){
                $des="sin datos";
            } else{
                $des=$request->description[$i];
            }
          
            DB::table('reg_telephono')->insert([
              'number' => $request->numberCell[$i],
              'cod' => "+591",
              'description' => $des,
              'created_user_id' => $user,
              'created_date' => $fecha_actual,
              'deleted' => 0,
              'id_people'=>$id_gente,
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
        if (Auth::user()->authorizePermisos(['Sucursal', 'Ver informacion'])) {
        
            $query_reg_branch = " SELECT a.id, a.name as nameDres, a.description as descripS, u.name as creaU,uu.name as modiU,uuu.name as eliU, a.created_date as creaF, a.modified_date as modiF,a.deleted_date as eliF
            FROM `reg_branch` a
			left join users u on  a.created_user_id=u.id	
			left join users uu on  a.modified_user=uu.id	
			left join users uuu on  a.deleted_user_id=uuu.id
            where a.id = '$id'
            ORDER BY a.id limit 1";
           
                
                $branch = DB::select($query_reg_branch);
               
                $user = Auth::user();
         
                $query_telephono ="SELECT * FROM `reg_telephono` where id_people=$id";
      $query_address ="SELECT * FROM `reg_address` where id_people=$id";
      $reg_telephono = DB::select($query_telephono);
      $reg_address = DB::select($query_address); 
                    
                $usuario=User::orderBy('id','DESC')->get();
                return view('configuracion.sucursal.show',compact('usuario','user','branch','reg_telephono','reg_address'));  
          
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
       
        if (Auth::user()->authorizePermisos(['Sucursal', 'Editar'])) {
        
            $query_reg_branch = "SELECT a.id, a.name as nameDres, a.description as descripS
            FROM `reg_branch` a
            where a.id = '$id'
            ORDER BY a.id limit 1";
           
                
                $branch = DB::select($query_reg_branch);
               
                $user = Auth::user();
         
                $query_telephono ="SELECT * FROM `reg_telephono` where id_people=$id";
      $query_address ="SELECT * FROM `reg_address` where id_people=$id";
      $reg_telephono = DB::select($query_telephono);
      $reg_address = DB::select($query_address); 
                    
                $usuario=User::orderBy('id','DESC')->get();
                return view('configuracion.sucursal.edit',compact('usuario','user','branch','reg_telephono','reg_address'));  
          
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
            if($request->zone == null || $request->street== null || $request->number == null || $request->numberCell== null){
              $mensajeError = 'Ocurrió un error al procesar la solicitud, revice los telefono o la dirección. Por favor, inténtalo de nuevo.';
              Session::flash('error', $mensajeError);
              return redirect()->back();
              exit;
            }
          
            
            try {
             
              $user = Auth::user()->id;
            
            $fecha_actual = new DateTime();
            $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
            $data = $request->validate([
                'name' => 'required|max:255',
                'descripcion' => 'nullable',
                
              ]);
          
       
        
           $id_gente= 
           DB::table('reg_branch')
           ->where('id',$id) 
           ->update([
            'name' => $data['name'],
            'description' => $data['descripcion'],
            
              'modified_user' => $user,
              'modified_date' => $fecha_actual,
          
            ]);
                
            $streetFile=$request->zone;
           
            $numberFile=$request->numberCell;
            $ss="SELECT * FROM reg_address where id_people = $id";
            $ss2 = DB::select($ss);
          
            $iDarray=[];
            foreach ($ss2 as $key => $value) {
             array_push($iDarray,$value->id);
              
            }
           
            for ($i=0; $i <sizeof($iDarray) ; $i++) { 
              
            $RR = DB::table('reg_address')
              ->where('id',$iDarray[$i]) 
              ->update([
                'zone' => $request->zone[$i],
                'street' => $request->street[$i],
                'number' => $request->number[$i],
                'modified_user' => $user,
                'modified_date' => $fecha_actual,
                'id_people'=>$id,
                'descripcion'=>$request->decriptionAddress[$i],
                ]);
            }
            $ss="SELECT * FROM reg_telephono where id_people = $id";
            $ss2 = DB::select($ss);
          
            $iDarray=[];
            foreach ($ss2 as $key => $value) {
             array_push($iDarray,$value->id);
              
            }
            for ($i=0; $i <sizeof($iDarray) ; $i++) {
              if($request->description[$i]==null){
                  $des="sin datos";
              } else{
                  $des=$request->description[$i];
              }
          
        
              DB::table('reg_telephono')
              ->where('id',$iDarray[$i]) 
              ->update([
                'number' => $request->numberCell[$i],
                'cod' => "+591",
                'description' => $des,
                'modified_user' => $user,
                'modified_date' => $fecha_actual,
                'id_people'=>$id,
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
          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
        try {
            $querry_sucursal= "SELECT id,deleted FROM reg_branch WHERE id = $id LIMIT 1
                ";
            $sucursalX = DB::select($querry_sucursal);
           
            $user = Auth::user()->id;
            $del=2;
            $fecha_actual = new DateTime();
            $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
            
            if ($sucursalX[0]->deleted==0) {
              $del=1;
            } else {
              $del=0;
            }
            
            $id_gente= 
           
            DB::table('reg_branch')
            ->where('id',($id)) 
            ->update([
              
               'deleted_user_id' => $user,
               'deleted_date' => $fecha_actual,
               'deleted' => $del,
             
             ]);
             DB::table('reg_address')
            ->where('id',($id)) 
            ->update([
              
               'deleted_user_id' => $user,
               'deleted_date' => $fecha_actual,
               'deleted' => $del,
             
             ]);
             DB::table('reg_telephono')
            ->where('id',($id)) 
            ->update([
              
               'deleted_user_id' => $user,
               'deleted_date' => $fecha_actual,
               'deleted' => $del,
             
             ]);
            
        
    
             if ($sucursalX[0]->deleted==0) {
              return redirect()->back()->with('status', 'activate');
             } else {
              return redirect()->back()->with('status', 'delete');
             }
             
           
            
         } catch (\Throwable $th) {
            dd ($th);
            return redirect()->back()->with('status', 'error');
            
        } 
    }
}
