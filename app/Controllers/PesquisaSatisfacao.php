<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\ParticipanteEntity;
use App\Models\PesquisaSatisfacaoModel;
use App\Entities\PesquisaSatisfacaoEntity;
use App\Entities\ReservaEntity;
use App\Models\ConfiguracaoModel;
use App\Models\ReservaModel;
use DateTime;

class PesquisaSatisfacao extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/PesquisaSatisfacao/cadastrar');
    }

    public function doCadastrar() {
        $m = new PesquisaSatisfacaoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new PesquisaSatisfacaoEntity($this->request->getPost());
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
        $m = new PesquisaSatisfacaoModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $data = [
            'pesquisasatisfacao' => $e,
        ];
        return view('Painel/PesquisaSatisfacao/alterar', $data);
    }

    public function doAlterar() {
        $m = new PesquisaSatisfacaoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new PesquisaSatisfacaoEntity($this->request->getPost());
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
        return view('Painel/PesquisaSatisfacao/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new PesquisaSatisfacaoModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vPesquisaSatisfacao' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/PesquisaSatisfacao/resposta',  $data);
    }
    
    public function listar() {
        $m = new PesquisaSatisfacaoModel();
        $data = [
            'vPesquisaSatisfacao' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/PesquisaSatisfacao/listar', $data);
    }

    public function excluir() {
        $m = new PesquisaSatisfacaoModel();
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
        return view('Painel/PesquisaSatisfacao/relatorio');
    }
}
