<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TemplateTermoModel;
use App\Entities\TemplateTermoEntity;

class TemplateTermo extends BaseController {

    public function index() {
        return $this->alterar();
    }

    // public function cadastrar() {
    //     return view('Painel/TemplateTermo/cadastrar');
    // }

    // public function doCadastrar() {
    //     $m = new TemplateTermoModel();
    //     $ef = $this->validateWithRequest($m->getValidationRulesFiles());
    //     if ($ef !== true) {
    //         return $this->returnWithError($ef);
    //     }
    //     $e = new TemplateTermoEntity($this->request->getPost());
    //     $m->db->transStart();
    //     try {
    //         if ($m->insert($e, false)) { 
    //             $m->db->transComplete();
    //             return $this->returnSucess('Cadastrado com sucesso!');
    //         } else {
    //             return $this->returnWithError($m->errors());
    //         }
    //     } catch (\Exception $ex) {
    //         return $this->returnWithError($ex->getMessage());
    //     }
    // }

    public function alterar() {
        $m = new TemplateTermoModel();
        // $e = $m->find($this->request->getUri()->getSegment(3));
        $e = $m->find(1);
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $data = [
            'templatetermo' => $e,
        ];
        return view('Painel/TemplateTermo/alterar', $data);
    }

    public function doAlterar() {
        $m = new TemplateTermoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $e->texto = $this->request->getPost('texto');
        try{ 
            $m->db->transStart();
            if ($m->update($e->id, $e)) { 
                $m->db->transComplete();
                return $this->returnSucess('Cadastrado com sucesso!');
            } else { 
                return $this->returnWithError($m->errors());
            }
        }catch (\Exception $ex){ 
            return $this->returnWithError($ex->getMessage());
        }
    }
    
    // public function pesquisar(){
    //     return view('Painel/TemplateTermo/pesquisar');
    // }
    
    // public function doPesquisar(){
    //     $m = new TemplateTermoModel();
    //     $m->buildFindList($this->request->getGet());
    //     $data = [
    //         'vTemplateTermo' => $m->paginate(self::itensPaginacao),
    //         'pager' => $m->pager,
    //     ];
    //     return view('Painel/TemplateTermo/resposta',  $data);
    // }
    
    // public function listar() {
    //     $m = new TemplateTermoModel();
    //     $data = [
    //         'vTemplateTermo' => $m->paginate(self::itensPaginacao),
    //         'pager' => $m->pager,
    //     ];
    //     return view('Painel/TemplateTermo/listar', $data);
    // }

    // public function excluir() {
    //     $m = new TemplateTermoModel();
    //     $e = $m->find($this->request->getUri()->getSegment(3));
    //     if ($e === null) {
    //         return $this->returnWithError('Registro não encontrado.');
    //     }
    //     $m->db->transStart();
    //     if ($m->delete($e->id)) { 
    //         $m->db->transComplete();
    //         return $this->returnSucess('Excluído com sucesso!');
    //     }
    //     return $this->returnWithError('Erro ao excluir registro.');
    // }
    
    // public function pesquisaModal() {
    //     $m = new TemplateTermoModel();
    //     $m->buildFindModal($this->request->getGet('searchTerm'));
    //     $data = [
    //         'vTemplateTermo' => $m->findAll(100)
    //     ];
    //     return view('Painel/TemplateTermo/respostaModal', $data);
    // }
}
