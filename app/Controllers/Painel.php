<?php

namespace App\Controllers;

use App\Entities\ReservaEntity;
use App\Models\UsuarioModel;
use App\Entities\UsuarioEntity;
use App\Entities\ConfiguracaoEntity;
use App\Models\ConfiguracaoModel;
use App\Models\ReservaModel;
use App\Models\ServicoModel;
use App\Models\ProdutoModel;

class Painel extends BaseController
{
    private const TOKEN_RECUPERACAO_TTL = 3600; // 1 hora
    
    public function home(){
        $reservaM = new ReservaModel();
        $data['vReserva'] = $reservaM->where('dataReserva = DATE(NOW())')
                ->where('status', ReservaEntity::STATUS_ATIVO)->orderBy('horaInicio')->findAll();
        $data['vReservasSemSaida'] = (new ReservaModel())
            ->where('dataReserva < CURRENT_DATE')
            ->where('status', ReservaEntity::STATUS_ATIVO)
            ->groupStart()
                ->where('horaEntrada IS NOT NULL', null, false)
                ->where('horaEntrada !=', '')
                ->where('horaEntrada !=', '0000-00-00 00:00:00')
            ->groupEnd()
            ->groupStart()
                ->where('horaSaida IS NULL', null, false)
                ->orWhere('horaSaida', '')
                ->orWhere('horaSaida', '0000-00-00 00:00:00')
            ->groupEnd()
            ->orderBy('dataReserva', 'DESC')
            ->orderBy('horaInicio', 'ASC')
            ->findAll();
        $servicoModel = new ServicoModel();
        $data['servicosAtivos'] = array_map(static function ($servico) {
            $valorBruto = (string) $servico->valor;
            $valorNumerico = str_contains($valorBruto, ',')
                ? str_replace(['.', ','], ['', '.'], $valorBruto)
                : $valorBruto;

            return [
                'id'    => (int) $servico->id,
                'nome'  => (string) $servico->Nome,
                'valor' => (float) $valorNumerico,
                'unidade' => (string) ($servico->unidade ?? ''),
            ];
        }, $servicoModel->where('ativo', 1)->orderBy('Nome', 'ASC')->findAll());
        $produtoModel = new ProdutoModel();
        $data['produtosAtivos'] = array_map(static function ($produto) {
            $valorBruto = (string) $produto->valor;
            $valorNumerico = str_contains($valorBruto, ',')
                ? str_replace(['.', ','], ['', '.'], $valorBruto)
                : $valorBruto;

            return [
                'id'    => (int) $produto->id,
                'nome'  => (string) $produto->nome,
                'valor' => (float) $valorNumerico,
            ];
        }, $produtoModel->orderBy('nome', 'ASC')->findAll());
        $configuracao = ConfiguracaoModel::getConfiguracao();
        $usarCalculoUsoEspaco = false;
        $servicoUsoEspacoId = 1;
        if ($configuracao instanceof ConfiguracaoEntity) {
            $usarCalculoUsoEspaco = (int) $configuracao->adicinarCalculoServico === ConfiguracaoEntity::ADICINAR_CALCULO_SERVICO_SIM;
            $servicoUsoEspacoId = (int) $configuracao->servicoUsoEspaco ?: 1;
        }
        $data['usarCalculoUsoEspaco'] = $usarCalculoUsoEspaco;
        $data['servicoUsoEspacoId'] = $servicoUsoEspacoId;
        return view('Painel/home', $data);
    }
    
    public function login(){
        return view('Painel/login');    
    }

    public function recuperarSenha(){
        return view('Painel/recuperarSenha');
    }

    public function doRecuperarSenha(){
        $email = trim((string) $this->request->getPost('email'));
        if ($email === '') {
            return $this->returnWithError('Informe um e-mail válido.');
        }

        $mensagemSucesso = 'Se o e-mail estiver cadastrado, enviaremos as instruções de recuperação em instantes.';
        $model = new UsuarioModel();
        $usuario = $model->where('login', $email)->first();

        if (!($usuario instanceof UsuarioEntity) || (int) $usuario->ativo !== 1) {
            return redirect()->back()->withInput()->with('msg_sucesso', $mensagemSucesso);
        }

        try {
            $token = $this->criarTokenRecuperacao($usuario);
            $resetUrl = base_url('Painel/alterarSenha/' . $token);

            $emailService = \Config\Services::email();
            $emailService->clear(true);
            $emailConfig = config('Email');
            if (!empty($emailConfig->fromEmail)) {
                $emailService->setFrom($emailConfig->fromEmail, $emailConfig->fromName ?: null);
            }
            $emailService->setTo($usuario->login);
            $emailService->setSubject('Recuperação de senha - InventaLab');
            $emailService->setMailType('html');
            $emailService->setMessage(view('Painel/recuperar_senha', [
                'usuario'  => $usuario,
                'resetUrl' => $resetUrl,
            ]));

            if (!$emailService->send()) {
                log_message('error', 'Falha ao enviar e-mail de recuperação de senha: ' . print_r($emailService->printDebugger(['headers', 'subject']), true));
                return $this->returnWithError('Não foi possível enviar as instruções de recuperação. Tente novamente mais tarde.');
            }
        } catch (\Throwable $exception) {
            log_message('error', 'Erro durante o envio de recuperação de senha: ' . $exception->getMessage());
            return $this->returnWithError('Não foi possível processar sua solicitação no momento. Tente novamente mais tarde.');
        }

        return redirect()->back()->with('msg_sucesso', $mensagemSucesso);
    }
    
