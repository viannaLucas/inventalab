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
            <form id='formCadastrar' action="<?PHP echo base_url('Servico/doCadastrar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                        <input class="form-control" name="Nome" id="Nome" type="text" maxlength="100" value="<?= old('Nome') ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Valor</label> 
                        <input class="form-control maskReal" name="valor" id="valor" type="text" value="<?= old('valor', '0,00') ?>">
                    </div>
                    <div class="form-group col-12">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Descrição</label> 
                        <textarea class="form-control" name="descricao" id="descricao" rows="2" maxlength="250"><?= old('descricao') ?></textarea>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Unidade</label> 
                        <input class="form-control" name="unidade" id="unidade" type="text" maxlength="20" value="<?= old('unidade') ?>">
                        <small class="form-text text-muted">Ex.: "Por minuto", "Por Hora", "A cada uso".</small>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="ativo">Ativo</label> 
                        <select class="form-control" name="ativo" id="ativo" required="" >
                            <option value="" <?= old('ativo')=='' ? 'selected' : ''; ?>></option>
                            <?PHP foreach (App\Entities\ServicoEntity::_op('ativo') as $k => $op){ ?>
                            <option value="<?= $k; ?>" <?= old('ativo') === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                    </div>                                        
                    <div class="form-group col-12">
                        <h6 class="mb-2 mt-3">Dados Fiscais</h6>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Unidade de Controle</label> 
                        <input class="form-control" name="UnidadedeControle" id="UnidadedeControle" type="text" maxlength="10" value="<?= old('UnidadedeControle') ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Produto Inspecionado</label> 
                        <select class="form-control" name="ProdutoInspecionado" id="ProdutoInspecionado">
                            <option value="" <?= old('ProdutoInspecionado')=='' ? 'selected' : ''; ?>></option>
                            <option value="S" <?= old('ProdutoInspecionado') === 'S' ? 'selected' : ''; ?>>Sim</option>
                            <option value="N" <?= old('ProdutoInspecionado') === 'N' ? 'selected' : ''; ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Produto Fabricado</label> 
                        <select class="form-control" name="ProdutoFabricado" id="ProdutoFabricado">
                            <option value="" <?= old('ProdutoFabricado')=='' ? 'selected' : ''; ?>></option>
                            <option value="S" <?= old('ProdutoFabricado') === 'S' ? 'selected' : ''; ?>>Sim</option>
                            <option value="N" <?= old('ProdutoFabricado') === 'N' ? 'selected' : ''; ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Produto Liberado</label> 
                        <select class="form-control" name="ProdutoLiberado" id="ProdutoLiberado">
                            <option value="" <?= old('ProdutoLiberado')=='' ? 'selected' : ''; ?>></option>
                            <option value="S" <?= old('ProdutoLiberado') === 'S' ? 'selected' : ''; ?>>Sim</option>
                            <option value="N" <?= old('ProdutoLiberado') === 'N' ? 'selected' : ''; ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Produto em Inventário</label> 
                        <select class="form-control" name="ProdutoemInventario" id="ProdutoemInventario">
                            <option value="" <?= old('ProdutoemInventario')=='' ? 'selected' : ''; ?>></option>
                            <option value="S" <?= old('ProdutoemInventario') === 'S' ? 'selected' : ''; ?>>Sim</option>
                            <option value="N" <?= old('ProdutoemInventario') === 'N' ? 'selected' : ''; ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo de Produto</label> 
                        <select class="form-control" name="TipodeProduto" id="TipodeProduto">
                            <option value="" <?= old('TipodeProduto')=='' ? 'selected' : ''; ?>></option>
                            <option value="P" <?= old('TipodeProduto') === 'P' ? 'selected' : ''; ?>>Produto</option>
                            <option value="S" <?= old('TipodeProduto') === 'S' ? 'selected' : ''; ?>>Servico</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Indicação de Lote Série</label> 
                        <select class="form-control" name="IndicacaodeLoteSerie" id="IndicacaodeLoteSerie">
                            <option value="" <?= old('IndicacaodeLoteSerie')=='' ? 'selected' : ''; ?>></option>
                            <option value="N" <?= old('IndicacaodeLoteSerie') === 'N' ? 'selected' : ''; ?>>Não</option>
                            <option value="L" <?= old('IndicacaodeLoteSerie') === 'L' ? 'selected' : ''; ?>>Lote</option>
                            <option value="S" <?= old('IndicacaodeLoteSerie') === 'S' ? 'selected' : ''; ?>>Serie</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Código de Situação Tributária CST</label> 
                        <select class="form-control" name="CodigodeSituacaoTributariaCST" id="CodigodeSituacaoTributariaCST">
                            <option value="" <?= old('CodigodeSituacaoTributariaCST')=='' ? 'selected' : ''; ?>></option>
                            <option value="0" <?= old('CodigodeSituacaoTributariaCST') === '0' ? 'selected' : ''; ?>>0</option>
                            <option value="1" <?= old('CodigodeSituacaoTributariaCST') === '1' ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?= old('CodigodeSituacaoTributariaCST') === '2' ? 'selected' : ''; ?>>2</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Classificação Fiscal</label> 
                        <input class="form-control" name="ClassificacaoFiscal" id="ClassificacaoFiscal" type="text" maxlength="10" value="<?= old('ClassificacaoFiscal') ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Grupo de Produto</label> 
                        <input class="form-control" name="GrupodeProduto" id="GrupodeProduto" type="text" maxlength="30" value="<?= old('GrupodeProduto') ?>">
                    </div>
                <div class="form-group mb-0 mt-3 text-center col-12">
                    <button type="submit" class="btn btn-primary submitButton">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- content closed -->
<?= $this->endSection('content'); ?>

<?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?>

<?= $this->section('scripts'); ?>
<script>
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
            Nome: {
                required: true,
            },
            descricao: {
                required: true,
            },
            valor: {
                required: true,
                real: true,
                normalizer: function (value) { if (value.includes(',')) { return value.replaceAll('.', '').replace(',', '.'); } return value; },
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
        }
    });
</script>    
<?= $this->endSection('scripts'); ?>
