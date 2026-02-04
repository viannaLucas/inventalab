<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Serviço</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Cadastrar</span>
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
            <form id='formCadastrar' action="<?PHP echo base_url('Servico/doCadastrar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label>
                        <input class="form-control" name="Nome" id="Nome" type="text" maxlength="100" value="<?= esc(old('Nome'), 'attr') ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Valor</label>
                        <input class="form-control maskReal" name="valor" id="valor" type="text" value="<?= esc(old('valor', '0,00'), 'attr') ?>">
                    </div>
                    <div class="form-group col-12">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Descrição</label>
                        <textarea class="form-control" name="descricao" id="descricao" rows="2" maxlength="250"><?= esc(old('descricao')) ?></textarea>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Unidade</label>
                        <input class="form-control" name="unidade" id="unidade" type="text" maxlength="20" value="<?= esc(old('unidade'), 'attr') ?>">
                        <small class="form-text text-muted">Ex.: "Por minuto", "Por Hora", "A cada uso".</small>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="ativo">Ativo</label>
                        <select class="form-control" name="ativo" id="ativo" required="">
                            <option value="" <?= old('ativo') == '' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\ServicoEntity::_op('ativo') as $k => $op) { ?>
                                <option value="<?= esc($k, 'attr') ?>" <?= old('ativo') === $k ? 'selected' : ''; ?>><?= esc($op) ?></option>
                            <?PHP } ?>
                        </select>
                    </div>
                    <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                        <div class="border-bottom mx-n1 mb-3">
                            <h4 class="px-2">Lista de Produtos do Serviço</h4>
                        </div>
                        <div class="form-row px-2">
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Produto</label>
                                <div class="input-group mb-3">
                                    <input class="form-control" name="servicoproduto_Produto_id_Text" id="servicoproduto_Produto_id_Text" type="text" disabled="true" onclick="$('#addonSearchservicoproduto_Produto_id').click()" value="<?= esc(old('servicoproduto_Produto_id_Text'), 'attr') ?>" />
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="addonSearchservicoproduto_Produto_id"
                                            data-toggle="modal" data-target="#modalFK" data-title='Localizar Produto'
                                            data-url-search='<?PHP echo base_url('Produto/pesquisaModal?searchTerm='); ?>' data-input-result='servicoproduto_Produto_id' data-input-text='servicoproduto_Produto_id_Text'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input class="d-none" name="servicoproduto_Produto_id" id="servicoproduto_Produto_id" type="text" value="<?= esc(old('servicoproduto_Produto_id'), 'attr') ?>" />
                                </div>
                            </div>
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Quantidade</label>
                                <input class="form-control maskInteiro" name="servicoproduto_quantidade" id="servicoproduto_quantidade" type="text" value="<?= esc(old('servicoproduto_quantidade'), 'attr') ?>">
                            </div>
                            <div class="form-group col-auto">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label>
                                <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddServicoProduto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <table class="table table-striped" id="listTableServicoProduto">
                            <thead>
                                <tr>
                                    <th scope="col">Produto</th>
                                    <th scope="col">Quantidade</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="w-100 text-center msgEmptyListServicoProduto mb-3">
                            <span class="h5">Sem itens selecionados</span>
                        </div>
                    </fieldset>
                    <div class="form-group col-12">
                        <h6 class="mb-2 mt-3">Dados Fiscais</h6>
                        <div class="alert alert-info" role="alert">
                            <strong>Campo Código</strong> Para cada serviço cadastrado no sistema, deve haver um cadastro correspondente no sistema MXM do SESC. O vínculo entre os dois é realizado por meio do campo 'código', que deve ser preenchido com o código do serviço do sistema do SESC (MXM).
                        </div>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Código Serviço Cadastrado no MXM</label>
                        <input class="form-control" name="codigo" id="codigo" type="text" maxlength="10" value="<?= esc(old('codigo'), 'attr') ?>">
                        <small id="codigo-descricao" class="form-text text-muted d-none"></small>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Unidade de Controle</label>
                        <input class="form-control" name="UnidadedeControle" id="UnidadedeControle" type="text" maxlength="10" value="<?= esc(old('UnidadedeControle'), 'attr') ?>" readonly>
                    </div>
                    <div class="form-group col-12 col-md-6 d-none">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Produto Inspecionado</label>
                        <select class="form-control" name="ProdutoInspecionado" id="ProdutoInspecionado">
                            <option value="" <?= old('ProdutoInspecionado') == '' ? 'selected' : ''; ?>></option>
                            <option value="S" <?= old('ProdutoInspecionado') === 'S' ? 'selected' : ''; ?>>Sim</option>
                            <option value="N" <?= old('ProdutoInspecionado') === 'N' ? 'selected' : ''; ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6 d-none">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Produto Fabricado</label>
                        <select class="form-control" name="ProdutoFabricado" id="ProdutoFabricado">
                            <option value="" <?= old('ProdutoFabricado') == '' ? 'selected' : ''; ?>></option>
                            <option value="S" <?= old('ProdutoFabricado') === 'S' ? 'selected' : ''; ?>>Sim</option>
                            <option value="N" <?= old('ProdutoFabricado') === 'N' ? 'selected' : ''; ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Produto Liberado</label>
                        <select class="form-control" name="ProdutoLiberado" id="ProdutoLiberado" disabled>
                            <option value="" <?= old('ProdutoLiberado') == '' ? 'selected' : ''; ?>></option>
                            <option value="S" <?= old('ProdutoLiberado') === 'S' ? 'selected' : ''; ?>>Sim</option>
                            <option value="N" <?= old('ProdutoLiberado') === 'N' ? 'selected' : ''; ?>>Não</option>
                        </select>
                        <input type="hidden" name="ProdutoLiberado" id="ProdutoLiberadoHidden" value="<?= esc(old('ProdutoLiberado'), 'attr') ?>">
                    </div>
                    <div class="form-group col-12 col-md-6 d-none">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Produto em Inventário</label>
                        <select class="form-control" name="ProdutoemInventario" id="ProdutoemInventario">
                            <option value="" <?= old('ProdutoemInventario') == '' ? 'selected' : ''; ?>></option>
                            <option value="S" <?= old('ProdutoemInventario') === 'S' ? 'selected' : ''; ?>>Sim</option>
                            <option value="N" <?= old('ProdutoemInventario') === 'N' ? 'selected' : ''; ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6 d-none">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo de Produto</label>
                        <select class="form-control" name="TipodeProduto" id="TipodeProduto">
                            <option value="" <?= old('TipodeProduto') == '' ? 'selected' : ''; ?>></option>
                            <option value="P" <?= old('TipodeProduto') === 'P' ? 'selected' : ''; ?>>Produto</option>
                            <option value="S" <?= old('TipodeProduto') === 'S' ? 'selected' : ''; ?>>Servico</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6 d-none">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Indicação de Lote Série</label>
                        <select class="form-control" name="IndicacaodeLoteSerie" id="IndicacaodeLoteSerie">
                            <option value="" <?= old('IndicacaodeLoteSerie') == '' ? 'selected' : ''; ?>></option>
                            <option value="N" <?= old('IndicacaodeLoteSerie') === 'N' ? 'selected' : ''; ?>>Não</option>
                            <option value="L" <?= old('IndicacaodeLoteSerie') === 'L' ? 'selected' : ''; ?>>Lote</option>
                            <option value="S" <?= old('IndicacaodeLoteSerie') === 'S' ? 'selected' : ''; ?>>Serie</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Código de Situação Tributária CST</label>
                        <select class="form-control" name="CodigodeSituacaoTributariaCST" id="CodigodeSituacaoTributariaCST" disabled>
                            <option value="" <?= old('CodigodeSituacaoTributariaCST') == '' ? 'selected' : ''; ?>></option>
                            <option value="0" <?= old('CodigodeSituacaoTributariaCST') === '0' ? 'selected' : ''; ?>>0</option>
                            <option value="1" <?= old('CodigodeSituacaoTributariaCST') === '1' ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?= old('CodigodeSituacaoTributariaCST') === '2' ? 'selected' : ''; ?>>2</option>
                        </select>
                        <input type="hidden" name="CodigodeSituacaoTributariaCST" id="CodigodeSituacaoTributariaCSTHidden" value="<?= esc(old('CodigodeSituacaoTributariaCST'), 'attr') ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Classificação Fiscal</label>
                        <input class="form-control" name="ClassificacaoFiscal" id="ClassificacaoFiscal" type="text" maxlength="10" value="<?= esc(old('ClassificacaoFiscal'), 'attr') ?>" readonly>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Grupo de Produto</label>
                        <input class="form-control" name="GrupodeProduto" id="GrupodeProduto" type="text" maxlength="30" value="<?= esc(old('GrupodeProduto'), 'attr') ?>" readonly>
                    </div>
                    <div class="form-group mb-0 mt-3 text-center col-12">
                        <button type="submit" class="btn btn-primary submitButton">Cadastrar</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<template id="templateRowServicoProduto">
    <tr id='ServicoProduto_{_index_}'>
        <td>
            <input type="hidden" class="form-control ignoreValidate fkProduto_idServicoProduto" name="ServicoProduto[{_index_}][Produto_id]" readonly="true" value="{_Produto_id_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_Produto_id_Text_}" />
        </td>
        <td><input type="text" class="form-control ignoreValidate" name="ServicoProduto[{_index_}][quantidade]" readonly="true" value="{_quantidade_}" /></td>
        <td>
            <div class="btn btn-danger btnExcluirServicoProduto" onclick="$('#ServicoProduto_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                </svg>
            </div>
        </td>
    </tr>
