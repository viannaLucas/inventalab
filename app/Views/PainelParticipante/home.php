<?php

use App\Entities\Cast\CastCurrencyBR;
?>
<?= $this->extend('PainelParticipante/template'); ?>
<?= $this->section('content'); ?>

<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Painel</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Página Principal</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<div class="container px-0">
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card box-shadow-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Minhas Reservas</h4>
                        <small class="text-muted">Últimas 5 reservas realizadas.</small>
                    </div>
                    <div class="d-flex align-items-center justify-content-end">
                        <a href="<?php echo base_url('PainelParticipante/listarReservas'); ?>" class="btn btn-outline-secondary btn-sm">Ver mais</a>
                        <a href="<?php echo base_url('PainelParticipante/reserva'); ?>" class="btn btn-outline-secondary btn-sm ml-2">Reservar</a>
                    </div>
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
                                    <th scope="col">Data Reserva - Início/Fim</th>
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
                                            <td><?= $i->dataReserva ?> - <?= $i->horaInicio . ' / ' . $i->horaFim ?></td>
                                            <td><?= esc($i->numeroConvidados) ?></td>
                                            <td><span style="color: <?= $i->_cl('status', $i->status) ?>;"><?= esc($i->_op('status', $i->status)) ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Nenhuma reserva encontrada.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <div class="card box-shadow-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Minhas Inscrições</h4>
                        <small class="text-muted">Últimas 5 inscrições em eventos.</small>
                    </div>
                    <div class="d-flex align-items-center justify-content-end">
                        <a href="<?php echo base_url('PainelParticipante/listarReservas'); ?>" class="btn btn-outline-secondary btn-sm">Ver todas</a>
                    </div>
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
                                    <th scope="col">Evento</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Pagamento</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php if (!empty($vReservas)) : ?>
                                    <?php /** @var \App\Entities\ReservaEntity $i */ ?>
                                    <?php foreach ($vReservas as $i) : ?>
                                        <tr>
                                            <td><?= $i->dataReserva ?> - <?= $i->horaInicio . ' / ' . $i->horaFim ?></td>
                                            <td><?= esc($i->numeroConvidados) ?></td>
                                            <td><span style="color: <?= $i->_cl('status', $i->status) ?>;"><?= esc($i->_op('status', $i->status)) ?></span></td>
                                            <td><?= esc($formatarHora($i->horaEntrada) . ' / ' . $formatarHora($i->horaSaida)) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Nenhuma reserva encontrada.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card box-shadow-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Próximos Eventos</h4>
                        <small class="text-muted">Próximos eventos.</small>
                    </div>
                </div>
                <div class="card-body pt-0">

                    <div class="row row-sm">
                        <?php foreach($eventos as $evento){ ;?>
                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <div class="card">
                                <img class="card-img-top w-100" src="<?= esc(base_url($evento->imagem), 'attr') ?>" alt="">
                                <div class="card-body">
                                    <h4 class="card-title mb-3"><?= esc($evento->nome) ; ?></h4>
                                    <div class="card-text">Data Início: <?= $evento->dataInicio ?></div>
                                    <div class="card-text">Valor: <?= CastCurrencyBR::set($evento->valor) > 0 ? esc('R$ '.$evento->valor) : 'Gratuito'; ?></div>
                                    <a class="btn btn-outline-secondary" href="<?= esc(base_url('PainelParticipante/inscricao/'.$evento->id.'/'.$evento->gerarSlug()) , 'attr') ?>">Incrição</a>
                                    <a class="btn btn-outline-primary" target="_blank" href="<?= esc(base_url('detalheEvento/'.$evento->id.'/'.$evento->gerarSlug()) , 'attr' ) ?>">Veja Mais</a>
                                </div>
                            </div>
                        </div>
                        <?php } ;?>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
