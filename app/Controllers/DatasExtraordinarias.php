<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DatasExtraordinariasModel;
use App\Entities\DatasExtraordinariasEntity;

class DatasExtraordinarias extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/DatasExtraordinarias/cadastrar');
    }

    public function doCadastrar() {
        $m = new DatasExtraordinariasModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new DatasExtraordinariasEntity($this->request->getPost());
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
        $m = new DatasExtraordinariasModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $data = [
            'datasextraordinarias' => $e,
        ];
        return view('Painel/DatasExtraordinarias/alterar', $data);
    }

    public function doAlterar() {
        $m = new DatasExtraordinariasModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new DatasExtraordinariasEntity($this->request->getPost());
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
        return view('Painel/DatasExtraordinarias/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new DatasExtraordinariasModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vDatasExtraordinarias' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/DatasExtraordinarias/resposta',  $data);
    }
    
    public function listar() {
        $m = new DatasExtraordinariasModel();
        $data = [
            'vDatasExtraordinarias' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/DatasExtraordinarias/listar', $data);
    }

    public function excluir() {
        $m = new DatasExtraordinariasModel();
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
        $m = new DatasExtraordinariasModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vDatasExtraordinarias' => $m->findAll(100)
        ];
        return view('Painel/DatasExtraordinarias/respostaModal', $data);
    }
}
