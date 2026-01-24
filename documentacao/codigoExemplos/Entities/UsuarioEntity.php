<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class UsuarioEntity extends EntityBase {

    const folder = 'usuario_arquivos';
    
    /**
     * Tipo de acessos:
     *      'publico'  => acesso sem restrição de login e senha (Ex.: tela de login)
     *      'global'   => todos os usuários logados possuem acesso, 
     *                    não há controle de permissão (Painel::home)
     *      'usuario'  => acesso para usuários logados que possuem permissão 
     *                    para a funcionalidade 
     *      'admin'    => acesso para usuários logados com permissão de usuário 
     *                    administrador "useradmin" (Usuario::cadastrar)
     * 
     * @var array Lista de todas permissões do sistema
     */
    private const PERMISSOES = [
            'ExemploCampos' => [
                'alterar' => [
                    'metodos' => ['ExemploCampos::alterar', 'ExemploCampos::doAlterar', 'TabelaFK::pesquisaModal'],
                    'label' => 'Alterar',
                    'descricao' => 'Permite alterar ExemploCampos',
                    'tipoAcesso' => 'usuario'
                ],
                'pesquisar' => [
                    'metodos' => ['ExemploCampos::pesquisar', 'ExemploCampos::doPesquisar', 'TabelaFK::pesquisaModal'],
                    'label' => 'Pesquisar',
                    'descricao' => 'Permite Pesquisar ExemploCampos',
                    'tipoAcesso' => 'usuario'
                ],
                'cadastrar' => [
                    'metodos' => ['ExemploCampos::cadastrar', 'ExemploCampos::doCadastrar', 'TabelaFK::pesquisaModal'],
                    'label' => 'Cadastrar',
                    'descricao' => 'Permite Cadastrar ExemploCampos',
                    'tipoAcesso' => 'usuario'
                ],
                'listar' => [
                    'metodos' => ['ExemploCampos::listar'],
                    'label' => 'Listar',
                    'descricao' => 'Permite Listar ExemploCampos',
                    'tipoAcesso' => 'usuario'
                ],
                'excluir' => [
                    'metodos' => ['ExemploCampos::excluir'],
                    'label' => 'Excluir',
                    'descricao' => 'Permite Excluir ExemploCampos',
                    'tipoAcesso' => 'usuario'
                ],
                
            ],
            'TabelaFK' => [
                'alterar' => [
                    'metodos' => ['TabelaFK::alterar', 'TabelaFK::doAlterar', 'TabelaFK::pesquisaModal'],
                    'label' => 'Alterar',
                    'descricao' => 'Permite alterar TabelaFK',
                    'tipoAcesso' => 'usuario'
                ],
                'pesquisar' => [
                    'metodos' => ['TabelaFK::pesquisar', 'TabelaFK::doPesquisar', 'TabelaFK::pesquisaModal'],
                    'label' => 'Pesquisar',
                    'descricao' => 'Permite Pesquisar TabelaFK',
                    'tipoAcesso' => 'usuario'
                ],
                'cadastrar' => [
                    'metodos' => ['TabelaFK::cadastrar', 'TabelaFK::doCadastrar', 'TabelaFK::pesquisaModal'],
                    'label' => 'Cadastrar',
                    'descricao' => 'Permite Cadastrar TabelaFK',
                    'tipoAcesso' => 'usuario'
                ],
                'listar' => [
                    'metodos' => ['TabelaFK::listar'],
                    'label' => 'Listar',
                    'descricao' => 'Permite Listar TabelaFK',
                    'tipoAcesso' => 'usuario'
                ],
                'excluir' => [
                    'metodos' => ['TabelaFK::excluir'],
                    'label' => 'Excluir',
                    'descricao' => 'Permite Excluir TabelaFK',
                    'tipoAcesso' => 'usuario'
                ],
                
            ],
            'Painel' => [
                'login' => [
                    'metodos' => ['Painel::login', 'Painel::doLogin'],
                    'label' => 'Login',
                    'descricao' => 'Realizar Login',
                    'tipoAcesso' => 'publico'
                ],
                'logout' => [
                    'metodos' => ['Painel::logout'],
                    'label' => 'Logout',
                    'descricao' => 'Logout',
                    'tipoAcesso' => 'publico'
                ],
                'home' => [
                    'metodos' => ['Painel::home'],
                    'label' => 'Inicial',
                    'descricao' => 'Página inicial do painel',
                    'tipoAcesso' => 'global'
                ],
                'perfil' => [
                    'metodos' => ['Painel::alterarPerfil', 'Painel::doAlterarPerfil'],
                    'label' => 'Alterar Perfil',
                    'descricao' => 'Editar dados do perfil',
                    'tipoAcesso' => 'global'
                ],
                'resource' => [
                    'metodos' => ['Painel::resource'],
                    'label' => 'Acesso a Imagens/Arquivos salvos no sistema',
                    'descricao' => 'Acessar Arquivos de upload',
                    'tipoAcesso' => 'global'
                ],
            ],
            'Usuario' => [
                'cadastrar' => [
                    'metodos' => ['Usuario::cadastrar', 'Usuario::doCadastrar'],
                    'label' => 'Logout',
                    'descricao' => 'Adicionar novo usuário',
                    'tipoAcesso' => 'admin'
                ],
                'alterar' => [
                    'metodos' => ['Usuario::alterar', 'Usuario::doAlterar'],
                    'label' => 'Logout',
                    'descricao' => 'Logout',
                    'tipoAcesso' => 'admin'
                ],
                'pesquisar' => [
                    'metodos' => ['Usuario::pesquisar', 'Usuario::doPesquisar'],
                    'label' => 'Pesquisar',
                    'descricao' => 'Pesquisar Usuários',
                    'tipoAcesso' => 'admin'
                ],
                'listar' => [
                    'metodos' => ['Usuario::listar'],
                    'label' => 'Listar',
                    'descricao' => 'Listar Usuários',
                    'tipoAcesso' => 'admin'
                ],
                'excluir' => [
                    'metodos' => ['Usuario::excluir'],
                    'label' => 'Excluir',
                    'descricao' => 'Excluir Usuários',
                    'tipoAcesso' => 'admin'
                ],
            ]
        ];
    
    protected $attributes = [
        'id' => '',
        'nome' => '',
        'login' => '',
        'foto' => '',
        'senha' => '',
        'permissoes' => ''
    ];
    
    protected $casts = [
        'foto' => 'filePath['.self::folder.']',
    ];
    
    protected $op_ativo = [
        0 => 'Inativo',
        1 => 'Ativo'
    ];
    
    protected $color_ativo = [
        0 => 'red',
        1 => 'blue'
    ];
    
    public function setSenha($senha) {
        $this->attributes['senha'] = password_hash($senha, PASSWORD_DEFAULT);
        return $this;
    }

    public function setPermissoes(array $permissao) {
        $encrypter = \Config\Services::encrypter();
        $this->attributes['permissoes'] = $encrypter->encrypt(json_encode($permissao, true));
        return $this;
    }
    
    /**
     * Retorna as permissões do usuário
     * 
     * @return array lista de permissoes
     */
    public function getPermissoes():array{
        if($this->attributes['permissoes'] == ''){
            return [];
        }
        $encrypter = \Config\Services::encrypter();
        return json_decode($encrypter->decrypt($this->attributes['permissoes']),true);
    }
    
    /**
     * Verifica se o usuário tem permissão de acesso a um método de um controller
     * 
     * @see \App\Entities\UsuarioEntity::PERMISSOES
     * 
     * @param string $controller Controller que está sendo excecutado
     * @param string $metodo Método do Controller que está sendo executado
     * @return bool retorna true quando possue permissão e false quando não
     */
    public function verificarPermissao(string $controller,string $metodo): bool {
        if($controller == '' || $metodo == '' || !$this->existePermissaoVinculada($controller, $metodo)){
            return false;
        }
        //verifica se o método é publico, se é useradmin ou se acesso é global
        if($this->isMetodoPublico($controller, $metodo) 
                || ($this->isLogged() && $this->isMetodoGlobal($controller, $metodo))
                || in_array('useradmin', $this->getPermissoes())){
            return true;
        }
        // verifica se tem permissao
        foreach($this->getPermissoes() as $pu){
            [$cu, $mu] = explode('.', $pu);
            if(isset(self::PERMISSOES[$cu][$mu]['metodos']) 
                    && is_array(self::PERMISSOES[$cu][$mu]['metodos']) 
                    && in_array("$controller::$metodo", self::PERMISSOES[$cu][$mu]['metodos'])){
                // verifica se permissão é de usuario
                return self::PERMISSOES[$cu][$mu]['tipoAcesso'] == 'usuario';
            }
        }
        return false;
    }
    
    /**
     * Verifica se há alguma permissão publica que contém o controller::método
     * 
     * @param string $controller controller que está sendo acessado
     * @param string $metodo método do controller que está sendo acessado
     * @return bool
     */
    private function isMetodoPublico(string $controller,string $metodo): bool {
        return $this->isTipoAcesso($controller, $metodo, 'publico');
    }
    
    /**
     * Verifica se há alguma permissão global que contém o controller::método
     * 
     * @param string $controller controller que está sendo acessado
     * @param string $metodo método do controller que está sendo acessado
     * @return bool
     */
    private function isMetodoGlobal(string $controller,string $metodo): bool {
        return $this->isTipoAcesso($controller, $metodo, 'global');
    }
    
    /**
     * Verifica se há alguma permissão com o tipo de acesso informado que
     * contenha o controlador::método informado 
     * 
     * @see \App\Entities\UsuarioEntity::PERMISSOES
     * 
     * @param string $controller Controller que está sendo acessado
     * @param string $metodo Método que está sendo acessado
     * @param type $tipoAcesso tipo de acesso que está sendo buscado
     * @return bool Se possui permissao com o tipo de acesso definido retorna true, se não false
     */
    private function isTipoAcesso(string $controller,string $metodo, $tipoAcesso): bool {
        foreach(self::PERMISSOES as $pg){
            foreach ($pg as $p) {
                if($p['tipoAcesso'] == $tipoAcesso && in_array("$controller::$metodo", $p['metodos'])){
                    return true;
                }
            }
        }
        return false;
    }
    
    /**
     * Busca se o Controller::metodo que está sendo acessado está contido em 
     * alguma permissão {@see \App\Entities\UsuarioEntity::PERMISSOES}
     * 
     * @param string $controller Controller que está sendo acessado
     * @param string $metodo Método que está sendo acessado
     * @return bool Se possui alguma permissao vinculada retorna true, se não false.
     */
    private function existePermissaoVinculada(string $controller,string $metodo): bool {
        foreach(self::PERMISSOES as $pg){
            foreach ($pg as $p) {
                if(in_array("$controller::$metodo", $p['metodos'])){
                    return true;
                }
            }
        }
        return false;
    }
    
    /**
     * Retorna a lista de permissões de tipoAcesso "usuario" que o usuário possui
     * caso seja Usuário Administrador, retorna todas as permissões do 
     * tipoAcesso == 'usuario' 
     * 
     * @see \App\Entities\UsuarioEntity::PERMISSOES
     * 
     * @return array Lista de permissoes
     */
    public function getDescricaoPermissoes():array{
        if($this->isUsuarioAdministrador()){
            return $this->getPermissoesTipoAcesso('usuario');
        }
        $pu = $this->getPermissoes();
        asort($pu);
        $pd = [];
        foreach($pu as $p){
            if(!str_contains($p, '.')) {
                continue;
            }
            [$c, $m] = explode('.', $p);
            if(isset(self::PERMISSOES[$c][$m])
                    && self::PERMISSOES[$c][$m]['tipoAcesso'] == 'usuario'){
                $pd[$c][$m] = self::PERMISSOES[$c][$m];
            }
        }
        return $pd;
    }
    
    /**
     * Lista todas as permissões com o tipo de acesso solicitado
     * 
     * @see \App\Entities\UsuarioEntity::PERMISSOES
     * 
     * @param string $tipoAcesso Tipo de acesso {@see \App\Entities\UsuarioEntity::PERMISSOES}
     * @return array Lista de permissoes
     */
    private function getPermissoesTipoAcesso(string $tipoAcesso): array {
        $pr = [];
        foreach(self::PERMISSOES as $c => $pg){
            foreach ($pg as $m => $p) {
                if($p['tipoAcesso'] == $tipoAcesso){
                    $pr[$c][$m] = $p;
                }
            }
        }
        return $pr;
    }
    
    /**
     * Verifica se o usuário tem permissões de administrador
     * 
     * @return bool se for Usuario administrador retorna true, se não false
     */
    public function isUsuarioAdministrador():bool{
        return in_array('useradmin', $this->getPermissoes());
    }
    
    /**
     * Verifica se o usuário é o mesmo da sessão, ou seja se é o usuário logado
     * 
     * @return boolean Se for o usuário logado (Sessão) retorna true, se não false
     */
    public function isLogged(){
        $m = \App\Models\UsuarioModel::getSessao();
        if($m != null && $m->id == $this->id){
            return true;
        }
        return false;
    }
}
