<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class ConfiguracaoEntity extends EntityBase {
    
    const folder = 'configuracao_arquivos';
    private $fk_servicoUsoEspaco = null;
    
    const ADICINAR_CALCULO_SERVICO_NAO = 0;
    const ADICINAR_CALCULO_SERVICO_SIM = 1;

    protected $attributes = [
        'id' => '',
        'lotacaoEspaco' => '',
        'intervaloEntrePesquisa' => '',
        'textoEmailConfirmacao' => '',
        'servicoUsoEspaco' => '',
        'adicinarCalculoServico' => '',
    ];
    
    protected $casts = [
    ];   
    
    public $op_adicinarCalculoServico = [
        self::ADICINAR_CALCULO_SERVICO_NAO => 'Não',
        self::ADICINAR_CALCULO_SERVICO_SIM => 'Sim',];   
    
    public $color_adicinarCalculoServico = [
        self::ADICINAR_CALCULO_SERVICO_NAO => 'unset',
        self::ADICINAR_CALCULO_SERVICO_SIM => 'unset',];
    
    public function getServico(bool $forceUpadate=false){
        $m = new \App\Models\ServicoModel();
        if($this->fk_servicoUsoEspaco == null || $forceUpadate){
            $this->fk_servicoUsoEspaco = $m->find($this->attributes['servicoUsoEspaco']);
        }
        return $this->fk_servicoUsoEspaco;
    }
}
