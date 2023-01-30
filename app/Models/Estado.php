<?php

    namespace App\Models;

    class Estado
    {
        private $estados =
        [
         

                ['estado' => 'TRAB PRES GECON', 'tipo' => 1, 'grupo' => "PRESENTE"],
                ['estado' => 'TRAB PRES GEMAM', 'tipo' => 1, 'grupo' => "PRESENTE"],
                ['estado' => 'TRAB PRES GEBOC', 'tipo' => 1, 'grupo' => "PRESENTE"],
                
                ['estado' => 'INCAP','tipo' => 0, 'grupo' => 'INCA'] ,
                ['estado' => 'VACAC','tipo' => 0, 'grupo' => 'VACAC'],
                ['estado' => 'TRAB CASA', 'tipo' => 0, 'grupo' => "REMOTO"],
                
                ['estado' => 'PERM PERS', 'tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM DIA FAM','tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM MÉD (D)', 'tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM MÉD (H)','tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM LACT', 'tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM VOT', 'tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM SEPELIO','tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM SER MADRE','tipo' => 0, 'grupo' => 'PERM REMUN'],
                ['estado' => 'PERM OFIC/JUR', 'tipo' => 0, 'grupo' => 'PERM REMUN'],

                ['estado' => 'APOYO DIV', 'tipo' => 1, 'grupo' => 'APOYO OTRAS UNIDADES'],
                
                ['estado' => 'PERM NO REMUN (H)','tipo' => 0, 'grupo' => 'PERM NO REMUN'],
                ['estado' => 'PERM NO REMUN (D)','tipo' => 0, 'grupo' => 'PERM NO REMUN'],
                
                ['estado' => 'LICENC X LUTO', 'tipo' => 0, 'grupo' => 'LICENCIA'],
                ['estado' => 'LICE CALAMIDAD', 'tipo' => 0, 'grupo' => 'LICENCIA'],
                ['estado' => 'LICE X MATRI', 'tipo' => 0, 'grupo' => 'LICENCIA'],
                ['estado' => 'LICE EST', 'tipo' => 0, 'grupo' => 'LICENCIA'],
                ['estado' => 'LICE MATER', 'tipo' => 0, 'grupo' => 'LICENCIA'],
                ['estado' => 'LICE PATER', 'tipo' => 0, 'grupo' => 'LICENCIA'],
                ['estado' => 'LICE DEPOR','tipo' => 0, 'grupo' => 'LICENCIA'],
                ['estado' => 'LICENCIA','tipo' => 0, 'grupo' => 'LICENCIA'],
                
                
                ['estado' => 'AUSENTE','tipo' => 0, 'grupo' => 'AUSENTE'],
                ['estado' => 'SUSPENSIÓN', 'tipo' => 0, 'grupo' => 'SUPENSION'],
                
                ['estado' => 'COMPEN', 'tipo' => 0, 'grupo' => 'COMPEN'],
                ['estado' => 'COMIS NAC', 'tipo' => 1, 'grupo' => 'COMISION'],
                ['estado' => 'COMIS INTER', 'tipo' => 1, 'grupo' => 'COMISION'],
               
                ['estado' => 'APO GEDIN', 'tipo' => 1, 'grupo' => 'APOYO OTRAS UNIDADES'],
                ['estado' => 'APO GEBOC', 'tipo' => 1, 'grupo' => 'APOYO OTRAS UNIDADES'],
                ['estado' => 'APO GEMAM','tipo' => 1, 'grupo' => 'APOYO OTRAS UNIDADES'],
                
            
            ];

        public function getEstados(){
            return $this->estados;
        }

        public function buscarTipoEstado($estado){
            $tipo = 1;
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
        public function estadosTipoGrupo(bool $presente): array
        {
            $estados = [];
            foreach ($this->estados as $e){
                if($e['tipo'] == $presente){
                    if(!array_search($e['grupo'] , $estados))
                    $estados[] = $e['grupo'];
                }
            }
            return $estados;
        }
    }
