<?php

namespace App\Http\Controllers;

use App\Imports\PersonalImport;
use App\Models\Division;
use App\Models\Personal;
use App\Models\PersonalCorporativo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Facades\Excel;

class PersonalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('upload');
        $this->middleware('permission:read personal')->only('index');
        $this->middleware('role:USER DEPPC|ADMIN')->only('personalActivos');
    }


    public function index(){

        $users = Personal::
        Join('CORPORATIVA_INTERFACE.dbo.LISTADO_PERSONAL_SAP_ACTIVOS_View2 as l' ,'l.ID', 'user_id')
        ->with('parte')->where('supervisor_id' , auth()->user()->id)->get();
        
        if(auth()->user()->hasAnyRole('JEFE DE DEPARTAMENTO')){
            $users = Personal::
            Join('CORPORATIVA_INTERFACE.dbo.LISTADO_PERSONAL_SAP_ACTIVOS_View2 as l' ,'l.ID', 'user_id')
            ->leftJoin('CORPORATIVA_INTERFACE.dbo.SALARIO_VIew AS S', 'S.PERNR', 'l.NUM_SAP')
            ->with('parte')->where('division_id' , auth()->user()->division_id)->get();
        }
        
        return inertia('personal/ListPersonal', ['users' => $users, 'personal' => User::get()]);
    }

    public function personalActivos(){
        $personal =  PersonalCorporativo::where('GERENCIA', 'LIKE', 'CONS')
        ->select('NUM_SAP', 'APELLIDOS_NOMBRES',  'IDENTIFICACION', 'S.BET01 as salario', 'CARGO' , 'B.PTEXT as tipo_contrato', 'F.CTEDT as fin_contrato', 'F.EINDT as inicio_contrato', 'ID')
        ->leftJoin('BI_T503T_TIPOCONTRATO_View AS B', 'B.PERSK', 'LISTADO_PERSONAL_SAP_ACTIVOS_View2.TIPO_NOMINA')
        ->leftJoin('FECHA_CONTRATO_PA0016_TYPE_View AS F', 'F.PERNR', 'NUM_SAP')
        ->leftJoin('SALARIO_VIew AS S', 'S.PERNR', 'NUM_SAP')
        ->orderBy('APELLIDOS_NOMBRES')->get()
        ;
        $divisiones = Division::get();
        return inertia('personal/PersonalActivos', ['users' => $personal, 'divisiones' => $divisiones]);
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

    public function update(Request $request, Personal $personal){
        $personal->update([
            'division_id' => $request->division_id
        ]);
        return back();
    }
    
    public function getFinContratos($dias){
        $usersContratosPorTerminar = PersonalCorporativo::
        select('APELLIDOS_NOMBRES as name', 'PTEXT as tipo_contrato', 'CTEDT as fecha', 'CTTYP as prorrogas')
        ->where('GERENCIA', 'LIKE', 'CONS')->leftJoin('FECHA_CONTRATO_PA0016_TYPE_View AS F', 'F.PERNR', 'NUM_SAP')
        ->leftJoin('BI_T503T_TIPOCONTRATO_View AS B', 'B.PERSK', 'LISTADO_PERSONAL_SAP_ACTIVOS_View2.TIPO_NOMINA')
        ->where('F.CTEDT' , '<>', 0)
        ->orderBy('F.CTEDT')->where('F.CTEDT' , '<', Carbon::now()->addDay($dias)->format('Ymd'))->get();

        return response()->json(['users' => $usersContratosPorTerminar], 200);
    }

    public function getCostoDivision(){
        
    }

    public function traerPersonal(Request $request){

        $actual = $request->user_actual_supervisor;
        $nuevo = $request->user_nuevo_supervisor;

        $personal = Personal::where('supervisor_id', $actual)->get();
        foreach($personal as $p){
            $p->update([
                'supervisor_id' => $nuevo,
              'supervisor_anterior_id' => $actual,
            ]);
        }
        return back();
    }


}
