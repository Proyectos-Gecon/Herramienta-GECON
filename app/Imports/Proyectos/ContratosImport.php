<?php

namespace App\Imports\Proyectos;

use App\Models\Cliente;
use App\Models\Contrato;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ContratosImport implements ToModel, WithHeadingRow, WithUpserts
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
     
        return new Contrato([
            
            'contrato_id' => $row['idcontrato'],
            'objeto' => $row['objeto_del_contrato'] ?? null,
            'cliente_id' => Cliente::where('nombre_cliente',  $row['idcliente'])->first()->id ?? null,
            'supervisor' => $row['supervisor'] ?? null,
            'gerente' => $row['gerente_de_proyecto'] ?? null,
            'tipo_venta' => $row['tipo_de_venta'] ?? null,
            'fecha_inicio' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_inicio']) ?? null,
            'fecha_fin' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_fin']) ?? null,
            'moneda' => $row['moneda'] ?? null,
            'precio_venta' => $row['precio_de_venta'] ?? null,
            'años_ejecucion' => $row['años_ejecucion'] ?? null,
            'estado' => $row['estado_del_contrato'] ?? null,
        ]);
    }
    
    public function uniqueBy()
    {
        return 'contrato_id';
    }

    
}
