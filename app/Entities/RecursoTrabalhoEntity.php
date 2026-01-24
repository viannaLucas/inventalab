<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class RecursoTrabalhoEntity extends EntityBase {
    
    const folder = 'recursotrabalho_arquivos';
    
    protected $attributes = [
        'id' => '',
        'nome' => '',
        'tipo' => '',
        'foto' => '',
        'marcaFabricante' => '',
        'descricao' => '',
        'requerHabilidade' => '',
        'usoExclusivo' => '',
        'situacaoTrabalho' => '',
        'quantidadeDisponivel' => '',
    ];
    
    protected $casts = [
        'foto' => 'filePath['.self::folder.']',
    ];
    
    public $op_tipo = [
        0 => 'Ferramenta',
        1 => 'Equipamento',];
    
    public $op_requerHabilidade = [
        0 => 'Não',
        1 => 'Sim',];
    
    public $op_usoExclusivo = [
        0 => 'Não',
        1 => 'Sim',];
    
    public $op_situacaoTrabalho = [
        0 => 'Ativo',
        1 => 'Em Manutenção',
        2 => 'Removido',];   
    
    public $color_tipo = [
        0 => 'unset',
        1 => 'unset',];
    public $color_requerHabilidade = [
        0 => 'unset',
        1 => 'unset',];
    public $color_usoExclusivo = [
        0 => 'unset',
        1 => 'unset',];
    public $color_situacaoTrabalho = [
        0 => 'unset',
        1 => 'unset',
        2 => 'unset',];
    
    public function getListGarantia(){
        $m = new \App\Models\GarantiaModel();
        return $m->where('RecursoTrabalho_id', $this->id)
                ->findAll();
    }
    
}