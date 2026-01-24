<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class AtividadeLivreRecursoEntity extends EntityBase {
    
    const folder = 'atividadelivrerecurso_arquivos';
    private $fk_atividadelivre = null;
    private $fk_recursotrabalho = null;
    
    protected $attributes = [
        'id' => '',
        'AtividadeLivre_id' => '',
        'RecursoTrabalho_id' => '',
    ];
    
    protected $casts = [
    ];   
    
    
    public function getAtividadeLivre(bool $forceUpadate=false){
        $m = new \App\Models\AtividadeLivreModel();
        if($this->fk_atividadelivre == null || $forceUpadate){
            $this->fk_atividadelivre = $m->find($this->AtividadeLivre_id);
        }
        return $this->fk_atividadelivre;
    }
    
    public function getRecursoTrabalho(bool $forceUpadate=false){
        $m = new \App\Models\RecursoTrabalhoModel();
        if($this->fk_recursotrabalho == null || $forceUpadate){
            $this->fk_recursotrabalho = $m->find($this->RecursoTrabalho_id);
        }
        return $this->fk_recursotrabalho;
    }
}