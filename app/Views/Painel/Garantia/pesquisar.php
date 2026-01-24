<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Garantia</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Pesquisa</span>
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
            <form id='formPesquisa' action="<?PHP echo base_url('Garantia/doPesquisar'); ?>" class="needs-validation" method="GET" enctype="multipart/form-data" >
                <div class="form-row">
                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Recurso Trabalho</label> 
                        <div class="input-group">
                            <input class="form-control" name="RecursoTrabalho_id_Text" id="RecursoTrabalho_id_Text" type="text" disabled="true" onclick="$('#addonSearchRecursoTrabalho_id').click()"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="addonSearchRecursoTrabalho_id" 
                                        data-toggle="modal" data-target="#modalFK" data-title='Localizar Recurso Trabalho'
                                        data-url-search='<?PHP echo base_url('RecursoTrabalho/pesquisaModal?searchTerm='); ?>' data-input-result='RecursoTrabalho_id' data-input-text='RecursoTrabalho_id_Text' >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <input class="d-none" name="RecursoTrabalho_id" id="RecursoTrabalho_id" type="text" />
                        </div>
                    </div>                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Descrição</label> 
                        <input class="form-control" name="descricao" id="descricao" type="text" maxlength="200">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="tipo">Tipo</label> 
                        <select class="form-control select2" name="tipo[]" id="tipo" multiple="multiple">
                            <option value="0">Fabricante</option>
                            <option value="1">Garantia Estendida</option>
                            <option value="2">Conserto e Manutenção </option>
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
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Fim</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Data Fim Inicial" class="form-control maskData" name="dataFimStart" id="dataFimInicial">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Data Fim Final" class="form-control maskData" name="dataFimEnd" id="dataFimFinal">
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