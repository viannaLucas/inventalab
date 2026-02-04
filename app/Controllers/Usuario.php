<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\UsuarioEntity;
use App\Models\UsuarioModel;

class Usuario extends BaseController {
    
    public function cadastrar() {
        $data['permissoes'] = UsuarioModel::getSessao()?->getDescricaoPermissoes();
        return view('Painel/Usuario/cadastrar', $data);
    }

    public function doCadastrar() {
        $m = new UsuarioModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        
        $permissoes = is_array($this->request->getPost('permissoes')) ? $this->request->getPost('permissoes') : [];
        $eu = new UsuarioEntity($this->request->getPost());
        
        //adiciona apenas permissões que o usuário atual possue
        if(!UsuarioModel::getSessao()->isUsuarioAdministrador()){
            $eu->setPermissoes(array_intersect($permissoes, UsuarioModel::getSessao()->getPermissoes()));
        }
        
        $eu->foto = $this->getRandomName('foto');
        $eu->senha = $this->gerarSenha();
        $m->db->transStart();
        try {
            if ($m->insert($eu, false)) {
                $m->uploadImage($this->request->getFile('foto'), $eu->foto, UsuarioEntity::folder);
                $m->db->transComplete();
                $this->enviarEmailBoasVindas($eu);
                return $this->returnSucess('Cadastrado com sucesso! Enviamos um e-mail de boas-vindas com as instruções de acesso.');
            } else {
                return $this->returnWithError($m->errors());
            }
        } catch (\Exception $ex) {
            return $this->returnWithError($ex->getMessage());
        }
    }
    
    public function alterar(){
        $m = new UsuarioModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $data = [
            'usuario' => $e,
            'permissoes' => UsuarioModel::getSessao()?->getDescricaoPermissoes(),
        ];
        return view('Painel/Usuario/alterar', $data);
    }
    
    public function doAlterar() {
        $m = new UsuarioModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        
        $foto = $e->foto;
        $post = $this->request->getPost();
        if(isset($post['senha'])){
            unset($post['senha']);
        }
        if(isset($post['login'])){
            unset($post['login']);
        }
        if(!isset($post['ativo'])){
            $post['ativo'] = 0;
        }
        $e->fill($post);
        try{
            $ru['foto'] = $m->uploadImage($this->request->getFile('foto'), null, UsuarioEntity::folder);
            $e->foto = $ru['foto'] !== false ? $ru['foto'] : $foto;
            $m->db->transStart();
            if ($m->update($e->id, $e)) {
                if($ru['foto'] !== false) $m->deleteFile($foto);
                $m->db->transComplete();
                return $this->returnSucess('Alterado com sucesso!');
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
    
    public function listar(){
        $m = new UsuarioModel();
        $data = [
            'vUsuario' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Usuario/listar', $data);
    }
    
    public function excluir() {
        $m = new UsuarioModel();
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
    
    public function pesquisar(){
        return view('Painel/Usuario/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new UsuarioModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vUsuario' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Usuario/resposta',  $data);
    }

    private function gerarSenha(int $tamanho = 16): string
    {
        $tamanho = max(6, $tamanho);
        $maiusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $minusculas = 'abcdefghijklmnopqrstuvwxyz';
        $numeros = '0123456789';
        $simbolos = '!@#$%^&*()-_=+[]{}<>?/|';
        $todos = $maiusculas . $minusculas . $numeros . $simbolos;

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

    private function enviarEmailBoasVindas(UsuarioEntity $usuario): void
    {
        if (!filter_var($usuario->login, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException('E-mail cadastrado inválido para envio de boas-vindas.');
        }

        $emailService = \Config\Services::email();
        $emailService->clear(true);

        $emailConfig = config('Email');
        if (!empty($emailConfig->fromEmail)) {
            $emailService->setFrom($emailConfig->fromEmail, $emailConfig->fromName ?: null);
        }

        $emailService->setTo($usuario->login);
        $emailService->setSubject('Bem-vindo ao InventaLab');
        $emailService->setMailType('html');
        $emailService->setMessage(view('Painel/boas_vindas_usuario', [
            'usuario' => $usuario,
            'recuperarSenhaUrl' => base_url('Painel/recuperarSenha'),
        ]));

        if (!$emailService->send()) {
            $detalhes = $emailService->printDebugger(['headers', 'subject', 'body']);
            log_message('error', 'Falha ao enviar e-mail de boas-vindas para o usuário ' . ($usuario->login ?? 'desconhecido') . ': ' . $detalhes);
            // throw new \RuntimeException('Não foi possível enviar o e-mail de boas-vindas.');
        }
    }
}
