<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class GarantiaEntity extends EntityBase {
    
    const folder = 'garantia_arquivos';
    private $fk_recursotrabalho = null;
    
    protected $attributes = [
        'id' => '',
        'RecursoTrabalho_id' => '',
        'descricao' => '',
        'tipo' => '',
        'dataInicio' => '',
        'dataFim' => '',
    ];
    
    protected $casts = [
        'dataInicio' => 'dateBR',
        'dataFim' => 'dateBR',
    ];
    
    public $op_tipo = [
        0 => 'Fabricante',
        1 => 'Garantia Estendida',
        2 => 'Conserto e Manutenção ',];   
    
    public $color_tipo = [
        0 => 'unset',
        1 => 'unset',
        2 => 'unset',];
    
    public function getRecursoTrabalho(bool $forceUpadate=false){
        $m = new \App\Models\RecursoTrabalhoModel();
        if($this->fk_recursotrabalho == null || $forceUpadate){
            $this->fk_recursotrabalho = $m->find($this->RecursoTrabalho_id);
        }
        return $this->fk_recursotrabalho;
    }
}