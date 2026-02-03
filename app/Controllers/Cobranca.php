<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CobrancaModel;
use App\Entities\CobrancaEntity;
use App\Models\CobrancaServicoModel;
use App\Entities\CobrancaServicoEntity;
use App\Models\CobrancaProdutoModel;
use App\Entities\CobrancaProdutoEntity;
use App\Entities\Cast\CastCurrencyBR;
use App\Models\FaturaModel;
use App\Models\ProdutoModel;

class Cobranca extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/Cobranca/cadastrar');
    }

    public function doCadastrar() {
        $m = new CobrancaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $CobrancaServico = $this->request->getPost('CobrancaServico') ?? [];
        $CobrancaProduto = $this->request->getPost('CobrancaProduto') ?? [];
        $servicosQuantidade = $this->normalizarServicosQuantidade($CobrancaServico);
        $totalCobranca = 0.0;
        foreach ($CobrancaServico as $pp) {
            $quantidade = (int) ($pp['quantidade'] ?? 0);
            $valorUnitario = (float) CastCurrencyBR::set((string) ($pp['valorUnitario'] ?? '0'));
            $totalCobranca += $quantidade * $valorUnitario;
        }
        /*
        // PRODUTOS_DESATIVADOS
        foreach ($CobrancaProduto as $pp) {
            $quantidade = (int) ($pp['quantidade'] ?? 0);
            $valorUnitario = (float) CastCurrencyBR::set((string) ($pp['valorUnitario'] ?? '0'));
            $totalCobranca += $quantidade * $valorUnitario;
        }
        */
        $e = new CobrancaEntity($this->request->getPost());
        $e->valor = number_format($totalCobranca, 2, '.', '');
        $m->db->transStart();
        try {
            if ($m->insert($e, false)) { 
                $e->id = $m->getInsertID();
                $produtoModel = new ProdutoModel();
                $deltaProdutos = $produtoModel->calcularDeltaEstoquePorServicos($servicosQuantidade);
                $produtoModel->ajustarEstoquePorDelta($deltaProdutos);
                $mCobrancaServico = new CobrancaServicoModel();
                foreach ($CobrancaServico as $pp){
                    $pp['Cobranca_id'] = $m->getInsertID();
                    $pp['valorUnitario'] = CastCurrencyBR::set($pp['valorUnitario']);
                    $eCobrancaServico = new CobrancaServicoEntity($pp);
                    if(!$mCobrancaServico->insert($eCobrancaServico, false)){
                        $m->db->transRollback();
                        return $this->returnWithError($mCobrancaServico->errors());
                    }
                }
                /*
                // PRODUTOS_DESATIVADOS
                $mCobrancaProduto = new CobrancaProdutoModel();
                foreach ($CobrancaProduto as $pp){
                    $pp['Cobranca_id'] = $m->getInsertID();
                    $eCobrancaProduto = new CobrancaProdutoEntity($pp);
                    if(!$mCobrancaProduto->insert($eCobrancaProduto, false)){
                        return $this->returnWithError($mCobrancaProduto->errors());
                    }
                }
                */
                (new FaturaModel())->processarFatura($e);
                $m->db->transComplete();
                return $this->returnSucess('Cadastrado com sucesso!');
            } else {
                $m->db->transRollback();
                return $this->returnWithError($m->errors());
            }
        } catch (\Exception $ex) {
            $m->db->transRollback();
            return $this->returnWithError($ex->getMessage());
        }
    }

    public function alterar() {
        $m = new CobrancaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $participante = new \App\Models\ParticipanteModel();
        $data = [
            'cobranca' => $e,
            'participante' => $participante->find($e->Participante_id),
        ];
        return view('Painel/Cobranca/alterar', $data);
    }

    public function doAlterar() {
        $m = new CobrancaModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        if ((int) $e->situacao === 1) {
            return $this->returnWithError('Cobrança já está paga e não pode ser alterada.');
        }
        $CobrancaServico = $this->request->getPost('CobrancaServico') ?? [];
        // $CobrancaProduto = $this->request->getPost('CobrancaProduto') ?? [];
        $servicosQuantidadeAtual = $this->normalizarServicosQuantidade($e->getListCobrancaServico());
        $servicosQuantidadeNova = $this->normalizarServicosQuantidade($CobrancaServico);
        $totalCobranca = 0.0;
        foreach ($CobrancaServico as $pp) {
            $quantidade = (int) ($pp['quantidade'] ?? 0);
            $valorUnitario = (float) CastCurrencyBR::set((string) ($pp['valorUnitario'] ?? '0'));
            $totalCobranca += $quantidade * $valorUnitario;
        }
        /*
        // PRODUTOS_DESATIVADOS
        foreach ($CobrancaProduto as $pp) {
            $quantidade = (int) ($pp['quantidade'] ?? 0);
            $valorUnitario = (float) CastCurrencyBR::set((string) ($pp['valorUnitario'] ?? '0'));
            $totalCobranca += $quantidade * $valorUnitario;
        }
        */
        $en = new CobrancaEntity($this->request->getPost());
        $en->valor = number_format($totalCobranca, 2, '.', '');
        try{ 
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                $produtoModel = new ProdutoModel();
                $deltaProdutos = $produtoModel->calcularDeltaEstoquePorServicos($servicosQuantidadeNova, $servicosQuantidadeAtual);
                $produtoModel->ajustarEstoquePorDelta($deltaProdutos);
                $mCobrancaServico = new CobrancaServicoModel();
                $idsDelete = array_map(fn($v):int => $v->id, $e->getListCobrancaServico());
                if(count($idsDelete)>0){
                    $mCobrancaServico->delete($idsDelete);
                }
                foreach ($CobrancaServico as $pp){
                    $pp['Cobranca_id'] = $e->id;
                    $eCobrancaServico = new CobrancaServicoEntity($pp);
                    if(!$mCobrancaServico->insert($eCobrancaServico, false)){
                        $m->db->transRollback();
                        return $this->returnWithError($mCobrancaServico->errors());
                    }
                }
                /*
                // PRODUTOS_DESATIVADOS
                $mCobrancaProduto = new CobrancaProdutoModel();
                $idsDeleteProduto = array_map(fn($v):int => $v->id, $e->getListCobrancaProduto());
                if(count($idsDeleteProduto)>0){
                    $mCobrancaProduto->delete($idsDeleteProduto);
                }
                foreach ($CobrancaProduto as $pp){
                    $pp['Cobranca_id'] = $e->id;
                    $eCobrancaProduto = new CobrancaProdutoEntity($pp);
                    if(!$mCobrancaProduto->insert($eCobrancaProduto, false)){
                        return $this->returnWithError($mCobrancaProduto->errors());
                    }
                }
                */
                (new FaturaModel())->processarFatura($en);
                $m->db->transComplete();
                return $this->returnSucess('Cadastrado com sucesso!');
            } else { 
                $m->db->transRollback();
                return $this->returnWithError($m->errors());
            }
        }catch (\Exception $ex){ 
            $m->db->transRollback();
            return $this->returnWithError($ex->getMessage());
        }
    }
    
    public function pesquisar(){
        return view('Painel/Cobranca/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new CobrancaModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vCobranca' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Cobranca/resposta',  $data);
    }
    
    public function listar() {
        $m = new CobrancaModel();
        $m->orderBy('id', 'DESC');
        $data = [
            'vCobranca' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Cobranca/listar', $data);
    }

    public function excluir() {
        $m = new CobrancaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $servicosQuantidadeAtual = $this->normalizarServicosQuantidade($e->getListCobrancaServico());
        $m->db->transStart();
        try {
            $produtoModel = new ProdutoModel();
            $deltaProdutos = $produtoModel->calcularDeltaEstoquePorServicos([], $servicosQuantidadeAtual);
            $produtoModel->ajustarEstoquePorDelta($deltaProdutos);
            if ($m->delete($e->id)) { 
                $m->db->transComplete();
                return $this->returnSucess('Excluído com sucesso!');
            }
            $m->db->transRollback();
            return $this->returnWithError('Erro ao excluir registro.');
        } catch (\Exception $ex) {
            $m->db->transRollback();
            return $this->returnWithError($ex->getMessage());
        }
    }
    
    public function pesquisaModal() {
        $m = new CobrancaModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vCobranca' => $m->findAll(100)
        ];
        return view('Painel/Cobranca/respostaModal', $data);
    }

    private function normalizarServicosQuantidade(array $itens): array
    {
        $resultado = [];
        foreach ($itens as $item) {
            $servicoId = 0;
            $quantidade = 0;

            if (is_array($item)) {
                $servicoId = (int) ($item['Servico_id'] ?? 0);
                $quantidade = (int) ($item['quantidade'] ?? 0);
            } elseif (is_object($item)) {
                $servicoId = (int) ($item->Servico_id ?? 0);
                $quantidade = (int) ($item->quantidade ?? 0);
            }

            if ($servicoId <= 0 || $quantidade <= 0) {
                continue;
            }

            if (!isset($resultado[$servicoId])) {
                $resultado[$servicoId] = 0;
            }
            $resultado[$servicoId] += $quantidade;
        }

        return $resultado;
    }
}
