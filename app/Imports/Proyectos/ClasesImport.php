<?php

namespace App\Imports\Proyectos;

use App\Models\Clase;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ClasesImport implements ToModel, WithHeadingRow, WithUpserts
{

    use Importable;
    /**  
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Clase([
            'name' => $row['clase'],
            'type' => $row['tipo_de_buque'] ?? null,
            'empresa_diseñadora' => $row['empresa_diseñadora'] ?? null,
            'material_casco' => $row['material_del_casco'] ?? null,
            'eslora' => $row['eslora_m'] ?? null,
            'manga' => $row['manga_m'] ?? null,
            'calado_diseño' => $row['calado_de_diseño'] ?? null,
            'puntal' => $row['puntal'] ?? null,
            'full_load' => $row['full_load_tons'] ?? null,
            'light_ship' => $row['light_ship_tons'] ?? null,
            'potencia_total_kw' => $row['potencia_total_kw'] ?? null,
            'tipo_propulsion' => $row['tipo_propulsion'] ?? null,
            'velocidad' => $row['velocidad_maxima'] ?? null,
            'autonomias' => $row['autonomia_dias'] ?? null,
            'alcance' => $row['alcance_millas'] ?? null,
            'tripulacion_maxima' => $row['tripulacion'] ?? null,
            'GT' => $row['gt'] ?? null,
            'CGT' => $row['cgt'] ?? null,
            'render' => $row['render_proyecto'] ?? null,
            'bollard_pull' => $row['bollard_pull'] ?? null,
            'clasificacion' => $row['clasificacion'] ?? null,
        ]);
    }

    
    public function uniqueBy()
    {
        return 'name';
    }
}
