<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CobrancaServicoModel;
use App\Entities\CobrancaServicoEntity;

class CobrancaServico extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/CobrancaServico/cadastrar');
    }

    public function doCadastrar() {
        $m = new CobrancaServicoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new CobrancaServicoEntity($this->request->getPost());
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
        $m = new CobrancaServicoModel();
        $e = $m->find($this->request->uri->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $cobranca = new \App\Models\CobrancaModel();
        $servico = new \App\Models\ServicoModel();
        $data = [
            'cobrancaservico' => $e,
            'cobranca' => $cobranca->find($e->Cobranca_id),
            'servico' => $servico->find($e->Servico_id),
        ];
        return view('Painel/CobrancaServico/alterar', $data);
    }

    public function doAlterar() {
        $m = new CobrancaServicoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new CobrancaServicoEntity($this->request->getPost());
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
        return view('Painel/CobrancaServico/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new CobrancaServicoModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vCobrancaServico' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/CobrancaServico/resposta',  $data);
    }
    
    public function listar() {
        $m = new CobrancaServicoModel();
        $data = [
            'vCobrancaServico' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/CobrancaServico/listar', $data);
    }

    public function excluir() {
        $m = new CobrancaServicoModel();
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
        $m = new CobrancaServicoModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vCobrancaServico' => $m->findAll(100)
        ];
        return view('Painel/CobrancaServico/respostaModal', $data);
    }
}
