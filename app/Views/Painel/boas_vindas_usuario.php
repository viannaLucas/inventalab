<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Bem-vindo ao InventaLab</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #1f2933;">
    <p>Olá <?= esc($usuario->nome ?? ''); ?>,</p>
    <p>Bem-vindo(a) ao InventaLab! Seu acesso foi criado com o e-mail <strong><?= esc($usuario->login ?? ''); ?></strong>.</p>
    <p>Por segurança, você precisa definir uma senha antes do primeiro acesso. Siga os passos abaixo:</p>
    <ol style="padding-left: 16px;">
        <li>Acesse a página de recuperação de senha: <a href="<?= esc($recuperarSenhaUrl, 'attr'); ?>"><?= esc($recuperarSenhaUrl); ?></a>.</li>
        <li>Informe o e-mail cadastrado e solicite a alteração de senha.</li>
        <li>Abra o e-mail de recuperação que você receberá em instantes e clique no link enviado.</li>
        <li>Escolha uma nova senha e confirme para concluir.</li>
    </ol>
    <p>Depois de definir a nova senha, você já poderá entrar no InventaLab normalmente.</p>
    <p>Se precisar de ajuda, responda a este e-mail ou procure a equipe responsável.</p>
    <p>Até breve,<br>Equipe InventaLab</p>
</body>
</html>
