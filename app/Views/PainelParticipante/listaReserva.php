<?= $this->extend('PainelParticipante/template'); ?>

<?= $this->section('content'); ?>

<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Painel</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Minhas Reservas</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<div class="container px-0">
    <div class="card box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Minhas Reservas</h4>
            <small class="text-muted">Últimas 30 reservas realizadas.</small>
        </div>
        <div class="card-body pt-0">
            <?php
            $formatarHora = static function ($valor) {
                if (empty($valor) || $valor === '0000-00-00 00:00:00') {
                    return '-';
                }

                $timestamp = strtotime($valor);

                return $timestamp ? date('H:i', $timestamp) : '-';
            };
            ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Data Reserva - Início/Fim</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Convidados</th>
                            <th scope="col">Status</th>
                            <th scope="col">Hora<br>Entrada/Saída</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php if (!empty($vReservas)) : ?>
                            <?php /** @var \App\Entities\ReservaEntity $i */ ?>
                            <?php foreach ($vReservas as $i) : ?>
                                <tr>
                                    <td><?= $i->id ?></td>
                                    <td><?= $i->dataReserva ?> - <?= $i->horaInicio . ' / ' . $i->horaFim ?></td>
                                    <td><span style="color: <?= $i->_cl('tipo', $i->tipo) ?>;"><?= $i->_op('tipo', $i->tipo) ?></span></td>
                                    <td><?= $i->numeroConvidados ?></td>
                                    <td><span style="color: <?= $i->_cl('status', $i->status) ?>;"><?= $i->_op('status', $i->status) ?></span></td>
                                    <td><?= $formatarHora($i->horaEntrada) . ' / ' . $formatarHora($i->horaSaida) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="9" class="text-center">Nenhuma reserva encontrada.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
