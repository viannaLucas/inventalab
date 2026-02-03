<?php

use App\Entities\Cast\CastCurrencyBR;
?>
<?= $this->extend('PainelParticipante/template'); ?>

<?= $this->section('content'); ?>

<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Painel</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Inscrição</span>
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
                        <h2 class=" mb-1">Inscrição</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="text-center mb-4">
                        <h2 class="mb-2">Que bom que vamos ter você conosco!</h2>
                        <p class="text-muted mb-0">Falta só um passo para garantir a sua inscrição.</p>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="mb-0">Confirme os dados</h4>
                        </div>
                    </div>

                    <div class="row align-items-stretch">
                        <div class="col-12 col-lg-8 d-flex">
                            <div class="border rounded p-3 p-md-4 w-100 h-100">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block">Evento</small>
                                        <div class="h5 mb-0"><?= esc($evento->nome); ?></div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block">Descrição</small>
                                        <div class="mb-0"><?= esc($evento->descricao); ?></div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                                        <small class="text-muted d-block">Data</small>
                                        <div class="font-weight-semibold"><?= esc($evento->dataInicio); ?></div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <small class="text-muted d-block">Valor</small>
                                        <div class="font-weight-semibold">
                                            <?= CastCurrencyBR::set($evento->valor) > 0 ? esc('R$ ' . $evento->valor) : 'Gratuito'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (!$inscrito) { ?>
                        <div class="col-12 col-lg-4 mt-4 mt-lg-0 d-flex">
                            <div class="card bg-light border-0 w-100 h-100">
                                <div class="card-body d-flex flex-column h-100">
                                    <h5 class="mb-2">Tudo certo?</h5>
                                    <p class="text-muted flex-grow-1 mb-3">
                                        Ao confirmar, sua inscrição será registrada e você receberá as próximas instruções.
                                    </p>
                                    <a href="<?= base_url('PainelParticipante/confirmarInscricao/'.$evento->id) ;?>" class="btn btn-success btn-block">Realizar Inscrição</a>
                                </div>
                            </div>
                        </div>
                        <?php }else { ?>
                            <div class="col-12 col-lg-4 mt-4 mt-lg-0 d-flex">
                            <div class="card bg-light border-0 w-100 h-100">
                                <div class="card-body d-flex flex-column h-100">
                                    <?php if($pago) { ?>
                                    <h5 class="mb-2">Parabéns! Sua vaga está garantida.</h5>
                                    <p class="text-muted flex-grow-1 mb-3">
                                        Agora é só aguardar e comparecer no dia do evento!
                                    </p>
                                    <?php }else{ ?>
                                    <h5 class="mb-2">Quase lá! Último passo...</h5>
                                    <p class="text-muted flex-grow-1 mb-3">
                                        Entre em contato para realizar o pagamento, concluir sua inscrição e garantir sua vaga.
                                        <a class="btn btn-primary d-block mt-4" href="<?= base_url('#contato') ;?>" target="_blank">Entrar em contato</a>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                       
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
