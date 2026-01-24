<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OficinaTematicaModel;
use App\Entities\OficinaTematicaEntity;
use App\Models\ArquivoOficinaModel;
use App\Entities\ArquivoOficinaEntity;

use App\Models\MaterialOficinaModel;
use App\Entities\MaterialOficinaEntity;

use App\Models\RecursoOficinaModel;
use App\Entities\RecursoOficinaEntity;


class OficinaTematica extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/OficinaTematica/cadastrar');
    }

    public function doCadastrar() {
        $m = new OficinaTematicaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new OficinaTematicaEntity($this->request->getPost());
        $m->db->transStart();
        try {
            if ($m->insert($e, false)) { 
                $mArquivoOficina = new ArquivoOficinaModel();
                $ArquivoOficina = $this->request->getPost('ArquivoOficina') ?? [];
                foreach ($ArquivoOficina as $pp){
                    $pp['OficinaTematica_id'] = $m->getInsertID();
                    $eArquivoOficina = new ArquivoOficinaEntity($pp);
                    if(!$mArquivoOficina->insert($eArquivoOficina, false)){
                        return $this->returnWithError($mArquivoOficina->errors());
                    }
                }
                $mMaterialOficina = new MaterialOficinaModel();
                $MaterialOficina = $this->request->getPost('MaterialOficina') ?? [];
                foreach ($MaterialOficina as $pp){
                    $pp['OficinaTematica_id'] = $m->getInsertID();
                    $eMaterialOficina = new MaterialOficinaEntity($pp);
                    if(!$mMaterialOficina->insert($eMaterialOficina, false)){
                        return $this->returnWithError($mMaterialOficina->errors());
                    }
                }
                $mRecursoOficina = new RecursoOficinaModel();
                $RecursoOficina = $this->request->getPost('RecursoOficina') ?? [];
                foreach ($RecursoOficina as $pp){
                    $pp['OficinaTematica_id'] = $m->getInsertID();
                    $eRecursoOficina = new RecursoOficinaEntity($pp);
                    if(!$mRecursoOficina->insert($eRecursoOficina, false)){
                        return $this->returnWithError($mRecursoOficina->errors());
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
        $m = new OficinaTematicaModel();
        $e = $m->where('situacao', 0)->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $data = [
            'oficinatematica' => $e,
        ];
        return view('Painel/OficinaTematica/alterar', $data);
    }

    public function doAlterar() {
        $m = new OficinaTematicaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->where('situacao', 0)->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new OficinaTematicaEntity($this->request->getPost());
        try{ 
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                $mArquivoOficina = new ArquivoOficinaModel();
                $idsDelete = array_map(fn($v):int => $v->id, $e->getListArquivoOficina());
                if(count($idsDelete)>0){
                    $mArquivoOficina->delete($idsDelete);
                }
                $ArquivoOficina = $this->request->getPost('ArquivoOficina') ?? [];
                foreach ($ArquivoOficina as $pp){
                    $pp['OficinaTematica_id'] = $e->id;
                    $eArquivoOficina = new ArquivoOficinaEntity($pp);
                    if(!$mArquivoOficina->insert($eArquivoOficina, false)){
                        return $this->returnWithError($mArquivoOficina->errors());
                    }
                }
                $mMaterialOficina = new MaterialOficinaModel();
                $idsDelete = array_map(fn($v):int => $v->id, $e->getListMaterialOficina());
                if(count($idsDelete)>0){
                    $mMaterialOficina->delete($idsDelete);
                }
                $MaterialOficina = $this->request->getPost('MaterialOficina') ?? [];
                foreach ($MaterialOficina as $pp){
                    $pp['OficinaTematica_id'] = $e->id;
                    $eMaterialOficina = new MaterialOficinaEntity($pp);
                    if(!$mMaterialOficina->insert($eMaterialOficina, false)){
                        return $this->returnWithError($mMaterialOficina->errors());
                    }
                }
                $mRecursoOficina = new RecursoOficinaModel();
                $idsDelete = array_map(fn($v):int => $v->id, $e->getListRecursoOficina());
                if(count($idsDelete)>0){
                    $mRecursoOficina->delete($idsDelete);
                }
                $RecursoOficina = $this->request->getPost('RecursoOficina') ?? [];
                foreach ($RecursoOficina as $pp){
                    $pp['OficinaTematica_id'] = $e->id;
                    $eRecursoOficina = new RecursoOficinaEntity($pp);
                    if(!$mRecursoOficina->insert($eRecursoOficina, false)){
                        return $this->returnWithError($mRecursoOficina->errors());
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
        return view('Painel/OficinaTematica/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new OficinaTematicaModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vOficinaTematica' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/OficinaTematica/resposta',  $data);
    }
    
    public function listar() {
        $m = new OficinaTematicaModel();
        $m->where('situacao', 0);
        $data = [
            'vOficinaTematica' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/OficinaTematica/listar', $data);
    }

    public function excluir() {
        $m = new OficinaTematicaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        if ((int) $e->situacao === 1) {
            return $this->returnWithError('Registro já se encontra excluído.');
        }
        $m->db->transStart();
        if ($m->marcarExcluido($e->id)) { 
            $m->db->transComplete();
            return $this->returnSucess('Excluído com sucesso!');
        }
        return $this->returnWithError('Erro ao excluir registro.');
    }
    
    public function pesquisaModal() {
        $m = new OficinaTematicaModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vOficinaTematica' => $m->findAll(100)
        ];
        return view('Painel/OficinaTematica/respostaModal', $data);
    }
    
    public function descricao() {
        $m = new OficinaTematicaModel();
        $e = $m->where('situacao', 0)->find($this->request->getUri()->getSegment(3));
        $data = [];
        if ($e === null) {
            $data['error'] = true;
            $data['msg'] = 'Oficina Temática não encontrada!';
            $data['html'] = '';
            return $this->response->setJSON($data);
        }
        $data['error'] = false;
        $data['msg'] = '';
        $data['html'] = $e->descricaoAtividade;
        return $this->response->setJSON($data);
    }
}
