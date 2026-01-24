<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class EventoEntity extends EntityBase {
    
    const folder = 'evento_arquivos';
    private $fk_servico = null;
    
    protected $attributes = [
        'id' => '',
        'Servico_id' => '',
        'nome' => '',
        'texto' => '',
        'descricao' => '',
        'imagem' => '',
        'vagasLimitadas' => '',
        'numeroVagas' => '',
        'inscricoesAbertas' => '',
        'divulgar' => '',
        'dataInicio' => '',
        'valor' => '',
    ];
    
    protected $casts = [
        'dataInicio' => 'dateBR',
        'valor' => 'currencyBR',
        'imagem' => 'filePath[' . self::folder . ']',
    ];
    
    public $op_vagasLimitadas = [
        0 => 'Não',
        1 => 'Sim',];
    
    public $op_inscricoesAbertas = [
        0 => 'Não',
        1 => 'Sim',];
    
    public $op_divulgar = [
        0 => 'Não',
        1 => 'Sim',];   
    
    public $color_vagasLimitadas = [
        0 => 'unset',
        1 => 'unset',];
    public $color_inscricoesAbertas = [
        0 => 'unset',
        1 => 'unset',];
    public $color_divulgar = [
        0 => 'unset',
        1 => 'unset',];
    
    public function getServico(bool $forceUpadate=false){
        $m = new \App\Models\ServicoModel();
        if($this->fk_servico == null || $forceUpadate){
            $this->fk_servico = $m->find($this->Servico_id);
        }
        return $this->fk_servico;
    }
    
    public function getListControlePresenca(){
        $m = new \App\Models\ControlePresencaModel();
        return $m->where('Evento_id', $this->id)
                ->findAll();
    }
    
    
    public function getListEventoReserva(){
        $m = new \App\Models\EventoReservaModel();
        return $m->where('Evento_id', $this->id)
                ->findAll();
    }
    
    
    public function getListParticipanteEvento(){
        $m = new \App\Models\ParticipanteEventoModel();
        return $m->where('Evento_id', $this->id)
                ->findAll();
    }
    
    function gerarSlug() {
        $titulo = $this->attributes['nome'];
        // Converte para UTF-8 se necessário
        $titulo = mb_convert_encoding($titulo, 'UTF-8', 'auto');

        // Remove acentos
        $titulo = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $titulo);

        // Converte para minúsculas
        $titulo = strtolower($titulo);

        // Remove caracteres que não sejam letras, números, espaço ou hífen
        $titulo = preg_replace('/[^a-z0-9\s-]/', '', $titulo);

        // Substitui espaços e múltiplos hífens por um único hífen
        $titulo = preg_replace('/[\s-]+/', '-', $titulo);

        // Remove hífens do início e do fim
        $titulo = trim($titulo, '-');

        return $titulo;
    }

}
