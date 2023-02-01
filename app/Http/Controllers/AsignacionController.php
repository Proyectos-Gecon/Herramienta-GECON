<?php

namespace App\Http\Controllers;

use App\Models\Almacens\Equipo;
use App\Models\Asignacion;
use App\Models\CategoriaSAP;
use App\Models\PersonalCorporativo;
use App\Models\PersonalCorporativoCompleto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsignacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Asignacion::truncate();
        // $prestamos = CategoriaSAP::
        // select('equipos.codigo_interno as equipo' ,'l.ID as user_id',  'prestamos.proyecto_id as proyecto', 'prestamos.observacion as observacion', 'prestamos.fecha_prestamo as fecha', 'prestamos.estado as estado' , 'prestamos.fecha_devolucion as fecha_devolucion', 'la.ID as almacenista')

        // ->leftJoin('users', 'users.id', 'prestamos.persona_id')
        // ->leftJoin('users as almacenista' , 'almacenista.id' , 'prestamos.almacenista_entrega')
        // ->leftJoin('equipos' ,'equipos.id' ,'prestamos.equipo_id')

        // ->Join('CORPORATIVA_INTERFACE.dbo.LISTADO_PERSONAL_SAP_TODOS_View as l' ,'l.IDENTIFICACION', DB::raw('users.identificacion collate Latvian_BIN'))

        // ->Join('CORPORATIVA_INTERFACE.dbo.LISTADO_PERSONAL_SAP_TODOS_View as la' ,'la.IDENTIFICACION', DB::raw('almacenista.identificacion collate Latvian_BIN'))
        

        // ->join('proyectos', 'proyectos.id', 'prestamos.proyecto_id')
        // ->get();
        // foreach ($prestamos as $key => $value) {
        //     if($value->equipo != null){
        //          Asignacion::create([
        //             'equipo_id' => Equipo::where('codigo_interno',$value->equipo)->first()->id ?? 1,
        //             'persona_id' => $value->user_id,
        //             'proyecto_id' => $value->proyecto,
        //             'supervisor_id' => 1,
        //             'almacenista_entrega' => $value->almacenista,
        //             'fecha_prestamo' => $value->fecha,
        //             'ubicacion' => '',
        //             'estado' => $value->estado == 'PRESTADO' ? 'ASIGNADO':$value->estado,
        //         ]);
        //     }
           
        // }
        $asignaciones = Asignacion::
        leftJoin('CORPORATIVA_INTERFACE.dbo.LISTADO_PERSONAL_SAP_TODOS_View as l','l.ID', DB::raw('asignacions.persona_id'))
        ->with('equipo')->orderBy('fecha_prestamo', 'DESC')->whereEstado('ASIGNADO')->get();
      
        return inertia('almacen/asignaciones/Index', [
            'asignaciones' => $asignaciones
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asignacion  $asignacion
     * @return \Illuminate\Http\Response
     */
    public function show(Asignacion $asignacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asignacion  $asignacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Asignacion $asignacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asignacion  $asignacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asignacion $asignacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asignacion  $asignacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asignacion $asignacion)
    {
        //
    }
}
