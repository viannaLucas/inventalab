<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Exemplo Campos</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Cadastrar</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- content -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Cadastrar</h4>
        </div>
        <div class="card-body pt-0">
            <form id='formCadastrar' action="<?PHP echo base_url('ExemploCampos/doCadastrar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Texto</label> 
                        <input class="form-control" name="tipoTexto" id="tipoTexto" type="text" maxlength="100" value="<?= old('tipoTexto') ?>">
                    </div>                    
                    <div class="form-group col-12 ">
                        <label>Tipo Imagem</label>
                        <input type="file" class="dropify" id="tipoImagem" name="tipoImagem" accept=".jpg,.jpeg,.webp,.png" 
                               data-allowed-file-extensions="webp png jpeg jpg" data-max-file-size="10M" >
                    </div>                    
                    <div class="form-group col-12 col-md-6 ">
                        <label>Tipo Arquivo</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="tipoArquivo" name="tipoArquivo">
                            <label class="custom-file-label" for="tipoArquivo" data-browse="Arquivo"></label>
                        </div>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Data</label> 
                        <input class="form-control maskData" name="tipoData" id="tipoData" type="text" value="<?= old('tipoData') ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Número</label> 
                        <input class="form-control maskInteiro" name="tipoNumero" id="tipoNumero" type="text" value="<?= old('tipoNumero') ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Real</label> 
                        <input class="form-control maskReal" name="tipoReal" id="tipoReal" type="text" value="<?= old('tipoReal', '0,00') ?>">
                    </div>                    
                    <div class="form-group col-12 ">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Textarea</label> 
                        <textarea name="tipoTextarea" id="tipoTextarea" class="form-control" placeholder="" rows="3"><?= old('tipoTextarea') ?></textarea>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo CPF</label> 
                        <input class="form-control maskCPF" name="tipoCPF" id="tipoCPF" type="text" value="<?= old('tipoCPF') ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">tipoCNPJ</label> 
                        <input class="form-control maskCNPJ" name="tipoCNPJ" id="tipoCNPJ" type="text" value="<?= old('tipoCNPJ') ?>">
                    </div>                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Email</label> 
                        <input class="form-control" name="tipoEmail" id="tipoEmail" type="text" maxlength="250" value="<?= old('tipoEmail') ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="tipoSelect">Tipo Select</label> 
                        <select class="form-control" name="tipoSelect" id="tipoSelect" required="" >
                            <option value="" <?= old('tipoSelect')=='' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\ExemploCamposEntity::_op('tipoSelect') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= old('tipoSelect') === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Telefone</label> 
                        <input class="form-control" name="tipoTelefone" id="tipoTelefone" type="text" maxlength="20" value="<?= old('tipoTelefone') ?>">
                    </div>                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Senha</label> 
                        <input class="form-control" name="tipoSenha" id="tipoSenha" type="text" maxlength="50" value="<?= old('tipoSenha') ?>">
                    </div>                    
                    <div class="col-12">
                        <textarea name="tipoEditor" id="tipoEditor" class="form-control summernote"><?= old('tipoEditor') ?></textarea>
                    </div>
                </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Foreignkey</label> 
                        <div class="input-group">
                            <input class="form-control" name="foreignkey_Text" id="foreignkey_Text" type="text" disabled="true" onclick="$('#addonSearchforeignkey').click()" value="<?= old('foreignkey_Text'); ?>"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="addonSearchforeignkey" 
                                        data-toggle="modal" data-target="#modalFK" data-title='Localizar Foreignkey'
                                        data-url-search='<?PHP echo base_url('TabelaFK/pesquisaModal?searchTerm='); ?>' data-input-result='foreignkey' data-input-text='foreignkey_Text' >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <input class="d-none" name="foreignkey" id="foreignkey" type="text" value="<?= old('foreignkey'); ?>" />
                        </div>
                    </div>                                        
                <div class="form-group mb-0 mt-3 text-center col-12">
                    <button type="submit" class="btn btn-primary submitButton">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- content closed -->
<?= $this->endSection('content'); ?>

<?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?>

<?= $this->section('scripts'); ?>
<script>
    $('.submitButton').on('click', function(e){
        //$(this).attr('disabled', true);
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
        invalidHandler: function(event, validator){
            $('.submitButton').attr('disabled', false);
        },
        errorElement: "div",
        ignore: '.ignoreValidate',
        rules: {
            tipoTexto: {
                required: true,
            },
            tipoImagem: {
                required: true,
                arquivo: 'webp|jpg|jpeg|png',
            },
            tipoArquivo: {
                required: true,
                arquivo: 'pdf|doc|docx|xls|xlsx|csv',
            },
            tipoData: {
                required: true,
                dataBR: true,
            },
            tipoNumero: {
                required: true,
                inteiro: true,
            },
            tipoReal: {
                required: true,
                real: true,
                normalizer: function (value) { if (value.includes(',')) { return value.replaceAll('.', '').replace(',', '.'); } return value; },
                min: 0.01,
            },
            tipoTextarea: {
                required: true,
            },
            tipoCPF: {
                required: true,
                cpf: true,
            },
            tipoCNPJ: {
                required: true,
                cnpj: true,
            },
            tipoEmail: {
                required: true,
                email: true,
            },
            tipoSelect: {
                required: true,
            },
            tipoTelefone: {
                required: true,
            },
            tipoSenha: {
                required: true,
            },
            tipoEditor: {
                required: true,
            },
            foreignkey: {
                required: true,
            },
        }
    });
</script>    
<?= $this->endSection('scripts'); ?>
