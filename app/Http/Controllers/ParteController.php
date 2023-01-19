<?php

namespace App\Http\Controllers;

use App\Models\Parte;
use App\Models\Estado;
use App\Models\PersonalCorporativo;
use App\Models\Proyecto;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;

class ParteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = PersonalCorporativo::whereIn('ID' , auth()->user()->users->pluck('user_id')->toArray())->get();
        $proyectos = Proyecto::construccion()->pluck('name');
        $estados = new Estado();
        
        return inertia('personal/Parte', ['users' => $users, 'proyectos' => $proyectos, 'estados' => $estados->getEstados()]);
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
        $validateData = $request->validate([
            'users.*.id' => ['required'],
            'users.*.proyecto' => ['required'],
            'users.*.estado' => ['required'],
        ],[
            'users.*.id.required' => 'El Campo id es Obligatorio',
            'users.*.proyecto.required' => 'El Campo Proyecto es Obligatorio',
            'users.*.estado.required' => 'El Campo Estado es Obligatorio'
        ]);
        return $request;
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
