<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArquivoOficinaModel;
use App\Entities\ArquivoOficinaEntity;

class ArquivoOficina extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/ArquivoOficina/cadastrar');
    }

    public function doCadastrar() {
        $m = new ArquivoOficinaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new ArquivoOficinaEntity($this->request->getPost());
        $e->arquivo = $this->getRandomName('arquivo');
        $m->db->transStart();
        try {
            if ($m->insert($e, false)) { 
                $m->uploadFile($this->request->getFile('arquivo'), $e->arquivo);
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
        $m = new ArquivoOficinaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $oficinatematica = new \App\Models\OficinatematicaModel();
        $data = [
            'arquivooficina' => $e,
            'oficinatematica' => $oficinatematica->find($e->OficinaTematica_id),
        ];
        return view('Painel/ArquivoOficina/alterar', $data);
    }

    public function doAlterar() {
        $m = new ArquivoOficinaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new ArquivoOficinaEntity($this->request->getPost());
        try{ 
            $ru['arquivo'] = $m->uploadFile($this->request->getFile('arquivo'), null, ArquivoOficinaEntity::folder);
            $en->arquivo = $ru['arquivo'] !== false ? $ru['arquivo'] : $e->arquivo;
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                if($ru['arquivo'] !== false) $m->deleteFile($e->arquivo);
                $m->db->transComplete();
                return $this->returnSucess('Cadastrado com sucesso!');
            } else { 
                $m->deleteFiles($ru);
                return $this->returnWithError($m->errors());
            }
        }catch (\Exception $ex){ 
            if($ru['arquivo'] != false){
                $m->deleteFile($ru['arquivo']);
            }
            return $this->returnWithError($ex->getMessage());
        }
    }
    
    public function pesquisar(){
        return view('Painel/ArquivoOficina/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new ArquivoOficinaModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vArquivoOficina' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/ArquivoOficina/resposta',  $data);
    }
    
    public function listar() {
        $m = new ArquivoOficinaModel();
        $data = [
            'vArquivoOficina' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/ArquivoOficina/listar', $data);
    }

    public function excluir() {
        $m = new ArquivoOficinaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $m->db->transStart();
        if ($m->delete($e->id)) { 
            $m->deleteFile($e->arquivo);
            $m->db->transComplete();
            return $this->returnSucess('Excluído com sucesso!');
        }
        return $this->returnWithError('Erro ao excluir registro.');
    }
    
    public function pesquisaModal() {
        $m = new ArquivoOficinaModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vArquivoOficina' => $m->findAll(100)
        ];
        return view('Painel/ArquivoOficina/respostaModal', $data);
    }
}
