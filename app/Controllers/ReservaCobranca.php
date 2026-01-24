<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReservaCobrancaModel;
use App\Entities\ReservaCobrancaEntity;

class ReservaCobranca extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/ReservaCobranca/cadastrar');
    }

    public function doCadastrar() {
        $m = new ReservaCobrancaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new ReservaCobrancaEntity($this->request->getPost());
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
        $m = new ReservaCobrancaModel();
        $e = $m->find($this->request->uri->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $reserva = new \App\Models\ReservaModel();
        $cobranca = new \App\Models\CobrancaModel();
        $data = [
            'reservacobranca' => $e,
            'reserva' => $reserva->find($e->Reserva_id),
            'cobranca' => $cobranca->find($e->Cobranca_id),
        ];
        return view('Painel/ReservaCobranca/alterar', $data);
    }

    public function doAlterar() {
        $m = new ReservaCobrancaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new ReservaCobrancaEntity($this->request->getPost());
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
        return view('Painel/ReservaCobranca/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new ReservaCobrancaModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vReservaCobranca' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/ReservaCobranca/resposta',  $data);
    }
    
    public function listar() {
        $m = new ReservaCobrancaModel();
        $data = [
            'vReservaCobranca' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/ReservaCobranca/listar', $data);
    }

    public function excluir() {
        $m = new ReservaCobrancaModel();
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
        $m = new ReservaCobrancaModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vReservaCobranca' => $m->findAll(100)
        ];
        return view('Painel/ReservaCobranca/respostaModal', $data);
    }
}
