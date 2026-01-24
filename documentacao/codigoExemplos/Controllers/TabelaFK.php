<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TabelaFKModel;
use App\Entities\TabelaFKEntity;

class TabelaFK extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/TabelaFK/cadastrar');
    }

    public function doCadastrar() {
        $m = new TabelaFKModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new TabelaFKEntity($this->request->getPost());
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
        $m = new TabelaFKModel();
        $e = $m->find($this->request->uri->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $data = [
            'tabelafk' => $e,
        ];
        return view('Painel/TabelaFK/alterar', $data);
    }

    public function doAlterar() {
        $m = new TabelaFKModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new TabelaFKEntity($this->request->getPost());
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
        return view('Painel/TabelaFK/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new TabelaFKModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vTabelaFK' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/TabelaFK/resposta',  $data);
    }
    
    public function listar() {
        $m = new TabelaFKModel();
        $data = [
            'vTabelaFK' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/TabelaFK/listar', $data);
    }

    public function excluir() {
        $m = new TabelaFKModel();
        $e = $m->find($this->request->uri->getSegment(3));
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
        $m = new TabelaFKModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vTabelaFK' => $m->findAll(100)
        ];
        return view('Painel/TabelaFK/respostaModal', $data);
    }
}
