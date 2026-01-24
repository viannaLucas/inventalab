<?php

namespace App\Controllers;
use App\Models\UsuarioModel;
use App\Entities\UsuarioEntity;

class Painel extends BaseController
{
    
    public function home(){
        return view('Painel/home');
    }
    
    public function login(){
        return view('Painel/login');    
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
    
    public function resource() {
        $pastarPermitidas = [
            'exemplocampos_arquivos',
            'usuario_arquivos',
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
}
