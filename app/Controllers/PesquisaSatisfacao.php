<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\ParticipanteEntity;
use App\Models\PesquisaSatisfacaoModel;
use App\Entities\PesquisaSatisfacaoEntity;
use App\Entities\ReservaEntity;
use App\Models\ConfiguracaoModel;
use App\Models\ReservaModel;
use DateInterval;
use DateTime;
use DateTimeImmutable;

class PesquisaSatisfacao extends BaseController {

    public function index() {
        return $this->listar();
    }

    // public function cadastrar() {
    //     return view('Painel/PesquisaSatisfacao/cadastrar');
    // }

    // public function doCadastrar() {
    //     $m = new PesquisaSatisfacaoModel();
    //     $ef = $this->validateWithRequest($m->getValidationRulesFiles());
    //     if ($ef !== true) {
    //         return $this->returnWithError($ef);
    //     }
    //     $e = new PesquisaSatisfacaoEntity($this->request->getPost());
    //     $m->db->transStart();
    //     try {
    //         if ($m->insert($e, false)) { 
    //             $m->db->transComplete();
    //             return $this->returnSucess('Cadastrado com sucesso!');
    //         } else {
    //             return $this->returnWithError($m->errors());
    //         }
    //     } catch (\Exception $ex) {
    //         return $this->returnWithError($ex->getMessage());
    //     }
    // }

    // public function alterar() {
    //     $m = new PesquisaSatisfacaoModel();
    //     $e = $m->find($this->request->getUri()->getSegment(3));
    //     if ($e === null) {
    //         return $this->returnWithError('Registro não encontrado.');
    //     } 
    //     $data = [
    //         'pesquisasatisfacao' => $e,
    //     ];
    //     return view('Painel/PesquisaSatisfacao/alterar', $data);
    // }

    // public function doAlterar() {
    //     $m = new PesquisaSatisfacaoModel();
    //     $ef = $this->validateWithRequest($m->getValidationRulesFiles());
    //     if ($ef !== true) {
    //         return $this->returnWithError($ef);
    //     }
    //     $e = $m->find($this->request->getPost('id'));
    //     if ($e === null) {
    //         return $this->returnWithError('Registro não encontrado.');
    //     }
    //     $en = new PesquisaSatisfacaoEntity($this->request->getPost());
    //     try{ 
    //         $m->db->transStart();
    //         if ($m->update($en->id, $en)) { 
    //             $m->db->transComplete();
    //             return $this->returnSucess('Cadastrado com sucesso!');
    //         } else { 
    //             return $this->returnWithError($m->errors());
    //         }
    //     }catch (\Exception $ex){ 
    //         return $this->returnWithError($ex->getMessage());
    //     }
    // }
    
    public function visualizar() {
        $m = new PesquisaSatisfacaoModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $data = [
            'pesquisasatisfacao' => $e,
        ];
        return view('Painel/PesquisaSatisfacao/visualizar', $data);
    }

