<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Recuperação de senha</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #1f2933;">
    <p>Olá <?= esc($participante->nome ?? ''); ?>,</p>
    <p>Recebemos um pedido para redefinir a senha da sua conta no InventaLab. Para continuar, clique no botão abaixo ou copie o link e cole no seu navegador.</p>
    <p style="margin: 24px 0;">
        <a href="<?= esc($resetUrl, 'attr'); ?>" style="background-color: #007bff; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 4px; display: inline-block;">Definir nova senha</a>
    </p>
    <p>Link direto: <br><a href="<?= esc($resetUrl, 'attr'); ?>"><?= esc($resetUrl); ?></a></p>
    <p>Se você não solicitou essa alteração, ignore este e-mail – sua senha permanecerá a mesma.</p>
    <p>Até breve,<br>Equipe InventaLab</p>
</body>
</html>
