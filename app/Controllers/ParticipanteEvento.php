<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ParticipanteEventoModel;
use App\Entities\ParticipanteEventoEntity;

class ParticipanteEvento extends BaseController {    public function pesquisaModal() {
        $m = new ParticipanteEventoModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vParticipanteEvento' => $m->findAll(100)
        ];
        return view('Painel/ParticipanteEvento/respostaModal', $data);
    }
}
