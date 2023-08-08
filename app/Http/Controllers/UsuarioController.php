<?php

namespace App\Http\Controllers;

use App\User;
use App\Permiso;
use Auth;
use App\Acceso;
use App\Modulo;
use App\SubModulo;
use App\Program;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Perfil;
use DB;

class UsuarioController extends Controller
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
        if(Auth::user()->authorizePermisos(['Usuarios', 'Ver']))
        {
            $query_reg_people = 'SELECT p.id, p.first_name, p.last_name1, p.last_name2, p.ci, p.age, p.birthdate, p.deleted as eliU, t.name as nameT, b.name as nameS,b.deleted as eliSucu
            FROM `reg_people` p
            JOIN `reg_types` t on t.id=p.id_tipo
            JOIN `reg_branch` b ON p.id_branch = b.id
            where  p.deleted=0 and b.deleted=0
            ORDER BY p.id';
             $query_user = 'SELECT *
             FROM `users` u 
             JOIN `reg_people` p  on p.id=u.id_people
             where  u.deleted=0
             ORDER BY p.id';
            $user2 = DB::select($query_user);
            $user = Auth::user();
     
            $usuario=User::orderBy('id','DESC')->get();
            

           
            return view('configuracion.usuario.index',compact('usuario','user2'));      
        }
        else
        {
            return dd('largo de aqui');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {        
        if(Auth::user()->authorizePermisos(['Usuarios', 'Ver']))
        {
            if(Perfil::find($id)->user != NULL)
            { 
                return dd("Este perfil ya tiene usuario"); 
            }
            else
            {
                $perfil = Perfil::find($id);           
                $modulo = Modulo::get();     
            
                return view('auth.register',compact('perfil', 'modulo'));
            }
        }
        else
        {
            return dd('largo de aqui');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {   
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make("123"),
            'val'=> FALSE, 
            'elim'=> 0,
        ]);

        $perfil = Perfil::find($id);
        $perfil->user_id = $user->id;
        $perfil->save();
        $smod = Program::get();
        if($request->permiso)
        {
            foreach($smod as $sm)
            {
                foreach($sm->permisos as $pe)
                {                   
                    if(in_array($sm->id.'.'.$pe->id,$request->permiso))
                    {
                        Acceso:: create([
                            'user_id'=>$user->id,
                            'program_id'=>$sm->id,
                            'permiso_id'=>$pe->id
                        ]);
                    }                         
                }
            }
        }  
        return redirect()->route('usuario.index');
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
    public function edit($id, Request $request)
    {// id de la persona 
       
        $accesos="SELECT * FROM `users` u 
        JOIN `reg_people` p  on p.id=u.id_people
        JOIN `accesos` a  on u.id=a.user_id
        ";
         

         
         
        $user = Auth::user();
        if($user->authorizePermisos(['Usuarios', 'Editar']))
        {           
            
            $ss="SELECT id FROM users where id_people = $id limit 1";
            $ss2 = DB::select($ss);
            $usuario=User::find($ss2[0]->id); 
         
            $modulo = Modulo::get();
            $query_modulo="SELECT m.id as idMO, m.nombre as nomMo, m.desc as decMo, m.icon as icoMo  FROM `modulos` m 
            "; 
            $moduloX = DB::select($query_modulo);
          
            $query_user = "SELECT u.name as userName, p.id as idpersona, p.first_name as nombre, p.last_name1 as apeP, p.last_name2 as apeM, p.ci as CI, p.age as edad, p.birthdate as Fnacimiento,p.gender as genero, c.id as idPais, c.name as namePaid,foto,t.id as idTipo, t.name as nameT,
			b.id as idSucursal, b.name as nameSucm, cc.id as idCiudad, cc.name as nameCC, u.id as idUser, u.name as nameUser  
			,pp.id as idTele,pp.number as numTele,pp.description as descrtiTele,aa.id as idDir,aa.zone as zona, aa.street as calle, aa.number as numeroPuerta
             FROM `users` u 
             JOIN `reg_people` p  on p.id=u.id_people
             join `reg_types` t on t.id=p.id_tipo
			 JOIN `reg_branch` b on p.id_branch=b.id
			 JOIN `reg_country` c on p.nationality=c.id
			 JOIN `reg_city` cc on p.city=cc.id
             JOIN `reg_telephono` pp on pp.id_people=p.id
			 JOIN `reg_address` aa on aa.id_people=p.id 
             where  u.deleted=0 and p.id=$id
             ORDER BY p.id
             LIMIT 1
            " ;
             $userX = DB::select($query_user);
              
             $query_reg_types = 'SELECT * FROM `reg_types` ORDER BY id';
    $reg_types = DB::select($query_reg_types);
    $query_reg_branch = 'SELECT * FROM `reg_branch` ORDER BY id';
    $reg_branch = DB::select($query_reg_branch);

    $query_reg_country = "SELECT * FROM `reg_country` ORDER BY id";
    $query_reg_city = "SELECT * FROM `reg_city` ORDER BY id";
    $reg_country = DB::select($query_reg_country);
    $reg_city = DB::select($query_reg_city);

            $query_telephono ="SELECT * FROM `reg_telephono` where id_people=$id";
            $query_address ="SELECT * FROM `reg_address` where id_people=$id";
            $reg_telephono = DB::select($query_telephono);
            $reg_address = DB::select($query_address);    
             
         
            return view('configuracion.usuario.edit',compact('moduloX','usuario', 'modulo','reg_branch','reg_types','userX','reg_country','reg_city','reg_telephono','reg_address'));
        }
        else
        {
            return dd('largo de aqui');
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
        try {
            $ss="SELECT id FROM users where id_people = $id limit 1";
        $ss2 = DB::select($ss);
      
       
        $user = User::find($ss2[0]->id);
        $smod = Program::get();
        if($request->permiso)
        {
        foreach($smod as $sm)
            {
                foreach($sm->permisos as $pe)
                {
                    
                    if(Acceso::where('user_id', $user->id)
                    ->where ('program_id', $sm->id)
                    ->where('permiso_id', $pe->id)->first())
                    {
                        if(!in_array('G'.$sm->id.'.'.$pe->id,$request->permiso))
                        {
                            $test =Acceso::where('user_id', $user->id)
                            ->where ('program_id', $sm->id)
                            ->where('permiso_id', $pe->id)->delete();
                            //echo($test);
                        } 
                    }    
                    else 
                    {                    
                        if(in_array('G'.$sm->id.'.'.$pe->id,$request->permiso))
                        {
                            $test = Acceso:: create([
                                'user_id'=>$user->id,
                                'program_id'=>$sm->id,
                                'permiso_id'=>$pe->id
                            ]);
                            //echo($test);
                        } 
                    } 
                    /*$test = Acceso::where('user_id', $user->id)
                    ->where ('program_id', $sm->id)
                    ->where('permiso_id', $pe->id); */                
                }
            }
        }
        else
        {
            Acceso::where('user_id', $user->id)->delete();
        } 

        
        $user->save();
        /*Storage::delete($user->foto);
        if($request->foto)
        {
            $path = $request->file('foto')->store('images');
            $user->foto = $path;
            $user->save();
        }*/
        //return dd("XD");
        return redirect()->back()->with('status', 'success');
  
    } catch (\Throwable $th) {
        throw $th;
       
        //return redirect()->route('perfil.create')->with('jsonDatos',$jsonDatos)->with('jsonDatos',$jsonDatos);
            //return view('configuracion.perfiles.create', compact('jsonDatos'));
        return redirect()->back()->with('status', 'error');
     
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
        $userX= "SELECT id FROM users WHERE id_people = $id LIMIT 1
            ";
        $userD = DB::select($userX);
        
        $user = Auth::user()->id;
    
        $fecha_actual = new DateTime();
        $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
        $persona =" SELECT ci FROM reg_people where $id = id limit 1
        ";
        $personaBD=DB::select($persona);
        $ciP=$personaBD[0]->ci;
        $letras = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cadenaAleatoria= substr(str_shuffle($letras), 0, 10);
        
        
        $id_gente= 
       
        DB::table('reg_people')
        ->where('id',($id)) 
        ->update([
         
           'ci' => $cadenaAleatoria.$ciP,
           'deleted_user_id' => $user,
           'deleted_date' => $fecha_actual,
           'deleted' => 1,
           'ci_delete' =>$ciP, 
           
           
         ]);
         $user = User::find($userD[0]->id);
         $user->elim = 1;
         $user->deleted = 1;
         $user->deleted_user_id =Auth::user()->id;
         $user->deleted_date =$fecha_actual;   
         $user->save();
        //$user->delete(); elimina 

    
        return redirect()->back()->with('status', 'delete');
        
     } catch (\Throwable $th) {
        dd ($th);
        return redirect()->back()->with('status', 'error');
        
    }
    }
    public function updatePassword(Request $request)
    {
        $this->validate($request,[
            'mypassword'=>'required|string',
            'password' => 'required|string|min:3|confirmed',
        ]);

        if (Hash::check($request->mypassword, Auth::user()->password)) {
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->val = 1;
            $user->save();
            return redirect()->route('inicio')->with('success','La contrasesa se combio de forma correcta');
        }
        else
        {
            return view('auth.password')->with('message','La contrase actual es incorrecta');
        }
    }
    public function resetPassword($id)
    {
           
          try {
            $userX= "SELECT id FROM users WHERE id_people = $id LIMIT 1
            ";
             $userD = DB::select($userX);
            $user = User::find($userD[0]->id);
            $user->password = Hash::make('123');
            $user->val = 0;
            $user->save();
            return redirect()->back()->with('status', 'success');
          } catch (\Throwable $th) {
            return redirect()->back()->with('status', 'error');
          }
        
       // return redirect()->route('inicio')->with('success','La contrasesa se combio de forma correcta');
    }

    public function BloquearUser(Request $request, $id)
    {
     try {
        $userX= "SELECT id FROM users WHERE id_people = $id LIMIT 1
            ";
            $ban=$request->ban;
       
            if ($ban=="pir") {
                $ban=1;
                } else {
                if($ban=="rip"){
                   $ban=0;     
                }else{
                    return redirect()->back()->with('status', 'error');
                    exit;            
                }

            }
            
        $userD = DB::select($userX);
        $user = Auth::user()->id;
       $user = User::find($userD[0]->id);
         $user->blockead_user = $ban;
         $user->save();
        return redirect()->back()->with('status', 'banned');
        
     } catch (\Throwable $th) {
        
        return redirect()->back()->with('status', 'error');
        
    }
    }
    public function SuperUsuario(Request $request, $id)
    {
       
     try {
        $userX= "SELECT id FROM users WHERE id_people = $id LIMIT 1
            ";
            $super=$request->super;
            
            if ($super==1) {
                $userD = DB::select($userX);
        $user = Auth::user()->id;
       $user = User::find($userD[0]->id);
         $user->super_user = 1;
         $user->save();
        return redirect()->back()->with('status', 'userSuper');
                } else {
                if($super==0){
                    $userD = DB::select($userX);
                    $user = Auth::user()->id;
                   $user = User::find($userD[0]->id);
                     $user->super_user = 0;
                     $user->save();
                    return redirect()->back()->with('status', 'userNormal'); 
                }else{
                    return redirect()->back()->with('status', 'error');
                    exit;            
                }

            }
            
        
        
     } catch (\Throwable $th) {
        
        return redirect()->back()->with('status', 'error');
        
    }
    }
    public function  AumentoUsuario(Request $request, $id)
    {
        
       
     try {
        $userX= "SELECT id,number_modif FROM users WHERE id_people = $id LIMIT 1
            ";
            $userD = DB::select($userX);
            $super=$userD[0]->number_modif;
            
            if ($super==0) {
                $super=$super+1;
             
        $user = Auth::user()->id;
       $user = User::find($userD[0]->id);
         $user->number_modif = $super;
         $user->save();
        return redirect()->back()->with('status', 'aumento0');
                } else {
              
                    return redirect()->back()->with('status', 'aumento1'); 
             

            }
            
        
        
     } catch (\Throwable $th) {
        
        return redirect()->back()->with('status', 'error');
        
    }
    }
   

}
