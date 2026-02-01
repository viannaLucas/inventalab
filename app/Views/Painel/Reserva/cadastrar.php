<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Reserva</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Cadastrar</span>
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
            <form id='formCadastrar' action="<?PHP echo base_url('Reserva/doCadastrar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <p class="col-12">Selecione a data e hora que irá permanecer no InventaLab</p>
                    <!-- <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Cadastro</label> 
                        <input class="form-control maskData" name="dataCadastro" id="dataCadastro" type="text" value="<?= esc(old('dataCadastro'), 'attr') ?>">
                    </div>                     -->
                    <div class="form-group col-12 col-md-4">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Reserva</label>
                        <input class="form-control maskData" name="dataReserva" id="dataReserva" type="text" value="<?= esc(old('dataReserva'), 'attr') ?>">
                    </div>
                    <div class="form-group col-12 col-md-4">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Início</label>
                        <input class="form-control" name="horaInicio" id="horaInicio" type="time" maxlength="10" value="<?= esc(old('horaInicio'), 'attr') ?>">
                    </div>
                    <div class="form-group col-12 col-md-4">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Fim</label>
                        <input class="form-control" name="horaFim" id="horaFim" type="time" maxlength="10" value="<?= esc(old('horaFim'), 'attr') ?>">
                    </div>
                </div>
                <div class="form-row">
                    <p class="col-12">O espaço poderá ser usado por outras pessoas durante o horário da reserva?</p>
                    <div class="form-group col-12 col-md-4">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="tipo">Tipo da Reserva</label>
                        <select class="form-control" name="tipo" id="tipo" required="">
                            <option value="" <?= old('tipo') == '' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\ReservaEntity::_op('tipo') as $k => $op) { ?>
                                <option value="<?= esc($k, 'attr') ?>" <?= old('tipo') === $k ? 'selected' : ''; ?>><?= esc($op) ?></option>
                            <?PHP } ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <p class="col-12">Irá ter mais pessoas acompanhando o Participante?</p>
                    <div class="form-group col-12 col-md-4">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Possui Convidados</label>
                        <select class="form-control" id="possuiConvidado">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-4">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Número Convidados</label>
                        <input class="form-control maskInteiro" name="numeroConvidados" id="numeroConvidados" type="text" value="<?= esc(old('numeroConvidados'), 'attr') ?>">
                    </div>
                    <!-- <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="status">Status</label> 
                        <select class="form-control" name="status" id="status" required="" >
                            <option value="" <?= old('status') == '' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\ReservaEntity::_op('status') as $k => $op) { ?>
                            <option value="<?= esc($k, 'attr') ?>" <?= old('status') === $k ? 'selected' : ''; ?>><?= esc($op) ?></option>
                            <?PHP } ?>
                        </select>
                    </div> -->
                    <p class="col-12">A visita é de alguma instituição de ensino?</p>
                    <div class="form-group col-12 col-md-4">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="turmaEscola">É Uma Turma Escolar?</label>
                        <select class="form-control" name="turmaEscola" id="turmaEscola" required="">
                            <option value="" <?= old('turmaEscola') == '' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\ReservaEntity::_op('turmaEscola') as $k => $op) { ?>
                                <option value="<?= esc($k, 'attr') ?>" <?= old('turmaEscola') === $k ? 'selected' : ''; ?>><?= esc($op) ?></option>
                            <?PHP } ?>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-4">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome Escola</label>
                        <input class="form-control" name="nomeEscola" id="nomeEscola" type="text" maxlength="250" value="<?= esc(old('nomeEscola'), 'attr') ?>">
                    </div>
                    <div class="form-group col-12 col-md-4">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="anoTurma">Ano Turma</label>
                        <select class="form-control" name="anoTurma" id="anoTurma" required="">
                            <option value="" <?= old('anoTurma') == '' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\ReservaEntity::_op('anoTurma') as $k => $op) { ?>
                                <option value="<?= esc($k, 'attr') ?>" <?= old('anoTurma') === $k ? 'selected' : ''; ?>><?= esc($op) ?></option>
                            <?PHP } ?>
                        </select>
                    </div>
                    <!-- <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Ano Turma</label> 
                        <input class="form-control" name="anoTurma" id="anoTurma" type="text" maxlength="10" value="<?= esc(old('anoTurma'), 'attr') ?>">
                    </div> -->
                    <!-- <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Entrada</label> 
                        <input class="form-control" name="horaEntrada" id="horaEntrada" type="text" maxlength="" value="<?= esc(old('horaEntrada'), 'attr') ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Saída</label> 
                        <input class="form-control" name="horaSaida" id="horaSaida" type="text" maxlength="" value="<?= esc(old('horaSaida'), 'attr') ?>">
                    </div> -->
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <div class="border-bottom mx-n1 mb-3">
                            <h4 class="px-2">Lista de Atividade Livre</h4>
                        </div>
                        <div class="form-row px-2">
                            <div class="form-group col-12 ">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Descrição</label>
                                <textarea name="atividadelivre_descricao" id="atividadelivre_descricao" class="form-control" placeholder="" rows="3"><?= esc(old('atividadelivre_descricao')) ?></textarea>
                            </div>
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label>
                                <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddAtividadeLivre">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <table class="table table-striped" id="listTableAtividadeLivre">
                            <thead>
                                <tr>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="w-100 text-center msgEmptyListAtividadeLivre mb-3">
                            <span class="h5">Sem itens selecionados</span>
                        </div>
                    </fieldset>
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <div class="border-bottom mx-n1 mb-3">
                            <h4 class="px-2">Lista de Evento Reserva</h4>
                        </div>
                        <div class="form-row px-2">
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Evento</label>
                                <div class="input-group mb-3">
                                    <input class="form-control" name="eventoreserva_Evento_id_Text" id="eventoreserva_Evento_id_Text" type="text" disabled="true" onclick="$('#addonSearcheventoreserva_Evento_id').click()" value="<?= esc(old('eventoreserva_Evento_id_Text'), 'attr') ?>" />
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="addonSearcheventoreserva_Evento_id"
                                            data-toggle="modal" data-target="#modalFK" data-title='Localizar >Evento'
                                            data-url-search='<?PHP echo base_url('Evento/pesquisaModal?searchTerm='); ?>' data-input-result='eventoreserva_Evento_id' data-input-text='eventoreserva_Evento_id_Text'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input class="d-none" name="eventoreserva_Evento_id" id="eventoreserva_Evento_id" type="text" value="<?= esc(old('eventoreserva_Evento_id'), 'attr') ?>" />
                                </div>
                            </div>
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label>
                                <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddEventoReserva">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <table class="table table-striped" id="listTableEventoReserva">
                            <thead>
                                <tr>
                                    <th scope="col">Evento</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="w-100 text-center msgEmptyListEventoReserva mb-3">
                            <span class="h5">Sem itens selecionados</span>
                        </div>
                    </fieldset>
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <div class="border-bottom mx-n1 mb-3">
                            <h4 class="px-2">Lista de Oficina Temática Reserva</h4>
                        </div>
                        <div class="form-row px-2">
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Oficina Temática</label>
                                <div class="input-group mb-3">
                                    <input class="form-control" name="oficinatematicareserva_OficinaTematica_id_Text" id="oficinatematicareserva_OficinaTematica_id_Text" type="text" disabled="true" onclick="$('#addonSearchoficinatematicareserva_OficinaTematica_id').click()" value="<?= esc(old('oficinatematicareserva_OficinaTematica_id_Text'), 'attr') ?>" />
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="addonSearchoficinatematicareserva_OficinaTematica_id"
                                            data-toggle="modal" data-target="#modalFK" data-title='Localizar >Oficina Temática'
                                            data-url-search='<?PHP echo base_url('OficinaTematica/pesquisaModal?searchTerm='); ?>' data-input-result='oficinatematicareserva_OficinaTematica_id' data-input-text='oficinatematicareserva_OficinaTematica_id_Text'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input class="d-none" name="oficinatematicareserva_OficinaTematica_id" id="oficinatematicareserva_OficinaTematica_id" type="text" value="<?= esc(old('oficinatematicareserva_OficinaTematica_id'), 'attr') ?>" />
                                </div>
                            </div>
                            <div class="form-group col-12 ">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Observação</label>
                                <textarea name="oficinatematicareserva_observacao" id="oficinatematicareserva_observacao" class="form-control" placeholder="" rows="3"><?= esc(old('oficinatematicareserva_observacao')) ?></textarea>
                            </div>
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label>
                                <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddOficinaTematicaReserva">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <table class="table table-striped" id="listTableOficinaTematicaReserva">
                            <thead>
                                <tr>
                                    <th scope="col">Oficina Temática</th>
                                    <th scope="col">Observação</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="w-100 text-center msgEmptyListOficinaTematicaReserva mb-3">
                            <span class="h5">Sem itens selecionados</span>
                        </div>
                    </fieldset>
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <div class="border-bottom mx-n1 mb-3">
                            <h4 class="px-2">Lista de Reserva Participante</h4>
                        </div>
                        <div class="form-row px-2">
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Participante</label>
                                <div class="input-group mb-3">
                                    <input class="form-control" name="reservaparticipante_Participante_id_Text" id="reservaparticipante_Participante_id_Text" type="text" disabled="true" onclick="$('#addonSearchreservaparticipante_Participante_id').click()" value="<?= esc(old('reservaparticipante_Participante_id_Text'), 'attr') ?>" />
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="addonSearchreservaparticipante_Participante_id"
                                            data-toggle="modal" data-target="#modalFK" data-title='Localizar >Participante'
                                            data-url-search='<?PHP echo base_url('Participante/pesquisaModal?searchTerm='); ?>' data-input-result='reservaparticipante_Participante_id' data-input-text='reservaparticipante_Participante_id_Text'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input class="d-none" name="reservaparticipante_Participante_id" id="reservaparticipante_Participante_id" type="text" value="<?= esc(old('reservaparticipante_Participante_id'), 'attr') ?>" />
                                </div>
                            </div>
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label>
                                <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddReservaParticipante">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <table class="table table-striped" id="listTableReservaParticipante">
                            <thead>
                                <tr>
                                    <th scope="col">Participante</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="w-100 text-center msgEmptyListReservaParticipante mb-3">
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

