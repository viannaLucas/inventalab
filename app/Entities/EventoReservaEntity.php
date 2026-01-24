<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class EventoReservaEntity extends EntityBase {
    
    const folder = 'eventoreserva_arquivos';
    private $fk_reserva = null;
    private $fk_evento = null;
    
    protected $attributes = [
        'id' => '',
        'Reserva_id' => '',
        'Evento_id' => '',
    ];
    
    protected $casts = [
    ];   
    
    
    public function getReserva(bool $forceUpadate=false){
        $m = new \App\Models\ReservaModel();
        if($this->fk_reserva == null || $forceUpadate){
            $this->fk_reserva = $m->find($this->Reserva_id);
        }
        return $this->fk_reserva;
    }
    
    public function getEvento(bool $forceUpadate=false){
        $m = new \App\Models\EventoModel();
        if($this->fk_evento == null || $forceUpadate){
            $this->fk_evento = $m->find($this->Evento_id);
        }
        return $this->fk_evento;
    }
}