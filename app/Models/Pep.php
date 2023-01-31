<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pep extends Model
{
    use HasFactory;

    public function pep(){
        return  $this->belongsTo(Pep::class, 'pep_id');
    }

    public function peps(){
        return $this->hasMany(Pep::class);
    }

    public function grafos(){
        return $this->hasMany(Grafo::class);
    }

    public function total(){
        return ($this->materiales_presupestados + $this->mano_obra + $this->servicios);
    }
    
    public function calcularMaterialEjecutado(){
        $peps = $this->peps;
        $total=0; 
        $suma = 0;
        if(count($peps) > 0){
            foreach ($peps as $value) { 
                if(count($value->peps) > 0){
                  foreach ($value->peps as $pep) {
                        foreach ($pep->grafos as $grafo) {
                            $suma += $grafo->calcularMaterialEjecutado();
                        }
                        $suma += $pep->materiales_ejecutados;
                  }
                }else{
                    foreach($value->grafos as $g){
                        $suma += $g->calcularMaterialEjecutado();
                    }
                    $suma += $value->materiales_ejecutados;
                }
            }
        }
        foreach($this->grafos as $g){
            $total += $g->calcularMaterialEjecutado();
        }
        return $suma + $total + $this->materiales_ejecutados;
    }

    public function calcularMDOEjecutado(){
        $peps = $this->peps;
        $total=0; 
        $suma = 0;
        if(count($peps) > 0){
            foreach ($peps as $value) { 
                if(count($value->peps) > 0){
                  foreach ($value->peps as $pep) {
                        foreach ($pep->grafos as $grafo) {
                            $suma += $grafo->calcularMDOEjecutado();
                        }
                        $suma += $pep->mano_obra_ejecutados;
                  }
                }else{
                    foreach($value->grafos as $g){
                        $suma += $g->calcularMDOEjecutado();
                    }
                    $suma += $value->mano_obra_ejecutados;
                }
            }
        }
        foreach($this->grafos as $g){
            $total += $g->calcularMDOEjecutado();
        }
       
        return $suma + $total + $this->mano_obra_ejecutados;
    }

    public function calcularServiciojecutado(){
        $peps = $this->peps;
        $total=0; 
        $suma = 0;
        if(count($peps) > 0){
            foreach ($peps as $value) { 
                if(count($value->peps) > 0){
                  foreach ($value->peps as $pep) {
                        foreach ($pep->grafos as $grafo) {
                            $suma += $grafo->calcularServiciojecutado();
                        }
                        $suma += $pep->servicios_ejecutados;
                  }
                }else{
                    foreach($value->grafos as $g){
                        $suma += $g->calcularServiciojecutado();
                    }
                    $suma += $value->servicios_ejecutados;
                }
            }
           
        }
        foreach($this->grafos as $g){
            $total += $g->calcularServiciojecutado();
        }
       
        return $suma + $total + $this->servicios_ejecutados;
    }

    public function TotalEjecutado(){
        return $this->calcularMaterialEjecutado() + $this->calcularServiciojecutado() + $this->calcularMDOEjecutado();
    }

    public function totalejecutar(){
        return $this->materiales_ejecutados + $this->mano_obra_ejecutados + $this->servicios_ejecutados;
    }
    
    public function calcularCPI(){
        return ($this->avance == 0 || $this->TotalEjecutado() == 0) ? 0: $this->total()*  $this->avance/$this->TotalEjecutado();
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
