<?php

namespace App\Models;

use App\Models\Almacens\Equipo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function equipo(){
        return $this->belongsTo(Equipo::class , 'equipo_id');
    }

    public function user(){
        return $this->belongsTo(PersonalCorporativo::class , 'persona_id', 'ID');
    }
    
}
