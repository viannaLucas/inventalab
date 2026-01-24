<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PresencaEventoModel;
use App\Entities\PresencaEventoEntity;

class PresencaEvento extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/PresencaEvento/cadastrar');
    }

    public function doCadastrar() {
        $m = new PresencaEventoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new PresencaEventoEntity($this->request->getPost());
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
        $m = new PresencaEventoModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $participanteevento = new \App\Models\ParticipanteeventoModel();
        $controlepresenca = new \App\Models\ControlepresencaModel();
        $data = [
            'presencaevento' => $e,
            'participanteevento' => $participanteevento->find($e->ParticipanteEvento_id),
            'controlepresenca' => $controlepresenca->find($e->ControlePresenta_id),
        ];
        return view('Painel/PresencaEvento/alterar', $data);
    }

    public function doAlterar() {
        $m = new PresencaEventoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new PresencaEventoEntity($this->request->getPost());
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
        return view('Painel/PresencaEvento/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new PresencaEventoModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vPresencaEvento' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/PresencaEvento/resposta',  $data);
    }
    
    public function listar() {
        $m = new PresencaEventoModel();
        $data = [
            'vPresencaEvento' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/PresencaEvento/listar', $data);
    }

    public function excluir() {
        $m = new PresencaEventoModel();
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
        $m = new PresencaEventoModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vPresencaEvento' => $m->findAll(100)
        ];
        return view('Painel/PresencaEvento/respostaModal', $data);
    }
}
