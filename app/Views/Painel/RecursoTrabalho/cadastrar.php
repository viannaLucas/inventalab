<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Recurso Trabalho</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Cadastrar</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- content -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Cadastrar</h4>
        </div>
        <div class="card-body pt-0">
            <form id='formCadastrar' action="<?PHP echo base_url('RecursoTrabalho/doCadastrar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                        <input class="form-control" name="nome" id="nome" type="text" maxlength="200" value="<?= old('nome') ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="tipo">Tipo</label> 
                        <select class="form-control" name="tipo" id="tipo" required="" >
                            <option value="" <?= old('tipo')=='' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\RecursoTrabalhoEntity::_op('tipo') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= old('tipo') === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>                    
                    <div class="form-group col-12 ">
                        <label>Foto</label>
                        <input type="file" class="dropify" id="foto" name="foto" accept=".jpg,.jpeg,.webp,.png" 
                               data-allowed-file-extensions="webp png jpeg jpg" data-max-file-size="10M" >
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Marca do Fabricante</label> 
                        <input class="form-control" name="marcaFabricante" id="marcaFabricante" type="text" maxlength="200" value="<?= old('marcaFabricante') ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Descrição</label> 
                        <input class="form-control" name="descricao" id="descricao" type="text" maxlength="200" value="<?= old('descricao') ?>">
                    </div>
                    <div class="form-group col-12 col-md-6 campo-equipamento<?= old('tipo') === '1' ? '' : ' d-none'; ?>">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="requerHabilidade">Requer Habilidade</label> 
                        <select class="form-control" name="requerHabilidade" id="requerHabilidade" required="" >
                            <option value="" <?= old('requerHabilidade')=='' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\RecursoTrabalhoEntity::_op('requerHabilidade') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= old('requerHabilidade') === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>                    
                    <div class="form-group col-12 col-md-6 campo-equipamento<?= old('tipo') === '1' ? '' : ' d-none'; ?>">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="usoExclusivo">Uso Exclusivo</label> 
                        <select class="form-control" name="usoExclusivo" id="usoExclusivo" required="" >
                            <option value="" <?= old('usoExclusivo')=='' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\RecursoTrabalhoEntity::_op('usoExclusivo') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= old('usoExclusivo') === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="situacaoTrabalho">Situação Trabalho</label> 
                        <select class="form-control" name="situacaoTrabalho" id="situacaoTrabalho" required="" >
                            <option value="" <?= old('situacaoTrabalho')=='' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\RecursoTrabalhoEntity::_op('situacaoTrabalho') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= old('situacaoTrabalho') === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>                                        
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Quantidade Disponível</label> 
                        <input class="form-control maskInteiro" name="quantidadeDisponivel" id="quantidadeDisponivel" type="text" maxlength="200" value="<?= old('quantidadeDisponivel') ?>">
                    </div>
                </div>
                <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                    <div class="border-bottom mx-n1 mb-3">
                        <h4 class="px-2">Lista de Garantia</h4>
                    </div>
                    <div class="form-row px-2"><div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Descrição</label> 
                            <input class="form-control" name="garantia_descricao" id="garantia_descricao" type="text" maxlength="200" value="<?= old('garantia_descricao') ?>">
                        </div>                        
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600" for="garantia_tipo">Tipo</label> 
                            <select class="form-control" name="garantia_tipo" id="garantia_tipo" required="" >
                                <option value="" <?= old('garantia_tipo')=='' ? 'selected' : ''; ?>></option>
                                <?PHP foreach (App\Entities\GarantiaEntity::_op('tipo') as $k => $op){ ?>
                                <option value="<?= $k; ?>" <?= old('garantia_tipo') === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                                <?PHP } ?>
                            </select>
                        </div>                        
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Início</label> 
                            <input class="form-control maskData" name="garantia_dataInicio" id="garantia_dataInicio" type="text" value="<?= old('garantia_dataInicio') ?>">
                        </div>                        
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Fim</label> 
                            <input class="form-control maskData" name="garantia_dataFim" id="garantia_dataFim" type="text" value="<?= old('garantia_dataFim') ?>">
                        </div>                        
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label> 
                            <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddGarantia">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <table class="table table-striped" id="listTableGarantia">
                        <thead>
                            <tr>
                                <th scope="col">Descrição</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Data Início</th>
                                <th scope="col">Data Fim</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody >
                        </tbody>
                    </table>
                    <div class="w-100 text-center msgEmptyListGarantia mb-3">
                        <span class="h5">Sem itens selecionados</span>
                    </div>
                </fieldset>
                <div class="form-group mb-0 mt-3 text-center col-12">
                    <button type="submit" class="btn btn-primary submitButton">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="templateRowGarantia">
    <tr id='Garantia_{_index_}'>
        <td><input type="text" class="form-control ignoreValidate" name="Garantia[{_index_}][descricao]" readonly="true" value="{_descricao_}" /></td>
        <td>
            <input type="hidden" class="form-control ignoreValidate tipoGarantia" name="Garantia[{_index_}][tipo]" readonly="true" value="{_tipo_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_tipo_Text_}" />
        </td>
        <td><input type="text" class="form-control ignoreValidate" name="Garantia[{_index_}][dataInicio]" readonly="true" value="{_dataInicio_}" /></td>
        <td><input type="text" class="form-control ignoreValidate" name="Garantia[{_index_}][dataFim]" readonly="true" value="{_dataFim_}" /></td>
        <td>
            <div class="btn btn-danger btnExcluirGarantia" onclick="$('#Garantia_{_index_}').remove();">
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
            enableValidationFieldsFK();
        },
        errorElement: "div",
        ignore: '.ignoreValidate',
        rules: {
            nome: {
                required: true,
            },
            tipo: {
                required: true,
            },
            foto: {
                required: true,
                arquivo: 'webp|jpg|jpeg|png',
            },
            marcaFabricante: {
                required: false,
            },
            descricao: {
                required: true,
            },
            requerHabilidade: {
                required: {
                    depends: function () {
                        return $('#tipo').val() === '1';
                    }
                },
            },
            usoExclusivo: {
                required: {
                    depends: function () {
                        return $('#tipo').val() === '1';
                    }
                },
            },
            situacaoTrabalho: {
                required: true,
            },
            garantia_descricao: {
                required: true,
            },
            garantia_tipo: {
                required: true,
            },
            garantia_dataInicio: {
                required: true,
                dataBR: true,
            },
            garantia_dataFim: {
                required: true,
                dataBR: true,
            },
            quantidadeDisponivel: {
                required: true,
                inteiro: true,
            }
        }
    });

    $('#tipo').on('change', function () {
        toggleEquipamentoFields();
    });

    toggleEquipamentoFields();

    function toggleEquipamentoFields() {
        var isEquipamento = $('#tipo').val() === '1';
        $('.campo-equipamento').toggleClass('d-none', !isEquipamento);

        $('#requerHabilidade, #usoExclusivo').each(function () {
            $(this).prop('required', isEquipamento);
            if (!isEquipamento) {
                $(this).removeClass('is-invalid is-valid');
                validator.element(this);
            }
        });
    }

    var inputsGarantia = [
        'garantia_descricao',
        'garantia_tipo',
        'garantia_dataInicio',
        'garantia_dataFim',
    ];
    
    $('#btnAddGarantia').on('click', function (e) {
        addGarantia();
    });

    function disableValidationFieldsFK() {
        for (var i in inputsGarantia) {
            $('#' + inputsGarantia[i]).addClass('ignoreValidate');
        }
    }

    function enableValidationFieldsFK() {
        for (var i in inputsGarantia) {
            $('#' + inputsGarantia[i]).removeClass('ignoreValidate');
        }
    }

    var indexRowGarantia = 0;
    function addGarantia() {
        $('.msgEmptyListGarantia').addClass('d-none');
        //$('#listTableGarantia').removeClass('d-none');
        let error = false;
        for (var i in inputsGarantia) {
            if (!$('#' + inputsGarantia[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        let html = $('#templateRowGarantia').html();
        html = html.replaceAll('{_index_}', indexRowGarantia);
        html = html.replaceAll('{_descricao_}', $('#garantia_descricao').val());
        html = html.replaceAll('{_tipo_}', $('#garantia_tipo').val());
        html = html.replaceAll('{_tipo_Text_}', $('#garantia_tipo option:selected').text());
        html = html.replaceAll('{_dataInicio_}', $('#garantia_dataInicio').val());
        html = html.replaceAll('{_dataFim_}', $('#garantia_dataFim').val());
        $('#listTableGarantia tbody').append(html);

        $('#garantia_descricao').val('');
        $('#garantia_tipo').val('');
        $('#garantia_dataInicio').val('');
        $('#garantia_dataFim').val('');
        indexRowGarantia++;
    }
</script>    
<?= $this->endSection('scripts'); ?>
