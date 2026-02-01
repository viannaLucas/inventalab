<?= $this->extend('templateSite'); ?>

<?= $this->section('content'); ?>
<!-- Hero Section -->
<!-- <section class="container mx-auto px-4 py-16 sm:py-24">
                <div class="relative flex min-h-[500px] flex-col items-center justify-center gap-6 overflow-hidden rounded-xl bg-cover bg-center p-8 text-center" data-alt="A modern workshop with various tools and equipment in a dimly lit, focused environment." style='background-image: linear-gradient(rgba(16, 25, 34, 0.6) 0%, rgba(16, 25, 34, 0.8) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuAM9GmaibNZYF_OONMc4iYea2JG1fQ41j4HBrb6UfzGXzpmBH65rigKPuF3_evCVe45zX2IzAvrEGOdzHpzgNXL1RcOs5KKkbs1bJeP6Ec5L_Y40bPXatKOUaEcuqaP1wNa0hmi63WTUHdrIQK81IW2egmUhpNBSmluAlr2nxM5Bxi6OTQFXvugw5rTjOc95vGbEY_pJh4iO2zwzSVIH80bAr0JlX4NEu6Y50epSUB70HFcX1PFAUlLeSavT5f6OlerGiTxqj3I4pHA");'>
                    <h1 class="text-4xl font-black text-white md:text-6xl">Suas Ideias, Construídas Aqui.</h1>
                    <p class="max-w-2xl text-base text-slate-200 md:text-lg">O melhor lugar para criadores, inovadores e makers darem vida às suas ideias. Junte-se à nossa comunidade e comece a construir hoje.</p>
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <button class="flex h-12 cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-primary px-6 text-base font-bold text-white"><span class="truncate">Quero participar</span></button>
                        <button class="flex h-12 cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-white/20 px-6 text-base font-bold text-white backdrop-blur-sm"><span class="truncate">Agende uma visita</span></button>
                    </div>
                </div>
            </section> -->
