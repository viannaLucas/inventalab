<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class CobrancaProdutoEntity extends EntityBase {
    
    const folder = 'cobrancaproduto_arquivos';
    private $fk_cobranca = null;
    private $fk_produto = null;
    
    protected $attributes = [
        'id' => '',
        'Cobranca_id' => '',
        'Produto_id' => '',
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
    
    public function getProduto(bool $forceUpadate=false){
        $m = new \App\Models\ProdutoModel();
        if($this->fk_produto == null || $forceUpadate){
            $this->fk_produto = $m->find($this->Produto_id);
        }
        return $this->fk_produto;
    }
}