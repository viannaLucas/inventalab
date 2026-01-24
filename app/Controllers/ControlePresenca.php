<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ControlePresencaModel;
use App\Entities\ControlePresencaEntity;
use App\Models\PresencaEventoModel;
use App\Entities\PresencaEventoEntity;


class ControlePresenca extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/ControlePresenca/cadastrar');
    }

    public function doCadastrar() {
        $m = new ControlePresencaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new ControlePresencaEntity($this->request->getPost());
        $m->db->transStart();
        try {
            if ($m->insert($e, false)) { 
                $mPresencaEvento = new PresencaEventoModel();
                $PresencaEvento = $this->request->getPost('PresencaEvento') ?? [];
                foreach ($PresencaEvento as $pp){
                    $pp['ControlePresenca_id'] = $m->getInsertID();
                    $ePresencaEvento = new PresencaEventoEntity($pp);
                    if(!$mPresencaEvento->insert($ePresencaEvento, false)){
                        return $this->returnWithError($mPresencaEvento->errors());
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
        $m = new ControlePresencaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $evento = new \App\Models\EventoModel();
        $data = [
            'controlepresenca' => $e,
            'evento' => $evento->find($e->Evento_id),
        ];
        return view('Painel/ControlePresenca/alterar', $data);
    }

    public function doAlterar() {
        $m = new ControlePresencaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new ControlePresencaEntity($this->request->getPost());
        try{ 
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                $mPresencaEvento = new PresencaEventoModel();
                $idsDelete = array_map(fn($v):int => $v->id, $e->getListPresencaEvento());
                if(count($idsDelete)>0){
                    $mPresencaEvento->delete($idsDelete);
                }
                $PresencaEvento = $this->request->getPost('PresencaEvento') ?? [];
                foreach ($PresencaEvento as $pp){
                    $pp['ControlePresenca_id'] = $e->id;
                    $ePresencaEvento = new PresencaEventoEntity($pp);
                    if(!$mPresencaEvento->insert($ePresencaEvento, false)){
                        return $this->returnWithError($mPresencaEvento->errors());
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
        return view('Painel/ControlePresenca/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new ControlePresencaModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vControlePresenca' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/ControlePresenca/resposta',  $data);
    }
    
    public function listar() {
        $m = new ControlePresencaModel();
        $data = [
            'vControlePresenca' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/ControlePresenca/listar', $data);
    }

    public function excluir() {
        $m = new ControlePresencaModel();
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
        $m = new ControlePresencaModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vControlePresenca' => $m->findAll(100)
        ];
        return view('Painel/ControlePresenca/respostaModal', $data);
    }
}
