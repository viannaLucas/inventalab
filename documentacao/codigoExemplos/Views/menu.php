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
                        <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="30" height="30" fill="currentColor" class="bi bi-grid" viewBox="0 0 20 20">
                        <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0h2A1.5 1.5 0 0 1 5 1.5v2A1.5 1.5 0 0 1 3.5 5h-2A1.5 1.5 0 0 1 0 3.5v-2zM1.5 1a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5h-2zM0 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8zm1 3v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2H1zm14-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2h14zM2 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                    <span class="side-menu__label">Exemplo Campos</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <?PHP if(\App\Models\UsuarioModel::getSessao()->verificarPermissao('ExemploCampos', 'cadastrar')){ ?>
                    <li><a class="slide-item" href="<?PHP echo base_url('ExemploCampos/cadastrar'); ?>">Cadastrar</a></li>
                    <?PHP } ?>
                    <?PHP if(\App\Models\UsuarioModel::getSessao()->verificarPermissao('ExemploCampos', 'pesquisar')){ ?>
                    <li><a class="slide-item" href="<?PHP echo base_url('ExemploCampos/pesquisar'); ?>">Pesquisar</a></li>
                    <?PHP } ?>
                    <?PHP if(\App\Models\UsuarioModel::getSessao()->verificarPermissao('ExemploCampos', 'listar')){ ?>
                    <li><a class="slide-item" href="<?PHP echo base_url('ExemploCampos/listar'); ?>">Listar</a></li>
                    <?PHP } ?>
                </ul>
            </li>
                        <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="30" height="30" fill="currentColor" class="bi bi-grid" viewBox="0 0 20 20">
                        <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0h2A1.5 1.5 0 0 1 5 1.5v2A1.5 1.5 0 0 1 3.5 5h-2A1.5 1.5 0 0 1 0 3.5v-2zM1.5 1a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5h-2zM0 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8zm1 3v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2H1zm14-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2h14zM2 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                    <span class="side-menu__label">Tabela FK</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <?PHP if(\App\Models\UsuarioModel::getSessao()->verificarPermissao('TabelaFK', 'cadastrar')){ ?>
                    <li><a class="slide-item" href="<?PHP echo base_url('TabelaFK/cadastrar'); ?>">Cadastrar</a></li>
                    <?PHP } ?>
                    <?PHP if(\App\Models\UsuarioModel::getSessao()->verificarPermissao('TabelaFK', 'pesquisar')){ ?>
                    <li><a class="slide-item" href="<?PHP echo base_url('TabelaFK/pesquisar'); ?>">Pesquisar</a></li>
                    <?PHP } ?>
                    <?PHP if(\App\Models\UsuarioModel::getSessao()->verificarPermissao('TabelaFK', 'listar')){ ?>
                    <li><a class="slide-item" href="<?PHP echo base_url('TabelaFK/listar'); ?>">Listar</a></li>
                    <?PHP } ?>
                </ul>
            </li>
                        <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon"  width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 20 20">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                    </svg>
                    <span class="side-menu__label">Usuário</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <?PHP if(\App\Models\UsuarioModel::getSessao()->verificarPermissao('Usuario', 'cadastrar')){ ?>
                    <li><a class="slide-item" href="<?PHP echo base_url('Usuario/cadastrar'); ?>">Cadastrar</a></li>
                    <?PHP } ?>
                    <?PHP if(\App\Models\UsuarioModel::getSessao()->verificarPermissao('Usuario', 'pesquisar')){ ?>
                    <li><a class="slide-item" href="<?PHP echo base_url('Usuario/pesquisar'); ?>">Pesquisar</a></li>
                    <?PHP } ?>
                    <?PHP if(\App\Models\UsuarioModel::getSessao()->verificarPermissao('Usuario', 'listar')){ ?>
                    <li><a class="slide-item" href="<?PHP echo base_url('Usuario/listar'); ?>">Listar</a></li>
                    <?PHP } ?>
                </ul>
            </li>
        </ul>
    </div>
</aside>
<!-- main-sidebar -->