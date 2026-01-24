<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;
use App\Models\DadosApiModel;
use App\Models\ProdutoDadosApiModel;
use App\Libraries\ApiSesc;
use App\Entities\ProdutoEntity;
use App\Entities\DadosApiEntity;
use App\Entities\ProdutoDadosApiEntity;

class Produto extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/Produto/cadastrar');
    }

    public function doCadastrar() {
        $m = new ProdutoModel();
        $mDadosApi = new DadosApiModel();
        $mProdutoDadosApi = new ProdutoDadosApiModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new ProdutoEntity($this->request->getPost());
        $e->foto = $this->getRandomName('foto');
        $dadosApiData = $this->getDadosApiData();
        $dadosApiData['codigo'] = '';
        $eDadosApi = new DadosApiEntity($dadosApiData);
        $m->db->transStart();
        try {
            if ($m->insert($e, false)) { 
                $produtoId = $m->getInsertID();
                if (!$mDadosApi->insert($eDadosApi, false)) {
                    $m->db->transRollback();
                    return $this->returnWithError($mDadosApi->errors());
                }
                $eProdutoDadosApi = new ProdutoDadosApiEntity([
                    'Produto_id' => $produtoId,
                    'DadosApi_id' => $mDadosApi->getInsertID(),
                ]);
                if (!$mProdutoDadosApi->insert($eProdutoDadosApi, false)) {
                    $m->db->transRollback();
                    return $this->returnWithError($mProdutoDadosApi->errors());
                }
                $e->id = $produtoId;
                $apiResult = $this->atualizarCadastrarApi($e);
                if ($apiResult !== true) {
                    $m->db->transRollback();
                    return $this->returnWithError($apiResult);
                }
                $m->uploadImage($this->request->getFile('foto'), $e->foto);
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
        $m = new ProdutoModel();
        $mProdutoDadosApi = new ProdutoDadosApiModel();
        $mDadosApi = new DadosApiModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $dadosApi = null;
        $produtoDadosApi = $mProdutoDadosApi->where('Produto_id', $e->id)->first();
        if ($produtoDadosApi !== null) {
            $dadosApi = $mDadosApi->find($produtoDadosApi->DadosApi_id);
        }
        if ($dadosApi === null) {
            $dadosApi = new DadosApiEntity();
        }
        $data = [
            'produto' => $e,
            'dadosApi' => $dadosApi,
        ];
        return view('Painel/Produto/alterar', $data);
    }

    public function doAlterar() {
        $m = new ProdutoModel();
        $mDadosApi = new DadosApiModel();
        $mProdutoDadosApi = new ProdutoDadosApiModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new ProdutoEntity($this->request->getPost());
        $dadosApiData = $this->getDadosApiData();
        $produtoDadosApi = $mProdutoDadosApi->where('Produto_id', $e->id)->first();
        try{ 
            $ru['foto'] = $m->uploadImage($this->request->getFile('foto'), null, ProdutoEntity::folder);
            $en->foto = $ru['foto'] !== false ? $ru['foto'] : $e->foto;
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                if ($produtoDadosApi !== null) {
                    if (!$mDadosApi->update($produtoDadosApi->DadosApi_id, $dadosApiData)) {
                        $m->db->transRollback();
                        if($ru['foto'] !== false) $m->deleteFile($ru['foto']);
                        return $this->returnWithError($mDadosApi->errors());
                    }
                } else {
                    $dadosApiData['codigo'] = '';
                    if (!$mDadosApi->insert($dadosApiData, false)) {
                        $m->db->transRollback();
                        if($ru['foto'] !== false) $m->deleteFile($ru['foto']);
                        return $this->returnWithError($mDadosApi->errors());
                    }
                    $eProdutoDadosApi = new ProdutoDadosApiEntity([
                        'Produto_id' => $e->id,
                        'DadosApi_id' => $mDadosApi->getInsertID(),
                    ]);
                    if (!$mProdutoDadosApi->insert($eProdutoDadosApi, false)) {
                        $m->db->transRollback();
                        if($ru['foto'] !== false) $m->deleteFile($ru['foto']);
                        return $this->returnWithError($mProdutoDadosApi->errors());
                    }
                }
                if($ru['foto'] !== false) $m->deleteFile($e->foto);
                $m->db->transComplete();
                return $this->returnSucess('Cadastrado com sucesso!');
            } else { 
                $m->deleteFiles($ru);
                return $this->returnWithError($m->errors());
            }
        }catch (\Exception $ex){ 
            if($ru['foto'] != false){
                $m->deleteFile($ru['foto']);
            }
            return $this->returnWithError($ex->getMessage());
        }
    }
    
    public function pesquisar(){
        return view('Painel/Produto/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new ProdutoModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vProduto' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Produto/resposta',  $data);
    }
    
    public function listar() {
        $m = new ProdutoModel();
        $data = [
            'vProduto' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Produto/listar', $data);
    }

    public function excluir() {
        $m = new ProdutoModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $m->db->transStart();
        if ($m->delete($e->id)) { 
            $m->deleteFile($e->foto);
            $m->db->transComplete();
            return $this->returnSucess('Excluído com sucesso!');
        }
        return $this->returnWithError('Erro ao excluir registro.');
    }
    
    public function pesquisaModal() {
        $m = new ProdutoModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vProduto' => $m->findAll(100)
        ];
        return view('Painel/Produto/respostaModal', $data);
    }

    private function atualizarCadastrarApi(ProdutoEntity $produto) {
        $dadosApi = $produto->getDadosApi(true);
        if ($dadosApi === null || $dadosApi->id === '') {
            return 'Dados da API nao encontrados.';
        }

        $descricao = trim((string) $produto->nome);
        $estoqueMinimo = $produto->estoqueMinimo ?? '';
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
                    'IndicacaodeProdutoouServico' => 'P',
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
        log_message('info', 'Retorno API cadastro produto: {retorno}', [
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
