<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OficinaTematicaReservaModel;
use App\Entities\OficinaTematicaReservaEntity;

class OficinaTematicaReserva extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/OficinaTematicaReserva/cadastrar');
    }

    public function doCadastrar() {
        $m = new OficinaTematicaReservaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new OficinaTematicaReservaEntity($this->request->getPost());
        $m->db->transStart();
        try {
            if ($m->insert($e, false)) { 
                $m->db->transComplete();
                return $this->returnSucess('Cadastrado com sucesso!');
            } else {
                return $this->returnWithError($m->errors());
            }
        } catch (\Exception $ex) {
            return $this->returnWithError($ex->getMessage());
        }
    }

    public function alterar() {
        $m = new OficinaTematicaReservaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $reserva = new \App\Models\ReservaModel();
        $oficinatematica = new \App\Models\OficinatematicaModel();
        $data = [
            'oficinatematicareserva' => $e,
            'reserva' => $reserva->find($e->Reserva_id),
            'oficinatematica' => $oficinatematica->find($e->OficinaTematica_id),
        ];
        return view('Painel/OficinaTematicaReserva/alterar', $data);
    }

    public function doAlterar() {
        $m = new OficinaTematicaReservaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new OficinaTematicaReservaEntity($this->request->getPost());
        try{ 
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                $m->db->transComplete();
                return $this->returnSucess('Cadastrado com sucesso!');
            } else { 
                return $this->returnWithError($m->errors());
            }
        }catch (\Exception $ex){ 
            return $this->returnWithError($ex->getMessage());
        }
    }
    
    public function pesquisar(){
        return view('Painel/OficinaTematicaReserva/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new OficinaTematicaReservaModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vOficinaTematicaReserva' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/OficinaTematicaReserva/resposta',  $data);
    }
    
    public function listar() {
        $m = new OficinaTematicaReservaModel();
        $data = [
            'vOficinaTematicaReserva' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/OficinaTematicaReserva/listar', $data);
    }

    public function excluir() {
        $m = new OficinaTematicaReservaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $m->db->transStart();
        if ($m->delete($e->id)) { 
            $m->db->transComplete();
            return $this->returnSucess('Excluído com sucesso!');
        }
        return $this->returnWithError('Erro ao excluir registro.');
    }
    
    public function pesquisaModal() {
        $m = new OficinaTematicaReservaModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vOficinaTematicaReserva' => $m->findAll(100)
        ];
        return view('Painel/OficinaTematicaReserva/respostaModal', $data);
    }
}
