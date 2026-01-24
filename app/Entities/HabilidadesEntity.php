<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class HabilidadesEntity extends EntityBase {
    
    const folder = 'habilidades_arquivos';
    private $fk_participante = null;
    private $fk_recursotrabalho = null;
    
    protected $attributes = [
        'id' => '',
        'Participante_id' => '',
        'RecursoTrabalho_id' => '',
    ];
    
    protected $casts = [
    ];   
    
    
    public function getParticipante(bool $forceUpadate=false){
        $m = new \App\Models\ParticipanteModel();
        if($this->fk_participante == null || $forceUpadate){
            $this->fk_participante = $m->find($this->Participante_id);
        }
        return $this->fk_participante;
    }
    
    public function getRecursoTrabalho(bool $forceUpadate=false){
        $m = new \App\Models\RecursoTrabalhoModel();
        if($this->fk_recursotrabalho == null || $forceUpadate){
            $this->fk_recursotrabalho = $m->find($this->RecursoTrabalho_id);
        }
        return $this->fk_recursotrabalho;
    }
}