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
                $avance = AvanceProyectoSemanal::firstOrNew([
                     'proyecto_id' => $this->proyecto,
                    'semana' => $row['semana'],
                ]);
                $avance->avance_planeado = $row['avance_planeado'];
                $avance->avance_real= $row['avance_real'] ?? 0;
                $avance->avance_real_costo= $row['avance_real_costo'] ?? 0;
                $avance->costo_material= $row['costo_material'] ?? 0;
                $avance->costo_mano_obra= $row['costo_mano_obra'] ?? 0;
                $avance->costo_servicio= $row['costo_servicio'] ?? 0;
                $avance->valor_planeado= $row['valor_planeado'] ?? 0;
                $avance->valor_ganado= $row['valor_ganado'] ?? 0;
                $avance->costo_actual= $row['costo_actual'] ?? 0;
                $avance->CPI= $row['cpi'] ?? 0;
                $avance->SPI= $row['spi'] ?? 0;
                $avance->EAC= $row['eac'] ?? 0;
                $avance->EACT= $row['eact'] ?? 0;
                $avance->ETC= $row['etc'] ?? 0;
                $avance->TCPI= $row['tcpi'] ?? 0;
                $avance->variacion_avance = $row['variacion_avance'] ?? 0;
                $avance->variacion_costo = $row['variacion_costo'] ?? 0;
               
            }
        
    }
    }
}
