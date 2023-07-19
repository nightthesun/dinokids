<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modulo;
use App\SubModulo;
use App\Program;
use App\Permiso;

class ModuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modulo = Modulo::get();
        $program = Program::get();
        $submodulo = SubModulo::get();
        $permiso = Permiso::get();
        return view('dev.modulo.index', compact('modulo', 'program', 'permiso', 'submodulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dev.modulo.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->file('foto'))
        {
            $path = $request->file('foto')->store('images');
        }
        else{
            $path = NULL;            
        } 
        $data = $request->validate([
            'nombre' => 'required|max:255',
            'paterno' => 'required',
            'materno' => 'required',
            'fecha_nac' => 'nullable',
            'ci' => 'required|unique:perfils',
            'ci_e' => 'required',
            'unidad_id' => 'required',
            'cargo' => 'nullable',
            'corp_telf' => 'nullable',
            'corp_int' => 'nullable',
            'corp_email' => 'nullable|unique:perfils',
            'area' => 'required',
            'corp_celu' => 'nullable',
            'fecha_ingreso' => 'nullable',
            'dias_vacacion' => 'nullable',
            'telf' => 'nullable',
            'direc' => 'nullable',
            'celu' => 'nullable',
            'email' => 'nullable|unique:perfils',   
        ]);
        $perfil = Perfil::create(          
            $data += ['foto'=>$path]
        );      
        return redirect()->route('perfil.index');
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
    }
}
