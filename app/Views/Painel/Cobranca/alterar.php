<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Cobrança</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Alterar</span>
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
            <form id='formAlterar' action="<?PHP echo base_url('Cobranca/doAlterar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $cobranca->id ?>" />
                <div class="form-row">

                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Participante</label>
                        <div class="input-group">
                            <input class="form-control" name="Participante_id_Text" id="Participante_id_Text" type="text" disabled="true" onclick="$('#addonSearchParticipante_id').click()" value="<?= $cobranca->getParticipante()->nome ?>" />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="addonSearchParticipante_id"
                                    data-toggle="modal" data-target="#modalFK" data-title='Localizar Participante'
                                    data-url-search='<?PHP echo base_url('Participante/pesquisaModal?searchTerm='); ?>' data-input-result='Participante_id' data-input-text='Participante_id_Text'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </button>
                            </div>
                            <input class="d-none" name="Participante_id" id="Participante_id" type="text" value="<?= $cobranca->Participante_id ?>" />
                        </div>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data</label>
                        <input class="form-control maskData" name="data" id="data" type="text" value="<?= $cobranca->data ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Valor</label>
                        <input class="form-control maskReal" name="valor" id="valor" type="text" value="<?= $cobranca->valor ?>" readonly="true">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="situacao">Situação</label>
                        <select class="form-control" name="situacao" id="situacao" required="">
                            <?PHP foreach (App\Entities\CobrancaEntity::_op('situacao') as $k => $op) { ?>
                                <option value="<?= $k; ?>" <?= ((int)$cobranca->situacao) === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>
                    <div class="form-group col-12 ">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Observações</label>
                        <textarea name="observacoes" id="observacoes" class="form-control" placeholder="" rows="3"><?= $cobranca->observacoes ?></textarea>
                    </div>
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <div class="border-bottom mx-n1 mb-3">
                            <h4 class="px-2">Lista de Cobrança Serviço</h4>
                        </div>
                        <?php if ((int) $cobranca->situacao !== 1) : ?>
                        <div class="form-row px-2">
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Serviço</label>
                                <div class="input-group mb-3">
                                    <input class="form-control" name="cobrancaservico_Servico_id_Text" id="cobrancaservico_Servico_id_Text" type="text" disabled="true" onclick="$('#addonSearchcobrancaservico_Servico_id').click()" value="" />
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="addonSearchcobrancaservico_Servico_id"
                                            data-toggle="modal" data-target="#modalFK" data-title='Localizar >Serviço'
                                            data-url-search='<?PHP echo base_url('Servico/pesquisaModal?searchTerm='); ?>' data-input-result='cobrancaservico_Servico_id' data-input-text='cobrancaservico_Servico_id_Text'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input class="d-none" name="cobrancaservico_Servico_id" id="cobrancaservico_Servico_id" type="text" value="" />
                                </div>
                            </div>
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Quantidade</label>
                                <input class="form-control maskInteiro" name="cobrancaservico_quantidade" id="cobrancaservico_quantidade" type="text" value="">
                            </div>
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Valor Unitário</label>
                                <input class="form-control maskReal" name="cobrancaservico_valorUnitario" id="cobrancaservico_valorUnitario" type="text" value="">
                            </div>
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label>
                                <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddCobrancaServico">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <?php endif; ?>
                        <table class="table table-striped" id="listTableCobrancaServico">
                            <thead>
                                <tr>
                                    <th scope="col">Serviço</th>
                                    <th scope="col">Quantidade</th>
                                    <th scope="col">Valor Unitário</th>
                                    <?php if ((int) $cobranca->situacao !== 1) : ?>
                                    <th scope="col">Ações</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="w-100 text-center msgEmptyListCobrancaServico mb-3">
                            <span class="h5">Sem itens selecionados</span>
                        </div>
                    </fieldset>
                    <?php if (false) : // PRODUTOS_DESATIVADOS ?>
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <div class="border-bottom mx-n1 mb-3">
                            <h4 class="px-2">Lista de Cobrança Produto</h4>
                        </div>
                        <?php if ((int) $cobranca->situacao !== 1) : ?>
                        <div class="form-row px-2">
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Produto</label>
                                <div class="input-group mb-3">
                                    <input class="form-control" name="cobrancaproduto_Produto_id_Text" id="cobrancaproduto_Produto_id_Text" type="text" disabled="true" onclick="$('#addonSearchcobrancaproduto_Produto_id').click()" value="" />
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="addonSearchcobrancaproduto_Produto_id"
                                            data-toggle="modal" data-target="#modalFK" data-title='Localizar Produto'
                                            data-url-search='<?PHP echo base_url('Produto/pesquisaModal?searchTerm='); ?>' data-input-result='cobrancaproduto_Produto_id' data-input-text='cobrancaproduto_Produto_id_Text'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input class="d-none" name="cobrancaproduto_Produto_id" id="cobrancaproduto_Produto_id" type="text" value="" />
                                </div>
                            </div>
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Quantidade</label>
                                <input class="form-control maskInteiro" name="cobrancaproduto_quantidade" id="cobrancaproduto_quantidade" type="text" value="">
                            </div>
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Valor Unitário</label>
                                <input class="form-control maskReal" name="cobrancaproduto_valorUnitario" id="cobrancaproduto_valorUnitario" type="text" value="">
                            </div>
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label>
                                <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddCobrancaProduto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <?php endif; ?>
                        <table class="table table-striped" id="listTableCobrancaProduto">
                            <thead>
                                <tr>
                                    <th scope="col">Produto</th>
                                    <th scope="col">Quantidade</th>
                                    <th scope="col">Valor Unitário</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="w-100 text-center msgEmptyListCobrancaProduto mb-3">
                            <span class="h5">Sem itens selecionados</span>
                        </div>
                    </fieldset>
                    <?php endif; ?>
                    <div class="form-group mb-0 mt-3 text-center col-12">
                        <?php if ((int) $cobranca->situacao !== 1) { ?>
                        <button type="submit" class="btn btn-primary submitButton">Alterar</button>
                        <?php }else{ ?>
                        <button type="button" onclick="history.back()" class="btn btn-primary submitButton">Voltar</button>
                        <?php } ;?>
                    </div>
            </form>
        </div>
    </div>
</div>

<template id="templateRowCobrancaServico">
    <tr id='CobrancaServico_{_index_}'>
        <td>
            <input type="hidden" class="form-control ignoreValidate fkServico_idCobrancaServico" name="CobrancaServico[{_index_}][Servico_id]" readonly="true" value="{_Servico_id_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_Servico_id_Text_}" />
        </td>
        <td><input type="text" class="form-control ignoreValidate" name="CobrancaServico[{_index_}][quantidade]" readonly="true" value="{_quantidade_}" /></td>
        <td><input type="text" class="form-control ignoreValidate" name="CobrancaServico[{_index_}][valorUnitario]" readonly="true" value="{_valorUnitario_}" /></td>
        <?php if ((int) $cobranca->situacao !== 1) : ?>
        <td>
            <div class="btn btn-danger btnExcluirCobrancaServico" onclick="$('#CobrancaServico_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                </svg>
            </div>
        </td>
        <?php endif; ?>
    </tr>
</template>
<?php if (false) : // PRODUTOS_DESATIVADOS ?>
<template id="templateRowCobrancaProduto">
    <tr id='CobrancaProduto_{_index_}'>
        <td>
            <input type="hidden" class="form-control ignoreValidate fkProduto_idCobrancaProduto" name="CobrancaProduto[{_index_}][Produto_id]" readonly="true" value="{_Produto_id_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_Produto_id_Text_}" />
        </td>
        <td><input type="text" class="form-control ignoreValidate" name="CobrancaProduto[{_index_}][quantidade]" readonly="true" value="{_quantidade_}" /></td>
        <td><input type="text" class="form-control ignoreValidate" name="CobrancaProduto[{_index_}][valorUnitario]" readonly="true" value="{_valorUnitario_}" /></td>
        <td>
            <div class="btn btn-danger btnExcluirCobrancaProduto" onclick="$('#CobrancaProduto_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                </svg>
            </div>
        </td>
    </tr>
</template>
<?php endif; ?>
<!-- content closed -->
<?= $this->endSection('content'); ?>

<?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?>

<?= $this->section('scripts'); ?>
<script>
    $('.submitButton').on('click', function(e) {
        //$(this).attr('disabled', true);
        disableValidationFieldsFK();
    });
    var situacaoOriginal = <?= (int) $cobranca->situacao ?>;
    var validator = $("#formAlterar").validate({
        submitHandler: function(form) {
            disableValidationFieldsFK();

            var situacaoAtual = parseInt($('#situacao').val() || '0', 10);
            if (situacaoOriginal === 0 && situacaoAtual === 1) {
                swal({
                    title: 'Confirma pagamento?',
                    text: 'Após definir como paga não será permitido realizar alterações. Deseja prosseguir?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, continuar',
                    cancelButtonText: 'Não'
                }, function(isConfirm) {
                    if (isConfirm) {
                        form.submit();
                    }
                });
                return;
            }

            form.submit();
        },
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            error.appendTo(element.parent());
        },
        highlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        onfocusout: function(element) {
            if (!this.checkable(element)) {
                this.element(element);
            }
        },
        invalidHandler: function(event, validator) {
            $('.submitButton').attr('disabled', false);
            enableValidationFieldsFK();
        },
        errorElement: "div",
        ignore: '.ignoreValidate',
        rules: {
            Participante_id: {
                required: true,
            },
            data: {
                required: true,
                dataBR: true,
            },
            valor: {
                required: true,
                real: true,
                normalizer: function(value) {
                    if (value.includes(',')) {
                        return value.replaceAll('.', '').replace(',', '.');
                    }
                    return value;
                },
                min: 0.01,
            },
            observacoes: {
                required: true,
            },
            situacao: {
                required: true,
            },
            cobrancaservico_Servico_id: {
                required: true,
            },
            cobrancaservico_quantidade: {
                required: true,
                inteiro: true,
            },
            cobrancaservico_valorUnitario: {
                required: true,
                real: true,
                normalizer: function(value) {
                    if (value.includes(',')) {
                        return value.replaceAll('.', '').replace(',', '.');
                    }
                    return value;
                },
                min: 0.01,
            },
            /*
            // PRODUTOS_DESATIVADOS
            cobrancaproduto_Produto_id: {
                required: true,
            },
            cobrancaproduto_quantidade: {
                required: true,
                inteiro: true,
            },
            cobrancaproduto_valorUnitario: {
                required: true,
                real: true,
                normalizer: function(value) {
                    if (value.includes(',')) {
                        return value.replaceAll('.', '').replace(',', '.');
                    }
                    return value;
                },
                min: 0.01,
            },
            */
        }
    });

    var inputsCobrancaServico = [
        'cobrancaservico_Servico_id',
        'cobrancaservico_quantidade',
        'cobrancaservico_valorUnitario',
    ];

    // PRODUTOS_DESATIVADOS
    var inputsCobrancaProduto = [];

    function formatReal(value) {
        if (typeof value === 'string' && value.includes(',')) {
            return value.replaceAll('.', '').replace(',', '.');
        }
        return value;
    }

    $('#btnAddCobrancaServico').on('click', function(e) {
        addCobrancaServico();
    });

    function disableValidationFieldsFK() {
        for (var i in inputsCobrancaServico) {
            $('#' + inputsCobrancaServico[i]).addClass('ignoreValidate');
        }
        for (var i in inputsCobrancaProduto) {
            $('#' + inputsCobrancaProduto[i]).addClass('ignoreValidate');
        }
    }

    function enableValidationFieldsFK() {
        for (var i in inputsCobrancaServico) {
            $('#' + inputsCobrancaServico[i]).removeClass('ignoreValidate');
        }
        for (var i in inputsCobrancaProduto) {
            $('#' + inputsCobrancaProduto[i]).removeClass('ignoreValidate');
        }
    }

    var indexRowCobrancaServico = 0;

    function addCobrancaServico() {
        $('.msgEmptyListCobrancaServico').addClass('d-none');
        //$('#listTableCobrancaServico').removeClass('d-none');
        let error = false;
        for (var i in inputsCobrancaServico) {
            if (!$('#' + inputsCobrancaServico[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        let dados = {};
        dados.Servico_id = $('#cobrancaservico_Servico_id').val();
        dados.Servico_id_Text = $('#cobrancaservico_Servico_id_Text').val();
        dados.quantidade = $('#cobrancaservico_quantidade').val();
        dados.valorUnitario = formatReal($('#cobrancaservico_valorUnitario').val());

        insertRowCobrancaServico(dados);

        $('#cobrancaservico_Servico_id').val('');
        $('#cobrancaservico_Servico_id_Text').val('');
        $('#cobrancaservico_quantidade').val('');
        $('#cobrancaservico_valorUnitario').val('');
    }

    function insertRowCobrancaServico(dados) {
        let html = $('#templateRowCobrancaServico').html();
        html = html.replaceAll('{_index_}', indexRowCobrancaServico);
        html = html.replaceAll('{_Servico_id_}', dados.Servico_id);
        html = html.replaceAll('{_Servico_id_Text_}', dados.Servico_id_Text);
        html = html.replaceAll('{_quantidade_}', dados.quantidade);
        html = html.replaceAll('{_valorUnitario_}', formatReal(dados.valorUnitario));
        $('#listTableCobrancaServico tbody').append(html);

        indexRowCobrancaServico++;
        $(".msgEmptyListCobrancaServico").hide();
    }

    /*
    // PRODUTOS_DESATIVADOS
    var indexRowCobrancaProduto = 0;
    $('#btnAddCobrancaProduto').on('click', function(e) {
        addCobrancaProduto();
    });

    function addCobrancaProduto() {
        $('.msgEmptyListCobrancaProduto').addClass('d-none');
        let error = false;
        for (var i in inputsCobrancaProduto) {
            if (!$('#' + inputsCobrancaProduto[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        let dados = {};
        dados.Produto_id = $('#cobrancaproduto_Produto_id').val();
        dados.Produto_id_Text = $('#cobrancaproduto_Produto_id_Text').val();
        dados.quantidade = $('#cobrancaproduto_quantidade').val();
        dados.valorUnitario = formatReal($('#cobrancaproduto_valorUnitario').val());

        insertRowCobrancaProduto(dados);

        $('#cobrancaproduto_Produto_id').val('');
        $('#cobrancaproduto_Produto_id_Text').val('');
        $('#cobrancaproduto_quantidade').val('');
        $('#cobrancaproduto_valorUnitario').val('');
    }

    function insertRowCobrancaProduto(dados) {
        let html = $('#templateRowCobrancaProduto').html();
        html = html.replaceAll('{_index_}', indexRowCobrancaProduto);
        html = html.replaceAll('{_Produto_id_}', dados.Produto_id);
        html = html.replaceAll('{_Produto_id_Text_}', dados.Produto_id_Text);
        html = html.replaceAll('{_quantidade_}', dados.quantidade);
        html = html.replaceAll('{_valorUnitario_}', formatReal(dados.valorUnitario));
        $('#listTableCobrancaProduto tbody').append(html);

        indexRowCobrancaProduto++;
        $(".msgEmptyListCobrancaProduto").hide();
    }
    */

    <?PHP foreach ($cobranca->getListCobrancaServico() as $i => $o) {
        $o->Servico_id_Text = $o->getServico()->Nome;
    ?>
        insertRowCobrancaServico(<?= json_encode($o) ?>);
    <?PHP } ?>

    /*
    // PRODUTOS_DESATIVADOS
    <?PHP foreach ($cobranca->getListCobrancaProduto() as $i => $o) {
        $o->Produto_id_Text = $o->getProduto()->nome;
    ?>
        insertRowCobrancaProduto(<?= json_encode($o) ?>);
    <?PHP } ?>
    */
</script>
<?= $this->endSection('scripts'); ?>
