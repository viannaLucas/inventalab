<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class CobrancaParticipanteEventoEntity extends EntityBase {
    
    const folder = 'cobrancaparticipanteevento_arquivos';
    private $fk_participanteevento = null;
    private $fk_cobranca = null;
    
    protected $attributes = [
        'id' => '',
        'ParticipanteEvento_id' => '',
        'Cobranca_id' => '',
    ];
    
    protected $casts = [
    ];   
    
    
    public function getParticipanteEvento(bool $forceUpadate=false){
        $m = new \App\Models\ParticipanteEventoModel();
        if($this->fk_participanteevento == null || $forceUpadate){
            $this->fk_participanteevento = $m->find($this->ParticipanteEvento_id);
        }
        return $this->fk_participanteevento;
    }
    
    public function getCobranca(bool $forceUpadate=false){
        $m = new \App\Models\CobrancaModel();
        if($this->fk_cobranca == null || $forceUpadate){
            $this->fk_cobranca = $m->find($this->Cobranca_id);
        }
        return $this->fk_cobranca;
    }
}
