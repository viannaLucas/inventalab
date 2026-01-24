<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ParticipanteModel;
use App\Entities\ParticipanteEntity;
use App\Models\HabilidadesModel;
use App\Entities\HabilidadesEntity;


class Participante extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/Participante/cadastrar');
    }

    public function doCadastrar() {
        $m = new ParticipanteModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $post = $this->request->getPost();
        unset($post['codigoApiSesc']);
        
        // Verificação: se o termo de responsabilidade não foi definido e a idade for menor que 18 anos
        // deve ser forçado o valor sim para o campo suspenso
        if (empty($post['termoResponsabilidade']) && isset($post['dataNascimento'])) {
            $dataNascimento = new \DateTime($post['dataNascimento']);
            $hoje = new \DateTime();
            $idade = $hoje->diff($dataNascimento)->y;
            
            if ($idade < 18) {
                $post['suspenso'] = ParticipanteEntity::SUSPENSO_SIM;
            }
        }
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
        
        $post['senha'] = $this->gerarSenha();
        $e = new ParticipanteEntity($post);
        $e->termoResponsabilidade = $this->getRandomName('termoResponsabilidade');
        $m->db->transStart();
        try {
            if ($m->insert($e, false)) { 
                $m->uploadFile($this->request->getFile('termoResponsabilidade'), $e->termoResponsabilidade);
                $mHabilidades = new HabilidadesModel();
                $Habilidades = $this->request->getPost('Habilidades') ?? [];
                foreach ($Habilidades as $pp){
                    $pp['Participante_id'] = $m->getInsertID();
                    $eHabilidades = new HabilidadesEntity($pp);
                    if(!$mHabilidades->insert($eHabilidades, false)){
                        return $this->returnWithError($mHabilidades->errors());
                    }
                }
                $m->db->transComplete();
                $this->enviarEmailBoasVindas($e);
                return $this->returnSucess('Cadastrado com sucesso! Enviamos um e-mail com as instruções de acesso.');
            } else {
                return $this->returnWithError($m->errors());
            }
        } catch (\Exception $ex) {
            return $this->returnWithError($ex->getMessage());
        }
    }

    public function alterar() {
        $m = new ParticipanteModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $data = [
            'participante' => $e,
        ];
        return view('Painel/Participante/alterar', $data);
    }

    public function doAlterar() {
        $m = new ParticipanteModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $post = $this->request->getPost();
        unset($post['codigoApiSesc']);
        if(isset($post['senha'])){ //não pode alterar a senha
            $post['senha'] = $e->senha;
        }
        if(isset($post['email'])){ //não pode alterar email
            $post['email'] = $e->email;
        }
        // Verificação: se o termo de responsabilidade não foi definido e a idade for menor que 18 anos
        // deve ser forçado o valor sim para o campo suspenso
        if ((empty($post['termoResponsabilidade']) && $e->termoResponsabilidade == '') && isset($post['dataNascimento'])) {
            $dataNascimento = new \DateTime($post['dataNascimento']);
            $hoje = new \DateTime();
            $idade = $hoje->diff($dataNascimento)->y;
            
            if ($idade < 18) {
                $post['suspenso'] = ParticipanteEntity::SUSPENSO_SIM;
            }
        }
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
        $en = new ParticipanteEntity($post);
        try{ 
            $ru['termoResponsabilidade'] = $m->uploadFile($this->request->getFile('termoResponsabilidade'), null, ParticipanteEntity::folder);
            $en->termoResponsabilidade = $ru['termoResponsabilidade'] !== false ? $ru['termoResponsabilidade'] : $e->termoResponsabilidade;
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                $mHabilidades = new HabilidadesModel();
                $idsDelete = array_map(fn($v):int => $v->id, $e->getListHabilidades());
                if(count($idsDelete)>0){
                    $mHabilidades->delete($idsDelete);
                }
                $Habilidades = $this->request->getPost('Habilidades') ?? [];
                foreach ($Habilidades as $pp){
                    $pp['Participante_id'] = $e->id;
                    $eHabilidades = new HabilidadesEntity($pp);
                    if(!$mHabilidades->insert($eHabilidades, false)){
                        return $this->returnWithError($mHabilidades->errors());
                    }
                }
                if($ru['termoResponsabilidade'] !== false) $m->deleteFile($e->termoResponsabilidade);
                $m->db->transComplete();
                return $this->returnSucess('Cadastrado com sucesso!');
            } else { 
                $m->deleteFiles($ru);
                return $this->returnWithError($m->errors());
            }
        }catch (\Exception $ex){ 
            if($ru['termoResponsabilidade'] != false){
                $m->deleteFile($ru['termoResponsabilidade']);
            }
            return $this->returnWithError($ex->getMessage());
        }
    }

    private function gerarSenha(int $tamanho = 12): string
    {
        $tamanho = max(6, $tamanho);
        $maiusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $minusculas = 'abcdefghijklmnopqrstuvwxyz';
        $numeros = '0123456789';
        $todos = $maiusculas . $minusculas . $numeros;

        $senhaChars = [
            $maiusculas[random_int(0, strlen($maiusculas) - 1)],
            $minusculas[random_int(0, strlen($minusculas) - 1)],
            $numeros[random_int(0, strlen($numeros) - 1)],
        ];

        for ($i = count($senhaChars); $i < $tamanho; $i++) {
            $senhaChars[] = $todos[random_int(0, strlen($todos) - 1)];
        }

        for ($i = count($senhaChars) - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            [$senhaChars[$i], $senhaChars[$j]] = [$senhaChars[$j], $senhaChars[$i]];
        }

        return implode('', $senhaChars);
    }
    
    public function pesquisar(){
        return view('Painel/Participante/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new ParticipanteModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vParticipante' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Participante/resposta',  $data);
    }
    
    public function listar() {
        $m = new ParticipanteModel();
        $data = [
            'vParticipante' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Participante/listar', $data);
    }

    public function excluir() {
        $m = new ParticipanteModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $m->db->transStart();
        if ($m->delete($e->id)) { 
            $m->deleteFile($e->termoResponsabilidade);
            $m->db->transComplete();
            return $this->returnSucess('Excluído com sucesso!');
        }
        return $this->returnWithError('Erro ao excluir registro.');
    }
    
    public function pesquisaModal() {
        $m = new ParticipanteModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vParticipante' => $m->findAll(100)
        ];
        return view('Painel/Participante/respostaModal', $data);
    }

    private function enviarEmailBoasVindas(ParticipanteEntity $participante): void
    {
        $destinatario = trim((string) ($participante->email ?? ''));
        if ($destinatario === '') {
            $destinatario = trim((string) ($participante->login ?? ''));
        }

        if (!filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException('E-mail cadastrado inválido para envio de boas-vindas.');
        }

        $emailService = \Config\Services::email();
        $emailService->clear(true);

        $emailConfig = config('Email');
        if (!empty($emailConfig->fromEmail)) {
            $emailService->setFrom($emailConfig->fromEmail, $emailConfig->fromName ?: null);
        }

        $emailService->setTo($destinatario);
        $emailService->setSubject('Bem-vindo ao InventaLab');
        $emailService->setMailType('html');
        $emailService->setMessage(view('Painel/Participante/boas_vindas_participante', [
            'participante' => $participante,
            'emailAcesso' => $destinatario,
            'recuperarSenhaUrl' => base_url('PainelParticipante/recuperarSenha'),
        ]));

        if (!$emailService->send()) {
            $detalhes = $emailService->printDebugger(['headers', 'subject', 'body']);
            log_message('error', 'Falha ao enviar e-mail de boas-vindas para o participante ' . ($participante->email ?? $participante->login ?? 'desconhecido') . ': ' . $detalhes);
            throw new \RuntimeException('Não foi possível enviar o e-mail de boas-vindas.');
        }
    }
}
