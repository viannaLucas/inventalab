<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class TemplateTermoEntity extends EntityBase {
    
    const folder = 'templatetermo_arquivos';
    
    protected $attributes = [
        'id' => '',
        'nome' => '',
        'texto' => '',
    ];
    
    protected $casts = [
    ];   
    
}