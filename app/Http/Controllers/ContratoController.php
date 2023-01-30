<?php

namespace App\Http\Controllers;

use App\Imports\Proyectos\ContratosImport;
use App\Models\CategoriaSAP;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\PersonalCorporativo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contratos = Contrato::with('cliente')->get();
        return inertia('proyectos/contratos/index', ['contratos' => $contratos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nombre_cliente')->get();
        $gerentes = PersonalCorporativo::where('CARGO', 'LIKE', '%GERENTE DE PROYECTO%')->where('GERENCIA', 'CONS')->get();
        return inertia('proyectos/contratos/form', ['clientes' => $clientes, 'gerentes' => $gerentes]);
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
            'contrato_id' => 'required|unique:contratos,contrato_id',
            'objeto' => 'nullable',
            'cliente_id' => 'nullable|numeric',
            'supervisor' => 'nullable',
            'gerente' => 'nullable',
            'tipo_venta' => 'nullable',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
            'moneda:' => 'nullable',
            'precio_venta' => 'nullable|numeric',
            'estado' => 'nullable',
        ]);
        
        if(!$request->has('prevalidate')){
            $validateData['años_ejecucion'] = $this->obtenerAnhos($request->fecha_inicio, $request->fecha_fin);
            Contrato::create($validateData);
        }

        return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function show(Contrato $contrato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function edit(Contrato $contrato)
    {
        $clientes = Cliente::orderBy('nombre_cliente')->get();
        $gerentes = PersonalCorporativo::where('CARGO', 'LIKE', '%GERENTE DE PROYECTO%')->where('GERENCIA', 'CONS')->get();
        return inertia('proyectos/contratos/form', ['clientes' => $clientes, 'gerentes' => $gerentes, 'contrato' => $contrato]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contrato $contrato)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contrato $contrato)
    {
        $contrato->delete();
        return back();
    }


    public function upload(Request $request){
        (new ContratosImport)->import($request->file);
    }



    public function obtenerAnhos($inicio , $fin){
        if(!isset($inicio) || !isset($fin)){
            return '';
        }

        $menor =  Carbon::parse($inicio)->format('Y');
        $mayor = Carbon::parse($fin)->format('Y');

        $i = 0;
        $anhos = ' ';
        while(isset($menor) && isset($mayor) && $menor + $i <= $mayor){
            $anhos .=  ($menor + $i)."; ";
            $i++;
        }
        return trim($anhos, ';');
    }
}
