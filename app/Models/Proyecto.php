<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class, 'contrato_id')->withDefault(function ($contrato, $proyecto) {
            $contrato->contrato_id = '-';
        });
    }


    public function clase()
    {
        return $this->belongsTo(Clase::class, 'clase_id')->withDefault(function ($clase, $proyecto) {
            $clase->name = '-';
        });
    }

    protected function estadoProyecto(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => trim($value),
            set: fn ($value) => strtoupper(trim($value)),
        );
    }

    public function scopeConstruccion($query)
    {
        return $query->where('estado_proyecto','<>' ,'SERVICIO POSTVENTA');
    }
 
    
}
