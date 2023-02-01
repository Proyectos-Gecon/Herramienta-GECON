<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function supervisor(){
        return $this->belongsTo(User::class, 'supervisor_id')->withDefault(function ($supervisor, $personal) {
            $supervisor->name = '-';
        });
    }

    public function user(){
        return $this->belongsTo(PersonalCorporativo::class, 'user_id', 'ID');
    }

    public function division(){
        return $this->belongsTo(Division::class);
    }

    public function parte(){
        return $this->hasOne(Parte::class , 'user_id', 'user_id')->latestOfMany();
        //return $this->hasMany(Parte::class , 'user_id', 'user_id');
    }

    
    protected function costoH(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0,",","."),
            set: fn ($value) => strtoupper(trim($value)),
        );
    }
}
