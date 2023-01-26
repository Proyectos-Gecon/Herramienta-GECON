<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Estado;
use App\Models\Parte;
use App\Models\Personal;
use App\Models\PersonalCorporativo;
use App\Models\Proyecto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request){
        $estado = new Estado();
        $date = Carbon::now();
        
        if ( Carbon::now()->format('G') <  12){
            $date =new Carbon('yesterday'); 
        }
      
        
        $labels_divisions = Division::orderBy('name')->pluck('abreiacion')->toArray();
        $noPresentesDivision = [];
        $presentesDivision = [];
        $totalPresentes = 0;
        $totalNoPresentes = 0;

        $areatrabajos = Personal::groupBy('area_trabajo')->pluck('area_trabajo');
        
        $partes = Parte::where('fecha', $date)->get();

    
        $proyectos = Proyecto::where('estado_proyecto', 'CONSTRUCCIÓN')->get();
     
        foreach($labels_divisions as $name){
            $noPresentesDivision[$name] = 0;
            $presentesDivision[$name] = 0;
        }


            
        foreach($partes as $parte){
            if($parte->personal->division != null){
                if(!$parte->estaPresente()){
                    $noPresentesDivision[$parte->personal->division->abreiacion] ++;
                    $totalNoPresentes ++;
                }else{
                    $presentesDivision[$parte->personal->division->abreiacion] ++;
                    $totalPresentes ++;
                }
            }
        }
      
        $usersContratosPorTerminar = PersonalCorporativo::where('GERENCIA', 'LIKE', 'CONS')->leftJoin('FECHA_CONTRATO_PA0016_TYPE_View AS F', 'F.PERNR', 'NUM_SAP')
        ->leftJoin('BI_T503T_TIPOCONTRATO_View AS B', 'B.PERSK', 'LISTADO_PERSONAL_SAP_ACTIVOS_View2.TIPO_NOMINA')
        ->where('F.CTEDT','LIKE' ,'%'.date("m").'__')->orderBy('F.CTEDT')->where('F.CTEDT' , '<', Carbon::now()->addDay(10)->format('Ymd'))->get();
       
        return Inertia::render('Dashboard', [
            'labesDivision' => $labels_divisions,
            'noPresentesDivision' => $noPresentesDivision, 
            'presentesDivision' => $presentesDivision, 
            'usersContratosPorTerminar' => $usersContratosPorTerminar, 
            'totalPresentes' => $totalPresentes, 
            'totalNoPresentes' => $totalNoPresentes , 
            'fecha' => $date->format('l,  d/m/Y'),
            'proyectos' => $proyectos,
        ]); 
    }

    public function personal(Request $request){
        $estado = new Estado();
        $date = Carbon::now();
        
        // if ( Carbon::now()->format('G') <  12){
        //     $date =new Carbon('yesterday'); 
        // }
        $labelsAbsentismos = $estado->estadosTipoGrupo(false);
        
        $labels_divisions = Division::orderBy('name')->pluck('abreiacion')->toArray();
        $noPresentesDivision = [];
        $presentesDivision = [];
        $totalPresentes = 0;
        $totalNoPresentes = 0;
        $tiposAbsentismos = [];
        $areatrabajos = Personal::groupBy('area_trabajo')->pluck('area_trabajo');
        
        $partes = Parte::where('fecha', $date)->get();

        $absentismos = Parte::fecha($date)->select("estado", DB::raw("count(*) as cantidad"))->nopresentes()->groupBy('estado')->get();

        $proyectos = Parte::fecha($date)->select("proyecto", DB::raw("count(*) as cantidad"), DB::raw("SUM('costo_dia') as cantidad"))
        ->leftJoin('personals as p' ,'p.user_id', 'partes.user_id')
        ->presentes()
        ->groupBy('proyecto')->get();
        return $proyectos;
        foreach($labels_divisions as $name){
            $noPresentesDivision[$name] = 0;
            $presentesDivision[$name] = 0;
            
        }
            
        foreach($partes as $parte){
            if($parte->personal->division != null){
                if(!$parte->estaPresente()){
                    $noPresentesDivision[$parte->personal->division->abreiacion] ++;
                    
                    $totalNoPresentes ++;
                }else{
                    $presentesDivision[$parte->personal->division->abreiacion] ++;
                   
                    $totalPresentes ++;
                }
            }
        }
      
        $usersContratosPorTerminar = PersonalCorporativo::where('GERENCIA', 'LIKE', 'CONS')->leftJoin('FECHA_CONTRATO_PA0016_TYPE_View AS F', 'F.PERNR', 'NUM_SAP')
        ->leftJoin('BI_T503T_TIPOCONTRATO_View AS B', 'B.PERSK', 'LISTADO_PERSONAL_SAP_ACTIVOS_View2.TIPO_NOMINA')
        ->where('F.CTEDT','LIKE' ,'%'.date("m").'__')->orderBy('F.CTEDT')->where('F.CTEDT' , '<', Carbon::now()->addDay(10)->format('Ymd'))->get();
       
        return Inertia::render('personal/Dashboard', [
            'noPresentesDivision' => $noPresentesDivision, 
            'labesDivision' => $labels_divisions,
            'presentesDivision' => $presentesDivision, 
            'usersContratosPorTerminar' => $usersContratosPorTerminar, 
            'totalPresentes' => $totalPresentes, 
            'totalNoPresentes' => $totalNoPresentes , 
            'fecha' => $date->format('l,  d/m/Y'),
            'absentismos' => $absentismos,
        ]); 
    }
}
