<?php

namespace App\Http\Controllers;

use App\Imports\PersonalImport;
use App\Models\Personal;
use App\Models\PersonalCorporativo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Facades\Excel;

class PersonalController extends Controller
{
    public function index(){

        $users = Personal::with('user')->where('supervisor_id' , auth()->user()->id)->get();

        return inertia('personal/ListPersonal', ['users' => $users]);
    }

    public function personalActivos(){
        $personal = Personal::with('user', 'division')->get();
        return inertia('personal/PersonalActivos', ['users' => $personal]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $users = PersonalCorporativo::where('GERENCIA', 'CONS')->get();

        return inertia('personal/AddPersonal', ['users' => $users]);
    }


    public function store(Request $request){
    
        $validateData = $request->validate([
            'users' => 'required|array|distinct',
            'users.*.ID' => 'required',
            'fecha_devolucion' => 'nullable|date|after:yesterday'
        ]);
       
        foreach ($validateData['users'] as $user){
            
            $persona = Personal::firstOrNew([
                'user_id' => $user['ID'],
            ]);
            $persona->supervisor_anterior_id = $persona->supervisor_id;
            $persona->supervisor_id = auth()->user()->id;
            $persona->fecha_devolucion =  Carbon::parse($validateData['fecha_devolucion'])->format('Y-m-d') ?? null;
            $persona->save();
            
        }
        return back();
    }


    public function destroy(PersonalCorporativo $personal)
    {
        $persona = Personal::where([
            'user_id' => $personal->ID,
        ])->first();
        $persona->supervisor_anterior_id = auth()->user()->id;
        $persona->supervisor_id =  2;
        $persona->fecha_devolucion = null;
        $persona->save();
        return redirect()->back();
    }

    public function upload(Request $request){
       Excel::import(new PersonalImport, $request->file);
    }
}
