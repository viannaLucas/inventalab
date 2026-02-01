<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ControlePresencaModel;
use App\Entities\ControlePresencaEntity;
use App\Models\PresencaEventoModel;
use App\Entities\PresencaEventoEntity;


class ControlePresenca extends BaseController {    public function pesquisaModal() {
        $m = new ControlePresencaModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vControlePresenca' => $m->findAll(100)
        ];
        return view('Painel/ControlePresenca/respostaModal', $data);
    }
}
