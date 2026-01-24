<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Oficina Temática Reserva</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Alterar</span>
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
            <form id='formAlterar' action="<?PHP echo base_url('OficinaTematicaReserva/doAlterar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="id" value="<?= $oficinatematicareserva->id ?>" />
                <div class="form-row">
                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Reserva</label> 
                        <div class="input-group">
                            <input class="form-control" name="Reserva_id_Text" id="Reserva_id_Text" type="text" disabled="true" onclick="$('#addonSearchReserva_id').click()" value="<?= $oficinatematicareserva->getReserva()->dataReserva ?>"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="addonSearchReserva_id" 
                                        data-toggle="modal" data-target="#modalFK" data-title='Localizar Reserva'
                                        data-url-search='<?PHP echo base_url('Reserva/pesquisaModal?searchTerm='); ?>' data-input-result='Reserva_id' data-input-text='Reserva_id_Text' >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <input class="d-none" name="Reserva_id" id="Reserva_id" type="text" value="<?= $oficinatematicareserva->Reserva_id ?>" />
                        </div>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Oficina Temática</label> 
                        <div class="input-group">
                            <input class="form-control" name="OficinaTematica_id_Text" id="OficinaTematica_id_Text" type="text" disabled="true" onclick="$('#addonSearchOficinaTematica_id').click()" value="<?= $oficinatematicareserva->getOficinaTematica()->nome ?>"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="addonSearchOficinaTematica_id" 
                                        data-toggle="modal" data-target="#modalFK" data-title='Localizar Oficina Temática'
                                        data-url-search='<?PHP echo base_url('OficinaTematica/pesquisaModal?searchTerm='); ?>' data-input-result='OficinaTematica_id' data-input-text='OficinaTematica_id_Text' >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <input class="d-none" name="OficinaTematica_id" id="OficinaTematica_id" type="text" value="<?= $oficinatematicareserva->OficinaTematica_id ?>" />
                        </div>
                    </div>                    
                    <div class="form-group col-12 ">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Observação</label> 
                        <textarea name="observacao" id="observacao" class="form-control" placeholder="" rows="3"><?= $oficinatematicareserva->observacao ?></textarea>
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
            Reserva_id: {
                required: true,
            },
            OficinaTematica_id: {
                required: true,
            },
            observacao: {
                
            },
        }
    });

</script>    
<?= $this->endSection('scripts'); ?>
