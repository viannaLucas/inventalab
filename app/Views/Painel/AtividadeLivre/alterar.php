<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Atividade Livre</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Alterar</span>
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
            <form id='formAlterar' action="<?PHP echo base_url('AtividadeLivre/doAlterar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="id" value="<?= $atividadelivre->id ?>" />
                <div class="form-row">
                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Reserva</label> 
                        <div class="input-group">
                            <input class="form-control" name="Reserva_id_Text" id="Reserva_id_Text" type="text" disabled="true" onclick="$('#addonSearchReserva_id').click()" value="<?= $atividadelivre->getReserva()->dataReserva ?>"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="addonSearchReserva_id" 
                                        data-toggle="modal" data-target="#modalFK" data-title='Localizar Reserva'
                                        data-url-search='<?PHP echo base_url('Reserva/pesquisaModal?searchTerm='); ?>' data-input-result='Reserva_id' data-input-text='Reserva_id_Text' >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <input class="d-none" name="Reserva_id" id="Reserva_id" type="text" value="<?= $atividadelivre->Reserva_id ?>" />
                        </div>
                    </div>                    
                    <div class="form-group col-12 ">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Descrição</label> 
                        <textarea name="descricao" id="descricao" class="form-control" placeholder="" rows="3"><?= $atividadelivre->descricao ?></textarea>
                    </div>                                        
                <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                    <div class="border-bottom mx-n1 mb-3">
                        <h4 class="px-2">Lista de Atividade Livre Recurso</h4>
                    </div>
                    <div class="form-row px-2">
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Recurso Trabalho</label> 
                            <div class="input-group mb-3">
                                <input class="form-control" name="atividadelivrerecurso_RecursoTrabalho_id_Text" id="atividadelivrerecurso_RecursoTrabalho_id_Text" type="text" disabled="true" onclick="$('#addonSearchatividadelivrerecurso_RecursoTrabalho_id').click()" value=""/>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="addonSearchatividadelivrerecurso_RecursoTrabalho_id" 
                                            data-toggle="modal" data-target="#modalFK" data-title='Localizar >Recurso Trabalho'
                                            data-url-search='<?PHP echo base_url('RecursoTrabalho/pesquisaModal?searchTerm='); ?>' data-input-result='atividadelivrerecurso_RecursoTrabalho_id' data-input-text='atividadelivrerecurso_RecursoTrabalho_id_Text' >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                        </svg>
                                    </button>
                                </div>
                                <input class="d-none" name="atividadelivrerecurso_RecursoTrabalho_id" id="atividadelivrerecurso_RecursoTrabalho_id" type="text" value="" />
                            </div>
                        </div>                        
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label> 
                            <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddAtividadeLivreRecurso">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <table class="table table-striped" id="listTableAtividadeLivreRecurso">
                        <thead>
                            <tr>
                                <th scope="col">Recurso Trabalho</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody >
                        </tbody>
                    </table>
                    <div class="w-100 text-center msgEmptyListAtividadeLivreRecurso mb-3">
                        <span class="h5">Sem itens selecionados</span>
                    </div>
                </fieldset>
                <div class="form-group mb-0 mt-3 text-center col-12">
                    <button type="submit" class="btn btn-primary submitButton">Alterar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="templateRowAtividadeLivreRecurso">
    <tr id='AtividadeLivreRecurso_{_index_}'>
        <td>
            <input type="hidden" class="form-control ignoreValidate fkRecursoTrabalho_idAtividadeLivreRecurso" name="AtividadeLivreRecurso[{_index_}][RecursoTrabalho_id]" readonly="true" value="{_RecursoTrabalho_id_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_RecursoTrabalho_id_Text_}" />
        </td>
        <td>
            <div class="btn btn-danger btnExcluirAtividadeLivreRecurso" onclick="$('#AtividadeLivreRecurso_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>
            </div>
        </td>
    </tr>
</template>
<!-- content closed -->
<?= $this->endSection('content'); ?>

<?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?>

<?= $this->section('scripts'); ?>
<script>
    $('.submitButton').on('click', function(e){
        //$(this).attr('disabled', true);
        disableValidationFieldsFK();
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
            enableValidationFieldsFK();
        },
        errorElement: "div",
        ignore: '.ignoreValidate',
        rules: {
            Reserva_id: {
                required: true,
            },
            descricao: {
                required: true,
            },
            atividadelivrerecurso_RecursoTrabalho_id: {
                required: true,
            },
        }
    });

    var inputsAtividadeLivreRecurso = [
        'atividadelivrerecurso_RecursoTrabalho_id',
    ];
    
    $('#btnAddAtividadeLivreRecurso').on('click', function (e) {
        addAtividadeLivreRecurso();
    });

    function disableValidationFieldsFK() {
        for (var i in inputsAtividadeLivreRecurso) {
            $('#' + inputsAtividadeLivreRecurso[i]).addClass('ignoreValidate');
        }
    }

    function enableValidationFieldsFK() {
        for (var i in inputsAtividadeLivreRecurso) {
            $('#' + inputsAtividadeLivreRecurso[i]).removeClass('ignoreValidate');
        }
    }

    var indexRowAtividadeLivreRecurso = 0;
    function addAtividadeLivreRecurso() {
        $('.msgEmptyListAtividadeLivreRecurso').addClass('d-none');
        //$('#listTableAtividadeLivreRecurso').removeClass('d-none');
        let error = false;
        for (var i in inputsAtividadeLivreRecurso) {
            if (!$('#' + inputsAtividadeLivreRecurso[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        let dados = {};
        dados.RecursoTrabalho_id = $('#atividadelivrerecurso_RecursoTrabalho_id').val();
        dados.RecursoTrabalho_id_Text = $('#atividadelivrerecurso_RecursoTrabalho_id_Text').val();
            
        insertRowAtividadeLivreRecurso(dados);
        
        $('#atividadelivrerecurso_RecursoTrabalho_id').val('');
        $('#atividadelivrerecurso_RecursoTrabalho_id_Text').val('');
    }
    
    function insertRowAtividadeLivreRecurso(dados){
        let html = $('#templateRowAtividadeLivreRecurso').html();
        html = html.replaceAll('{_index_}', indexRowAtividadeLivreRecurso);
        html = html.replaceAll('{_RecursoTrabalho_id_}', dados.RecursoTrabalho_id);
        html = html.replaceAll('{_RecursoTrabalho_id_Text_}', dados.RecursoTrabalho_id_Text);
        $('#listTableAtividadeLivreRecurso tbody').append(html);
        
        indexRowAtividadeLivreRecurso++;
        $(".msgEmptyListAtividadeLivreRecurso").hide();
    }

<?PHP foreach ($atividadelivre->getListAtividadeLivreRecurso() as $i => $o) {
    $o->RecursoTrabalho_id_Text = $o->getRecursoTrabalho()->nome;
?>
    insertRowAtividadeLivreRecurso(<?= json_encode($o) ?>);
<?PHP } ?>
</script>    
<?= $this->endSection('scripts'); ?>
