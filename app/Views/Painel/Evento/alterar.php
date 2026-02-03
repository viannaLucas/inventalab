<?php
$eventoValorRaw = is_scalar($evento->valor ?? null) ? (string)$evento->valor : '0';
$eventoValorNormalizado = str_replace(['.', ','], ['', '.'], $eventoValorRaw);
$eventoValor = is_numeric($eventoValorNormalizado) ? (float)$eventoValorNormalizado : 0.0;
?>
<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Evento</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Alterar</span>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="pr-1 mb-xl-0">
            <a href="<?= esc(base_url('Evento/controlePresenca/' . $evento->id), 'attr') ?>" class="btn btn-secondary">Definir Presença</a>
        </div>
        <div class="pr-1 mb-xl-0">
            <a href="<?= esc(base_url('Evento/imprimirListaPresenca/' . $evento->id), 'attr') ?>" class="btn btn-secondary">Imprimir Lista Presença</a>
        </div>
        <div class="pr-1 mb-xl-0">
            <a href="<?= esc(base_url('Evento/imprimirEntregaMaterial/' . $evento->id), 'attr') ?>" class="btn btn-secondary">Imprimir Lista Material</a>
        </div>
        <div class="pr-1 mb-xl-0">
            <a href="<?= esc(base_url('Evento/exportarListaParticipante/' . $evento->id), 'attr') ?>" class="btn btn-secondary">Exportar Participantes</a>
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
            <form id='formAlterar' action="<?PHP echo base_url('Evento/doAlterar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= esc($evento->id, 'attr') ?>" />
                <div class="row">
                    <div class="form-group col-12 col-md-12">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label>
                        <input class="form-control" name="nome" id="nome" type="text" maxlength="150" value="<?= esc($evento->nome, 'attr') ?>">
                    </div>
                    <div class="form-group col-12 ">
                        <label>Imagem <?PHP if($evento->imagem != '') { ?>
                            <a class="btn btn-sm btn-primary ml-3" href="<?= esc(base_url($evento->imagem), 'attr') ?>" target="_blank">Fazer Download</a>
                            <?PHP } ?>
                        </label>
                        <input type="file" class="dropify" id="imagem" name="imagem" accept=".jpg,.jpeg,.webp,.png"
                               data-default-file="<?= esc($evento->imagem != '' ? base_url($evento->imagem) : '', 'attr') ?>"
                               data-allowed-file-extensions="webp png jpeg jpg" data-max-file-size="10M" >
                    </div>
                    <div class="form-group col-12">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Descrição</label>
                        <textarea name="descricao" id="descricao" class="form-control" placeholder="" rows="3"><?= esc($evento->descricao) ?></textarea>
                        <small class="form-text text-muted">Uma breve descrição de um parágrafo sobre o evento.</small>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="vagasLimitadas">Vagas Limitadas</label>
                        <select class="form-control" name="vagasLimitadas" id="vagasLimitadas" required="">
                            <option value="" <?= (string)$evento->vagasLimitadas === '' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\EventoEntity::_op('vagasLimitadas') as $k => $op) { ?>
                                <option value="<?= esc($k, 'attr') ?>" <?= (string)$evento->vagasLimitadas === (string)$k ? 'selected' : ''; ?>><?= esc($op) ?></option>
                            <?PHP } ?>
                        </select>
                        <small class="form-text text-muted">Definir se é um evento com vagas limitadas como curso, ou se é um evento de acesso livre como amostras e exposições.</small>
                    </div>
                    <div class="form-group col-12 col-md-6 <?= (string)$evento->vagasLimitadas === '1' ? '' : 'd-none'; ?>" id="numeroVagasGroup">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Número Vagas</label>
                        <input class="form-control maskInteiro" name="numeroVagas" id="numeroVagas" type="text" value="<?= esc($evento->numeroVagas, 'attr') ?>" <?= (string)$evento->vagasLimitadas === '1' ? 'required' : ''; ?>>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="inscricoesAbertas">Inscrições Abertas</label>
                        <select class="form-control" name="inscricoesAbertas" id="inscricoesAbertas" required="">
                            <option value="" <?= (string)$evento->inscricoesAbertas === '' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\EventoEntity::_op('inscricoesAbertas') as $k => $op) { ?>
                                <option value="<?= esc($k, 'attr') ?>" <?= (string)$evento->inscricoesAbertas === (string)$k ? 'selected' : ''; ?>><?= esc($op) ?></option>
                            <?PHP } ?>
                        </select>
                        <small class="form-text text-muted">Inscrições podem ser realizadas pelo próprio Participante ou apenas por administradores e monitores.</small>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="divulgar">Divulgar</label>
                        <select class="form-control" name="divulgar" id="divulgar" required="">
                            <option value="" <?= (string)$evento->divulgar === '' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\EventoEntity::_op('divulgar') as $k => $op) { ?>
                                <option value="<?= esc($k, 'attr') ?>" <?= (string)$evento->divulgar === (string)$k ? 'selected' : ''; ?>><?= esc($op) ?></option>
                            <?PHP } ?>
                        </select>
                        <small class="form-text text-muted">Evento será divulgado na página principal, tornando as infirmações públicas na página principal.</small>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Início</label>
                        <input class="form-control maskData" name="dataInicio" id="dataInicio" type="text" value="<?= esc($evento->dataInicio, 'attr') ?>">
                        <small class="form-text text-muted">Data do primeiro dia do evento.</small>
                    </div>
                    <div class="form-group col-12 col-md-12">
                        Financeiro
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Valor</label>
                        <input class="form-control maskReal" name="valor" id="valor" type="text" value="<?= esc($evento->valor, 'attr') ?>">
                        <small class="form-text text-muted">Valor de inscrição para cada participate, deixe com valor 0,00 para sem cobrança.</small>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Serviço</label>
                        <div class="input-group">
                            <input class="form-control" name="Servico_id_Text" id="Servico_id_Text" type="text" disabled="true" onclick="$('#addonSearchServico_id').click()" value="<?= esc($evento->getServico()->Nome, 'attr') ?>"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="addonSearchServico_id"
                                    data-toggle="modal" data-target="#modalFK" data-title='Localizar Serviço'
                                    data-url-search='<?PHP echo base_url('Servico/pesquisaModal?searchTerm='); ?>' data-input-result='Servico_id' data-input-text='Servico_id_Text'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <input class="d-none" name="Servico_id" id="Servico_id" type="text" value="<?= esc($evento->Servico_id, 'attr') ?>" />
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Informações do evento</label>
                        <small class="form-text text-muted">Texto com as informações do evento, quando evento for público será apresentado na página principal.</small>
                        <textarea name="texto" id="texto" class="form-control summernote"><?= esc($evento->texto) ?></textarea>
                    </div>
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <a id="listaReservas"></a>
                        <div class="border-bottom mx-n1 mb-3" >
                            <h4 class="px-2">Reservas do Espaço</h4>
                            <p class="px-3 text-muted">Cadastre cada período em que o evento ocupará o espaço físico. É possível adicionar mais de um dia, inclusive com horários distintos.</p>
                        </div>
                        <div class="form-row px-2 align-items-end">
                            <div class="form-group col-sm-3 col-12">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600" for="reservaespaco_data">Data</label>
                                <input class="form-control maskData" name="reservaespaco_data" id="reservaespaco_data" type="text" value="<?= esc(old('reservaespaco_data'), 'attr') ?>">
                            </div>
                            <div class="form-group col-sm-2 col-12">
                                <div class="form-check mt-sm-4 pt-sm-2">
                                    <input class="form-check-input" type="checkbox" id="reservaespaco_diaInteiro">
                                    <label class="form-check-label" for="reservaespaco_diaInteiro">Dia inteiro</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-2 col-12">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600" for="reservaespaco_horaInicio">Hora Início</label>
                                <input class="form-control" name="reservaespaco_horaInicio" id="reservaespaco_horaInicio" type="time" value="<?= esc(old('reservaespaco_horaInicio'), 'attr') ?>">
                            </div>
                            <div class="form-group col-sm-2 col-12">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600" for="reservaespaco_horaFim">Hora Fim</label>
                                <input class="form-control" name="reservaespaco_horaFim" id="reservaespaco_horaFim" type="time" value="<?= esc(old('reservaespaco_horaFim'), 'attr') ?>">
                            </div>
                            <div class="form-group col-sm-auto col-12">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600 d-block">&nbsp;</label>
                                <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddReservaEspaco">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <table class="table table-striped" id="listTableReservaEspaco">
                            <thead>
                                <tr>
                                    <th scope="col">Data</th>
                                    <th scope="col">Hora Início</th>
                                    <th scope="col">Hora Fim</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="w-100 text-center msgEmptyListReservaEspaco mb-3">
                            <span class="h5">Sem itens selecionados</span>
                        </div>
                    </fieldset>
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <div class="border-bottom mx-n1 mb-3">
                            <h4 id="controlePresenca" class="px-2">Lista de Controle Presença</h4>
                            <p class="px-3 text-muted">Em eventos com vagas limitadas, há a possibilidade de criar listas de presença.Cada lista conterá os nomes dos participantes. Há a possibilidade de ser mais de uma lista em casos como o evento necessite ter um controle de presença em diferentes turnos, como por exemplo "Manhã e Tarde" ou ainda "Primeiro Dia e Segundo Dia" </p>
                        </div>
                        <div class="form-row px-2">
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Descrição</label>
                                <input class="form-control" name="controlepresenca_descricao" id="controlepresenca_descricao" type="text" maxlength="100" value="">
                                <small class="form-text text-muted">Ex.: Manhã, Tarde, Dia 1</small>
                            </div>
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label>
                                <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddControlePresenca">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
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
                            <tbody>
                            </tbody>
                        </table>
                        <div class="w-100 text-center msgEmptyListControlePresenca mb-3">
                            <span class="h5">Sem itens selecionados</span>
                        </div>
                    </fieldset>
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <div class="border-bottom mx-n1 mb-3">
                            <h4 class="px-2">Lista de Participante Evento</h4>
                            <p class="px-3 text-muted">Em eventos com vagas limitadas, adicione Participantes para controlar vagas e presença. Pode ser feito após cadastrar o evento com o decorrer das inscrições.</p>
                            <?php if ($eventoValor > 0) { ?>
                                <p class="px-3 text-muted">
                                    Legenda Botão Pagamento:
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                            <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                                            <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                            <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                                        </svg>
                                    <span class="badge badge-warning">Em aberto</span>
                                    <span class="badge badge-success">Pago</span>
                                </p>
                            <?php } ?>
                        </div>
                        <div class="form-row px-2">
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Participante</label>
                                <div class="input-group mb-3">
                                    <input class="form-control" name="participanteevento_Participante_id_Text" id="participanteevento_Participante_id_Text" type="text" disabled="true" onclick="$('#addonSearchparticipanteevento_Participante_id').click()" value="" />
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="addonSearchparticipanteevento_Participante_id"
                                            data-toggle="modal" data-target="#modalFK" data-title='Localizar >Participante'
                                            data-url-search='<?PHP echo base_url('Participante/pesquisaModal?searchTerm='); ?>' data-input-result='participanteevento_Participante_id' data-input-text='participanteevento_Participante_id_Text'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input class="d-none" name="participanteevento_Participante_id" id="participanteevento_Participante_id" type="text" value="" />
                                </div>
                            </div>
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label>
                                <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddParticipanteEvento">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
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
                            <tbody>
                            </tbody>
                        </table>
                        <div class="w-100 text-center msgEmptyListParticipanteEvento mb-3">
                            <span class="h5">Sem itens selecionados</span>
                        </div>
                    </fieldset>
                    <div class="form-group mb-0 mt-3 text-center col-12">
                        <button type="submit" class="btn btn-primary submitButton">Alterar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="templateRowControlePresenca">
    <tr id='ControlePresenca_{_index_}'>
        <td>
            <input type="hidden" class="ignoreValidate" name="ControlePresenca[{_index_}][id]" value="{_id_}" />
            <input type="text" class="form-control ignoreValidate" name="ControlePresenca[{_index_}][descricao]" value="{_descricao_}" />
        </td>
        <td>
            <div class="btn btn-danger btnExcluirControlePresenca" onclick="removeControlePresenca('{_index_}');">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                </svg>
            </div>
        </td>
    </tr>
