<!doctype html>
<html lang="pt-BR" dir="ltr">
    <head>

        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="Sistema Floripa 360">

        <!-- Title -->
        <title>Sistema Floripa 360</title>

        <!-- Favicon -->
        <link rel="icon" href="<?php echo base_url('assets/img/brand/favicon.png'); ?>" type="image/x-icon"/>

        <!-- Bootstrap css-->
        <link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet"/>

        <!-- Icons css -->
        <link href="<?php echo base_url('assets/css/icons.css'); ?>" rel="stylesheet">

        <!--  Right-sidemenu css -->
        <link href="<?php echo base_url('assets/plugins/sidebar/sidebar.css'); ?>" rel="stylesheet">

        <!-- P-scroll bar css-->
        <link href="<?php echo base_url('assets/plugins/perfect-scrollbar/p-scrollbar.css'); ?>" rel="stylesheet" />

        <!--  Left-Sidebar css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/sidemenu.css'); ?>">

        <!-- Style css -->
        <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/style-dark.css'); ?>" rel="stylesheet">

        <!-- Skinmodes css -->
        <link href="<?php echo base_url('assets/css/skin-modes.css'); ?>" rel="stylesheet" />

        <!-- Animations css -->
        <link href="<?php echo base_url('assets/css/animate.css'); ?>" rel="stylesheet">
        
        <!-- text editor -->
        <link href="<?php echo base_url('assets/plugins/summernote/summernote.min.css'); ?>" rel="stylesheet">
        
        <!-- dropify -->
        <link href="<?php echo base_url('assets/plugins/dropify/css/dropify.min.css'); ?>" rel="stylesheet">
        
        <!-- Internal Select2 css -->
        <link href="<?PHP echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet">
        
        <!--- Internal Sweet-Alert css-->
        <link href="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.css'); ?>" rel="stylesheet">

        <?= $this->renderSection('styles'); ?>

    </head>

    <body class="main-body app sidebar-mini dark-theme">

        <!-- Loader -->
        <div id="global-loader">
            <img src="<?php echo base_url('assets/img/loader.svg'); ?>" class="loader-img" alt="Loader">
        </div>
        <!-- /Loader -->

        <!-- Page -->
        <div class="page">

            <?= $this->include('menu'); ?>

            <!-- main-content -->
            <div class="main-content app-content">

                <?= $this->include('menuTopo'); ?>

                <!-- container -->
                <div class="container-fluid">

                    <?= $this->renderSection('content'); ?>

                </div>
                <!-- Container closed -->

            </div>
            <!-- main-content closed -->

            <?= $this->renderSection('modal'); ?>

            <!-- Footer opened -->
            <!--            <div class="main-footer ht-40">
                            <div class="container-fluid pd-t-0-f ht-100p">
                                <span>Copyright © 2021 <a href="#">Valex</a>. Designed by <a href="https://www.spruko.com/">Spruko</a> All rights reserved.</span>
                            </div>
                        </div>-->
            <!-- Footer closed -->

        </div>
        <!-- End Page -->
        
        <?PHP 
            $msg_sucesso = session()->getFlashdata('msg_sucesso'); 
            if($msg_sucesso != null){
        ?>
        <div class="modal" id="modalSucesso">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-body tx-center pd-y-20 pd-x-20">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button> <i class="icon ion-ios-checkmark-circle-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                        <h4 class="tx-success tx-semibold mg-b-20">Sucesso!</h4>
                        <p class="mg-b-20 mg-x-20"><?PHP echo esc($msg_sucesso); ?></p>
                        <button aria-label="Close" class="btn ripple btn-success pd-x-25" data-dismiss="modal" type="button">Continue</button>
                    </div>
                </div>
            </div>
        </div>
        <?PHP 
            } 
            $msg_erro = session()->getFlashdata('msg_erro');
            if($msg_erro != null){
                if(is_array($msg_erro)){
                    $am = $msg_erro;
                    $msg_erro = '<ul class="list-group"><li class="list-group-item">';
                    $msg_erro .= implode('</li><li class="list-group-item">', $am);
                    $msg_erro .= '</li></ul>';
                }
        ?>
        <div class="modal" id="modalErro">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-body tx-center pd-y-20 pd-x-20">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block ml-1"></i>
                        <h4 class="tx-danger mg-b-20">Erro!</h4>
                        <p class="mg-b-20 mg-x-20"><?PHP echo $msg_erro; ?></p>
                        <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-dismiss="modal" type="button">Continue</button>
                    </div>
                </div>
            </div>
        </div>
        <?PHP } ?>
        
        <!-- ForeingKey Modal -->
        <div class="modal" id="modalFK">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Localizar</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-header">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <input class="form-control" id="inputModalFKSearch" type="text" maxlength="50" value=""/>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="btnModalFKSearch" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="col-12" id="divModalFKResult">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--End ForeingKey Modal -->
        
        <!-- Back-to-top -->
        <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

        <!-- JQuery min js -->
        <script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>

        <!-- Bootstrap js -->
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/popper.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.js'); ?>"></script>

        <!-- Ionicons js -->
        <script src="<?php echo base_url('assets/plugins/ionicons/ionicons.js'); ?>"></script>

        <!-- Moment js -->
        <script src="<?php echo base_url('assets/plugins/moment/moment.js'); ?>"></script>

        <!-- P-scroll js -->
        <script src="<?php echo base_url('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js'); ?>"></script>
<!--        <script src="<?php echo base_url('assets/plugins/perfect-scrollbar/p-scroll.js'); ?>"></script>-->

        <!-- Sticky js -->
        <script src="<?php echo base_url('assets/js/sticky.js'); ?>"></script>

        <!-- eva-icons js -->
        <script src="<?php echo base_url('assets/js/eva-icons.min.js'); ?>"></script>

        <!-- Rating js-->
        <script src="<?php echo base_url('assets/plugins/rating/jquery.rating-stars.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/rating/jquery.barrating.js'); ?>"></script>

        <!-- Sidebar js -->
        <script src="<?php echo base_url('assets/plugins/side-menu/sidemenu.js'); ?>"></script>

        <!-- Right-sidebar js -->
<!--        <script src="<?php echo base_url('assets/plugins/sidebar/sidebar.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/sidebar/sidebar-custom.js'); ?>"></script>-->

        <!--Internal  JQueryValidate.min js -->
        <script src="<?php echo base_url('assets/plugins/jQueryValidate/jquery.validate.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jQueryValidate/validacoesPersonalizadas.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jQueryValidate/localization/messages_pt_BR.js'); ?>"></script>
        
        <!-- Dropfy Upload Image -->
        <script src="<?php echo base_url('assets/plugins/dropify/js/dropify.min.js'); ?>"></script>
        
        <!-- Internal Select2.min js -->
        <script src="<?PHP echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>
        
        <!--Internal  Sweet-Alert js-->
        <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/sweet-alert/jquery.sweet-alert.js'); ?>"></script>

        <!-- Sweet-alert js  -->
        <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
        
        <!-- custom js -->
        <script src="<?php echo base_url('assets/plugins/summernote/summernote.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/validacoes.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mask.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.maskMoney.min.js'); ?>"></script>
        

        <?= $this->renderSection('scripts'); ?>
    </body>
</html>