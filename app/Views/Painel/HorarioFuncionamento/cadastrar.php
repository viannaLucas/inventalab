<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Horário Funcionamento</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Gerenciar Horários</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- content -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Cadastrar Horário Funcionamento</h4>
        </div>
        <div class="card-body pt-0">
            <form id='formCadastrar' action="<?PHP echo base_url('HorarioFuncionamento/doCadastrar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <div class="form-row">
                    <div class="form-group col-6 col-md-4">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="diaSemana">Dia da Semana</label> 
                        <select class="form-control" name="diaSemana" id="diaSemana" required="" >
                            <option value="" <?= old('diaSemana')=='' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\HorarioFuncionamentoEntity::_op('diaSemana') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= old('diaSemana') === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>
                    <div class="form-group col-6 col-md-4">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Início</label> 
                        <input class="form-control" name="horaInicio" id="horaInicio" type="time" maxlength="10" value="<?= old('horaInicio') ?>">
                    </div>
                    <div class="form-group col-6 col-md-4">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Final</label> 
                        <input class="form-control" name="horaFinal" id="horaFinal" type="time" maxlength="10" value="<?= old('horaFinal') ?>">
                    </div>
                    <div class="form-group mb-0 mt-3 text-center col-12">
                        <button type="submit" class="btn btn-primary submitButton">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Horário Funcionamento Cadastrados</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h4 class="card-title mb-1">Calendário Semanal</h4>
                    <div id="scheduleTimeline" class="schedule-timeline"></div>
                </div>
                <div class="col-12 col-md-6">
                    <h6 class="card-title">Lista Horário Cadastrados</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Dia da Semana</th>
                                    <th scope="col">Hora Início</th>
                                    <th scope="col">Hora Final</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?PHP foreach ($vHorarioFuncionamento as $i) { ?>
                                <tr>
                                    <td><?= $i->id ?></td>
                                    <td><span style="color: <?= $i->_cl('diaSemana', $i->diaSemana) ?>;"><?= $i->_op('diaSemana', $i->diaSemana) ?></span></td>
                                    <td><?= $i->horaInicio ?></td>
                                    <td><?= $i->horaFinal ?></td>
                                    <td>
                                        <a href="<?php echo base_url('HorarioFuncionamento/alterar/' . $i->id); ?>" class="btn btn-primary  btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                        </a>
                                        <div data-href="<?php echo base_url('HorarioFuncionamento/excluir/' . $i->id); ?>" class="btn btn-danger btn-sm btnExcluirLista">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- content -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class=" mb-0">Datas Extraordinárias</h4>
        </div>
        <hr>
        <div class="card-body pt-0 mt-1 mt-1">
            <h4 class="card-title mb-2 ">Cadastrar Datas Extraordinárias</h4>
            <p>As Datas Extraordinárias são utilizadas para definir horários de funcionamento diferenciados, permitindo indicar dias em que o espaço estará aberto ou fechado fora da programação semanal padrão. Caso seja necessário cadastrar o dia inteiro, utilize <strong>00:00</strong> na Hora Início e <strong>23:59</strong> na Hora Fim.</p>
            <form id='formCadastrarDatasExtraordinarias' action="<?PHP echo base_url('DatasExtraordinarias/doCadastrar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <div class="form-row">
                    
                    <div class="form-group col-12 col-md-2">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data</label> 
                        <input class="form-control maskData" name="data" id="data" type="text" value="<?= old('data') ?>">
                    </div>
                    <div class="form-group col-12 col-md-2">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Início</label> 
                        <input class="form-control" name="horaInicio" id="horaInicio" type="time" maxlength="10" value="<?= old('horaInicio') ?>">
                    </div>
                    <div class="form-group col-12 col-md-2">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Fim</label> 
                        <input class="form-control" name="horaFim" id="horaFim" type="time" maxlength="10" value="<?= old('horaFim') ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-2">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="tipo">Tipo</label> 
                        <select class="form-control" name="tipo" id="tipo" required="" >
                            <option value="" <?= old('tipo')=='' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\DatasExtraordinariasEntity::_op('tipo') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= old('tipo') === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>
                    <div class="form-group mb-0 mt-3 text-center col-12 col-md-2">
                        <button type="submit" class="btn btn-primary submitButton mt-2 mb-0">Cadastrar</button>
                    </div>
                </div>
            </form>
            <hr>
            <div class="row px-2 pb-3">
                <h4 class="card-title mb-3 ">Lista de Datas Extraordinárias Programadas</h4>
                <div class="table-responsive mt-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Data</th>
                                <th scope="col">Hora Início</th>
                                <th scope="col">Hora Fim</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?PHP foreach ($vDatasExtraordinarias as $i) { ?>
                            <tr>
                                <td><?= $i->id ?></td>
                                <td><?= $i->data ?></td>
                                <td><?= $i->horaInicio ?></td>
                                <td><?= $i->horaFim ?></td>
                                <td><span style="color: <?= $i->_cl('tipo', $i->tipo) ?>;"><?= $i->_op('tipo', $i->tipo) ?></span></td>
                                <td>
                                    <a href="<?php echo base_url('DatasExtraordinarias/alterar/' . $i->id); ?>" class="btn btn-primary  btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </a>
                                    <div data-href="<?php echo base_url('DatasExtraordinarias/excluir/' . $i->id); ?>" class="btn btn-danger btn-sm btnExcluirLista">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- content closed -->
<?= $this->endSection('content'); ?>

<?= $this->section('styles'); ?>
<style>
    .schedule-timeline {
        border: 1px solid rgba(0,0,0,.125);
        border-radius: .5rem;
        padding: 1rem;
        font-size: .85rem;
    }
    .schedule-row {
        display: grid;
        grid-template-columns: 80px 1fr;
        align-items: center;
        margin-bottom: .75rem;
    }
    .schedule-row:last-child {
        margin-bottom: 0;
    }
    .schedule-label {
        font-weight: 600;
        text-transform: capitalize;
    }
    .schedule-track {
        position: relative;
        height: 16px;
        background: linear-gradient(90deg, rgba(0,0,0,.05) 0%, rgba(0,0,0,.05) 100%);
        border-radius: 8px;
        overflow: hidden;
    }
    .schedule-slot {
        position: absolute;
        top: 0;
        bottom: 0;
        background: rgba(13,110,253,.5);
        border: 1px solid rgba(13,110,253,.8);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 4px;
        font-size: .65rem;
        color: #fff;
        white-space: nowrap;
    }
    .schedule-slot span {
        pointer-events: none;
    }
</style>
<?= $this->endSection('styles'); ?>

<?= $this->section('scripts'); ?>
<script>

<?php
        $scheduleByDay = [];
        foreach ($vHorarioFuncionamento as $horario) {
            $dayKey = (int) $horario->diaSemana;
            $scheduleByDay[$dayKey][] = [
                'start' => substr((string) $horario->horaInicio, 0, 5),
                'end'   => substr((string) $horario->horaFinal, 0, 5),
            ];
        }

        foreach ([1, 2, 3, 4, 5, 6, 7] as $dayKey) {
            $scheduleByDay[$dayKey] = $scheduleByDay[$dayKey] ?? [];
        }

        foreach ($scheduleByDay as &$intervals) {
            if (count($intervals) > 1) {
                usort($intervals, static function ($a, $b) {
                    return strcmp($a['start'], $b['start']);
                });
            }
        }
        unset($intervals);
?>
    const DEFAULT_SCHEDULE = <?= json_encode($scheduleByDay, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

    const DAY_LABELS = {
        1: 'Segunda',
        2: 'Terca',
        3: 'Quarta',
        4: 'Quinta',
        5: 'Sexta',
        6: 'Sabado',
        7: 'Domingo',
    };
    const DAY_ORDER = [1,2,3,4,5,6,7];

    function toMinutes(timeStr){
        if (!timeStr) return 0;
        const parts = timeStr.split(':');
        const h = Number(parts[0]);
        const m = Number(parts[1]);
        if (Number.isNaN(h) || Number.isNaN(m)) return 0;
        return h * 60 + m;
    }

    function formatTime(totalMinutes){
        const clamped = Math.max(0, Math.min(1440, Math.round(totalMinutes)));
        const hours = Math.floor(clamped / 60);
        const minutes = clamped % 60;
        return String(hours).padStart(2, '0') + 'h' + String(minutes).padStart(2, '0');
    }

    function computeTimelineBounds(schedule){
        let earliest = Infinity;
        let latest = -Infinity;
        DAY_ORDER.forEach(function(day){
            (schedule[day] || []).forEach(function(interval){
                const start = toMinutes(interval.start);
                const end = Math.max(start, toMinutes(interval.end));
                if (start < earliest) earliest = start;
                if (end > latest) latest = end;
            });
        });
        if (!Number.isFinite(earliest) || !Number.isFinite(latest)){
            return { start: 0, end: 24 * 60, total: 24 * 60 };
        }
        const start = Math.max(0, earliest - 120);
        const end = Math.min(1440, latest + 120);
        const total = Math.max(60, end - start || 24 * 60);
        return { start, end, total };
    }

    function renderScheduleTimeline(schedule){
        const container = document.getElementById('scheduleTimeline');
        if (!container) return;
        const bounds = computeTimelineBounds(schedule);
        const rows = [];
        DAY_ORDER.forEach(function(day){
            const label = DAY_LABELS[day] || ('Dia ' + day);
            const intervals = schedule[day] || [];
            const slots = intervals.map(function(interval){
                const start = toMinutes(interval.start);
                const end = Math.max(start, toMinutes(interval.end));
                const clampedStart = Math.max(bounds.start, start);
                const clampedEnd = Math.min(bounds.end, end);
                if (clampedEnd <= clampedStart) return '';
                const left = ((clampedStart - bounds.start) / bounds.total) * 100;
                const slotWidth = ((clampedEnd - clampedStart) / bounds.total) * 100;
                const tooltip = formatTime(start) + ' ate ' + formatTime(end);
                return '<span class="schedule-slot" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="' + tooltip + '" style="left:' + left + '%;width:' + slotWidth + '%;"><span>' + formatTime(start) + '</span><span>' + formatTime(end) + '</span></span>';
            }).join('');
            rows.push(
                '<div class="schedule-row">' +
                    '<span class="schedule-label">' + label + '</span>' +
                    '<div class="schedule-track">' + slots + '</div>' +
                '</div>'
            );
        });
        container.innerHTML = rows.join('');
        if (window.jQuery && typeof window.jQuery.fn.popover === 'function'){
            window.jQuery('#scheduleTimeline [data-toggle="popover"]').popover({
                container: 'body',
                trigger: 'hover',
                placement: 'top'
            });
        }
    }

    renderScheduleTimeline(DEFAULT_SCHEDULE);

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
            diaSemana: {
                required: true,
            },
            horaInicio: {
                required: true,
            },
            horaFinal: {
                required: true,
            },
        }
    });

    var validatorExtraordinaria = $("#formCadastrarDatasExtraordinarias").validate({
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
            data: {
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
        }
    });
</script>    
<?= $this->endSection('scripts'); ?>
