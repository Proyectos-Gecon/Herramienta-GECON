<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalCorporativo extends Model
{
    use HasFactory;

    protected $table = 'LISTADO_PERSONAL_SAP_ACTIVOS_View2';
    protected $connection = 'sqlsrv_sap';
    protected $guard = 'personal_sap';

    public function personal(){
        return $this->belongsTo(Personal::class, 'id','user_id');
    }

    public function parte(){
        return $this->hasMany(Parte::class , 'user_id', 'ID');
    }

    

}
