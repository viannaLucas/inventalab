<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HorarioFuncionamentoModel;
use App\Entities\HorarioFuncionamentoEntity;
use App\Models\DatasExtraordinariasModel;

class HorarioFuncionamento extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        $data['vHorarioFuncionamento'] = (new HorarioFuncionamentoModel())->orderBy('diaSemana ASC, horaInicio ASC')->findAll();
        $data['vDatasExtraordinarias'] = (new DatasExtraordinariasModel())->where('data >= DATE(NOW())')->orderBy('data ASC, horaInicio ASC')->findAll();
        return view('Painel/HorarioFuncionamento/cadastrar', $data);
    }

    public function doCadastrar() {
        $m = new HorarioFuncionamentoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new HorarioFuncionamentoEntity($this->request->getPost());
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
        $m = new HorarioFuncionamentoModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $data = [
            'horariofuncionamento' => $e,
        ];
        return view('Painel/HorarioFuncionamento/alterar', $data);
    }

    public function doAlterar() {
        $m = new HorarioFuncionamentoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new HorarioFuncionamentoEntity($this->request->getPost());
        try{ 
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                $m->db->transComplete();
                return redirect()
                        ->to('/HorarioFuncionamento/cadastrar')
                        ->with('msg_sucesso', 'Cadastrado com sucesso!');
            } else { 
                return $this->returnWithError($m->errors());
            }
        }catch (\Exception $ex){ 
            return $this->returnWithError($ex->getMessage());
        }
    }
    
    public function pesquisar(){
        return view('Painel/HorarioFuncionamento/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new HorarioFuncionamentoModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vHorarioFuncionamento' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/HorarioFuncionamento/resposta',  $data);
    }
    
    public function listar() {
        $m = new HorarioFuncionamentoModel();
        $data = [
            'vHorarioFuncionamento' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/HorarioFuncionamento/listar', $data);
    }

    public function excluir() {
        $m = new HorarioFuncionamentoModel();
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
        $m = new HorarioFuncionamentoModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vHorarioFuncionamento' => $m->findAll(100)
        ];
        return view('Painel/HorarioFuncionamento/respostaModal', $data);
    }
}
