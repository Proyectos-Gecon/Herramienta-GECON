<?php

namespace App\Http\Controllers\Almacens;

use App\Http\Controllers\Controller;
use App\Models\Almacens\Almacen;
use App\Models\Almacens\Categoria;
use App\Models\Almacens\Equipo;
use App\Models\CategoriaSAP;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Equipo::truncate();
        // $equipos = CategoriaSAP::get();
        // foreach ($equipos as  $value) {
        //     $categoria = Categoria::where('name', $value->name)->first();
        //     if($categoria != null){
        //        Equipo::create([
        //         'responsable' => 1,
        //         'name' => $categoria->name,
        //         'almacen_id' => 1,
        //         'categoria_id' => $categoria->id,
        //         'codigo_interno' => $value->codigo_interno,
        //         'serial' => $value->serial,
        //         'codigo_SAP' => $value->codigo_SAP,
        //         'valor_compra' => $value->valor_compra,
        //         'ubicacion' => $value->ubicacion,
        //         'marca' => $value->marca,
        //         'fecha_ingreso' => $value->fecha_ingreso,
        //         'observaciones' => $value->observaciones,
        //         'es_pequeño' => $value->es_pequeño,
        //         'estado' => $value->estado,
        //         'estado_operativo' => $value->estado_operativo,
        //         'criticidad' => 0,
        //     ]); 
        //     }
            
        // }

        $equipos = Equipo::active()->get();
        return inertia('almacen/equipos/index', [
            'equipos' => $equipos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grupos = Categoria::where('nivel', 'Grupo')->get();
        $subgrupos = Categoria::where('nivel', 'Sub Grupo')->get();
        $categorias = Categoria::where('nivel', 'Descripcion')->get();
        $almacenes = Almacen::get();

        return inertia('almacen/equipos/form', [
            'grupos' => $grupos,
            'subgrupos' => $subgrupos,
            'categorias' => $categorias,
            'almacenes' => $almacenes,
        ]);
    }


    protected function crearCodigo($data){
        $categoria = Categoria::where('id',$data['categoria_id'])->first();
        $equipo =  Equipo::whereHas('categoria.padre', function (Builder $query) use($categoria){
            $query->where('id', $categoria->padre->id);
        })->where("es_pequeño", 0)->latest()->first();
       
        $valor = isset($equipo->codigo_interno) ? substr($equipo->codigo_interno, -3 ,3):0;
        
        return $categoria->padre->padre->letra."".$categoria->padre->letra."".date_format(new DateTime($data['fecha_ingreso']),"y")."01".str_pad(($valor + 1), 3 , '0',STR_PAD_LEFT);
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
            'categoria_id' => 'required|exists:categorias,id',
            'almacen_id' => 'required|exists:almacens,id',
            'serial' => 'required|unique:equipos,serial',
            'codigo_SAP' => 'nullable',
            'valor_compra' => 'required',
            'marca' => 'nullable|numeric',
            'fecha_ingreso' => 'required|date',
            'observacion' => 'nullable'
        ]);
        if(!$request->has('prevalidate')){
            $validateData['codigo_interno'] = $this->crearCodigo($validateData);
            $validateData['name'] =Categoria::where('id', $validateData['categoria_id'])->first()->name;
            $validateData['responsable'] = auth()->user()->id;
            $validateData['es_pequeño'] = 0;
            $validateData['criticidad'] = 0;
            return $validateData;
            Equipo::create($validateData);
        }
       
        return redirect()->back();
        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function show(Equipo $equipo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipo $equipo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipo $equipo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipo $equipo)
    {
        //
    }
}
