<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Evento</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Controle de Presença</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
 <div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h3 class="">Selecione o Controle de Presença para impressão</h3>
        </div>
        <div class="card-body pt-0">
            <?PHP if (count($evento->getListControlePresenca()) > 0) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Descrição</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?PHP foreach ($evento->getListControlePresenca() as $i) { ?>
                        <tr>
                            <td><h5><?= $i->getEvento()?->nome ?>: <?= $i->descricao ?></h5></td>
                            <td>
                                <a target="_blank" href="<?php echo base_url('Evento/imprimirListaPresenca/'. $evento->id.'/'.$i->id); ?>" class="btn btn-primary ">
                                    Imprimir
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <?PHP } else { ?>
                <div class="justify-content-center">
                    <div class="card mg-b-20 text-center ">
                        <div class="card-body h-100">
                            <img src="<?PHP echo base_url('assets/img/no-data.svg'); ?>" alt="" class="" style="max-height: 100px;"/>
                            <h5 class="mg-b-10 mg-t-15 tx-18">Controles de Presença não encontrados</h5>
                            <p class="text-muted">Não há nenhuma lista de presença cadastrada para este evento</ps>
                            <div class="w-100">
                                <a class="btn btn-secondary" href="<?PHP echo base_url('Evento/alterar/'.$evento->id.'#controlePresenca'); ?>">Cadastrar Controle de Presença</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?PHP } ?>
        </div>
    </div>
</div>

<!-- row closed -->
<?= esc($this->endSection('content'); ) ?><?= $this->section('scripts'); ?>

<?= $this->endSection(); ?>
