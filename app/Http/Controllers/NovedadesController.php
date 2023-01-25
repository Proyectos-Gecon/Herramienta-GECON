<?php

namespace App\Http\Controllers;

use App\Models\Parte;
use App\Models\Personal;
use App\Models\PersonalCorporativo;
use Carbon\Carbon;
use Faker\Provider\ar_EG\Person;
use Illuminate\Http\Request;

class NovedadesController extends Controller
{
    public function index(){
        $personals = Personal::whereNotIn('user_id', Parte::where('fecha', Carbon::now())->pluck('user_id')->toArray())->with('user', 'supervisor', 'division')->orWhere('division_id', null)->get();

        return inertia('personal/novedades/Index', ['novedades' => $personals]) ;
    }
}
