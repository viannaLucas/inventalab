<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>Seja Bem-Vindo - Login</title>

        <!-- Bootstrap core CSS -->
        <!-- Bootstrap css-->
        <link href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

        <!-- Favicons -->
        <link rel="apple-touch-icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>" sizes="180x180">
        <link rel="icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>" sizes="32x32" type="image/png">
        <link rel="icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>" sizes="16x16" type="image/png">
        <link rel="mask-icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>" color="#563d7c">
        <link rel="icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>">
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
                margin-bottom: 0; /* Override default `<label>` margin */
                line-height: 1.5;
                color: #495057;
                pointer-events: none;
                cursor: text; /* Match the input under the label */
                border: 1px solid transparent;
                border-radius: .25rem;
                transition: all .1s ease-in-out;
            }

            .form-label-group input::-webkit-input-placeholder {
                color: transparent;
            }

            .form-label-group input::-moz-placeholder {
                color: transparent;
            }

            .form-label-group input:-ms-input-placeholder {
                color: transparent;
            }

            .form-label-group input::-ms-input-placeholder {
                color: transparent;
            }

            .form-label-group input::placeholder {
                color: transparent;
            }

            .form-label-group input:not(:-moz-placeholder-shown) {
                padding-top: 1.25rem;
                padding-bottom: .25rem;
            }

            .form-label-group input:not(:-ms-input-placeholder) {
                padding-top: 1.25rem;
                padding-bottom: .25rem;
            }

            .form-label-group input:not(:placeholder-shown) {
                padding-top: 1.25rem;
                padding-bottom: .25rem;
            }

            .form-label-group input:not(:-moz-placeholder-shown) ~ label {
                padding-top: .25rem;
                padding-bottom: .25rem;
                font-size: 12px;
                color: #777;
            }

            .form-label-group input:not(:-ms-input-placeholder) ~ label {
                padding-top: .25rem;
                padding-bottom: .25rem;
                font-size: 12px;
                color: #777;
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

            /* Fallback for Edge
            -------------------------------------------------- */
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
        <form action="<?PHP echo base_url('Painel/doLogin'); ?>" method="post" class="form-signin border border-3 p-3 rounded-lg bg-white shadow">
            <div class="text-center mb-4">
                <img class="mb-4" src="<?= base_url('assets/img/brand/logoLogin.png'); ?>" alt="" width="200">
                <h1 class="h3 mb-3 font-weight-normal">Bem-Vindo</h1>
                <p>Realize o login para continuar</p>
                <?PHP 
                $msg_erro = session()->getFlashdata('msg_erro'); 
                if($msg_erro != null){ 
                    echo '<div class="alert alert-danger" role="alert">'.$msg_erro.'</div>';
                }
                ?>
            </div>
            <div class="form-label-group">
                <input type="text" name="login" id="login" class="form-control" required autofocus>
                <label for="login">Login</label>
            </div>
            <div class="form-label-group">
                <input type="password" name="senha" id="senha" class="form-control" required>
                <label for="senha">Senha</label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
        </form>

    </body>
</html>
