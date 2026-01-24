<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Usuário</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Cadastrar</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- row -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Cadastrar</h4>
        </div>
        <div class="card-body pt-0">
            <form id='formCadastrar' action="<?PHP echo base_url('Usuario/doCadastrar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                        <input class="form-control" name="nome" id="nome" type="text" maxlength="50" value="<?= old('nome') ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Login</label> 
                        <input class="form-control" name="login" id="login" type="text" maxlength="50" value="<?= old('login') ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Senha</label> 
                        <input class="form-control" name="senha" id="senha" type="password" maxlength="50">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Confirmação Senha</label> 
                        <input class="form-control" name="confirmaSenha" id="confirmaSenha" type="password" maxlength="50">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label> 
                        <div class="custom-control custom-switch">
                            <input  type="checkbox" class="custom-control-input" name='ativo' id="ativo" value="1" <?= old('ativo') == '1' ? 'checked':''  ?> >
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
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Funcionalidade</th>
                                    <th>Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left"><label class="ckbox"><input type="checkbox" id="permissaoAdmin" name="permissoes[]" value="useradmin"><span>Usuario Administrador</span></label></td>
                                    <td>Acesso a todas funcionalidades incluindo gerenciar Usuários</td>
                                </tr>
                                <?PHP 
                                foreach ($permissoes as $c => $lm){
                                    foreach ($lm as $nm => $m){ 
                                ?>
                                <tr class="permissoesUsuario">
                                    <td class="text-left "><label class="ckbox"><input type="checkbox" name="permissoes[]" value="<?= $c.'.'.$nm; ?>"><span><?= $c; ?>: <?= $m['label']; ?></span></label></td>
                                    <td><?= $m['descricao']; ?></td>
                                </tr>
                                <?PHP } } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group mb-0 mt-3 text-center col-12">
                        <div>
                            <button type="submit" class="btn btn-primary submitButton">Cadastrar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- row closed -->
<?= $this->endSection('content'); ?>

<?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?>

<?= $this->section('scripts'); ?>
<script>
    
    $('.submitButton').on('click', function (e) {
        $(this).attr('disabled', true);
    });
    
    var validator = $("#formCadastrar").validate({
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
                required: true,
                minlength: 5
            },
            confirmaSenha: {
                required: true,
                equalTo: "#senha"
            },
            foto: {
                arquivo: 'webp|jpg|jpeg|png'
            }
        }
    });
    
    $('#permissaoAdmin').on('change', function(e){ 
        if($('#permissaoAdmin').prop('checked')){
            $('.permissoesUsuario').hide();
        }else{
            $('.permissoesUsuario').show();
        }
    });
</script>    
<?= $this->endSection('scripts'); ?>