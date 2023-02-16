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
            if(Carbon::now()->format('w') == 1){

                $date =Carbon::now()->subDays(2); 
            }
            $date =new Carbon('yesterday'); 
        }

        $divisiones = $this->divisionesConsulta($date);
      
        
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
        ->where('F.CTEDT' , '<>', 0)
        ->orderBy('F.CTEDT')->where('F.CTEDT' , '<', Carbon::now()->addDay(20)->format('Ymd'))->get();
       
        return Inertia::render('Dashboard', [
            'labesDivision' => $labels_divisions,
            'noPresentesDivision' => $noPresentesDivision, 
            'presentesDivision' => $presentesDivision, 
            'usersContratosPorTerminar' => $usersContratosPorTerminar, 
            'totalPresentes' => $totalPresentes, 
            'totalNoPresentes' => $totalNoPresentes , 
            'fecha' => $date->format('l,  d/m/Y'),
            'proyectos' => $proyectos,
            'divisiones' => $divisiones,
            'noRegistrados' => $this->noRegistrados($date),
            'costoMes' => $this->costosMes($date),
        ]); 
    }

    public function personal(Request $request){
        $estado = new Estado();
        $date = Carbon::now();
        $noPresentesDivision = [];
        $presentesDivision = [];
        $totalPresentes = 0;
        $totalNoPresentes = 0;
        
        if ( Carbon::now()->format('G') <  12){
            if(Carbon::now()->format('w') == 1){
                $date =Carbon::now()->subDays(2); 
            }
            $date =new Carbon('yesterday'); 
        }

        if($request->fecha != null){
            $date = Carbon::parse($request->fecha['_value']);
        }
       
        $labels_divisions = Division::whereNotNull('abreiacion')->orderBy('name')->pluck('abreiacion')->toArray();
            
        $partes = Parte::where('fecha', $date)->get();

        $absentismos = Parte::fecha($date)->select("estado", DB::raw("count(*) as cantidad"))->nopresentes()->groupBy('estado')->get();

        $divisiones = $this->divisionesConsulta($date);

        $proyectos = Parte::fecha($date)
        ->select("proyecto", DB::raw("count(*) as cantidad"), DB::raw("SUM(p.costo_d) as costo"))
        ->leftJoin('personals as p' ,'p.user_id', 'partes.user_id')
        ->where('estado', '<>', 'VACAC')
        ->groupBy('proyecto')->get();

        foreach($labels_divisions as $name){
            $noPresentesDivision[$name] = 0;
            $presentesDivision[$name] = 0;
        }
            
        foreach($partes as $parte){
            if($parte->personal->division != null && $parte->personal->division->abreiacion != null){
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
        ->where('F.CTEDT' , '<>', 0)
        ->orderBy('F.CTEDT')->where('F.CTEDT' , '<', Carbon::now()->addDay(20)->format('Ymd'))->get();

        
       
        return Inertia::render('personal/Dashboard', [  
            'noPresentesDivision' => $noPresentesDivision, 
            'labesDivision' => $labels_divisions,
            'presentesDivision' => $presentesDivision, 
            'usersContratosPorTerminar' => $usersContratosPorTerminar, 
            'totalPresentes' => $totalPresentes, 
            'totalNoPresentes' => $totalNoPresentes , 
            'fecha' => $date->format('d/m/Y'),
            'absentismos' => $absentismos,
            'proyectos' => $proyectos,
            'divsiones' => $divisiones,
            'noRegistrados' => $this->noRegistrados($date),
            'costoMes' => $this->costosMes($date)
        ]); 
    }

    protected function divisionesConsulta($date){
        return Personal::
        select('d.abreiacion as division', DB::raw("SUM(S.BET01) as sum_salarios"), DB::raw("count(p.user_id) as cantidad") )
        ->join('CORPORATIVA_INTERFACE.dbo.LISTADO_PERSONAL_SAP_ACTIVOS_View2 as l' ,'l.ID', 'user_id')
        ->join('CORPORATIVA_INTERFACE.dbo.SALARIO_VIew AS S', 'S.PERNR', 'l.NUM_SAP')
        ->join('divisions as d' , 'd.id', 'personals.division_id')
        ->join('partes as p', 'p.user_id', 'personals.user_id')
        ->where('p.fecha', $date)
        ->groupBy('d.abreiacion')->orderBy('sum_salarios', 'DESC')->get();
    }

    protected function noRegistrados($date){
        return Personal::Join('CORPORATIVA_INTERFACE.dbo.LISTADO_PERSONAL_SAP_ACTIVOS_View2 as l' ,'l.ID', 'user_id')
        ->whereNotIn('user_id', Parte::where('fecha', Carbon::now())->pluck('user_id')->toArray())->count();
    }

    protected  function costosMes($date){
        return PersonalCorporativo::where('GERENCIA', 'CONS')->select(DB::raw("SUM(S.BET01) as sum_salarios"), DB::raw("COUNT(*) as count") )
        ->join('CORPORATIVA_INTERFACE.dbo.SALARIO_VIew AS S', 'S.PERNR', 'NUM_SAP')
        ->orderBy('sum_salarios', 'DESC')->get();
    }
}
