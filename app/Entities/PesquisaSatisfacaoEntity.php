<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class PesquisaSatisfacaoEntity extends EntityBase {
    
    const folder = 'pesquisasatisfacao_arquivos';
    const RESPONDIDO_SIM = 1;
    const RESPONDIDO_NAO = 0;

    protected $attributes = [
        'id' => '',
        'Participante_id' => '',
        'resposta1' => '',
        'resposta2' => '',
        'resposta3' => '',
        'resposta4' => '',
        'resposta5' => '',
        'dataResposta' => '',
        'dataEnvio' => '',
        'respondido' => '',
    ];
    
    protected $casts = [
        'dataResposta' => 'dateBR',
        'dataEnvio' => 'dateBR',
    ];   
    
}