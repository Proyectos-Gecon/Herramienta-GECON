<?php

namespace App\Models\Almacens;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user(){ 
        return $this->belongsTo(User::class);
    }

    public function padre(){ 
        return $this->belongsTo(Categoria::class , 'categoria_id');
    }
}
