<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>Recuperar Senha</title>

        <link href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?= esc(base_url('assets/css/auth.css'), 'attr') ?>" rel="stylesheet"/>

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
                    <h1 class="auth-title auth-stagger delay-3">Recuperar acesso</h1>
                    <p class="auth-subtitle auth-stagger delay-4">Vamos enviar as instruções para redefinir sua senha.</p>
                </div>
                <div class="auth-form">
                    <div class="auth-form-header auth-stagger delay-1">
                        <div class="auth-kicker">Painel</div>
                        <h2 class="auth-form-title">Recuperar senha</h2>
                        <p class="auth-form-subtitle">Informe seu e-mail cadastrado.</p>
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
                    <form action="<?PHP echo base_url('Painel/doRecuperarSenha'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <?php $honeypotName = config('Honeypot')->name ?? 'honeypot'; ?>
                        <div style="display:none">
                            <label for="hp"><?= esc(config('Honeypot')->label ?? 'Fill This Field'); ?></label>
                            <input type="text" id="hp" name="<?= esc($honeypotName, 'attr'); ?>" value="" autocomplete="off" tabindex="-1" />
                        </div>
                        <div class="form-label-group">
                            <input type="email" name="email" id="email" class="form-control" placeholder=" " value="<?= esc(old('email') ?? '', 'attr'); ?>" required autofocus autocomplete="email">
                            <label for="email">E-mail</label>
                        </div>
                        <div class="auth-actions">
                            <button class="btn btn-primary btn-lg" type="submit">Enviar instruções</button>
                        </div>
                        <div class="auth-links">
                            <a href="<?= esc(base_url('Painel/login'), 'attr') ?>">Voltar ao login</a>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </body>
</html>
