<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class ServicoDadosApiEntity extends EntityBase {
    
    const folder = 'servicodadosapi_arquivos';
    private $fk_servico = null;
    private $fk_dadosapi = null;
    
    protected $attributes = [
        'id' => '',
        'Servico_id' => '',
        'DadosApi_id' => '',
    ];
    
    protected $casts = [
    ];   
    
    
    public function getServico(bool $forceUpadate=false){
        $m = new \App\Models\ServicoModel();
        if($this->fk_servico == null || $forceUpadate){
            $this->fk_servico = $m->find($this->Servico_id);
        }
        return $this->fk_servico;
    }
    
    public function getDadosApi(bool $forceUpadate=false){
        $m = new \App\Models\DadosApiModel();
        if($this->fk_dadosapi == null || $forceUpadate){
            $this->fk_dadosapi = $m->find($this->DadosApi_id);
        }
        return $this->fk_dadosapi;
    }
}