<template id="templateRowAtividadeLivre">
    <tr id='AtividadeLivre_{_index_}'>
        <td><input type="text" class="form-control ignoreValidate" name="AtividadeLivre[{_index_}][descricao]" readonly="true" value="{_descricao_}" /></td>
        <td>
            <div class="btn btn-danger btnExcluirAtividadeLivre" onclick="$('#AtividadeLivre_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                </svg>
            </div>
        </td>
    </tr>
</template>
<template id="templateRowEventoReserva">
    <tr id='EventoReserva_{_index_}'>
        <td>
            <input type="hidden" class="form-control ignoreValidate fkEvento_idEventoReserva" name="EventoReserva[{_index_}][Evento_id]" readonly="true" value="{_Evento_id_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_Evento_id_Text_}" />
        </td>
        <td>
            <div class="btn btn-danger btnExcluirEventoReserva" onclick="$('#EventoReserva_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                </svg>
            </div>
        </td>
    </tr>
</template>
<template id="templateRowOficinaTematicaReserva">
    <tr id='OficinaTematicaReserva_{_index_}'>
        <td>
            <input type="hidden" class="form-control ignoreValidate fkOficinaTematica_idOficinaTematicaReserva" name="OficinaTematicaReserva[{_index_}][OficinaTematica_id]" readonly="true" value="{_OficinaTematica_id_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_OficinaTematica_id_Text_}" />
        </td>
        <td><input type="text" class="form-control ignoreValidate" name="OficinaTematicaReserva[{_index_}][observacao]" readonly="true" value="{_observacao_}" /></td>
        <td>
            <div class="btn btn-danger btnExcluirOficinaTematicaReserva" onclick="$('#OficinaTematicaReserva_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                </svg>
            </div>
        </td>
    </tr>
