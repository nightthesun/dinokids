<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Role;
use App\Permiso;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
/*no auto login*/
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
/*GATES*/
use Illuminate\Support\Facades\Gate;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function showRegistrationForm()
    {
    if(Auth::user()->authorizePermisos(['crear_users']))
      {
        $permisos=Permiso::orderBy('name','ASC')->get();
        $permisos= $permisos->groupBy('subtipo');
        return view('auth.register',compact('permisos'));
      }
      else
      {
          return dd('largo de aqui');
      }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            //'name' => ['required', 'string', 'max:255'],
            'nombre' => ['required','string', 'max:255'],
            'materno' => ['required','string', 'max:255'],
            'paterno' => ['required','string', 'max:255'],
            'ci'=>['required','numeric','unique:users'],
            //'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //'direc' => ['required','string', 'max:255'],
            //'gps_url' => ['required','string', 'max:255'],
            //'telf'=>['numeric','digits_between:7,8','nullable'],
            //'password' => ['required', 'string', 'min:3', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data, $path)
    {
        $user = User::create([
            'name' => $data['ci'],
            'password' => Hash::make("123"),
            'val'=> FALSE, 
            'rol'=>$data['rol'], 
        ]);
        $permiso = count(Permiso::get());
        //Auth::user()->permisos()->detach();
        for ($i=1; $i <= $permiso; $i++) 
        { 
            if(isset($data['perm'.$i]))
            {
                $user->permisos()->attach(Permiso::where('id', $data['perm'.$i])->first());
            }
        }
        return $user;
    }
    /*NO AUTO LOGIN AFTER REGISTER*/
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        // $this->guard()->login($user); <---AUTO LOGIN
        if ($response = $this->registered($request, $user)) {
            return $response;
        }
        return $request->wantsJson()
                    ? new Response('', 201)
                    : redirect($this->redirectPath());
    }
}
