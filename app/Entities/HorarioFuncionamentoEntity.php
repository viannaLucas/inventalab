<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class HorarioFuncionamentoEntity extends EntityBase {
    
    const folder = 'horariofuncionamento_arquivos';
    
    protected $attributes = [
        'id' => '',
        'diaSemana' => '',
        'horaInicio' => '',
        'horaFinal' => '',
    ];
    
    protected $casts = [
    ];
    
    public $op_diaSemana = [
        0 => 'Domingo',
        1 => 'Segunda',
        2 => 'Terça',
        3 => 'Quarta',
        4 => 'Quinta',
        5 => 'Sexta',
        6 => 'Sábado',];   
    
    public $color_diaSemana = [
        0 => 'unset',
        1 => 'unset',
        2 => 'unset',
        3 => 'unset',
        4 => 'unset',
        5 => 'unset',
        6 => 'unset',];
}