<?php

namespace App\Models\Almacens;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $guarded = [];

    
    public function categoria(){ 
        return $this->belongsTo(Categoria::class , 'categoria_id');
    }

    public function scopeActive($query)
    {
        return $query->where('estado_operativo', '<>','BAJA');
    }
    
}
