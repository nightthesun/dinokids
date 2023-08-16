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
use Illuminate\Support\Str;


class TutorprincipalController extends Controller
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
        if (Auth::user()->authorizePermisos(['Relacion', 'Ver'])) {
        
        $query_reg_tutor_principals = 'SELECT tp.id, tp.relationship, tp.observatio, tp.previous_tuto
        FROM `reg_tutor_principals` tp
        ORDER BY tp.id ';
               $reg_tutor_principals = DB::select($query_reg_tutor_principals);
         
                $user = Auth::user();
         
                $usuario=User::orderBy('id','DESC')->get();
                return view('configuracion.comunidad.indexRelacion',compact('usuario','user','reg_tutor_principals'));  
          
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

        $randomString = Str::random(5);

        dd("desde create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
