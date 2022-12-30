<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jefe(){
        return $this->belongsTo(PersonalCorporativo::class, 'jefe_id', 'ID');
    }

    public function planillador(){
        return $this->belongsTo(PersonalCorporativo::class, 'planillador_id' , 'ID');
    }

    public function auxiliares(){
        return $this->hasMany(AuxiliarDivision::class, 'division_id');
    }
}
