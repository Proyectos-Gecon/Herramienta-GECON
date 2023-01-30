<?php

namespace App\Imports\Proyectos;

use App\Models\Clase;
use App\Models\Contrato;
use App\Models\Proyecto;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ProyectosImport implements ToModel, WithHeadingRow, WithUpserts
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Proyecto([
            'casco' => $row['numero_de_casco'] ,
            'name'  => $row['id_nombre_del_proyecto'] ?? null,
            'clase_id' => Clase::where('name', $row['clase'])->first()->id ?? null,
            'contrato_id' => Contrato::where('contrato_id', $row['idcontrato'])->first()->id ?? null,
            'tipo_proyecto' => trim($row['tipo_de_proyecto']) ?? null,
            'codigo_SAP' => $row['idcodigo_sap'] ?? null,
            'estado_proyecto' => trim($row['estado_del_proyecto']) ?? null,
            'siglas_proyecto' => $row['siglas_proyecto'] ?? null,
            'alcance' => trim($row['alcance_del_proyecto']) ?? null,
            'nombre_buque' => $row['nombre_buque'] ?? null,
            // 'supervisor' => $row['numero_casco'],
            // 'gerente' => $row['numero_casco'],
            // 'imagen' => $row['numero_casco'],
        ]);
    }

    
    public function uniqueBy()
    {
        return 'casco';
    }
}
