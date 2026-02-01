<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>Definir nova senha</title>

        <link href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?= esc(base_url('assets/css/auth.css'), 'attr') ?>" rel="stylesheet"/>

        <!-- Favicons -->
        <link rel="apple-touch-icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>" sizes="180x180">
        <link rel="icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>" sizes="32x32" type="image/png">
        <link rel="icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>" sizes="16x16" type="image/png">
        <link rel="mask-icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>" color="#563d7c">
        <link rel="icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>">
        <meta name="theme-color" content="#2563eb">
    </head>
    <body class="auth-page auth-page--recovery">
        <main class="auth-shell">
            <section class="auth-card">
                <div class="auth-brand">
                    <span class="auth-eyebrow auth-stagger delay-1">InventaLab</span>
                    <img class="auth-logo auth-stagger delay-2" src="<?= esc(base_url('assets/img/brand/logoLogin.png'), 'attr') ?>" alt="InventaLab">
                    <h1 class="auth-title auth-stagger delay-3">Defina sua nova senha</h1>
                    <p class="auth-subtitle auth-stagger delay-4">Crie uma senha segura para continuar usando o painel.</p>
                </div>
                <div class="auth-form">
                    <div class="auth-form-header auth-stagger delay-1">
                        <div class="auth-kicker">Painel</div>
                        <h2 class="auth-form-title">Alterar senha</h2>
                        <p class="auth-form-subtitle">Confirme sua nova senha para concluir.</p>
                    </div>
                    <?php
                    $msg_sucesso = session()->getFlashdata('msg_sucesso');
                    if ($msg_sucesso !== null) {
                        echo '<div class="alert alert-success" role="alert">' . $msg_sucesso . '</div>';
                    }
                    $msg_erro = session()->getFlashdata('msg_erro');
                    if ($msg_erro !== null) {
                        echo '<div class="alert alert-danger" role="alert">' . $msg_erro . '</div>';
                    }
                    ?>
                    <form action="<?= base_url('Painel/doAlterarSenha'); ?>" method="post">
                        <input type="hidden" name="token" value="<?= esc($token ?? '', 'attr'); ?>">
                        <div class="form-label-group">
                            <input type="password" name="senha" id="senha" class="form-control" required minlength="6" placeholder=" " autocomplete="new-password">
                            <label for="senha">Nova senha</label>
                        </div>
                        <div class="form-label-group">
                            <input type="password" name="confirmaSenha" id="confirmaSenha" class="form-control" required minlength="6" placeholder=" " autocomplete="new-password">
                            <label for="confirmaSenha">Confirmar nova senha</label>
                        </div>
                        <div class="auth-actions">
                            <button class="btn btn-primary btn-lg" type="submit">Salvar nova senha</button>
                        </div>
                        <div class="auth-links">
                            <a href="<?= esc(base_url('Painel/login'), 'attr') ?>">Voltar ao login</a>
                        </div>
                    </form>
                </div>
            </section>
        </main>
        <script>
            const senhaInput = document.getElementById('senha');
            const confirmaInput = document.getElementById('confirmaSenha');
            const senhaRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/;

            function validarSenha() {
                if (senhaInput.value !== '' && !senhaRegex.test(senhaInput.value)) {
                    senhaInput.setCustomValidity('A senha deve ter no mínimo 6 caracteres, com ao menos 1 letra maiúscula, 1 letra minúscula e 1 número.');
                } else {
                    senhaInput.setCustomValidity('');
                }

                if (confirmaInput.value !== '' && confirmaInput.value !== senhaInput.value) {
                    confirmaInput.setCustomValidity('As senhas não conferem.');
                } else {
                    confirmaInput.setCustomValidity('');
                }
            }

            senhaInput.addEventListener('input', validarSenha);
            confirmaInput.addEventListener('input', validarSenha);
        </script>
    </body>
</html>
