<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class ReservaCobrancaEntity extends EntityBase {
    
    const folder = 'reservacobranca_arquivos';
    private $fk_reserva = null;
    private $fk_cobranca = null;
    
    protected $attributes = [
        'id' => '',
        'Reserva_id' => '',
        'Cobranca_id' => '',
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
    
    public function getCobranca(bool $forceUpadate=false){
        $m = new \App\Models\CobrancaModel();
        if($this->fk_cobranca == null || $forceUpadate){
            $this->fk_cobranca = $m->find($this->Cobranca_id);
        }
        return $this->fk_cobranca;
    }
}