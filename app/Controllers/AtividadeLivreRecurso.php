<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AtividadeLivreRecursoModel;
use App\Entities\AtividadeLivreRecursoEntity;

class AtividadeLivreRecurso extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/AtividadeLivreRecurso/cadastrar');
    }

    public function doCadastrar() {
        $m = new AtividadeLivreRecursoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new AtividadeLivreRecursoEntity($this->request->getPost());
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
        $m = new AtividadeLivreRecursoModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $atividadelivre = new \App\Models\AtividadelivreModel();
        $recursotrabalho = new \App\Models\RecursotrabalhoModel();
        $data = [
            'atividadelivrerecurso' => $e,
            'atividadelivre' => $atividadelivre->find($e->AtividadeLivre_id),
            'recursotrabalho' => $recursotrabalho->find($e->RecursoTrabalho_id),
        ];
        return view('Painel/AtividadeLivreRecurso/alterar', $data);
    }

    public function doAlterar() {
        $m = new AtividadeLivreRecursoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new AtividadeLivreRecursoEntity($this->request->getPost());
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
        return view('Painel/AtividadeLivreRecurso/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new AtividadeLivreRecursoModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vAtividadeLivreRecurso' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/AtividadeLivreRecurso/resposta',  $data);
    }
    
    public function listar() {
        $m = new AtividadeLivreRecursoModel();
        $data = [
            'vAtividadeLivreRecurso' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/AtividadeLivreRecurso/listar', $data);
    }

    public function excluir() {
        $m = new AtividadeLivreRecursoModel();
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
        $m = new AtividadeLivreRecursoModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vAtividadeLivreRecurso' => $m->findAll(100)
        ];
        return view('Painel/AtividadeLivreRecurso/respostaModal', $data);
    }
}
