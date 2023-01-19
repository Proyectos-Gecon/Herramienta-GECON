<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function supervisor(){
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function user(){
        return $this->belongsTo(PersonalCorporativo::class, 'user_id', 'ID');
    }

}
