<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class ProdutoEntity extends EntityBase {
    
    const folder = 'produto_arquivos';
    private $fk_dadosapi = null;
    
    protected $attributes = [
        'id' => '',
        'nome' => '',
        'foto' => '',
        'valor' => '',
        'estoqueMinimo' => '',
        'estoqueAtual' => '',
    ];
    
    protected $casts = [
        'valor' => 'currencyBR',
        'foto' => 'filePath[' . self::folder . ']',
    ];   
    
    public function getDadosApi(bool $forceUpadate=false){
        if($this->fk_dadosapi == null || $forceUpadate){
            $m = new \App\Models\ProdutoDadosApiModel();
            $rel = $m->where('Produto_id', $this->id)->first();
            $this->fk_dadosapi = $rel ? $rel->getDadosApi($forceUpadate) : null;
        }
        return $this->fk_dadosapi;
    }
    
}
