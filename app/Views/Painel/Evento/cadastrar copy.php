<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Evento</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Cadastrar</span>
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
            <form id='formCadastrar' action="<?PHP echo base_url('Evento/doCadastrar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                        <input class="form-control" name="nome" id="nome" type="text" maxlength="150" value="<?= old('nome') ?>">
                    </div>                    
                    <div class="col-12">
                        <textarea name="texto" id="texto" class="form-control summernote"><?= old('texto') ?></textarea>
                    </div>
                </div>                    
                    <div class="form-group col-12 ">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Descrição</label> 
                        <textarea name="descricao" id="descricao" class="form-control" placeholder="" rows="3"><?= old('descricao') ?></textarea>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="vagasLimitadas">Vagas Limitadas</label> 
                        <select class="form-control" name="vagasLimitadas" id="vagasLimitadas" required="" >
                            <option value="" <?= old('vagasLimitadas')=='' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\EventoEntity::_op('vagasLimitadas') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= old('vagasLimitadas') === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Número Vagas</label> 
                        <input class="form-control maskInteiro" name="numeroVagas" id="numeroVagas" type="text" value="<?= old('numeroVagas') ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="inscricoesAbertas">Inscrições Abertas</label> 
                        <select class="form-control" name="inscricoesAbertas" id="inscricoesAbertas" required="" >
                            <option value="" <?= old('inscricoesAbertas')=='' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\EventoEntity::_op('inscricoesAbertas') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= old('inscricoesAbertas') === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="divulgar">Divulgar</label> 
                        <select class="form-control" name="divulgar" id="divulgar" required="" >
                            <option value="" <?= old('divulgar')=='' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\EventoEntity::_op('divulgar') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= old('divulgar') === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Início</label> 
                        <input class="form-control maskData" name="dataInicio" id="dataInicio" type="text" value="<?= old('dataInicio') ?>">
                    </div>                                        
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Valor</label>
                        <input class="form-control maskReal" name="valor" id="valor" type="text" value="<?= old('valor', '0,00') ?>">
                    </div>
                <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                    <div class="border-bottom mx-n1 mb-3">
                        <h4 class="px-2">Lista de Controle Presença</h4>
                    </div>
                    <div class="form-row px-2"><div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Descrição</label> 
                            <input class="form-control" name="controlepresenca_descricao" id="controlepresenca_descricao" type="text" maxlength="100" value="<?= old('controlepresenca_descricao') ?>">
                        </div>                        
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label> 
                            <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddControlePresenca">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <table class="table table-striped" id="listTableControlePresenca">
                        <thead>
                            <tr>
                                <th scope="col">Descrição</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody >
                        </tbody>
                    </table>
                    <div class="w-100 text-center msgEmptyListControlePresenca mb-3">
                        <span class="h5">Sem itens selecionados</span>
                    </div>
                </fieldset>
                <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                    <div class="border-bottom mx-n1 mb-3">
                        <h4 class="px-2">Lista de Evento Reserva</h4>
                    </div>
                    <div class="form-row px-2">
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Reserva</label> 
                            <div class="input-group mb-3">
                                <input class="form-control" name="eventoreserva_Reserva_id_Text" id="eventoreserva_Reserva_id_Text" type="text" disabled="true" onclick="$('#addonSearcheventoreserva_Reserva_id').click()" value="<?= old('eventoreserva_Reserva_id_Text'); ?>"/>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="addonSearcheventoreserva_Reserva_id" 
                                            data-toggle="modal" data-target="#modalFK" data-title='Localizar >Reserva'
                                            data-url-search='<?PHP echo base_url('Reserva/pesquisaModal?searchTerm='); ?>' data-input-result='eventoreserva_Reserva_id' data-input-text='eventoreserva_Reserva_id_Text' >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                        </svg>
                                    </button>
                                </div>
                                <input class="d-none" name="eventoreserva_Reserva_id" id="eventoreserva_Reserva_id" type="text" value="<?= old('eventoreserva_Reserva_id'); ?>" />
                            </div>
                        </div>                        
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label> 
                            <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddEventoReserva">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <table class="table table-striped" id="listTableEventoReserva">
                        <thead>
                            <tr>
                                <th scope="col">Reserva</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody >
                        </tbody>
                    </table>
                    <div class="w-100 text-center msgEmptyListEventoReserva mb-3">
                        <span class="h5">Sem itens selecionados</span>
                    </div>
                </fieldset>
                <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                    <div class="border-bottom mx-n1 mb-3">
                        <h4 class="px-2">Lista de Participante Evento</h4>
                    </div>
                    <div class="form-row px-2">
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Participante</label> 
                            <div class="input-group mb-3">
                                <input class="form-control" name="participanteevento_Participante_id_Text" id="participanteevento_Participante_id_Text" type="text" disabled="true" onclick="$('#addonSearchparticipanteevento_Participante_id').click()" value="<?= old('participanteevento_Participante_id_Text'); ?>"/>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="addonSearchparticipanteevento_Participante_id" 
                                            data-toggle="modal" data-target="#modalFK" data-title='Localizar >Participante'
                                            data-url-search='<?PHP echo base_url('Participante/pesquisaModal?searchTerm='); ?>' data-input-result='participanteevento_Participante_id' data-input-text='participanteevento_Participante_id_Text' >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                        </svg>
                                    </button>
                                </div>
                                <input class="d-none" name="participanteevento_Participante_id" id="participanteevento_Participante_id" type="text" value="<?= old('participanteevento_Participante_id'); ?>" />
                            </div>
                        </div>                        
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label> 
                            <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddParticipanteEvento">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <table class="table table-striped" id="listTableParticipanteEvento">
                        <thead>
                            <tr>
                                <th scope="col">Participante</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody >
                        </tbody>
                    </table>
                    <div class="w-100 text-center msgEmptyListParticipanteEvento mb-3">
                        <span class="h5">Sem itens selecionados</span>
                    </div>
                </fieldset>
                <div class="form-group mb-0 mt-3 text-center col-12">
                    <button type="submit" class="btn btn-primary submitButton">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="templateRowControlePresenca">
    <tr id='ControlePresenca_{_index_}'>
        <td><input type="text" class="form-control ignoreValidate" name="ControlePresenca[{_index_}][descricao]" readonly="true" value="{_descricao_}" /></td>
        <td>
            <div class="btn btn-danger btnExcluirControlePresenca" onclick="$('#ControlePresenca_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>
            </div>
        </td>
    </tr>
