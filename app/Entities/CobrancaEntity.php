<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class CobrancaEntity extends EntityBase {
    
    const folder = 'cobranca_arquivos';
    private $fk_participante = null;
    
    const SITUACAO_ABERTA = 0;
    const SITUACAO_PAGA = 1;
    const SITUACAO_CANCELADA = 2;

    protected $attributes = [
        'id' => '',
        'Participante_id' => '',
        'data' => '',
        'valor' => '',
        'observacoes' => '',
        'situacao' => '',
    ];
    
    protected $casts = [
        'data' => 'dateBR',
        'valor' => 'currencyBR',
    ];
    
    public $op_situacao = [
        self::SITUACAO_ABERTA => 'Aberta',
        self::SITUACAO_PAGA => 'Paga',
        self::SITUACAO_CANCELADA => 'Cancelada',];   
    
    public $color_situacao = [
        self::SITUACAO_ABERTA => 'unset',
        self::SITUACAO_PAGA => 'unset',
        self::SITUACAO_CANCELADA => 'unset',];
    
    public function getParticipante(bool $forceUpadate=false){
        $m = new \App\Models\ParticipanteModel();
        if($this->fk_participante == null || $forceUpadate){
            $this->fk_participante = $m->find($this->Participante_id);
        }
        return $this->fk_participante;
    }
    
    public function getListCobrancaServico(){
        $m = new \App\Models\CobrancaServicoModel();
        return $m->where('Cobranca_id', $this->id)
                ->findAll();
    }

    public function getListCobrancaProduto(){
        $m = new \App\Models\CobrancaProdutoModel();
        return $m->where('Cobranca_id', $this->id)
                ->findAll();
    }

    public function getListFatura(){
        $m = new \App\Models\FaturaModel();
        return $m->where('Cobranca_id', $this->id)
                ->findAll();
    }
    
}
