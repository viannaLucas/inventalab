<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class ParticipanteEventoEntity extends EntityBase {
    
    const folder = 'participanteevento_arquivos';
    private $fk_participante = null;
    private $fk_evento = null;
    
    protected $attributes = [
        'id' => '',
        'Participante_id' => '',
        'Evento_id' => '',
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
    
    public function getEvento(bool $forceUpadate=false){
        $m = new \App\Models\EventoModel();
        if($this->fk_evento == null || $forceUpadate){
            $this->fk_evento = $m->find($this->Evento_id);
        }
        return $this->fk_evento;
    }
}