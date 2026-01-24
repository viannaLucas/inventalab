<?php
$surveyUrl = $surveyUrl ?? $linkPesquisa ?? $urlPesquisa ?? '#';
$makerName = $nomeMaker ?? $nomeParticipante ?? $nome ?? 'Maker';
$labName = $nomeLaboratorio ?? 'InventaLab';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Satisfação InventaLab</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:'Segoe UI',Arial,sans-serif;color:#333333;">
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f4f4f4;">
        <tr>
            <td align="center" style="padding:24px 16px;">
                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px;background-color:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e0e0e0;">
                    <tr>
                        <td style="padding:32px 32px 16px;text-align:center;background:linear-gradient(135deg,#174f78,#1eb8d6);color:#ffffff;">
                            <h1 style="margin:0;font-size:26px;font-weight:600;">Queremos ouvir você, <?= esc($makerName) ?>!</h1>
                            <p style="margin:12px 0 0;font-size:16px;line-height:1.5;">Sua experiência no <?= esc($labName) ?> é essencial para construir um laboratório ainda mais criativo.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;font-size:15px;line-height:1.7;">
                            <p style="margin:0 0 16px;">Olá, <?= esc($makerName) ?>!</p>
                            <p style="margin:0 0 16px;">Você reservou um tempo para criar conosco e queremos garantir que cada jornada maker no <?= esc($labName) ?> seja ainda melhor. Reserve alguns minutos para responder à pesquisa de satisfação e nos contar como foi sua experiência.</p>
                            <p style="margin:0 0 16px;">Sua opinião orienta as próximas melhorias, novos recursos e oficinas que podemos oferecer à comunidade de criadores. A pesquisa é rápida e suas respostas serão mantidas em sigilo.</p>
                            <div style="text-align:center;margin:32px 0;">
                                <a href="<?= esc($surveyUrl) ?>" style="background-color:#1eb8d6;color:#ffffff;text-decoration:none;padding:14px 28px;border-radius:999px;font-size:16px;font-weight:600;display:inline-block;">Responder pesquisa agora</a>
                            </div>
                            <p style="margin:0 0 16px;">Se preferir, copie e cole este link no seu navegador: <a href="<?= esc($surveyUrl) ?>" style="color:#174f78;text-decoration:underline;word-break:break-all;"><?= esc($surveyUrl) ?></a></p>
                            <p style="margin:0;">Obrigado por colaborar com o InventaLab e por continuar impulsionando a cultura maker!</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 32px;background-color:#f9fafb;font-size:13px;color:#666666;text-align:center;">
                            <p style="margin:0;">Equipe <?= esc($labName) ?> &bull; Incentivando ideias a ganharem forma.</p>
                            <p style="margin:8px 0 0;">Se você não fez nenhuma atividade recentemente, pode ignorar este e-mail.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
