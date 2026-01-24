<?php

namespace App\Entities;

use \App\Entities\EntityBase;
use DateTime;

class ReservaEntity extends EntityBase {
    
    const folder = 'reserva_arquivos';
    const TIPO_EXCLUSIVA = 0;
    const TIPO_COMPARTILHADA = 1;

    const STATUS_CANCELADO = 0;
    const STATUS_ATIVO = 1;

    const TURMA_ESCOLA_SIM = 0;
    const TURMA_ESCOLA_NAO = 1;
    
    protected $attributes = [
        'id' => '',
        'dataCadastro' => '',
        'dataReserva' => '',
        'horaInicio' => '',
        'horaFim' => '',
        'tipo' => '',
        'numeroConvidados' => '',
        'status' => '',
        'turmaEscola' => '',
        'nomeEscola' => '',
        'anoTurma' => '',
        'horaEntrada' => '',
        'horaSaida' => '',
    ];
    
    protected $casts = [
        'dataCadastro' => 'dateBR',
        'dataReserva' => 'dateBR',
    ];
    
    public $op_tipo = [
        self::TIPO_EXCLUSIVA => 'Exclusiva',
        self::TIPO_COMPARTILHADA => 'Compartilhada',];
    
    public $op_status = [
        self::STATUS_CANCELADO => 'Cancelado',
        self::STATUS_ATIVO => 'Ativo',];
    
    public $op_turmaEscola = [
        self::TURMA_ESCOLA_SIM => 'Sim',
        self::TURMA_ESCOLA_NAO => 'Não',];   

    public $op_anoTurma = [
        0 => '1° ano',
        1 => '2° ano',
        2 => '3° ano',
        3 => '4° ano',
        4 => '5° ano',
        5 => '6° ano',
        6 => '7° ano',
        7 => '8° ano',
        8 => '9° ano',];   
    
    public $color_tipo = [
        self::TIPO_EXCLUSIVA => 'unset',
        self::TIPO_COMPARTILHADA => 'unset',];

    public $color_status = [
        0 => '#c01c28',
        1 => '#2ec27e',];

    public $color_turmaEscola = [
        0 => 'unset',
        1 => 'unset',];

    public $color_anoTurma = [
        0 => 'unset',
        1 => 'unset',
        2 => 'unset',
        3 => 'unset',
        4 => 'unset',
        5 => 'unset',
        6 => 'unset',
        7 => 'unset',
        8 => 'unset',];
    
    public function getListAtividadeLivre(){
        $m = new \App\Models\AtividadeLivreModel();
        return $m->where('Reserva_id', $this->id)
                ->findAll();
    }
    
    
    public function getListEventoReserva(){
        $m = new \App\Models\EventoReservaModel();
        return $m->where('Reserva_id', $this->id)
                ->findAll();
    }
    
    
    public function getListOficinaTematicaReserva(){
        $m = new \App\Models\OficinaTematicaReservaModel();
        return $m->where('Reserva_id', $this->id)
                ->findAll();
    }
    
    
    public function getListReservaParticipante(){
        $m = new \App\Models\ReservaParticipanteModel();
        return $m->where('Reserva_id', $this->id)
                ->findAll();
    }

    public function getReservaCobranca(): ?\App\Entities\ReservaCobrancaEntity
    {
        $m = new \App\Models\ReservaCobrancaModel();
        return $m->where('Reserva_id', $this->id)->first();
    }
    
    
    public function getDuracaoEmMinutos(): int
    {   
        $d1 = DateTime::createFromFormat('d/m/Y H:i', $this->dataCadastro.' '.$this->horaInicio);
        $d2 = DateTime::createFromFormat('d/m/Y H:i', $this->dataCadastro.' '.$this->horaFim);
        
        return ($d2->getTimestamp() - $d1->getTimestamp()) / 60;
    }

    public function getListaParticipantes(): array
    {   
        $vParticipante = [];
        /** @var ReservaParticipanteEntity $rp */
        foreach($this->getListReservaParticipante() as $rp){
            $vParticipante[] = $rp->getParticipante();
        }
        return $vParticipante;
    }
}
