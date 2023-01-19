<?php

    namespace App\Models;

    class Estado
    {
        private $estados =
            [
                ['estado' => 'TRAB PRES', 'tipo' => 1, 'grupo' => "PRESENTE"],
                ['estado' => 'INCAP','tipo' => 0, 'grupo' => 'INCA'] ,
                ['estado' => 'VACAC','tipo' => 0, 'grupo' => 'VACAC'],
                ['estado' => 'TRAB CASA', 'tipo' => 0, 'grupo' => "REMOTO"],
                ['estado' => 'PERM PERS', 'tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM DIA FAM','tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM MÉD (D)', 'tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM REMUN (H)', 'tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM MÉD (H)','tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM REMUN (D)','tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM NO REMUN (H)','tipo' => 0, 'grupo' => 'PERM NO REMUN'],
                ['estado' => 'AUSENTE','tipo' => 0, 'grupo' => 'AUSENTE'],
                ['estado' => 'APOYO DIV', 'tipo' => 1, 'grupo' => 'APOYO OTRAS UNIDADES'],
                ['estado' => 'PERM NO REMUN (D)','tipo' => 0, 'grupo' => 'PERM NO REMUN'],
                ['estado' => 'LICENC X LUTO', 'tipo' => 0, 'grupo' => 'LICENCIA'],
                ['estado' => 'LICE CALAMIDAD', 'tipo' => 0, 'grupo' => 'LICENCIA'],
                ['estado' => 'PERM LACT', 'tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM VOT', 'tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM SEPELIO','tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'LICE X MATRI', 'tipo' => 0, 'grupo' => 'LICENCIA'],
                ['estado' => 'LICE DEPOR','tipo' => 0, 'grupo' => 'LICENCIA'],
                ['estado' => 'PERM SER MADRE','tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM OFIC/JUR', 'tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'COMPEN', 'tipo' => 0, 'grupo' => 'COMPEN'],
                ['estado' => 'LICE EST', 'tipo' => 0, 'grupo' => 'LICENCIA'],
                ['estado' => 'LICE', 'tipo' => 0, 'grupo' => 'LICENCIA'],
                ['estado' => 'COMIS NAC', 'tipo' => 1, 'grupo' => 'COMISION'],
                ['estado' => 'COMIS INTER', 'tipo' => 1, 'grupo' => 'COMISION'],
                ['estado' => 'SUSPENSIÓN', 'tipo' => 0, 'grupo' => 'SUPENSION'],
                ['estado' => 'APO GEDIN', 'tipo' => 1, 'grupo' => 'APOYO OTRAS UNIDADES'],
                ['estado' => 'APO GEBOC', 'tipo' => 1, 'grupo' => 'APOYO OTRAS UNIDADES'],
                ['estado' => 'APO GEMAM','tipo' => 1, 'grupo' => 'APOYO OTRAS UNIDADES'],
                ['estado' => 'LICE MATER', 'tipo' => 0, 'grupo' => 'LICENCIA'],
                ['estado' => 'LICE PATER', 'tipo' => 0, 'grupo' => 'LICENCIA'],
            ];

        public function getEstados(){
            return $this->estados;
        }

        public function buscarTipoEstado($estado){
            $tipo = 0;
            foreach ($this->estados as $e){
                if($e['estado'] == $estado){
                    $tipo = $e['tipo'];
                }
            }
            return $tipo;
        }

        public function buscarGrupoEstado($estado){
            $tipo = 0;
            foreach ($this->estados as $e){
                if($e['estado'] == $estado){
                    $tipo = $e['grupo'];
                }
            }
            return $tipo;
        }

        public function estadosTipo(bool $presente): array
        {
            $estados = [];
            foreach ($this->estados as $e){
                if($e['tipo'] == $presente){
                    $estados[] = $e['estado'];
                }
            }
            return $estados;
        }
    }