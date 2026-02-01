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
            'Cobranca' => [
                'alterar' => [
                    'metodos' => ['Cobranca::alterar', 'Cobranca::doAlterar',  'Servico::pesquisaModal', 'Participante::pesquisaModal'],
                    'label' => 'Alterar',
                    'descricao' => 'Permite alterar Cobrança',
                    'tipoAcesso' => 'usuario'
                ],
                'pesquisar' => [
                    'metodos' => ['Cobranca::pesquisar', 'Cobranca::doPesquisar', 'Servico::pesquisaModal', 'Participante::pesquisaModal'],
                    'label' => 'Pesquisar',
                    'descricao' => 'Permite Pesquisar Cobrança',
                    'tipoAcesso' => 'usuario'
                ],
                'cadastrar' => [
                    'metodos' => [
                        'Cobranca::cadastrar', 'Cobranca::doCadastrar', 
                        'Evento::cobranca', 'Servico::pesquisaModal', 'Participante::pesquisaModal'],
                    'label' => 'Cadastrar',
                    'descricao' => 'Permite Cadastrar Cobrança',
                    'tipoAcesso' => 'usuario'
                ],
                'listar' => [
                    'metodos' => ['Cobranca::listar'],
                    'label' => 'Listar',
                    'descricao' => 'Permite Listar Cobrança',
                    'tipoAcesso' => 'usuario'
                ],
                'excluir' => [
                    'metodos' => ['Cobranca::excluir'],
                    'label' => 'Excluir',
                    'descricao' => 'Permite Excluir Cobrança',
                    'tipoAcesso' => 'usuario'
                ],
                
            ],
            'Configuracao' => [
                'alterar' => [
                    'metodos' => ['Configuracao::alterar', 'Configuracao::doAlterar'],
                    'label' => 'Alterar',
                    'descricao' => 'Permite alterar Configuracao',
                    'tipoAcesso' => 'usuario'
                ],
            ],
            'Evento' => [
                'alterar' => [
                    'metodos' => ['Evento::alterar', 'Evento::doAlterar','Evento::verificarDatasReserva', 'Participante::pesquisaModal', 'Servico::pesquisaModal'],
                    'label' => 'Alterar',
                    'descricao' => 'Permite alterar Evento',
                    'tipoAcesso' => 'usuario'
                ],
                'pesquisar' => [
                    'metodos' => ['Evento::pesquisar', 'Evento::doPesquisar',],
                    'label' => 'Pesquisar',
                    'descricao' => 'Permite Pesquisar Evento',
                    'tipoAcesso' => 'usuario'
                ],
                'cadastrar' => [
                    'metodos' => ['Evento::cadastrar', 'Evento::doCadastrar', 'Evento::verificarDatasReserva', 'Servico::pesquisaModal','Participante::pesquisaModal'],
                    'label' => 'Cadastrar',
                    'descricao' => 'Permite Cadastrar Evento',
                    'tipoAcesso' => 'usuario'
                ],
                'listar' => [
                    'metodos' => ['Evento::listar'],
                    'label' => 'Listar',
                    'descricao' => 'Permite Listar Evento',
                    'tipoAcesso' => 'usuario'
                ],
                'excluir' => [
                    'metodos' => ['Evento::excluir'],
                    'label' => 'Excluir',
                    'descricao' => 'Permite Excluir Evento',
                    'tipoAcesso' => 'usuario'
                ],
                'controlePresenca' => [
                    'metodos' => ['Evento::controlePresenca', 'Evento::definirPresenca', 'Evento::getPresentesEmControle', 'Evento::imprimirListaPresenca', 'Evento::imprimirEntregaMaterial', 'Evento::exportarListaParticipante'],
                    'label' => 'Controle Presença',
                    'descricao' => 'Permite definir presença dos participantes em um Controle de Presença de um Evento',
                    'tipoAcesso' => 'usuario'
                ],
            ],
            'HorarioFuncionamento' => [
                'alterar' => [
                    'metodos' => ['HorarioFuncionamento::alterar', 'HorarioFuncionamento::doAlterar'],
                    'label' => 'Alterar',
                    'descricao' => 'Permite alterar HorarioFuncionamento',
                    'tipoAcesso' => 'usuario'
                ],
                'cadastrar' => [
                    'metodos' => ['HorarioFuncionamento::cadastrar', 'HorarioFuncionamento::doCadastrar',  'RecursoTrabalho::pesquisaModal'],
                    'label' => 'Cadastrar',
                    'descricao' => 'Permite Cadastrar HorarioFuncionamento',
                    'tipoAcesso' => 'usuario'
                ],
                'definirHoraFuncionamento' => [
                    'metodos' => [
                        'HorarioFuncionamento::cadastrar', 'HorarioFuncionamento::doCadastrar',  'HorarioFuncionamento::alterar', 'HorarioFuncionamento::doAlterar','HorarioFuncionamento::excluir',
                        'DatasExtraordinarias::cadastrar', 'DatasExtraordinarias::doCadastrar',  'DatasExtraordinarias::alterar', 'DatasExtraordinarias::doAlterar','DatasExtraordinarias::excluir'
                        
                        ],
                    'label' => 'Configurar Hora Funcionamento',
                    'descricao' => 'Permite Configurar Horário Funcionamento',
                    'tipoAcesso' => 'usuario'
                ],
            ],
            'Produto' => [
                'alterar' => [
                    'metodos' => ['Produto::alterar', 'Produto::doAlterar'],
                    'label' => 'Alterar',
                    'descricao' => 'Permite alterar Produto',
                    'tipoAcesso' => 'usuario'
                ],
                'pesquisar' => [
                    'metodos' => ['Produto::pesquisar', 'Produto::doPesquisar'],
                    'label' => 'Pesquisar',
                    'descricao' => 'Permite Pesquisar Produto',
                    'tipoAcesso' => 'usuario'
                ],
                'cadastrar' => [
                    'metodos' => ['Produto::cadastrar', 'Produto::doCadastrar'],
                    'label' => 'Cadastrar',
                    'descricao' => 'Permite Cadastrar Produto',
                    'tipoAcesso' => 'usuario'
                ],
                'listar' => [
                    'metodos' => ['Produto::listar'],
                    'label' => 'Listar',
                    'descricao' => 'Permite Listar Produto',
                    'tipoAcesso' => 'usuario'
                ],
            ],
            'OficinaTematica' => [
                'alterar' => [
                    'metodos' => ['OficinaTematica::alterar', 'OficinaTematica::doAlterar', 'RecursoTrabalho::pesquisaModal'],
                    'label' => 'Alterar',
                    'descricao' => 'Permite alterar OficinaTematica',
                    'tipoAcesso' => 'usuario'
                ],
                'pesquisar' => [
                    'metodos' => ['OficinaTematica::pesquisar', 'OficinaTematica::doPesquisar'],
                    'label' => 'Pesquisar',
                    'descricao' => 'Permite Pesquisar OficinaTematica',
                    'tipoAcesso' => 'usuario'
                ],
                'cadastrar' => [
                    'metodos' => ['OficinaTematica::cadastrar', 'OficinaTematica::doCadastrar', 'RecursoTrabalho::pesquisaModal'],
                    'label' => 'Cadastrar',
                    'descricao' => 'Permite Cadastrar OficinaTematica',
                    'tipoAcesso' => 'usuario'
                ],
                'listar' => [
                    'metodos' => ['OficinaTematica::listar'],
                    'label' => 'Listar',
                    'descricao' => 'Permite Listar OficinaTematica',
                    'tipoAcesso' => 'usuario'
                ],
                'excluir' => [
                    'metodos' => ['OficinaTematica::excluir'],
                    'label' => 'Excluir',
                    'descricao' => 'Permite Excluir OficinaTematica',
                    'tipoAcesso' => 'usuario'
                ],
                
            ],
            'Participante' => [
                'alterar' => [
                    'metodos' => ['Participante::alterar', 'Participante::doAlterar', 'RecursoTrabalho::pesquisaModal'],
                    'label' => 'Alterar',
                    'descricao' => 'Permite alterar Participante',
                    'tipoAcesso' => 'usuario'
                ],
                'pesquisar' => [
                    'metodos' => ['Participante::pesquisar', 'Participante::doPesquisar', 'RecursoTrabalho::pesquisaModal'],
                    'label' => 'Pesquisar',
                    'descricao' => 'Permite Pesquisar Participante',
                    'tipoAcesso' => 'usuario'
                ],
                'cadastrar' => [
                    'metodos' => ['Participante::cadastrar', 'Participante::doCadastrar', 'RecursoTrabalho::pesquisaModal'],
                    'label' => 'Cadastrar',
                    'descricao' => 'Permite Cadastrar Participante',
                    'tipoAcesso' => 'usuario'
                ],
                'listar' => [
                    'metodos' => ['Participante::listar'],
                    'label' => 'Listar',
                    'descricao' => 'Permite Listar Participante',
                    'tipoAcesso' => 'usuario'
                ],
            ],
            'PesquisaSatisfacao' => [
                'visualizar' => [
                    'metodos' => ['PesquisaSatisfacao::visualizar'],
                    'label' => 'Visualizar Resposta',
                    'descricao' => 'Permite visualizar resposta da  Pesquisa Satisfação',
                    'tipoAcesso' => 'usuario'
                ],
                'pesquisar' => [
                    'metodos' => ['PesquisaSatisfacao::pesquisar', 'PesquisaSatisfacao::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal'],
                    'label' => 'Pesquisar',
                    'descricao' => 'Permite Pesquisar PesquisaSatisfacao',
                    'tipoAcesso' => 'usuario'
                ],
                'listar' => [
                    'metodos' => ['PesquisaSatisfacao::listar'],
                    'label' => 'Listar',
                    'descricao' => 'Permite Listar PesquisaSatisfacao',
                    'tipoAcesso' => 'usuario'
                ],
                'cronEnvio' => [
                    'metodos' => ['PesquisaSatisfacao::cronEnvio', 'PesquisaSatisfacao::respostaPesquisa'],
                    'label' => 'Cron',
                    'descricao' => 'Cron',
                    'tipoAcesso' => 'publico'
                ],
                'responderPesquisa' => [
                    'metodos' => ['PesquisaSatisfacao::responderPesquisa', 'PesquisaSatisfacao::doResponderPesquisa'],
                    'label' => 'Responder Pesquisa de Satisfação',
                    'descricao' => 'Respnder Pesquisa de Satisfação',
                    'tipoAcesso' => 'publico'
                ],
                
            ],
            'RecursoTrabalho' => [
                'alterar' => [
                    'metodos' => [
                        'RecursoTrabalho::alterar', 'RecursoTrabalho::doAlterar',
                        'Garantia::alterar', 'Garantia::doAlterar','Garantia::cadastrar', 'Garantia::doCadastrar', 'Garantia::excluir',
                    ],
                    'label' => 'Alterar',
                    'descricao' => 'Permite alterar RecursoTrabalho',
                    'tipoAcesso' => 'usuario'
                ],
                'pesquisar' => [
                    'metodos' => ['RecursoTrabalho::pesquisar', 'RecursoTrabalho::doPesquisar'],
                    'label' => 'Pesquisar',
                    'descricao' => 'Permite Pesquisar RecursoTrabalho',
                    'tipoAcesso' => 'usuario'
                ],
                'cadastrar' => [
                    'metodos' => ['RecursoTrabalho::cadastrar', 'RecursoTrabalho::doCadastrar'],
                    'label' => 'Cadastrar',
                    'descricao' => 'Permite Cadastrar RecursoTrabalho',
                    'tipoAcesso' => 'usuario'
                ],
                'listar' => [
                    'metodos' => ['RecursoTrabalho::listar'],
                    'label' => 'Listar',
                    'descricao' => 'Permite Listar RecursoTrabalho',
                    'tipoAcesso' => 'usuario'
                ],
                'garantia' => [
                    'metodos' => ['Garantia::alterar', 'Garantia::doAlterar','Garantia::cadastrar', 'Garantia::doCadastrar', 'Garantia::excluir'],
                    'label' => 'Garantias',
                    'descricao' => 'Permite Gerenciar Garantias',
                    'tipoAcesso' => 'usuario'
                ],
            ],
            'Reserva' => [
                'alterar' => [
                    'metodos' => ['Reserva::alterar', 'Reserva::doAlterar', 'Reserva::definirEntrada', 'Reserva::definirSaida','Participante::pesquisaModal', 'OficinaTematica::pesquisaModal'],
                    'label' => 'Alterar',
                    'descricao' => 'Permite alterar Reserva',
                    'tipoAcesso' => 'usuario'
                ],
                'pesquisar' => [
                    'metodos' => ['Reserva::pesquisar', 'Reserva::doPesquisar', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'OficinaTematica::pesquisaModal'],
                    'label' => 'Pesquisar',
                    'descricao' => 'Permite Pesquisar Reserva',
                    'tipoAcesso' => 'usuario'
                ],
                'cadastrar' => [
                    'metodos' => ['Reserva::cadastrar', 'Reserva::doCadastrar', 'Reserva::listaReservaJson', 'OficinaTematica::descricao', 'Participante::pesquisaModal', 'OficinaTematica::pesquisaModal'],
                    'label' => 'Cadastrar',
                    'descricao' => 'Permite Cadastrar Reserva',
                    'tipoAcesso' => 'usuario'
                ],
                'listar' => [
                    'metodos' => ['Reserva::listar'],
                    'label' => 'Listar',
                    'descricao' => 'Permite Listar Reserva',
                    'tipoAcesso' => 'usuario'
                ],
                'controleUso' => [
                    'metodos' => ['Reserva::litarServicosReserva', 'Reserva::definirServicosReserva'],
                    'label' => 'Controle de Acesso e Uso',
                    'descricao' => 'Permite definir entrada/saída e serviços usados',
                    'tipoAcesso' => 'usuario'
                ],
            ],
            'Servico' => [
                'alterar' => [
                    'metodos' => ['Servico::alterar', 'Servico::doAlterar', 'Servico::obterDadosServicoApiSesc', 'Servico::validarCodigoUnico', 'Produto::pesquisaModal'],
                    'label' => 'Alterar',
                    'descricao' => 'Permite alterar Servico',
                    'tipoAcesso' => 'usuario'
                ],
                'pesquisar' => [
                    'metodos' => ['Servico::pesquisar', 'Servico::doPesquisar'],
                    'label' => 'Pesquisar',
                    'descricao' => 'Permite Pesquisar Servico',
                    'tipoAcesso' => 'usuario'
                ],
                'cadastrar' => [
                    'metodos' => ['Servico::cadastrar', 'Servico::doCadastrar', 'Servico::obterDadosServicoApiSesc', 'Servico::validarCodigoUnico', 'Produto::pesquisaModal'],
                    'label' => 'Cadastrar',
                    'descricao' => 'Permite Cadastrar Servico',
                    'tipoAcesso' => 'usuario'
                ],
                'listar' => [
                    'metodos' => ['Servico::listar'],
                    'label' => 'Listar',
                    'descricao' => 'Permite Listar Servico',
                    'tipoAcesso' => 'usuario'
                ],
            ],
            'TemplateTermo' => [
                'alterar' => [
                    'metodos' => ['TemplateTermo::alterar', 'TemplateTermo::doAlterar'],
                    'label' => 'Alterar',
                    'descricao' => 'Permite alterar Template do Termo',
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
                'recuperarsenha' => [
                    'metodos' => ['Painel::recuperarSenha', 'Painel::doRecuperarSenha', 'Painel::alterarSenha', 'Painel::doAlterarSenha'],
                    'label' => 'Recuperar Senha',
                    'descricao' => 'Solicitar recuperação de senha',
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
                'publicResource' => [
                    'metodos' => ['Painel::publicResource'],
                    'label' => 'Acesso a Imagens/Arquivos salvos no sistema',
                    'descricao' => 'Acessar Arquivos de upload',
                    'tipoAcesso' => 'publico'
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
            ],
            'Relatorio' => [
                'pesquisaSatisfacao' => [
                    'metodos' => ['PesquisaSatisfacao::relatorio', 'PesquisaSatisfacao::relatorioDados'],
                    'label' => 'Emitir relatório Pesquisa Satisfação',
                    'descricao' => 'Emite relatório das Pesquisas de Satisfação',
                    'tipoAcesso' => 'usuario'
                ],
                'reservas' => [
                    'metodos' => ['Reserva::relatorio', 'Reserva::relatorioDados'],
                    'label' => 'Emitir relatório Reservas',
                    'descricao' => 'Emite relatório das Reservas',
                    'tipoAcesso' => 'usuario'
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
        1 => '#4b66ffff'
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
