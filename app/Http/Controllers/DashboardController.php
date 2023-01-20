<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Parte;
use App\Models\Personal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request){
        
   
        $labels_divisions = Division::orderBy('name')->pluck('name')->toArray();
        $noPresentesDivision = [];
        $noPresentesArea = [];
        $presentesDivision = [];
        $presentesArea = [];
        $areatrabajos = Personal::groupBy('area_trabajo')->pluck('area_trabajo');
        
        $partes = Parte::where('fecha', Carbon::now())->get();
       
        foreach($labels_divisions as $name){
            $noPresentesDivision[$name] = 0;
            $presentesDivision[$name] = 0;
        }
        foreach($areatrabajos as $name){
            if($name != ''){
                
                $noPresentesArea[$name] = 0;
                $presentesArea[$name] = 0;
            }
        }


        foreach($partes as $parte){
            if($parte->personal->division != null){
                if(!$parte->estaPresente()){
                    $noPresentesDivision[$parte->personal->division->name] ++;
                    $noPresentesArea[$parte->personal->area_trabajo] ++;
                }else{
                    $presentesDivision[$parte->personal->division->name] ++;
                    $presentesArea[$parte->personal->area_trabajo] ++;
                }
            }
        }
        return Inertia::render('Dashboard', ['noPresentesDivision' => $noPresentesDivision, 'labes_division' => $labels_divisions,
        'presentesDivision' => $presentesDivision, 'noPresenteArea' => $noPresentesArea, 'PresentesArea' => $presentesArea]); 
    }
}
