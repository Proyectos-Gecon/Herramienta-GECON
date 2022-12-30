<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaSAP extends Model
{
    protected $table = 'clases';
    protected $connection = 'sqlsrv_sap_herramientas';
    protected $guard = 'personal_sap';


    use HasFactory;
    
    protected $hidden = ['imagen', 'clasificacion', 'construido', 'created_at', 'updated_at'];

    
    protected function eslora(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value,2,",","."),
            set: fn ($value) => strtolower($value),
        );
    }
    
}
