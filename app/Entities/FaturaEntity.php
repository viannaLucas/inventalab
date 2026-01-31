<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class FaturaEntity extends EntityBase {
    
    private $fk_cobranca = null;
    const SITUACAO_NAO_PROCESSADO = 0;
    const SITUACAO_PROCESSADO = 1;
    const SITUACAO_COM_ERRO = 2;
    
    protected $attributes = [
        'id' => '',
        'Cobranca_id' => '',
        'processoApiSesc' => '',
        'situacao' => '',
    ];
    
    protected $casts = [
    ];
    
    public $op_situacao = [
        self::SITUACAO_NAO_PROCESSADO => 'Não Processado',
        self::SITUACAO_PROCESSADO => 'Processado',
        self::SITUACAO_COM_ERRO => 'Com Erro',];   
    
    public $color_situacao = [
        self::SITUACAO_NAO_PROCESSADO => 'unset',
        self::SITUACAO_PROCESSADO => 'unset',
        self::SITUACAO_COM_ERRO => 'unset',];
    
    public function getCobranca(bool $forceUpadate=false){
        $m = new \App\Models\CobrancaModel();
        if($this->fk_cobranca == null || $forceUpadate){
            $this->fk_cobranca = $m->find($this->Cobranca_id);
        }
        return $this->fk_cobranca;
    }
}
