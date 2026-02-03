<?= $this->extend('PainelParticipante/template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Painel</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Alterar Perfil</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- row -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Seus Dados</h4>
        </div>
        <div class="card-body pt-0">
            <form id='formAlterar' action="<?PHP echo base_url('PainelParticipante/doAlterarPerfil'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="id" value="<?= esc($participante->id) ?>"/>
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                        <input class="form-control" name="nome" id="nome" type="text" maxlength="50" value="<?= esc($participante->nome) ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Senha</label> 
                        <input class="form-control" name="senhaAtual" id="senhaAtual" type="password" maxlength="50">
                    </div>
                    <div class="alert alert-info col-12 rounded" role="alert">
                        Deixe a senha em branco para <strong>não</strong> ser alterada.
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nova Senha</label> 
                        <input class="form-control" name="senha" id="senha" type="password" maxlength="50">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Confirmação Nova Senha</label> 
                        <input class="form-control" name="confirmaSenha" id="confirmaSenha" type="password" maxlength="50">
                    </div>
                    <!-- <div class="form-group col-12 ">
                        <label>Foto</label>
                        <input type="file" class="dropify" id="foto" name="foto" accept=".jpg,.jpeg,.webp,.png" 
                               data-allowed-file-extensions="webp png jpeg jpg" data-max-file-size="10M" >
                    </div> -->
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
                    $faturarResponsavel = trim((string) $participante->nomeResponsavel) !== '';
                ?>
                <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                    <div class="border-bottom mx-n1 mb-3">
                        <h4 class="px-2">Dados de faturamento</h4>
                    </div>
                    <div class="form-row px-2">
                        <div class="form-group col-12">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="faturarResponsavel" name="faturarResponsavel" value="1" <?= $faturarResponsavel ? 'checked' : ''; ?>>
                                <label class="custom-control-label" for="faturarResponsavel">Faturar em nome do responsável</label>
                            </div>
                            <small class="text-muted">Marque esta opção se a nota fiscal deve ser emitida em nome do responsável. Nesse caso, informe o nome do responsável abaixo.</small>
                        </div>
                        <div class="form-group col-12 col-md-6 nome-responsavel-container <?= $faturarResponsavel ? '' : 'd-none'; ?>">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome do Responsável</label> 
                            <input class="form-control" name="nomeResponsavel" id="nomeResponsavel" type="text" maxlength="100" value="<?= esc($participante->nomeResponsavel) ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">CPF</label> 
                            <input class="form-control maskCPF" name="cpf" id="cpf" type="text" maxlength="20" value="<?= esc($participante->cpf) ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">CEP</label> 
                            <input class="form-control" name="cep" id="cep" type="text" maxlength="10" value="<?= esc($participante->cep) ?>">
                        </div>
                        <div class="form-group col-12">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Logradouro</label> 
                            <input class="form-control" name="logradouro" id="logradouro" type="text" maxlength="200" value="<?= esc($participante->logradouro) ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Número</label> 
                            <input class="form-control maskNumero20" name="numero" id="numero" type="text" maxlength="20" value="<?= esc($participante->numero) ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Bairro</label> 
                            <input class="form-control" name="bairro" id="bairro" type="text" maxlength="100" value="<?= esc($participante->bairro) ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Cidade</label> 
                            <input class="form-control" name="cidade" id="cidade" type="text" maxlength="100" value="<?= esc($participante->cidade) ?>">
                        </div>
                        <input type="hidden" name="codigoCidade" id="codigoCidade" value="<?= esc($participante->codigoCidade ?? '', 'attr'); ?>">
                        <div class="form-group col-12 col-md-6">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Estado</label> 
                            <select class="form-control" name="uf" id="uf">
                                <option value=""></option>
                                <?php foreach ($ufs as $sigla => $nome) { ?>
                                    <option value="<?= esc($sigla, 'attr') ?>" <?= $participante->uf === $sigla ? 'selected' : ''; ?>><?= esc($nome) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <div class="form-group mb-0 mt-3 text-center col-12">
                    <div>
                        <button type="submit" class="btn btn-primary submitButton">Alterar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- row closed -->
<?= $this->endSection('content'); ?><?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?><?= $this->section('scripts'); ?>
<script>
    $('.submitButton').on('click', function (e) {
        // $(this).attr('disabled', true);
    });
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
    var validator = $("#formAlterar").validate({
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
        invalidHandler: function (event, validator) {
            $('.submitButton').attr('disabled', false);
        },
        errorElement: "div",
        ignore: '.ignoreValidate',
        rules: {
            nome: {
                required: true,
                minlength: 5
            },
            cpf: {
                required: true,
                cpf: true
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
            cep: {
                required: true,
                cep: true
            },
            logradouro: {
                required: true
            },
            numero: {
                inteiro: true,
                maxlength: 20,
            },
            bairro: {
                required: true
            },
            cidade: {
                required: true
            },
            uf: {
                required: true
            },
            login: {
                required: true,
                minlength: 5
            },
            senha: {
                //required: true,
                minlength: 6,
                senhaForte: true
            },
            confirmaSenha: {
                //required: true,
                equalTo: "#senha"
            },
            // foto: {
            //     arquivo: 'webp|jpg|jpeg|png'
            // }
        }
    });

    var consultaCepBaseUrl = "<?= base_url('PainelParticipante/consultaCep'); ?>";
    var ultimoCepConsultado = '';

    $('#cep').on('input', function () {
        var cep = $(this).val().replace(/\D/g, '');
        if (cep.length < 8) {
            ultimoCepConsultado = '';
            $('#codigoCidade').val('');
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
                    $('#codigoCidade').val('');
                    return;
                }
                $('#logradouro').val(data.logradouro || '');
                $('#bairro').val(data.bairro || '');
                $('#cidade').val(data.cidade || '');
                $('#uf').val(data.uf || '');
                $('#codigoCidade').val(data.codigoCidade || '');
            })
            .catch(function () {});
    });

    $('#permissaoAdmin').on('change', function (e) {
        if ($('#permissaoAdmin').prop('checked')) {
            $('.permissoesparticipante').hide();
        } else {
            $('.permissoesparticipante').show();
        }
    });

    $('#permissaoAdmin').trigger('change');
</script>    
<?= $this->endSection('scripts'); ?>
