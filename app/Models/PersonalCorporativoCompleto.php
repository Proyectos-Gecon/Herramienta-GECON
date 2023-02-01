<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalCorporativoCompleto extends Model
{
    use HasFactory;
    protected $table = 'LISTADO_PERSONAL_SAP_TODOS_View';
    protected $connection = 'sqlsrv_sap';
    protected $guard = 'personal_sap';

    public function personal(){
        return $this->belongsTo(Personal::class, 'id','user_id');
    }
}
