<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class CobrancaServicoEntity extends EntityBase {
    
    const folder = 'cobrancaservico_arquivos';
    private $fk_cobranca = null;
    private $fk_servico = null;
    
    protected $attributes = [
        'id' => '',
        'Cobranca_id' => '',
        'Servico_id' => '',
        'quantidade' => '',
        'valorUnitario' => '',
    ];
    
    protected $casts = [
    ];   
    
    
    public function getCobranca(bool $forceUpadate=false){
        $m = new \App\Models\CobrancaModel();
        if($this->fk_cobranca == null || $forceUpadate){
            $this->fk_cobranca = $m->find($this->Cobranca_id);
        }
        return $this->fk_cobranca;
    }
    
    public function getServico(bool $forceUpadate=false){
        $m = new \App\Models\ServicoModel();
        if($this->fk_servico == null || $forceUpadate){
            $this->fk_servico = $m->find($this->Servico_id);
        }
        return $this->fk_servico;
    }
}