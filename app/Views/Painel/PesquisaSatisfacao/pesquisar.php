<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Pesquisa de Satisfação</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Pesquisa</span>
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
            <form id='formPesquisa' action="<?PHP echo base_url('PesquisaSatisfacao/doPesquisar'); ?>" class="needs-validation" method="GET" enctype="multipart/form-data" >
                <div class="form-row">
                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Uso Espaço</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Resposta 1 Inicial" class="form-control maskInteiro" name="resposta1Start" id="resposta1Start">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Resposta 1 Final" class="form-control maskInteiro" name="resposta1End" id="resposta1End">
                        </div>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Atendimento</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Resposta 2 Inicial" class="form-control maskInteiro" name="resposta2Start" id="resposta2Start">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Resposta 2 Final" class="form-control maskInteiro" name="resposta2End" id="resposta2End">
                        </div>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Equipamentos</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Resposta 3 Inicial" class="form-control maskInteiro" name="resposta3Start" id="resposta3Start">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Resposta 3 Final" class="form-control maskInteiro" name="resposta3End" id="resposta3End">
                        </div>
                    </div>                                                            
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Resposta</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Data Resposta Inicial" class="form-control maskData" name="dataRespostaStart" id="dataRespostaInicial">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Data Resposta Final" class="form-control maskData" name="dataRespostaEnd" id="dataRespostaFinal">
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
