<?php

namespace App\Http\Controllers;

use App\Imports\Proyectos\ClasesImport;
use App\Models\CategoriaSAP;
use App\Models\Clase;
use Illuminate\Http\Request;

class ClaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clases = Clase::with('proyectos')->orderBy('name')->get();
      
       return inertia('proyectos/clases/index', [
            'clases' => $clases
       ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('proyectos/clases/form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validateData = $request->validate([
            'name' => 'required|unique:clases,name',
            'type' => 'required',
            'empresa_diseñadora' => 'nullable|string',
            'material_casco' => 'nullable|string',
            'eslora' => 'nullable|numeric',
            'manga' => 'nullable|numeric',
            'calado_diseño' => 'nullable|numeric',
            'puntal' => 'nullable|numeric',
            'full_load' => 'nullable|numeric',
            'light_ship' => 'nullable|numeric',
            'potencia_total_kw' => 'nullable|numeric',
            'tipo_propulsion' => 'nullable|string',
            'velocidad' => 'nullable|numeric',
            'autonomias' => 'nullable|numeric',
            'alcance' => 'nullable|numeric',
            'tripulacion_maxima' => 'nullable|numeric',
            'GT' => 'nullable|numeric',
            'CGT' => 'nullable|numeric',
            'render' => 'nullable',
            'bollard_pull' => 'nullable|numeric',
            'clasificacion' => 'nullable|required',
        ]);
        Clase::create($validateData);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clase  $clase
     * @return \Illuminate\Http\Response
     */
    public function show(Clase $clase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clase  $clase
     * @return \Illuminate\Http\Response
     */
    public function edit(Clase $clase)
    {
        return inertia('proyectos/clases/form', ['clase' => $clase]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clase  $clase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clase $clase)
    {
        return "Actualizar";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clase  $clase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clase $clase)
    {
        return back();
    }

    public function upload(Request $request){
           (new ClasesImport)->import($request->file); 
    }
}
