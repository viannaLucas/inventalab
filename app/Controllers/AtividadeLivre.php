<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AtividadeLivreModel;
use App\Entities\AtividadeLivreEntity;
use App\Models\AtividadeLivreRecursoModel;
use App\Entities\AtividadeLivreRecursoEntity;


class AtividadeLivre extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/AtividadeLivre/cadastrar');
    }

    public function doCadastrar() {
        $m = new AtividadeLivreModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new AtividadeLivreEntity($this->request->getPost());
        $m->db->transStart();
        try {
            if ($m->insert($e, false)) { 
                $mAtividadeLivreRecurso = new AtividadeLivreRecursoModel();
                $AtividadeLivreRecurso = $this->request->getPost('AtividadeLivreRecurso') ?? [];
                foreach ($AtividadeLivreRecurso as $pp){
                    $pp['AtividadeLivre_id'] = $m->getInsertID();
                    $eAtividadeLivreRecurso = new AtividadeLivreRecursoEntity($pp);
                    if(!$mAtividadeLivreRecurso->insert($eAtividadeLivreRecurso, false)){
                        return $this->returnWithError($mAtividadeLivreRecurso->errors());
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
        $m = new AtividadeLivreModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $reserva = new \App\Models\ReservaModel();
        $data = [
            'atividadelivre' => $e,
            'reserva' => $reserva->find($e->Reserva_id),
        ];
        return view('Painel/AtividadeLivre/visualizar', $data);
    }

    public function doAlterar() {
        $m = new AtividadeLivreModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new AtividadeLivreEntity($this->request->getPost());
        // Não permitir alteração da reserva via POST
        $en->Reserva_id = $e->Reserva_id;
        try{ 
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                $mAtividadeLivreRecurso = new AtividadeLivreRecursoModel();
                $idsDelete = array_map(fn($v):int => $v->id, $e->getListAtividadeLivreRecurso());
                if(count($idsDelete)>0){
                    $mAtividadeLivreRecurso->delete($idsDelete);
                }
                $AtividadeLivreRecurso = $this->request->getPost('AtividadeLivreRecurso') ?? [];
                foreach ($AtividadeLivreRecurso as $pp){
                    $pp['AtividadeLivre_id'] = $e->id;
                    $eAtividadeLivreRecurso = new AtividadeLivreRecursoEntity($pp);
                    if(!$mAtividadeLivreRecurso->insert($eAtividadeLivreRecurso, false)){
                        return $this->returnWithError($mAtividadeLivreRecurso->errors());
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
        return view('Painel/AtividadeLivre/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new AtividadeLivreModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vAtividadeLivre' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/AtividadeLivre/resposta',  $data);
    }
    
    public function listar() {
        $m = new AtividadeLivreModel();
        $data = [
            'vAtividadeLivre' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/AtividadeLivre/listar', $data);
    }

    public function excluir() {
        $m = new AtividadeLivreModel();
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
        $m = new AtividadeLivreModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vAtividadeLivre' => $m->findAll(100)
        ];
        return view('Painel/AtividadeLivre/respostaModal', $data);
    }
}
