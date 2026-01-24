<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RecursoOficinaModel;
use App\Entities\RecursoOficinaEntity;

class RecursoOficina extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/RecursoOficina/cadastrar');
    }

    public function doCadastrar() {
        $m = new RecursoOficinaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new RecursoOficinaEntity($this->request->getPost());
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
        $m = new RecursoOficinaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $recursotrabalho = new \App\Models\RecursotrabalhoModel();
        $oficinatematica = new \App\Models\OficinatematicaModel();
        $data = [
            'recursooficina' => $e,
            'recursotrabalho' => $recursotrabalho->find($e->RecursoTrabalho_id),
            'oficinatematica' => $oficinatematica->find($e->OficinaTematica_id),
        ];
        return view('Painel/RecursoOficina/alterar', $data);
    }

    public function doAlterar() {
        $m = new RecursoOficinaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new RecursoOficinaEntity($this->request->getPost());
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
        return view('Painel/RecursoOficina/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new RecursoOficinaModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vRecursoOficina' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/RecursoOficina/resposta',  $data);
    }
    
    public function listar() {
        $m = new RecursoOficinaModel();
        $data = [
            'vRecursoOficina' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/RecursoOficina/listar', $data);
    }

    public function excluir() {
        $m = new RecursoOficinaModel();
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
        $m = new RecursoOficinaModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vRecursoOficina' => $m->findAll(100)
        ];
        return view('Painel/RecursoOficina/respostaModal', $data);
    }
}
