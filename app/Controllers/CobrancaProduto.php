<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CobrancaProdutoModel;
use App\Entities\CobrancaProdutoEntity;

class CobrancaProduto extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/CobrancaProduto/cadastrar');
    }

    public function doCadastrar() {
        $m = new CobrancaProdutoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new CobrancaProdutoEntity($this->request->getPost());
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
        $m = new CobrancaProdutoModel();
        $e = $m->find($this->request->uri->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $cobranca = new \App\Models\CobrancaModel();
        $produto = new \App\Models\ProdutoModel();
        $data = [
            'cobrancaproduto' => $e,
            'cobranca' => $cobranca->find($e->Cobranca_id),
            'produto' => $produto->find($e->Produto_id),
        ];
        return view('Painel/CobrancaProduto/alterar', $data);
    }

    public function doAlterar() {
        $m = new CobrancaProdutoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new CobrancaProdutoEntity($this->request->getPost());
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
        return view('Painel/CobrancaProduto/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new CobrancaProdutoModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vCobrancaProduto' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/CobrancaProduto/resposta',  $data);
    }
    
    public function listar() {
        $m = new CobrancaProdutoModel();
        $data = [
            'vCobrancaProduto' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/CobrancaProduto/listar', $data);
    }

    public function excluir() {
        $m = new CobrancaProdutoModel();
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
        $m = new CobrancaProdutoModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vCobrancaProduto' => $m->findAll(100)
        ];
        return view('Painel/CobrancaProduto/respostaModal', $data);
    }
}
