<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class TabelaFKEntity extends EntityBase {
    
    const folder = 'tabelafk_arquivos';
    
    protected $attributes = [
        'id' => '',
        'nome' => '',
    ];
    
    protected $casts = [
    ];   
    
}