</template>
<template id="templateRowReservaEspaco">
    <tr id='ReservaEspaco_{_index_}'>
        <td>
            <input type="hidden" class="ignoreValidate" name="ReservaEspaco[{_index_}][id]" value="{_id_}" />
            <input type="hidden" class="ignoreValidate" name="ReservaEspaco[{_index_}][data]" value="{_data_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_data_}" />
        </td>
        <td>
            <input type="hidden" class="ignoreValidate" name="ReservaEspaco[{_index_}][horaInicio]" value="{_horaInicio_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_horaInicio_}" />
        </td>
        <td>
            <input type="hidden" class="ignoreValidate" name="ReservaEspaco[{_index_}][horaFim]" value="{_horaFim_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_horaFim_}" />
        </td>
        <td>
            <div class="btn btn-danger btnExcluirReservaEspaco" onclick="removeReservaEspaco('{_index_}');">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
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
            <?php if ($eventoValor > 0) { ?>
                <a class="btn btnAddCobrancaParticipanteEvento {_class_btn_cobranca_} {_class_btn_cobranca_color_}" href="<?= base_url('Evento/cobranca/') ?>{_id_}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                    </svg>
                </a>
            <?php } ?>
            <div class="btn btn-danger btnExcluirParticipanteEvento {_class_btn_excluir_}" onclick="$('#ParticipanteEvento_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                </svg>
            </div>
        </td>
    </tr>