<!-- Cursos e Eventos Section -->
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
                        <a href="<?= esc(base_url('detalheEvento/'.$evento->id.'/'.$evento->gerarSlug()) , 'attr' ) ?>" class="mt-auto flex h-10 w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-primary/20 dark:bg-primary/30 text-primary text-sm font-bold"><span class="truncate">Saiba mais</span></a>
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
            <div class="h-80 w-full rounded-xl bg-cover bg-center" data-alt="A person working on a laptop in a creative workspace." style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDg7xeVzkpOL3a3D9lx6EJ22nzAcSy8jFhyMWiDoTw5FCRT3uLy0wBUcp1fgeOPoTp24_UItcBcIrdZFKiWD9w2ikOSAyzL8m-ZAAsDnvcwpPEhpzgrHv4zH8Yv21F8TMu2rkEM4Nk2Ld1Bxf7ZbJPsBW5wxgfBYD21xV8NiiIomQucEt-htcJ5oUy416AF967tWqjyexVb_YXafy-HQvQNXPHDru7SCpgewUV42qVp3Y4RiZOkwstUjDxCgIwO7oi_X_1MCyW9lVl4");'></div>
            <div class="h-80 w-full rounded-xl bg-cover bg-center" data-alt="A group of people collaborating around a table in a workshop." style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCAAziPHN9ToEgCNeXNcBy2nF1iWBHmuyxFcJt2b80Q0YWTAskxS0Mgc--N5c5ggWPnyldIyOSapdUBemTbsv_EpjzVyky1HHltdpddYr46EBIuZk6evNCGBmcvDOgYCw8iCp4V33XDSND7wfm8yPta6di_xtyx5a-hes82ZY6srBk7C7O2nDHdRgoxwHwqiHeGCs4EBoMyMu9MAzyXnmmhmHPfqO32dI4eY_42LQ3LPdVxWNXMhU3-4orJNSqmv5BbOUFBWcC9gu0B");'></div>
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
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/20 text-primary"><span class="material-symbols-outlined !text-4xl">person_add</span></div>
                <h3 class="mt-4 text-lg font-bold">1. Cadastre-se</h3>
                <p class="mt-2 text-sm text-text-muted-light dark:text-text-muted-dark">Crie sua conta em nossa plataforma de forma rápida e segura.</p>
            </div>
            <div class="flex flex-col items-center text-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/20 text-primary"><span class="material-symbols-outlined !text-4xl">calendar_month</span></div>
                <h3 class="mt-4 text-lg font-bold">2. Agende seu tempo</h3>
                <p class="mt-2 text-sm text-text-muted-light dark:text-text-muted-dark">Reserve horários para usar os equipamentos e bancadas disponíveis.</p>
            </div>
            <div class="flex flex-col items-center text-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/20 text-primary"><span class="material-symbols-outlined !text-4xl">construction</span></div>
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
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-300 group-hover:scale-105" data-alt="A modern 3D printer in action." style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDsrxQqu-d-olZfzX2PeKuXdxZz4aBt9Dd8IbH6pzriTK355EmD6ZQe7YcFY8eKkQiBvqXrBATVYjSZ9ilE2EXnXC5rTizclYILB-d9jZDYB4MGtrLO9P6HQ3Z4IznjAL1AyALKADMnkGZ2RELg29SFK-eBQky0DBOc36Aaf6FiU0XnTWmrIpvB45rCQkM9W9D6nvRE-azJN-SgqpOxwLG13v5L5y6xk95RiQA5rhlEqXnTq8xgBxXXlGGk9FMhWHAHG3SAPE1Ml3j5")'></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <h3 class="relative text-lg font-bold text-white">Impressoras 3D</h3>
        </div>
        <div class="group relative flex h-60 flex-col justify-end overflow-hidden rounded-lg p-4">
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-300 group-hover:scale-105" data-alt="A laser cutter engraving a piece of wood." style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBZdUS_Xb4VSKgvVlLUamWsE-LiL0iSxihw7iawHpr30kY9qChdqlnqw2QylGZlvndaW5MvqTK-cSyOaczri62PIojB4g-70gvX4NeXbkrTaLcwCSBeweqhzX65hZeY4jz-erreiN96oucni7c8ebVSrAELFdFxO6YcM1U3Bc17p4XMCP8FzqLyuvPThS2Y91ATefFKCFm2KqZ0HfQBB5DRTceUk5ZvoYi58dlOps8E6CJzkqSO7x05n7FkPYVdpJFKWFfqYPyjiTg0")'></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <h3 class="relative text-lg font-bold text-white">Corte a Laser</h3>
        </div>
        <div class="group relative flex h-60 flex-col justify-end overflow-hidden rounded-lg p-4">
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-300 group-hover:scale-105" data-alt="A CNC machine carving a complex design into metal." style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuA8YbwggX0SSXTAmlByOB3qh08dGGzIBotq_gx2huwCkm1_qV1ZCURueOGxfcSdcwpXrhoO9p83ogtSSX52suyQv8zG5E1F3fggG00qiP8PjqKnLQzbe6dVDJlCMC_NS1S5yBkzPjz54oUwAjZevvqvQV3_I0zysX8uBx4WpT34SQ4ekvGeqGyfD4-RbOjPb9C9GkBQgXrBLF6c6BM0_KzAXgoPI00SdD-TD8GYjTRd8l2ncG6xvB4dBaS34DURrk6d9ZORUAly1yBj")'></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <h3 class="relative text-lg font-bold text-white">Máquinas CNC</h3>
        </div>
        <div class="group relative flex h-60 flex-col justify-end overflow-hidden rounded-lg p-4">
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-300 group-hover:scale-105" data-alt="A soldering station with various electronic components." style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBVXrtj8IyyHS2khip7GVlCe-DRPh8H5VqpUFns4_pt-NJSg7yxQ2NFZHdwZt9ArMxQY0voi1owlkOttDXxQR3V1_POzUF__EM3BXGGPm1OM-jtc2WC9Bjh-B20_Uw12cpEKUZlzrOl7xJAeDEqLH0R_ci0v8L6yV3_vJIE326fULzakeIWPz7uHSUC-kbXAuOqOf2VMCsbDwlQzL29zHwpuS9O8MCj5hQSB444GgbH2Ih_aSAF4_S2R35JK3StlEyn-xpQ-o6DlRzN")'></div>
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
                <span class="material-symbols-outlined mt-1 text-2xl text-primary">location_on</span>
                <div>
                    <h3 class="font-bold">Endereço</h3>
                    <p class="text-text-muted-light dark:text-text-muted-dark">Rua da Inovação, 123, Bairro da Tecnologia, São Paulo - SP</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <span class="material-symbols-outlined mt-1 text-2xl text-primary">call</span>
                <div>
                    <h3 class="font-bold">Telefone</h3>
                    <p class="text-text-muted-light dark:text-text-muted-dark">(11) 98765-4321</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <span class="material-symbols-outlined mt-1 text-2xl text-primary">schedule</span>
                <div>
                    <h3 class="font-bold">Horário de Funcionamento</h3>
                    <p class="text-text-muted-light dark:text-text-muted-dark">Segunda a Sábado, das 09:00 às 21:00</p>
                </div>
            </div>
            <div class="mt-4 h-64 w-full overflow-hidden rounded-lg">
                <iframe allowfullscreen="" class="h-full w-full" data-location="São Paulo, Brazil" loading="lazy" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.145942463991!2d-46.656571584406!3d-23.563099367543885!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce59c8da0aa315%3A0xd59f9431f2c9776a!2sAv.%20Paulista%2C%20S%C3%A3o%20Paulo%20-%20SP!5e0!3m2!1spt-BR!2sbr!4v1633390318531!5m2!1spt-BR!2sbr" style="border:0;"></iframe>
            </div>
        </div>
        <form class="flex flex-col gap-4">
            <div>
                <label class="block text-sm font-medium" for="name">Nome</label>
                <input class="mt-1 block w-full rounded-md border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-sm focus:border-primary focus:ring-primary" id="name" name="name" type="text" />
            </div>
            <div>
                <label class="block text-sm font-medium" for="email">Email</label>
                <input class="mt-1 block w-full rounded-md border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-sm focus:border-primary focus:ring-primary" id="email" name="email" type="email" />
            </div>
            <div>
                <label class="block text-sm font-medium" for="message">Mensagem</label>
                <textarea class="mt-1 block w-full rounded-md border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-sm focus:border-primary focus:ring-primary" id="message" name="message" rows="5"></textarea>
            </div>
            <button class="flex h-12 w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-primary px-6 text-base font-bold text-white" type="submit"><span class="truncate">Enviar Mensagem</span></button>
        </form>
    </div>
</section>
<?= $this->endSection(); ?>