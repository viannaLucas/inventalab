<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class ProdutoDadosApiEntity extends EntityBase {
    
    const folder = 'produtodadosapi_arquivos';
    private $fk_produto = null;
    private $fk_dadosapi = null;
    
    protected $attributes = [
        'id' => '',
        'Produto_id' => '',
        'DadosApi_id' => '',
    ];
    
    protected $casts = [
    ];   
    
    
    public function getProduto(bool $forceUpadate=false){
        $m = new \App\Models\ProdutoModel();
        if($this->fk_produto == null || $forceUpadate){
            $this->fk_produto = $m->find($this->Produto_id);
        }
        return $this->fk_produto;
    }
    
    public function getDadosApi(bool $forceUpadate=false){
        $m = new \App\Models\DadosApiModel();
        if($this->fk_dadosapi == null || $forceUpadate){
            $this->fk_dadosapi = $m->find($this->DadosApi_id);
        }
        return $this->fk_dadosapi;
    }
}
