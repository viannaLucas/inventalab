<?php

namespace App\Controllers;

use App\Entities\AtividadeLivreEntity;
use App\Entities\AtividadeLivreRecursoEntity;
use App\Entities\Cast\CastDateBR;
use App\Entities\DatasExtraordinariasEntity;
use App\Entities\EventoEntity;
use App\Entities\OficinaTematicaReservaEntity;
use App\Models\ParticipanteModel;
use App\Entities\ParticipanteEntity;
use App\Entities\ReservaEntity;
use App\Entities\ReservaParticipanteEntity;
use App\Libraries\ValidacaoCadastroReserva;
use App\Models\AtividadeLivreModel;
use App\Models\AtividadeLivreRecursoModel;
use App\Models\ConfiguracaoModel;
use App\Models\DatasExtraordinariasModel;
use App\Models\EventoModel;
use App\Models\HorarioFuncionamentoModel;
use App\Models\OficinaTematicaModel;
use App\Models\OficinaTematicaReservaModel;
use App\Models\RecursoTrabalhoModel;
use App\Models\ReservaModel;
use App\Models\ReservaParticipanteModel;
use CodeIgniter\HTTP\ResponseInterface;
use DateInterval;
use DateTime;
use stdClass;

class PainelParticipante extends BaseControllerParticipante
{
    private const TOKEN_RECUPERACAO_TTL = 3600; // 1 hora

    public function site()
    {
        helper('form');
        $data['eventos'] = (new EventoModel())->where('dataInicio >', date('Y-m-d'))
            ->where('divulgar', 1)->orderBy('dataInicio ASC')->findAll();
        return view('site', $data);
    }

