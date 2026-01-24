<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class PresencaEventoEntity extends EntityBase {
    
    const folder = 'presencaevento_arquivos';
    private $fk_participanteevento = null;
    private $fk_controlepresenca = null;
    
    const PRESENCA_NAO = 0;
    const PRESENCA_SIM = 1;

    protected $attributes = [
        'id' => '',
        'ParticipanteEvento_id' => '',
        'ControlePresenta_id' => '',
        'presente' => '',
    ];
    
    protected $casts = [
    ];
    
    public $op_presente = [
        self::PRESENCA_NAO => 'Não',
        self::PRESENCA_SIM => 'Sim',];   
    
    public $color_presente = [
        self::PRESENCA_NAO => 'unset',
        self::PRESENCA_SIM => 'unset',];
    
    public function getParticipanteEvento(bool $forceUpadate=false){
        $m = new \App\Models\ParticipanteEventoModel();
        if($this->fk_participanteevento == null || $forceUpadate){
            $this->fk_participanteevento = $m->find($this->ParticipanteEvento_id);
        }
        return $this->fk_participanteevento;
    }
    
    public function getControlePresenca(bool $forceUpadate=false){
        $m = new \App\Models\ControlePresencaModel();
        if($this->fk_controlepresenca == null || $forceUpadate){
            $this->fk_controlepresenca = $m->find($this->ControlePresenta_id);
        }
        return $this->fk_controlepresenca;
    }
}