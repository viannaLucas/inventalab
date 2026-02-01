<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Produto</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Pesquisa</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- content -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Pesquisa</h4>
        </div>
        <div class="card-body pt-0">
            <form id='formPesquisa' action="<?PHP echo base_url('Produto/doPesquisar'); ?>" class="needs-validation" method="GET" enctype="multipart/form-data" >
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                        <input class="form-control" name="nome" id="nome" type="text" maxlength="200">
                    </div>                                        
                    <!-- Valor desabilitado temporariamente -->
                    <!--
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Valor</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Valor Inicial" class="form-control maskReal" name="valorStart" id="valorStart">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Valor Final" class="form-control maskReal" name="valorEnd" id="valorEnd">
                        </div>
                    </div>
                    -->
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Estoque Mínimo</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Estoque Mínimo Inicial" class="form-control maskInteiro" name="estoqueMinimoStart" id="estoqueMinimoStart">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Estoque Mínimo Final" class="form-control maskInteiro" name="estoqueMinimoEnd" id="estoqueMinimoEnd">
                        </div>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Estoque Atual</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Estoque Atual Inicial" class="form-control maskInteiro" name="estoqueAtualStart" id="estoqueAtualStart">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Estoque Atual Final" class="form-control maskInteiro" name="estoqueAtualEnd" id="estoqueAtualEnd">
                        </div>
                    </div>                                        
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="ativo">Ativo</label> 
                        <select class="form-control select2" name="ativo[]" id="ativo" multiple="multiple">
                            <?PHP foreach (App\Entities\ProdutoEntity::_op('ativo') as $k => $op){ ?>
                            <option value="<?= esc($k, 'attr') ?>"><?= esc($op ) ?></option>
                            <?PHP } ?>
                        </select>
                    </div>                               
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Abaixo do Estoque Mínimo</label>
                        <select class="form-control" name="abaixoEstoqueMinimo" id="abaixoEstoqueMinimo">
                            <option value="" selected></option>
                            <option value="S">Sim</option>
                            <option value="N">Não</option>
                        </select>
                    </div>
                    <div class="form-group mb-0 mt-3 text-center col-12">
                        <button type="submit" class="btn btn-primary submitButton">Pesquisar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- content closed -->
<?= $this->endSection('content'); ?>
