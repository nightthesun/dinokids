<?php

namespace App\Http\Controllers;

use App\User;
use App\Permiso;
use Auth;
use App\Acceso;
use App\Modulo;
use App\SubModulo;
use App\Program;
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
            $user = Auth::user();
            $usuario=User::orderBy('id','DESC')->get();
            
            return view('configuracion.usuario.index',compact('usuario'));      
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
    {
        $user = Auth::user();
        if($user->authorizePermisos(['Usuarios', 'Editar']))
        {
            $usuario=User::find($id);            
            $modulo = Modulo::get(); 
                               
            return view('configuracion.usuario.edit',compact('usuario', 'modulo'));
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
        $user = User::find($id);
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

        $user->dbiz_user = $request->dbiz_user;
        $user->save();
        /*Storage::delete($user->foto);
        if($request->foto)
        {
            $path = $request->file('foto')->store('images');
            $user->foto = $path;
            $user->save();
        }*/
        //return dd("XD");
        return redirect()->route('usuario.edit', $user->id);
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
        $user = User::find($id);
        $user->password = Hash::make('123');
        $user->val = 0;
        $user->save();
        return redirect()->route('usuario.index');
    }
}
