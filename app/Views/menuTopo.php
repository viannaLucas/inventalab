<!-- main-header -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left ">
            
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a> 
           </div>
        </div>
        <div class="">
            <div class="responsive-logo">
                <a href="<?php echo base_url('Painel/home'); ?>"><img src="<?php echo base_url('assets/img/brand/logo.png'); ?>" class="logo-1" alt="logo"></a>
                <a href="<?php echo base_url('Painel/home'); ?>"><img src="<?php echo base_url('assets/img/brand/logo-white.png'); ?>" class="dark-logo-1" alt="logo"></a>
                <a href="<?php echo base_url('Painel/home'); ?>"><img src="<?php echo base_url('assets/img/brand/favicon.png'); ?>" class="logo-2" alt="logo"></a>
                <a href="<?php echo base_url('Painel/home'); ?>"><img src="<?php echo base_url('assets/img/brand/favicon-white.png'); ?>" class="dark-logo-2" alt="logo"></a>
            </div>
        </div>
        <div class="main-header-right">
            <div class="nav nav-item  navbar-nav-right ml-auto">
                <div class="nav-item theme-color" style="margin: auto 3px;">
                    <div class="nav-link mx-n2 btnThemeColorDark d-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 512 512"><title>Modo Escuro</title><path d="M160 136c0-30.62 4.51-61.61 16-88C99.57 81.27 48 159.32 48 248c0 119.29 96.71 216 216 216 88.68 0 166.73-51.57 200-128-26.39 11.49-57.38 16-88 16-119.29 0-216-96.71-216-216z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
                    </div>
                    <div class="nav-link mx-n2 btnThemeColorWhite">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 512 512"><title>Modo Claro</title><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M256 48v48M256 416v48M403.08 108.92l-33.94 33.94M142.86 369.14l-33.94 33.94M464 256h-48M96 256H48M403.08 403.08l-33.94-33.94M142.86 142.86l-33.94-33.94"/><circle cx="256" cy="256" r="80" fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32"/></svg>
                    </div>
                </div>
                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
                </div>
                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <?PHP 
                    $avatar = \App\Models\UsuarioModel::getSessao()->foto; 
                    if($avatar == '') $avatar = '/assets/img/faces/default_avatar.jpg';
                    ?>
                    <a class="profile-user d-flex" href=""><img alt="" src="<?= esc(base_url($avatar), 'attr') ?>" ></a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user"><img alt="" src="<?= esc(base_url($avatar), 'attr') ?>" class=""></div>
                                <div class="ml-3 my-auto">
                                    <h6><?= esc(\App\Models\UsuarioModel::getSessao()->nome) ?></h6>
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item" href="<?= esc(base_url('Painel/alterarPerfil'), 'attr') ?>"><i class="bx bx-user-circle"></i> Perfil</a>
                        <a class="dropdown-item" href="<?php echo base_url('Painel/logout'); ?>"><i class="bx bx-log-out"></i> Sair</a>
                    </div>
                </div>
<!--                <div class="dropdown main-header-message right-toggle">
                    <a class="nav-link pr-0" data-toggle="sidebar-right" data-target=".sidebar-right">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                    </a>
                </div>-->
            </div>
        </div>
    </div>
</div>
<!-- /main-header -->