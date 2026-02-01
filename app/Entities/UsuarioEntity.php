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
            // 'ArquivoOficina' => [
            //     'alterar' => [
            //         'metodos' => ['ArquivoOficina::alterar', 'ArquivoOficina::doAlterar', 'OficinaTematica::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar ArquivoOficina',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['ArquivoOficina::pesquisar', 'ArquivoOficina::doPesquisar', 'OficinaTematica::pesquisaModal'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar ArquivoOficina',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => ['ArquivoOficina::cadastrar', 'ArquivoOficina::doCadastrar', 'OficinaTematica::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar ArquivoOficina',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['ArquivoOficina::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar ArquivoOficina',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'excluir' => [
            //         'metodos' => ['ArquivoOficina::excluir'],
            //         'label' => 'Excluir',
            //         'descricao' => 'Permite Excluir ArquivoOficina',
            //         'tipoAcesso' => 'usuario'
            //     ],
                
            // ],
            // 'AtividadeLivre' => [
            //     'alterar' => [
            //         'metodos' => ['AtividadeLivre::alterar', 'AtividadeLivre::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar AtividadeLivre',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['AtividadeLivre::pesquisar', 'AtividadeLivre::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar AtividadeLivre',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => ['AtividadeLivre::cadastrar', 'AtividadeLivre::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar AtividadeLivre',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['AtividadeLivre::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar AtividadeLivre',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'excluir' => [
            //         'metodos' => ['AtividadeLivre::excluir'],
            //         'label' => 'Excluir',
            //         'descricao' => 'Permite Excluir AtividadeLivre',
            //         'tipoAcesso' => 'usuario'
            //     ],
                
            // ],
            // 'AtividadeLivreRecurso' => [
            //     'alterar' => [
            //         'metodos' => ['AtividadeLivreRecurso::alterar', 'AtividadeLivreRecurso::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar AtividadeLivreRecurso',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['AtividadeLivreRecurso::pesquisar', 'AtividadeLivreRecurso::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar AtividadeLivreRecurso',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => ['AtividadeLivreRecurso::cadastrar', 'AtividadeLivreRecurso::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar AtividadeLivreRecurso',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['AtividadeLivreRecurso::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar AtividadeLivreRecurso',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'excluir' => [
            //         'metodos' => ['AtividadeLivreRecurso::excluir'],
            //         'label' => 'Excluir',
            //         'descricao' => 'Permite Excluir AtividadeLivreRecurso',
            //         'tipoAcesso' => 'usuario'
            //     ],
                
            // ],
            // 'Cobranca' => [
            //     'alterar' => [
            //         'metodos' => ['Cobranca::alterar', 'Cobranca::doAlterar',  'Servico::pesquisaModal', 'Participante::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar Cobrança',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['Cobranca::pesquisar', 'Cobranca::doPesquisar', 'Servico::pesquisaModal', 'Participante::pesquisaModal'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar Cobrança',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => [
            //             'Cobranca::cadastrar', 'Cobranca::doCadastrar', 
            //             'Evento::cobranca', 'Servico::pesquisaModal', 'Participante::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar Cobrança',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['Cobranca::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar Cobrança',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'excluir' => [
            //         'metodos' => ['Cobranca::excluir'],
            //         'label' => 'Excluir',
            //         'descricao' => 'Permite Excluir Cobrança',
            //         'tipoAcesso' => 'usuario'
            //     ],
                
            // ],
            // 'CobrancaProduto' => [
            //     'alterar' => [
            //         'metodos' => ['CobrancaProduto::alterar', 'CobrancaProduto::doAlterar', 'Cobranca::pesquisaModal', 'Produto::pesquisaModal', 'CobrancaProduto::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar Cobrança Produto',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['CobrancaProduto::pesquisar', 'CobrancaProduto::doPesquisar', 'Cobranca::pesquisaModal', 'Produto::pesquisaModal', 'CobrancaProduto::pesquisaModal'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar Cobrança Produto',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => ['CobrancaProduto::cadastrar', 'CobrancaProduto::doCadastrar', 'Cobranca::pesquisaModal', 'Produto::pesquisaModal', 'CobrancaProduto::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar Cobrança Produto',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['CobrancaProduto::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar Cobrança Produto',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'excluir' => [
            //         'metodos' => ['CobrancaProduto::excluir'],
            //         'label' => 'Excluir',
            //         'descricao' => 'Permite Excluir Cobrança Produto',
            //         'tipoAcesso' => 'usuario'
            //     ],
                
            // ],
            // 'Configuracao' => [
            //     'alterar' => [
            //         'metodos' => ['Configuracao::alterar', 'Configuracao::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar Configuracao',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     // 'pesquisar' => [
            //     //     'metodos' => ['Configuracao::pesquisar', 'Configuracao::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            //     //     'label' => 'Pesquisar',
            //     //     'descricao' => 'Permite Pesquisar Configuracao',
            //     //     'tipoAcesso' => 'usuario'
            //     // ],
            //     // 'cadastrar' => [
            //     //     'metodos' => ['Configuracao::cadastrar', 'Configuracao::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            //     //     'label' => 'Cadastrar',
            //     //     'descricao' => 'Permite Cadastrar Configuracao',
            //     //     'tipoAcesso' => 'usuario'
            //     // ],
            //     // 'listar' => [
            //     //     'metodos' => ['Configuracao::listar'],
            //     //     'label' => 'Listar',
            //     //     'descricao' => 'Permite Listar Configuracao',
            //     //     'tipoAcesso' => 'usuario'
            //     // ],
            //     // 'excluir' => [
            //     //     'metodos' => ['Configuracao::excluir'],
            //     //     'label' => 'Excluir',
            //     //     'descricao' => 'Permite Excluir Configuracao',
            //     //     'tipoAcesso' => 'usuario'
            //     // ],
                
            // ],
            // 'ControlePresenca' => [
            //     'alterar' => [
            //         'metodos' => ['ControlePresenca::alterar', 'ControlePresenca::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar ControlePresenca',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['ControlePresenca::pesquisar', 'ControlePresenca::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar ControlePresenca',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => ['ControlePresenca::cadastrar', 'ControlePresenca::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar ControlePresenca',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['ControlePresenca::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar ControlePresenca',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'excluir' => [
            //         'metodos' => ['ControlePresenca::excluir'],
            //         'label' => 'Excluir',
            //         'descricao' => 'Permite Excluir ControlePresenca',
            //         'tipoAcesso' => 'usuario'
            //     ],
                
            // ],
            // // 'DatasExtraordinarias' => [
            // //     'alterar' => [
            // //         'metodos' => ['DatasExtraordinarias::alterar', 'DatasExtraordinarias::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal'],
            // //         'label' => 'Alterar',
            // //         'descricao' => 'Permite alterar DatasExtraordinarias',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'pesquisar' => [
            // //         'metodos' => ['DatasExtraordinarias::pesquisar', 'DatasExtraordinarias::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal'],
            // //         'label' => 'Pesquisar',
            // //         'descricao' => 'Permite Pesquisar DatasExtraordinarias',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'cadastrar' => [
            // //         'metodos' => ['DatasExtraordinarias::cadastrar', 'DatasExtraordinarias::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal'],
            // //         'label' => 'Cadastrar',
            // //         'descricao' => 'Permite Cadastrar DatasExtraordinarias',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'listar' => [
            // //         'metodos' => ['DatasExtraordinarias::listar'],
            // //         'label' => 'Listar',
            // //         'descricao' => 'Permite Listar DatasExtraordinarias',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'excluir' => [
            // //         'metodos' => ['DatasExtraordinarias::excluir'],
            // //         'label' => 'Excluir',
            // //         'descricao' => 'Permite Excluir DatasExtraordinarias',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
                
            // // ],
            // 'Evento' => [
            //     'alterar' => [
            //         'metodos' => ['Evento::alterar', 'Evento::doAlterar','Evento::verificarDatasReserva', 'Participante::pesquisaModal', 'Servico::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar Evento',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['Evento::pesquisar', 'Evento::doPesquisar',],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar Evento',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => ['Evento::cadastrar', 'Evento::doCadastrar', 'Evento::verificarDatasReserva', 'Servico::pesquisaModal','Participante::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar Evento',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['Evento::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar Evento',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'excluir' => [
            //         'metodos' => ['Evento::excluir'],
            //         'label' => 'Excluir',
            //         'descricao' => 'Permite Excluir Evento',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'controlePresenca' => [
            //         'metodos' => ['Evento::controlePresenca', 'Evento::definirPresenca', 'Evento::getPresentesEmControle', 'Evento::imprimirListaPresenca', 'Evento::imprimirEntregaMaterial', 'Evento::exportarListaParticipante'],
            //         'label' => 'Controle Presença',
            //         'descricao' => 'Permite definir presença dos participantes em um Controle de Presença de um Evento',
            //         'tipoAcesso' => 'usuario'
            //     ],
                
            // ],
            // // 'EventoReserva' => [
            // //     'alterar' => [
            // //         'metodos' => ['EventoReserva::alterar', 'EventoReserva::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal'],
            // //         'label' => 'Alterar',
            // //         'descricao' => 'Permite alterar EventoReserva',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'pesquisar' => [
            // //         'metodos' => ['EventoReserva::pesquisar', 'EventoReserva::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal'],
            // //         'label' => 'Pesquisar',
            // //         'descricao' => 'Permite Pesquisar EventoReserva',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'cadastrar' => [
            // //         'metodos' => ['EventoReserva::cadastrar', 'EventoReserva::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal'],
            // //         'label' => 'Cadastrar',
            // //         'descricao' => 'Permite Cadastrar EventoReserva',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'listar' => [
            // //         'metodos' => ['EventoReserva::listar'],
            // //         'label' => 'Listar',
            // //         'descricao' => 'Permite Listar EventoReserva',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'excluir' => [
            // //         'metodos' => ['EventoReserva::excluir'],
            // //         'label' => 'Excluir',
            // //         'descricao' => 'Permite Excluir EventoReserva',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
                
            // // ],
            // // 'Garantia' => [
            // //     'alterar' => [
            // //         'metodos' => ['Garantia::alterar', 'Garantia::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            // //         'label' => 'Alterar',
            // //         'descricao' => 'Permite alterar Garantia',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'pesquisar' => [
            // //         'metodos' => ['Garantia::pesquisar', 'Garantia::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            // //         'label' => 'Pesquisar',
            // //         'descricao' => 'Permite Pesquisar Garantia',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'cadastrar' => [
            // //         'metodos' => ['Garantia::cadastrar', 'Garantia::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            // //         'label' => 'Cadastrar',
            // //         'descricao' => 'Permite Cadastrar Garantia',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'listar' => [
            // //         'metodos' => ['Garantia::listar'],
            // //         'label' => 'Listar',
            // //         'descricao' => 'Permite Listar Garantia',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'excluir' => [
            // //         'metodos' => ['Garantia::excluir'],
            // //         'label' => 'Excluir',
            // //         'descricao' => 'Permite Excluir Garantia',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
                
            // // ],
            // // 'Habilidades' => [
            // //     'alterar' => [
            // //         'metodos' => ['Habilidades::alterar', 'Habilidades::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            // //         'label' => 'Alterar',
            // //         'descricao' => 'Permite alterar Habilidades',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'pesquisar' => [
            // //         'metodos' => ['Habilidades::pesquisar', 'Habilidades::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            // //         'label' => 'Pesquisar',
            // //         'descricao' => 'Permite Pesquisar Habilidades',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'cadastrar' => [
            // //         'metodos' => ['Habilidades::cadastrar', 'Habilidades::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            // //         'label' => 'Cadastrar',
            // //         'descricao' => 'Permite Cadastrar Habilidades',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'listar' => [
            // //         'metodos' => ['Habilidades::listar'],
            // //         'label' => 'Listar',
            // //         'descricao' => 'Permite Listar Habilidades',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'excluir' => [
            // //         'metodos' => ['Habilidades::excluir'],
            // //         'label' => 'Excluir',
            // //         'descricao' => 'Permite Excluir Habilidades',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
                
            // // ],
            // 'HorarioFuncionamento' => [
            //     'alterar' => [
            //         'metodos' => ['HorarioFuncionamento::alterar', 'HorarioFuncionamento::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar HorarioFuncionamento',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['HorarioFuncionamento::pesquisar', 'HorarioFuncionamento::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar HorarioFuncionamento',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => ['HorarioFuncionamento::cadastrar', 'HorarioFuncionamento::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar HorarioFuncionamento',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['HorarioFuncionamento::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar HorarioFuncionamento',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'excluir' => [
            //         'metodos' => ['HorarioFuncionamento::excluir'],
            //         'label' => 'Excluir',
            //         'descricao' => 'Permite Excluir HorarioFuncionamento',
            //         'tipoAcesso' => 'usuario'
            //     ],
                
            // ],
            // // 'ItemMovimentacaoEstoque' => [
            // //     'alterar' => [
            // //         'metodos' => ['ItemMovimentacaoEstoque::alterar', 'ItemMovimentacaoEstoque::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal'],
            // //         'label' => 'Alterar',
            // //         'descricao' => 'Permite alterar ItemMovimentacaoEstoque',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'pesquisar' => [
            // //         'metodos' => ['ItemMovimentacaoEstoque::pesquisar', 'ItemMovimentacaoEstoque::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal'],
            // //         'label' => 'Pesquisar',
            // //         'descricao' => 'Permite Pesquisar ItemMovimentacaoEstoque',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'cadastrar' => [
            // //         'metodos' => ['ItemMovimentacaoEstoque::cadastrar', 'ItemMovimentacaoEstoque::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal'],
            // //         'label' => 'Cadastrar',
            // //         'descricao' => 'Permite Cadastrar ItemMovimentacaoEstoque',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'listar' => [
            // //         'metodos' => ['ItemMovimentacaoEstoque::listar'],
            // //         'label' => 'Listar',
            // //         'descricao' => 'Permite Listar ItemMovimentacaoEstoque',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'excluir' => [
            // //         'metodos' => ['ItemMovimentacaoEstoque::excluir'],
            // //         'label' => 'Excluir',
            // //         'descricao' => 'Permite Excluir ItemMovimentacaoEstoque',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
                
            // // ],
            // 'Produto' => [
            //     'alterar' => [
            //         'metodos' => ['Produto::alterar', 'Produto::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar Produto',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['Produto::pesquisar', 'Produto::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar Produto',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => ['Produto::cadastrar', 'Produto::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar Produto',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['Produto::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar Produto',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'excluir' => [
            //         'metodos' => ['Produto::excluir'],
            //         'label' => 'Excluir',
            //         'descricao' => 'Permite Excluir Produto',
            //         'tipoAcesso' => 'usuario'
            //     ],
                
            // ],
            // // 'MaterialOficina' => [
            // //     'alterar' => [
            // //         'metodos' => ['MaterialOficina::alterar', 'MaterialOficina::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            // //         'label' => 'Alterar',
            // //         'descricao' => 'Permite alterar MaterialOficina',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'pesquisar' => [
            // //         'metodos' => ['MaterialOficina::pesquisar', 'MaterialOficina::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            // //         'label' => 'Pesquisar',
            // //         'descricao' => 'Permite Pesquisar MaterialOficina',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'cadastrar' => [
            // //         'metodos' => ['MaterialOficina::cadastrar', 'MaterialOficina::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            // //         'label' => 'Cadastrar',
            // //         'descricao' => 'Permite Cadastrar MaterialOficina',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'listar' => [
            // //         'metodos' => ['MaterialOficina::listar'],
            // //         'label' => 'Listar',
            // //         'descricao' => 'Permite Listar MaterialOficina',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'excluir' => [
            // //         'metodos' => ['MaterialOficina::excluir'],
            // //         'label' => 'Excluir',
            // //         'descricao' => 'Permite Excluir MaterialOficina',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
                
            // // ],
            // // 'MovimentacaoEstoque' => [
            // //     'alterar' => [
            // //         'metodos' => ['MovimentacaoEstoque::alterar', 'MovimentacaoEstoque::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            // //         'label' => 'Alterar',
            // //         'descricao' => 'Permite alterar MovimentacaoEstoque',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'pesquisar' => [
            // //         'metodos' => ['MovimentacaoEstoque::pesquisar', 'MovimentacaoEstoque::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            // //         'label' => 'Pesquisar',
            // //         'descricao' => 'Permite Pesquisar MovimentacaoEstoque',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'cadastrar' => [
            // //         'metodos' => ['MovimentacaoEstoque::cadastrar', 'MovimentacaoEstoque::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            // //         'label' => 'Cadastrar',
            // //         'descricao' => 'Permite Cadastrar MovimentacaoEstoque',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'listar' => [
            // //         'metodos' => ['MovimentacaoEstoque::listar'],
            // //         'label' => 'Listar',
            // //         'descricao' => 'Permite Listar MovimentacaoEstoque',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'excluir' => [
            // //         'metodos' => ['MovimentacaoEstoque::excluir'],
            // //         'label' => 'Excluir',
            // //         'descricao' => 'Permite Excluir MovimentacaoEstoque',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
                
            // // ],
            // 'OficinaTematica' => [
            //     'alterar' => [
            //         'metodos' => ['OficinaTematica::alterar', 'OficinaTematica::doAlterar', 'RecursoTrabalho::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar OficinaTematica',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['OficinaTematica::pesquisar', 'OficinaTematica::doPesquisar'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar OficinaTematica',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => ['OficinaTematica::cadastrar', 'OficinaTematica::doCadastrar', 'RecursoTrabalho::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar OficinaTematica',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['OficinaTematica::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar OficinaTematica',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'excluir' => [
            //         'metodos' => ['OficinaTematica::excluir'],
            //         'label' => 'Excluir',
            //         'descricao' => 'Permite Excluir OficinaTematica',
            //         'tipoAcesso' => 'usuario'
            //     ],
                
            // ],
            // // 'OficinaTematicaReserva' => [
            // //     'alterar' => [
            // //         'metodos' => ['OficinaTematicaReserva::alterar', 'OficinaTematicaReserva::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            // //         'label' => 'Alterar',
            // //         'descricao' => 'Permite alterar OficinaTematicaReserva',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'pesquisar' => [
            // //         'metodos' => ['OficinaTematicaReserva::pesquisar', 'OficinaTematicaReserva::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            // //         'label' => 'Pesquisar',
            // //         'descricao' => 'Permite Pesquisar OficinaTematicaReserva',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'cadastrar' => [
            // //         'metodos' => ['OficinaTematicaReserva::cadastrar', 'OficinaTematicaReserva::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            // //         'label' => 'Cadastrar',
            // //         'descricao' => 'Permite Cadastrar OficinaTematicaReserva',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'listar' => [
            // //         'metodos' => ['OficinaTematicaReserva::listar'],
            // //         'label' => 'Listar',
            // //         'descricao' => 'Permite Listar OficinaTematicaReserva',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'excluir' => [
            // //         'metodos' => ['OficinaTematicaReserva::excluir'],
            // //         'label' => 'Excluir',
            // //         'descricao' => 'Permite Excluir OficinaTematicaReserva',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
                
            // // ],
            // 'Participante' => [
            //     'alterar' => [
            //         'metodos' => ['Participante::alterar', 'Participante::doAlterar', 'RecursoTrabalho::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar Participante',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['Participante::pesquisar', 'Participante::doPesquisar', 'RecursoTrabalho::pesquisaModal'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar Participante',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => ['Participante::cadastrar', 'Participante::doCadastrar', 'RecursoTrabalho::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar Participante',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['Participante::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar Participante',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'excluir' => [
            //         'metodos' => ['Participante::excluir'],
            //         'label' => 'Excluir',
            //         'descricao' => 'Permite Excluir Participante',
            //         'tipoAcesso' => 'usuario'
            //     ],
                
            // ],
            // // 'ParticipanteEvento' => [
            // //     'alterar' => [
            // //         'metodos' => ['ParticipanteEvento::alterar', 'ParticipanteEvento::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal'],
            // //         'label' => 'Alterar',
            // //         'descricao' => 'Permite alterar ParticipanteEvento',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'pesquisar' => [
            // //         'metodos' => ['ParticipanteEvento::pesquisar', 'ParticipanteEvento::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal'],
            // //         'label' => 'Pesquisar',
            // //         'descricao' => 'Permite Pesquisar ParticipanteEvento',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'cadastrar' => [
            // //         'metodos' => ['ParticipanteEvento::cadastrar', 'ParticipanteEvento::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal'],
            // //         'label' => 'Cadastrar',
            // //         'descricao' => 'Permite Cadastrar ParticipanteEvento',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'listar' => [
            // //         'metodos' => ['ParticipanteEvento::listar'],
            // //         'label' => 'Listar',
            // //         'descricao' => 'Permite Listar ParticipanteEvento',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'excluir' => [
            // //         'metodos' => ['ParticipanteEvento::excluir'],
            // //         'label' => 'Excluir',
            // //         'descricao' => 'Permite Excluir ParticipanteEvento',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
                
            // // ],
            // 'PesquisaSatisfacao' => [
            //     // 'alterar' => [
            //     //     'metodos' => ['PesquisaSatisfacao::alterar', 'PesquisaSatisfacao::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal'],
            //     //     'label' => 'Alterar',
            //     //     'descricao' => 'Permite alterar PesquisaSatisfacao',
            //     //     'tipoAcesso' => 'usuario'
            //     // ],
            //     'visualizar' => [
            //         'metodos' => ['PesquisaSatisfacao::visualizar'],
            //         'label' => 'Visualizar Resposta',
            //         'descricao' => 'Permite visualizar resposta da  Pesquisa Satisfação',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['PesquisaSatisfacao::pesquisar', 'PesquisaSatisfacao::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar PesquisaSatisfacao',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     // 'cadastrar' => [
            //     //     'metodos' => ['PesquisaSatisfacao::cadastrar', 'PesquisaSatisfacao::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal'],
            //     //     'label' => 'Cadastrar',
            //     //     'descricao' => 'Permite Cadastrar PesquisaSatisfacao',
            //     //     'tipoAcesso' => 'usuario'
            //     // ],
            //     'listar' => [
            //         'metodos' => ['PesquisaSatisfacao::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar PesquisaSatisfacao',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     // 'excluir' => [
            //     //     'metodos' => ['PesquisaSatisfacao::excluir'],
            //     //     'label' => 'Excluir',
            //     //     'descricao' => 'Permite Excluir PesquisaSatisfacao',
            //     //     'tipoAcesso' => 'usuario'
            //     // ],
            //     'cronEnvio' => [
            //         'metodos' => ['PesquisaSatisfacao::cronEnvio', 'PesquisaSatisfacao::respostaPesquisa'],
            //         'label' => 'Cron',
            //         'descricao' => 'Cron',
            //         'tipoAcesso' => 'publico'
            //     ],
            //     'responderPesquisa' => [
            //         'metodos' => ['PesquisaSatisfacao::responderPesquisa', 'PesquisaSatisfacao::doResponderPesquisa'],
            //         'label' => 'Responder Pesquisa de Satisfação',
            //         'descricao' => 'Respnder Pesquisa de Satisfação',
            //         'tipoAcesso' => 'publico'
            //     ],
                
            // ],
            // // 'PresencaEvento' => [
            // //     'alterar' => [
            // //         'metodos' => ['PresencaEvento::alterar', 'PresencaEvento::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal'],
            // //         'label' => 'Alterar',
            // //         'descricao' => 'Permite alterar PresencaEvento',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'pesquisar' => [
            // //         'metodos' => ['PresencaEvento::pesquisar', 'PresencaEvento::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal'],
            // //         'label' => 'Pesquisar',
            // //         'descricao' => 'Permite Pesquisar PresencaEvento',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'cadastrar' => [
            // //         'metodos' => ['PresencaEvento::cadastrar', 'PresencaEvento::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal'],
            // //         'label' => 'Cadastrar',
            // //         'descricao' => 'Permite Cadastrar PresencaEvento',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'listar' => [
            // //         'metodos' => ['PresencaEvento::listar'],
            // //         'label' => 'Listar',
            // //         'descricao' => 'Permite Listar PresencaEvento',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'excluir' => [
            // //         'metodos' => ['PresencaEvento::excluir'],
            // //         'label' => 'Excluir',
            // //         'descricao' => 'Permite Excluir PresencaEvento',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
                
            // // ],
            // 'RecursoOficina' => [
            //     'alterar' => [
            //         'metodos' => ['RecursoOficina::alterar', 'RecursoOficina::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar RecursoOficina',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['RecursoOficina::pesquisar', 'RecursoOficina::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar RecursoOficina',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => ['RecursoOficina::cadastrar', 'RecursoOficina::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar RecursoOficina',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['RecursoOficina::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar RecursoOficina',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'excluir' => [
            //         'metodos' => ['RecursoOficina::excluir'],
            //         'label' => 'Excluir',
            //         'descricao' => 'Permite Excluir RecursoOficina',
            //         'tipoAcesso' => 'usuario'
            //     ],
                
            // ],
            // 'RecursoTrabalho' => [
            //     'alterar' => [
            //         'metodos' => ['RecursoTrabalho::alterar', 'RecursoTrabalho::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar RecursoTrabalho',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['RecursoTrabalho::pesquisar', 'RecursoTrabalho::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar RecursoTrabalho',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => ['RecursoTrabalho::cadastrar', 'RecursoTrabalho::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar RecursoTrabalho',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['RecursoTrabalho::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar RecursoTrabalho',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     // 'excluir' => [
            //     //     'metodos' => ['RecursoTrabalho::excluir'],
            //     //     'label' => 'Excluir',
            //     //     'descricao' => 'Permite Excluir RecursoTrabalho',
            //     //     'tipoAcesso' => 'usuario'
            //     // ],
                
            // ],
            // 'Reserva' => [
            //     'alterar' => [
            //         'metodos' => ['Reserva::alterar', 'Reserva::doAlterar', 'Reserva::definirEntrada', 'Reserva::definirSaida','OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'Participante::getDadosParticipante', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar Reserva',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['Reserva::pesquisar', 'Reserva::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar Reserva',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => ['Reserva::cadastrar', 'Reserva::doCadastrar', 'Reserva::listaReservaJson', 'OficinaTematica::descricao', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'Participante::getDadosParticipante', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar Reserva',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['Reserva::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar Reserva',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'excluir' => [
            //         'metodos' => ['Reserva::excluir'],
            //         'label' => 'Excluir',
            //         'descricao' => 'Permite Excluir Reserva',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'controleUso' => [
            //         'metodos' => ['Reserva::litarServicosReserva', 'Reserva::definirServicosReserva'],
            //         'label' => 'Controle de Acesso e Uso',
            //         'descricao' => 'Permite definir entrada/saída e serviços usados',
            //         'tipoAcesso' => 'usuario'
            //     ],
            // ],
            // // 'ReservaParticipante' => [
            // //     'alterar' => [
            // //         'metodos' => ['ReservaParticipante::alterar', 'ReservaParticipante::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Reserva::pesquisaModal'],
            // //         'label' => 'Alterar',
            // //         'descricao' => 'Permite alterar ReservaParticipante',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'pesquisar' => [
            // //         'metodos' => ['ReservaParticipante::pesquisar', 'ReservaParticipante::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Reserva::pesquisaModal'],
            // //         'label' => 'Pesquisar',
            // //         'descricao' => 'Permite Pesquisar ReservaParticipante',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'cadastrar' => [
            // //         'metodos' => ['ReservaParticipante::cadastrar', 'ReservaParticipante::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Reserva::pesquisaModal'],
            // //         'label' => 'Cadastrar',
            // //         'descricao' => 'Permite Cadastrar ReservaParticipante',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'listar' => [
            // //         'metodos' => ['ReservaParticipante::listar'],
            // //         'label' => 'Listar',
            // //         'descricao' => 'Permite Listar ReservaParticipante',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
            // //     'excluir' => [
            // //         'metodos' => ['ReservaParticipante::excluir'],
            // //         'label' => 'Excluir',
            // //         'descricao' => 'Permite Excluir ReservaParticipante',
            // //         'tipoAcesso' => 'usuario'
            // //     ],
                
            // // ],
            // 'Servico' => [
            //     'alterar' => [
            //         'metodos' => ['Servico::alterar', 'Servico::doAlterar', 'Servico::obterDadosServicoApiSesc', 'Servico::validarCodigoUnico', 'Produto::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar Servico',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'pesquisar' => [
            //         'metodos' => ['Servico::pesquisar', 'Servico::doPesquisar'],
            //         'label' => 'Pesquisar',
            //         'descricao' => 'Permite Pesquisar Servico',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'cadastrar' => [
            //         'metodos' => ['Servico::cadastrar', 'Servico::doCadastrar', 'Servico::obterDadosServicoApiSesc', 'Servico::validarCodigoUnico', 'Produto::pesquisaModal'],
            //         'label' => 'Cadastrar',
            //         'descricao' => 'Permite Cadastrar Servico',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'listar' => [
            //         'metodos' => ['Servico::listar'],
            //         'label' => 'Listar',
            //         'descricao' => 'Permite Listar Servico',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     // 'excluir' => [
            //     //     'metodos' => ['Servico::excluir'],
            //     //     'label' => 'Excluir',
            //     //     'descricao' => 'Permite Excluir Servico',
            //     //     'tipoAcesso' => 'usuario'
            //     // ],
                
            // ],
            // 'TemplateTermo' => [
            //     'alterar' => [
            //         'metodos' => ['TemplateTermo::alterar', 'TemplateTermo::doAlterar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Reserva::pesquisaModal'],
            //         'label' => 'Alterar',
            //         'descricao' => 'Permite alterar Template do Termo',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     // 'pesquisar' => [
            //     //     'metodos' => ['TemplateTermo::pesquisar', 'TemplateTermo::doPesquisar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Reserva::pesquisaModal'],
            //     //     'label' => 'Pesquisar',
            //     //     'descricao' => 'Permite Pesquisar TemplateTermo',
            //     //     'tipoAcesso' => 'usuario'
            //     // ],
            //     // 'cadastrar' => [
            //     //     'metodos' => ['TemplateTermo::cadastrar', 'TemplateTermo::doCadastrar', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'AtividadeLivre::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Evento::pesquisaModal', 'Reserva::pesquisaModal', 'Evento::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'Participante::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'MovimentacaoEstoque::pesquisaModal', 'Produto::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Reserva::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Evento::pesquisaModal', 'ParticipanteEvento::pesquisaModal', 'ControlePresenca::pesquisaModal', 'RecursoTrabalho::pesquisaModal', 'OficinaTematica::pesquisaModal', 'Participante::pesquisaModal', 'Reserva::pesquisaModal'],
            //     //     'label' => 'Cadastrar',
            //     //     'descricao' => 'Permite Cadastrar TemplateTermo',
            //     //     'tipoAcesso' => 'usuario'
            //     // ],
            //     // 'listar' => [
            //     //     'metodos' => ['TemplateTermo::listar'],
            //     //     'label' => 'Listar',
            //     //     'descricao' => 'Permite Listar TemplateTermo',
            //     //     'tipoAcesso' => 'usuario'
            //     // ],
            //     // 'excluir' => [
            //     //     'metodos' => ['TemplateTermo::excluir'],
            //     //     'label' => 'Excluir',
            //     //     'descricao' => 'Permite Excluir TemplateTermo',
            //     //     'tipoAcesso' => 'usuario'
            //     // ],
                
            // ],
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
                // 'testeemail' => [
                //     'metodos' => ['Painel::testeEmail'],
                //     'label' => 'Teste E-mail',
                //     'descricao' => 'Executar envio de e-mail para teste de configuração',
                //     'tipoAcesso' => 'admin'
                // ],
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
            // 'Relatorio' => [
            //     'pesquisaSatisfacao' => [
            //         'metodos' => ['PesquisaSatisfacao::relatorio'],
            //         'label' => 'Emitir relatório Pesquisa Satisfação',
            //         'descricao' => 'Emite relatório das Pesquisas de Satisfação',
            //         'tipoAcesso' => 'usuario'
            //     ],
            //     'reservas' => [
            //         'metodos' => ['Reserva::relatorio'],
            //         'label' => 'Emitir relatório Reservas',
            //         'descricao' => 'Emite relatório das Reservas',
            //         'tipoAcesso' => 'usuario'
            //     ],
            // ]
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
