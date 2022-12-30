<?php

namespace App\Http\Controllers;

use App\Models\AuxiliarDivision;
use App\Models\Division;
use App\Models\PersonalCorporativo;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisiones = Division::with(['jefe', 'planillador', 'auxiliares.user'])->get();
       
        return inertia('divisiones/index', ['divisiones' => $divisiones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = PersonalCorporativo::get();
        return inertia('divisiones/form', ['users'=> $users]);
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
            'name' => 'required|unique:divisions,name|min:4',
            'jefe_id' => 'required|numeric',
            'planillador_id' => 'required',
            'auxiliares' => 'required|array|distinct'
        ]);

        $division = Division::create([
            'name' => $validateData['name'],
            'jefe_id' => $validateData['jefe_id'],
            'planillador_id' => $validateData['planillador_id'],
        ])->id;
        
        foreach ($validateData['auxiliares'] as  $auxiliar) {
            AuxiliarDivision::create([
                'division_id' => $division,
                'user_id' => $auxiliar
            ]);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function show(Division $division)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Division $division)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(Division $division, Request $request)
    {
        $d = Division::findorFail($request->division);
        $d->delete();
        return back();
    }
}