    public function pesquisar(){
        return view('Painel/PesquisaSatisfacao/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new PesquisaSatisfacaoModel();
        $filtros = $this->request->getGet();
        unset($filtros['Participante_idStart'], $filtros['Participante_idEnd']);
        $m->buildFindList($filtros)->orderBy('dataResposta DESC');
        $data = [
            'vPesquisaSatisfacao' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/PesquisaSatisfacao/resposta',  $data);
    }
    
    public function listar() {
        $m = new PesquisaSatisfacaoModel();
        $m->orderBy('dataResposta DESC');
        $data = [
            'vPesquisaSatisfacao' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/PesquisaSatisfacao/listar', $data);
    }

    // public function excluir() {
    //     $m = new PesquisaSatisfacaoModel();
    //     $e = $m->find($this->request->getUri()->getSegment(3));
    //     if ($e === null) {
    //         return $this->returnWithError('Registro não encontrado.');
    //     }
    //     $m->db->transStart();
    //     if ($m->delete($e->id)) { 
    //         $m->db->transComplete();
    //         return $this->returnSucess('Excluído com sucesso!');
    //     }
    //     return $this->returnWithError('Erro ao excluir registro.');
    // }
    
    public function pesquisaModal() {
        $m = new PesquisaSatisfacaoModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vPesquisaSatisfacao' => $m->findAll(100)
        ];
        return view('Painel/PesquisaSatisfacao/respostaModal', $data);
    }

    public function cronEnvio()
    {
        $reservaM = new ReservaModel();
        $vReservas = $reservaM->where('status', ReservaEntity::STATUS_ATIVO)
            ->where('DATE(horaSaida) = CURDATE() - INTERVAL 1 DAY')
            ->findAll();
        $vParticipante = [];
        /** @var ReservaEntity $reserva*/
        foreach($vReservas as $reserva){
            $vParticipante = array_merge($vParticipante, $reserva->getListaParticipantes());
        }
        $configuracoesE = ConfiguracaoModel::getConfiguracao();
        $pesquisaSatisfacaoM = new PesquisaSatisfacaoModel();
        $db = db_connect();
        $intervalo =  $db->escape($configuracoesE->intervaloEntrePesquisa);
        /** @var ParticipanteEntity $participante */
        foreach($vParticipante as $participante){            
            $r = $pesquisaSatisfacaoM->select()->where('Participante_id', $participante->id)
                ->where("DATE(dataEnvio) > CURDATE() - INTERVAL $intervalo DAY")->findAll();
            if(empty($r)){
                echo "<p>Enviando para $participante->email</p>";
                $this->enviarEmailPesquisa($participante);
            }
        }
    }

    private function enviarEmailPesquisa(ParticipanteEntity $participante)
    {
        $pesquisaE = new PesquisaSatisfacaoEntity();
        $pesquisaE->respondido = PesquisaSatisfacaoEntity::RESPONDIDO_NAO;
        $pesquisaE->Participante_id = $participante->id;
        $pesquisaE->dataEnvio = (new DateTime())->format('d/m/Y');
        $pesquisaM = new PesquisaSatisfacaoModel();
        if(!$pesquisaM->insert($pesquisaE, false)){
            return false;
        }
        $pesquisaE->id = $pesquisaM->getInsertID();
        try {
            $token = $this->criarTokenRecuperacao($pesquisaE);
            $pesquisaUrl = base_url('PesquisaSatisfacao/responderPesquisa/' . $token);

            $emailService = \Config\Services::email();
            $emailService->clear(true);
            $emailConfig = config('Email');
            if (!empty($emailConfig->fromEmail)) {
                $emailService->setFrom($emailConfig->fromEmail, $emailConfig->fromName ?: null);
            }

            $destinatario = trim((string) $participante->email);
            if ($destinatario === '') {
                $destinatario = trim((string) $participante->email);
            }

            if ($destinatario === '') {
                log_message('error', 'Participante sem e-mail/login cadastrado para Pesquisa Satisfação. ID: ' . $participante->id);
                return false;
            }

            $emailService->setTo($destinatario);
            $emailService->setSubject('Pesquisa Satisfação - Participante InventaLab');
            $emailService->setMailType('html');
            $emailService->setMessage(view('Painel/PesquisaSatisfacao/emailPesquisa', [
                'linkPesquisa' => $pesquisaUrl,
                'nome' => $participante->nome,
                'nomeLaboratorio' => 'InventaLab',
            ]));

            if (!$emailService->send()) {
                log_message('error', 'Falha ao enviar e-mail de Pesquisa Satisfação para participante: ' . print_r($emailService->printDebugger(['headers', 'subject']), true));
                return false;
            }
        } catch (\Throwable $exception) {
            log_message('error', 'Erro durante o envio de Pesquisa Satisfação para participante: ' . $exception->getMessage());
            return false;
        }

        return true;
    }

    public function responderPesquisa()
    {
        $token = (string) $this->request->getUri()->getSegment(3);

        if ($token === '') {
            return redirect()->to('PainelParticipante/home')->with('msg_erro', 'Link de pesquisa inválido.');
        }

        try {
            $payload = $this->decodificarTokenRecuperacao($token);

            if (!isset($payload['id'])) {
                throw new \RuntimeException('Token inválido.');
            }

            $pesquisaModel = new PesquisaSatisfacaoModel();
            $pesquisa = $pesquisaModel->find((int) $payload['id']);

            if (!($pesquisa instanceof PesquisaSatisfacaoEntity)) {
                throw new \RuntimeException('Pesquisa não encontrada.');
            }
        } catch (\Throwable $exception) {
            log_message('error', 'Erro ao carregar pesquisa de satisfação: ' . $exception->getMessage());
            return redirect()->to('PainelParticipante/home')->with('msg_erro', 'Link inválido ou expirado.');
        }

        return view('Painel/PesquisaSatisfacao/paginaPesquisa', [
            'token' => $token,
            'formAction' => base_url('PesquisaSatisfacao/doResponderPesquisa'),
        ]);
    }

    public function doResponderPesquisa()
    {
        $token = (string) $this->request->getPost('token');

        if ($token === '') {
            return redirect()->to('PainelParticipante/home')->with('msg_erro', 'Token de pesquisa ausente.');
        }

        $avaliacoesEntrada = [
            'uso_geral'   => $this->request->getPost('uso_geral'),
            'atendimento' => $this->request->getPost('atendimento'),
            'equipamentos'=> $this->request->getPost('equipamentos'),
        ];

        $avaliacoes = [];
        foreach ($avaliacoesEntrada as $campo => $valor) {
            if ($valor === null || $valor === '' || !ctype_digit((string) $valor)) {
                return redirect()->back()->withInput()->with('msg_erro', 'Preencha todas as avaliações numéricas.');
            }

            $valorInt = (int) $valor;
            if ($valorInt < 0 || $valorInt > 10) {
                return redirect()->back()->withInput()->with('msg_erro', 'As avaliações devem estar entre 0 e 10.');
            }

            $avaliacoes[$campo] = $valorInt;
        }

        $sugestoes = trim((string) $this->request->getPost('sugestoes'));
        $atividades = trim((string) $this->request->getPost('atividades'));

        if ($sugestoes === '' || $atividades === '') {
            return redirect()->back()->withInput()->with('msg_erro', 'Preencha os campos de texto da pesquisa.');
        }

        try {
            $payload = $this->decodificarTokenRecuperacao($token);

            if (!isset($payload['id'])) {
                throw new \RuntimeException('Token inválido.');
            }

            $pesquisaModel = new PesquisaSatisfacaoModel();
            $pesquisa = $pesquisaModel->find((int) $payload['id']);

            if (!($pesquisa instanceof PesquisaSatisfacaoEntity)) {
                throw new \RuntimeException('Pesquisa não encontrada.');
            }

            if ((int) $pesquisa->respondido === PesquisaSatisfacaoEntity::RESPONDIDO_SIM) {
                return redirect()->to('PainelParticipante/home')->with('msg_sucesso', 'Pesquisa já respondida. Obrigado!');
            }

            $pesquisa->resposta1 = $avaliacoes['uso_geral'];
            $pesquisa->resposta2 = $avaliacoes['atendimento'];
            $pesquisa->resposta3 = $avaliacoes['equipamentos'];
            $pesquisa->resposta4 = $sugestoes;
            $pesquisa->resposta5 = $atividades;
            $pesquisa->dataResposta = date('d/m/Y');
            $pesquisa->respondido = PesquisaSatisfacaoEntity::RESPONDIDO_SIM;

            $pesquisaModel->allowCallbacks(false);
            $atualizado = $pesquisaModel->update($pesquisa->id, $pesquisa);
            $pesquisaModel->allowCallbacks(true);

            if ($atualizado === false) {
                $erros = $pesquisaModel->errors();
                throw new \RuntimeException(is_array($erros) ? implode(PHP_EOL, $erros) : 'Falha ao registrar respostas.');
            }
        } catch (\Throwable $exception) {
            log_message('error', 'Erro ao registrar respostas da pesquisa: ' . $exception->getMessage());
            return redirect()->back()->withInput()->with('msg_erro', 'Não foi possível registrar suas respostas. Tente novamente.');
        }

        return view('Painel/PesquisaSatisfacao/agradecimentoPesquisa');
    }

    private function criarTokenRecuperacao(PesquisaSatisfacaoEntity $pesquisa): string
    {
        $payload = [
            'id'    => $pesquisa->id,
            'ts'    => time(),
            'nonce' => bin2hex(random_bytes(8)),
        ];

        $jsonPayload = json_encode($payload);
        if ($jsonPayload === false) {
            throw new \RuntimeException('Não foi possível preparar os dados para recuperação de senha.');
        }

        $encrypter = \Config\Services::encrypter();
        $cipherText = $encrypter->encrypt($jsonPayload);

        return $this->encodeUrlSafe($cipherText);
    }

    private function encodeUrlSafe(string $cipherText): string
    {
        return rtrim(strtr(base64_encode($cipherText), '+/', '-_'), '=');
    }

    private function decodificarTokenRecuperacao(string $token): array
    {
        $cipherText = $this->decodeUrlSafe($token);

        $encrypter = \Config\Services::encrypter();
        $json = $encrypter->decrypt($cipherText);

        $dados = json_decode($json, true);
        if (!is_array($dados)) {
            throw new \RuntimeException('Token inválido.');
        }

        return $dados;
    }

    private function decodeUrlSafe(string $encoded): string
    {
        $encoded = strtr($encoded, '-_', '+/');
        $resto = strlen($encoded) % 4;
        if ($resto > 0) {
            $encoded .= str_repeat('=', 4 - $resto);
        }

        $decoded = base64_decode($encoded, true);
        if ($decoded === false) {
            throw new \RuntimeException('Token inválido.');
        }

        return $decoded;
    }

    public function relatorio()
    {
        $filtros = $this->resolverFiltrosRelatorio(false);
        $payload = $this->montarPayloadRelatorio($filtros);

        return view('Painel/PesquisaSatisfacao/relatorio', [
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
        [$respostasA, $enviosA] = $this->carregarRespostasEnvios($filtros['a_inicio'], $filtros['a_fim']);
        [$respostasB, $enviosB] = $this->carregarRespostasEnvios($filtros['b_inicio'], $filtros['b_fim']);

        $periodoA = $this->montarResumoPeriodo('Período A', $respostasA, $enviosA, $filtros['a_inicio'], $filtros['a_fim']);
        $periodoB = $this->montarResumoPeriodo('Período B', $respostasB, $enviosB, $filtros['b_inicio'], $filtros['b_fim']);

        $inicioComparativo = $filtros['a_inicio'] <= $filtros['b_inicio'] ? $filtros['a_inicio'] : $filtros['b_inicio'];
        $fimComparativo = $filtros['a_fim'] >= $filtros['b_fim'] ? $filtros['a_fim'] : $filtros['b_fim'];
        $mesesComparativo = $this->gerarMesesPeriodo($inicioComparativo, $fimComparativo);
        $labelsMesesComparativo = $this->gerarLabelsMeses($mesesComparativo, $inicioComparativo->format('Y') !== $fimComparativo->format('Y'));

        $seriesCompA = $this->montarSeriesMensais($respostasA, $enviosA, $mesesComparativo);
        $seriesCompB = $this->montarSeriesMensais($respostasB, $enviosB, $mesesComparativo);

        $labelsNotas = array_map('strval', range(0, 10));

        return [
            'erro' => false,
            'filtros' => [
                'dataADe' => $filtros['a_inicio']->format('Y-m-d'),
                'dataAAte' => $filtros['a_fim']->format('Y-m-d'),
                'dataBDe' => $filtros['b_inicio']->format('Y-m-d'),
                'dataBAte' => $filtros['b_fim']->format('Y-m-d'),
            ],
            'geral' => [
                'totalRespostas' => $periodoA['totalRespostas'],
                'totalEnviadas' => $periodoA['totalEnviadas'],
                'mediaUso' => $periodoA['mediaUso'],
                'mediaAtendimento' => $periodoA['mediaAtendimento'],
                'mediaEquip' => $periodoA['mediaEquip'],
                'mediaGeral' => $periodoA['mediaGeral'],
                'ultimaResposta' => $periodoA['ultimaResposta'],
                'labelsNotas' => $labelsNotas,
                'distUso' => $periodoA['distribuicao']['uso'],
                'distAtendimento' => $periodoA['distribuicao']['atendimento'],
                'distEquip' => $periodoA['distribuicao']['equip'],
                'labelsMeses' => $periodoA['labelsMeses'],
                'evolucaoUso' => $periodoA['evolucaoUso'],
                'evolucaoAtendimento' => $periodoA['evolucaoAtendimento'],
                'evolucaoEquip' => $periodoA['evolucaoEquip'],
                'enviosPorMes' => $periodoA['envios'],
                'respostasPorMes' => $periodoA['respostas'],
            ],
            'comparativo' => [
                'labelsNotas' => $labelsNotas,
                'labelsMeses' => $labelsMesesComparativo,
                'periodoA' => [
                    'nome' => $periodoA['nome'],
                    'mediaUso' => $periodoA['mediaUso'],
                    'mediaAtendimento' => $periodoA['mediaAtendimento'],
                    'mediaEquip' => $periodoA['mediaEquip'],
                    'totalRespostas' => $periodoA['totalRespostas'],
                    'totalEnviadas' => $periodoA['totalEnviadas'],
                    'distribuicao' => $periodoA['distribuicao'],
                    'envios' => $seriesCompA['envios'],
                    'respostas' => $seriesCompA['respostas'],
                    'temas' => $periodoA['temas'],
                ],
                'periodoB' => [
                    'nome' => $periodoB['nome'],
                    'mediaUso' => $periodoB['mediaUso'],
                    'mediaAtendimento' => $periodoB['mediaAtendimento'],
                    'mediaEquip' => $periodoB['mediaEquip'],
                    'totalRespostas' => $periodoB['totalRespostas'],
                    'totalEnviadas' => $periodoB['totalEnviadas'],
                    'distribuicao' => $periodoB['distribuicao'],
                    'envios' => $seriesCompB['envios'],
                    'respostas' => $seriesCompB['respostas'],
                    'temas' => $periodoB['temas'],
                ],
            ],
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

        $aDeRaw = trim((string) ($payload['dataADe'] ?? ''));
        $aAteRaw = trim((string) ($payload['dataAAte'] ?? ''));
        $bDeRaw = trim((string) ($payload['dataBDe'] ?? ''));
        $bAteRaw = trim((string) ($payload['dataBAte'] ?? ''));

        $erros = [];
        $aInicio = $aDeRaw !== '' ? DateTimeImmutable::createFromFormat('Y-m-d', $aDeRaw) : null;
        if ($aDeRaw !== '' && !$aInicio instanceof DateTimeImmutable) {
            $erros[] = 'Data início do período A inválida.';
        }
        $aFim = $aAteRaw !== '' ? DateTimeImmutable::createFromFormat('Y-m-d', $aAteRaw) : null;
        if ($aAteRaw !== '' && !$aFim instanceof DateTimeImmutable) {
            $erros[] = 'Data fim do período A inválida.';
        }

        $hoje = new DateTimeImmutable('today');
        $aFimPadrao = $hoje;
        $aInicioPadrao = $hoje->sub(new DateInterval('P30D'));

        if (!$aInicio instanceof DateTimeImmutable) {
            $aInicio = $aInicioPadrao;
        }
        if (!$aFim instanceof DateTimeImmutable) {
            $aFim = $aFimPadrao;
        }

        if ($aInicio > $aFim) {
            $erros[] = 'Período A inválido: início maior que fim.';
        }

        $bInicio = $bDeRaw !== '' ? DateTimeImmutable::createFromFormat('Y-m-d', $bDeRaw) : null;
        if ($bDeRaw !== '' && !$bInicio instanceof DateTimeImmutable) {
            $erros[] = 'Data início do período B inválida.';
        }
        $bFim = $bAteRaw !== '' ? DateTimeImmutable::createFromFormat('Y-m-d', $bAteRaw) : null;
        if ($bAteRaw !== '' && !$bFim instanceof DateTimeImmutable) {
            $erros[] = 'Data fim do período B inválida.';
        }

        if (!$bInicio instanceof DateTimeImmutable || !$bFim instanceof DateTimeImmutable) {
            $bFim = $aInicio->sub(new DateInterval('P1D'));
            $bInicio = $bFim->sub(new DateInterval('P29D'));
        }

        if ($bInicio > $bFim) {
            $erros[] = 'Período B inválido: início maior que fim.';
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

    private function carregarRespostasEnvios(DateTimeImmutable $inicio, DateTimeImmutable $fim): array
    {
        $respostaModel = new PesquisaSatisfacaoModel();
        $respostaModel->buildFindList([
            'dataRespostaStart' => $inicio->format('d/m/Y'),
            'dataRespostaEnd' => $fim->format('d/m/Y'),
        ]);
        $respostaModel->where('respondido', PesquisaSatisfacaoEntity::RESPONDIDO_SIM);
        $respostas = $respostaModel->findAll();

        $envioModel = new PesquisaSatisfacaoModel();
        $envioModel->buildFindList([
            'dataEnvioStart' => $inicio->format('d/m/Y'),
            'dataEnvioEnd' => $fim->format('d/m/Y'),
        ]);
        $envios = $envioModel->findAll();

        return [$respostas, $envios];
    }

    private function montarResumoPeriodo(string $nome, array $respostas, array $envios, DateTimeImmutable $inicio, DateTimeImmutable $fim): array
    {
        $totalRespostas = count($respostas);
        $totalEnviadas = count($envios);

        $mediaUso = $this->calcularMedia($respostas, 'resposta1');
        $mediaAtendimento = $this->calcularMedia($respostas, 'resposta2');
        $mediaEquip = $this->calcularMedia($respostas, 'resposta3');

        $mediaGeral = ($mediaUso + $mediaAtendimento + $mediaEquip) / 3;
        $mediaGeral = round($mediaGeral, 1);

        $ultimaResposta = $this->calcularUltimaResposta($respostas);

        $distUso = $this->calcularDistribuicao($respostas, 'resposta1');
        $distAtendimento = $this->calcularDistribuicao($respostas, 'resposta2');
        $distEquip = $this->calcularDistribuicao($respostas, 'resposta3');

        $meses = $this->gerarMesesPeriodo($inicio, $fim);
        $labelsMeses = $this->gerarLabelsMeses($meses, $inicio->format('Y') !== $fim->format('Y'));
        $series = $this->montarSeriesMensais($respostas, $envios, $meses);

        return [
            'nome' => $nome,
            'totalRespostas' => $totalRespostas,
            'totalEnviadas' => $totalEnviadas,
            'mediaUso' => $mediaUso,
            'mediaAtendimento' => $mediaAtendimento,
            'mediaEquip' => $mediaEquip,
            'mediaGeral' => $mediaGeral,
            'ultimaResposta' => $ultimaResposta,
            'distribuicao' => [
                'uso' => $distUso,
                'atendimento' => $distAtendimento,
                'equip' => $distEquip,
            ],
            'labelsMeses' => $labelsMeses,
            'evolucaoUso' => $series['evolucaoUso'],
            'evolucaoAtendimento' => $series['evolucaoAtendimento'],
            'evolucaoEquip' => $series['evolucaoEquip'],
            'envios' => $series['envios'],
            'respostas' => $series['respostas'],
            'temas' => $this->extrairTemas($respostas),
        ];
    }

    private function calcularMedia(array $respostas, string $campo): float
    {
        $soma = 0.0;
        $qtd = 0;
        foreach ($respostas as $resposta) {
            $nota = $this->normalizarNota($resposta->$campo ?? null);
            if ($nota === null) {
                continue;
            }
            $soma += $nota;
            $qtd++;
        }
        if ($qtd === 0) {
            return 0.0;
        }

        return round($soma / $qtd, 1);
    }

    private function calcularDistribuicao(array $respostas, string $campo): array
    {
        $dist = array_fill(0, 11, 0);
        foreach ($respostas as $resposta) {
            $nota = $this->normalizarNota($resposta->$campo ?? null);
            if ($nota === null || $nota < 0 || $nota > 10) {
                continue;
            }
            $dist[$nota] += 1;
        }
        return $dist;
    }

    private function montarSeriesMensais(array $respostas, array $envios, array $meses): array
    {
        $keys = array_map(static function (DateTimeImmutable $data) {
            return $data->format('Y-m');
        }, $meses);

        $enviosMap = array_fill_keys($keys, 0);
        $respostasMap = array_fill_keys($keys, 0);
        $sumUso = array_fill_keys($keys, 0.0);
        $countUso = array_fill_keys($keys, 0);
        $sumAtendimento = array_fill_keys($keys, 0.0);
        $countAtendimento = array_fill_keys($keys, 0);
        $sumEquip = array_fill_keys($keys, 0.0);
        $countEquip = array_fill_keys($keys, 0);

        foreach ($envios as $envio) {
            $dataEnvio = $this->parseDataPesquisa($envio->dataEnvio ?? null);
            if (!$dataEnvio instanceof DateTimeImmutable) {
                continue;
            }
            $key = $dataEnvio->format('Y-m');
            if (isset($enviosMap[$key])) {
                $enviosMap[$key] += 1;
            }
        }

        foreach ($respostas as $resposta) {
            $dataResposta = $this->parseDataPesquisa($resposta->dataResposta ?? null);
            if (!$dataResposta instanceof DateTimeImmutable) {
                continue;
            }
            $key = $dataResposta->format('Y-m');
            if (!isset($respostasMap[$key])) {
                continue;
            }
            $respostasMap[$key] += 1;

            $notaUso = $this->normalizarNota($resposta->resposta1 ?? null);
            if ($notaUso !== null) {
                $sumUso[$key] += $notaUso;
                $countUso[$key] += 1;
            }

            $notaAtendimento = $this->normalizarNota($resposta->resposta2 ?? null);
            if ($notaAtendimento !== null) {
                $sumAtendimento[$key] += $notaAtendimento;
                $countAtendimento[$key] += 1;
            }

            $notaEquip = $this->normalizarNota($resposta->resposta3 ?? null);
            if ($notaEquip !== null) {
                $sumEquip[$key] += $notaEquip;
                $countEquip[$key] += 1;
            }
        }

        $evolucaoUso = [];
        $evolucaoAtendimento = [];
        $evolucaoEquip = [];
        foreach ($keys as $key) {
            $evolucaoUso[] = $countUso[$key] > 0 ? round($sumUso[$key] / $countUso[$key], 1) : 0;
            $evolucaoAtendimento[] = $countAtendimento[$key] > 0 ? round($sumAtendimento[$key] / $countAtendimento[$key], 1) : 0;
            $evolucaoEquip[] = $countEquip[$key] > 0 ? round($sumEquip[$key] / $countEquip[$key], 1) : 0;
        }

        return [
            'envios' => array_values($enviosMap),
            'respostas' => array_values($respostasMap),
            'evolucaoUso' => $evolucaoUso,
            'evolucaoAtendimento' => $evolucaoAtendimento,
            'evolucaoEquip' => $evolucaoEquip,
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

    private function calcularUltimaResposta(array $respostas): string
    {
        $ultima = null;
        foreach ($respostas as $resposta) {
            $dataResposta = $this->parseDataPesquisa($resposta->dataResposta ?? null);
            if (!$dataResposta instanceof DateTimeImmutable) {
                continue;
            }
            if ($ultima === null || $dataResposta > $ultima) {
                $ultima = $dataResposta;
            }
        }
        return $ultima instanceof DateTimeImmutable ? $ultima->format('Y-m-d') : '--';
    }

    private function parseDataPesquisa(?string $valor): ?DateTimeImmutable
    {
        $texto = trim((string) $valor);
        if ($texto === '') {
            return null;
        }
        $data = DateTimeImmutable::createFromFormat('d/m/Y', $texto)
            ?: DateTimeImmutable::createFromFormat('Y-m-d', $texto);
        return $data instanceof DateTimeImmutable ? $data : null;
    }

    private function normalizarNota($valor): ?int
    {
        if ($valor === null || $valor === '') {
            return null;
        }
        if (!is_numeric($valor)) {
            return null;
        }
        $nota = (int) $valor;
        if ($nota <= 0) {
            return null;
        }
        return $nota;
    }

    private function extrairTemas(array $respostas): array
    {
        $contagem = [];
        $originais = [];

        foreach ($respostas as $resposta) {
            $campos = [
                $resposta->resposta4 ?? null,
                $resposta->resposta5 ?? null,
            ];

            foreach ($campos as $texto) {
                $texto = trim((string) $texto);
                if ($texto === '') {
                    continue;
                }
                $partes = preg_split('/[,\n;|]+/', $texto) ?: [];
                foreach ($partes as $parte) {
                    $tema = trim($parte);
                    if ($tema === '' || mb_strlen($tema) < 3) {
                        continue;
                    }
                    $chave = mb_strtolower($tema, 'UTF-8');
                    $contagem[$chave] = ($contagem[$chave] ?? 0) + 1;
                    if (!isset($originais[$chave])) {
                        $originais[$chave] = $tema;
                    }
                }
            }
        }

        if (empty($contagem)) {
            return [];
        }

        arsort($contagem);
        $top = array_slice($contagem, 0, 5, true);
        $temas = [];
        foreach ($top as $chave => $qtd) {
            $temas[] = [
                'tema' => $originais[$chave] ?? $chave,
                'qtd' => $qtd,
            ];
        }
        return $temas;
    }
}
