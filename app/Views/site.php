<?= $this->extend('templateSite'); ?>

<?php
$horarioFuncionamentoTexto = [];
if (!empty($vHorarioFuncionamento)) {
    $scheduleByDay = [];
    foreach ($vHorarioFuncionamento as $horario) {
        $dayKey = (int) $horario->diaSemana;
        $scheduleByDay[$dayKey][] = [
            'start' => substr((string) $horario->horaInicio, 0, 5),
            'end'   => substr((string) $horario->horaFinal, 0, 5),
        ];
    }

    $dayOrder = [1, 2, 3, 4, 5, 6, 7];
    $dayLabels = [
        1 => 'Segunda:',
        2 => 'Terça:',
        3 => 'Quarta:',
        4 => 'Quinta:',
        5 => 'Sexta:',
        6 => 'Sábado:',
        7 => 'Domingo:',
    ];

    $formatTime = static function ($timeStr) {
        $t = substr((string) $timeStr, 0, 5);
        return str_replace(':', 'h', $t);
    };

    foreach ($dayOrder as $dayKey) {
        $intervals = $scheduleByDay[$dayKey] ?? [];
        if (count($intervals) > 1) {
            usort($intervals, static function ($a, $b) {
                return strcmp($a['start'], $b['start']);
            });
        }
        if (count($intervals) === 0) {
            continue;
        }
        $parts = [];
        foreach ($intervals as $interval) {
            $parts[] = $formatTime($interval['start']) . ' as ' . $formatTime($interval['end']);
        }
        $horarioFuncionamentoTexto[] = $dayLabels[$dayKey] . ' ' . implode(' , ', $parts);
    }
}
?>

<?= $this->section('content'); ?>
<section class="bg-card-light dark:bg-card-dark py-3 sm:py-6" id="cursos">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold md:text-4xl">Eventos</h2>
            <p class="mt-4 text-base text-text-muted-light dark:text-text-muted-dark md:text-lg">Participe de nossos workshops e eventos para aprender novas habilidades, conhecer outros makers e se inspirar.</p>
        </div>
        <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($eventos as $evento) {; ?>
                <div class="flex flex-col overflow-hidden rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark">
                    <div class="h-48 w-full bg-cover bg-center" data-alt="<?= esc($evento->nome); ?>" style='background-image: url("<?= esc($evento->imagem); ?>")'></div>
                    <div class="flex flex-1 flex-col p-6">
                        <h3 class="text-xl font-bold"><?= esc($evento->nome);; ?></h3>
                        <p class="mt-2 text-sm text-text-muted-light dark:text-text-muted-dark"><?= esc($evento->nome); ?></p>
                        <span class="my-4 text-sm font-semibold text-primary"><?= esc($evento->dataInicio); ?></span>
                        <a href="<?= esc(base_url('detalheEvento/' . $evento->id . '/' . $evento->gerarSlug()), 'attr') ?>" class="mt-auto flex h-10 w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-primary/20 dark:bg-primary/30 text-primary text-sm font-bold"><span class="truncate">Saiba mais</span></a>
                    </div>
                </div>
            <?php }; ?>
        </div>
    </div>
</section>
<!-- Sobre o espaço Section -->
<section class="container mx-auto px-4 py-16 sm:py-24" id="sobre">
    <div class="flex flex-col items-center gap-12">
        <div class="max-w-3xl text-center">
            <h2 class="text-3xl font-bold md:text-4xl">Sobre o espaço</h2>
            <p class="mt-4 text-base text-text-muted-light dark:text-text-muted-dark md:text-lg">Somos uma oficina comunitária que oferece acesso a ferramentas, tecnologia e educação. Nossa missão é capacitar indivíduos a aprender, criar e inovar em um ambiente colaborativo e de apoio.</p>
        </div>
        <div class="grid w-full grid-cols-1 gap-4 md:grid-cols-2">
            <div class="h-80 w-full rounded-xl bg-cover bg-center" data-alt="A person working on a laptop in a creative workspace." style='background-image: url("<?= esc(base_url('assets/img/site/sobre-1.jpg'), 'attr'); ?>");'></div>
            <div class="h-80 w-full rounded-xl bg-cover bg-center" data-alt="A group of people collaborating around a table in a workshop." style='background-image: url("<?= esc(base_url('assets/img/site/sobre-2.jpg'), 'attr'); ?>");'></div>
        </div>
    </div>
