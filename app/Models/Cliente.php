<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected  $appends = [ 'proyectos_count' ];
   
    
    public function getProyectosCountAttribute()
    {
        return Proyecto::whereHas('contrato', function ($q){
            $q->where('cliente_id', $this->id);
        })->count();
    }

}
