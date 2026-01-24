<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class ControlePresencaEntity extends EntityBase {
    
    const folder = 'controlepresenca_arquivos';
    private $fk_evento = null;
    
    protected $attributes = [
        'id' => '',
        'Evento_id' => '',
        'descricao' => '',
    ];
    
    protected $casts = [
    ];   
    
    
    public function getEvento(bool $forceUpadate=false){
        $m = new \App\Models\EventoModel();
        if($this->fk_evento == null || $forceUpadate){
            $this->fk_evento = $m->find($this->Evento_id);
        }
        return $this->fk_evento;
    }
    
    public function getListPresencaEvento(){
        $m = new \App\Models\PresencaEventoModel();
        return $m->where('ControlePresenta_id', $this->id)
                ->findAll();
    }
    
}