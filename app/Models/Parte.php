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
}
