<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Parte;
use App\Models\Personal;
use App\Models\PersonalCorporativo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request){
        
   
        $labels_divisions = Division::orderBy('name')->pluck('abreiacion')->toArray();
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
                    $noPresentesDivision[$parte->personal->division->abreiacion] ++;
                    $noPresentesArea[$parte->personal->area_trabajo] ++;
                }else{
                    $presentesDivision[$parte->personal->division->abreiacion] ++;
                    $presentesArea[$parte->personal->area_trabajo] ++;
                }
            }
        }
        $usersContratosPorTerminar = PersonalCorporativo::where('GERENCIA', 'LIKE', 'CONS')->leftJoin('FECHA_CONTRATO_PA0016_TYPE_View AS F', 'F.PERNR', 'NUM_SAP')
        ->leftJoin('BI_T503T_TIPOCONTRATO_View AS B', 'B.PERSK', 'LISTADO_PERSONAL_SAP_ACTIVOS_View2.TIPO_NOMINA')
        ->where('F.CTEDT','LIKE' ,'%'.date("m").'__')->orderBy('F.CTEDT')->where('F.CTEDT' , '<', Carbon::now()->addDay(30)->format('Ymd'))->get();
        
        return Inertia::render('Dashboard', ['noPresentesDivision' => $noPresentesDivision, 'labesDivision' => $labels_divisions,
        'presentesDivision' => $presentesDivision, 'noPresenteArea' => $noPresentesArea, 'PresentesArea' => $presentesArea, 'usersContratosPorTerminar' => $usersContratosPorTerminar]); 
    }
}
