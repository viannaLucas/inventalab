<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ServicoModel;
use App\Models\DadosApiModel;
use App\Models\ServicoDadosApiModel;
use App\Libraries\ApiSesc;
use App\Entities\ServicoEntity;
use App\Entities\DadosApiEntity;
use App\Entities\ServicoDadosApiEntity;

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
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new ServicoEntity($this->request->getPost());
        $dadosApiData = $this->getDadosApiData();
        $dadosApiData['codigo'] = '';
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
                $e->id = $servicoId;
                $apiResult = $this->atualizarCadastrarApi($e);
                if ($apiResult !== true) {
                    $m->db->transRollback();
                    return $this->returnWithError($apiResult);
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
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new ServicoEntity($this->request->getPost());
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
                    $dadosApiData['codigo'] = '';
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

    private function atualizarCadastrarApi(ServicoEntity $servico) {
        $dadosApi = $servico->getDadosApi(true);
        if ($dadosApi === null || $dadosApi->id === '') {
            return 'Dados da API nao encontrados.';
        }

        $descricao = trim((string) $servico->Nome);
        $estoqueMinimo = $servico->estoqueMinimo ?? '';
        $estoqueMinimo = $estoqueMinimo === '' ? '0' : (string) $estoqueMinimo;

        $payloadData = [
            'InterfacedoProduto' => [
                [
                    'SequenciadoRegistro' => 1,
                    'CodigodoProduto' => '',
                    'PrimeiraDescricaodoProduto' => $descricao,
                    'SegundaDescricaodoProduto' => $descricao,
                    'UnidadedeControle' => (string) $dadosApi->UnidadedeControle,
                    'ProdutoInspecionado' => (string) $dadosApi->ProdutoInspecionado,
                    'ProdutoFabricado' => (string) $dadosApi->ProdutoFabricado,
                    'ProdutoLiberado' => (string) $dadosApi->ProdutoLiberado,
                    'EstoqueMinimo' => $estoqueMinimo,
                    'EstoqueMaximo' => '99999',
                    'ProdutoemInventario' => (string) $dadosApi->ProdutoemInventario,
                    'IndicacaodeProdutoouServico' => 'S',
                    'TipodeProduto' => (string) $dadosApi->TipodeProduto,
                    'IndicacaodeLoteSerie' => (string) $dadosApi->IndicacaodeLoteSerie,
                    'CodigodeSituacaoTributariaCST' => (string) $dadosApi->CodigodeSituacaoTributariaCST,
                    'ClassificacaoFiscal' => (string) $dadosApi->ClassificacaoFiscal,
                    'GrupodeProduto' => (string) $dadosApi->GrupodeProduto,
                ],
            ],
        ];

        $api = new ApiSesc();
        $result = $api->cadastrarProdutoServicoNota($payloadData);
        log_message('info', 'Retorno API cadastro serviço: {retorno}', [
            'retorno' => json_encode($result),
        ]);

        $curlError = $result['curl_error'] ?? '';
        if ($curlError !== '') {
            return $curlError;
        }

        $decoded = $result['decoded_response'] ?? null;
        $success = is_array($decoded) && ($decoded['Success'] ?? null) === true;
        if (!$success) {
            $mensagens = [];
            if (is_array($decoded)) {
                $msgs = $decoded['Messages'] ?? null;
                if (is_array($msgs)) {
                    foreach ($msgs as $msg) {
                        if (is_array($msg)) {
                            $mensagem = trim((string) ($msg['Message'] ?? ''));
                        } elseif (is_string($msg)) {
                            $mensagem = trim($msg);
                        } else {
                            $mensagem = '';
                        }
                        if ($mensagem !== '') {
                            $mensagens[] = $mensagem;
                        }
                    }
                }
            }
            if ($mensagens === []) {
                return 'Erro ao enviar dados para API.';
            }
            return implode('; ', $mensagens);
        }

        $data = $decoded['Data'] ?? null;
        $codigo = is_scalar($data) ? trim((string) $data) : '';
        if ($codigo === '') {
            return 'Resposta da API sem codigo.';
        }

        $mDadosApi = new DadosApiModel();
        $dadosApiAtual = $mDadosApi->find($dadosApi->id);
        if ($dadosApiAtual === null) {
            return 'Dados da API nao encontrados para atualizar codigo.';
        }
        $dadosApiAtual->codigo = $codigo;
        if (!$mDadosApi->update($dadosApi->id, $dadosApiAtual)) {
            $errors = $mDadosApi->errors();
            if (is_array($errors)) {
                $errors = implode('; ', $errors);
            }
            return $errors !== '' ? $errors : 'Erro ao atualizar codigo da API.';
        }

        return true;
    }

    private function getDadosApiData(): array {
        $fields = [
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
}
