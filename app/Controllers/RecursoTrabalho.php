<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RecursoTrabalhoModel;
use App\Entities\RecursoTrabalhoEntity;
use App\Models\GarantiaModel;
use App\Entities\GarantiaEntity;


class RecursoTrabalho extends BaseController
{

    public function index()
    {
        return $this->cadastrar();
    }

    public function cadastrar()
    {
        return view('Painel/RecursoTrabalho/cadastrar');
    }

    public function doCadastrar()
    {
        $m = new RecursoTrabalhoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new RecursoTrabalhoEntity($this->request->getPost());
        $e->foto = $this->getRandomName('foto');
        $m->db->transStart();
        try {
            if ($m->insert($e, false)) {
                $m->uploadImage($this->request->getFile('foto'), $e->foto);
                $mGarantia = new GarantiaModel();
                $Garantia = $this->request->getPost('Garantia') ?? [];
                foreach ($Garantia as $pp) {
                    $pp['RecursoTrabalho_id'] = $m->getInsertID();
                    $eGarantia = new GarantiaEntity($pp);
                    if (!$mGarantia->insert($eGarantia, false)) {
                        return $this->returnWithError($mGarantia->errors());
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

    public function alterar()
    {
        $m = new RecursoTrabalhoModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $data = [
            'recursotrabalho' => $e,
        ];
        return view('Painel/RecursoTrabalho/alterar', $data);
    }

    public function doAlterar()
    {
        $m = new RecursoTrabalhoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new RecursoTrabalhoEntity($this->request->getPost());
        try {
            $ru['foto'] = $m->uploadImage($this->request->getFile('foto'), null, RecursoTrabalhoEntity::folder);
            $en->foto = $ru['foto'] !== false ? $ru['foto'] : $e->foto;
            $m->db->transStart();
            if ($m->update($en->id, $en)) {
                $mGarantia = new GarantiaModel();
                $idsDelete = array_map(fn($v): int => $v->id, $e->getListGarantia());
                if (count($idsDelete) > 0) {
                    $mGarantia->delete($idsDelete);
                }
                $Garantia = $this->request->getPost('Garantia') ?? [];
                foreach ($Garantia as $pp) {
                    $pp['RecursoTrabalho_id'] = $e->id;
                    $eGarantia = new GarantiaEntity($pp);
                    if (!$mGarantia->insert($eGarantia, false)) {
                        return $this->returnWithError($mGarantia->errors());
                    }
                }
                if ($ru['foto'] !== false) $m->deleteFile($e->foto);
                $m->db->transComplete();
                return $this->returnSucess('Cadastrado com sucesso!');
            } else {
                $m->deleteFiles($ru);
                return $this->returnWithError($m->errors());
            }
        } catch (\Exception $ex) {
            if ($ru['foto'] != false) {
                $m->deleteFile($ru['foto']);
            }
            return $this->returnWithError($ex->getMessage());
        }
    }

    public function pesquisar()
    {
        return view('Painel/RecursoTrabalho/pesquisar');
    }

    public function doPesquisar()
    {
        $m = new RecursoTrabalhoModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vRecursoTrabalho' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/RecursoTrabalho/resposta',  $data);
    }

    public function listar()
    {
        $m = new RecursoTrabalhoModel();
        $data = [
            'vRecursoTrabalho' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/RecursoTrabalho/listar', $data);
    }
    public function pesquisaModal()
    {
        $m = new RecursoTrabalhoModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vRecursoTrabalho' => $m->findAll(100)
        ];
        return view('Painel/RecursoTrabalho/respostaModal', $data);
    }
}
