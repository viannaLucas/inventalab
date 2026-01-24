<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Configuração</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Alterar</span>
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
            <form id='formAlterar' action="<?PHP echo base_url('Configuracao/doAlterar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="id" value="<?= $configuracao->id ?>" />
                <div class="form-row">
                    <div class="form-group col-12 col-md-6"> 
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="lotacaoEspaco">Lotação Espaço</label>
                        <button type="button" class="btn btn-link p-0 ml-2 align-baseline text-info" data-toggle="modal" data-target="#configuracaoCampoAjuda" aria-label="Ajuda sobre os campos da configuração">
                            <span class="badge badge-secondary rounded-circle px-2">?</span>
                        </button>
                        <input class="form-control maskInteiro" name="lotacaoEspaco" id="lotacaoEspaco" type="text" value="<?= $configuracao->lotacaoEspaco ?>">
                        <small class="form-text text-muted">Número de pessoas simultâneas no espaço (lotação)</small>
                    </div>                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="intervaloEntrePesquisa">Intervalo Entre Pesquisa</label>
                        <button type="button" class="btn btn-link p-0 ml-2 align-baseline text-info" data-toggle="modal" data-target="#configuracaoCampoAjuda" aria-label="Ajuda sobre os campos da configuração">
                            <span class="badge badge-secondary rounded-circle px-2">?</span>
                        </button>
                        <input class="form-control maskInteiro" name="intervaloEntrePesquisa" id="intervaloEntrePesquisa" type="text" value="<?= $configuracao->intervaloEntrePesquisa ?>">
                        <small class="form-text text-muted">Intervalo mínimo em dias para enviar pesquisas</small>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Serviço</label> 
                        <div class="input-group">
                            <input class="form-control" name="servicoUsoEspaco_Text" id="servicoUsoEspaco_Text" type="text" disabled="true" onclick="$('#addonSearchservicoUsoEspaco').click()" value="<?= $configuracao->getServico()->Nome ?>"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="addonSearchservicoUsoEspaco" 
                                        data-toggle="modal" data-target="#modalFK" data-title='Localizar Serviço'
                                        data-url-search='<?PHP echo base_url('Servico/pesquisaModal?searchTerm='); ?>' data-input-result='servicoUsoEspaco' data-input-text='servicoUsoEspaco_Text' >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <input class="d-none" name="servicoUsoEspaco" id="servicoUsoEspaco" type="text" value="<?= $configuracao->getServico()->id ?>" />
                        </div>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="adicinarCalculoServico">Adicionar Cálculo Serviço</label>
                        <select class="form-control" name="adicinarCalculoServico" id="adicinarCalculoServico" required="">
                            <?PHP foreach (App\Entities\ConfiguracaoEntity::_op('adicinarCalculoServico') as $k => $op) { ?>
                            <option value="<?= $k; ?>" <?= ((int)$configuracao->adicinarCalculoServico) === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                            <?PHP } ?>
                        </select>
                        <small class="form-text text-muted">Define se o cálculo do serviço deve ser aplicado automaticamente.</small>
                    </div>
                    <div class="col-12">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="intervaloEntrePesquisa">Texto do Email de Confirmação</label>
                        <textarea name="textoEmailConfirmacao" id="textoEmailConfirmacao" class="form-control summernote"><?= $configuracao->textoEmailConfirmacao ?></textarea>
                    </div>
                </div>                                        
                <div class="form-group mb-0 mt-3 text-center col-12">
                    <button type="submit" class="btn btn-primary submitButton">Alterar</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="configuracaoCampoAjuda" tabindex="-1" role="dialog" aria-labelledby="configuracaoCampoAjudaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="configuracaoCampoAjudaLabel">Como configurar estes campos?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Lotação espaço:</strong> define o número máximo de pessoas que podem utilizar o espaço simultaneamente. O sistema bloqueia novas reservas para o mesmo horário assim que este limite é atingido.</p>
                    <p><strong>Intervalo entre pesquisa:</strong> define, em dias, o tempo mínimo entre os envios da pesquisa de avaliação para um mesmo visitante. Isso evita disparar vários e-mails quando alguém faz reservas em horários ou dias muito próximos.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Entendi</button>
                </div>
            </div>
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
            lotacaoEspaco: {
                required: true,
                inteiro: true,
            },
            intervaloEntrePesquisa: {
                required: true,
                inteiro: true,
            },
            textoEmailConfirmacao: {
                required: true,
            },
            adicinarCalculoServico: {
                required: true,
            },
        }
    });

</script>    
<?= $this->endSection('scripts'); ?>