</template>
<template id="templateRowReservaParticipante">
    <tr id='ReservaParticipante_{_index_}'>
        <td>
            <input type="hidden" class="form-control ignoreValidate fkParticipante_idReservaParticipante" name="ReservaParticipante[{_index_}][Participante_id]" readonly="true" value="{_Participante_id_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_Participante_id_Text_}" />
        </td>
        <td>
            <div class="btn btn-danger btnExcluirReservaParticipante" onclick="$('#ReservaParticipante_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                </svg>
            </div>
        </td>
    </tr>
</template>
<!-- content closed -->
<?= $this->endSection('content'); ?><?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?><?= $this->section('scripts'); ?>
<script>
    $('.submitButton').on('click', function(e) {
        //$(this).attr('disabled', true);
        disableValidationFieldsFK();
    });
    var validator = $("#formCadastrar").validate({
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            error.appendTo(element.parent());
        },
        highlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        onfocusout: function(element) {
            if (!this.checkable(element)) {
                this.element(element);
            }
        },
        invalidHandler: function(event, validator) {
            $('.submitButton').attr('disabled', false);
            enableValidationFieldsFK();
        },
        errorElement: "div",
        ignore: '.ignoreValidate',
        rules: {
            dataCadastro: {
                required: true,
                dataBR: true,
            },
            dataReserva: {
                required: true,
                dataBR: true,
            },
            horaInicio: {
                required: true,
            },
            horaFim: {
                required: true,
            },
            tipo: {
                required: true,
            },
            numeroConvidados: {
                required: true,
                inteiro: true,
            },
            status: {
                required: true,
            },
            turmaEscola: {
                required: true,
            },
            nomeEscola: {
                required: true,
            },
            anoTurma: {
                required: true,
            },
            horaEntrada: {
                required: true,
            },
            horaSaida: {
                required: true,
            },
            atividadelivre_descricao: {
                required: true,
            },
            eventoreserva_Evento_id: {
                required: true,
            },
            oficinatematicareserva_OficinaTematica_id: {
                required: true,
            },
            oficinatematicareserva_observacao: {

            },
            reservaparticipante_Participante_id: {
                required: true,
            },
        }
    });

    var inputsAtividadeLivre = [
        'atividadelivre_descricao',
    ];

    $('#btnAddAtividadeLivre').on('click', function(e) {
        addAtividadeLivre();
    });

    var inputsEventoReserva = [
        'eventoreserva_Evento_id',
    ];

    $('#btnAddEventoReserva').on('click', function(e) {
        addEventoReserva();
    });

    var inputsOficinaTematicaReserva = [
        'oficinatematicareserva_OficinaTematica_id',
        'oficinatematicareserva_observacao',
    ];

    $('#btnAddOficinaTematicaReserva').on('click', function(e) {
        addOficinaTematicaReserva();
    });

    var inputsReservaParticipante = [
        'reservaparticipante_Participante_id',
    ];

    $('#btnAddReservaParticipante').on('click', function(e) {
        addReservaParticipante();
    });

    function disableValidationFieldsFK() {
        for (var i in inputsAtividadeLivre) {
            $('#' + inputsAtividadeLivre[i]).addClass('ignoreValidate');
        }
        for (var i in inputsEventoReserva) {
            $('#' + inputsEventoReserva[i]).addClass('ignoreValidate');
        }
        for (var i in inputsOficinaTematicaReserva) {
            $('#' + inputsOficinaTematicaReserva[i]).addClass('ignoreValidate');
        }
        for (var i in inputsReservaParticipante) {
            $('#' + inputsReservaParticipante[i]).addClass('ignoreValidate');
        }
    }

    function enableValidationFieldsFK() {
        for (var i in inputsAtividadeLivre) {
            $('#' + inputsAtividadeLivre[i]).removeClass('ignoreValidate');
        }
        for (var i in inputsEventoReserva) {
            $('#' + inputsEventoReserva[i]).removeClass('ignoreValidate');
        }
        for (var i in inputsOficinaTematicaReserva) {
            $('#' + inputsOficinaTematicaReserva[i]).removeClass('ignoreValidate');
        }
        for (var i in inputsReservaParticipante) {
            $('#' + inputsReservaParticipante[i]).removeClass('ignoreValidate');
        }
    }

    var indexRowAtividadeLivre = 0;

    function addAtividadeLivre() {
        $('.msgEmptyListAtividadeLivre').addClass('d-none');
        //$('#listTableAtividadeLivre').removeClass('d-none');
        let error = false;
        for (var i in inputsAtividadeLivre) {
            if (!$('#' + inputsAtividadeLivre[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        let html = $('#templateRowAtividadeLivre').html();
        html = html.replaceAll('{_index_}', indexRowAtividadeLivre);
        html = html.replaceAll('{_descricao_}', $('#atividadelivre_descricao').val());
        $('#listTableAtividadeLivre tbody').append(html);

        $('#atividadelivre_descricao').val('');
        indexRowAtividadeLivre++;
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
        html = html.replaceAll('{_Evento_id_}', $('#eventoreserva_Evento_id').val());
        html = html.replaceAll('{_Evento_id_Text_}', $('#eventoreserva_Evento_id_Text').val());
        $('#listTableEventoReserva tbody').append(html);

        $('#eventoreserva_Evento_id').val('');
        $('#eventoreserva_Evento_id_Text').val('');
        indexRowEventoReserva++;
    }

    var indexRowOficinaTematicaReserva = 0;

    function addOficinaTematicaReserva() {
        $('.msgEmptyListOficinaTematicaReserva').addClass('d-none');
        //$('#listTableOficinaTematicaReserva').removeClass('d-none');
        let error = false;
        for (var i in inputsOficinaTematicaReserva) {
            if (!$('#' + inputsOficinaTematicaReserva[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        let html = $('#templateRowOficinaTematicaReserva').html();
        html = html.replaceAll('{_index_}', indexRowOficinaTematicaReserva);
        html = html.replaceAll('{_OficinaTematica_id_}', $('#oficinatematicareserva_OficinaTematica_id').val());
        html = html.replaceAll('{_OficinaTematica_id_Text_}', $('#oficinatematicareserva_OficinaTematica_id_Text').val());
        html = html.replaceAll('{_observacao_}', $('#oficinatematicareserva_observacao').val());
        $('#listTableOficinaTematicaReserva tbody').append(html);

        $('#oficinatematicareserva_OficinaTematica_id').val('');
        $('#oficinatematicareserva_OficinaTematica_id_Text').val('');
        $('#oficinatematicareserva_observacao').val('');
        indexRowOficinaTematicaReserva++;
    }

    var indexRowReservaParticipante = 0;

    function addReservaParticipante() {
        $('.msgEmptyListReservaParticipante').addClass('d-none');
        //$('#listTableReservaParticipante').removeClass('d-none');
        let error = false;
        for (var i in inputsReservaParticipante) {
            if (!$('#' + inputsReservaParticipante[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        let html = $('#templateRowReservaParticipante').html();
        html = html.replaceAll('{_index_}', indexRowReservaParticipante);
        html = html.replaceAll('{_Participante_id_}', $('#reservaparticipante_Participante_id').val());
        html = html.replaceAll('{_Participante_id_Text_}', $('#reservaparticipante_Participante_id_Text').val());
        $('#listTableReservaParticipante tbody').append(html);

        $('#reservaparticipante_Participante_id').val('');
        $('#reservaparticipante_Participante_id_Text').val('');
        indexRowReservaParticipante++;
    }
</script>
<?= $this->endSection('scripts'); ?>