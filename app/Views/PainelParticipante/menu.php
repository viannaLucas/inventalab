<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="<?php echo base_url('PainelParticipante/home'); ?>"><img src="<?php echo base_url('assets/img/brand/logo.png'); ?>" class="main-logo" alt="logo"></a>
        <a class="desktop-logo logo-dark active" href="<?php echo base_url('PainelParticipante/home'); ?>"><img src="<?php echo base_url('assets/img/brand/logo-white.png'); ?>" class="main-logo dark-theme" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href="<?php echo base_url('PainelParticipante/home'); ?>"><img src="<?php echo base_url('assets/img/brand/favicon.png'); ?>" class="logo-icon" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-dark active" href="<?php echo base_url('PainelParticipante/home'); ?>"><img src="<?php echo base_url('assets/img/brand/favicon-white.png'); ?>" class="logo-icon dark-theme" alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <ul class="side-menu pt-3" id="menuPermissoes">
            <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="side-menu__icon bi bi-calendar2-week" viewBox="0 0 20 20">
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z" />
                        <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                    </svg>
                    <span class="side-menu__label">Reserva</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li><a class="slide-item" href="<?PHP echo base_url('PainelParticipante/reserva'); ?>">Cadastrar</a></li>
                    <li><a class="slide-item" href="<?PHP echo base_url('PainelParticipante/listarReservas'); ?>">Listar</a></li>
                </ul>
            </li>
            <li class="slide d-none">
                <a class="side-menu__item" data-toggle="slide">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="side-menu__icon bi bi-calendar2-heart" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm2 .5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V4a.5.5 0 0 0-.5-.5zm5 4.493c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132"></path>
                    </svg>
                    <span class="side-menu__label">Eventos</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li><a class="slide-item" href="<?PHP echo base_url('PainelParticipante/inscricoes'); ?>">Minhas Inscrições</a></li>
                    <li><a class="slide-item" href="<?PHP echo base_url('PainelParticipante/home#proximosEventos'); ?>">Próximos Eventos</a></li>
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
                        <li><a class="slide-item" href="<?PHP echo base_url('PainelParticipante/pesquisaOficinaTematica'); ?>">Pesquisar</a></li>
                        <li><a class="slide-item" href="<?PHP echo base_url('PainelParticipante/listarOficinaTematica'); ?>">Listar</a></li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
<!-- main-sidebar -->