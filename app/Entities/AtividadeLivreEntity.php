<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class AtividadeLivreEntity extends EntityBase {
    
    const folder = 'atividadelivre_arquivos';
    private $fk_reserva = null;
    
    protected $attributes = [
        'id' => '',
        'Reserva_id' => '',
        'descricao' => '',
    ];
    
    protected $casts = [
    ];   
    
    
    public function getReserva(bool $forceUpadate=false){
        $m = new \App\Models\ReservaModel();
        if($this->fk_reserva == null || $forceUpadate){
            $this->fk_reserva = $m->find($this->Reserva_id);
        }
        return $this->fk_reserva;
    }
    
    public function getListAtividadeLivreRecurso(){
        $m = new \App\Models\AtividadeLivreRecursoModel();
        return $m->where('AtividadeLivre_id', $this->id)
                ->findAll();
    }
    
}