</section>
<!-- Como funciona Section -->
<section class="bg-card-light dark:bg-card-dark py-16 sm:py-24" id="como-funciona">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold md:text-4xl">Como funciona</h2>
            <p class="mt-4 text-base text-text-muted-light dark:text-text-muted-dark md:text-lg">Começar a criar no nosso espaço é simples e rápido. Siga estes passos para se tornar parte da nossa comunidade de makers.</p>
        </div>
        <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            <div class="flex flex-col items-center text-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/20 text-primary"><span class="material-symbols-outlined !text-4xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-check-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                    </span></div>
                <h3 class="mt-4 text-lg font-bold">1. Cadastre-se</h3>
                <p class="mt-2 text-sm text-text-muted-light dark:text-text-muted-dark">Crie sua conta em nossa plataforma de forma rápida e segura.</p>
            </div>
            <div class="flex flex-col items-center text-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/20 text-primary"><span class="material-symbols-outlined !text-4xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-calendar-range" viewBox="0 0 16 16">
                            <path d="M9 7a1 1 0 0 1 1-1h5v2h-5a1 1 0 0 1-1-1M1 9h4a1 1 0 0 1 0 2H1z" />
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                        </svg>
                    </span></div>
                <h3 class="mt-4 text-lg font-bold">2. Agende seu tempo</h3>
                <p class="mt-2 text-sm text-text-muted-light dark:text-text-muted-dark">Reserve horários para usar os equipamentos e bancadas disponíveis.</p>
            </div>
            <div class="flex flex-col items-center text-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/20 text-primary"><span class="material-symbols-outlined !text-4xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
                            <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3q0-.405-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708M3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z" />
                        </svg>
                    </span></div>
                <h3 class="mt-4 text-lg font-bold">3. Crie!</h3>
                <p class="mt-2 text-sm text-text-muted-light dark:text-text-muted-dark">Use nosso espaço e ferramentas para dar vida aos seus projetos.</p>
            </div>
        </div>
    </div>
</section>
<!-- Equipamentos Section -->
<section class="container mx-auto px-4 py-16 sm:py-24" id="equipamentos">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-3xl font-bold md:text-4xl">Nossos Equipamentos</h2>
        <p class="mt-4 text-base text-text-muted-light dark:text-text-muted-dark md:text-lg">De impressão 3D a marcenaria, temos uma vasta gama de ferramentas profissionais à sua disposição para qualquer tipo de projeto.</p>
    </div>
    <div class="mt-12 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        <div class="group relative flex h-60 flex-col justify-end overflow-hidden rounded-lg p-4">
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-300 group-hover:scale-105" data-alt="A modern 3D printer in action." style='background-image: url("<?= esc(base_url('assets/img/site/equipamentos-3d.jpg'), 'attr'); ?>")'></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <h3 class="relative text-lg font-bold text-white">Impressoras 3D</h3>
        </div>
        <div class="group relative flex h-60 flex-col justify-end overflow-hidden rounded-lg p-4">
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-300 group-hover:scale-105" data-alt="A laser cutter engraving a piece of wood." style='background-image: url("<?= esc(base_url('assets/img/site/equipamentos-laser.jpg'), 'attr'); ?>")'></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <h3 class="relative text-lg font-bold text-white">Corte a Laser</h3>
        </div>
        <div class="group relative flex h-60 flex-col justify-end overflow-hidden rounded-lg p-4">
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-300 group-hover:scale-105" data-alt="A CNC machine carving a complex design into metal." style='background-image: url("<?= esc(base_url('assets/img/site/equipamentos-cnc.jpg'), 'attr'); ?>")'></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <h3 class="relative text-lg font-bold text-white">Máquinas CNC</h3>
        </div>
        <div class="group relative flex h-60 flex-col justify-end overflow-hidden rounded-lg p-4">
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-300 group-hover:scale-105" data-alt="A soldering station with various electronic components." style='background-image: url("<?= esc(base_url('assets/img/site/equipamentos-eletronica.jpg'), 'attr'); ?>")'></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <h3 class="relative text-lg font-bold text-white">Bancada de Eletrônica</h3>
        </div>
    </div>
