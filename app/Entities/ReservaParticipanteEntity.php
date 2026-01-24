<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class ReservaParticipanteEntity extends EntityBase {
    
    const folder = 'reservaparticipante_arquivos';
    private $fk_participante = null;
    private $fk_reserva = null;
    
    protected $attributes = [
        'id' => '',
        'Participante_id' => '',
        'Reserva_id' => '',
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
    
    public function getReserva(bool $forceUpadate=false){
        $m = new \App\Models\ReservaModel();
        if($this->fk_reserva == null || $forceUpadate){
            $this->fk_reserva = $m->find($this->Reserva_id);
        }
        return $this->fk_reserva;
    }
}