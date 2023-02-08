<?php

namespace App\Http\Controllers\Almacens;

use App\Http\Controllers\Controller;
use App\Models\Almacens\Equipo;
use App\Models\Asignacion;
use App\Models\CategoriaSAP;
use App\Models\PersonalCorporativo;
use App\Models\PersonalCorporativoCompleto;
use App\Models\Proyecto;
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
        //     if(Equipo::where('codigo_interno',$value->equipo)->first() != null){
        //          Asignacion::create([
        //             'equipo_id' => Equipo::where('codigo_interno',$value->equipo)->first()->id,
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
        $personal = PersonalCorporativo::orderBy('APELLIDOS_NOMBRES')->get();
        $equipos = Equipo::where('estado', 'DISPONIBLE')->whereIN('estado_operativo', ['OPERATIVO', 'OPERATIVA', 'OPERATIVO CON LIMITACIONES'])->get();
        $proyectos = Proyecto::construccion()->get();
        return inertia('almacen/asignaciones/form', [
            'equipos' => $equipos,
            'personal' => $personal,
            'proyectos' => $proyectos,
        ]);
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
            'equipos' => 'required|array|distinct',
            'proyecto_id' => 'required|exists:proyectos,id',
            'persona_id' => 'required',
            'supervisor_id' => 'required',
            'observacion' => 'nullable'
        ]);

        foreach ($validateData['equipos'] as $id) {
            $equipo = Equipo::where('id', $id)->first();
            $asignacion = Asignacion::create([
                'persona_id' => $validateData['persona_id'],
                'equipo_id' => $id,        
                'supervisor_id' => $validateData['supervisor_id'],
                'proyecto_id' => $validateData['proyecto_id'],
                'fecha_prestamo' => Carbon::now(),
                'almacenista_entrega' => auth()->user()->id,
                'ubicacion' => 1,
                'estado' => 'ASIGNADO',
                'observacion' => $validateData['observacion'],
            ]);
        
        }
        return back();
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

    public function descargar(Asignacion $asignacion, Request $request){
        $asignacion->estado = 'DEVUELTO';
        $asignacion->observacion = $request->observacion ?? $asignacion->observacion;
        $asignacion->save();
        $equipo = $asignacion->equipo;
        $equipo->estado_operativo = $request->estado;
        $equipo->estado = 'DISPONIBLE';
        $equipo->save();
    }

    public function buscar($cedula){
        $user = PersonalCorporativo::where('IDENTIFICACION', $cedula)->first();
        if($user == null){
            return back()->withErrors(['msg' => 'Usuario no encontrado']);
        }

        $asignaciones = Asignacion::where('persona_id', $user->ID)
        ->select('e.name as nombre', 'e.serial as serial', 'fecha_prestamo as fecha', 'e.codigo_interno' ,'asignacions.estado as estado')
        ->Join('CORPORATIVA_INTERFACE.dbo.LISTADO_PERSONAL_SAP_ACTIVOS_View2 as l' ,'l.ID', 'persona_id')
        ->Join('equipos as e' ,'e.id', 'equipo_id')
        ->orderBy('estado')
        ->get();

        if(count($asignaciones) == 0){
            return back()->withErrors(['msg' => $user->APELLIDOS_NOMBRES .' no tiene Asignaciones']);
        }


        return inertia('almacen/asignaciones/buscar')->with([
            'user' => $user,
            'asignaciones' => $asignaciones,
            'userLogin' => auth()->user()->id ?? null,
        ]);
    }
}
