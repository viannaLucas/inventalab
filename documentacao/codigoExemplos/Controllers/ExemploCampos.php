<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ExemploCamposModel;
use App\Entities\ExemploCamposEntity;

class ExemploCampos extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/ExemploCampos/cadastrar');
    }

    public function doCadastrar() {
        $m = new ExemploCamposModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new ExemploCamposEntity($this->request->getPost());
        $e->tipoImagem = $this->getRandomName('tipoImagem');
        $e->tipoArquivo = $this->getRandomName('tipoArquivo');
        $m->db->transStart();
        try {
            if ($m->insert($e, false)) { 
                $m->uploadImage($this->request->getFile('tipoImagem'), $e->tipoImagem);
                $m->uploadFile($this->request->getFile('tipoArquivo'), $e->tipoArquivo);
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
        $m = new ExemploCamposModel();
        $e = $m->find($this->request->uri->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $tabelafk = new \App\Models\TabelafkModel();
        $data = [
            'exemplocampos' => $e,
            'tabelafk' => $tabelafk->find($e->foreignkey),
        ];
        return view('Painel/ExemploCampos/alterar', $data);
    }

    public function doAlterar() {
        $m = new ExemploCamposModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new ExemploCamposEntity($this->request->getPost());
        try{ 
            $ru['tipoImagem'] = $m->uploadImage($this->request->getFile('tipoImagem'), null, ExemploCamposEntity::folder);
            $en->tipoImagem = $ru['tipoImagem'] !== false ? $ru['tipoImagem'] : $e->tipoImagem;
            $ru['tipoArquivo'] = $m->uploadFile($this->request->getFile('tipoArquivo'), null, ExemploCamposEntity::folder);
            $en->tipoArquivo = $ru['tipoArquivo'] !== false ? $ru['tipoArquivo'] : $e->tipoArquivo;
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                if($ru['tipoImagem'] !== false) $m->deleteFile($e->tipoImagem);
                if($ru['tipoArquivo'] !== false) $m->deleteFile($e->tipoArquivo);
                $m->db->transComplete();
                return $this->returnSucess('Cadastrado com sucesso!');
            } else { 
                $m->deleteFiles($ru);
                return $this->returnWithError($m->errors());
            }
        }catch (\Exception $ex){ 
            if($ru['tipoImagem'] != false){
                $m->deleteFile($ru['tipoImagem']);
            }
            if($ru['tipoArquivo'] != false){
                $m->deleteFile($ru['tipoArquivo']);
            }
            return $this->returnWithError($ex->getMessage());
        }
    }
    
    public function pesquisar(){
        return view('Painel/ExemploCampos/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new ExemploCamposModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vExemploCampos' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/ExemploCampos/resposta',  $data);
    }
    
    public function listar() {
        $m = new ExemploCamposModel();
        $data = [
            'vExemploCampos' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/ExemploCampos/listar', $data);
    }

    public function excluir() {
        $m = new ExemploCamposModel();
        $e = $m->find($this->request->uri->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $m->db->transStart();
        if ($m->delete($e->id)) { 
            $m->deleteFile($e->tipoImagem);
            $m->deleteFile($e->tipoArquivo);
            $m->db->transComplete();
            return $this->returnSucess('Excluído com sucesso!');
        }
        return $this->returnWithError('Erro ao excluir registro.');
    }
    
    public function pesquisaModal() {
        $m = new ExemploCamposModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vExemploCampos' => $m->findAll(100)
        ];
        return view('Painel/ExemploCampos/respostaModal', $data);
    }
}
