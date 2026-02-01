<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Pesquisa de Satisfação</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Cadastrar</span>
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
            <form id='formCadastrar' action="<?PHP echo base_url('PesquisaSatisfacao/doCadastrar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <div class="form-row">
                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Participante</label> 
                        <input class="form-control maskInteiro" name="Participante_id" id="Participante_id" type="text" value="<?= esc(old('Participante_id'), 'attr') ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Resposta 1</label> 
                        <input class="form-control maskInteiro" name="resposta1" id="resposta1" type="text" value="<?= esc(old('resposta1'), 'attr') ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Resposta 2</label> 
                        <input class="form-control maskInteiro" name="resposta2" id="resposta2" type="text" value="<?= esc(old('resposta2'), 'attr') ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Resposta 3</label> 
                        <input class="form-control maskInteiro" name="resposta3" id="resposta3" type="text" value="<?= esc(old('resposta3'), 'attr') ?>">
                    </div>                    
                    <div class="form-group col-12 ">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Resposta 4</label> 
                        <textarea name="resposta4" id="resposta4" class="form-control" placeholder="" rows="3"><?= esc(old('resposta4')) ?></textarea>
                    </div>                    
                    <div class="form-group col-12 ">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Resposta 5</label> 
                        <textarea name="resposta5" id="resposta5" class="form-control" placeholder="" rows="3"><?= esc(old('resposta5')) ?></textarea>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Resposta</label> 
                        <input class="form-control maskData" name="dataResposta" id="dataResposta" type="text" value="<?= esc(old('dataResposta'), 'attr') ?>">
                    </div>                                        
                <div class="form-group mb-0 mt-3 text-center col-12">
                    <button type="submit" class="btn btn-primary submitButton">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- content closed -->
<?= $this->endSection('content'); ?><?= $this->section('styles'); ?>
<?= esc($this->endSection('styles'); ) ?><?= $this->section('scripts'); ?>
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
            Participante_id: {
                required: true,
                inteiro: true,
            },
            resposta1: {
                required: true,
                inteiro: true,
            },
            resposta2: {
                required: true,
                inteiro: true,
            },
            resposta3: {
                required: true,
                inteiro: true,
            },
            resposta4: {
                
            },
            resposta5: {
                
            },
            dataResposta: {
                dataBR: true,
            },
        }
    });
</script>    
<?= $this->endSection('scripts'); ?>
