<?php
/**
 * @var \App\Entities\EventoEntity|null $evento
 * @var \App\Entities\ControlePresencaEntity|null $controlePresenca
 */


$evento = $controlePresenca->getEvento(); 
$participantesEvento = $evento->getListParticipanteEvento();

$nomesParticipantes = [];
foreach ($participantesEvento as $pe){
    $nomesParticipantes[] = $pe->getParticipante()->nome;
}
sort($nomesParticipantes, SORT_NATURAL | SORT_FLAG_CASE);

$presencas = $controlePresenca ? $controlePresenca->getListPresencaEvento() : [];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title><?= esc($evento->nome ?? 'Lista de Presença') ?></title>
    <style>
        :root {
            --primary-text: #111;
            --border-color: #000;
            --table-header-bg: #f5f5f5;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 12pt;
            color: var(--primary-text);
            margin: 4mm 6mm 6mm;
        }

        header {
            text-align: center;
            margin-bottom: 4mm;
        }

        h1 {
            font-size: 20pt;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        h2 {
            font-size: 14pt;
            margin: 4px 0 0;
            font-weight: normal;
        }

        header p {
            margin: 2px 0 0;
            font-size: 10pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            border: 1px solid var(--border-color);
            page-break-inside: auto;
        }

        thead {
            background: var(--table-header-bg);
        }

        th, td {
            border: 1px solid var(--border-color);
            padding: 6px 8px;
            text-align: left;
            vertical-align: middle;
        }

        th + th,
        td + td {
            border-left: 1px solid var(--border-color);
        }

        th {
            font-size: 12pt;
            font-weight: 600;
        }

        td.rubrica {
            width: 35%;
            height: 14mm;
        }

        td.sem-registros {
            text-align: center;
            font-style: italic;
            color: #555;
        }

        @media print {
            body {
                margin: 4mm 6mm 6mm;
                --border-color: #000;
            }

            thead {
                background: #fff;
            }

            table, th, td {
                border-color: #000 !important;
                border-width: 1px !important;
                border-style: solid !important;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1><?= esc($evento->nome ?? 'Evento') ?></h1>
        <h2><?= esc($controlePresenca->descricao ?? '') ?></h2>
        <p>Lista gerada para uso interno do evento.</p>
        <p>Emissão: <?= esc(date('d/m/Y H:i')) ?></p>
    </header>

    <table>
        <thead>
            <tr>
                <th>Participante</th>
                <th>Rubrica</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($nomesParticipantes)): ?>
            <?php foreach ($nomesParticipantes as $nome): ?>
                <tr>
                    <td><?= esc($nome) ?></td>
                    <td class="rubrica"></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2" class="sem-registros">Nenhum participante disponível para este controle de presença.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
