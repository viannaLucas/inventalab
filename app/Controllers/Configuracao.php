<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConfiguracaoModel;
use App\Entities\ConfiguracaoEntity;

class Configuracao extends BaseController {

    public function index() {
        return $this->alterar();
    }

    // public function cadastrar() {
    //     return view('Painel/Configuracao/cadastrar');
    // }

    // public function doCadastrar() {
    //     $m = new ConfiguracaoModel();
    //     $ef = $this->validateWithRequest($m->getValidationRulesFiles());
    //     if ($ef !== true) {
    //         return $this->returnWithError($ef);
    //     }
    //     $e = new ConfiguracaoEntity($this->request->getPost());
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
        $m = new ConfiguracaoModel();
        $e = $m->find(1);
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $data = [
            'configuracao' => $e,
        ];
        return view('Painel/Configuracao/alterar', $data);
    }

    public function doAlterar() {
        $m = new ConfiguracaoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new ConfiguracaoEntity($this->request->getPost());
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
    
    // public function pesquisar(){
    //     return view('Painel/Configuracao/pesquisar');
    // }
    
    // public function doPesquisar(){
    //     $m = new ConfiguracaoModel();
    //     $m->buildFindList($this->request->getGet());
    //     $data = [
    //         'vConfiguracao' => $m->paginate(self::itensPaginacao),
    //         'pager' => $m->pager,
    //     ];
    //     return view('Painel/Configuracao/resposta',  $data);
    // }
    
    // public function listar() {
    //     $m = new ConfiguracaoModel();
    //     $data = [
    //         'vConfiguracao' => $m->paginate(self::itensPaginacao),
    //         'pager' => $m->pager,
    //     ];
    //     return view('Painel/Configuracao/listar', $data);
    // }

    // public function excluir() {
    //     $m = new ConfiguracaoModel();
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
    //     $m = new ConfiguracaoModel();
    //     $m->buildFindModal($this->request->getGet('searchTerm'));
    //     $data = [
    //         'vConfiguracao' => $m->findAll(100)
    //     ];
    //     return view('Painel/Configuracao/respostaModal', $data);
    // }
}
