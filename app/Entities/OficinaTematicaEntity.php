<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class OficinaTematicaEntity extends EntityBase {
    
    const folder = 'oficinatematica_arquivos';
    
    protected $attributes = [
        'id' => '',
        'nome' => '',
        'descricaoAtividade' => '',
        'situacao' => 0,
    ];
    
    protected $casts = [
        'situacao' => 'int',
    ];   
    
    
    public function getListArquivoOficina(){
        $m = new \App\Models\ArquivoOficinaModel();
        return $m->where('OficinaTematica_id', $this->id)
                ->findAll();
    }
    
    
    public function getListMaterialOficina(){
        $m = new \App\Models\MaterialOficinaModel();
        return $m->where('OficinaTematica_id', $this->id)
                ->findAll();
    }
    
    
    public function getListRecursoOficina(){
        $m = new \App\Models\RecursoOficinaModel();
        return $m->where('OficinaTematica_id', $this->id)
                ->findAll();
    }
    
}
