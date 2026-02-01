<?php

namespace App\Entities;

use \App\Entities\EntityBase;

class ParticipanteEntity extends EntityBase {
    
    const folder = 'participante_arquivos';

    const SUSPENSO_NAO = 0;
    const SUSPENSO_SIM = 1;
    
    /**
     * Tipo de acessos:
     *      'publico'  => acesso sem restrição de login e senha (Ex.: tela de login)
     *      'global'   => todos os usuários logados possuem acesso, 
     *                    não há controle de permissão (PainelParticipante::home)
     *      'participante'  => acesso para usuários logados que possuem permissão 
     *                    para a funcionalidade 
     *      'admin'    => acesso para usuários logados com permissão de usuário 
     *                    administrador "useradmin" (Participante::cadastrar)
     * 
     * @var array Lista de todas permissões do sistema
     */
    private const PERMISSOES = [
        'PainelParticipante' => [
            'login' => [
                'metodos' => ['PainelParticipante::login', 'PainelParticipante::doLogin', 'PainelParticipante::site', 'PainelParticipante::detalheEvento', 'PainelParticipante::enviarContatoSite'],
                'label' => 'Login',
                'descricao' => 'Realizar Login',
                'tipoAcesso' => 'publico'
            ],
            'cadastro' => [
                'metodos' => ['PainelParticipante::cadastrar', 'PainelParticipante::doCadastrar', 'PainelParticipante::confirmarCadastro'],
                'label' => 'Cadastro',
                'descricao' => 'Realizar cadastro de participante',
                'tipoAcesso' => 'publico'
            ],
            'consultacep' => [
                'metodos' => ['PainelParticipante::consultaCep'],
                'label' => 'Consulta CEP',
                'descricao' => 'Consultar endereço via CEP',
                'tipoAcesso' => 'publico'
            ],
            'recuperarsenha' => [
                'metodos' => ['PainelParticipante::recuperarSenha', 'PainelParticipante::doRecuperarSenha', 'PainelParticipante::alterarSenha', 'PainelParticipante::doAlterarSenha'],
                'label' => 'Recuperar Senha',
                'descricao' => 'Solicitar recuperação de senha',
                'tipoAcesso' => 'publico'
            ],
            'logout' => [
                'metodos' => ['PainelParticipante::logout'],
                'label' => 'Logout',
                'descricao' => 'Logout',
                'tipoAcesso' => 'publico'
            ],
            'home' => [
                'metodos' => ['PainelParticipante::home'],
                'label' => 'Inicial',
                'descricao' => 'Página inicial do painel',
                'tipoAcesso' => 'global'
            ],
            'evento' => [
                'metodos' => ['PainelParticipante::eventos','PainelParticipante::evento', 'PainelParticipante::inscricao', 'PainelParticipante::inscricoes'],
                'label' => 'Ver detalhe sobre evento e fazer inscrição',
                'descricao' => 'Fazer inscrição no evento',
                'tipoAcesso' => 'global'
            ],
            'reserva' => [
                'metodos' => ['PainelParticipante::reserva', 'PainelParticipante::listaReservaJson',
                            'PainelParticipante::descricaoOficina', 'PainelParticipante::cadastrarReserva',
                            'PainelParticipante::listarReservas'],
                'label' => 'Reserva',
                'descricao' => 'Gerencia as reservas',
                'tipoAcesso' => 'global'
            ],
            'perfil' => [
                'metodos' => ['PainelParticipante::alterarPerfil', 'PainelParticipante::doAlterarPerfil'],
                'label' => 'Alterar Perfil',
                'descricao' => 'Editar dados do perfil',
                'tipoAcesso' => 'global'
            ],
            'resource' => [
                'metodos' => ['PainelParticipante::resource'],
                'label' => 'Acesso a Imagens/Arquivos salvos no sistema',
                'descricao' => 'Acessar Arquivos de upload',
                'tipoAcesso' => 'global'
            ],
        ],
    ];

    protected $attributes = [
        'id' => '',
        'nome' => '',
        'telefone' => '',
        'email' => '',
        'cpf' => '',
        'logradouro' => '',
        'numero' => '',
        'bairro' => '',
        'cidade' => '',
        'codigoCidade' => '',
        'uf' => '',
        'cep' => '',
        'nomeResponsavel' => '',
        'dataNascimento' => '',
        'termoResponsabilidade' => '',
        'suspenso' => '',
        'observacoesGerais' => '',
        'senha' => '',
        'codigoApiSesc' => '',
    ];
    
