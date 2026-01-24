<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HabilidadesModel;
use App\Entities\HabilidadesEntity;

class Habilidades extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/Habilidades/cadastrar');
    }

    public function doCadastrar() {
        $m = new HabilidadesModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new HabilidadesEntity($this->request->getPost());
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
        $m = new HabilidadesModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $participante = new \App\Models\ParticipanteModel();
        $recursotrabalho = new \App\Models\RecursotrabalhoModel();
        $data = [
            'habilidades' => $e,
            'participante' => $participante->find($e->Participante_id),
            'recursotrabalho' => $recursotrabalho->find($e->RecursoTrabalho_id),
        ];
        return view('Painel/Habilidades/alterar', $data);
    }

    public function doAlterar() {
        $m = new HabilidadesModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new HabilidadesEntity($this->request->getPost());
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
        return view('Painel/Habilidades/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new HabilidadesModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vHabilidades' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Habilidades/resposta',  $data);
    }
    
    public function listar() {
        $m = new HabilidadesModel();
        $data = [
            'vHabilidades' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Habilidades/listar', $data);
    }

    public function excluir() {
        $m = new HabilidadesModel();
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
        $m = new HabilidadesModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vHabilidades' => $m->findAll(100)
        ];
        return view('Painel/Habilidades/respostaModal', $data);
    }
}
