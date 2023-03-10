<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Parte;
use App\Models\Personal;
use App\Models\PersonalCorporativo;
use Carbon\Carbon;
use Faker\Provider\ar_EG\Person;
use Illuminate\Http\Request;

class NovedadesController extends Controller
{
    public function index(){
        $personals = Personal::
        Join('CORPORATIVA_INTERFACE.dbo.LISTADO_PERSONAL_SAP_ACTIVOS_View2 as l' ,'l.ID', 'user_id')
        ->whereNotIn('user_id', Parte::where('fecha', Carbon::now())->pluck('user_id')->toArray())->with('supervisor', 'division')->orWhere('division_id', null)->get();
        
        $divisiones = Division::orderBy('name')->get();

        return inertia('personal/novedades/Index', ['novedades' => $personals, 'divisiones' => $divisiones]) ;
    }
}
