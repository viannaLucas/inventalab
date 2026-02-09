<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class DadosApiEntity extends EntityBase {
    
    const folder = 'dadosapi_arquivos';
    
    protected $attributes = [
        'id' => '',
        'codigo' => '',
        'CodigodoTipodeOperacao' => '',
        'UnidadedeControle' => '',
        'ProdutoInspecionado' => '',
        'ProdutoFabricado' => '',
        'ProdutoLiberado' => '',
        'ProdutoemInventario' => '',
        'TipodeProduto' => '',
        'IndicacaodeLoteSerie' => '',
        'CodigodeSituacaoTributariaCST' => '',
        'ClassificacaoFiscal' => '',
        'GrupodeProduto' => '',
    ];
    
    protected $casts = [
    ];   
    
}
