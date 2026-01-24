<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ParticipanteEventoModel;
use App\Entities\ParticipanteEventoEntity;

class ParticipanteEvento extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/ParticipanteEvento/cadastrar');
    }

    public function doCadastrar() {
        $m = new ParticipanteEventoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new ParticipanteEventoEntity($this->request->getPost());
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
        $m = new ParticipanteEventoModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $participante = new \App\Models\ParticipanteModel();
        $evento = new \App\Models\EventoModel();
        $data = [
            'participanteevento' => $e,
            'participante' => $participante->find($e->Participante_id),
            'evento' => $evento->find($e->Evento_id),
        ];
        return view('Painel/ParticipanteEvento/alterar', $data);
    }

    public function doAlterar() {
        $m = new ParticipanteEventoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new ParticipanteEventoEntity($this->request->getPost());
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
        return view('Painel/ParticipanteEvento/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new ParticipanteEventoModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vParticipanteEvento' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/ParticipanteEvento/resposta',  $data);
    }
    
    public function listar() {
        $m = new ParticipanteEventoModel();
        $data = [
            'vParticipanteEvento' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/ParticipanteEvento/listar', $data);
    }

    public function excluir() {
        $m = new ParticipanteEventoModel();
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
        $m = new ParticipanteEventoModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vParticipanteEvento' => $m->findAll(100)
        ];
        return view('Painel/ParticipanteEvento/respostaModal', $data);
    }
}
