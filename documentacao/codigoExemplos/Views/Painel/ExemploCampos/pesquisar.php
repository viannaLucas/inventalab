<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Exemplo Campos</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Pesquisa</span>
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
            <form id='formPesquisa' action="<?PHP echo base_url('ExemploCampos/doPesquisar'); ?>" class="needs-validation" method="GET" enctype="multipart/form-data" >
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Texto</label> 
                        <input class="form-control" name="tipoTexto" id="tipoTexto" type="text" maxlength="100">
                    </div>                                                            
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Data</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Tipo Data Inicial" class="form-control maskData" name="tipoDataStart" id="tipoDataInicial">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Tipo Data Final" class="form-control maskData" name="tipoDataEnd" id="tipoDataFinal">
                        </div>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Número</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Tipo Número Inicial" class="form-control maskInteiro" name="tipoNumeroStart" id="tipoNumeroStart">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Tipo Número Final" class="form-control maskInteiro" name="tipoNumeroEnd" id="tipoNumeroEnd">
                        </div>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Real</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Tipo Real Inicial" class="form-control maskReal" name="tipoRealStart" id="tipoRealStart">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Tipo Real Final" class="form-control maskReal" name="tipoRealEnd" id="tipoRealEnd">
                        </div>
                    </div>                                        
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo CPF</label> 
                        <input class="form-control maskCPF" name="tipoCPF" id="tipoCPF" type="text" />
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo CNPJ</label> 
                        <input class="form-control maskCNPJ" name="tipoCNPJ" id="tipoCNPJ" type="text" />
                    </div>                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Email</label> 
                        <input class="form-control" name="tipoEmail" id="tipoEmail" type="text" maxlength="250">
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="tipoSelect">Tipo Select</label> 
                        <select class="form-control select2" name="tipoSelect[]" id="tipoSelect" multiple="multiple">
                            <option value="0">opção 1</option>
                            <option value="1">Opção 2</option>
                        </select>
                    </div>                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Telefone</label> 
                        <input class="form-control" name="tipoTelefone" id="tipoTelefone" type="text" maxlength="20">
                    </div>                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Tipo Senha</label> 
                        <input class="form-control" name="tipoSenha" id="tipoSenha" type="text" maxlength="50">
                    </div>                                        
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Foreignkey</label> 
                        <div class="input-group">
                            <input class="form-control" name="foreignkey_Text" id="foreignkey_Text" type="text" disabled="true" onclick="$('#addonSearchforeignkey').click()"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="addonSearchforeignkey" 
                                        data-toggle="modal" data-target="#modalFK" data-title='Localizar Foreignkey'
                                        data-url-search='<?PHP echo base_url('TabelaFK/pesquisaModal?searchTerm='); ?>' data-input-result='foreignkey' data-input-text='foreignkey_Text' >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <input class="d-none" name="foreignkey" id="foreignkey" type="text" />
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