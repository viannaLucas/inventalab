<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="<?php echo base_url('Painel/home'); ?>"><img src="<?php echo base_url('assets/img/brand/logo.png'); ?>" class="main-logo" alt="logo"></a>
        <a class="desktop-logo logo-dark active" href="<?php echo base_url('Painel/home'); ?>"><img src="<?php echo base_url('assets/img/brand/logo-white.png'); ?>" class="main-logo dark-theme" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href="<?php echo base_url('Painel/home'); ?>"><img src="<?php echo base_url('assets/img/brand/favicon.png'); ?>" class="logo-icon" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-dark active" href="<?php echo base_url('Painel/home'); ?>"><img src="<?php echo base_url('assets/img/brand/favicon-white.png'); ?>" class="logo-icon dark-theme" alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <ul class="side-menu pt-3" id="menuPermissoes">
            <li class="slide">
                <a class="side-menu__item" href="<?= base_url('/Painel/home'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="side-menu__icon bi bi-house" viewBox="0 0 20 20">
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                    </svg>
                    <span class="side-menu__label">Página Principal</span>
                </a>
            </li>
            <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="side-menu__icon bi bi-cash-coin" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                    </svg>
                    <span class="side-menu__label">Cobranças</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Cobranca', 'cadastrar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Cobranca/cadastrar'); ?>">Cadastrar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Cobranca', 'pesquisar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Cobranca/pesquisar'); ?>">Pesquisar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Cobranca', 'listar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Cobranca/listar'); ?>">Listar</a></li>
                    <?PHP } ?>
                </ul>
            </li>
            <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="side-menu__icon bi bi-calendar2-heart" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm2 .5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V4a.5.5 0 0 0-.5-.5zm5 4.493c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132" />
                    </svg>
                    <span class="side-menu__label">Evento</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Evento', 'cadastrar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Evento/cadastrar'); ?>">Cadastrar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Evento', 'pesquisar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Evento/pesquisar'); ?>">Pesquisar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Evento', 'listar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Evento/listar'); ?>">Listar</a></li>
                    <?PHP } ?>
                </ul>
            </li>
            <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="side-menu__icon bi bi-lightbulb-fill" viewBox="0 0 20 20">
                        <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5" />
                    </svg>
                    <span class="side-menu__label">Oficina Temática</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('OficinaTematica', 'cadastrar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('OficinaTematica/cadastrar'); ?>">Cadastrar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('OficinaTematica', 'pesquisar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('OficinaTematica/pesquisar'); ?>">Pesquisar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('OficinaTematica', 'listar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('OficinaTematica/listar'); ?>">Listar</a></li>
                    <?PHP } ?>
                </ul>
            </li>
            <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="side-menu__icon bi bi-person-vcard" viewBox="0 0 20 20">
                        <path d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5" />
                        <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96q.04-.245.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 1 1 12z" />
                    </svg>
                    <span class="side-menu__label">Participante</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Participante', 'cadastrar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Participante/cadastrar'); ?>">Cadastrar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Participante', 'pesquisar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Participante/pesquisar'); ?>">Pesquisar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Participante', 'listar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Participante/listar'); ?>">Listar</a></li>
                    <?PHP } ?>
                </ul>
            </li>
            <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="side-menu__icon bi bi-tools" viewBox="0 0 20 20">
                        <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3q0-.405-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708M3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z" />
                    </svg>
                    <span class="side-menu__label">Recurso Trabalho</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('RecursoTrabalho', 'cadastrar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('RecursoTrabalho/cadastrar'); ?>">Cadastrar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('RecursoTrabalho', 'pesquisar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('RecursoTrabalho/pesquisar'); ?>">Pesquisar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('RecursoTrabalho', 'listar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('RecursoTrabalho/listar'); ?>">Listar</a></li>
                    <?PHP } ?>
                </ul>
            </li>

            <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="side-menu__icon bi bi-list-check" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0" />
                    </svg>
                    <span class="side-menu__label">Pesquisa Satisfação</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <!-- <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('PesquisaSatisfacao', 'cadastrar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('PesquisaSatisfacao/cadastrar'); ?>">Cadastrar</a></li>
                    <?PHP } ?> -->
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('PesquisaSatisfacao', 'pesquisar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('PesquisaSatisfacao/pesquisar'); ?>">Pesquisar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('PesquisaSatisfacao', 'listar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('PesquisaSatisfacao/listar'); ?>">Listar</a></li>
                    <?PHP } ?>
                </ul>
            </li>

            <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="side-menu__icon bi bi-box-seam" viewBox="0 0 16 16">
                        <path d="M8.21.6a.5.5 0 0 0-.42 0L1.29 3.39a.5.5 0 0 0-.29.46v8.3a.5.5 0 0 0 .29.46l6.5 2.79a.5.5 0 0 0 .42 0l6.5-2.79a.5.5 0 0 0 .29-.46v-8.3a.5.5 0 0 0-.29-.46l-6.5-2.79zM2 4.27 7.5 6.63v7.2L2 11.47V4.27zm6.5 9.56v-7.2L14 4.27v7.2l-5.5 2.36zM13.56 3.8 8 6.12 2.44 3.8 8 1.48l5.56 2.32z" />
                    </svg>
                    <span class="side-menu__label">Produto</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Produto', 'cadastrar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Produto/cadastrar'); ?>">Cadastrar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Produto', 'pesquisar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Produto/pesquisar'); ?>">Pesquisar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Produto', 'listar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Produto/listar'); ?>">Listar</a></li>
                    <?PHP } ?>
                </ul>
            </li>

            <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="side-menu__icon bi bi-graph-up" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07" />
                    </svg>
                    <span class="side-menu__label">Relatórios</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('PesquisaSatisfacao', 'relatorio')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('PesquisaSatisfacao/relatorio'); ?>">Pesquisa Satisfação</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Reserva', 'relatorio')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Reserva/relatorio'); ?>">Reservas</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Cobranca', 'relatorio')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Cobranca/relatorio'); ?>">Cobranças</a></li>
                    <?PHP } ?>
                </ul>
            </li>

            <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="side-menu__icon bi bi-calendar2-week" viewBox="0 0 20 20">
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z" />
                        <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                    </svg>
                    <span class="side-menu__label">Reserva</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Reserva', 'cadastrar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Reserva/cadastrar'); ?>">Cadastrar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Reserva', 'pesquisar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Reserva/pesquisar'); ?>">Pesquisar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Reserva', 'listar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Reserva/listar'); ?>">Listar</a></li>
                    <?PHP } ?>
                </ul>
            </li>

            <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="30" height="30" fill="currentColor" class="bi bi-grid" viewBox="0 0 20 20">
                        <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0h2A1.5 1.5 0 0 1 5 1.5v2A1.5 1.5 0 0 1 3.5 5h-2A1.5 1.5 0 0 1 0 3.5v-2zM1.5 1a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5h-2zM0 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8zm1 3v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2H1zm14-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2h14zM2 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z" />
                    </svg>
                    <span class="side-menu__label">Serviço</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Servico', 'cadastrar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Servico/cadastrar'); ?>">Cadastrar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Servico', 'pesquisar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Servico/pesquisar'); ?>">Pesquisar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Servico', 'listar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Servico/listar'); ?>">Listar</a></li>
                    <?PHP } ?>
                </ul>
            </li>

            <li>
                <hr>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="<?= base_url('Ajuda/index'); ?>" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="side-menu__icon bi bi-question-circle" viewBox="0 0 20 20">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94" />
                    </svg>
                    <span class="side-menu__label">Ajuda</span>
                </a>
            </li>
            <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="side-menu__icon bi bi-toggles" viewBox="0 0 20 20">
                        <path d="M4.5 9a3.5 3.5 0 1 0 0 7h7a3.5 3.5 0 1 0 0-7zm7 6a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5m-7-14a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5m2.45 0A3.5 3.5 0 0 1 8 3.5 3.5 3.5 0 0 1 6.95 6h4.55a2.5 2.5 0 0 0 0-5zM4.5 0h7a3.5 3.5 0 1 1 0 7h-7a3.5 3.5 0 1 1 0-7" />
                    </svg>
                    <span class="side-menu__label">Configuração</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Configuracao', 'alterar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Configuracao/alterar'); ?>">Configurações Gerais</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('HorarioFuncionamento', 'cadastrar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('HorarioFuncionamento/cadastrar'); ?>">Horário de Funcionamento</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('TemplateTermo', 'alterar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('TemplateTermo/alterar'); ?>">Termo Autorização</a></li>
                    <?PHP } ?>
                </ul>
            </li>
            <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 20 20">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>
                    <span class="side-menu__label">Usuário</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Usuario', 'cadastrar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Usuario/cadastrar'); ?>">Cadastrar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Usuario', 'pesquisar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Usuario/pesquisar'); ?>">Pesquisar</a></li>
                    <?PHP } ?>
                    <?PHP if (\App\Models\UsuarioModel::getSessao()->verificarPermissao('Usuario', 'listar')) { ?>
                        <li><a class="slide-item" href="<?PHP echo base_url('Usuario/listar'); ?>">Listar</a></li>
                    <?PHP } ?>
                </ul>
            </li>
        </ul>
    </div>
</aside>
<!-- main-sidebar -->