<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>Seja Bem-Vindo - Login</title>

        <link href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?= esc(base_url('assets/css/auth.css'), 'attr') ?>" rel="stylesheet"/>

        <link rel="apple-touch-icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>" sizes="180x180">
        <link rel="icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>" sizes="32x32" type="image/png">
        <link rel="icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>" sizes="16x16" type="image/png">
        <link rel="mask-icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>" color="#563d7c">
        <link rel="icon" href="<?PHP echo base_url('assets/img/brand/favicon.png'); ?>">
        <meta name="theme-color" content="#2563eb">
    </head>
    <body class="auth-page auth-page--login">
        <main class="auth-shell">
            <section class="auth-card">
                <div class="auth-brand">
                    <span class="auth-eyebrow auth-stagger delay-1">InventaLab</span>
                    <img class="auth-logo auth-stagger delay-2" src="<?= esc(base_url('assets/img/brand/logoLogin.png'), 'attr') ?>" alt="InventaLab">
                    <h1 class="auth-title auth-stagger delay-3">Acesso do painel</h1>
                    <p class="auth-subtitle auth-stagger delay-4">Entre com suas credenciais para gerenciar o sistema.</p>
                </div>
                <div class="auth-form">
                    <div class="auth-form-header auth-stagger delay-1">
                        <div class="auth-kicker">Painel</div>
                        <h2 class="auth-form-title">Entrar</h2>
                        <p class="auth-form-subtitle">Use seu login e senha para continuar.</p>
                    </div>
                    <?PHP 
                    $msg_sucesso = session()->getFlashdata('msg_sucesso'); 
                    if($msg_sucesso != null){ 
                        echo '<div class="alert alert-success" role="alert">'.$msg_sucesso.'</div>';
                    }
                    $msg_erro = session()->getFlashdata('msg_erro'); 
                    if($msg_erro != null){ 
                        echo '<div class="alert alert-danger" role="alert">'.$msg_erro.'</div>';
                    }
                    ?>
                    <form action="<?PHP echo base_url('Painel/doLogin'); ?>" method="post">
                        <div class="form-label-group">
                            <input type="text" name="login" id="login" class="form-control" placeholder=" " value="<?= esc(old('login') ?? '', 'attr'); ?>" required autofocus autocomplete="username">
                            <label for="login">Login</label>
                        </div>
                        <div class="form-label-group">
                            <input type="password" name="senha" id="senha" class="form-control" placeholder=" " required autocomplete="current-password">
                            <label for="senha">Senha</label>
                        </div>
                        <div class="auth-actions">
                            <button class="btn btn-primary btn-lg" type="submit">Entrar</button>
                        </div>
                        <div class="auth-links">
                            <a href="<?= esc(base_url('Painel/recuperarSenha'), 'attr') ?>">Recuperar senha</a>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </body>
</html>
