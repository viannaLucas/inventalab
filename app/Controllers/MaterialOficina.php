<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MaterialOficinaModel;
use App\Entities\MaterialOficinaEntity;

class MaterialOficina extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/MaterialOficina/cadastrar');
    }

    public function doCadastrar() {
        $m = new MaterialOficinaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new MaterialOficinaEntity($this->request->getPost());
        $e->foto = $this->getRandomName('foto');
        $m->db->transStart();
        try {
            if ($m->insert($e, false)) { 
                $m->uploadImage($this->request->getFile('foto'), $e->foto);
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
        $m = new MaterialOficinaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $oficinatematica = new \App\Models\OficinatematicaModel();
        $data = [
            'materialoficina' => $e,
            'oficinatematica' => $oficinatematica->find($e->OficinaTematica_id),
        ];
        return view('Painel/MaterialOficina/alterar', $data);
    }

    public function doAlterar() {
        $m = new MaterialOficinaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new MaterialOficinaEntity($this->request->getPost());
        try{ 
            $ru['foto'] = $m->uploadImage($this->request->getFile('foto'), null, MaterialOficinaEntity::folder);
            $en->foto = $ru['foto'] !== false ? $ru['foto'] : $e->foto;
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                if($ru['foto'] !== false) $m->deleteFile($e->foto);
                $m->db->transComplete();
                return $this->returnSucess('Cadastrado com sucesso!');
            } else { 
                $m->deleteFiles($ru);
                return $this->returnWithError($m->errors());
            }
        }catch (\Exception $ex){ 
            if($ru['foto'] != false){
                $m->deleteFile($ru['foto']);
            }
            return $this->returnWithError($ex->getMessage());
        }
    }
    
    public function pesquisar(){
        return view('Painel/MaterialOficina/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new MaterialOficinaModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vMaterialOficina' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/MaterialOficina/resposta',  $data);
    }
    
    public function listar() {
        $m = new MaterialOficinaModel();
        $data = [
            'vMaterialOficina' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/MaterialOficina/listar', $data);
    }

    public function excluir() {
        $m = new MaterialOficinaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $m->db->transStart();
        if ($m->delete($e->id)) { 
            $m->deleteFile($e->foto);
            $m->db->transComplete();
            return $this->returnSucess('Excluído com sucesso!');
        }
        return $this->returnWithError('Erro ao excluir registro.');
    }
    
    public function pesquisaModal() {
        $m = new MaterialOficinaModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vMaterialOficina' => $m->findAll(100)
        ];
        return view('Painel/MaterialOficina/respostaModal', $data);
    }
}
