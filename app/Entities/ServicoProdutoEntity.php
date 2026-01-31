<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class ServicoProdutoEntity extends EntityBase {
    
    const folder = 'servicoproduto_arquivos';
    private $fk_produto = null;
    private $fk_servico = null;
    
    protected $attributes = [
        'id' => '',
        'Produto_id' => '',
        'Servico_id' => '',
        'quantidade' => '',
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
    
    public function getServico(bool $forceUpadate=false){
        $m = new \App\Models\ServicoModel();
        if($this->fk_servico == null || $forceUpadate){
            $this->fk_servico = $m->find($this->Servico_id);
        }
        return $this->fk_servico;
    }
}
