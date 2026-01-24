<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Entities\UsuarioEntity;

class UsuarioModel extends BaseModel {
    
    private const SESSION_NAME = 'sessao_usuario_maker';
    
    protected $table = 'Usuario';
    protected $allowedFields = ['nome', 'login', 'foto', 'senha', 'permissoes', 'ativo'];
    protected $validationRules = [
	    'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
        'nome' => ['label'=> 'Nome', 'rules'=>'required|min_length[5]'],
        'login' => ['label'=> 'Login', 'rules'=>'required|min_length[5]|max_length[254]|valid_email|is_unique[Usuario.login,id,{id}]'],
        'senha' => ['label'=> 'Senha', 'rules'=>'required|senhaForte'],
        'ativo' => ['label'=> 'Ativo', 'rules'=>'permit_empty|in_list[0,1]'],
    ];
    protected $validationRulesFiles = [
        'foto' => ['label' => 'Foto', 'rules' => 'is_image[foto]|max_size[foto,10240]|ext_in[foto,jpg,jpeg,webp,png]'],
        'senha' => ['label'=> 'Senha', 'rules'=>'permit_empty|senhaForte'],
        'confirmaSenha' => ['label'=> 'Confirmação Senha', 'rules'=>'permit_empty|matches[senha]'],
    ];
    protected $validationMessages = [
        'senha' => [
            'senhaForte' => 'A senha deve ter no mínimo 6 caracteres, com ao menos 1 letra maiúscula, 1 letra minúscula e 1 número.',
        ],
    ];
    protected $returnType = \App\Entities\UsuarioEntity::class;
    
    protected $beforeUpdate = ['protecaoAtivo', 'protecaoCampoImutavel'];
    protected $beforeDelete   = ['protecaoExcluir'];
    
    protected function protecaoAtivo($data){
        if(in_array($this->getSessao()->id,$data['id']) && $data['data']['ativo'] != 1){
            throw new \Exception('Não é permitido desativar seu próprio usuário');
        }
        return $data;
    }
    
    protected function protecaoCampoImutavel($data){
        $usuarioEntity = (new UsuarioModel())->select()->where('id', $data['id'])->first();
        if(!($usuarioEntity instanceof UsuarioEntity)){
            throw new \Exception('Usuário a ser alterado não encontrado.');
        }
        $data['data']['login'] = $usuarioEntity->login;
        return $data;
    }
    
    protected function protecaoExcluir($data){
        if(in_array($this->getSessao()->id,$data['id'])){
            throw new \Exception('Não é permitido excluir seu próprio usuário');
        }
        return $data;
    }
    
    /**
     * Faz pesquisa com conjuntos de dados e intevalo de valores no caso de 
     * números e datas adicionando sufixo 'Start' e 'End' no nome do campo
     * 
     * Ex.: Campo Pedido->dataCadastro => $data['dataCadastroStart'] 
     * e $data['dataCadastroStart'] podem ser usados para definir um intervalo
     * 
     * @param array $data
     * @return $this
     */
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->getCompiledSelect(); //clear builder
        if(isset($data['nome'])) $this->like('nome', $data['nome']);
        if(isset($data['login'])) $this->like('descricao', $data['login']);
        if(isset($data['ativo'])){
            $func = is_array($data['ativo']) ? 'whereIn' : 'where';
            $this->$func('ativo', $data['ativo']);
        }
        return $this;
    }
    
    /**
     * Faz um busca ampla usando um termo de pesquisa
     * 
     * @param string $searchTerm
     * @return $this
     */
    public function buildFindModal(string $searchTerm){
        $this->builder()->getCompiledSelect(); //clear builder
        $this->orLike('nome', $searchTerm);
        $this->orLike('login', $searchTerm);
        
        return $this;
    }
    
    /**
     * Verifica se há usuário com o login e senha informados, caso exista salva 
     * na sessão
     * 
     * @param string $login Login do usuário
     * @param string $planPW senha do usuário em texto puro
     * @return bool Retorna true caso exista um usuário com o login e senha informado
     */
    public function login($login, $planPW):bool {
        $u = new UsuarioModel();
        if ($login != "" && $planPW != ''){
            $eu = $u->where('login', $login)->first();
            if($eu instanceof \App\Entities\UsuarioEntity 
                    && password_verify($planPW, $eu->senha)
                    && $eu->ativo == 1){
                $encrypter = \Config\Services::encrypter();
                session()->set(self::SESSION_NAME, $encrypter->encrypt($eu->id));
                return true;
            }
        }
        return false;
    }

    /**
     * Remove usuário da sessão
     * 
     * @return bool true se removido, caso contrário false
     */
    public static function logout():bool{
        $session = session();
        $session->removeTempdata('utemp');
        $session->remove(self::SESSION_NAME);
        return !$session->has(self::SESSION_NAME);
    }

    /**
     * Busca usuário da sessão, não use este retorno para alterar os dados do 
     * usuário devido o filtro de senha usado para não guardar esta informação
     * na sessão
     * 
     * @return UsuarioEntity|null Retorna o usuário da sessão, se não tiver retorna null
     */
    public static function getSessao():\App\Entities\UsuarioEntity|null {
        $return = null;
        if(session(self::SESSION_NAME) !== null){
            $utemp = session()->getTempdata('utemp');
            if($utemp == null){
                $encrypter = \Config\Services::encrypter();
                $id = $encrypter->decrypt(session(self::SESSION_NAME));
                $m = new UsuarioModel();
                $ue = $m->find($id);
                if($ue == null || $ue->ativo == 0) {
                    UsuarioModel::logout();
                    return null;
                }
                $vc = $ue->toArray();
                $vc['senha'] = '';
                $utemp = new UsuarioEntity($vc);
                session()->setTempdata('utemp',$utemp,1);
            }
            return $utemp;
        }        
        return $return;
    }
    

}
