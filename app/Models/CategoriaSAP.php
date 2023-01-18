<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaSAP extends Model
{
    protected $table = 'equipos';
    protected $connection = 'sqlsrv_sap_herramientas';
    protected $guard = 'personal_sap';


    use HasFactory;
    
   
    
}
