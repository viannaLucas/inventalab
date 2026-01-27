<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Pesquisa de Satisfação</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Resposta Pesquisa</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- row -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Resposta Pesquisa</h4>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Data Resposta</th>
                            <th scope="col">Uso Espaço</th>
                            <th scope="col">Atendimento</th>
                            <th scope="col">Equipamentos</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?PHP foreach ($vPesquisaSatisfacao as $i) { ?>
                            <tr>
                                <td><?= $i->dataResposta ?></td>
                                <td><?= $i->resposta1 ?></td>
                                <td><?= $i->resposta2 ?></td>
                                <td><?= $i->resposta3 ?></td>
                                <td>
                                    <a href="<?php echo base_url('PesquisaSatisfacao/visualizar/' . $i->id); ?>" class="btn btn-primary  btn-sm">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?= $pager->links('default', 'templatePaginacao') ?>
        </div>
    </div>
</div>
<!-- row closed -->
<?= $this->endSection('content'); ?>