<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class ServicoEntity extends EntityBase {
    
    const folder = 'servico_arquivos';
    private $fk_dadosapi = null;

    const ATIVO_SIM = 1;
    const ATIVO_NAO = 0;
    
    protected $attributes = [
        'id' => '',
        'Nome' => '',
        'descricao' => '',
        'valor' => '',
        'unidade' => '',
        'ativo' => '',
    ];
    
    protected $casts = [
        'valor' => 'currencyBR',
    ];
    
    public $op_ativo = [
        self::ATIVO_NAO => 'Não',
        self::ATIVO_SIM => 'Sim',];   
    
    public $color_ativo = [
        self::ATIVO_NAO => 'unset',
        self::ATIVO_SIM => 'unset',];
    
    public function getDadosApi(bool $forceUpadate=false){
        if($this->fk_dadosapi == null || $forceUpadate){
            $m = new \App\Models\ServicoDadosApiModel();
            $rel = $m->where('Servico_id', $this->id)->first();
            $this->fk_dadosapi = $rel ? $rel->getDadosApi($forceUpadate) : null;
        }
        return $this->fk_dadosapi;
    }

    public function getListServicoProduto(){
        $m = new \App\Models\ServicoProdutoModel();
        return $m->where('Servico_id', $this->id)
                ->findAll();
    }
}
