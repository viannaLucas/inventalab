<?= $this->extend('template'); ?>
<?php
$formatarHoraBr = static function ($valor) {
    if (empty($valor) || $valor === '0000-00-00 00:00:00') {
        return '';
    }

    if (preg_match('/^\d{2}:\d{2}$/', $valor)) {
        return $valor;
    }

    $timestamp = strtotime($valor);
    if ($timestamp !== false) {
        return date('H:i', $timestamp);
    }

    $d = \DateTime::createFromFormat('d/m/Y H:i:s', $valor)
        ?: \DateTime::createFromFormat('d/m/Y H:i', $valor)
        ?: \DateTime::createFromFormat('Y-m-d H:i:s', $valor)
        ?: \DateTime::createFromFormat('Y-m-d H:i', $valor);
    return $d ? $d->format('H:i') : $valor;
};
$listaAtividadeLivre = $reserva->getListAtividadeLivre();
$listaEventoReserva = $reserva->getListEventoReserva();
$listaReservaParticipante = $reserva->getListReservaParticipante();
$oficinaTematicaReserva = $reserva->getListOficinaTematicaReserva();
$oficinaTematicaSelecionada = $oficinaTematicaReserva[0] ?? null;
$reservaCobranca = $reserva->getReservaCobranca();
$cobranca = $reservaCobranca ? $reservaCobranca->getCobranca() : null;
$participanteNome = $listaReservaParticipante[0]?->getParticipante()?->nome ?? '';
$horaEntradaRaw = trim((string) $reserva->horaEntrada);
$horaSaidaRaw = trim((string) $reserva->horaSaida);
$horaEntradaDefinida = $horaEntradaRaw !== '' && $horaEntradaRaw !== '0000-00-00 00:00:00';
$horaSaidaDefinida = $horaSaidaRaw !== '' && $horaSaidaRaw !== '0000-00-00 00:00:00';
$semCobranca = $reservaCobranca === null || $cobranca === null;
$mostrarBotaoCobranca = $horaEntradaDefinida && $horaSaidaDefinida && $semCobranca;
?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Reserva</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Alterar</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- content -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="card-title mb-1">Alterar</h4>
                <?php if ($mostrarBotaoCobranca) : ?>
                    <button
                        type="button"
                        class="btn btn-sm btn-primary js-add-cobranca"
                        data-reserva="<?= $reserva->id; ?>"
                        data-participante="<?= esc($participanteNome, 'attr'); ?>"
                        data-hora-entrada="<?= esc($horaEntradaRaw, 'attr'); ?>"
                        data-hora-saida="<?= esc($horaSaidaRaw, 'attr'); ?>"
                        data-data-reserva="<?= esc($reserva->dataReserva, 'attr'); ?>"
                        data-convidados="<?= (int) $reserva->numeroConvidados; ?>"
                    >
                        Adicionar Cobrança
                    </button>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body pt-0">
            <form id='formAlterar' action="<?PHP echo base_url('Reserva/doAlterar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="id" value="<?= $reserva->id ?>" />
                <div class="form-row">
                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Cadastro</label> 
                        <input class="form-control maskData" name="dataCadastro" id="dataCadastro" type="text" value="<?= $reserva->dataCadastro ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Reserva</label> 
                        <input class="form-control maskData" name="dataReserva" id="dataReserva" type="text" value="<?= $reserva->dataReserva ?>">
                    </div>                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Início</label> 
                        <input class="form-control" name="horaInicio" id="horaInicio" type="text" maxlength="10" value="<?= $reserva->horaInicio ?>">
                    </div>                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Fim</label> 
                        <input class="form-control" name="horaFim" id="horaFim" type="text" maxlength="10" value="<?= $reserva->horaFim ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="tipo">Tipo</label> 
                        <select class="form-control" name="tipo" id="tipo" required="" >
                            <?PHP foreach (App\Entities\ReservaEntity::_op('tipo') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= ((int)$reserva->tipo) === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Número Convidados</label> 
                        <input class="form-control maskInteiro" name="numeroConvidados" id="numeroConvidados" type="text" value="<?= $reserva->numeroConvidados ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="status">Status</label> 
                        <select class="form-control" name="status" id="status" required="" >
                            <?PHP foreach (App\Entities\ReservaEntity::_op('status') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= ((int)$reserva->status) === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="turmaEscola">Turma Escola</label> 
                        <select class="form-control" name="turmaEscola" id="turmaEscola" required="" >
                            <?PHP foreach (App\Entities\ReservaEntity::_op('turmaEscola') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= ((int)$reserva->turmaEscola) === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6 turma-escola-field" id="grupoNomeEscola">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome Escola</label> 
                        <input class="form-control" name="nomeEscola" id="nomeEscola" type="text" maxlength="250" value="<?= $reserva->nomeEscola ?>">
                    </div>
                    <div class="form-group col-12 col-md-6 turma-escola-field" id="grupoAnoTurma">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Ano Turma</label> 
                        <input class="form-control" name="anoTurma" id="anoTurma" type="text" maxlength="10" value="<?= $reserva->anoTurma ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Entrada</label> 
                        <input class="form-control maskHora" name="horaEntrada" id="horaEntrada" type="text" maxlength="5" value="<?= $formatarHoraBr($reserva->horaEntrada) ?>">
                        <small class="text-muted">Padrão HH:MM</small>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Saída</label> 
                        <input class="form-control maskHora" name="horaSaida" id="horaSaida" type="text" maxlength="5" value="<?= $formatarHoraBr($reserva->horaSaida) ?>">
                        <small class="text-muted">Padrão HH:MM</small>
                    </div>                                        
                <?php if (!empty($listaAtividadeLivre)) : ?>
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <div class="border-bottom mx-n1 mb-3">
                            <h4 class="px-2">Atividade Livre</h4>
                        </div>
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Descrição</th>
                                    <th scope="col" class="text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($listaAtividadeLivre as $idx => $atividadeLivre) : ?>
                                <tr>
                                    <td><?= esc($atividadeLivre->descricao ?? ''); ?></td>
                                    <td class="text-right">
                                        <?php if (!empty($atividadeLivre->id)) { ?>
                                            <a class="btn btn-primary btn-sm" href="<?= base_url('AtividadeLivre/alterar/' . $atividadeLivre->id); ?>">Visualizar</a>
                                        <?php } else { ?>
                                            <span class="text-muted">Indisponível</span>
                                        <?php } ?>
                                        <input type="hidden" name="AtividadeLivre[<?= $idx ?>][descricao]" value="<?= esc($atividadeLivre->descricao ?? ''); ?>">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </fieldset>
                <?php endif; ?>
                <?php if (!empty($listaEventoReserva)) : ?>
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <div class="border-bottom mx-n1 mb-3">
                            <h4 class="px-2">Evento da Reserva</h4>
                        </div>
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Evento</th>
                                    <th scope="col" class="text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($listaEventoReserva as $idx => $eventoReserva) :
                                $evento = $eventoReserva->getEvento();
                            ?>
                                <tr>
                                    <td><?= esc($evento->nome ?? ''); ?></td>
                                    <td class="text-right">
                                        <?php if (!empty($evento->id)) { ?>
                                            <a class="btn btn-primary btn-sm" href="<?= base_url('Evento/alterar/' . $evento->id); ?>">Visualizar</a>
                                        <?php } else { ?>
                                            <span class="text-muted">Indisponível</span>
                                        <?php } ?>
                                        <input type="hidden" name="EventoReserva[<?= $idx ?>][Evento_id]" value="<?= $eventoReserva->Evento_id ?>">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </fieldset>
                <?php endif; ?>
                <?php if ($oficinaTematicaSelecionada !== null) :
                    $oficina = $oficinaTematicaSelecionada->getOficinaTematica();
                    $observacaoOficina = trim((string) $oficinaTematicaSelecionada->observacao);
                ?>
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <div class="border-bottom mx-n1 mb-3">
                            <h4 class="px-2">Oficina Temática Reserva</h4>
                        </div>
                        <input type="hidden" name="OficinaTematicaReserva[0][OficinaTematica_id]" value="<?= $oficinaTematicaSelecionada->OficinaTematica_id ?>">
                        <input type="hidden" name="OficinaTematicaReserva[0][observacao]" value="<?= $observacaoOficina ?>">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Oficina Temática</th>
                                    <th scope="col">Observação</th>
                                    <th scope="col" class="text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= esc($oficina->nome ?? ''); ?></td>
                                    <td><?= $observacaoOficina !== '' ? esc($observacaoOficina) : '-'; ?></td>
                                    <td class="text-right">
                                        <?php if (!empty($oficina->id)) { ?>
                                            <a class="btn btn-primary btn-sm" href="<?= base_url('OficinaTematica/alterar/' . $oficina->id); ?>">Visualizar</a>
                                        <?php } else { ?>
                                            <span class="text-muted">Indisponível</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                <?php endif; ?>
                <?php if (!empty($listaReservaParticipante)) : ?>
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <div class="border-bottom mx-n1 mb-3">
                            <h4 class="px-2">Participantes da Reserva</h4>
                        </div>
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Participante</th>
                                    <th scope="col" class="text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($listaReservaParticipante as $idx => $reservaParticipante) :
                                $participante = $reservaParticipante->getParticipante();
                            ?>
                                <tr>
                                    <td><?= esc($participante->nome ?? ''); ?></td>
                                    <td class="text-right">
                                        <?php if (!empty($participante->id)) { ?>
                                            <a class="btn btn-primary btn-sm" href="<?= base_url('Participante/alterar/' . $participante->id); ?>">Visualizar</a>
                                        <?php } else { ?>
                                            <span class="text-muted">Indisponível</span>
                                        <?php } ?>
                                        <input type="hidden" name="ReservaParticipante[<?= $idx ?>][Participante_id]" value="<?= $reservaParticipante->Participante_id ?>">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </fieldset>
                <?php endif; ?>
                <?php if ($cobranca !== null) :
                    $situacaoLabel = $cobranca->_op('situacao', $cobranca->situacao);
                    $situacaoColor = $cobranca->_cl('situacao', $cobranca->situacao);
                    $observacoesCobranca = trim((string) $cobranca->observacoes);
                ?>
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <div class="border-bottom mx-n1 mb-3">
                            <h4 class="px-2">Cobrança</h4>
                        </div>
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Data</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Situação</th>
                                    <th scope="col">Observações</th>
                                    <th scope="col" class="text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= esc($cobranca->data ?? ''); ?></td>
                                    <td><?= esc((string) $cobranca->valor ?? ''); ?></td>
                                    <td><span style="color: <?= esc($situacaoColor); ?>;"><?= esc($situacaoLabel ?? ''); ?></span></td>
                                    <td><?= $observacoesCobranca !== '' ? esc($observacoesCobranca) : '-'; ?></td>
                                    <td class="text-right">
                                        <?php if (!empty($cobranca->id)) { ?>
                                            <a class="btn btn-primary btn-sm" href="<?= base_url('Cobranca/alterar/' . $cobranca->id); ?>">Visualizar</a>
                                        <?php } else { ?>
                                            <span class="text-muted">Indisponível</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                <?php endif; ?>
                <div class="form-group mb-0 mt-3 text-center col-12">
                    <button type="submit" class="btn btn-primary submitButton">Alterar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- content closed -->
<?= $this->endSection('content'); ?>

<?= $this->section('modal'); ?>
<div class="modal fade" id="modalReservaConsumo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <form method="post" action="">
                <div class="modal-header">
                    <h6 class="modal-title">Adicionar Cobrança</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Reserva de <strong class="js-consumo-participante"></strong></p>
                    <input type="hidden" name="reserva_id" value="">
                    <div class="form-group">
                        <label for="modalReservaConsumo-servico">Buscar Serviço</label>
                        <select class="form-control select2 js-consumo-servico" name="servico_id" id="modalReservaConsumo-servico" data-placeholder="Selecione um serviço">
                            <option value="">Selecione um serviço</option>
                            <?php foreach (($servicosAtivos ?? []) as $servico) : ?>
                                <option value="<?= esc($servico['id'], 'attr'); ?>">
                                    <?= esc($servico['nome']); ?> - R$ <?= number_format((float) $servico['valor'], 2, ',', '.'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0 js-tabela-servicos">
                            <thead>
                                <tr>
                                    <th>Serviço</th>
                                    <th class="text-right">Valor</th>
                                    <th style="width: 140px;">Quantidade</th>
                                    <th class="text-right">Total</th>
                                    <th style="width: 70px;" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="js-empty-row">
                                    <td colspan="5" class="text-center text-muted">Nenhum serviço selecionado.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <strong>Total: <span class="js-consumo-total">R$ 0,00</span></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="submit">Salvar</button>
                    <button class="btn ripple btn-secondary js-consumo-cancelar" data-dismiss="modal" type="button">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?>

<?= $this->section('scripts'); ?>
<script>
    const TURMA_ESCOLA_SIM = '0';
    const MASK_HORA = '00:00';

    function parseHoraParaMinutos(valor) {
        const match = valor.match(/^(\d{2}):(\d{2})$/);
        if (!match) {
            return null;
        }
        const hora = parseInt(match[1], 10);
        const minuto = parseInt(match[2], 10);
        if (hora < 0 || hora > 23 || minuto < 0 || minuto > 59) {
            return null;
        }
        return (hora * 60) + minuto;
    }

    $.validator.addMethod("horaBR", function (value, element) {
        if (this.optional(element)) {
            return true;
        }
        return parseHoraParaMinutos(value) !== null;
    }, 'Hora inválida.');

    $.validator.addMethod("horaSaidaMaiorIgual", function (value, element) {
        if (this.optional(element)) {
            return true;
        }
        const entradaVal = ($('#horaEntrada').val() || '').trim();
        if (entradaVal === '') {
            return true;
        }
        const entradaMinutos = parseHoraParaMinutos(entradaVal);
        const saidaMinutos = parseHoraParaMinutos(value);
        if (entradaMinutos === null || saidaMinutos === null) {
            return true;
        }
        return saidaMinutos >= entradaMinutos;
    }, 'Hora Saída deve ser igual ou posterior à Hora Entrada.');

    $('.maskHora').mask(MASK_HORA);

    function toggleCamposTurmaEscola() {
        const mostrar = $('#turmaEscola').val() === TURMA_ESCOLA_SIM;
        $('.turma-escola-field').toggleClass('d-none', !mostrar);
        $('#nomeEscola, #anoTurma').each(function () {
            $(this).prop('required', mostrar);
            if (!mostrar) {
                $(this).removeClass('is-invalid');
            }
        });
    }
    $('#turmaEscola').on('change', toggleCamposTurmaEscola);
    toggleCamposTurmaEscola();

    $('.submitButton').on('click', function(e){
        //$(this).attr('disabled', true);
        disableValidationFieldsFK();
    });
    var validator = $("#formAlterar").validate({
        submitHandler: function (form) {
            disableValidationFieldsFK();
            form.submit();
        },
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
                required: function () {
                    return $('#turmaEscola').val() === TURMA_ESCOLA_SIM;
                },
            },
            anoTurma: {
                required: function () {
                    return $('#turmaEscola').val() === TURMA_ESCOLA_SIM;
                },
            },
            horaEntrada: {
                horaBR: true,
            },
            horaSaida: {
                horaBR: true,
                horaSaidaMaiorIgual: true,
            },
        }
    });
    function disableValidationFieldsFK() {}

    function enableValidationFieldsFK() {}

    (function($) {
        'use strict';

        if (!$) {
            return;
        }

        var servicosAtivos = <?= json_encode($servicosAtivos ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
        if (!Array.isArray(servicosAtivos)) {
            servicosAtivos = [];
        }

        var usarCalculoUsoEspaco = <?= json_encode(!empty($usarCalculoUsoEspaco)); ?>;
        var SERVICO_USO_ESPACO_ID = Number(<?= json_encode($servicoUsoEspacoId ?? 1); ?>) || 1;
        var servicoPorId = {};
        servicosAtivos.forEach(function(servico) {
            if (servico && typeof servico.id !== 'undefined') {
                servicoPorId[Number(servico.id)] = servico;
            }
        });

        function obterServicoPorId(id) {
            var chave = Number(id);
            return servicoPorId.hasOwnProperty(chave) ? servicoPorId[chave] : null;
        }

        var consumoModalId = 'modalReservaConsumo';
        var $consumoModal = $('#' + consumoModalId);
        if (!$consumoModal.length) {
            return;
        }

        var $consumoForm = $consumoModal.find('form');
        var $consumoReserva = $consumoForm.find('input[name="reserva_id"]');
        var $consumoParticipante = $consumoModal.find('.js-consumo-participante');
        var $consumoTabela = $consumoModal.find('.js-tabela-servicos');
        var $consumoTotal = $consumoModal.find('.js-consumo-total');
        var $consumoServico = $consumoModal.find('.js-consumo-servico');
        var $consumoSubmit = $consumoForm.find('button[type="submit"]');

        var listarServicosUrl = '<?= base_url('Reserva/litarServicosReserva'); ?>';
        var definirServicosUrl = '<?= base_url('Reserva/definirServicosReserva'); ?>';
        var consumoSelecionados = [];
        var reservaCarregadaId = null;
        var consumoHoraEntradaRaw = '';
        var consumoHoraSaidaRaw = '';
        var consumoDataReserva = '';
        var consumoPessoasTotal = 1;
        var deveRecarregar = false;

        function formatarValor(valor) {
            var numero = Number(valor);
            if (!isFinite(numero)) {
                numero = 0;
            }
            return numero.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        }

        function escaparHtml(texto) {
            return $('<div>').text(texto || '').html();
        }

        function initSelect2InsideModal($select, $modal, namespace) {
            if (!$.fn.select2 || !$select.length) {
                return;
            }
            if ($select.hasClass('select2-hidden-accessible')) {
                $select.select2('destroy');
            }
            $select.select2({
                dropdownParent: $modal,
                placeholder: 'Selecione um serviço',
                allowClear: true,
                width: '100%'
            });

            var ns = (namespace || 'default').replace('.', '');
            $select.off('select2:open.' + ns).on('select2:open.' + ns, function() {
                var focarPesquisa = function() {
                    var $campoPesquisa = $modal.find('.select2-container--open .select2-search__field');
                    if ($campoPesquisa.length) {
                        $campoPesquisa.get(0).focus();
                    }
                };
                focarPesquisa();
                setTimeout(focarPesquisa, 0);
            });
        }

        function resetarSelectConsumo() {
            if (!$consumoServico.length) {
                return;
            }
            $consumoServico.val('');
            if ($.fn.select2 && $consumoServico.hasClass('select2-hidden-accessible')) {
                $consumoServico.trigger('change.select2');
            }
        }

        function atualizarTotalConsumo() {
            var total = consumoSelecionados.reduce(function(acumulado, item) {
                var quantidade = Number(item.quantidade) || 0;
                var valor = Number(item.valor) || 0;
                return acumulado + (quantidade * valor);
            }, 0);
            $consumoTotal.text(formatarValor(total));
        }

        function renderTabela() {
            var $tbody = $consumoTabela.find('tbody');
            $tbody.empty();

            if (!consumoSelecionados.length) {
                $tbody.append('<tr class="js-empty-row"><td colspan="5" class="text-center text-muted">Nenhum serviço selecionado.</td></tr>');
                atualizarTotalConsumo();
                return;
            }

            consumoSelecionados.forEach(function(item) {
                var quantidade = Number(item.quantidade) || 0;
                var total = quantidade * (Number(item.valor) || 0);
                var unidade = (item.unidade || '').toString().trim();
                var textoUnidade = '';
                if (unidade) {
                    textoUnidade = unidade.toLowerCase().indexOf('por ') === 0 ? unidade : ('Por ' + unidade);
                }
                var campoQuantidade = '<input type="number" min="0" step="1" class="form-control form-control-sm js-servico-qtde" data-id="' + item.id + '" value="' + quantidade + '">';
                var acoes = '<button type="button" class="btn btn-danger btn-sm js-remover-servico" data-id="' + item.id + '" title="Excluir" aria-label="Excluir">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">' +
                    '<title>Excluir</title>' +
                    '<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>' +
                    '<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>' +
                    '</svg>' +
                    '</button>';

                var linha = '' +
                    '<tr data-id="' + item.id + '">' +
                    '  <td>' + escaparHtml(item.nome) + '</td>' +
                    '  <td class="text-right">' +
                    '    <div>' + formatarValor(item.valor) + '</div>' +
                    (textoUnidade ? ('    <small class="form-text text-muted">' + escaparHtml(textoUnidade) + '</small>') : '') +
                    '  </td>' +
                    '  <td style="width: 140px;">' + campoQuantidade + '</td>' +
                    '  <td class="text-right js-servico-total">' + formatarValor(total) + '</td>' +
                    '  <td class="text-center">' + acoes + '</td>' +
                    '</tr>';
                $tbody.append(linha);
            });
            atualizarTotalConsumo();
        }

        function focusQuantidade(id) {
            var $campo = $consumoTabela.find('.js-servico-qtde[data-id="' + id + '"]');
            if ($campo.length) {
                $campo.trigger('focus');
            }
        }

        function adicionarServico(servicoId) {
            if (!servicoId) {
                return;
            }

            var servico = obterServicoPorId(servicoId);
            if (!servico) {
                return;
            }

            var existente = consumoSelecionados.find(function(item) {
                return Number(item.id) === Number(servico.id);
            });

            if (existente) {
                focusQuantidade(servico.id);
                return;
            }

            consumoSelecionados.push({
                id: servico.id,
                nome: servico.nome,
                valor: Number(servico.valor) || 0,
                unidade: servico.unidade || '',
                quantidade: 0
            });
            renderTabela();
            focusQuantidade(servico.id);
        }

        function resetConsumoModal() {
            consumoSelecionados = [];
            reservaCarregadaId = null;
            consumoHoraEntradaRaw = '';
            consumoHoraSaidaRaw = '';
            consumoDataReserva = '';
            consumoPessoasTotal = 1;
            $consumoReserva.val('');
            $consumoParticipante.text('');
            resetarSelectConsumo();
            renderTabela();
        }

        function normalizarDataHora(valor, dataReserva) {
            var texto = (valor || '').trim();
            if (!texto) {
                return '';
            }
            if (/^\d{2}:\d{2}$/.test(texto) && dataReserva) {
                return (dataReserva + ' ' + texto).trim();
            }
            return texto;
        }

        function parseDataHora(valor, dataReserva) {
            var texto = normalizarDataHora(valor, dataReserva);
            if (!texto) {
                return null;
            }
            var partes = texto.replace('T', ' ').split(' ');
            var dataParte = partes[0] || '';
            var horaParte = (partes[1] || '').substring(0, 5);
            if (!horaParte) {
                return null;
            }
            var ano = '';
            var mes = '';
            var dia = '';
            if (/^\d{2}\/\d{2}\/\d{4}$/.test(dataParte)) {
                var bits = dataParte.split('/');
                dia = bits[0];
                mes = bits[1];
                ano = bits[2];
            } else if (/^\d{4}-\d{2}-\d{2}$/.test(dataParte)) {
                var bitsIso = dataParte.split('-');
                ano = bitsIso[0];
                mes = bitsIso[1];
                dia = bitsIso[2];
            } else {
                return null;
            }
            var dataIso = ano + '-' + mes + '-' + dia + 'T' + horaParte + ':00';
            var data = new Date(dataIso);
            if (isNaN(data.getTime())) {
                return null;
            }
            return data;
        }

        function calcularUsoEspaco(entradaRaw, saidaRaw, pessoas, dataReserva) {
            var entrada = parseDataHora(entradaRaw, dataReserva);
            var saida = parseDataHora(saidaRaw, dataReserva);
            if (!entrada || !saida) {
                return { minutos: 0, quantidade: 0, valido: false };
            }
            var diff = (saida.getTime() - entrada.getTime()) / 60000;
            var minutos = Math.max(0, Math.round(diff));
            var pessoasCalculadas = Number(pessoas) || 0;
            pessoasCalculadas = pessoasCalculadas > 0 ? pessoasCalculadas : 1;
            return {
                minutos: minutos,
                quantidade: minutos * pessoasCalculadas,
                valido: diff > 0
            };
        }

        function adicionarUsoEspaco() {
            if (!usarCalculoUsoEspaco) {
                return;
            }
            var servico = obterServicoPorId(SERVICO_USO_ESPACO_ID);
            if (!servico) {
                return;
            }
            var resultado = calcularUsoEspaco(consumoHoraEntradaRaw, consumoHoraSaidaRaw, consumoPessoasTotal, consumoDataReserva);
            if (!resultado.valido || resultado.quantidade <= 0) {
                return;
            }
            var existente = consumoSelecionados.find(function(item) {
                return Number(item.id) === Number(servico.id);
            });
            if (existente) {
                existente.quantidade = resultado.quantidade;
                existente.valor = Number(servico.valor) || 0;
                existente.unidade = servico.unidade || '';
            } else {
                consumoSelecionados.push({
                    id: servico.id,
                    nome: servico.nome,
                    valor: Number(servico.valor) || 0,
                    unidade: servico.unidade || '',
                    quantidade: resultado.quantidade
                });
            }
        }

        function carregarServicosReserva(reservaId) {
            reservaCarregadaId = Number(reservaId) || null;
            if (!reservaCarregadaId) {
                return Promise.resolve();
            }

            var $tbody = $consumoTabela.find('tbody');
            $tbody.html('<tr><td colspan="5" class="text-center text-muted">Carregando serviços...</td></tr>');
            $consumoTotal.text('R$ 0,00');

            return fetch(listarServicosUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify({ reserva_id: reservaCarregadaId })
            }).then(function(response) {
                return response.json();
            }).then(function(data) {
                if (!data || data.erro) {
                    throw new Error((data && data.msg) ? data.msg : 'Não foi possível carregar os serviços.');
                }

                if (Number($consumoReserva.val()) !== reservaCarregadaId) {
                    return;
                }

                var servicos = Array.isArray(data.servicos) ? data.servicos : [];
                consumoSelecionados = servicos.map(function(item) {
                    return {
                        id: Number(item.id) || Number(item.servico_id) || 0,
                        nome: item.nome || '',
                        valor: Number(item.valorUnitario) || 0,
                        unidade: item.unidade || '',
                        quantidade: Number(item.quantidade) || 0
                    };
                }).filter(function(item) {
                    return item.id > 0;
                });

                if (usarCalculoUsoEspaco) {
                    adicionarUsoEspaco();
                }
                renderTabela();
            }).catch(function(error) {
                alert(error && error.message ? error.message : 'Erro ao carregar serviços.');
                consumoSelecionados = [];
                if (usarCalculoUsoEspaco) {
                    adicionarUsoEspaco();
                }
                renderTabela();
            });
        }

        $(document).on('click', '.js-add-cobranca', function() {
            var id = $(this).data('reserva');
            if (!id) {
                return;
            }
            var participante = $(this).data('participante') || '';
            resetConsumoModal();
            consumoHoraEntradaRaw = $(this).data('hora-entrada') || '';
            consumoHoraSaidaRaw = $(this).data('hora-saida') || '';
            consumoDataReserva = $(this).data('data-reserva') || '';
            var convidados = Number($(this).data('convidados')) || 0;
            consumoPessoasTotal = Math.max(1, convidados + 1);
            $consumoReserva.val(id);
            $consumoParticipante.text(participante);
            $consumoModal.modal('show');
            carregarServicosReserva(id);
        });

        $consumoModal.on('shown.bs.modal', function() {
            initSelect2InsideModal($consumoServico, $consumoModal, 'consumo');

            if ($.fn.select2 && $consumoServico.hasClass('select2-hidden-accessible')) {
                var $selecao = $consumoModal.find('.select2-container .select2-selection');
                if ($selecao.length) {
                    $selecao.trigger('focus');
                    return;
                }
            }
            $consumoServico.trigger('focus');
        });

        $consumoModal.on('hidden.bs.modal', function() {
            resetConsumoModal();
            if (deveRecarregar) {
                window.location.reload();
            }
            deveRecarregar = false;
        });

        $consumoServico.on('change', function() {
            var servicoId = Number($(this).val());
            if (!servicoId) {
                return;
            }
            adicionarServico(servicoId);
            resetarSelectConsumo();
        });

        $(document).on('click', '.js-remover-servico', function() {
            var servicoId = Number($(this).data('id'));
            consumoSelecionados = consumoSelecionados.filter(function(item) {
                return Number(item.id) !== servicoId;
            });
            renderTabela();
        });

        $(document).on('input', '.js-servico-qtde', function() {
            var servicoId = Number($(this).data('id'));
            var quantidade = parseFloat($(this).val());
            if (!isFinite(quantidade) || quantidade < 0) {
                quantidade = 0;
                $(this).val('0');
            }

            var selecionado = consumoSelecionados.find(function(item) {
                return Number(item.id) === servicoId;
            });

            if (selecionado) {
                selecionado.quantidade = quantidade;
                var total = quantidade * (Number(selecionado.valor) || 0);
                $(this).closest('tr').find('.js-servico-total').text(formatarValor(total));
                atualizarTotalConsumo();
            }
        });

        $consumoForm.on('submit', function(event) {
            event.preventDefault();

            var reservaId = $consumoReserva.val();
            var payloadServicos = consumoSelecionados.map(function(item) {
                var quantidade = Number($consumoTabela.find('.js-servico-qtde[data-id="' + item.id + '"]').val());
                quantidade = isFinite(quantidade) ? quantidade : 0;

                return {
                    id: item.id,
                    quantidade: quantidade
                };
            });

            if (!reservaId) {
                alert('Reserva inválida.');
                return;
            }

            $consumoSubmit.prop('disabled', true);
            fetch(definirServicosUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    reserva_id: Number(reservaId),
                    servicos: payloadServicos
                })
            }).then(function(response) {
                return response.json();
            }).then(function(response) {
                if (response && response.erro === false) {
                    deveRecarregar = true;
                    $consumoModal.modal('hide');
                    return;
                }

                var mensagem = response && response.msg ? response.msg : 'Não foi possível salvar a cobrança.';
                alert(mensagem);
            }).catch(function() {
                alert('Erro ao enviar os serviços. Tente novamente.');
            }).then(function() {
                $consumoSubmit.prop('disabled', false);
            });
        });
    })(window.jQuery);
</script>    
<?= $this->endSection('scripts'); ?>
