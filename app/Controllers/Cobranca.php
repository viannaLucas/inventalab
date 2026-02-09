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
use DateInterval;
use DateTimeImmutable;

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
        $payload = $this->request->getPost();
        $payload['Participante_id'] = $e->Participante_id;
        $payload['data'] = $e->data;
        $en = new CobrancaEntity($payload);
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

    public function relatorio()
    {
        $filtros = $this->resolverFiltrosRelatorio(false);
        $payload = $this->montarPayloadRelatorio($filtros);

        return view('Painel/Cobranca/relatorio', [
            'relatorioData' => $payload,
        ]);
    }

    public function relatorioDados()
    {
        $filtros = $this->resolverFiltrosRelatorio(true);
        if ($filtros['erro']) {
            return $this->response->setStatusCode(400)->setJSON([
                'erro' => true,
                'msg' => implode(' ', $filtros['erros']),
            ]);
        }

        $payload = $this->montarPayloadRelatorio($filtros);
        return $this->response->setJSON($payload);
    }

    private function montarPayloadRelatorio(array $filtros): array
    {
        $periodoA = $this->montarResumoPeriodo('Período A', $filtros['a_inicio'], $filtros['a_fim']);
        $periodoB = $this->montarResumoPeriodo('Período B', $filtros['b_inicio'], $filtros['b_fim']);

        $inicioComparativo = $filtros['a_inicio'] <= $filtros['b_inicio'] ? $filtros['a_inicio'] : $filtros['b_inicio'];
        $fimComparativo = $filtros['a_fim'] >= $filtros['b_fim'] ? $filtros['a_fim'] : $filtros['b_fim'];

        $mesesComparativo = $this->gerarMesesPeriodo($inicioComparativo, $fimComparativo);
        $labelsMesesComparativo = $this->gerarLabelsMeses($mesesComparativo, $inicioComparativo->format('Y') !== $fimComparativo->format('Y'));
        $seriesCompA = $this->montarSeriesMensais($periodoA['cobrancasPagas'], $mesesComparativo);
        $seriesCompB = $this->montarSeriesMensais($periodoB['cobrancasPagas'], $mesesComparativo);

        return [
            'erro' => false,
            'filtros' => [
                'dataADe' => $filtros['a_inicio']->format('Y-m-d'),
                'dataAAte' => $filtros['a_fim']->format('Y-m-d'),
                'dataBDe' => $filtros['b_inicio']->format('Y-m-d'),
                'dataBAte' => $filtros['b_fim']->format('Y-m-d'),
            ],
            'geral' => [
                'totalCobrancas' => $periodoA['totalCobrancas'],
                'totalValor' => $periodoA['totalValor'],
                'ticketMedio' => $periodoA['ticketMedio'],
                'totalServicos' => $periodoA['totalServicos'],
                'totalServicosUnicos' => $periodoA['totalServicosUnicos'],
                'situacaoCounts' => $periodoA['situacaoCounts'],
                'situacaoValores' => $periodoA['situacaoValores'],
                'totalAbertas' => (int) ($periodoA['situacaoCounts'][CobrancaEntity::SITUACAO_ABERTA] ?? 0),
                'valorAbertas' => (float) ($periodoA['situacaoValores'][CobrancaEntity::SITUACAO_ABERTA] ?? 0),
                'labelsMeses' => $periodoA['labelsMeses'],
                'valoresPorMes' => $periodoA['valoresPorMes'],
                'quantidadesPorMes' => $periodoA['quantidadesPorMes'],
                'servicos' => $periodoA['servicos'],
                'servicosChart' => $periodoA['servicosChart'],
            ],
            'comparativo' => [
                'labelsMeses' => $labelsMesesComparativo,
                'seriesA' => $seriesCompA,
                'seriesB' => $seriesCompB,
                'periodoA' => $this->payloadResumoPeriodo($periodoA),
                'periodoB' => $this->payloadResumoPeriodo($periodoB),
            ],
        ];
    }

    private function payloadResumoPeriodo(array $periodo): array
    {
        return [
            'nome' => $periodo['nome'],
            'inicio' => $periodo['inicio']->format('Y-m-d'),
            'fim' => $periodo['fim']->format('Y-m-d'),
            'totalCobrancas' => $periodo['totalCobrancas'],
            'totalValor' => $periodo['totalValor'],
            'ticketMedio' => $periodo['ticketMedio'],
            'totalServicos' => $periodo['totalServicos'],
            'totalServicosUnicos' => $periodo['totalServicosUnicos'],
            'situacaoCounts' => $periodo['situacaoCounts'],
            'situacaoValores' => $periodo['situacaoValores'],
            'totalAbertas' => (int) ($periodo['situacaoCounts'][CobrancaEntity::SITUACAO_ABERTA] ?? 0),
            'valorAbertas' => (float) ($periodo['situacaoValores'][CobrancaEntity::SITUACAO_ABERTA] ?? 0),
            'servicos' => $periodo['servicos'],
            'servicosChart' => $periodo['servicosChart'],
        ];
    }

    private function montarResumoPeriodo(string $nome, DateTimeImmutable $inicio, DateTimeImmutable $fim): array
    {
        $cobrancas = $this->carregarCobrancasPeriodo($inicio, $fim);
        $servicos = $this->carregarServicosPeriodo($inicio, $fim, true);

        $totalValor = 0.0;
        $situacaoCounts = [
            CobrancaEntity::SITUACAO_ABERTA => 0,
            CobrancaEntity::SITUACAO_PAGA => 0,
            CobrancaEntity::SITUACAO_CANCELADA => 0,
        ];
        $situacaoValores = [
            CobrancaEntity::SITUACAO_ABERTA => 0.0,
            CobrancaEntity::SITUACAO_PAGA => 0.0,
            CobrancaEntity::SITUACAO_CANCELADA => 0.0,
        ];
        $cobrancasPagas = [];

        foreach ($cobrancas as $cobranca) {
            $valor = $this->parseNumeroParaFloat($cobranca['valor'] ?? 0);
            $situacao = (int) ($cobranca['situacao'] ?? CobrancaEntity::SITUACAO_ABERTA);
            if (!array_key_exists($situacao, $situacaoCounts)) {
                $situacao = CobrancaEntity::SITUACAO_ABERTA;
            }
            $situacaoCounts[$situacao] += 1;
            $situacaoValores[$situacao] += $valor;
            if ($situacao === CobrancaEntity::SITUACAO_PAGA) {
                $totalValor += $valor;
                $cobrancasPagas[] = $cobranca;
            }
        }

        $totalCobrancas = count($cobrancasPagas);
        $ticketMedio = $totalCobrancas > 0 ? ($totalValor / $totalCobrancas) : 0.0;

        $totalServicos = 0;
        foreach ($servicos as $servico) {
            $totalServicos += (int) $servico['quantidade'];
        }

        $meses = $this->gerarMesesPeriodo($inicio, $fim);
        $labelsMeses = $this->gerarLabelsMeses($meses, $inicio->format('Y') !== $fim->format('Y'));
        $series = $this->montarSeriesMensais($cobrancasPagas, $meses);

        return [
            'nome' => $nome,
            'inicio' => $inicio,
            'fim' => $fim,
            'cobrancas' => $cobrancas,
            'cobrancasPagas' => $cobrancasPagas,
            'servicos' => $servicos,
            'servicosChart' => $this->montarTopServicosChart($servicos, 8),
            'totalCobrancas' => $totalCobrancas,
            'totalValor' => $totalValor,
            'ticketMedio' => $ticketMedio,
            'totalServicos' => $totalServicos,
            'totalServicosUnicos' => count($servicos),
            'situacaoCounts' => $situacaoCounts,
            'situacaoValores' => $situacaoValores,
            'labelsMeses' => $labelsMeses,
            'valoresPorMes' => $series['valores'],
            'quantidadesPorMes' => $series['quantidades'],
        ];
    }

    private function carregarCobrancasPeriodo(DateTimeImmutable $inicio, DateTimeImmutable $fim): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('Cobranca c');
        $builder->select('c.id, c.data, c.valor, c.situacao');
        $builder->where('c.data >=', $inicio->format('Y-m-d'));
        $builder->where('c.data <=', $fim->format('Y-m-d'));
        $builder->orderBy('c.data', 'ASC');
        return $builder->get()->getResultArray() ?? [];
    }

    private function carregarServicosPeriodo(DateTimeImmutable $inicio, DateTimeImmutable $fim, bool $somentePagas): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('CobrancaServico cs');
        $builder->select('s.id as servico_id, s.Nome as servico_nome, SUM(cs.quantidade) as quantidade, SUM(cs.quantidade * cs.valorUnitario) as total');
        $builder->join('Cobranca c', 'c.id = cs.Cobranca_id');
        $builder->join('Servico s', 's.id = cs.Servico_id');
        $builder->where('c.data >=', $inicio->format('Y-m-d'));
        $builder->where('c.data <=', $fim->format('Y-m-d'));
        if ($somentePagas) {
            $builder->where('c.situacao', CobrancaEntity::SITUACAO_PAGA);
        }
        $builder->groupBy('s.id, s.Nome');
        $builder->orderBy('total', 'DESC');

        $rows = $builder->get()->getResultArray() ?? [];
        return array_map(function (array $row): array {
            return [
                'id' => (int) ($row['servico_id'] ?? 0),
                'nome' => (string) ($row['servico_nome'] ?? 'Serviço'),
                'quantidade' => (int) ($row['quantidade'] ?? 0),
                'total' => $this->parseNumeroParaFloat($row['total'] ?? 0),
            ];
        }, $rows);
    }

    private function montarSeriesMensais(array $cobrancas, array $meses): array
    {
        $valores = [];
        $quantidades = [];
        foreach ($meses as $mes) {
            $key = $mes->format('Y-m');
            $valores[$key] = 0.0;
            $quantidades[$key] = 0;
        }

        foreach ($cobrancas as $cobranca) {
            $data = $this->parseDataCobranca($cobranca['data'] ?? '');
            if (!$data instanceof DateTimeImmutable) {
                continue;
            }
            $key = $data->format('Y-m');
            if (!array_key_exists($key, $valores)) {
                continue;
            }
            $valores[$key] += $this->parseNumeroParaFloat($cobranca['valor'] ?? 0);
            $quantidades[$key] += 1;
        }

        return [
            'valores' => array_values($valores),
            'quantidades' => array_values($quantidades),
        ];
    }

    private function montarTopServicosChart(array $servicos, int $limite): array
    {
        if (count($servicos) <= $limite) {
            return [
                'labels' => array_map(fn($s) => $s['nome'], $servicos),
                'valores' => array_map(fn($s) => $s['total'], $servicos),
            ];
        }

        $top = array_slice($servicos, 0, $limite);
        $resto = array_slice($servicos, $limite);
        $totalResto = 0.0;
        foreach ($resto as $s) {
            $totalResto += (float) $s['total'];
        }

        $labels = array_map(fn($s) => $s['nome'], $top);
        $valores = array_map(fn($s) => (float) $s['total'], $top);
        $labels[] = 'Outros';
        $valores[] = $totalResto;

        return [
            'labels' => $labels,
            'valores' => $valores,
        ];
    }

    private function resolverFiltrosRelatorio(bool $strict): array
    {
        $payload = $this->request->getJSON(true);
        if ($payload === null) {
            $payload = $this->request->getGet() ?? [];
        }
        if (count($payload) === 0) {
            $payload = $this->request->getPost() ?? [];
        }

        $dataADeRaw = trim((string) ($payload['dataADe'] ?? ''));
        $dataAAteRaw = trim((string) ($payload['dataAAte'] ?? ''));
        $dataBDeRaw = trim((string) ($payload['dataBDe'] ?? ''));
        $dataBAteRaw = trim((string) ($payload['dataBAte'] ?? ''));

        $erros = [];
        $aInicio = $dataADeRaw !== '' ? DateTimeImmutable::createFromFormat('Y-m-d', $dataADeRaw) : null;
        if ($dataADeRaw !== '' && !$aInicio instanceof DateTimeImmutable) {
            $erros[] = 'Data início (A) inválida.';
        }
        $aFim = $dataAAteRaw !== '' ? DateTimeImmutable::createFromFormat('Y-m-d', $dataAAteRaw) : null;
        if ($dataAAteRaw !== '' && !$aFim instanceof DateTimeImmutable) {
            $erros[] = 'Data fim (A) inválida.';
        }
        $bInicio = $dataBDeRaw !== '' ? DateTimeImmutable::createFromFormat('Y-m-d', $dataBDeRaw) : null;
        if ($dataBDeRaw !== '' && !$bInicio instanceof DateTimeImmutable) {
            $erros[] = 'Data início (B) inválida.';
        }
        $bFim = $dataBAteRaw !== '' ? DateTimeImmutable::createFromFormat('Y-m-d', $dataBAteRaw) : null;
        if ($dataBAteRaw !== '' && !$bFim instanceof DateTimeImmutable) {
            $erros[] = 'Data fim (B) inválida.';
        }

        $hoje = new DateTimeImmutable('today');
        $fimPadrao = $hoje;
        $inicioPadrao = $hoje->sub(new DateInterval('P30D'));
        $fimBPadrao = $inicioPadrao->sub(new DateInterval('P1D'));
        $inicioBPadrao = $fimBPadrao->sub(new DateInterval('P29D'));

        if (!$aInicio instanceof DateTimeImmutable) {
            $aInicio = $inicioPadrao;
        }
        if (!$aFim instanceof DateTimeImmutable) {
            $aFim = $fimPadrao;
        }
        if (!$bInicio instanceof DateTimeImmutable) {
            $bInicio = $inicioBPadrao;
        }
        if (!$bFim instanceof DateTimeImmutable) {
            $bFim = $fimBPadrao;
        }

        if ($aInicio > $aFim) {
            $erros[] = 'Data início (A) maior que data fim (A).';
        }
        if ($bInicio > $bFim) {
            $erros[] = 'Data início (B) maior que data fim (B).';
        }

        if ($strict && count($erros) > 0) {
            return [
                'erro' => true,
                'erros' => $erros,
                'a_inicio' => $aInicio,
                'a_fim' => $aFim,
                'b_inicio' => $bInicio,
                'b_fim' => $bFim,
            ];
        }

        if ($aInicio > $aFim) {
            [$aInicio, $aFim] = [$aFim, $aInicio];
        }
        if ($bInicio > $bFim) {
            [$bInicio, $bFim] = [$bFim, $bInicio];
        }

        return [
            'erro' => false,
            'erros' => $erros,
            'a_inicio' => $aInicio,
            'a_fim' => $aFim,
            'b_inicio' => $bInicio,
            'b_fim' => $bFim,
        ];
    }

    private function gerarMesesPeriodo(DateTimeImmutable $inicio, DateTimeImmutable $fim): array
    {
        $meses = [];
        $cursor = $inicio->modify('first day of this month');
        $limite = $fim->modify('first day of this month');
        while ($cursor <= $limite) {
            $meses[] = $cursor;
            $cursor = $cursor->modify('+1 month');
        }
        if (empty($meses)) {
            $meses[] = $inicio->modify('first day of this month');
        }
        return $meses;
    }

    private function gerarLabelsMeses(array $meses, bool $comAno): array
    {
        $nomes = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        $labels = [];
        foreach ($meses as $data) {
            $nome = $nomes[(int) $data->format('n') - 1] ?? $data->format('m');
            $labels[] = $comAno ? ($nome . '/' . $data->format('Y')) : $nome;
        }
        return $labels;
    }

    private function parseDataCobranca(string $valor): ?DateTimeImmutable
    {
        $texto = trim($valor);
        if ($texto === '') {
            return null;
        }
        $data = DateTimeImmutable::createFromFormat('Y-m-d', $texto)
            ?: DateTimeImmutable::createFromFormat('d/m/Y', $texto);
        return $data instanceof DateTimeImmutable ? $data : null;
    }

    private function parseNumeroParaFloat($valor): float
    {
        $texto = trim((string) $valor);
        if ($texto === '') {
            return 0.0;
        }
        if (str_contains($texto, ',')) {
            $texto = str_replace(['.', ','], ['', '.'], $texto);
        }
        return (float) $texto;
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
