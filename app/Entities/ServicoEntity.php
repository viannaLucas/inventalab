<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class ServicoEntity extends EntityBase {
    
    const folder = 'servico_arquivos';
    private $fk_dadosapi = null;
    
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
        0 => 'Não',
        1 => 'Sim',];   
    
    public $color_ativo = [
        0 => 'unset',
        1 => 'unset',];
    
    public function getDadosApi(bool $forceUpadate=false){
        if($this->fk_dadosapi == null || $forceUpadate){
            $m = new \App\Models\ServicoDadosApiModel();
            $rel = $m->where('Servico_id', $this->id)->first();
            $this->fk_dadosapi = $rel ? $rel->getDadosApi($forceUpadate) : null;
        }
        return $this->fk_dadosapi;
    }
}
