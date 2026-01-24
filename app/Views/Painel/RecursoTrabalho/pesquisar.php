<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Recurso Trabalho</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Pesquisa</span>
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
            <form id='formPesquisa' action="<?PHP echo base_url('RecursoTrabalho/doPesquisar'); ?>" class="needs-validation" method="GET" enctype="multipart/form-data" >
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                        <input class="form-control" name="nome" id="nome" type="text" maxlength="200">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="tipo">Tipo</label> 
                        <select class="form-control select2" name="tipo[]" id="tipo" multiple="multiple">
                            <option value="0">Ferramenta</option>
                            <option value="1">Equipamento</option>
                        </select>
                    </div>                                        <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Marca do Fabricante</label> 
                        <input class="form-control" name="marcaFabricante" id="marcaFabricante" type="text" maxlength="200">
                    </div>                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Descrição</label> 
                        <input class="form-control" name="descricao" id="descricao" type="text" maxlength="200">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="requerHabilidade">Requer Habilidade</label> 
                        <select class="form-control select2" name="requerHabilidade[]" id="requerHabilidade" multiple="multiple">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="usoExclusivo">Uso Exclusivo</label> 
                        <select class="form-control select2" name="usoExclusivo[]" id="usoExclusivo" multiple="multiple">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="situacaoTrabalho">Situação Trabalho</label> 
                        <select class="form-control select2" name="situacaoTrabalho[]" id="situacaoTrabalho" multiple="multiple">
                            <option value="0">Ativo</option>
                            <option value="1">Em Manutenção</option>
                            <option value="2">Removido</option>
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