</template>
<template id="templateRowEventoReserva">
    <tr id='EventoReserva_{_index_}'>
        <td>
            <input type="hidden" class="form-control ignoreValidate fkReserva_idEventoReserva" name="EventoReserva[{_index_}][Reserva_id]" readonly="true" value="{_Reserva_id_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_Reserva_id_Text_}" />
        </td>
        <td>
            <div class="btn btn-danger btnExcluirEventoReserva" onclick="$('#EventoReserva_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>
            </div>
        </td>
    </tr>
</template>
<template id="templateRowParticipanteEvento">
    <tr id='ParticipanteEvento_{_index_}'>
        <td>
            <input type="hidden" class="form-control ignoreValidate fkParticipante_idParticipanteEvento" name="ParticipanteEvento[{_index_}][Participante_id]" readonly="true" value="{_Participante_id_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_Participante_id_Text_}" />
        </td>
        <td>
            <div class="btn btn-danger btnExcluirParticipanteEvento" onclick="$('#ParticipanteEvento_{_index_}').remove();">
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
            enableValidationFieldsFK();
        },
        errorElement: "div",
        ignore: '.ignoreValidate',
        rules: {
            nome: {
                required: true,
            },
            texto: {
                required: true,
            },
            descricao: {
                required: true,
            },
            vagasLimitadas: {
                required: true,
            },
            numeroVagas: {
                inteiro: true,
            },
            inscricoesAbertas: {
                required: true,
            },
            divulgar: {
                required: true,
            },
            dataInicio: {
                required: true,
                dataBR: true,
            },
            valor: {
                real: true,
                normalizer: function(value) {
                    if (value.includes(',')) {
                        return value.replaceAll('.', '').replace(',', '.');
                    }
                    return value;
                },
            },
            controlepresenca_descricao: {
                required: true,
            },
            eventoreserva_Reserva_id: {
                required: true,
            },
            participanteevento_Participante_id: {
                required: true,
            },
        }
    });

    var inputsControlePresenca = [
        'controlepresenca_descricao',
    ];
    
    $('#btnAddControlePresenca').on('click', function (e) {
        addControlePresenca();
    });

    var inputsEventoReserva = [
        'eventoreserva_Reserva_id',
    ];
    
    $('#btnAddEventoReserva').on('click', function (e) {
        addEventoReserva();
    });

    var inputsParticipanteEvento = [
        'participanteevento_Participante_id',
    ];
    
    $('#btnAddParticipanteEvento').on('click', function (e) {
        addParticipanteEvento();
    });

    function disableValidationFieldsFK() {
        for (var i in inputsControlePresenca) {
            $('#' + inputsControlePresenca[i]).addClass('ignoreValidate');
        }
        for (var i in inputsEventoReserva) {
            $('#' + inputsEventoReserva[i]).addClass('ignoreValidate');
        }
        for (var i in inputsParticipanteEvento) {
            $('#' + inputsParticipanteEvento[i]).addClass('ignoreValidate');
        }
    }

    function enableValidationFieldsFK() {
        for (var i in inputsControlePresenca) {
            $('#' + inputsControlePresenca[i]).removeClass('ignoreValidate');
        }
        for (var i in inputsEventoReserva) {
            $('#' + inputsEventoReserva[i]).removeClass('ignoreValidate');
        }
        for (var i in inputsParticipanteEvento) {
            $('#' + inputsParticipanteEvento[i]).removeClass('ignoreValidate');
        }
    }

    var indexRowControlePresenca = 0;
    function addControlePresenca() {
        $('.msgEmptyListControlePresenca').addClass('d-none');
        //$('#listTableControlePresenca').removeClass('d-none');
        let error = false;
        for (var i in inputsControlePresenca) {
            if (!$('#' + inputsControlePresenca[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        let html = $('#templateRowControlePresenca').html();
        html = html.replaceAll('{_index_}', indexRowControlePresenca);
        html = html.replaceAll('{_descricao_}', $('#controlepresenca_descricao').val());
        $('#listTableControlePresenca tbody').append(html);

        $('#controlepresenca_descricao').val('');
        indexRowControlePresenca++;
    }

    var indexRowEventoReserva = 0;
    function addEventoReserva() {
        $('.msgEmptyListEventoReserva').addClass('d-none');
        //$('#listTableEventoReserva').removeClass('d-none');
        let error = false;
        for (var i in inputsEventoReserva) {
            if (!$('#' + inputsEventoReserva[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        let html = $('#templateRowEventoReserva').html();
        html = html.replaceAll('{_index_}', indexRowEventoReserva);
        html = html.replaceAll('{_Reserva_id_}', $('#eventoreserva_Reserva_id').val());
        html = html.replaceAll('{_Reserva_id_Text_}', $('#eventoreserva_Reserva_id_Text').val());
        $('#listTableEventoReserva tbody').append(html);

        $('#eventoreserva_Reserva_id').val('');
        $('#eventoreserva_Reserva_id_Text').val('');
        indexRowEventoReserva++;
    }

    var indexRowParticipanteEvento = 0;
    function addParticipanteEvento() {
        $('.msgEmptyListParticipanteEvento').addClass('d-none');
        //$('#listTableParticipanteEvento').removeClass('d-none');
        let error = false;
        for (var i in inputsParticipanteEvento) {
            if (!$('#' + inputsParticipanteEvento[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        let html = $('#templateRowParticipanteEvento').html();
        html = html.replaceAll('{_index_}', indexRowParticipanteEvento);
        html = html.replaceAll('{_Participante_id_}', $('#participanteevento_Participante_id').val());
        html = html.replaceAll('{_Participante_id_Text_}', $('#participanteevento_Participante_id_Text').val());
        $('#listTableParticipanteEvento tbody').append(html);

        $('#participanteevento_Participante_id').val('');
        $('#participanteevento_Participante_id_Text').val('');
        indexRowParticipanteEvento++;
    }
</script>    
<?= $this->endSection('scripts'); ?>