</template>

<!-- content closed -->
<?= $this->endSection('content'); ?><?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?><?= $this->section('scripts'); ?>
<script>
    const baseUrlServicoApi = "<?= base_url('Servico/obterDadosServicoApiSesc/'); ?>";
    const baseUrlCodigoUnico = "<?= base_url('Servico/validarCodigoUnico'); ?>";
    const codigoInput = $('#codigo');
    const submitButton = $('.submitButton');
    let codigoApiCache = {
        valor: null,
        valido: null
    };
    let codigoApiEmAndamento = null;
    let codigoUnicoCache = {
        valor: null,
        valido: null,
        servicoId: null
    };
    let codigoUnicoEmAndamento = null;
    const servicoId = null;

    function setCodigoApiErro(mensagem) {
        let errorEl = $('#codigo-api-error');
        if (!errorEl.length) {
            errorEl = $('<div/>', {
                id: 'codigo-api-error',
                class: 'invalid-feedback d-block'
            });
            codigoInput.parent().append(errorEl);
        }
        errorEl.text(mensagem);
        codigoInput.removeClass('is-valid').addClass('is-invalid');
    }

    function limparCodigoApiErro() {
        $('#codigo-api-error').remove();
        codigoInput.removeClass('is-invalid').addClass('is-valid');
    }

    function preencherDadosServico(dados) {
        if (!dados) {
            return;
        }
        const descricao = dados.Descricao ?? '';
        if (descricao) {
            $('#codigo-descricao').text(descricao).removeClass('d-none');
        } else {
            $('#codigo-descricao').text('').addClass('d-none');
        }
        $('#CodigodeSituacaoTributariaCST').val(dados.CodigodaSituacaoTributaria ?? '').trigger('change');
        $('#CodigodeSituacaoTributariaCSTHidden').val(dados.CodigodaSituacaoTributaria ?? '');
        $('#UnidadedeControle').val(dados.UnidadeDeMedidaDeControle ?? '');
        $('#ProdutoInspecionado').val('N').trigger('change');
        $('#ProdutoFabricado').val('N').trigger('change');
        $('#ProdutoLiberado').val(dados.LiberadoParaMovimentacao ?? '').trigger('change');
        $('#ProdutoLiberadoHidden').val(dados.LiberadoParaMovimentacao ?? '');
        $('#ProdutoemInventario').val('N').trigger('change');
        $('#TipodeProduto').val('S').trigger('change');
        $('#IndicacaodeLoteSerie').val('N').trigger('change');
        $('#ClassificacaoFiscal').val(dados.ClassificacaoFiscal ?? '');
        $('#GrupodeProduto').val(dados.GrupoProduto ?? '');
    }

    function validarCodigoServicoApi(forceFetch = false) {
        const codigo = (codigoInput.val() || '').trim();
        if (!codigo) {
            setCodigoApiErro('O campo código é obrigatório.');
            $('#codigo-descricao').text('').addClass('d-none');
            return Promise.resolve(false);
        }

        if (!forceFetch && codigoApiCache.valor === codigo && codigoApiCache.valido !== null) {
            if (!codigoApiCache.valido) {
                return Promise.resolve(false);
            }
            return validarCodigoUnico(forceFetch);
        }

        if (codigoApiEmAndamento) {
            return codigoApiEmAndamento;
        }

        codigoApiEmAndamento = fetch(`${baseUrlServicoApi}${encodeURIComponent(codigo)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then((response) => response.json())
            .then((data) => {
                const valido = !!(data && data.Success === true && Array.isArray(data.Data) && data.Data.length > 0);
                codigoApiCache = {
                    valor: codigo,
                    valido: valido
                };
                if (!valido) {
                    setCodigoApiErro('Código não encontrado na API do MXM.');
                    $('#codigo-descricao').text('').addClass('d-none');
                    return false;
                }
                limparCodigoApiErro();
                preencherDadosServico(data.Data[0]);
                return validarCodigoUnico(forceFetch);
            })
            .catch(() => {
                setCodigoApiErro('Não foi possível validar o código na API do MXM.');
                $('#codigo-descricao').text('').addClass('d-none');
                codigoApiCache = {
                    valor: codigo,
                    valido: false
                };
                return false;
            })
            .finally(() => {
                codigoApiEmAndamento = null;
            });

        return codigoApiEmAndamento;
    }

    function validarCodigoUnico(forceFetch = false) {
        const codigo = (codigoInput.val() || '').trim();
        if (!codigo) {
            setCodigoApiErro('O campo código é obrigatório.');
            return Promise.resolve(false);
        }

        if (!forceFetch &&
            codigoUnicoCache.valor === codigo &&
            codigoUnicoCache.servicoId === servicoId &&
            codigoUnicoCache.valido !== null) {
            return Promise.resolve(codigoUnicoCache.valido);
        }

        if (codigoUnicoEmAndamento) {
            return codigoUnicoEmAndamento;
        }

        const params = new URLSearchParams({
            codigo
        });
        if (servicoId !== null) {
            params.append('servicoId', servicoId);
        }

        codigoUnicoEmAndamento = fetch(`${baseUrlCodigoUnico}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then((response) => response.json())
            .then((data) => {
                const valido = !!(data && data.valido === true);
                codigoUnicoCache = {
                    valor: codigo,
                    valido: valido,
                    servicoId: servicoId
                };
                if (!valido) {
                    setCodigoApiErro(data?.msg || 'Código já cadastrado para outro serviço.');
                    return false;
                }
                limparCodigoApiErro();
                return true;
            })
            .catch(() => {
                setCodigoApiErro('Não foi possível validar o código no sistema.');
                codigoUnicoCache = {
                    valor: codigo,
                    valido: false,
                    servicoId: servicoId
                };
                return false;
            })
            .finally(() => {
                codigoUnicoEmAndamento = null;
            });

        return codigoUnicoEmAndamento;
    }

    $('.submitButton').on('click', function(e) {
        //$(this).attr('disabled', true);
    });
    var validator = $("#formCadastrar").validate({
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
            Nome: {
                required: true,
            },
            descricao: {
                required: true,
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
            unidade: {
                required: true,
            },
            ativo: {
                required: true,
            },
            UnidadedeControle: {
                required: true,
            },
            ProdutoInspecionado: {
                required: true,
            },
            ProdutoFabricado: {
                required: true,
            },
            ProdutoLiberado: {
                required: true,
            },
            ProdutoemInventario: {
                required: true,
            },
            TipodeProduto: {
                required: true,
            },
            IndicacaodeLoteSerie: {
                required: true,
            },
            CodigodeSituacaoTributariaCST: {
                required: true,
            },
            ClassificacaoFiscal: {
                required: true,
            },
            GrupodeProduto: {
                required: true,
            },
            codigo: {
                required: true,
            },
            servicoproduto_Produto_id: {
                required: true,
            },
            servicoproduto_quantidade: {
                required: true,
                inteiro: true,
            },
        }
    });

    codigoInput.on('blur', function() {
        if ($(this).val().trim()) {
            validarCodigoServicoApi();
        }
    });

    $("#formCadastrar").on('submit', function(e) {
        e.preventDefault();
        submitButton.attr('disabled', true);
        disableValidationFieldsFK();
        validarCodigoServicoApi(true).then((valido) => {
            if (valido && validator.form()) {
                $(this).off('submit');
                this.submit();
            } else {
                enableValidationFieldsFK();
                submitButton.attr('disabled', false);
            }
        });
    });

    var inputsServicoProduto = [
        'servicoproduto_Produto_id',
        'servicoproduto_quantidade',
    ];

    $('#btnAddServicoProduto').on('click', function(e) {
        addServicoProduto();
    });

    function disableValidationFieldsFK() {
        for (var i in inputsServicoProduto) {
            $('#' + inputsServicoProduto[i]).addClass('ignoreValidate');
        }
    }

    function enableValidationFieldsFK() {
        for (var i in inputsServicoProduto) {
            $('#' + inputsServicoProduto[i]).removeClass('ignoreValidate');
        }
    }

    var indexRowServicoProduto = 0;

    function addServicoProduto() {
        $('.msgEmptyListServicoProduto').addClass('d-none');
        let error = false;
        for (var i in inputsServicoProduto) {
            if (!$('#' + inputsServicoProduto[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        let html = $('#templateRowServicoProduto').html();
        html = html.replaceAll('{_index_}', indexRowServicoProduto);
        html = html.replaceAll('{_Produto_id_}', $('#servicoproduto_Produto_id').val());
        html = html.replaceAll('{_Produto_id_Text_}', $('#servicoproduto_Produto_id_Text').val());
        html = html.replaceAll('{_quantidade_}', $('#servicoproduto_quantidade').val());
        $('#listTableServicoProduto tbody').append(html);

        $('#servicoproduto_Produto_id').val('');
        $('#servicoproduto_Produto_id_Text').val('');
        $('#servicoproduto_quantidade').val('');
        indexRowServicoProduto++;
    }
</script>
<?= $this->endSection('scripts'); ?>