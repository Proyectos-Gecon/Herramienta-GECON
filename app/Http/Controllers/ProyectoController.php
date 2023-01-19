<?php

namespace App\Http\Controllers;

use App\Imports\Proyectos\ProyectosImport;
use App\Models\CategoriaSAP;
use App\Models\Clase;
use App\Models\Contrato;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyectos = Proyecto::with('contrato', 'clase')->get();
        $construccion = Proyecto::where('estado_proyecto', 'CONSTRUCCIÓN')->count();
        return inertia('proyectos/proyectos/index', ['proyectos' => $proyectos, 'construccion' => $construccion]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clases = Clase::get();
        $contratos = Contrato::get();
        return inertia('proyectos/proyectos/form', ['clases' => $clases, 'contratos' => $contratos]);
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
            'casco' => 'required|unique:proyectos,casco',
            'name' =>  'required|unique:proyectos,name',
            'siglas_proyecto' => 'nullable|string|min:3',
            'clase_id' => 'nullable|exists:clases,id',
            'contrato_id' => 'nullable|exists:contratos,id',
            'tipo_proyecto' => 'nullable|string|min:3',
            'codigo_SAP' => 'nullable|string|min:3',
            'estado_proyecto' => 'nullable|string|min:3',
            'alcance' => 'nullable|string|min:3',
            'nombre_buque' => 'nullable|string|min:3',
        ]);

        if(!$request->prevalidate){
            Proyecto::create($validateData);
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function show(Proyecto $proyecto)
    {
        $p = Proyecto::with('clase', 'contrato', 'contrato.cliente')->where('id' , $proyecto->id)->first();
 
        return inertia('proyectos/proyectos/show', ['proyecto' => $p]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyecto $proyecto)
    {
        $clases = Clase::get();
        $contratos = Contrato::get();
        
        return inertia('proyectos/proyectos/form', ['clases' => $clases, 'contratos' => $contratos, 'proyecto' => $proyecto, 'doubling' => false]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyecto $proyecto)
    {
        $validateData = $request->validate([
            'casco' => 'required|unique:proyectos,casco,'.$proyecto->id,
            'name' =>  'required|unique:proyectos,name,'.$proyecto->id,
            'siglas_proyecto' => 'nullable|string|min:3',
            'clase_id' => 'nullable|exists:clases,id',
            'contrato_id' => 'nullable|exists:contratos,id',
            'tipo_proyecto' => 'nullable|string|min:3',
            'codigo_SAP' => 'nullable|string|min:3',
            'estado_proyecto' => 'nullable|string|min:3',
            'alcance' => 'nullable|string|min:3',
            'nombre_buque' => 'nullable|string|min:3',
        ]);
        $proyecto->update($validateData);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyecto $proyecto)
    {
        $proyecto->delete();
        return back();
    }

    public function upload(Request $request){
        (new ProyectosImport)->import($request->file);
    }

    public function duplicate(Proyecto $proyecto){
        $clases = Clase::get();
        $contratos = Contrato::get();
        
        return inertia('proyectos/proyectos/form', ['clases' => $clases, 'contratos' => $contratos, 'proyecto' => $proyecto, 'doubling' => true]);
    }
}