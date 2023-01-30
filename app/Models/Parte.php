<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parte extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(PersonalCorporativo::class, 'user_id', 'ID');
    }

    public function personal(){
        return $this->belongsTo(Personal::class, 'user_id', 'user_id');
    }
   

    public function scopeNopresentes($query){
        $estado = new Estado();
        return $query->whereIn('estado' , $estado->estadosTipo(false));
    }
    public function scopePresentes($query){
        $estado = new Estado();
        return $query->whereIn('estado' , $estado->estadosTipo(true));
    }

    public function grupoEstado(){
        $estado = new Estado();
        return $estado->buscarGrupoEstado($this->estado);
    }
    
    public function estaPresente(){
        $estado = new Estado();
        return $estado->buscarTipoEstado($this->estado);
    }

    public function scopeFecha($query, $fecha){
        return $query->whereDate('fecha', $fecha);
    }
}
