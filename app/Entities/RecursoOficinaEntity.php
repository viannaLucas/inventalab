<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class RecursoOficinaEntity extends EntityBase {
    
    const folder = 'recursooficina_arquivos';
    private $fk_recursotrabalho = null;
    private $fk_oficinatematica = null;
    
    protected $attributes = [
        'id' => '',
        'RecursoTrabalho_id' => '',
        'OficinaTematica_id' => '',
    ];
    
    protected $casts = [
    ];   
    
    
    public function getRecursoTrabalho(bool $forceUpadate=false){
        $m = new \App\Models\RecursoTrabalhoModel();
        if($this->fk_recursotrabalho == null || $forceUpadate){
            $this->fk_recursotrabalho = $m->find($this->RecursoTrabalho_id);
        }
        return $this->fk_recursotrabalho;
    }
    
    public function getOficinaTematica(bool $forceUpadate=false){
        $m = new \App\Models\OficinaTematicaModel();
        if($this->fk_oficinatematica == null || $forceUpadate){
            $this->fk_oficinatematica = $m->find($this->OficinaTematica_id);
        }
        return $this->fk_oficinatematica;
    }
}