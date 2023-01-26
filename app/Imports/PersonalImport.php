<?php

namespace App\Imports;

use App\Models\Division;
use App\Models\Personal;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithUpserts;

class PersonalImport implements ToCollection, WithHeadingRow
{

    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            if($row['division_dpto'] != '' && $row['division_dpto'] != null){
            Personal::where(['user_id' => $row['id']])->update([
            
            'division_id' => Division::firstOrCreate([
                'name' => $row['division_dpto']
            ])->id,
            'tipo_contrato' => $row['tipo_de_contrato'],
            'objeto_contrato' => $row['obejto_del_contrato'],
            'area_trabajo' => $row['area_de_trabajo'],
            'costo_h' => $row['costo_hora'],
            'costo_d' => $row['costo_dia'],
            'costo_m' => $row['costo_mes'],  
            ]);
            }
            
      
        }
    }

 
}
