<?php

namespace App\Http\Controllers\Almacens;

use App\Http\Controllers\Controller;
use App\Models\Almacens\Almacen;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read almacen')->only('index');
        $this->middleware('role:ADMIN')->only(['store', 'create']);
       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $almacenes = Almacen::get();
        return inertia('almacen/almacens/index', [
            'almacenes' => $almacenes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('almacen/almacens/form');
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
            'nombre_almacen' => 'required|unique:almacens',
            'gerencia_id' => 'required',
            'ubicacion' => 'nullable'
        ]);
        
        Almacen::create($validateData);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function show(Almacen $almacen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function edit(Almacen $almacen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Almacen $almacen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Almacen $almacen)
    {
        //
    }
}