    public function doAlterarSenha()
    {
        $token = (string) $this->request->getPost('token');
        $novaSenha = (string) $this->request->getPost('senha');
        $confirmaSenha = (string) $this->request->getPost('confirmaSenha');

        if ($token === '') {
            return redirect()->to('Painel/recuperarSenha')->with('msg_erro', 'Token de recuperação ausente. Solicite um novo link.');
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

            $model = new UsuarioModel();
            $usuario = $model->find((int) $payload['id']);

            if (!($usuario instanceof UsuarioEntity) || (int) $usuario->ativo !== 1) {
                throw new \RuntimeException('Usuário não encontrado ou inativo.');
            }

            $usuario->senha = $novaSenha;
            $model->allowCallbacks(false);
            $atualizado = $model->update($usuario->id, $usuario);
            $model->allowCallbacks(true);

            if ($atualizado === false) {
                $erros = $model->errors();
                throw new \RuntimeException(is_array($erros) ? implode(PHP_EOL, $erros) : 'Não foi possível atualizar a senha.');
            }

            UsuarioModel::logout();

            return redirect()->to('Painel/login')->with('msg_sucesso', 'Senha alterada com sucesso! Faça login com a nova senha.');
        } catch (\Throwable $exception) {
            return redirect()->back()->withInput()->with('msg_erro', $exception->getMessage());
        }
    }

    public function doLogin(){
        $um = new UsuarioModel();
        if($um->login($this->request->getPost('login'), $this->request->getPost('senha'))){
            return redirect()->to('Painel/home');
        }
        // restringir tentativas de login a 5 por minuto
        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress()), 5, MINUTE) === false) {
            throw new \RuntimeException('Você fez muitas tentativas aguarde e tente novamente em alguns instantes.', 429, null);
        }
        return $this->returnWithError('Login e/ou Senha inválidos');
    }
    
    public function logout(){
        $um = new UsuarioModel();
        $um->logout();
        return redirect()->to('Painel/login');
    }
    
    public function alterarPerfil(){
        $e = UsuarioModel::getSessao();
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $data = [
            'usuario' => $e,
        ];
        return view('Painel/perfil', $data);
    }
    
    public function doAlterarPerfil(){
        $m = new UsuarioModel();
        $e = $m->find(UsuarioModel::getSessao()->id);
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        if($m->login($e->login, $this->request->getPost('senhaAtual')) == false){
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
        if($post['senha'] == ''){
            unset($post['senha']);
        }
        if(!isset($post['ativo'])){
            unset($post['ativo']);
        }
        if(!isset($post['login'])){
            unset($post['login']);
        }
        $e->fill($post);        
        try{
            $ru['foto'] = $m->uploadImage($this->request->getFile('foto'), null, UsuarioEntity::folder);
            $e->foto = $ru['foto'] !== false ? $ru['foto'] : $foto;
            $m->db->transStart();
            if ($m->update($e->id, $e)) {
                if($ru['foto'] !== false) $m->deleteFile($foto);
                $m->db->transComplete();
                return $this->returnSucess('Cadastrado com sucesso!');
            } else {
                $m->deleteFiles($ru);
                return $this->returnWithError($m->errors());
            }
        }catch (\Exception $ex){
            if(isset($ru['foto']) && $ru['foto'] != false){
                $m->deleteFile($ru['foto']);
            }
        return $this->returnWithError($ex->getMessage());
        }
    }
    
    public function alterarSenha(string $token)
    {
        return view('Painel/alterarSenha', ['token' => $token]);
    }

    public function resource() {
        $pastarPermitidas = [
            'arquivooficina_arquivos',
            'produto_arquivos',
            'materialoficina_arquivos',
            'recursotrabalho_arquivos',
            'participante_arquivos',
            'usuario_arquivos',
            'evento_arquivos',
        ];
        $uri = $this->request->getUri();
        $filepath = WRITEPATH . $uri->getSegment(1) . '/' . $uri->getSegment(2);
        
        if(!in_array($uri->getSegment(1), $pastarPermitidas)
                || !is_file($filepath)){
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

    private function criarTokenRecuperacao(UsuarioEntity $usuario): string
    {
        $payload = [
            'id'    => $usuario->id,
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
}
