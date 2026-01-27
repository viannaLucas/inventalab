<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Produto</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Alterar</span>
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
            <form id='formAlterar' action="<?PHP echo base_url('Produto/doAlterar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="id" value="<?= $produto->id ?>" />
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                        <input class="form-control" name="nome" id="nome" type="text" maxlength="200" value="<?= $produto->nome ?>">
                    </div>                    
                    <div class="form-group col-12 ">
                        <label>Foto</label>
                        <label>
                            Foto                            <?PHP if($produto->foto != '') { ?>
                            <a class="btn btn-sm btn-primary ml-3" href="<?PHP echo base_url($produto->foto); ?>" target="_blank">Fazer Download</a>
                            <?PHP } ?>
                        </label>
                        <input type="file" class="dropify" id="foto" name="foto" accept=".jpg,.jpeg,.webp,.png" 
                               data-default-file="<?PHP echo $produto->foto != '' ? base_url($produto->foto) : ''; ?>"
                               data-allowed-file-extensions="webp png jpeg jpg" data-max-file-size="10M" >
                    </div>                    
                    <!-- Valor desabilitado temporariamente -->
                    <!--
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Valor</label> 
                        <input class="form-control maskReal" name="valor" id="valor" type="text" value="<?= $produto->valor ?>">
                    </div>
                    -->
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Estoque Mínimo</label> 
                        <input class="form-control maskInteiro" name="estoqueMinimo" id="estoqueMinimo" type="text" value="<?= $produto->estoqueMinimo ?>">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Estoque Atual</label> 
                        <input class="form-control maskInteiro" name="estoqueAtual" id="estoqueAtual" type="text" value="<?= $produto->estoqueAtual ?>">
                    </div>                                        
                    <!-- Dados Fiscais desabilitados temporariamente -->
                    <!--
                    <div class="form-group col-12">
                        <h6 class="mb-2 mt-3">Dados Fiscais</h6>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Código</label> 
                        <input class="form-control" type="text" value="<?= $dadosApi->codigo ?>" readonly>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Unidade de Controle</label> 
                        <input class="form-control" name="UnidadedeControle" id="UnidadedeControle" type="text" maxlength="10" value="<?= $dadosApi->UnidadedeControle ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Produto Inspecionado</label> 
                        <select class="form-control" name="ProdutoInspecionado" id="ProdutoInspecionado">
                            <option value="" <?= $dadosApi->ProdutoInspecionado=='' ? 'selected' : ''; ?>></option>
                            <option value="S" <?= $dadosApi->ProdutoInspecionado === 'S' ? 'selected' : ''; ?>>Sim</option>
                            <option value="N" <?= $dadosApi->ProdutoInspecionado === 'N' ? 'selected' : ''; ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Produto Fabricado</label> 
                        <select class="form-control" name="ProdutoFabricado" id="ProdutoFabricado">
                            <option value="" <?= $dadosApi->ProdutoFabricado=='' ? 'selected' : ''; ?>></option>
                            <option value="S" <?= $dadosApi->ProdutoFabricado === 'S' ? 'selected' : ''; ?>>Sim</option>
                            <option value="N" <?= $dadosApi->ProdutoFabricado === 'N' ? 'selected' : ''; ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Produto Liberado</label> 
                        <select class="form-control" name="ProdutoLiberado" id="ProdutoLiberado">
                            <option value="" <?= $dadosApi->ProdutoLiberado=='' ? 'selected' : ''; ?>></option>
                            <option value="S" <?= $dadosApi->ProdutoLiberado === 'S' ? 'selected' : ''; ?>>Sim</option>
                            <option value="N" <?= $dadosApi->ProdutoLiberado === 'N' ? 'selected' : ''; ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Produto em Inventário</label> 
                        <select class="form-control" name="ProdutoemInventario" id="ProdutoemInventario">
                            <option value="" <?= $dadosApi->ProdutoemInventario=='' ? 'selected' : ''; ?>></option>
                            <option value="S" <?= $dadosApi->ProdutoemInventario === 'S' ? 'selected' : ''; ?>>Sim</option>
                            <option value="N" <?= $dadosApi->ProdutoemInventario === 'N' ? 'selected' : ''; ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo de Produto</label> 
                        <select class="form-control" name="TipodeProduto" id="TipodeProduto">
                            <option value="" <?= $dadosApi->TipodeProduto=='' ? 'selected' : ''; ?>></option>
                            <option value="P" <?= $dadosApi->TipodeProduto === 'P' ? 'selected' : ''; ?>>Produto</option>
                            <option value="S" <?= $dadosApi->TipodeProduto === 'S' ? 'selected' : ''; ?>>Servico</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Indicação de Lote Série</label> 
                        <select class="form-control" name="IndicacaodeLoteSerie" id="IndicacaodeLoteSerie">
                            <option value="" <?= $dadosApi->IndicacaodeLoteSerie=='' ? 'selected' : ''; ?>></option>
                            <option value="N" <?= $dadosApi->IndicacaodeLoteSerie === 'N' ? 'selected' : ''; ?>>Não</option>
                            <option value="L" <?= $dadosApi->IndicacaodeLoteSerie === 'L' ? 'selected' : ''; ?>>Lote</option>
                            <option value="S" <?= $dadosApi->IndicacaodeLoteSerie === 'S' ? 'selected' : ''; ?>>Serie</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Código de Situação Tributária CST</label> 
                        <select class="form-control" name="CodigodeSituacaoTributariaCST" id="CodigodeSituacaoTributariaCST">
                            <option value="" <?= $dadosApi->CodigodeSituacaoTributariaCST=='' ? 'selected' : ''; ?>></option>
                            <option value="0" <?= $dadosApi->CodigodeSituacaoTributariaCST === '0' ? 'selected' : ''; ?>>0</option>
                            <option value="1" <?= $dadosApi->CodigodeSituacaoTributariaCST === '1' ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?= $dadosApi->CodigodeSituacaoTributariaCST === '2' ? 'selected' : ''; ?>>2</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Classificação Fiscal</label> 
                        <input class="form-control" name="ClassificacaoFiscal" id="ClassificacaoFiscal" type="text" maxlength="10" value="<?= $dadosApi->ClassificacaoFiscal ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Grupo de Produto</label> 
                        <input class="form-control" name="GrupodeProduto" id="GrupodeProduto" type="text" maxlength="30" value="<?= $dadosApi->GrupodeProduto ?>">
                    </div>
                    -->
                <div class="form-group mb-0 mt-3 text-center col-12">
                    <button type="submit" class="btn btn-primary submitButton">Alterar</button>
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
        },
        errorElement: "div",
        ignore: '.ignoreValidate',
        rules: {
            nome: {
                required: true,
            },
            foto: {
                arquivo: 'webp|jpg|jpeg|png',
            },
            // valor: {
            //     required: true,
            //     real: true,
            //     normalizer: function (value) { if (value.includes(',')) { return value.replaceAll('.', '').replace(',', '.'); } return value; },
            //     min: 0.01,
            // },
            estoqueMinimo: {
                required: true,
                inteiro: true,
            },
            estoqueAtual: {
                required: true,
                inteiro: true,
            },
            // UnidadedeControle: {
            //     required: true,
            // },
            // ProdutoInspecionado: {
            //     required: true,
            // },
            // ProdutoFabricado: {
            //     required: true,
            // },
            // ProdutoLiberado: {
            //     required: true,
            // },
            // ProdutoemInventario: {
            //     required: true,
            // },
            // TipodeProduto: {
            //     required: true,
            // },
            // IndicacaodeLoteSerie: {
            //     required: true,
            // },
            // CodigodeSituacaoTributariaCST: {
            //     required: true,
            // },
            // ClassificacaoFiscal: {
            //     required: true,
            // },
            // GrupodeProduto: {
            //     required: true,
            // },
        }
    });

</script>    
<?= $this->endSection('scripts'); ?>