</section>
<!-- Contato Section -->
<section class="container mx-auto px-4 py-16 sm:py-24" id="contato">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-3xl font-bold md:text-4xl">Fale Conosco</h2>
        <p class="mt-4 text-base text-text-muted-light dark:text-text-muted-dark md:text-lg">Tem alguma dúvida ou sugestão? Entre em contato ou venha nos visitar. Estamos ansiosos para ouvir sobre seu próximo grande projeto!</p>
    </div>
    <div class="mt-12 grid grid-cols-1 gap-12 lg:grid-cols-2">
        <div class="flex flex-col gap-6">
            <div class="flex items-start gap-4">
                <span class="material-symbols-outlined mt-1 text-2xl text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                        <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                        <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    </svg>
                </span>
                <div>
                    <h3 class="font-bold">Endereço</h3>
                    <p class="text-text-muted-light dark:text-text-muted-dark">R. Itaiópolis, 470 - América, Joinville - SC, 89204-100</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <span class="material-symbols-outlined mt-1 text-2xl text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
                        <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                        <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                    </svg>
                </span>
                <div>
                    <h3 class="font-bold">Telefone</h3>
                    <p class="text-text-muted-light dark:text-text-muted-dark">(47) 3441-3300</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <span class="material-symbols-outlined mt-1 text-2xl text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                    </svg>
                </span>
                <div>
                    <h3 class="font-bold">Horário de Funcionamento</h3>
                    <?php if (!empty($horarioFuncionamentoTexto)) { ?>
                        <p class="text-text-muted-light dark:text-text-muted-dark">
                            <?php foreach ($horarioFuncionamentoTexto as $idx => $linha) { ?>
                                <?= $idx ? '<br>' : ''; ?><?= esc($linha); ?>
                            <?php } ?>
                        </p>
                    <?php } else { ?>
                        <p class="text-text-muted-light dark:text-text-muted-dark">Horário não informado.</p>
                    <?php } ?>
                </div>
            </div>
            <div class="mt-4 h-64 w-full overflow-hidden rounded-lg">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3577.201276722168!2d-48.84724852431485!3d-26.287574267375067!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94deb02c2a692f8f%3A0x30564e2fea673820!2sR.%20Itai%C3%B3polis%2C%20470%20-%20Am%C3%A9rica%2C%20Joinville%20-%20SC%2C%2089204-100!5e0!3m2!1spt-BR!2sbr!4v1769981019830!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <form id="contato-form" class="flex flex-col gap-4" action="<?= esc(base_url('PainelParticipante/enviarContatoSite'), 'attr'); ?>" method="post" novalidate>
            <?= csrf_field(); ?>
            <?php $honeypotName = config('Honeypot')->name ?? 'honeypot'; ?>
            <div style="display:none">
                <label for="hp"><?= esc(config('Honeypot')->label ?? 'Fill This Field'); ?></label>
                <input type="text" id="hp" name="<?= esc($honeypotName, 'attr'); ?>" value="" autocomplete="off" tabindex="-1" />
            </div>
            <?php
            $msg_sucesso = session()->getFlashdata('msg_sucesso');
            if ($msg_sucesso) {
                echo '<div class="rounded-md border border-green-200 bg-green-50 p-4 text-sm text-green-800">' . esc($msg_sucesso) . '</div>';
            }
            $msg_erro = session()->getFlashdata('msg_erro');
            if ($msg_erro) {
                if (is_array($msg_erro)) {
                    $msg_erro = implode('<br>', array_map('esc', $msg_erro));
                } else {
                    $msg_erro = esc($msg_erro);
                }
                echo '<div class="rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-800">' . $msg_erro . '</div>';
            }
            ?>
            <div id="contato-erro-cliente" class="hidden rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-800"></div>
            <div>
                <label class="block text-sm font-medium" for="name">Nome</label>
                <input class="mt-1 block w-full rounded-md border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-sm focus:border-primary focus:ring-primary" id="name" name="name" type="text" value="<?= esc(old('name')); ?>" required />
            </div>
            <div>
                <label class="block text-sm font-medium" for="email">Email</label>
                <input class="mt-1 block w-full rounded-md border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-sm focus:border-primary focus:ring-primary" id="email" name="email" type="email" value="<?= esc(old('email')); ?>" required />
            </div>
            <div>
                <label class="block text-sm font-medium" for="message">Mensagem</label>
                <textarea class="mt-1 block w-full rounded-md border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-sm focus:border-primary focus:ring-primary" id="message" name="message" rows="5" required><?= esc(old('message')); ?></textarea>
            </div>
            <button class="flex h-12 w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-primary px-6 text-base font-bold text-white" type="submit"><span class="truncate">Enviar Mensagem</span></button>
        </form>
        <script>
            (function() {
                var form = document.getElementById('contato-form');
                if (!form) return;
                var errorBox = document.getElementById('contato-erro-cliente');
                form.addEventListener('submit', function(e) {
                    var nome = (document.getElementById('name') || {}).value || '';
                    var email = (document.getElementById('email') || {}).value || '';
                    var mensagem = (document.getElementById('message') || {}).value || '';
                    var erros = [];

                    if (nome.trim().length < 3) {
                        erros.push('Informe um nome com pelo menos 3 caracteres.');
                    }
                    if (email.trim() === '' || !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email.trim())) {
                        erros.push('Informe um e-mail válido.');
                    }
                    if (mensagem.trim().length < 10) {
                        erros.push('A mensagem deve conter pelo menos 10 caracteres.');
                    }

                    if (erros.length > 0) {
                        e.preventDefault();
                        if (errorBox) {
                            errorBox.innerHTML = erros.join('<br>');
                            errorBox.classList.remove('hidden');
                        }
                        return false;
                    }

                    if (errorBox) {
                        errorBox.classList.add('hidden');
                        errorBox.innerHTML = '';
                    }
                });
            })();
        </script>
    </div>
</section>
<?= $this->endSection(); ?>