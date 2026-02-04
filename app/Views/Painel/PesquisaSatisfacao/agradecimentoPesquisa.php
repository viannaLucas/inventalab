<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pesquisa de Satisfação - Obrigado</title>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/cdn/bootstrap-4.6.0.min.css') ?>">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .survey-card {
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 1.25rem 2.5rem rgba(13, 110, 253, 0.15);
            overflow: hidden;
            width: 100%;
        }

        .survey-card__header {
            background: rgba(13, 110, 253, 0.1);
            padding: 2rem 2rem 1.5rem;
        }

        .survey-card__header h1 {
            font-size: 1.75rem;
            margin-bottom: .5rem;
            color: #0d1b3f;
        }

        .survey-card__body {
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .lead {
            color: #495057;
        }

        .success-icon {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            box-shadow: 0 .75rem 1.5rem rgba(13, 110, 253, 0.3);
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.75rem;
            font-weight: 600;
        }

        .btn-secondary {
            display: inline-block;
            color: #ffffff;
            background-color: #6c757d;
            border-color: #6c757d;
            transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease, border-color .2s ease;
            padding: .75rem 2.5rem;
            border-radius: .65rem;
            font-weight: 600;
        }

        .btn-secondary:hover,
        .btn-secondary:focus {
            color: #ffffff;
            background-color: #5c636a;
            border-color: #565e64;
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(108, 117, 125, 0.25);
        }

        footer {
            font-size: .85rem;
            color: rgba(73, 80, 87, 0.8);
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6">
                <div class="survey-card">
                    <div class="survey-card__header">
                        <h1 class="mb-0">Obrigado pela sua resposta!</h1>
                    </div>
                    <div class="survey-card__body">
                        <div class="success-icon">✓</div>
                        <p class="lead mb-3">Recebemos seu feedback com sucesso.</p>
                        <p class="mb-4">A sua contribuição é essencial para que o InventaLab continue evoluindo e oferecendo experiências cada vez melhores.</p>
                        <a href="<?= esc(base_url('PainelParticipante/home'), 'attr') ?>" class="btn btn-secondary">Voltar ao Painel</a>
                        <footer>
                            <small>Até breve! Continue contando com o InventaLab.</small>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/vendor/cdn/jquery-3.5.1.slim.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/cdn/popper-1.16.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/cdn/bootstrap-4.6.0.min.js') ?>"></script>
</body>
</html>
