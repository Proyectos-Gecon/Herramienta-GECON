<?php

namespace App\Http\Controllers;

use App\Imports\Proyectos\ImportAvanceSemanal;
use App\Models\AvanceProyectoSemanal;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AvanceProyectoSemanalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AvanceProyectoSemanal::orderBy('semana', 'ASC')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        AvanceProyectoSemanal::truncate();
        Excel::import(new ImportAvanceSemanal($request->proyecto), $request->file);       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AvanceProyectoSemanal  $avanceProyectoSemanal
     * @return \Illuminate\Http\Response
     */
    public function show(AvanceProyectoSemanal $avanceProyectoSemanal)
    {
        //
    }

    public function getDataProyecto(Proyecto $proyecto){
     
        $semanas = AvanceProyectoSemanal::where('proyecto_id', $proyecto->id)->pluck('semana')->toArray();
        $planeado = AvanceProyectoSemanal::where('proyecto_id', $proyecto->id)->pluck('avance_planeado')->toArray();
        $ejecutado = AvanceProyectoSemanal::where('proyecto_id', $proyecto->id)->pluck('avance_real')->toArray();

        return response()->json([
            'labels' => $semanas,
            'planeado' => $planeado,
            'ejecutado' => $ejecutado,
        ], 200);
    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AvanceProyectoSemanal  $avanceProyectoSemanal
     * @return \Illuminate\Http\Response
     */
    public function edit(AvanceProyectoSemanal $avanceProyectoSemanal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AvanceProyectoSemanal  $avanceProyectoSemanal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AvanceProyectoSemanal $avanceProyectoSemanal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AvanceProyectoSemanal  $avanceProyectoSemanal
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvanceProyectoSemanal $avanceProyectoSemanal)
    {
        //
    }
}
