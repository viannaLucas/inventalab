<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Cadastro de Participante</title>
        <link href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?= base_url('assets/css/auth.css'); ?>" rel="stylesheet"/>
        <link rel="icon" href="<?= base_url('assets/img/brand/favicon.png'); ?>">
        <meta name="theme-color" content="#2563eb">
    </head>
    <body class="auth-page auth-page--signup">
        <main class="auth-shell auth-shell--wide">
            <section class="auth-card auth-card--wide">
                <div class="auth-brand">
                    <span class="auth-eyebrow auth-stagger delay-1">InventaLab</span>
                    <img class="auth-logo auth-stagger delay-2" src="<?= base_url('assets/img/brand/logoLogin.png'); ?>" alt="InventaLab">
                    <h1 class="auth-title auth-stagger delay-3">Crie sua conta</h1>
                    <p class="auth-subtitle auth-stagger delay-4">Um cadastro simples para acompanhar inscrições, acessos e atualizações.</p>
                </div>
                <div class="auth-form">
                    <div class="auth-form-header auth-stagger delay-1">
                        <div class="auth-kicker">Cadastro</div>
                        <h2 class="auth-form-title">Criar conta de participante</h2>
                        <p class="auth-form-subtitle">Preencha os dados abaixo para concluir seu cadastro.</p>
                    </div>
                    <?php
                    $msg_sucesso = session()->getFlashdata('msg_sucesso');
                    if ($msg_sucesso) {
                        echo '<div class="alert alert-success" role="alert">' . esc($msg_sucesso) . '</div>';
                    }
                    $msg_erro = session()->getFlashdata('msg_erro');
                    if ($msg_erro) {
                        echo '<div class="alert alert-danger" role="alert">' . nl2br(esc($msg_erro)) . '</div>';
                    }
                    ?>
                    <form action="<?= base_url('PainelParticipante/doCadastrar'); ?>" id='formCadastrar' method="post" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" name="nome" id="nome" class="form-control" placeholder=" " value="<?= esc(old('nome') ?? '', 'attr'); ?>" required>
                                    <label for="nome">Nome</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="email" name="email" id="email" class="form-control" placeholder=" " value="<?= esc(old('email') ?? '', 'attr'); ?>" required>
                                    <label for="email">E-mail</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" name="telefone" id="telefone" class="form-control maskTel" placeholder=" " value="<?= esc(old('telefone') ?? '', 'attr'); ?>" required>
                                    <label for="telefone">Telefone</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" name="dataNascimento" id="dataNascimento" class="form-control maskData" placeholder=" " value="<?= esc(old('dataNascimento') ?? '', 'attr'); ?>" required>
                                    <label for="dataNascimento">Data de Nascimento</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="password" name="senha" id="senha" class="form-control" placeholder=" " required minlength="6">
                                    <label for="senha">Senha</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="password" name="confirmaSenha" id="confirmaSenha" class="form-control" placeholder=" " required minlength="6">
                                    <label for="confirmaSenha">Confirmar Senha</label>
                                </div>
                            </div>
                        </div>
                        <?php
                        $ufs = [
                            'AC' => 'Acre',
                            'AL' => 'Alagoas',
                            'AP' => 'Amapá',
                            'AM' => 'Amazonas',
                            'BA' => 'Bahia',
                            'CE' => 'Ceará',
                            'DF' => 'Distrito Federal',
                            'ES' => 'Espírito Santo',
                            'GO' => 'Goiás',
                            'MA' => 'Maranhão',
                            'MT' => 'Mato Grosso',
                            'MS' => 'Mato Grosso do Sul',
                            'MG' => 'Minas Gerais',
                            'PA' => 'Pará',
                            'PB' => 'Paraíba',
                            'PR' => 'Paraná',
                            'PE' => 'Pernambuco',
                            'PI' => 'Piauí',
                            'RJ' => 'Rio de Janeiro',
                            'RN' => 'Rio Grande do Norte',
                            'RS' => 'Rio Grande do Sul',
                            'RO' => 'Rondônia',
                            'RR' => 'Roraima',
                            'SC' => 'Santa Catarina',
                            'SP' => 'São Paulo',
                            'SE' => 'Sergipe',
                            'TO' => 'Tocantins',
                        ];
                        $ufSelecionada = old('uf') ?? '';
                        $faturarResponsavel = old('faturarResponsavel');
                        $faturarResponsavelChecked = ($faturarResponsavel === '1' || $faturarResponsavel === 'on' || old('nomeResponsavel'));
                        ?>
                        <div class="row g-3 mt-2">
                            <div class="col-12">
                                <div class="form-check auth-check">
                                    <input class="form-check-input" type="checkbox" id="faturarResponsavel" name="faturarResponsavel" value="1" <?= $faturarResponsavelChecked ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="faturarResponsavel">Não tenho CPF</label>
                                </div>
                                <small class="text-muted auth-help">Se você é menor de idade e ainda não possui CPF, marque esta opção e informe os dados do responsável pelo pagamento.</small>
                            </div>
                            <div class="col-md-6 nome-responsavel-container <?= $faturarResponsavelChecked ? '' : 'd-none'; ?>">
                                <div class="form-label-group">
                                    <input type="text" name="nomeResponsavel" id="nomeResponsavel" class="form-control" placeholder=" " value="<?= esc(old('nomeResponsavel') ?? '', 'attr'); ?>" maxlength="100">
                                    <label for="nomeResponsavel">Nome do Responsável</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" name="cpf" id="cpf" class="form-control maskCPF" placeholder=" " value="<?= esc(old('cpf') ?? '', 'attr'); ?>" maxlength="20" required>
                                    <label for="cpf">CPF</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" name="cep" id="cep" class="form-control" placeholder=" " value="<?= esc(old('cep') ?? '', 'attr'); ?>" maxlength="10" required>
                                    <label for="cep">CEP</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-label-group">
                                    <input type="text" name="logradouro" id="logradouro" class="form-control" placeholder=" " value="<?= esc(old('logradouro') ?? '', 'attr'); ?>" maxlength="200" required>
                                    <label for="logradouro">Logradouro</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" name="numero" id="numero" class="form-control maskNumero20" placeholder=" " value="<?= esc(old('numero') ?? '', 'attr'); ?>" maxlength="20">
                                    <label for="numero">Número</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" name="bairro" id="bairro" class="form-control" placeholder=" " value="<?= esc(old('bairro') ?? '', 'attr'); ?>" maxlength="100" required>
                                    <label for="bairro">Bairro</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" name="cidade" id="cidade" class="form-control" placeholder=" " value="<?= esc(old('cidade') ?? '', 'attr'); ?>" maxlength="100" required>
                                    <label for="cidade">Cidade</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <select name="uf" id="uf" class="form-control" required>
                                        <option value=""></option>
                                        <?php foreach ($ufs as $sigla => $nome) { ?>
                                            <option value="<?= $sigla; ?>" <?= $ufSelecionada === $sigla ? 'selected' : ''; ?>><?= $nome; ?></option>
                                        <?php } ?>
                                    </select>
                                    <label for="uf">Estado</label>
                                </div>
                            </div>
                        </div>
                        <div class="auth-actions">
                            <a class="btn btn-outline-secondary btn-lg" href="<?= base_url('PainelParticipante/login'); ?>">Cancelar</a>
                            <button class="btn btn-primary btn-lg" type="submit">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
        <script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/jQueryValidate/jquery.validate.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/validacoes.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/jQueryValidate/validacoesPersonalizadas.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/jQueryValidate/localization/messages_pt_BR.js"></script>
        <script src="<?= base_url(); ?>assets/js/jquery.mask.min.js"></script>

        <script>
            // Mascara telefone
            var funcMaskTelefone = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            };
            var opstMaskTelefone = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(funcMaskTelefone.apply({}, arguments), options);
                }
            };
            $('.maskTel').mask(funcMaskTelefone, opstMaskTelefone);
            $('.maskCPF').mask('000.000.000-00', {reverse: true});
            $('.maskData').mask('00/00/0000', {reverse: true});
            $('.maskNumero20').mask('00000000000000000000');
            function toggleNomeResponsavel() {
                var checked = $('#faturarResponsavel').is(':checked');
                var container = $('.nome-responsavel-container');
                if (checked) {
                    container.removeClass('d-none');
                } else {
                    container.addClass('d-none');
                    $('#nomeResponsavel').val('');
                }
            }
            $('#faturarResponsavel').on('change', toggleNomeResponsavel);
            toggleNomeResponsavel();
        
            $('.submitButton').on('click', function(e){
                //$(this).attr('disabled', true);
            });
            var validator = $("#formCadastrar").validate({
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    error.appendTo(element.parent());
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-valid').addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
                onfocusout: function (element) {
                    if (!this.checkable(element)) {
                        this.element(element);
                    }
                },
                invalidHandler: function(event, validator){
                    $('.submitButton').attr('disabled', false);
                },
                errorElement: "div",
                ignore: '.ignoreValidate',
                rules: {
                    nome: {
                        required: true,
                    },
                    telefone: {
                        required: true,
                        telefone: true,
                    },
                    cpf: {
                        required: true,
                        cpf: true,
                    },
                    nomeResponsavel: {
                        required: function () {
                            return $('#faturarResponsavel').is(':checked');
                        },
                        minlength: {
                            param: 5,
                            depends: function () {
                                return $('#faturarResponsavel').is(':checked');
                            }
                        }
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    dataNascimento: {
                        required: true,
                        dataBR: true,
                    },
                    logradouro: {
                        required: true,
                    },
                    numero: {
                        inteiro: true,
                        maxlength: 20,
                    },
                    bairro: {
                        required: true,
                    },
                    cidade: {
                        required: true,
                    },
                    uf: {
                        required: true,
                    },
                    cep: {
                        required: true,
                        cep: true,
                    },
                    senha: {
                        required: true,
                        minlength: 6,
                        senhaForte: true,
                    },
                    confirmaSenha: {
                        required: true,
                        minlength: 6,
                        equalTo: '#senha',
                    },
                }
            });

            var consultaCepBaseUrl = "<?= base_url('PainelParticipante/consultaCep'); ?>";
            var ultimoCepConsultado = '';

            $('#cep').on('input', function () {
                var cep = $(this).val().replace(/\D/g, '');
                if (cep.length < 8) {
                    ultimoCepConsultado = '';
                    return;
                }
                if (cep.length !== 8 || cep === ultimoCepConsultado) {
                    return;
                }
                ultimoCepConsultado = cep;

                fetch(consultaCepBaseUrl + '/' + cep, {
                    headers: {
                        'Accept': 'application/json',
                    },
                })
                    .then(function (response) {
                        if (!response.ok) {
                            throw new Error('Erro HTTP ' + response.status);
                        }
                        return response.json();
                    })
                    .then(function (data) {
                        if (data.erro) {
                            return;
                        }
                        $('#logradouro').val(data.logradouro || '');
                        $('#bairro').val(data.bairro || '');
                        $('#cidade').val(data.cidade || '');
                        $('#uf').val(data.uf || '');
                    })
                    .catch(function () {});
            });
        </script>    
    </body>
</html>