    protected $casts = [
        'dataNascimento' => 'dateBR',
        'termoResponsabilidade' => 'filePath['.self::folder.']',
    ];
    
    public $op_suspenso = [
        self::SUSPENSO_NAO => 'Não',
        self::SUSPENSO_SIM => 'Sim',];   
    
    public $color_suspenso = [
        self::SUSPENSO_NAO => '#1a5fb4',
        self::SUSPENSO_SIM => '#c01c28',];
    
    public function getListHabilidades(){
        $m = new \App\Models\HabilidadesModel();
        return $m->where('Participante_id', $this->id)
                ->findAll();
    }
    
    public function setSenha($senha) {
        $this->attributes['senha'] = password_hash($senha, PASSWORD_DEFAULT);
        return $this;
    }

    public function setPermissoes(array $permissao) {
        $encrypter = \Config\Services::encrypter();
        $this->attributes['permissoes'] = $encrypter->encrypt(json_encode($permissao, true));
        return $this;
    }

    public function getIdade(): int
    {
        $dataNascimento = trim((string) ($this->dataNascimento ?? ''));
        if ($dataNascimento === '') {
            return 0;
        }

        $data = \DateTime::createFromFormat('d/m/Y', $dataNascimento);
        if ($data === false) {
            $data = \DateTime::createFromFormat('Y-m-d', $dataNascimento);
        }
        if ($data === false) {
            return 0;
        }

        $hoje = new \DateTime();
        return max(0, (int) $hoje->diff($data)->y);
    }
    
    /**
     * Retorna as permissões do usuário
     * 
     * @return array lista de permissoes
     */
    public function getPermissoes():array{
        return self::PERMISSOES;
    }
    
    /**
     * Verifica se o usuário tem permissão de acesso a um método de um controller
     * 
     * @see \App\Entities\ParticipanteEntity::PERMISSOES
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
            $cu = $controller;
            $mu = $metodo;
            if(isset(self::PERMISSOES[$cu][$mu]['metodos']) 
                    && is_array(self::PERMISSOES[$cu][$mu]['metodos']) 
                    && in_array("$controller::$metodo", self::PERMISSOES[$cu][$mu]['metodos'])){
                // verifica se permissão é de participante
                return self::PERMISSOES[$cu][$mu]['tipoAcesso'] == 'participante';
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
     * @see \App\Entities\ParticipanteEntity::PERMISSOES
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
     * alguma permissão {@see \App\Entities\ParticipanteEntity::PERMISSOES}
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
     * Retorna a lista de permissões de tipoAcesso "participante" que o usuário possui
     * caso seja Usuário Administrador, retorna todas as permissões do 
     * tipoAcesso == 'participante' 
     * 
     * @see \App\Entities\ParticipanteEntity::PERMISSOES
     * 
     * @return array Lista de permissoes
     */
    public function getDescricaoPermissoes():array{
        $pu = $this->getPermissoes();
        asort($pu);
        $pd = [];
        foreach($pu as $p){
            if(!str_contains($p, '.')) {
                continue;
            }
            [$c, $m] = explode('.', $p);
            if(isset(self::PERMISSOES[$c][$m])
                    && self::PERMISSOES[$c][$m]['tipoAcesso'] == 'participante'){
                $pd[$c][$m] = self::PERMISSOES[$c][$m];
            }
        }
        return $pd;
    }
    
    /**
     * Lista todas as permissões com o tipo de acesso solicitado
     * 
     * @see \App\Entities\ParticipanteEntity::PERMISSOES
     * 
     * @param string $tipoAcesso Tipo de acesso {@see \App\Entities\ParticipanteEntity::PERMISSOES}
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
     * Verifica se o usuário é o mesmo da sessão, ou seja se é o usuário logado
     * 
     * @return boolean Se for o usuário logado (Sessão) retorna true, se não false
     */
    public function isLogged(){
        $m = \App\Models\ParticipanteModel::getSessao();
        if($m != null && $m->id == $this->id){
            return true;
        }
        return false;
    }
}
