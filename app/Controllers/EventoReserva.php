<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventoReservaModel;
use App\Entities\EventoReservaEntity;

class EventoReserva extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/EventoReserva/cadastrar');
    }

    public function doCadastrar() {
        $m = new EventoReservaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new EventoReservaEntity($this->request->getPost());
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
        $m = new EventoReservaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $reserva = new \App\Models\ReservaModel();
        $evento = new \App\Models\EventoModel();
        $data = [
            'eventoreserva' => $e,
            'reserva' => $reserva->find($e->Reserva_id),
            'evento' => $evento->find($e->Evento_id),
        ];
        return view('Painel/EventoReserva/alterar', $data);
    }

    public function doAlterar() {
        $m = new EventoReservaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new EventoReservaEntity($this->request->getPost());
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
        return view('Painel/EventoReserva/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new EventoReservaModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vEventoReserva' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/EventoReserva/resposta',  $data);
    }
    
    public function listar() {
        $m = new EventoReservaModel();
        $data = [
            'vEventoReserva' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/EventoReserva/listar', $data);
    }

    public function excluir() {
        $m = new EventoReservaModel();
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
        $m = new EventoReservaModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vEventoReserva' => $m->findAll(100)
        ];
        return view('Painel/EventoReserva/respostaModal', $data);
    }
}
