<?= $this->extend('PainelParticipante/template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Painel</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Minhas Inscrições</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<div class="container px-0">
    <div class="card box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Minhas Incrições</h4>
            <small class="text-muted">Últimas 30 inscrições realizadas.</small>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">Evento</th>
                            <th scope="col">Data</th>
                            <th scope="col">Situação</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php if (!empty($vEventosIncritos)) : ?>
                            <?php /** @var EventoEntity $i */
                            foreach ($vEventosIncritos as $i) : ?>
                                <tr>
                                    <td><?= esc($i['evento']->nome) ?></td>
                                    <td><?= esc($i['evento']->dataInicio); ?></td>
                                    <td><?= $i['pago'] ? '<span class="text-success">Inscrito<span>' : '<span class="text-danger">Pagamento Pendente<span>'; ?></td>
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

<?= $this->endSection(); ?>