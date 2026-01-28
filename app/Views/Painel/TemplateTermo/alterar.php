<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Template Termo</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Alterar</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- content -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Alterar</h4>
        </div>
        <div class="card-body pt-0">
            <form id='formAlterar' action="<?PHP echo base_url('TemplateTermo/doAlterar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="id" value="<?= $templatetermo->id ?>" />
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="requererTermo">Requerer Termo</label> 
                        <select class="form-control" name="requererTermo" id="requererTermo" required="">
                            <?PHP foreach (App\Entities\TemplateTermoEntity::_op('requererTermo') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= ((int)$templatetermo->requererTermo) === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <textarea name="texto" id="texto" class="form-control summernote"><?= $templatetermo->texto ?></textarea>
                    </div>
                </div>                                        
                <div class="form-group mb-0 mt-3 text-center col-12">
                    <button type="submit" class="btn btn-primary submitButton">Alterar</button>
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
        invalidHandler: function(event, validator){
            $('.submitButton').attr('disabled', false);
        },
        errorElement: "div",
        ignore: '.ignoreValidate',
        rules: {
            nome: {
                required: true,
            },
            requererTermo: {
                required: true,
            },
            texto: {
                required: true,
            },
        }
    });

</script>    
<?= $this->endSection('scripts'); ?>
