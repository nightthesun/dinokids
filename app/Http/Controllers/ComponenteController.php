<?php

namespace App\Http\Controllers;

use App\Models\Componente;
use App\Models\Computadora;
use Illuminate\Http\Request;

/**
 * Class ComponenteController
 * @package App\Http\Controllers
 */
class ComponenteController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $componentes = Componente::paginate();

    return view('componente.index', compact('componentes'))
      ->with('i', (request()->input('page', 1) - 1) * $componentes->perPage());
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $componente = new Componente();
    return view('componente.create', compact('componente'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    request()->validate(Componente::$rules);

    $componente = Componente::create($request->all());

    return redirect()->route('componentes.index')
      ->with('success', 'Componente created successfully.');
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $computadoras = Computadora::find($id);
    $componentes = Componente::orderBy('id', 'DESC')
      ->where('id_compu', '=', $id)
      ->paginate(8);

    return view('componente.show', compact('computadoras', 'componentes'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $componente = Componente::find($id);

    return view('componente.edit', compact('componente'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  Componente $componente
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Componente $componente)
  {
    request()->validate(Componente::$rules);

    $componente->update($request->all());

    return redirect()->route('componentes.index')
      ->with('success', 'Componente updated successfully');
  }

  /**
   * @param int $id
   * @return \Illuminate\Http\RedirectResponse
   * @throws \Exception
   */
  public function destroy($id)
  {
    $componente = Componente::find($id)->delete();

    return redirect()->route('componentes.index')
      ->with('success', 'Componente deleted successfully');
  }
}
