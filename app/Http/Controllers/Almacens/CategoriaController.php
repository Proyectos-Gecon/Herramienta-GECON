<?php

namespace App\Http\Controllers\Almacens;

use App\Http\Controllers\Controller;
use App\Models\Almacens\Categoria;
use App\Models\CategoriaSAP;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Categoria::truncate();
        // $cas = CategoriaSAP::get();
        // foreach($cas as $c){
        //     $padre = CategoriaSAP::where('id', $c->categoria_id)->first();
        //     Categoria::create([
        //         'user_id' => 1,
        //         'name' => $c->name,
        //         'letra' => $c->letra,
        //         'nivel' => $c->nivel,
        //         'categoria_id' =>  $padre != null ? (Categoria::where('name', $padre->name)->first() != null ? Categoria::where('name', $padre->name)->first()->id:0):0,
        //     ]);
        // }
        $categorias = Categoria::with('padre', 'padre.padre')->has('padre')->has('padre.padre')->where('nivel', 'Descripcion')->orderBy('name')->get();
        return inertia('almacen/categorias/index', ['categorias' => $categorias]);

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
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {
        //
    }
}
