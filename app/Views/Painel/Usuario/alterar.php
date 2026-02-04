<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Usuário</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Alterar</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- row -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Alterar</h4>
        </div>
        <div class="card-body pt-0">
            <form id='formAlterar' action="<?PHP echo base_url('Usuario/doAlterar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="id" value="<?= esc($usuario->id) ?>"/>
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                        <input class="form-control" name="nome" id="nome" type="text" maxlength="50" value="<?= esc($usuario->nome) ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Email Login</label> 
                        <input class="form-control email" readonly name="login" id="login" type="text" maxlength="50" value="<?= esc($usuario->login) ?>">
                    </div>
                    <!-- <div class="alert alert-info col-12 rounded" role="alert">
                        Deixe "Nova Senha" em branco para <strong>não</strong> ser alterada.
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Senha</label> 
                        <input class="form-control" name="senha" id="senha" type="password" maxlength="50">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Confirmação Senha</label> 
                        <input class="form-control" name="confirmaSenha" id="confirmaSenha" type="password" maxlength="50">
                    </div> -->
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label> 
                        <div class="custom-control custom-switch">
                            <input  type="checkbox" class="custom-control-input" name='ativo' id="ativo" value="1" <?= esc($usuario->ativo) == '1' ? 'checked' : '' ?> >
                            <label class="custom-control-label" for="ativo">Ativo</label>
                        </div>
                    </div>
                    <div class="form-group col-12 ">
                        <label>Foto</label>
                        <input type="file" class="dropify" id="foto" name="foto" accept=".jpg,.jpeg,.webp,.png" 
                               data-allowed-file-extensions="webp png jpeg jpg" data-max-file-size="10M" >
                    </div>
                    <div class="mb-0 mt-3 text-center col-12">
                        <label class="h4">Permissões</label>
                        <div class="mt-2 mb-3 d-flex justify-content-center flex-wrap">
                            <label class="rdiobox mr-3">
                                <input type="radio" name="tipoPermissao" id="permPersonalizado" value="personalizado" <?= in_array('useradmin', $usuario->getPermissoes()) ? '' : 'checked' ?>>
                                <span>Personalizado</span>
                            </label>
                            <label class="rdiobox mr-3">
                                <input type="radio" name="tipoPermissao" id="permMonitor" value="monitor">
                                <span>Monitor</span>
                            </label>
                            <label class="rdiobox">
                                <input type="radio" name="tipoPermissao" id="permAdmin" value="admin" <?= in_array('useradmin', $usuario->getPermissoes()) ? 'checked' : '' ?>>
                                <span>Administrador</span>
                            </label>
                        </div>
                        <div id="adminInfo" class="mb-2 text-center text-muted" style="<?= in_array('useradmin', $usuario->getPermissoes()) ? '' : 'display: none;' ?>">
                            Todas as funcionalidades
                        </div>
                        <input type="checkbox" class="d-none" id="permissaoAdmin" name="permissoes[]" value="useradmin" <?= in_array('useradmin', $usuario->getPermissoes()) ? 'checked=""' : ''; ?>>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Funcionalidade</th>
                                    <th>Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?PHP
                                foreach ($permissoes as $c => $lm) {
                                    foreach ($lm as $nm => $m) {
                                        ?>
                                        <tr class="permissoesUsuario">
                                            <td class="text-left "><label class="ckbox"><input type="checkbox" name="permissoes[]" value="<?= esc($c . '.' . $nm, 'attr') ?>" <?= in_array($c . '.' . $nm, $usuario->getPermissoes()) ? 'checked=""' : ''; ?> ><span><?= $c; ?>: <?= $m['label']; ?></span></label></td>
                                            <td><?= esc($m['descricao']) ?></td>
                                        </tr>
                                    <?PHP }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group mb-0 mt-3 text-center col-12">
                        <div>
                            <button type="submit" class="btn btn-primary submitButton">Alterar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- row closed -->
<?= $this->endSection('content'); ?><?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?><?= $this->section('scripts'); ?>
<script>
    $('.submitButton').on('click', function (e) {
        //$(this).attr('disabled', true);
    });
    var validator = $("#formAlterar").validate({
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            error.appendTo(element.parent());
        },
        highlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        onfocusout: function (element) {
            if (!this.checkable(element)) {
                this.element(element);
            }
        },
        invalidHandler: function (event, validator) {
            $('.submitButton').attr('disabled', false);
        },
        errorElement: "div",
        ignore: '.ignoreValidate',
        rules: {
            nome: {
                required: true,
                minlength: 5
            },
            login: {
                required: true,
                minlength: 5
            },
            senha: {
                //required: true,
                minlength: 6,
                senhaForte: true
            },
            confirmaSenha: {
                //required: true,
                equalTo: "#senha"
            },
            foto: {
                arquivo: 'webp|jpg|jpeg|png'
            }
        }
    });

    function limparPermissoesUsuario() {
        $('.permissoesUsuario input[type="checkbox"]').prop('checked', false);
    }

    function aplicarAdminUI() {
        if ($('#permAdmin').prop('checked')) {
            $('#adminInfo').show();
            $('.permissoesUsuario').hide();
        }
    }

    $('input[name="tipoPermissao"]').on('change', function () {
        var tipo = $(this).val();

        if (tipo === 'admin') {
            $('#permissaoAdmin').prop('checked', true);
            $('#adminInfo').show();
            $('.permissoesUsuario').hide();
            return;
        }

        $('#permissaoAdmin').prop('checked', false);
        $('#adminInfo').hide();
        $('.permissoesUsuario').show();
        limparPermissoesUsuario();

        if (tipo === 'monitor') {
            var permissoesMonitor = [
                'Cobrança.alterar',
                'Cobrança.pesquisar',
                'Cobrança.cadastrar',
                'Cobrança.listar',
                'Cobrança.excluir',
                // 'Configuração.alterar',
                'Evento.alterar',
                'Evento.pesquisar',
                'Evento.cadastrar',
                'Evento.listar',
                'Evento.excluir',
                'Evento.controlePresenca',
                // 'Horário de Funcionamento.definirHoraFuncionamento',
                'Produto.alterar',
                'Produto.pesquisar',
                'Produto.cadastrar',
                'Produto.listar',
                // 'Oficina Temática.alterar',
                'Oficina Temática.pesquisar',
                // 'Oficina Temática.cadastrar',
                'Oficina Temática.listar',
                // 'Oficina Temática.excluir',
                'Participante.alterar',
                'Participante.pesquisar',
                'Participante.cadastrar',
                'Participante.listar',
                // 'Pesquisa Satisfação.visualizar',
                // 'Pesquisa Satisfação.pesquisar',
                // 'Pesquisa Satisfação.listar',
                'Recurso de Trabalho.alterar',
                'Recurso de Trabalho.pesquisar',
                'Recurso de Trabalho.cadastrar',
                'Recurso de Trabalho.listar',
                'Recurso de Trabalho.garantia',
                'Reserva.alterar',
                'Reserva.pesquisar',
                'Reserva.cadastrar',
                'Reserva.listar',
                'Reserva.controleUso',
                // 'Serviço.alterar',
                'Serviço.pesquisar',
                // 'Serviço.cadastrar',
                'Serviço.listar',
                // 'Termo de Autorização.alterar',
                // 'Relatório.pesquisaSatisfacao',
                // 'Relatório.reservas',
                // 'Relatório.cobranca'
            ];

            permissoesMonitor.forEach(function (valor) {
                $('.permissoesUsuario input[type="checkbox"][value="' + valor + '"]').prop('checked', true);
            });
        }
    });

    aplicarAdminUI();
</script>    
<?= $this->endSection('scripts'); ?>
