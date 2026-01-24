<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReservaParticipanteModel;
use App\Entities\ReservaParticipanteEntity;

class ReservaParticipante extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/ReservaParticipante/cadastrar');
    }

    public function doCadastrar() {
        $m = new ReservaParticipanteModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new ReservaParticipanteEntity($this->request->getPost());
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
        $m = new ReservaParticipanteModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $participante = new \App\Models\ParticipanteModel();
        $reserva = new \App\Models\ReservaModel();
        $data = [
            'reservaparticipante' => $e,
            'participante' => $participante->find($e->Participante_id),
            'reserva' => $reserva->find($e->Reserva_id),
        ];
        return view('Painel/ReservaParticipante/alterar', $data);
    }

    public function doAlterar() {
        $m = new ReservaParticipanteModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new ReservaParticipanteEntity($this->request->getPost());
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
        return view('Painel/ReservaParticipante/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new ReservaParticipanteModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vReservaParticipante' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/ReservaParticipante/resposta',  $data);
    }
    
    public function listar() {
        $m = new ReservaParticipanteModel();
        $data = [
            'vReservaParticipante' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/ReservaParticipante/listar', $data);
    }

    public function excluir() {
        $m = new ReservaParticipanteModel();
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
        $m = new ReservaParticipanteModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vReservaParticipante' => $m->findAll(100)
        ];
        return view('Painel/ReservaParticipante/respostaModal', $data);
    }
}
