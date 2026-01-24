<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class OficinaTematicaReservaEntity extends EntityBase {
    
    const folder = 'oficinatematicareserva_arquivos';
    private $fk_reserva = null;
    private $fk_oficinatematica = null;
    
    protected $attributes = [
        'id' => '',
        'Reserva_id' => '',
        'OficinaTematica_id' => '',
        'observacao' => '',
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
    
    public function getOficinaTematica(bool $forceUpadate=false){
        $m = new \App\Models\OficinaTematicaModel();
        if($this->fk_oficinatematica == null || $forceUpadate){
            $this->fk_oficinatematica = $m->find($this->OficinaTematica_id);
        }
        return $this->fk_oficinatematica;
    }
}