<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class CobrancaEntity extends EntityBase {
    
    const folder = 'cobranca_arquivos';
    private $fk_participante = null;
    
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
        0 => 'Aberta',
        1 => 'Paga',
        2 => 'Cancelada',];   
    
    public $color_situacao = [
        0 => 'unset',
        1 => 'unset',
        2 => 'unset',];
    
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
    
}
