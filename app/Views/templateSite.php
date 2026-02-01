<!DOCTYPE html>

<html class="light" lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>MakerSpace - Suas Ideias, Construídas Aqui</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link rel="icon" href="<?= base_url() ?>assets/img/brand/favicon.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#137fec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                        "card-light": "#ffffff",
                        "card-dark": "#182431",
                        "text-light": "#101922",
                        "text-dark": "#f6f7f8",
                        "text-muted-light": "#5c6a78",
                        "text-muted-dark": "#a0aec0",
                        "border-light": "#e7edf3",
                        "border-dark": "#2d3748"

                    },
                    fontFamily: {
                        "display": ["Space Grotesk", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-text-light dark:text-text-dark">
    <div class="relative flex min-h-screen w-full flex-col" id="root">
        <!-- Header -->
        <header class="sticky top-0 z-50 w-full border-b border-border-light dark:border-border-dark bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm" id="inicio">
            <div class="container mx-auto flex items-center justify-between px-4 py-3">
                <div class="flex items-center gap-3">
                    <a href="<?= esc(base_url(), 'attr') ?>">
                        <img src="<?= esc(base_url('assets/img/brand/logoLogin.png'), 'attr') ?>" alt="Logo" class="max-w-[150px]" />
                    </a>
                </div>
                <nav class="hidden items-center gap-8 lg:flex">
                    <!-- <a class="text-sm font-medium hover:text-primary" href="#inicio">Início</a> -->
                    <a class="text-sm font-medium hover:text-primary" href="<?= base_url() ;?>#cursos">Eventos</a>
                    <a class="text-sm font-medium hover:text-primary" href="<?= base_url() ;?>#sobre">Sobre</a>
                    <a class="text-sm font-medium hover:text-primary" href="<?= base_url() ;?>#como-funciona">Como funciona</a>
                    <a class="text-sm font-medium hover:text-primary" href="<?= base_url() ;?>#equipamentos">Equipamentos</a>
                    <a class="text-sm font-medium hover:text-primary" href="<?= base_url() ;?>#contato">Contato</a>
                </nav>
                <div class="hidden items-center gap-2 lg:flex">
                    <a href="<?= esc(base_url('PainelParticipante/cadastrar'), 'attr') ?>" class="flex h-10 cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-primary px-4 text-sm font-bold text-white"><span class="truncate">Cadastrar</span></a>
                    <a href="<?= esc(base_url('PainelParticipante/login'), 'attr') ?>" class="flex h-10 cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-primary/20 dark:bg-primary/30 px-4 text-sm font-bold text-primary"><span class="truncate">Entrar</span></a>
                </div>
            </div>
        </header>
        <main class="flex-1">
            <?= $this->renderSection('content'); ?></main>
        <!-- Footer -->
        <footer class="bg-card-light dark:bg-card-dark border-t border-border-light dark:border-border-dark">
            <div class="container mx-auto px-4 py-8">
                <div class="flex flex-col items-center justify-between gap-6 md:flex-row">
                    <p class="text-sm text-text-muted-light dark:text-text-muted-dark">© 2024 MakerSpace. Todos os direitos reservados.</p>
                    <div class="flex gap-6">
                        <a class="text-text-muted-light hover:text-primary dark:text-text-muted-dark" href="#">
                            <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewbox="0 0 24 24">
                                <path clip-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" fill-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a class="text-text-muted-light hover:text-primary dark:text-text-muted-dark" href="#">
                            <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewbox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                            </svg>
                        </a>
                        <a class="text-text-muted-light hover:text-primary dark:text-text-muted-dark" href="#">
                            <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewbox="0 0 24 24">
                                <path clip-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.013-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.023.047 1.351.058 3.807.058h.468c2.456 0 2.784-.011 3.807-.058.975-.045 1.504-.207 1.857-.344.467-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.047-1.023.058-1.351.058-3.807v-.468c0-2.456-.011-2.784-.058-3.807-.045-.975-.207-1.504-.344-1.857a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 100 10.27 5.135 5.135 0 000-10.27zm0 1.802a3.333 3.333 0 110 6.666 3.333 3.333 0 010-6.666zm5.338-3.205a1.2 1.2 0 100 2.4 1.2 1.2 0 000-2.4z" fill-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>