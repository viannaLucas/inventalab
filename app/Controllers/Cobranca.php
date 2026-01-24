<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CobrancaModel;
use App\Entities\CobrancaEntity;
use App\Models\CobrancaServicoModel;
use App\Entities\CobrancaServicoEntity;
use App\Models\CobrancaProdutoModel;
use App\Entities\CobrancaProdutoEntity;


class Cobranca extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/Cobranca/cadastrar');
    }

    public function doCadastrar() {
        $m = new CobrancaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new CobrancaEntity($this->request->getPost());
        $m->db->transStart();
        try {
            if ($m->insert($e, false)) { 
                $mCobrancaServico = new CobrancaServicoModel();
                $CobrancaServico = $this->request->getPost('CobrancaServico') ?? [];
                foreach ($CobrancaServico as $pp){
                    $pp['Cobranca_id'] = $m->getInsertID();
                    $eCobrancaServico = new CobrancaServicoEntity($pp);
                    if(!$mCobrancaServico->insert($eCobrancaServico, false)){
                        return $this->returnWithError($mCobrancaServico->errors());
                    }
                }
                $mCobrancaProduto = new CobrancaProdutoModel();
                $CobrancaProduto = $this->request->getPost('CobrancaProduto') ?? [];
                foreach ($CobrancaProduto as $pp){
                    $pp['Cobranca_id'] = $m->getInsertID();
                    $eCobrancaProduto = new CobrancaProdutoEntity($pp);
                    if(!$mCobrancaProduto->insert($eCobrancaProduto, false)){
                        return $this->returnWithError($mCobrancaProduto->errors());
                    }
                }
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
        $m = new CobrancaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $participante = new \App\Models\ParticipanteModel();
        $data = [
            'cobranca' => $e,
            'participante' => $participante->find($e->Participante_id),
        ];
        return view('Painel/Cobranca/alterar', $data);
    }

    public function doAlterar() {
        $m = new CobrancaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new CobrancaEntity($this->request->getPost());
        try{ 
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                $mCobrancaServico = new CobrancaServicoModel();
                $idsDelete = array_map(fn($v):int => $v->id, $e->getListCobrancaServico());
                if(count($idsDelete)>0){
                    $mCobrancaServico->delete($idsDelete);
                }
                $CobrancaServico = $this->request->getPost('CobrancaServico') ?? [];
                foreach ($CobrancaServico as $pp){
                    $pp['Cobranca_id'] = $e->id;
                    $eCobrancaServico = new CobrancaServicoEntity($pp);
                    if(!$mCobrancaServico->insert($eCobrancaServico, false)){
                        return $this->returnWithError($mCobrancaServico->errors());
                    }
                }
                $mCobrancaProduto = new CobrancaProdutoModel();
                $idsDeleteProduto = array_map(fn($v):int => $v->id, $e->getListCobrancaProduto());
                if(count($idsDeleteProduto)>0){
                    $mCobrancaProduto->delete($idsDeleteProduto);
                }
                $CobrancaProduto = $this->request->getPost('CobrancaProduto') ?? [];
                foreach ($CobrancaProduto as $pp){
                    $pp['Cobranca_id'] = $e->id;
                    $eCobrancaProduto = new CobrancaProdutoEntity($pp);
                    if(!$mCobrancaProduto->insert($eCobrancaProduto, false)){
                        return $this->returnWithError($mCobrancaProduto->errors());
                    }
                }
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
        return view('Painel/Cobranca/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new CobrancaModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vCobranca' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Cobranca/resposta',  $data);
    }
    
    public function listar() {
        $m = new CobrancaModel();
        $data = [
            'vCobranca' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Cobranca/listar', $data);
    }

    public function excluir() {
        $m = new CobrancaModel();
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
        $m = new CobrancaModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vCobranca' => $m->findAll(100)
        ];
        return view('Painel/Cobranca/respostaModal', $data);
    }
}
