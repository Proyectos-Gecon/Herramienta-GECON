<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuxiliarDivision extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function user(){
        return $this->belongsTo(PersonalCorporativo::class, 'user_id', 'ID');
    }
}
