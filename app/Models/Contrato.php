<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contrato extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    protected function precioVenta(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value/1000000,0,",","."),
            set: fn ($value) => $value,
        );
    }
   
    protected function moneda(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value == 'US DOLLAR' ? 'USD':'COP',
            set: fn ($value) => strtoupper($value),
        );
    }
   
    public function cliente(){
        return $this->BelongsTo(Cliente::class, 'cliente_id');
    }

    
}
