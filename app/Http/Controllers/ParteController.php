<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Parte;
use App\Models\Estado;
use App\Models\Personal;
use App\Models\PersonalCorporativo;
use App\Models\Proyecto;
use Carbon\Carbon;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = Carbon::now();

        if($request->fecha != null){
            $date = Carbon::parse($request->fecha);
        }
       
        if(auth()->user()->hasAnyRole('ADMIN', 'USER DEPPC', 'JEFE DE DEPARTAMENTO')){
            $parte = Parte::where('fecha', $date)->where('estado', 'LIKE','%'.$request->estado.'%')
            ->leftJoin('personals as p', 'p.user_id', 'partes.user_id')
            ->leftJoin('CORPORATIVA_INTERFACE.dbo.LISTADO_PERSONAL_SAP_ACTIVOS_View2 as l','l.ID', DB::raw('partes.user_id'))
            ->leftJoin('divisions as d' , 'd.id', 'p.division_id')
            ->select('l.NUM_SAP','l.APELLIDOS_NOMBRES','l.IDENTIFICACION', 'p.tipo_contrato', 'p.area_trabajo','l.CARGO', 'estado', 'proyecto', 'truno', 'fecha','d.name as division', 'p.costo_hora', 'p.costo_dia', 'p.costo_mes')->orderBy('l.APELLIDOS_NOMBRES')->get();
         
            $personalSinParte = PersonalCorporativo::where('GERENCIA', 'CONS')->count() - Parte::where('fecha', $date)->count();
        }else{
            $parte = Parte::with('user')->where('fecha', $date)->where(
                'planillador_id', auth()->user()->id)->get();
            $personalSinParte = Personal::where('supervisor_id', auth()->user()->id)->count() - count($parte);
       }
       //$parte = PersonalCorporativo::where('GERENCIA', 'CONS')->whereNotIn('id', Parte::pluck('user_id')->toArray())->get();
       return inertia('personal/index', ['parte' => $parte, 'personalSinParte' => $personalSinParte, 'fecha' => $date->format('d/m/Y'), 'divisiones' => Division::get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = Personal::with('user')->with('parte')->where(
            'supervisor_id', auth()->user()->id
        )->get();
        $parte = Parte::with('user')->where('fecha', Carbon::now())->where(
            'planillador_id', auth()->user()->id)->count();

        $proyectos = Proyecto::construccion()->pluck('name')->toArray();
        $estados = new Estado();
        
        return inertia('personal/Parte', ['users' => $users, 'proyectos' => $proyectos, 'estados' => $estados->getEstados(), 'parte' => $parte]);
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
            'users.*.id' => ['required'],
            'users.*.proyecto' => ['nullable'],
            'users.*.estado' => ['nullable'],
            'users.*.turno' => ['nullable'],
        ],[
            'users.*.id.required' => 'El Campo id es Obligatorio',
            'users.*.estado.required' => 'El Campo Estado es Obligatorio'
        ]);
        foreach ($validateData['users'] as $key => $user) {
           
            $parte = Parte::firstOrNew([
                'user_id' => $user['id'],
                'fecha' => Carbon::now(),
            ]);
            $parte->proyecto = $user['estado'] == 'VACAC' ? '-' : $user['proyecto'];
            $parte->planillador_id = auth()->user()->id;
            $parte->truno = !$user['turno'] ? 'Diurno':'Nocturno';
            $parte->estado = $user['estado'];
            $parte->save();
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parte  $parte
     * @return \Illuminate\Http\Response
     */
    public function show(Parte $parte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parte  $parte
     * @return \Illuminate\Http\Response
     */
    public function edit(Parte $parte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parte  $parte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parte $parte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parte  $parte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parte $parte)
    {
        //
    }
}
