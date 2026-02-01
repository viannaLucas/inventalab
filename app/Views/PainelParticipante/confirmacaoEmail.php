<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmação de Cadastro</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f7f7f7; padding: 24px;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px;margin:0 auto;background:#ffffff;border:1px solid #e5e5e5;border-radius:8px;">
        <tr>
            <td style="padding: 24px; text-align:center; border-bottom:1px solid #eee;">
                <img src="<?= esc(base_url('assets/img/brand/logoLogin.png'), 'attr') ?>" alt="InventaLab" width="160"/>
            </td>
        </tr>
        <tr>
            <td style="padding: 24px; color:#333;">
                <h2 style="margin:0 0 12px 0; font-size:20px;">Olá, <?= esc($participante->nome ?? ''); ?>!</h2>
                <p style="margin:0 0 16px 0;">Recebemos sua solicitação de cadastro no InventaLab.</p>
                <p style="margin:0 0 16px 0;">Para concluir, confirme seu e-mail clicando no botão abaixo:</p>
                <p style="margin:24px 0; text-align:center;">
                    <a href="<?= esc($confirmUrl ?? '#', 'attr'); ?>" style="background:#0d6efd;color:#fff;text-decoration:none;padding:12px 20px;border-radius:6px;display:inline-block;">Confirmar cadastro</a>
                </p>
                <p style="margin:0 0 8px 0; font-size:12px; color:#666;">Se o botão não funcionar, copie e cole o link no seu navegador:</p>
                <p style="margin:0; font-size:12px; color:#666; word-break:break-all;"><?= esc($confirmUrl ?? '', 'html'); ?></p>
                <p style="margin:24px 0 0 0; font-size:12px; color:#999;">Se você não solicitou este cadastro, ignore este e-mail.</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 12px 24px; text-align:center; font-size:12px; color:#888; border-top:1px solid #eee;">
                &copy; <?= date('Y'); ?> InventaLab
            </td>
        </tr>
    </table>
</body>
</html>

