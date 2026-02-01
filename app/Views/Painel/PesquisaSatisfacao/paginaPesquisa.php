<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pesquisa de Satisfação - InventaLab</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

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

        .survey-card__header p {
            margin-bottom: 0;
            color: #495057;
        }

        .survey-card__body {
            padding: 2rem;
        }

        .question-block + .question-block {
            margin-top: 1.75rem;
        }

        .rating-options {
            display: grid;
            grid-template-columns: repeat(11, minmax(2.1rem, 1fr));
            gap: .5rem;
            margin: .75rem 0 0;
        }

        .rating-option {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: .4rem 0;
            background-color: #f8f9fa;
            border: 1px solid rgba(13, 110, 253, 0.25);
            border-radius: .75rem;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
            font-weight: 600;
            color: #0d1b3f;
        }

        .rating-option:hover {
            transform: translateY(-1px);
            border-color: #0d6efd;
            box-shadow: 0 .45rem .85rem rgba(13, 110, 253, 0.15);
        }

        .rating-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .rating-option span {
            display: block;
            width: 100%;
            text-align: center;
            padding: .25rem 0;
            border-radius: .55rem;
            transition: background .2s ease, color .2s ease, box-shadow .2s ease;
        }

        .rating-option input:focus + span {
            box-shadow: 0 0 0 .2rem rgba(13, 110, 253, 0.3);
        }

        .rating-option input:checked + span {
            color: #ffffff;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border-radius: .55rem;
            box-shadow: 0 .55rem 1.1rem rgba(102, 16, 242, 0.2);
        }

        .form-control {
            width: 100%;
            font-size: .95rem;
        }

        .custom-control-label {
            font-size: .95rem;
        }

        .btn-secondary {
            display: block;
            width: 100%;
            font-size: 16px;
            padding: 5px;
            border-radius: 3px;
            color: #ffffff;
            background-color: #6c757d;
            border-color: #6c757d;
            transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease, border-color .2s ease;
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
            margin-top: 1.5rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
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
                <div class="survey-card">
                    <div class="survey-card__header">
                        <h1 class="mb-0">Pesquisa de Satisfação - InventaLab</h1>
                        <p>Compartilhe sua experiência e ajude a construir um espaço ainda melhor.</p>
                    </div>
                    <div class="survey-card__body">
                        <form action="<?= esc($formAction ?? '#') ?>" method="post" novalidate>
                            <input type="hidden" name="token" value="<?= esc($token ?? '') ?>">
                            <section class="question-block">
                                <h2 class="h5 text-primary">Uso geral do espaço</h2>
                                <p class="mb-2">Em uma escala de 0 a 10, qual o seu nível de satisfação com o uso geral do InventaLab (infraestrutura, organização e ambiente)?</p>
                                <div class="rating-options">
                                    <?php for ($i = 0; $i <= 10; $i++) : ?>
                                        <label class="rating-option" for="uso-geral-<?= $i ?>">
                                            <input type="radio" id="uso-geral-<?= $i ?>" name="uso_geral" value="<?= esc($i, 'attr') ?>" required>
                                            <span><?= esc($i) ?></span>
                                        </label>
                                    <?php endfor; ?>
                                </div>
                            </section>

                            <section class="question-block">
                                <h2 class="h5 text-primary">Atendimento</h2>
                                <p class="mb-2">Em uma escala de 0 a 10, como você avalia a qualidade do atendimento recebido pelos monitores e equipe do InventaLab?</p>
                                <div class="rating-options">
                                    <?php for ($i = 0; $i <= 10; $i++) : ?>
                                        <label class="rating-option" for="atendimento-<?= $i ?>">
                                            <input type="radio" id="atendimento-<?= $i ?>" name="atendimento" value="<?= esc($i, 'attr') ?>" required>
                                            <span><?= esc($i) ?></span>
                                        </label>
                                    <?php endfor; ?>
                                </div>
                            </section>

                            <section class="question-block">
                                <h2 class="h5 text-primary">Equipamentos e ferramentas</h2>
                                <p class="mb-2">Em uma escala de 0 a 10, como você avalia a variedade, disponibilidade e o estado de conservação dos equipamentos e ferramentas do InventaLab?</p>
                                <div class="rating-options">
                                    <?php for ($i = 0; $i <= 10; $i++) : ?>
                                        <label class="rating-option" for="equipamentos-<?= $i ?>">
                                            <input type="radio" id="equipamentos-<?= $i ?>" name="equipamentos" value="<?= esc($i, 'attr') ?>" required>
                                            <span><?= esc($i) ?></span>
                                        </label>
                                    <?php endfor; ?>
                                </div>
                            </section>

                            <section class="question-block">
                                <h2 class="h5 text-primary">Aprimorando o espaço</h2>
                                <p class="mb-2">Que melhorias você sugeriria para tornar o InventaLab mais funcional e atrativo?</p>
                                <textarea class="form-control" name="sugestoes" rows="4" placeholder="Compartilhe suas ideias" required></textarea>
                            </section>

                            <section class="question-block">
                                <h2 class="h5 text-primary">Dicas de atividades</h2>
                                <p class="mb-2">Quais atividades, oficinas ou projetos você gostaria de ver acontecendo no InventaLab?</p>
                                <textarea class="form-control" name="atividades" rows="4" placeholder="Conte-nos o que te inspira" required></textarea>
                            </section>

                            <div class="mt-4" style="text-align: center;">
                                <button type="submit" class="btn btn-secondary btn-lg btn-block">Enviar Respostas</button>
                            </div>
                        </form>
                        <footer>
                            <small>Obrigado por dedicar seu tempo. Seu feedback é essencial para a evolução do InventaLab.</small>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

</body>
</html>
