<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['imagen', 'clasificacion', 'construido', 'created_at', 'updated_at'];

    protected function eslora(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value,2,",","."),
            set: fn ($value) => strtolower($value),
        );
    }
}
