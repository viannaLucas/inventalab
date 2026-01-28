<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Participante</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Alterar</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- content -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Alterar</h4>
        </div>
        <div class="card-body pt-0">
            <form id='formAlterar' action="<?PHP echo base_url('Participante/doAlterar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="id" value="<?= $participante->id ?>" />
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                        <input class="form-control" name="nome" id="nome" type="text" maxlength="250" value="<?= $participante->nome ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Telefone</label> 
                        <input class="form-control maskTel" name="telefone" id="telefone" type="text" value="<?= $participante->telefone ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Email</label> 
                        <input class="form-control" name="email" id="email" type="text" maxlength="250" value="<?= $participante->email ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Nascimento</label> 
                        <input class="form-control maskData" name="dataNascimento" id="dataNascimento" type="text" value="<?= $participante->dataNascimento ?>">
                    </div>
                    <div class="form-group col-12 col-md-6 ">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            Termo Responsabilidade <?PHP if($participante->termoResponsabilidade != '') { ?>
                            <a id="btnDownloadTermo" class="btn btn-sm btn-primary ml-3" href="<?PHP echo base_url($participante->termoResponsabilidade); ?>" target="_blank">Fazer Download</a>
                            <?PHP } ?>
                        </label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="termoResponsabilidade" name="termoResponsabilidade">
                            <label class="custom-file-label" for="termoResponsabilidade" data-browse="Arquivo"></label>
                        </div>
                    </div>   
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="suspenso">Suspenso</label> 
                        <select class="form-control" name="suspenso" id="suspenso" required="" >
                            <?PHP foreach (App\Entities\ParticipanteEntity::_op('suspenso') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= ((int)$participante->suspenso) === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>                    
                    <div class="form-group col-12 ">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Observações Gerais</label> 
                        <textarea name="observacoesGerais" id="observacoesGerais" class="form-control" placeholder="" rows="3"><?= $participante->observacoesGerais ?></textarea>
                    </div>                                        
                <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                    <div class="border-bottom mx-n1 mb-3">
                        <h4 class="px-2">Lista de Habilidades</h4>
                    </div>
                    <div class="form-row px-2">
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Recurso Trabalho</label> 
                            <div class="input-group mb-3">
                                <input class="form-control" name="habilidades_RecursoTrabalho_id_Text" id="habilidades_RecursoTrabalho_id_Text" type="text" disabled="true" onclick="$('#addonSearchhabilidades_RecursoTrabalho_id').click()" value=""/>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="addonSearchhabilidades_RecursoTrabalho_id" 
                                            data-toggle="modal" data-target="#modalFK" data-title='Localizar >Recurso Trabalho'
                                            data-url-search='<?PHP echo base_url('RecursoTrabalho/pesquisaModal?searchTerm='); ?>' data-input-result='habilidades_RecursoTrabalho_id' data-input-text='habilidades_RecursoTrabalho_id_Text' >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                        </svg>
                                    </button>
                                </div>
                                <input class="d-none" name="habilidades_RecursoTrabalho_id" id="habilidades_RecursoTrabalho_id" type="text" value="" />
                            </div>
                        </div>                        
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label> 
                            <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddHabilidades">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <table class="table table-striped" id="listTableHabilidades">
                        <thead>
                            <tr>
                                <th scope="col">Recurso Trabalho</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody >
                        </tbody>
                    </table>
                    <div class="w-100 text-center msgEmptyListHabilidades mb-3">
                        <span class="h5">Sem itens selecionados</span>
                    </div>
                </fieldset>
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
                            <input class="form-control" name="nomeResponsavel" id="nomeResponsavel" type="text" maxlength="100" value="<?= $participante->nomeResponsavel ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">CPF</label> 
                            <input class="form-control maskCPF" name="cpf" id="cpf" type="text" maxlength="20" value="<?= $participante->cpf ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">CEP</label> 
                            <input class="form-control" name="cep" id="cep" type="text" maxlength="10" value="<?= $participante->cep ?>">
                        </div>
                        <div class="form-group col-12">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Logradouro</label> 
                            <input class="form-control" name="logradouro" id="logradouro" type="text" maxlength="200" value="<?= $participante->logradouro ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Número</label> 
                            <input class="form-control maskNumero20" name="numero" id="numero" type="text" maxlength="20" value="<?= $participante->numero ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Bairro</label> 
                            <input class="form-control" name="bairro" id="bairro" type="text" maxlength="100" value="<?= $participante->bairro ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Cidade</label> 
                            <input class="form-control" name="cidade" id="cidade" type="text" maxlength="100" value="<?= $participante->cidade ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Estado</label> 
                            <select class="form-control" name="uf" id="uf">
                                <option value=""></option>
                                <?php foreach ($ufs as $sigla => $nome) { ?>
                                    <option value="<?= $sigla; ?>" <?= $participante->uf === $sigla ? 'selected' : ''; ?>><?= $nome; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <div class="form-group mb-0 mt-3 text-center col-12">
                    <button type="submit" class="btn btn-primary submitButton">Alterar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="templateRowHabilidades">
    <tr id='Habilidades_{_index_}'>
        <td>
            <input type="hidden" class="form-control ignoreValidate fkRecursoTrabalho_idHabilidades" name="Habilidades[{_index_}][RecursoTrabalho_id]" readonly="true" value="{_RecursoTrabalho_id_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_RecursoTrabalho_id_Text_}" />
        </td>
        <td>
            <div class="btn btn-danger btnExcluirHabilidades" onclick="$('#Habilidades_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>
            </div>
        </td>
    </tr>
</template>
<!-- content closed -->
<?= $this->endSection('content'); ?>

<?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?>

<?= $this->section('scripts'); ?>
<script>
    $('.submitButton').on('click', function(e){
        //$(this).attr('disabled', true);
        disableValidationFieldsFK();
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
        invalidHandler: function(event, validator){
            $('.submitButton').attr('disabled', false);
            enableValidationFieldsFK();
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
            cep: {
                required: true,
                cep: true,
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
            termoResponsabilidade: {
                arquivo: 'pdf|doc|docx|xls|xlsx|csv',
            },
            suspenso: {
                required: true,
            },
            observacoesGerais: {
                required: false,
            },
            habilidades_RecursoTrabalho_id: {
                required: false,
            },
        }
    });

    var inputsHabilidades = [
        'habilidades_RecursoTrabalho_id',
    ];
    
    $('#btnAddHabilidades').on('click', function (e) {
        addHabilidades();
    });

    function disableValidationFieldsFK() {
        for (var i in inputsHabilidades) {
            $('#' + inputsHabilidades[i]).addClass('ignoreValidate');
        }
    }

    function enableValidationFieldsFK() {
        for (var i in inputsHabilidades) {
            $('#' + inputsHabilidades[i]).removeClass('ignoreValidate');
        }
    }

    var indexRowHabilidades = 0;
    function addHabilidades() {
        $('.msgEmptyListHabilidades').addClass('d-none');
        //$('#listTableHabilidades').removeClass('d-none');
        let error = false;
        for (var i in inputsHabilidades) {
            if (!$('#' + inputsHabilidades[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        let dados = {};
        dados.RecursoTrabalho_id = $('#habilidades_RecursoTrabalho_id').val();
        dados.RecursoTrabalho_id_Text = $('#habilidades_RecursoTrabalho_id_Text').val();
            
        insertRowHabilidades(dados);
        
        $('#habilidades_RecursoTrabalho_id').val('');
        $('#habilidades_RecursoTrabalho_id_Text').val('');
    }
    
    function insertRowHabilidades(dados){
        let html = $('#templateRowHabilidades').html();
        html = html.replaceAll('{_index_}', indexRowHabilidades);
        html = html.replaceAll('{_RecursoTrabalho_id_}', dados.RecursoTrabalho_id);
        html = html.replaceAll('{_RecursoTrabalho_id_Text_}', dados.RecursoTrabalho_id_Text);
        $('#listTableHabilidades tbody').append(html);
        
        indexRowHabilidades++;
        $(".msgEmptyListHabilidades").hide();
    }

<?PHP foreach ($participante->getListHabilidades() as $i => $o) {
    $o->RecursoTrabalho_id_Text = $o->getRecursoTrabalho()->nome;
?>
    insertRowHabilidades(<?= json_encode($o) ?>);
<?PHP } ?>

    // Update file label when a new file is selected
    $('#termoResponsabilidade').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass("selected").html(fileName);
    });
</script>    
<?= $this->endSection('scripts'); ?>
