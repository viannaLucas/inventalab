<?php
use App\Entities\Cast\CastCurrencyBR;
?>

<?= $this->extend('templateSite'); ?>

<?= $this->section('content'); ?>
<section class="bg-card-light dark:bg-card-dark py-2 sm:py-6" id="cursos">
    <div class="container mx-auto px-4">
        <h1 class="text-center" style="font-size:2rem;font-weight:700;"><?= esc($evento->nome); ?></h1>
        <img class="mx-auto block max-w-[650px] w-full" alt="<?= esc($evento->nome); ?>" src="<?= base_url() . $evento->imagem; ?>" />

        <div class="my-6 flex flex-wrap items-center justify-center gap-6 text-center text-base font-semibold">
            <div>Data de Inicio: <?= esc($evento->dataInicio); ?></div>
            <div>Valor: <?= CastCurrencyBR::set($evento->valor) > 0 ? esc('R$ '.$evento->valor) : 'Gratuito'; ?></div>
            <div>
                <a class="px-5 py-2 rounded-full bg-blue-600 text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
                   href="<?= base_url('PainelParticipante/evento/'.$evento->id); ?>">
                    Realizar Inscrição
                </a>
            </div>
        </div>

        <?= $evento->texto; ?>
    </div>
</section>
<?= $this->endSection(); ?>
