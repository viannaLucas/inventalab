<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>Cadastro Realizado</title>

        <link href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

        <link rel="apple-touch-icon" href="<?= base_url('assets/img/brand/favicon.png'); ?>" sizes="180x180">
        <link rel="icon" href="<?= base_url('assets/img/brand/favicon.png'); ?>" sizes="32x32" type="image/png">
        <link rel="icon" href="<?= base_url('assets/img/brand/favicon.png'); ?>" sizes="16x16" type="image/png">
        <link rel="mask-icon" href="<?= base_url('assets/img/brand/favicon.png'); ?>" color="#563d7c">
        <link rel="icon" href="<?= base_url('assets/img/brand/favicon.png'); ?>">
        <meta name="theme-color" content="#563d7c">

        <style>
            html, body { height: 100%; }
            body {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 40px 15px;
                background-color: #f5f5f5;
            }
            .card-confirm {
                width: 100%;
                max-width: 560px;
                border-radius: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="card card-confirm shadow border-0">
            <div class="card-body p-4 p-md-5 text-center">
                <img class="mb-4" src="<?= base_url('assets/img/brand/logoLogin.png'); ?>" alt="" width="180">
                <h1 class="h3 mb-3">Cadastro realizado com sucesso!</h1>
                <p class="text-muted mb-4">
                    Enviamos um e-mail para confirmação do seu cadastro.
                    Verifique sua caixa de entrada (e o spam) e clique no link para ativar sua conta.
                </p>
                <a href="<?= base_url('PainelParticipante/login'); ?>" class="btn btn-primary btn-lg">Realizar Login</a>
            </div>
        </div>
    </body>
</html>
