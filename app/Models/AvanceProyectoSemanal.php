<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvanceProyectoSemanal extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected  $appends = [ 'semana_format' ];
    protected $hidden = ['created_at', 'updated_at'];

    protected function getSemanaFormatAttribute()
    {
        return  substr($this->semana, 0, 2).'-'.substr($this->semana, 2,2);
           
    }
    
}
