<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Painel</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Alterar Perfil</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- row -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Seus Dados</h4>
        </div>
        <div class="card-body pt-0">
            <form id='formAlterar' action="<?PHP echo base_url('Painel/doAlterarPerfil'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="id" value="<?= esc($usuario->id) ?>"/>
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                        <input class="form-control" name="nome" id="nome" type="text" maxlength="50" value="<?= esc($usuario->nome) ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Senha</label> 
                        <input class="form-control" name="senhaAtual" id="senhaAtual" type="password" maxlength="50">
                    </div>
                    <div class="alert alert-info col-12 rounded" role="alert">
                        Deixe a senha em branco para <strong>não</strong> ser alterada.
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nova Senha</label> 
                        <input class="form-control" name="senha" id="senha" type="password" maxlength="50">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Confirmação Nova Senha</label> 
                        <input class="form-control" name="confirmaSenha" id="confirmaSenha" type="password" maxlength="50">
                    </div>
                    <div class="form-group col-12 ">
                        <label>Foto</label>
                        <input type="file" class="dropify" id="foto" name="foto" accept=".jpg,.jpeg,.webp,.png" 
                               data-allowed-file-extensions="webp png jpeg jpg" data-max-file-size="10M" >
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
<?= $this->endSection('content'); ?>

<?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?>

<?= $this->section('scripts'); ?>
<script>
    $('.submitButton').on('click', function (e) {
        // $(this).attr('disabled', true);
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

    $('#permissaoAdmin').on('change', function (e) {
        if ($('#permissaoAdmin').prop('checked')) {
            $('.permissoesUsuario').hide();
        } else {
            $('.permissoesUsuario').show();
        }
    });

    $('#permissaoAdmin').trigger('change');
</script>    
<?= $this->endSection('scripts'); ?>
