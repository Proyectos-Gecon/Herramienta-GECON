<?php

namespace App\Http\Controllers;

use App\Models\Parte;
use App\Models\Personal;
use App\Models\PersonalCorporativo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NovedadesController extends Controller
{
    public function index(){
        $personals = PersonalCorporativo::where('GERENCIA', 'CONS')->whereNotIn('id', Parte::where('fecha', Carbon::now())->pluck('user_id')->toArray())->get();

        return inertia('personal/novedades/Index', ['novedades' => $personals]) ;
    }
}