</template>

<div class="modal" id="modalErroRuntime">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block ml-1"></i>
                <h4 class="tx-danger mg-b-20">Erro!</h4>
                <p class="mg-b-20 mg-x-20" id="modalErroMensagem"></p>
                <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-dismiss="modal" type="button">Continue</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalSucessoRuntime">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                <i class="icon ion-ios-checkmark-circle-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="tx-success tx-semibold mg-b-20">Sucesso!</h4>
                <p class="mg-b-20 mg-x-20" id="modalSucessoMensagem"></p>
                <button aria-label="Close" class="btn ripple btn-success pd-x-25" data-dismiss="modal" type="button">Continue</button>
            </div>
        </div>
    </div>
</div>
<!-- content closed -->
<?= $this->endSection('content'); ?><?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?><?= $this->section('scripts'); ?>
<script>
    function formatModalMessage(message) {
        if (typeof message !== 'string') {
            return '';
        }
        return message.split('\n').map(function(line) {
            return $('<div>').text(line).html();
        }).join('<br>');
    }

    function alertSuccess(message) {
        $('#modalSucessoMensagem').html(formatModalMessage(message));
        $('#modalSucessoRuntime').modal('show');
    }

    function alertaError(message) {
        $('#modalErroMensagem').html(formatModalMessage(message));
        $('#modalErroRuntime').modal('show');
    }

    $('.submitButton').on('click', function(e) {
        //$(this).attr('disabled', true);
        disableValidationFieldsFK();
    });
    var validator = $("#formAlterar").validate({
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
            nome: {
                required: true,
            },
            imagem: {
                arquivo: 'webp|jpg|jpeg|png',
            },
            texto: {
                required: true,
            },
            descricao: {
                required: true,
            },
            Servico_id: {
                required: true,
            },
            vagasLimitadas: {
                required: true,
            },
            numeroVagas: {
                required: {
                    depends: function() {
                        return $('#vagasLimitadas').val() === '1';
                    }
                },
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
            reservaespaco_data: {
                required: true,
                dataBR: true,
            },
            reservaespaco_horaInicio: {
                required: {
                    depends: function() {
                        return !$('#reservaespaco_diaInteiro').is(':checked');
                    }
                },
            },
            reservaespaco_horaFim: {
                required: {
                    depends: function() {
                        return !$('#reservaespaco_diaInteiro').is(':checked');
                    }
                },
            },
            controlepresenca_descricao: {
                required: true,
            },
            participanteevento_Participante_id: {
                required: true,
            },
        },
        submitHandler: function(form, event) {
            if (event && typeof event.preventDefault === 'function') {
                event.preventDefault();
            }
            disableValidationFieldsFK();
            var $submitButtons = $('.submitButton');
            $submitButtons.attr('disabled', true);
            verificarDataHoraReservas()
                .then(function(result) {
                    if (result && result.ok) {
                        form.submit();
                        return;
                    }
                    enableValidationFieldsFK();
                    $submitButtons.attr('disabled', false);
                })
                .catch(function() {
                    enableValidationFieldsFK();
                    $submitButtons.attr('disabled', false);
                });
            return false;
        }
    });

    var $vagasLimitadas = $('#vagasLimitadas');
    var $numeroVagasGroup = $('#numeroVagasGroup');
    var $numeroVagas = $('#numeroVagas');

    function toggleNumeroVagas() {
        var limited = $vagasLimitadas.val() === '1';
        $numeroVagasGroup.toggleClass('d-none', !limited);
        $numeroVagas.prop('required', limited);
        if (!limited) {
            $numeroVagas.val('');
            $numeroVagas.removeClass('is-invalid is-valid');
            $numeroVagasGroup.find('div.invalid-feedback').remove();
        } else {
            validator.element('#numeroVagas');
        }
    }

    $vagasLimitadas.on('change', toggleNumeroVagas);
    toggleNumeroVagas();

    var inputsReservaEspaco = [
        'reservaespaco_data',
        'reservaespaco_horaInicio',
        'reservaespaco_horaFim',
    ];

    var $reservaDiaInteiro = $('#reservaespaco_diaInteiro');
    var $reservaHoraInicio = $('#reservaespaco_horaInicio');
    var $reservaHoraFim = $('#reservaespaco_horaFim');

    function syncReservaEspacoHoras() {
        if ($reservaDiaInteiro.is(':checked')) {
            $reservaHoraInicio.val('00:00').attr('readonly', true).addClass('bg-light');
            $reservaHoraFim.val('23:59').attr('readonly', true).addClass('bg-light');
        } else {
            if ($reservaHoraInicio.prop('readonly') && $reservaHoraInicio.val() === '00:00') {
                $reservaHoraInicio.val('');
            }
            if ($reservaHoraFim.prop('readonly') && $reservaHoraFim.val() === '23:59') {
                $reservaHoraFim.val('');
            }
            $reservaHoraInicio.attr('readonly', false).removeClass('bg-light');
            $reservaHoraFim.attr('readonly', false).removeClass('bg-light');
        }
    }

    function updateReservaEspacoEmptyState() {
        var hasItems = $('#listTableReservaEspaco tbody tr').length > 0;
        $('.msgEmptyListReservaEspaco').toggleClass('d-none', hasItems);
    }

    $reservaDiaInteiro.on('change', function() {
        syncReservaEspacoHoras();
        validator.element('#reservaespaco_horaInicio');
        validator.element('#reservaespaco_horaFim');
    });

    $('#btnAddReservaEspaco').on('click', function(e) {
        addReservaEspaco();
    });

    syncReservaEspacoHoras();
    updateReservaEspacoEmptyState();

    var indexRowReservaEspaco = 0;

    function insertRowReservaEspaco(dados) {
        let html = $('#templateRowReservaEspaco').html();
        html = html.replaceAll('{_index_}', indexRowReservaEspaco);
        html = html.replaceAll('{_id_}', dados.id || '');
        html = html.replaceAll('{_data_}', dados.data || '');
        html = html.replaceAll('{_horaInicio_}', dados.horaInicio || '');
        html = html.replaceAll('{_horaFim_}', dados.horaFim || '');
        $('#listTableReservaEspaco tbody').append(html);

        indexRowReservaEspaco++;
        updateReservaEspacoEmptyState();
    }

    function addReservaEspaco() {
        let error = false;
        for (var i in inputsReservaEspaco) {
            if (!$('#' + inputsReservaEspaco[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }

        var data = $('#reservaespaco_data').val();
        var diaInteiro = $reservaDiaInteiro.is(':checked');
        var horaInicio = $('#reservaespaco_horaInicio').val();
        var horaFim = $('#reservaespaco_horaFim').val();

        if (!diaInteiro) {
            if (horaInicio && horaFim && horaInicio >= horaFim) {
                validator.showErrors({
                    'reservaespaco_horaFim': 'Hora fim deve ser maior que a hora início.'
                });
                return;
            }
        } else {
            horaInicio = '00:00';
            horaFim = '23:59';
        }

        insertRowReservaEspaco({
            id: '',
            data: data,
            horaInicio: horaInicio,
            horaFim: horaFim,
        });

        $('#reservaespaco_data').val('');
        $('#reservaespaco_horaInicio').val('');
        $('#reservaespaco_horaFim').val('');
        $reservaDiaInteiro.prop('checked', false);
        syncReservaEspacoHoras();
    }

    function removeReservaEspaco(index) {
        $('#ReservaEspaco_' + index).remove();
        updateReservaEspacoEmptyState();
    }

    var inputsControlePresenca = [
        'controlepresenca_descricao',
    ];

    $('#btnAddControlePresenca').on('click', function(e) {
        addControlePresenca();
    });

    var inputsParticipanteEvento = [
        'participanteevento_Participante_id',
    ];

    $('#btnAddParticipanteEvento').on('click', function(e) {
        addParticipanteEvento();
    });

    function disableValidationFieldsFK() {
        for (var i in inputsControlePresenca) {
            $('#' + inputsControlePresenca[i]).addClass('ignoreValidate');
        }
        for (var i in inputsReservaEspaco) {
            $('#' + inputsReservaEspaco[i]).addClass('ignoreValidate');
        }
        for (var i in inputsParticipanteEvento) {
            $('#' + inputsParticipanteEvento[i]).addClass('ignoreValidate');
        }
    }

    function enableValidationFieldsFK() {
        for (var i in inputsControlePresenca) {
            $('#' + inputsControlePresenca[i]).removeClass('ignoreValidate');
        }
        for (var i in inputsReservaEspaco) {
            $('#' + inputsReservaEspaco[i]).removeClass('ignoreValidate');
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
        let dados = {};
        dados.id = '';
        dados.descricao = $('#controlepresenca_descricao').val();

        insertRowControlePresenca(dados);

        $('#controlepresenca_descricao').val('');
    }

    var indexRowParticipanteEvento = 0;

    function participanteEventoJaAdicionado(participanteId) {
        if (!participanteId) {
            return false;
        }
        const participanteIdValue = String(participanteId).trim();
        let duplicado = false;
        $('#listTableParticipanteEvento tbody .fkParticipante_idParticipanteEvento').each(function() {
            if (String($(this).val()).trim() === participanteIdValue) {
                duplicado = true;
                return false;
            }
        });
        return duplicado;
    }

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
        let dados = {};
        dados.Participante_id = $('#participanteevento_Participante_id').val();
        if (participanteEventoJaAdicionado(dados.Participante_id)) {
            alertaError('Participante ja adicionado na lista.');
            return;
        }
        dados.Participante_id_Text = $('#participanteevento_Participante_id_Text').val();

        insertRowParticipanteEvento(dados);

        $('#participanteevento_Participante_id').val('');
        $('#participanteevento_Participante_id_Text').val('');
    }

    function insertRowControlePresenca(dados) {
        let html = $('#templateRowControlePresenca').html();
        html = html.replaceAll('{_index_}', indexRowControlePresenca);
        html = html.replaceAll('{_id_}', dados.id || '');
        html = html.replaceAll('{_descricao_}', dados.descricao || '');
        $('#listTableControlePresenca tbody').append(html);

        indexRowControlePresenca++;
        $(".msgEmptyListControlePresenca").hide();
    }

    function removeControlePresenca(index) {
        const mensagem = 'Ao excluir este item, todos os registros de presença vinculados serão excluídos. Deseja continuar?';
        swal({
                title: 'Você tem Certeza?',
                text: mensagem,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Não'
            },
            function(isConfirm) {
                if (isConfirm) {
                    $('#ControlePresenca_' + index).remove();
                }
            }
        );
    }

    function insertRowParticipanteEvento(dados) {
        let html = $('#templateRowParticipanteEvento').html();
        html = html.replaceAll('{_index_}', indexRowParticipanteEvento);
        html = html.replaceAll('{_Participante_id_}', dados.Participante_id);
        html = html.replaceAll('{_Participante_id_Text_}', dados.Participante_id_Text);
        html = html.replaceAll('{_id_}', dados.id);
        const classeBtnCobranca = dados.id ? '' : 'd-none';
        html = html.replaceAll('{_class_btn_cobranca_}', classeBtnCobranca);
        const situacaoCobranca = Number.isFinite(Number(dados.cobranca_situacao))
            ? Number(dados.cobranca_situacao)
            : 0;
        const classeBtnCobrancaCor = situacaoCobranca === 1 ? 'btn-success' : 'btn-warning';
        html = html.replaceAll('{_class_btn_cobranca_color_}', classeBtnCobrancaCor);
        const classeBtnExcluir = !dados.id || situacaoCobranca === 0 ? '' : 'd-none';
        html = html.replaceAll('{_class_btn_excluir_}', classeBtnExcluir);
        $('#listTableParticipanteEvento tbody').append(html);

        indexRowParticipanteEvento++;
        $(".msgEmptyListParticipanteEvento").hide();
    }

    <?PHP foreach ($evento->getListControlePresenca() as $i => $o) {
    ?>
        insertRowControlePresenca(<?= json_encode($o) ?>);
    <?PHP } ?>
    <?PHP foreach ($evento->getListEventoReserva() as $i => $o) {
        $reserva = $o->getReserva();
        if ($reserva) {
            $horaInicio = substr((string)$reserva->horaInicio, 0, 5);
            $horaFim = substr((string)$reserva->horaFim, 0, 5);
            $dados = [
                'id' => $reserva->id,
                'data' => $reserva->dataReserva,
                'horaInicio' => $horaInicio,
                'horaFim' => $horaFim,
            ];
        } else {
            $dados = [
                'id' => '',
                'data' => '',
                'horaInicio' => '',
                'horaFim' => '',
            ];
        }
    ?>
        insertRowReservaEspaco(<?= json_encode($dados) ?>);
    <?PHP } ?>
    <?PHP
    $cobrancaParticipanteEventoModel = new \App\Models\CobrancaParticipanteEventoModel();
    foreach ($evento->getListParticipanteEvento() as $i => $o) {
        $o->Participante_id_Text = $o->getParticipante()->nome;
        $o->cobranca_situacao = null;
        if (!empty($o->id)) {
            $linkCobranca = $cobrancaParticipanteEventoModel
                ->where('ParticipanteEvento_id', $o->id)
                ->first();
            if ($linkCobranca) {
                $cobranca = $linkCobranca->getCobranca();
                if ($cobranca) {
                    $o->cobranca_situacao = $cobranca->situacao;
                }
            }
        }
    ?>
        insertRowParticipanteEvento(<?= json_encode($o) ?>);
    <?PHP } ?>

    function verificarDataHoraReservas() {
        const reservas = [];
        $('#listTableReservaEspaco tbody tr').each(function(index) {
            const $row = $(this);
            reservas.push({
                id: $row.find('input[type="hidden"][name^="ReservaEspaco"][name$="[id]"]').val() || '',
                indice: index + 1,
                data: $row.find('input[type="hidden"][name^="ReservaEspaco"][name$="[data]"]').val() || '',
                horaInicio: $row.find('input[type="hidden"][name^="ReservaEspaco"][name$="[horaInicio]"]').val() || '',
                horaFim: $row.find('input[type="hidden"][name^="ReservaEspaco"][name$="[horaFim]"]').val() || ''
            });
        });

        if (!reservas.length) {
            return Promise.resolve({ ok: true, conflicts: [] });
        }

        return fetch("<?= base_url('Evento/verificarDatasReserva'); ?>", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                reservas: reservas,
                eventoId: <?= (int)$evento->id ?>
            })
        })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Erro ao validar as reservas.');
                }
                return response.json();
            })
            .then(function(result) {
                if (result && Array.isArray(result.conflicts) && result.conflicts.length) {
                    const mensagens = result.conflicts.map(function(conflict) {
                        const selecionada = 'Você selecionou a reserva para (' + conflict.data + ' ' + conflict.horaInicio + ' - ' + conflict.horaFim + ')';
                        if (Array.isArray(conflict.reservas) && conflict.reservas.length) {
                            const detalhes = conflict.reservas.map(function(r) {
                                return r.horaInicio + '-' + r.horaFim;
                            }).join(', ');
                            const prefixoHorario = conflict.reservas.length > 1 ? 'nos horários ' : 'no horário ';
                            return selecionada + '\nContudo já há uma reserva neste dia ' + prefixoHorario + detalhes;
                        }
                        return selecionada + '\nContudo já há uma reserva em conflito para este período';
                    }).join('\n\n');
                    alertaError('Não foi possível prosseguir devido a conflitos de reserva:\n' + mensagens);
                    return { ok: false, conflicts: result.conflicts };
                }
                return { ok: true, conflicts: [] };
            })
            .catch(function(error) {
                console.error('Falha ao verificar datas de reserva:', error);
                alertaError('Não foi possível validar as reservas. Tente novamente.');
                return { ok: false, error: error.message };
            });
    }
</script>
<?= $this->endSection('scripts'); ?>
