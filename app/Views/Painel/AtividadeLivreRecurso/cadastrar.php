<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Atividade Livre Recurso</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Cadastrar</span>
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
            <form id='formCadastrar' action="<?PHP echo base_url('AtividadeLivreRecurso/doCadastrar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <div class="form-row">
                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Atividade Livre</label> 
                        <div class="input-group">
                            <input class="form-control" name="AtividadeLivre_id_Text" id="AtividadeLivre_id_Text" type="text" disabled="true" onclick="$('#addonSearchAtividadeLivre_id').click()" value="<?= old('AtividadeLivre_id_Text'); ?>"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="addonSearchAtividadeLivre_id" 
                                        data-toggle="modal" data-target="#modalFK" data-title='Localizar Atividade Livre'
                                        data-url-search='<?PHP echo base_url('AtividadeLivre/pesquisaModal?searchTerm='); ?>' data-input-result='AtividadeLivre_id' data-input-text='AtividadeLivre_id_Text' >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <input class="d-none" name="AtividadeLivre_id" id="AtividadeLivre_id" type="text" value="<?= old('AtividadeLivre_id'); ?>" />
                        </div>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Recurso Trabalho</label> 
                        <div class="input-group">
                            <input class="form-control" name="RecursoTrabalho_id_Text" id="RecursoTrabalho_id_Text" type="text" disabled="true" onclick="$('#addonSearchRecursoTrabalho_id').click()" value="<?= old('RecursoTrabalho_id_Text'); ?>"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="addonSearchRecursoTrabalho_id" 
                                        data-toggle="modal" data-target="#modalFK" data-title='Localizar Recurso Trabalho'
                                        data-url-search='<?PHP echo base_url('RecursoTrabalho/pesquisaModal?searchTerm='); ?>' data-input-result='RecursoTrabalho_id' data-input-text='RecursoTrabalho_id_Text' >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <input class="d-none" name="RecursoTrabalho_id" id="RecursoTrabalho_id" type="text" value="<?= old('RecursoTrabalho_id'); ?>" />
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
            atividadelivrerecurso_AtividadeLivre_id: {
                required: true,
            },
            atividadelivrerecurso_RecursoTrabalho_id: {
                required: true,
            },
        }
    });
</script>    
<?= $this->endSection('scripts'); ?>
