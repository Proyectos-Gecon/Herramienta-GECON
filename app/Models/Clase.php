<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['imagen', 'construido', 'created_at', 'updated_at'];

    protected  $appends = [ 'proyectos_count' ];

    protected function eslora(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value,2,",","."),
            set: fn ($value) => strtolower($value),
        );
    }
    protected function manga(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value,2,",","."),
            set: fn ($value) => strtolower($value),
        );
    }

    protected function puntal(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value,2,",","."),
            set: fn ($value) => strtolower($value),
        );
    }
    protected function alcance(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value,0,",","."),
            set: fn ($value) => strtolower($value),
        );
    }

    public function proyectos(){
        return $this->hasMany(Proyecto::class, 'clase_id');
    }

    
    public function getProyectosCountAttribute()
    {
        return count($this->proyectos);
    }
}
