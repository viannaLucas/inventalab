<?= $this->extend('PainelParticipante/template'); ?>

<?= $this->section('content'); ?>

<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Painel</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Próximos Eventos</span>
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
                        <h4 class="card-title mb-1">Próximos Eventos</h4>
                        <small class="text-muted">Próximos eventos.</small>
                    </div>
                </div>
                <div class="card-body pt-0">

                    <div class="row row-sm">
                        <?php foreach($eventos as $evento){ ;?>
                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <div class="card">
                                <img class="card-img-top w-100" src="<?= base_url($evento->imagem) ?>" alt="">
                                <div class="card-body">
                                    <h4 class="card-title mb-3"><?= esc($evento->nome) ;?></h4>
                                    <div class="card-text">Data Início: <?= $evento->dataInicio ?></div>
                                    <div class="card-text">Valor: <?= $evento->valor > 0 ? esc('R$ '.$evento->valor) : 'Gratuito'; ?></div>
                                    <a class="btn btn-outline-secondary" href="#">Incrição</a>
                                    <a class="btn btn-outline-primary" target="_blank" href="<?= base_url('detalheEvento/'.$evento->id.'/'.$evento->gerarSlug()) ;?>">Veja Mais</a>
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