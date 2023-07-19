<?php

namespace App\Http\Controllers;

use App\DataTables\PerfilsDataTable;
use DataTables;
use App\User;
use App\Perfil;
use DB;
class TestController extends Controller
{
    public function index()
    {
        return view('test');
    }

    public function data(Request $request, PerfilsDataTable $dataTable, Perfil $model)
    {
        return DataTables::of($request->all())->make();
        //$user = Auth::user();
        //$usuario=User::with('perfiles')->orderBy('id','DESC')->get();
        //return view('configuracion.usuario.index',compact('usuario')); 
        //$users = Perfil::all()->toArray();
        //return DataTables::of($usuario)->make();
    }
}