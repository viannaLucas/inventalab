<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class ArquivoOficinaEntity extends EntityBase {
    
    const folder = 'arquivooficina_arquivos';
    private $fk_oficinatematica = null;
    
    protected $attributes = [
        'id' => '',
        'OficinaTematica_id' => '',
        'nome' => '',
        'arquivo' => '',
    ];
    
    protected $casts = [
        'arquivo' => 'filePath['.self::folder.']',
    ];   
    
    
    public function getOficinaTematica(bool $forceUpadate=false){
        $m = new \App\Models\OficinaTematicaModel();
        if($this->fk_oficinatematica == null || $forceUpadate){
            $this->fk_oficinatematica = $m->find($this->OficinaTematica_id);
        }
        return $this->fk_oficinatematica;
    }
}