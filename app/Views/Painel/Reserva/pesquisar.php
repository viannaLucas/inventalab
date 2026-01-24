<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Reserva</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Pesquisa</span>
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
            <form id='formPesquisa' action="<?PHP echo base_url('Reserva/doPesquisar'); ?>" class="needs-validation" method="GET" enctype="multipart/form-data" >
                <div class="form-row">
                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Cadastro</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Data Cadastro Inicial" class="form-control maskData" name="dataCadastroStart" id="dataCadastroInicial">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Data Cadastro Final" class="form-control maskData" name="dataCadastroEnd" id="dataCadastroFinal">
                        </div>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Data Reserva</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Data Reserva Inicial" class="form-control maskData" name="dataReservaStart" id="dataReservaInicial">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Data Reserva Final" class="form-control maskData" name="dataReservaEnd" id="dataReservaFinal">
                        </div>
                    </div>
                    <!-- <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Início</label> 
                        <input class="form-control" name="horaInicio" id="horaInicio" type="text" maxlength="10">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Fim</label> 
                        <input class="form-control" name="horaFim" id="horaFim" type="text" maxlength="10">
                    </div>                     -->
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="tipo">Tipo</label> 
                        <select class="form-control select2" name="tipo[]" id="tipo" multiple="multiple">
                            <option value="0">Exclusiva</option>
                            <option value="1">Compartilhada</option>
                        </select>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Número Convidados</label> 
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">De</span></div>
                            <input type="text" aria-label="Número Convidados Inicial" class="form-control maskInteiro" name="numeroConvidadosStart" id="numeroConvidadosStart">
                            <div class="input-group-prepend"><span class="input-group-text">Até</span></div>
                            <input type="text" aria-label="Número Convidados Final" class="form-control maskInteiro" name="numeroConvidadosEnd" id="numeroConvidadosEnd">
                        </div>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="status">Status</label> 
                        <select class="form-control select2" name="status[]" id="status" multiple="multiple">
                            <option value="0">Cancelado</option>
                            <option value="1">Ativo</option>
                        </select>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="turmaEscola">Turma Escola</label> 
                        <select class="form-control select2" name="turmaEscola[]" id="turmaEscola" multiple="multiple">
                            <option value="0">1</option>
                            <option value="1">2</option>
                            <option value="2">3</option>
                            <option value="3">4</option>
                            <option value="4">5</option>
                            <option value="5">6</option>
                            <option value="6">7</option>
                            <option value="7">8</option>
                            <option value="8">9</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome Escola</label> 
                        <input class="form-control" name="nomeEscola" id="nomeEscola" type="text" maxlength="250">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Ano Turma</label> 
                        <input class="form-control" name="anoTurma" id="anoTurma" type="text" maxlength="10">
                    </div>
                    <!-- <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Entrada</label> 
                        <input class="form-control" name="horaEntrada" id="horaEntrada" type="text" maxlength="">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Hora Saída</label> 
                        <input class="form-control" name="horaSaida" id="horaSaida" type="text" maxlength="">
                    </div>                                         -->
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