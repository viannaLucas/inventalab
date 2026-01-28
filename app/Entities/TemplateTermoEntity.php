<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class TemplateTermoEntity extends EntityBase {
    
    const folder = 'templatetermo_arquivos';

    const REQUERER_TERMO_NAO = 0;
    const REQUERER_TERMO_SIM = 1;
    
    protected $attributes = [
        'id' => '',
        'nome' => '',
        'requererTermo' => '',
        'texto' => '',
    ];
    
    protected $casts = [
    ];   

    public $op_requererTermo = [
        self::REQUERER_TERMO_NAO => 'Não',
        self::REQUERER_TERMO_SIM => 'Sim',];
    
}
