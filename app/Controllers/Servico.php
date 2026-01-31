<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ServicoModel;
use App\Models\DadosApiModel;
use App\Models\ServicoDadosApiModel;
use App\Models\ServicoProdutoModel;
use App\Entities\ServicoEntity;
use App\Entities\DadosApiEntity;
use App\Entities\ServicoDadosApiEntity;
use App\Entities\ServicoProdutoEntity;
use App\Libraries\SescAPI;

class Servico extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/Servico/cadastrar');
    }

    public function doCadastrar() {
        $m = new ServicoModel();
        $mDadosApi = new DadosApiModel();
        $mServicoDadosApi = new ServicoDadosApiModel();
        $mServicoProduto = new ServicoProdutoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $codigo = trim((string) $this->request->getPost('codigo'));
        if ($codigo === '') {
            return $this->returnWithError('O campo código é obrigatório.');
        }
        if ($mServicoDadosApi->existsCodigo($codigo)) {
            return $this->returnWithError('Já existe um serviço cadastrado com este código.');
        }
        $e = new ServicoEntity($this->request->getPost());
        $ServicoProduto = $this->request->getPost('ServicoProduto') ?? [];
        $dadosApiData = $this->getDadosApiData();
        $eDadosApi = new DadosApiEntity($dadosApiData);
        $m->db->transStart();
        try {
            if ($m->insert($e, false)) { 
                $servicoId = $m->getInsertID();
                if (!$mDadosApi->insert($eDadosApi, false)) {
                    $m->db->transRollback();
                    return $this->returnWithError($mDadosApi->errors());
                }
                $eServicoDadosApi = new ServicoDadosApiEntity([
                    'Servico_id' => $servicoId,
                    'DadosApi_id' => $mDadosApi->getInsertID(),
                ]);
                if (!$mServicoDadosApi->insert($eServicoDadosApi, false)) {
                    $m->db->transRollback();
                    return $this->returnWithError($mServicoDadosApi->errors());
                }
                foreach ($ServicoProduto as $pp){
                    $pp['Servico_id'] = $servicoId;
                    $eServicoProduto = new ServicoProdutoEntity($pp);
                    if(!$mServicoProduto->insert($eServicoProduto, false)){
                        $m->db->transRollback();
                        return $this->returnWithError($mServicoProduto->errors());
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
        $m = new ServicoModel();
        $mServicoDadosApi = new ServicoDadosApiModel();
        $mDadosApi = new DadosApiModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $dadosApi = null;
        $servicoDadosApi = $mServicoDadosApi->where('Servico_id', $e->id)->first();
        if ($servicoDadosApi !== null) {
            $dadosApi = $mDadosApi->find($servicoDadosApi->DadosApi_id);
        }
        if ($dadosApi === null) {
            $dadosApi = new DadosApiEntity();
        }
        $data = [
            'servico' => $e,
            'dadosApi' => $dadosApi,
        ];
        return view('Painel/Servico/alterar', $data);
    }

    public function doAlterar() {
        $m = new ServicoModel();
        $mDadosApi = new DadosApiModel();
        $mServicoDadosApi = new ServicoDadosApiModel();
        $mServicoProduto = new ServicoProdutoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $codigo = trim((string) $this->request->getPost('codigo'));
        if ($codigo === '') {
            return $this->returnWithError('O campo código é obrigatório.');
        }
        if ($mServicoDadosApi->existsCodigo($codigo, (int) $e->id)) {
            return $this->returnWithError('Já existe um serviço cadastrado com este código.');
        }
        $en = new ServicoEntity($this->request->getPost());
        $ServicoProduto = $this->request->getPost('ServicoProduto') ?? [];
        $dadosApiData = $this->getDadosApiData();
        $servicoDadosApi = $mServicoDadosApi->where('Servico_id', $e->id)->first();
        try{ 
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                if ($servicoDadosApi !== null) {
                    if (!$mDadosApi->update($servicoDadosApi->DadosApi_id, $dadosApiData)) {
                        $m->db->transRollback();
                        return $this->returnWithError($mDadosApi->errors());
                    }
                } else {
                    if (!$mDadosApi->insert($dadosApiData, false)) {
                        $m->db->transRollback();
                        return $this->returnWithError($mDadosApi->errors());
                    }
                    $eServicoDadosApi = new ServicoDadosApiEntity([
                        'Servico_id' => $e->id,
                        'DadosApi_id' => $mDadosApi->getInsertID(),
                    ]);
                    if (!$mServicoDadosApi->insert($eServicoDadosApi, false)) {
                        $m->db->transRollback();
                        return $this->returnWithError($mServicoDadosApi->errors());
                    }
                }
                $idsDelete = array_map(fn($v):int => $v->id, $e->getListServicoProduto());
                if(count($idsDelete)>0){
                    $mServicoProduto->delete($idsDelete);
                }
                foreach ($ServicoProduto as $pp){
                    $pp['Servico_id'] = $e->id;
                    $eServicoProduto = new ServicoProdutoEntity($pp);
                    if(!$mServicoProduto->insert($eServicoProduto, false)){
                        $m->db->transRollback();
                        return $this->returnWithError($mServicoProduto->errors());
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
        return view('Painel/Servico/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new ServicoModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vServico' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Servico/resposta',  $data);
    }
    
    public function listar() {
        $m = new ServicoModel();
        $data = [
            'vServico' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Servico/listar', $data);
    }

    public function excluir() {
        $m = new ServicoModel();
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
        $m = new ServicoModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vServico' => $m->findAll(100)
        ];
        return view('Painel/Servico/respostaModal', $data);
    }

    private function getDadosApiData(): array {
        $fields = [
            'codigo',
            'UnidadedeControle',
            'ProdutoInspecionado',
            'ProdutoFabricado',
            'ProdutoLiberado',
            'ProdutoemInventario',
            'TipodeProduto',
            'IndicacaodeLoteSerie',
            'CodigodeSituacaoTributariaCST',
            'ClassificacaoFiscal',
            'GrupodeProduto',
        ];
        $data = [];
        foreach ($fields as $field) {
            $data[$field] = $this->request->getPost($field);
        }
        return $data;
    }

    public function obterDadosServicoApiSesc(string $codigo)
    {
        $sescApi = new SescAPI([
            'baseUrl'=> env('sescApi_baseUrl'),
            'username'=> env('sescApi_username'),
            'password'=> env('sescApi_password'),
            'environment'=> env('sescApi_environment'),
            'timeout_seconds'=> env('sescApi_timeoutSeconds'),
        ]);

        $resultado = $sescApi->consultaServico($codigo);
        $decoded = $resultado['decoded_response'] ?? null;
        $raw = $resultado['raw_response'] ?? null;

        if (is_array($decoded)) {
            return $this->response->setJSON($decoded);
        }

        if (is_string($raw)) {
            return $this->response
                ->setContentType('application/json')
                ->setBody($raw);
        }

        return $this->response
            ->setStatusCode(502)
            ->setJSON(['erro' => true, 'msg' => 'Resposta inválida da API.']);
    }

    public function validarCodigoUnico()
    {
        $codigo = trim((string) $this->request->getGet('codigo'));
        $servicoIdRaw = $this->request->getGet('servicoId');
        $servicoId = is_numeric($servicoIdRaw) ? (int) $servicoIdRaw : null;

        if ($codigo === '') {
            return $this->response->setJSON([
                'valido' => false,
                'msg' => 'O campo código é obrigatório.',
            ]);
        }

        $mServicoDadosApi = new ServicoDadosApiModel();
        $jaExiste = $mServicoDadosApi->existsCodigo($codigo, $servicoId);

        if ($jaExiste) {
            return $this->response->setJSON([
                'valido' => false,
                'msg' => 'Código já cadastrado para outro serviço.',
            ]);
        }

        return $this->response->setJSON(['valido' => true]);
    }
}
