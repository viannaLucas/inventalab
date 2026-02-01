<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AtividadeLivreModel;
use App\Entities\AtividadeLivreEntity;
use App\Models\AtividadeLivreRecursoModel;
use App\Entities\AtividadeLivreRecursoEntity;


class AtividadeLivre extends BaseController {    public function pesquisaModal() {
        $m = new AtividadeLivreModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vAtividadeLivre' => $m->findAll(100)
        ];
        return view('Painel/AtividadeLivre/respostaModal', $data);
    }
}
