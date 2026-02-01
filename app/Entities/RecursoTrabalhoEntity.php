<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class RecursoTrabalhoEntity extends EntityBase {
    
    const folder = 'recursotrabalho_arquivos';
    const TIPO_FERRAMENTA = 0;
    const TIPO_EQUIPAMENTO = 1;

    const REQUER_HABILIDADE_NAO = 0;
    const REQUER_HABILIDADE_SIM = 1;

    const USO_EXCLUSIVO_NAO = 0;
    const USO_EXCLUSIVO_SIM = 1;

    const SITUACAO_TRABALHO_ATIVO = 0;
    const SITUACAO_TRABALHO_MANUTENCAO = 1;
    const SITUACAO_TRABALHO_REMOVIDO = 2;
    
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
        self::TIPO_FERRAMENTA => 'Ferramenta',
        self::TIPO_EQUIPAMENTO => 'Equipamento',];
    
    public $op_requerHabilidade = [
        self::REQUER_HABILIDADE_NAO => 'Não',
        self::REQUER_HABILIDADE_SIM => 'Sim',];
    
    public $op_usoExclusivo = [
        self::USO_EXCLUSIVO_NAO => 'Não',
        self::USO_EXCLUSIVO_SIM => 'Sim',];
    
    public $op_situacaoTrabalho = [
        self::SITUACAO_TRABALHO_ATIVO => 'Ativo',
        self::SITUACAO_TRABALHO_MANUTENCAO => 'Em Manutenção',
        self::SITUACAO_TRABALHO_REMOVIDO => 'Removido',];   
    
    public $color_tipo = [
        self::TIPO_FERRAMENTA => 'unset',
        self::TIPO_EQUIPAMENTO => 'unset',];

    public $color_requerHabilidade = [
        self::REQUER_HABILIDADE_NAO => 'unset',
        self::REQUER_HABILIDADE_SIM => 'unset',];

    public $color_usoExclusivo = [
        self::USO_EXCLUSIVO_NAO => 'unset',
        self::USO_EXCLUSIVO_SIM => 'unset',];
        
    public $color_situacaoTrabalho = [
        self::SITUACAO_TRABALHO_ATIVO => 'unset',
        self::SITUACAO_TRABALHO_MANUTENCAO => 'unset',
        self::SITUACAO_TRABALHO_REMOVIDO => 'unset',];
    
    public function getListGarantia(){
        $m = new \App\Models\GarantiaModel();
        return $m->where('RecursoTrabalho_id', $this->id)
                ->findAll();
    }
    
}
