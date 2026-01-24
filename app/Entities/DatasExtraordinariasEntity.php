<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class DatasExtraordinariasEntity extends EntityBase {
    
    const TIPO_FECHADO = 0;
    const TIPO_ABERTO = 1;

    const folder = 'datasextraordinarias_arquivos';
    
    protected $attributes = [
        'id' => '',
        'data' => '',
        'horaInicio' => '',
        'horaFim' => '',
        'tipo' => '',
    ];
    
    protected $casts = [
        'data' => 'dateBR',
    ];
    
    public $op_tipo = [
        self::TIPO_FECHADO => 'Fechado',
        self::TIPO_ABERTO => 'Aberto',];   
    
    public $color_tipo = [
        self::TIPO_FECHADO => 'unset',
        self::TIPO_ABERTO => 'unset',];
}