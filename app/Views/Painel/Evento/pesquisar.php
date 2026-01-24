<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Evento</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Pesquisa</span>
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
            <form id='formPesquisa' action="<?PHP echo base_url('Evento/doPesquisar'); ?>" class="needs-validation" method="GET" enctype="multipart/form-data" >
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                        <input class="form-control" name="nome" id="nome" type="text" maxlength="150">
                    </div>                                                            
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="vagasLimitadas">Vagas Limitadas</label> 
                        <select class="form-control select2" name="vagasLimitadas[]" id="vagasLimitadas" multiple="multiple">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Número Vagas</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Número Vagas Inicial" class="form-control maskInteiro" name="numeroVagasStart" id="numeroVagasStart">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Número Vagas Final" class="form-control maskInteiro" name="numeroVagasEnd" id="numeroVagasEnd">
                        </div>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="inscricoesAbertas">Inscrições Abertas</label> 
                        <select class="form-control select2" name="inscricoesAbertas[]" id="inscricoesAbertas" multiple="multiple">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="divulgar">Divulgar</label> 
                        <select class="form-control select2" name="divulgar[]" id="divulgar" multiple="multiple">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Início</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Data Início Inicial" class="form-control maskData" name="dataInicioStart" id="dataInicioInicial">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Data Início Final" class="form-control maskData" name="dataInicioEnd" id="dataInicioFinal">
                        </div>
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