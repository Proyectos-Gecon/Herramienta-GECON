<?php

namespace App\Imports\Proyectos;

use App\Models\AvanceProyectoSemanal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportAvanceSemanal implements ToCollection, WithHeadingRow
{

 

    protected $proyecto;
    

    public function __construct($now)
    {
        $this->proyecto = $now;
    }

    
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            if(isset($row['avance_planeado'])){
                AvanceProyectoSemanal::create([
                    'proyecto_id' => $this->proyecto,
                    'fecha_estado' =>  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_de_estado']),
                    'semana' => $row['semana'],
                    'avance_planeado' => $row['avance_planeado'],
                    'avance_real'=> $row['avance_real'] ?? 0,
                    'avance_real_costo'=> $row['avance_real_costo'] ?? 0,
                    'costo_material'=> $row['costo_material'] ?? 0,
                    'costo_mano_obra'=> $row['costo_mano_obra'] ?? 0,
                    'costo_servicio'=> $row['costo_servicio'] ?? 0,
                    'valor_planeado'=> $row['valor_planeado'] ?? 0,
                    'valor_ganado'=> $row['valor_ganado'] ?? 0,
                    'costo_actual'=> $row['costo_actual'] ?? 0,
                    'CPI'=> $row['cpi'] ?? 0,
                    'SPI'=> $row['spi'] ?? 0,
                    'EAC'=> $row['eac'] ?? 0,
                    'EACT'=> $row['eact'] ?? 0,
                    'ETC'=> $row['etc'] ?? 0,
                    'TCPI'=> $row['tcpi'] ?? 0,
                    'variacion_avance'=> $row['variacion_avance'] ?? 0,
                    'variacion_costo'=> $row['variacion_costo'] ?? 0,
                ]);
            }
        
    }
    }
}