    public function enviarContatoSite()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->to(base_url('/#contato'));
        }

        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress() . '|contato_site'), 5, MINUTE) === false) {
            return redirect()
                ->to(base_url('/#contato'))
                ->withInput()
                ->with('msg_erro', 'Você fez muitas tentativas de contato. Aguarde alguns instantes e tente novamente.');
        }

        $validacao = \Config\Services::validation();
        $validacao->setRules([
            'name' => ['label' => 'Nome', 'rules' => 'required|min_length[3]|max_length[100]'],
            'email' => ['label' => 'E-mail', 'rules' => 'required|valid_email|max_length[150]'],
            'message' => ['label' => 'Mensagem', 'rules' => 'required|min_length[10]|max_length[2000]'],
        ]);

        if (!$validacao->withRequest($this->request)->run()) {
            return redirect()
                ->to(base_url('/#contato'))
                ->withInput()
                ->with('msg_erro', implode(PHP_EOL, $validacao->getErrors()));
        }

        $nome = trim((string) $this->request->getPost('name'));
        $email = trim((string) $this->request->getPost('email'));
        $mensagem = trim((string) $this->request->getPost('message'));

        $emailService = \Config\Services::email();
        $emailService->clear(true);
        $emailConfig = config('Email');

        $destinatario = trim((string) ($emailConfig->fromEmail ?? ''));
        if ($destinatario === '') {
            log_message('error', 'E-mail de destino não configurado para contato do site.');
            return redirect()
                ->to(base_url('/#contato'))
                ->withInput()
                ->with('msg_erro', 'Não foi possível enviar sua mensagem no momento. Tente novamente mais tarde.');
        }
        if (!empty($emailConfig->fromEmail)) {
            $emailService->setFrom($emailConfig->fromEmail, $emailConfig->fromName ?: null);
        }
        
        $emailService->setTo($destinatario);
        $emailService->setReplyTo($email, $nome);
        $emailService->setSubject('Contato via site - InventaLab');
        $emailService->setMailType('html');
        $emailService->setMessage(
            '<p>Mensagem enviada pelo formulário de contato do site.</p>'
            . '<p><strong>Nome:</strong> ' . esc($nome) . '</p>'
            . '<p><strong>E-mail:</strong> ' . esc($email) . '</p>'
            . '<p><strong>Mensagem:</strong><br>' . nl2br(esc($mensagem)) . '</p>'
            . '<p><strong>IP:</strong> ' . esc($this->request->getIPAddress()) . '</p>'
        );

        $enviado = $emailService->send();
        $debug = print_r($emailService->printDebugger(['headers', 'subject']), true);

        if (!$enviado) {
            log_message('error', 'Falha ao enviar contato do site: ' . $debug);
            return redirect()
                ->to(base_url('/#contato'))
                ->withInput()
                ->with('msg_erro', 'Não foi possível enviar sua mensagem no momento. Tente novamente mais tarde.');
        }

        log_message('info', 'Contato do site enviado com sucesso. Debug: ' . $debug);
        return redirect()
            ->to(base_url('/#contato'))
            ->with('msg_sucesso', 'Mensagem enviada com sucesso! Entraremos em contato em breve.');
    }

    public function home()
    {   
        $participante = ParticipanteModel::getSessao();
        $reservaParticipante = (new ReservaParticipanteModel())
            ->where('Participante_id', $participante->id)
            ->orderBy('id', 'DESC')->findAll(5);
        $data['vReservas'] = [];
        foreach ($reservaParticipante as $reservaItem) {
            $reserva = $reservaItem->getReserva();
            if ($reserva !== null) {
                $data['vReservas'][] = $reserva;
            }
        }
        $data['eventos'] = (new EventoModel())->where('dataInicio >', date('Y-m-d'))
            ->where('divulgar', 1)->orderBy('dataInicio ASC')->findAll();
        return view('PainelParticipante/home', $data);
    }

    public function detalheEvento(){
        $id = $this->request->getUri()->getSegment(2);
        if($id == '' || !is_numeric($id)){
            return redirect()->to(base_url());
        }
        $evento = (new EventoModel())->find($id);
        if($evento == null){
            return redirect()->to(base_url());            
        }

        return view('evento', ['evento'=>$evento]);
    }

    public function login()
    {
        return view('PainelParticipante/login', [
            'recuperarSenhaUrl' => base_url('PainelParticipante/recuperarSenha'),
        ]);
    }


    public function cadastrar()
    {
        return view('PainelParticipante/cadastro');
    }

    public function consultaCep(string $cep = '')
    {
        $cep = preg_replace('/\D+/', '', (string) $cep);
        if ($cep === '' || strlen($cep) !== 8) {
            return $this->response->setStatusCode(400)->setJSON([
                'erro' => true,
                'msg' => 'CEP inválido.',
            ]);
        }

        try {
            $client = \Config\Services::curlrequest();
            $response = $client->get("https://viacep.com.br/ws/{$cep}/json/", [
                'http_errors' => false,
                'timeout' => 5,
                'connect_timeout' => 3,
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'erro' => true,
                'msg' => 'Não foi possível consultar o CEP no momento.',
            ]);
        }

        if ($response->getStatusCode() !== 200) {
            return $this->response->setStatusCode(502)->setJSON([
                'erro' => true,
                'msg' => 'Não foi possível consultar o CEP no momento.',
            ]);
        }

        $dados = json_decode($response->getBody(), true);
        if (!is_array($dados)) {
            return $this->response->setStatusCode(502)->setJSON([
                'erro' => true,
                'msg' => 'Resposta inválida do serviço de CEP.',
            ]);
        }

        if (!empty($dados['erro'])) {
            return $this->response->setStatusCode(404)->setJSON([
                'erro' => true,
                'msg' => 'CEP não encontrado.',
            ]);
        }

        return $this->response->setJSON([
            'erro' => false,
            'logradouro' => $dados['logradouro'] ?? '',
            'bairro' => $dados['bairro'] ?? '',
            'cidade' => $dados['localidade'] ?? '',
            'codigoCidade' => $dados['ibge'] ?? '',
            'uf' => $dados['uf'] ?? '',
        ]);
    }

    public function doCadastrar()
    {
        $validacao = \Config\Services::validation();
        $validacao->setRules([
            'nome'            => ['label' => 'Nome', 'rules' => 'required'],
            'email'           => [
                'label' => 'E-mail', 
                'rules' => 'required|valid_email|is_unique[Participante.email]',
                'erros' => ['is_unique[Participante.email]' => 'Email já cadastrado, use a recuperação de senha na tela de login.']
            ],
            'telefone'        => ['label' => 'Telefone', 'rules' => 'required|telefone'],
            'cpf'             => ['label' => 'CPF', 'rules' => 'required|cpf|max_length[20]'],
            'logradouro'      => ['label' => 'Logradouro', 'rules' => 'required|max_length[200]'],
            'numero'          => ['label' => 'Número', 'rules' => 'permit_empty|integer|max_length[20]'],
            'bairro'          => ['label' => 'Bairro', 'rules' => 'required|max_length[100]'],
            'cidade'          => ['label' => 'Cidade', 'rules' => 'required|max_length[100]'],
            'uf'              => ['label' => 'UF', 'rules' => 'required|in_list[AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO]'],
            'cep'             => ['label' => 'CEP', 'rules' => 'required|cep|max_length[10]'],
            'dataNascimento'  => ['label' => 'Data de Nascimento', 'rules' => 'required|valid_date[d/m/Y]'],
            'senha'           => [
                'label' => 'Senha',
                'rules' => 'required|senhaForte',
                'errors' => [
                    'senhaForte' => 'A senha deve ter no mínimo 6 caracteres, com ao menos 1 letra maiúscula, 1 letra minúscula e 1 número.',
                ],
            ],
            'confirmaSenha'   => ['label' => 'Confirmação de Senha', 'rules' => 'required|matches[senha]'],
        ]);

        if (!$validacao->withRequest($this->request)->run()) {
            return $this->returnWithError(implode(PHP_EOL, $validacao->getErrors()));
        }

        $dados = [
            'nome'           => (string) $this->request->getPost('nome'),
            'email'          => (string) $this->request->getPost('email'),
            'telefone'       => (string) $this->request->getPost('telefone'),
            'cpf'            => (string) $this->request->getPost('cpf'),
            'logradouro'     => (string) $this->request->getPost('logradouro'),
            'numero'         => (string) $this->request->getPost('numero'),
            'bairro'         => (string) $this->request->getPost('bairro'),
            'cidade'         => (string) $this->request->getPost('cidade'),
            'uf'             => (string) $this->request->getPost('uf'),
            'cep'            => (string) $this->request->getPost('cep'),
            'dataNascimento' => (string) $this->request->getPost('dataNascimento'),
        ];
        $faturarResponsavel = (string) $this->request->getPost('faturarResponsavel') === '1';
        $nomeResponsavel = trim((string) $this->request->getPost('nomeResponsavel'));
        if ($faturarResponsavel) {
            if (strlen($nomeResponsavel) < 5) {
                return $this->returnWithError('O nome do responsável deve ter no mínimo 5 caracteres.');
            }
            $dados['nomeResponsavel'] = $nomeResponsavel;
        } else {
            $dados['nomeResponsavel'] = '';
        }

        // Calcula idade para definir suspensão (menor de 18 => suspenso)
        try {
            $dn = new \DateTime(CastDateBR::set($dados['dataNascimento']));
            $idade = $dn->diff(new \DateTime('today'))->y;
        } catch (\Throwable $e) {
            return $this->returnWithError('Data de nascimento inválida.');
        }

        $dados['suspenso'] = ($idade < 18)
            ? ParticipanteEntity::SUSPENSO_SIM
            : ParticipanteEntity::SUSPENSO_NAO;

        $participante = new ParticipanteEntity($dados);
        $participante->senha = (string) $this->request->getPost('senha');

        $model = new ParticipanteModel();
        try {
            if ($model->insert($participante) === false) {
                $erros = $model->errors();
                return $this->returnWithError(is_array($erros) ? implode(PHP_EOL, $erros) : 'Não foi possível concluir o cadastro.');
            }
        } catch (\Throwable $e) {
            return $this->returnWithError('Não foi possível concluir o cadastro.');
        }

        // Envia e-mail de confirmação de cadastro
        try {
            $hash = hash('sha256', strtolower($participante->email) . '|' . time() . '|' . bin2hex(random_bytes(8)));
            $confirmUrl = base_url('PainelParticipante/confirmarCadastro?h=' . $hash);

            $emailService = \Config\Services::email();
            $emailService->clear(true);
            $emailConfig = config('Email');
            if (!empty($emailConfig->fromEmail)) {
                $emailService->setFrom($emailConfig->fromEmail, $emailConfig->fromName ?: null);
            }

            $emailService->setTo((string) $participante->email);
            $emailService->setSubject('Confirmação de cadastro - Participante InventaLab');
            $emailService->setMailType('html');
            $emailService->setMessage(view('PainelParticipante/confirmacaoEmail', [
                'participante' => $participante,
                'confirmUrl'   => $confirmUrl,
            ]));

            $emailService->send(); // Em caso de falha, apenas registra
        } catch (\Throwable $e) {
            log_message('error', 'Falha ao enviar confirmação de cadastro: ' . $e->getMessage());
        }
        return view('PainelParticipante/confirmacaoCadastro');
    }

    public function confirmarCadastro()
    {
        return redirect()->to('PainelParticipante/login')->with('msg_sucesso', 'Confirmação realizada com sucesso!');
    }

    public function recuperarSenha()
    {
        return view('PainelParticipante/recuperarSenha');
    }

    public function doRecuperarSenha()
    {
        $email = trim((string) $this->request->getPost('email'));
        if ($email === '') {
            return $this->returnWithError('Informe um e-mail válido.');
        }

        $mensagemSucesso = 'Se o e-mail estiver cadastrado, enviaremos as instruções de recuperação em instantes.';
        $model = new ParticipanteModel();
        $participante = $model->where('email', $email)->first();

        if (!($participante instanceof ParticipanteEntity) || (int) $participante->suspenso === ParticipanteEntity::SUSPENSO_SIM) {
            return redirect()->back()->withInput()->with('msg_sucesso', $mensagemSucesso);
        }

        try {
            $token = $this->criarTokenRecuperacao($participante);
            $resetUrl = base_url('PainelParticipante/alterarSenha/' . $token);

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
                log_message('error', 'Participante sem e-mail/login cadastrado para recuperação de senha. ID: ' . $participante->id);
                return $this->returnWithError('Não foi possível enviar as instruções de recuperação. Tente novamente mais tarde.');
            }

            $emailService->setTo($destinatario);
            $emailService->setSubject('Recuperação de senha - Participante InventaLab');
            $emailService->setMailType('html');
            $emailService->setMessage(view('PainelParticipante/recuperar_senha', [
                'participante' => $participante,
                'resetUrl' => $resetUrl,
            ]));

            if (!$emailService->send()) {
                log_message('error', 'Falha ao enviar e-mail de recuperação de senha para participante: ' . print_r($emailService->printDebugger(['headers', 'subject']), true));
                return $this->returnWithError('Não foi possível enviar as instruções de recuperação. Tente novamente mais tarde.');
            }
        } catch (\Throwable $exception) {
            log_message('error', 'Erro durante o envio de recuperação de senha para participante: ' . $exception->getMessage());
            return $this->returnWithError('Não foi possível processar sua solicitação no momento. Tente novamente mais tarde.');
        }

        return redirect()->back()->with('msg_sucesso', $mensagemSucesso);
    }

    public function doLogin()
    {
        $um = new ParticipanteModel();
        if ($um->login($this->request->getPost('email'), $this->request->getPost('senha'))) {
            return redirect()->to('PainelParticipante/home');
        }
        // restringir tentativas de login a 5 por minuto
        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress()), 5, MINUTE) === false) {
            throw new \RuntimeException('Você fez muitas tentativas aguarde e tente novamente em alguns instantes.', 429, null);
        }
        return $this->returnWithError('Login e/ou Senha inválidos');
    }

    public function logout()
    {
        $um = new ParticipanteModel();
        $um->logout();
        return redirect()->to('PainelParticipante/login');
    }

    public function eventos()
    {
        $e = ParticipanteModel::getSessao();
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        
        $data = [
            'participante' => $e,
        ];

        $data['eventos'] = (new EventoModel())->where('dataInicio >', date('Y-m-d'))
            ->where('divulgar', 1)->orderBy('dataInicio ASC')->findAll();
        return view('PainelParticipante/eventos', $data);
    }

    public function alterarPerfil()
    {
        $e = ParticipanteModel::getSessao();
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $data = [
            'participante' => $e,
        ];
        return view('PainelParticipante/perfil', $data);
    }

    public function doAlterarPerfil()
    {
        $m = new ParticipanteModel();
        $e = $m->find(ParticipanteModel::getSessao()->id);
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        if ($m->login($e->email, $this->request->getPost('senhaAtual')) == false) {
            // restringir tentativas de login a 5 por minuto
            $throttler = \Config\Services::throttler();
            if ($throttler->check(md5($this->request->getIPAddress()), 3, MINUTE) === false) {
                throw new \RuntimeException('Você fez muitas tentativas aguarde e tente novamente em alguns instantes.', 429, null);
            }
            return $this->returnWithError('Senha inválida');
        }
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }

        $foto = $e->foto;
        $post = $this->request->getPost();
        unset($post['codigoApiSesc']);
        $faturarResponsavel = (string) $this->request->getPost('faturarResponsavel') === '1';
        $nomeResponsavel = trim((string) ($post['nomeResponsavel'] ?? ''));
        if ($faturarResponsavel) {
            if (strlen($nomeResponsavel) < 5) {
                return $this->returnWithError('O nome do responsável deve ter no mínimo 5 caracteres.');
            }
            $post['nomeResponsavel'] = $nomeResponsavel;
        } else {
            $post['nomeResponsavel'] = '';
        }
        if ($post['senha'] == '') {
            unset($post['senha']);
        }
        if (!isset($post['ativo'])) {
            unset($post['ativo']);
        }
        if (!isset($post['email'])) {
            unset($post['email']);
        }
        $e->fill($post);
        try {
            $ru['foto'] = $m->uploadImage($this->request->getFile('foto'), null, ParticipanteEntity::folder);
            $e->foto = $ru['foto'] !== false ? $ru['foto'] : $foto;
            $m->db->transStart();
            if ($m->update($e->id, $e)) {
                if ($ru['foto'] !== false) $m->deleteFile($foto);
                $m->db->transComplete();
                return redirect()->to('PainelParticipante/home', null, 'refresh')->with('msg_sucesso', 'Alterado com sucesso!');
            } else {
                $m->deleteFiles($ru);
                return $this->returnWithError($m->errors());
            }
        } catch (\Exception $ex) {
            if (isset($ru['foto']) && $ru['foto'] != false) {
                $m->deleteFile($ru['foto']);
            }
            return $this->returnWithError($ex->getMessage());
        }
    }

    public function alterarSenha(string $token)
    {
        return view('PainelParticipante/alterarSenha', ['token' => $token]);
    }

    public function doAlterarSenha()
    {
        $token = (string) $this->request->getPost('token');
        $novaSenha = (string) $this->request->getPost('senha');
        $confirmaSenha = (string) $this->request->getPost('confirmaSenha');

        if ($token === '') {
            return redirect()->to('PainelParticipante/recuperarSenha')->with('msg_erro', 'Token de recuperação ausente. Solicite um novo link.');
        }

        $validacao = \Config\Services::validation();
        $validacao->setRules([
            'senha' => [
                'label' => 'Senha',
                'rules' => 'required|senhaForte',
                'errors' => [
                    'senhaForte' => 'A senha deve ter no mínimo 6 caracteres, com ao menos 1 letra maiúscula, 1 letra minúscula e 1 número.',
                ],
            ],
            'confirmaSenha' => ['label' => 'Confirmação de Senha', 'rules' => 'required|matches[senha]'],
        ]);

        if (!$validacao->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('msg_erro', implode(PHP_EOL, $validacao->getErrors()));
        }

        try {
            $payload = $this->decodificarTokenRecuperacao($token);

            if (!isset($payload['id'], $payload['ts'])) {
                throw new \RuntimeException('Token inválido.');
            }

            if ((time() - (int) $payload['ts']) > self::TOKEN_RECUPERACAO_TTL) {
                throw new \RuntimeException('Token expirado. Solicite uma nova recuperação de senha.');
            }

            $model = new ParticipanteModel();
            $participante = $model->find((int) $payload['id']);

            if (!($participante instanceof ParticipanteEntity)) {
                throw new \RuntimeException('Participante não encontrado.');
            }

            if ((int) $participante->suspenso === ParticipanteEntity::SUSPENSO_SIM) {
                throw new \RuntimeException('Participante suspenso.');
            }

            $participante->senha = $novaSenha;
            $model->allowCallbacks(false);
            $atualizado = $model->update($participante->id, $participante);
            $model->allowCallbacks(true);

            if ($atualizado === false) {
                $erros = $model->errors();
                throw new \RuntimeException(is_array($erros) ? implode(PHP_EOL, $erros) : 'Não foi possível atualizar a senha.');
            }

            ParticipanteModel::logout();

            return redirect()->to('PainelParticipante/login')->with('msg_sucesso', 'Senha alterada com sucesso! Faça login com a nova senha.');
        } catch (\Throwable $exception) {
            return redirect()->back()->withInput()->with('msg_erro', $exception->getMessage());
        }
    }

    public function resource()
    {
        $pastarPermitidas = [
            'arquivooficina_arquivos',
            'produto_arquivos',
            'materialoficina_arquivos',
            'recursotrabalho_arquivos',
            'participante_arquivos',
        ];
        $uri = $this->request->getUri();
        $filepath = WRITEPATH . $uri->getSegment(1) . '/' . $uri->getSegment(2);

        if (
            !in_array($uri->getSegment(1), $pastarPermitidas)
            || !is_file($filepath)
        ) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            return;
        }

        $mime = mime_content_type($filepath);
        header('Content-Length: ' . filesize($filepath));
        header("Content-Type: $mime");
        header('Content-Disposition: inline; filename="' . $uri->getSegment(2) . '";');
        readfile($filepath);
        exit();
    }

    private function criarTokenRecuperacao(ParticipanteEntity $participante): string
    {
        $payload = [
            'id'    => $participante->id,
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

    public function inscricao()
    {
        $Evento_id = $this->request->getUri()->getSegment(3);
        if(!is_numeric($Evento_id) && $Evento_id <= 0){
            return $this->returnWithError('Evento não encontrado');
        }
        $eventoModel = new EventoModel();
        $evento = $eventoModel->find($Evento_id);
        if($evento == null){
            return $this->returnWithError('Evento não encontrado');
        }

        $data['participante'] = ParticipanteModel::getSessao();
        $data['evento'] = $evento;

        return view('PainelParticipante/inscricao', $data);
    }

    public function cancelarInscricao()
    {
        
    }

    public function inscricoes()
    {

    }

    public function reserva()
    {
        $data['vOficinaTematica'] = (new OficinaTematicaModel())
            ->where('situacao', 0)->findAll();
        $data['vHorarioFuncionamento'] = (new HorarioFuncionamentoModel())
            ->orderBy('diaSemana ASC, horaInicio ASC')->findAll();
        $data['vRecursoTrabalho'] = [];
        $data['configuracao'] = (new ConfiguracaoModel())->find(1);
        $data['vDatasFechado'] = (new DatasExtraordinariasModel())
            ->where('tipo', DatasExtraordinariasEntity::TIPO_FECHADO)
            ->where('data >=  DATE(NOW())')->findAll();
        $data['vDatasAberto'] = (new DatasExtraordinariasModel())
            ->where('tipo', DatasExtraordinariasEntity::TIPO_ABERTO)
            ->where('data >=  DATE(NOW())')->findAll();
        $vReserva = (new ReservaModel())->where('status', ReservaEntity::STATUS_ATIVO)
            ->where('dataReserva >= CURRENT_DATE')->findAll();

        $data['itensReserva'] = $this->formatarReservaView($vReserva);
        $data['participante'] = ParticipanteModel::getSessao();

        foreach ((new RecursoTrabalhoModel())->findAll() as $rt) {
            $ac = new \stdClass();
            $ac->id = $rt->id;
            $ac->exclusive = $rt->usoExclusivo == 1;
            $ac->name = $rt->nome;
            $ac->quantity = 1;
            $data['vRecursoTrabalho'][] = $ac;
        }
        $data['lAtividades'] = [];
        foreach ($data['vOficinaTematica'] as $i) {
            $rid = [];
            foreach ($i->getListRecursoOficina() as $r) {
                $rid[] = $r->RecursoTrabalho_id;
            }
            $ac = new \stdClass();
            $ac->id = $i->id;
            $ac->description = ''; //$i->descricaoAtividade;
            $ac->name = $i->nome;
            $ac->resourceIds = $rid;
            $data['lAtividades'][] = $ac;
        }
        return view('PainelParticipante/reserva', $data);
    }

    private function formatarReservaView($vReserva): array
    {
        $itensReserva = [];
        foreach($vReserva as $r){
            $i = new stdClass();
            $i->date = DateTime::createFromFormat('d/m/Y', $r->dataReserva)->format(('Y-m-d'));
            $i->start = $r->horaInicio;
            $i->duration = $r->getDuracaoEmMinutos();
            $i->people = $r->numeroConvidados+1;
            $i->name = '';
            $vOficinaTematica = $r->getListOficinaTematicaReserva();
            $ac = new stdClass();
            if(!empty($vOficinaTematica)){
                $ac->type = 'oficina';
                $ac->id = $vOficinaTematica[0]->id;
            }
            $vAtividadeLivre = $r->getListAtividadeLivre();
            if(!empty($vAtividadeLivre)){
                $ac->type = 'livre';
                $ac->descricao = 'Atividade Livre';
                $ac->resourceIds = array_map(function($n){ $n->id; }, $vAtividadeLivre[0]->getListAtividadeLivreRecurso());
            }            
            $i->activity = $ac;            
            $itensReserva[] = $i;
        }
        return $itensReserva;
    }

    public function listaReservaJson()
    {
        $vReserva = (new ReservaModel())->where('status', ReservaEntity::STATUS_ATIVO)
            ->where('dataReserva >= CURRENT_DATE')->findAll();
        return $this->response->setJSON($this->formatarReservaView($vReserva));
    }

    public function descricaoOficina() {
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

    public function cadastrarReserva() {
        //sample data: {"date":"2025-09-30","interval":[{"start":"10:30","duration":90},{"start":"14:00","duration":120}],"people":1,"name":"Lucas Participante","participantId":"3","note":"","activity":{"type":"oficina","id":"2"},"isClass":false,"nameSchool":"","yearClass":""}
        $data = $this->request->getJSON();
        $data->participantId = ParticipanteModel::getSessao()?->id;
        $validador = new ValidacaoCadastroReserva();
        $resultadoValidacao = $validador->validarDadosInputCadastrar($data);
        if ($resultadoValidacao !== true) {
            return $this->response->setJSON($resultadoValidacao);
        }
        
        $reservaModel = new ReservaModel();
        $reservaModel->db->transStart();
        try {
            foreach($data->interval as $r){
                $inicioReserva = DateTime::createFromFormat('Y-m-d H:i', $data->date.' '.$r->start);
                $fimReserva = clone $inicioReserva;
                $fimReserva->add(new DateInterval('PT'.$r->duration.'M'));
                
                $reservaEntity = new ReservaEntity();
                $reservaEntity->dataCadastro = (new DateTime())->format(('d/m/Y'));
                $reservaEntity->dataReserva = DateTime::createFromFormat('Y-m-d', $data->date)->format('d/m/Y');
                $reservaEntity->horaInicio = $r->start;
                $reservaEntity->horaFim = $fimReserva->format('H:i');
                $reservaEntity->tipo = ReservaEntity::TIPO_COMPARTILHADA;
                $reservaEntity->numeroConvidados = $data->people - 1;
                $reservaEntity->status = ReservaEntity::STATUS_ATIVO;
                $reservaEntity->turmaEscola = $data->isClass === true ? ReservaEntity::TURMA_ESCOLA_SIM : ReservaEntity::TURMA_ESCOLA_NAO;
                $reservaEntity->nomeEscola = $data->nameSchool;
                $reservaEntity->anoTurma = $data->yearClass;

                if (!$reservaModel->insert($reservaEntity, false)) {
                    return $this->prepareErrorJson($reservaModel->errors());
                }
                $reservaEntity->id = $reservaModel->getInsertID();
                $resPartEntity = new ReservaParticipanteEntity();
                $resPartEntity->Participante_id = $data->participantId;
                $resPartEntity->Reserva_id = $reservaEntity->id;
                $participanteModel = new ReservaParticipanteModel();
                if(!$participanteModel->insert($resPartEntity, false)){
                    return $this->prepareErrorJson(['Erro ao cadastrar Reserva Participante', ...$participanteModel->errors()]);
                }

                if($data->activity->type == 'oficina'){
                    $oficTematicaReserva = new OficinaTematicaReservaEntity();
                    $oficTematicaReserva->Reserva_id = $reservaEntity->id;
                    $oficTematicaReserva->OficinaTematica_id = $data->activity->id;
                    $oficTematicaReserva->observacao = $data->note;
                    $oficTemModel = new OficinaTematicaReservaModel();
                    if(!$oficTemModel->insert($oficTematicaReserva, false)){
                        return $this->prepareErrorJson(['Erro ao Vincular Oficina Reserva', ...$oficTemModel->errors()]);
                    }
                }
                if($data->activity->type == 'livre'){
                    $ativLivreEntity = new AtividadeLivreEntity();
                    $ativLivreEntity->Reserva_id = $reservaEntity->id;
                    $ativLivreEntity->descricao = $data->activity->description;
                    $ativLivreModel = new AtividadeLivreModel();
                    if(!$ativLivreModel->insert($ativLivreEntity, false)){
                        return $this->prepareErrorJson(['Erro ao Vincular Atividade Livre', ...$ativLivreModel->errors()]);
                    }
                    $ativLivreRecurso = new AtividadeLivreRecursoEntity();
                    $ativLivreRecurso->AtividadeLivre_id = $ativLivreModel->getInsertID();
                    $ativLivreRecursoModel = new AtividadeLivreRecursoModel();
                    foreach($data->activity->resourceIds as $r_id){
                        $ativLivreRecurso->RecursoTrabalho_id = $r_id;                        
                        if(!$ativLivreRecursoModel->insert($ativLivreRecurso, false)){
                            return $this->prepareErrorJson(['Erro ao Vincular Recursos à Atividade Livre', ...$ativLivreRecursoModel->errors()]);
                        }
                    }
                }

            }
            $reservaModel->db->transComplete();
            $sucesso = ['erro' => false, 'msg' => 'Cadastrado com sucesso!'];
            return $this->response->setJson($sucesso);
        } catch (\Exception $ex) {
            return $this->prepareErrorJson($ex->getMessage());
        }
    }
    
    private function prepareErrorJson(string|array $errors): ResponseInterface
    {   
        $msg = is_array($errors) ? implode("\n", $errors) : $errors;
        $error = ['erro' => true, 'msg' => $msg];
        return $this->response->setJson($error);
    }

    public function listarReservas()
    {
        $participante = ParticipanteModel::getSessao();
        $reservaParticipante = (new ReservaParticipanteModel())
            ->where('Participante_id', $participante->id)
            ->orderBy('id', 'DESC')->findAll(100);
        $data['vReservas'] = [];
        foreach ($reservaParticipante as $reservaItem) {
            $reserva = $reservaItem->getReserva();
            if ($reserva !== null) {
                $data['vReservas'][] = $reserva;
            }
        }

        return view('PainelParticipante/listaReserva', $data);
    }
}
