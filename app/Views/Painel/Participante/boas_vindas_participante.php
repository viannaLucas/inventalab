<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Bem-vindo ao InventaLab</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #1f2933;">
    <p>Olá <?= esc($participante->nome ?? ''); ?>,</p>
    <p>Seu acesso ao InventaLab foi criado com o e-mail <strong><?= esc($emailAcesso); ?></strong>.</p>
    <p>Para concluir o primeiro acesso, você precisa definir sua senha seguindo os passos abaixo:</p>
    <ol style="padding-left: 16px;">
        <li>Acesse a página de recuperação de senha: <a href="<?= esc($recuperarSenhaUrl, 'attr'); ?>"><?= esc($recuperarSenhaUrl); ?></a>.</li>
        <li>Informe o e-mail cadastrado e solicite a alteração de senha.</li>
        <li>Abra o e-mail de recuperação que você receberá e clique no link enviado.</li>
        <li>Escolha uma nova senha e confirme para finalizar.</li>
    </ol>
    <p>Depois disso, você já poderá entrar no painel do participante normalmente.</p>
    <p>Em caso de dúvidas, responda a este e-mail ou entre em contato com a equipe do InventaLab.</p>
    <p>Até breve,<br>Equipe InventaLab</p>
</body>
</html>
