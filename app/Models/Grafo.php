<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grafo extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function pep(){
        return  $this->belongsTo(\App\Models\Pep::class, 'pep_id');
    }

    public function operaciones(){
        return $this->hasMany(\App\Models\Operacion::class, 'grafo');
    }

    public function total(){
        return ($this->materiales_presupestados + $this->mano_obra + $this->servicios);
    }


    public function calcularMaterialEjecutado(){
        return  $this->operaciones->sum('materiales_ejecutados') + $this->materiales_ejecutados;
    }
    public function calcularMDOEjecutado(){
        return  $this->operaciones->sum('mano_obra_ejecutados') + $this->mano_obra_ejecutados;
    }
    public function calcularServiciojecutado(){
        return  $this->operaciones->sum('servicios_ejecutados') + $this->servicios_ejecutados;
    }
    public function TotalEjecutado(){
        return $this->calcularMaterialEjecutado() + $this->calcularServiciojecutado() + $this->calcularMDOEjecutado();
    }


    public function calcularCPI(){
        return ($this->TotalEjecutado() == 0 || $this->avance == null) ? 0: $this->total()*$this->avance / $this->TotalEjecutado();
    }

    public function ACxCPI(){
        return $this->calcularCPI() * $this->TotalEjecutado();
    }

    public function BACxCPI(){
        return $this->total()*$this->calcularCPI();
    }
    public function calcularEAC(){
        return ($this->calcularCPI() == 0) ? 0: $this->total()/$this->calcularCPI();
    }

    public function clcularETC(){
        return $this->calcularEAC() - $this->TotalEjecutado();
    }
    public function clcularVAC(){
        return $this->total() - $this->calcularEAC();
    }
    public function calcularEV(){
        return $this->total()*$this->avance;
    }
    public function calcularVc(){
        return $this->calcularEV()-$this->TotalEjecutado();
    }

    public function calcularAvanecePresupuesto(){
        return $this->total() == 0? 0:$this->TotalEjecutado()/$this->total();
    }
  
}
