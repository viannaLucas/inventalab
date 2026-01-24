<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class ExemploCamposEntity extends EntityBase {
    
    const folder = 'exemplocampos_arquivos';
    private $fk_tabelafk = null;
    
    protected $attributes = [
        'id' => '',
        'tipoTexto' => '',
        'tipoImagem' => '',
        'tipoArquivo' => '',
        'tipoData' => '',
        'tipoNumero' => '',
        'tipoReal' => '',
        'tipoTextarea' => '',
        'tipoCPF' => '',
        'tipoCNPJ' => '',
        'tipoEmail' => '',
        'tipoSelect' => '',
        'tipoTelefone' => '',
        'tipoSenha' => '',
        'tipoEditor' => '',
        'foreignkey' => '',
    ];
    
    protected $casts = [
        'tipoData' => 'dateBR',
        'tipoReal' => 'currencyBR',
        'tipoArquivo' => 'filePath['.self::folder.']',
        'tipoImagem' => 'filePath['.self::folder.']',
    ];
    
    public $op_tipoSelect = [
        0 => 'opção 1',
        1 => 'Opção 2',];   
    
    public $color_tipoSelect = [
        0 => '#62a0ea',
        1 => '#e01b24',];
    
    public function getTabelaFK(bool $forceUpadate=false){
        $m = new \App\Models\TabelaFKModel();
        if($this->fk_tabelafk == null || $forceUpadate){
            $this->fk_tabelafk = $m->find($this->foreignkey);
        }
        return $this->fk_tabelafk;
    }
}