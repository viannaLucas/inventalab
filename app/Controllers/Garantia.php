<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GarantiaModel;
use App\Entities\GarantiaEntity;

class Garantia extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/Garantia/cadastrar');
    }

    public function doCadastrar() {
        $m = new GarantiaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new GarantiaEntity($this->request->getPost());
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
        $m = new GarantiaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $recursotrabalho = new \App\Models\RecursotrabalhoModel();
        $data = [
            'garantia' => $e,
            'recursotrabalho' => $recursotrabalho->find($e->RecursoTrabalho_id),
        ];
        return view('Painel/Garantia/alterar', $data);
    }

    public function doAlterar() {
        $m = new GarantiaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new GarantiaEntity($this->request->getPost());
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
        return view('Painel/Garantia/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new GarantiaModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vGarantia' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Garantia/resposta',  $data);
    }
    
    public function listar() {
        $m = new GarantiaModel();
        $data = [
            'vGarantia' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Garantia/listar', $data);
    }

    public function excluir() {
        $m = new GarantiaModel();
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
        $m = new GarantiaModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vGarantia' => $m->findAll(100)
        ];
        return view('Painel/Garantia/respostaModal', $data);
    }
}
