<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>Definir nova senha</title>

        <link href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

        <link rel="apple-touch-icon" href="<?= esc(base_url('assets/img/brand/favicon.png'), 'attr') ?>" sizes="180x180">
        <link rel="icon" href="<?= esc(base_url('assets/img/brand/favicon.png'), 'attr') ?>" sizes="32x32" type="image/png">
        <link rel="icon" href="<?= esc(base_url('assets/img/brand/favicon.png'), 'attr') ?>" sizes="16x16" type="image/png">
        <link rel="mask-icon" href="<?= esc(base_url('assets/img/brand/favicon.png'), 'attr') ?>" color="#563d7c">
        <link rel="icon" href="<?= esc(base_url('assets/img/brand/favicon.png'), 'attr') ?>">
        <meta name="theme-color" content="#563d7c">

        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }

            html,
            body {
                height: 100%;
            }

            body {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-align: center;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }

            .form-signin {
                width: 100%;
                max-width: 420px;
                padding: 15px;
                margin: auto;
            }

            .form-label-group {
                position: relative;
                margin-bottom: 1rem;
            }

            .form-label-group input,
            .form-label-group label {
                height: 3.125rem;
                padding: .75rem;
            }

            .form-label-group label {
                position: absolute;
                top: 0;
                left: 0;
                display: block;
                width: 100%;
                margin-bottom: 0;
                line-height: 1.5;
                color: #495057;
                pointer-events: none;
                cursor: text;
                border: 1px solid transparent;
                border-radius: .25rem;
                transition: all .1s ease-in-out;
            }

            .form-label-group input::placeholder {
                color: transparent;
            }

            .form-label-group input:not(:placeholder-shown) {
                padding-top: 1.25rem;
                padding-bottom: .25rem;
            }

            .form-label-group input:not(:placeholder-shown) ~ label {
                padding-top: .25rem;
                padding-bottom: .25rem;
                font-size: 12px;
                color: #777;
            }

            .form-label-group input:-webkit-autofill ~ label {
                padding-top: .25rem;
                padding-bottom: .25rem;
                font-size: 12px;
                color: #777;
            }

            @supports (-ms-ime-align: auto) {
                .form-label-group {
                    display: -ms-flexbox;
                    display: flex;
                    -ms-flex-direction: column-reverse;
                    flex-direction: column-reverse;
                }

                .form-label-group label {
                    position: static;
                }

                .form-label-group input::-ms-input-placeholder {
                    color: #777;
                }
            }

        </style>
    </head>
    <body>
        <form action="<?= base_url('PainelParticipante/doAlterarSenha'); ?>" method="post" class="form-signin border border-3 p-3 rounded-lg bg-white shadow">
            <div class="text-center mb-4">
                <img class="mb-4" src="<?= esc(base_url('assets/img/brand/logoLogin.png'), 'attr') ?>" alt="" width="200">
                <h1 class="h3 mb-3 font-weight-normal">Definir nova senha</h1>
                <p>Crie uma nova senha para continuar acessando o painel.</p>
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
            </div>
            <input type="hidden" name="token" value="<?= esc($token ?? '', 'attr'); ?>">
            <div class="form-label-group">
                <input type="password" name="senha" id="senha" class="form-control" required minlength="6" placeholder="Nova senha">
                <label for="senha">Nova senha</label>
            </div>
            <div class="form-label-group">
                <input type="password" name="confirmaSenha" id="confirmaSenha" class="form-control" required minlength="6" placeholder="Confirmar nova senha">
                <label for="confirmaSenha">Confirmar nova senha</label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Salvar nova senha</button>
            <div class="text-center mt-3">
                <a href="<?= esc(base_url('PainelParticipante/login'), 'attr') ?>">Voltar ao login</a>
            </div>
        </form>
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
