<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Oficina Temática</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Alterar</span>
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
            <form id='formAlterar' action="<?PHP echo base_url('OficinaTematica/doAlterar'); ?>" class="needs-validation" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="id" value="<?= esc($oficinatematica->id, 'attr') ?>" />
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                        <input class="form-control" name="nome" id="nome" type="text" maxlength="150" value="<?= esc($oficinatematica->nome, 'attr') ?>">
                    </div>                    
                    <div class="col-12">
                        <textarea name="descricaoAtividade" id="descricaoAtividade" class="form-control summernote"><?= esc($oficinatematica->descricaoAtividade) ?></textarea>
                    </div>
                </div>                                    
                <br>    
                <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                    <div class="border-bottom mx-n1 mb-3">
                        <h4 class="px-2">Lista de Arquivo Oficina</h4>
                    </div>
                    <div class="form-row px-2"><div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                            <input class="form-control" name="arquivooficina_nome" id="arquivooficina_nome" type="text" maxlength="50" value="">
                        </div>                        
                        <div class="form-group col-auto ">
                            <label>Arquivo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="arquivooficina_arquivo" name="arquivooficina_arquivo" accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.zip,.jpg,.jpeg,.png">
                                <label class="custom-file-label" for="arquivooficina_arquivo" data-browse="Arquivo"></label>
                            </div>
                        </div>                        
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label> 
                            <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddArquivoOficina">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <table class="table table-striped" id="listTableArquivoOficina">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Arquivo</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody >
                        </tbody>
                    </table>
                    <div class="w-100 text-center msgEmptyListArquivoOficina mb-3">
                        <span class="h5">Sem itens selecionados</span>
                    </div>
                </fieldset>
                <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                    <div class="border-bottom mx-n1 mb-3">
                        <h4 class="px-2">Lista de Material Oficina</h4>
                    </div>
                    <div class="form-row px-2"><div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Descrição</label> 
                            <input class="form-control" name="materialoficina_descricao" id="materialoficina_descricao" type="text" maxlength="200" value="">
                        </div>                        
                        <div class="form-group col-12 ">
                            <label>Foto</label>
                            <input type="file" class="dropify" id="materialoficina_foto" name="materialoficina_foto" accept=".jpg,.jpeg,.webp,.png" 
                                   data-allowed-file-extensions="webp png jpeg jpg" data-max-file-size="10M" >
                        </div>                        
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label> 
                            <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddMaterialOficina">
                                Adicionar Material &nbsp;
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <table class="table table-striped" id="listTableMaterialOficina">
                        <thead>
                            <tr>
                                <th scope="col">Descrição</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody >
                        </tbody>
                    </table>
                    <div class="w-100 text-center msgEmptyListMaterialOficina mb-3">
                        <span class="h5">Sem itens selecionados</span>
                    </div>
                </fieldset>
                <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                    <div class="border-bottom mx-n1 mb-3">
                        <h4 class="px-2">Lista de Recurso Oficina</h4>
                    </div>
                    <div class="form-row px-2">
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Recurso Trabalho</label> 
                            <div class="input-group mb-3">
                                <input class="form-control" name="recursooficina_RecursoTrabalho_id_Text" id="recursooficina_RecursoTrabalho_id_Text" type="text" disabled="true" onclick="$('#addonSearchrecursooficina_RecursoTrabalho_id').click()" value=""/>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="addonSearchrecursooficina_RecursoTrabalho_id" 
                                            data-toggle="modal" data-target="#modalFK" data-title='Localizar >Recurso Trabalho'
                                            data-url-search='<?PHP echo base_url('RecursoTrabalho/pesquisaModal?searchTerm='); ?>' data-input-result='recursooficina_RecursoTrabalho_id' data-input-text='recursooficina_RecursoTrabalho_id_Text' >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                        </svg>
                                    </button>
                                </div>
                                <input class="d-none" name="recursooficina_RecursoTrabalho_id" id="recursooficina_RecursoTrabalho_id" type="text" value="" />
                            </div>
                        </div>                        
                        <div class="form-group col-auto">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">&nbsp;</label> 
                            <button type="button" class="form-inline btn btn-primary" style="padding: 12px 20px;" id="btnAddRecursoOficina">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <table class="table table-striped" id="listTableRecursoOficina">
                        <thead>
                            <tr>
                                <th scope="col">Recurso Trabalho</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody >
                        </tbody>
                    </table>
                    <div class="w-100 text-center msgEmptyListRecursoOficina mb-3">
                        <span class="h5">Sem itens selecionados</span>
                    </div>
                </fieldset>
                <div id="filesArquivoOficina" class="d-none"></div>
                <div id="filesMaterialOficina" class="d-none"></div>
                <div class="form-group mb-0 mt-3 text-center col-12">
                    <button type="submit" class="btn btn-primary submitButton">Alterar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="templateRowArquivoOficina">
    <tr id='ArquivoOficina_{_index_}'>
        <td><input type="text" class="form-control ignoreValidate" name="ArquivoOficina[{_index_}][nome]" readonly="true" value="{_nome_}" /></td>
        <td><input type="text" class="form-control ignoreValidate" name="ArquivoOficina[{_index_}][arquivo]" readonly="true" value="{_arquivo_}" /></td>
        <td>
            {_view_btn_}
            <div class="btn btn-danger btnExcluirArquivoOficina" onclick="$('#ArquivoOficina_{_index_}').remove(); $('#arquivooficina_file_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>
            </div>
        </td>
    </tr>
</template>
<template id="templateRowMaterialOficina">
    <tr id='MaterialOficina_{_index_}'>
        <td><input type="text" class="form-control ignoreValidate" name="MaterialOficina[{_index_}][descricao]" readonly="true" value="{_descricao_}" /></td>
        <td><input type="text" class="form-control ignoreValidate" name="MaterialOficina[{_index_}][foto]" readonly="true" value="{_foto_}" /></td>
        <td>
            {_view_btn_}
            <div class="btn btn-danger btnExcluirMaterialOficina" onclick="$('#MaterialOficina_{_index_}').remove(); $('#materialoficina_file_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                </svg>
            </div>
        </td>
    </tr>
</template>
<template id="templateRowRecursoOficina">
    <tr id='RecursoOficina_{_index_}'>
        <td>
            <input type="hidden" class="form-control ignoreValidate fkRecursoTrabalho_idRecursoOficina" name="RecursoOficina[{_index_}][RecursoTrabalho_id]" readonly="true" value="{_RecursoTrabalho_id_}" />
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_RecursoTrabalho_id_Text_}" />
        </td>
        <td>
            <div class="btn btn-danger btnExcluirRecursoOficina" onclick="$('#RecursoOficina_{_index_}').remove();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>
            </div>
        </td>
    </tr>
</template>
<!-- content closed -->
<?= $this->endSection('content'); ?><?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?><?= $this->section('scripts'); ?>
<script>
    $('.submitButton').on('click', function(e){
        //$(this).attr('disabled', true);
        disableValidationFieldsFK();
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
            enableValidationFieldsFK();
        },
        errorElement: "div",
        ignore: '.ignoreValidate',
        rules: {
            nome: {
                required: true,
            },
            descricaoAtividade: {
                required: true,
            },
            arquivooficina_nome: {
                required: true,
            },
            arquivooficina_arquivo: {
                required: true,
                arquivo: 'pdf|doc|docx|xls|xlsx|csv|zip|jpg|jpeg|png',
            },
            materialoficina_descricao: {
                required: true,
            },
            materialoficina_foto: {
                arquivo: 'webp|jpg|jpeg|png',
            },
            recursooficina_RecursoTrabalho_id: {
                required: true,
            },
        }
    });

    var inputsArquivoOficina = [
        'arquivooficina_nome',
        'arquivooficina_arquivo',
    ];
    
    $('#btnAddArquivoOficina').on('click', function (e) {
        addArquivoOficina();
    });

    var inputsMaterialOficina = [
        'materialoficina_descricao',
        'materialoficina_foto',
    ];
    
    $('#btnAddMaterialOficina').on('click', function (e) {
        addMaterialOficina();
    });

    var inputsRecursoOficina = [
        'recursooficina_RecursoTrabalho_id',
    ];
    
    $('#btnAddRecursoOficina').on('click', function (e) {
        addRecursoOficina();
    });

    function disableValidationFieldsFK() {
        for (var i in inputsArquivoOficina) {
            $('#' + inputsArquivoOficina[i]).addClass('ignoreValidate');
        }
        for (var i in inputsMaterialOficina) {
            $('#' + inputsMaterialOficina[i]).addClass('ignoreValidate');
        }
        for (var i in inputsRecursoOficina) {
            $('#' + inputsRecursoOficina[i]).addClass('ignoreValidate');
        }
    }

    function enableValidationFieldsFK() {
        for (var i in inputsArquivoOficina) {
            $('#' + inputsArquivoOficina[i]).removeClass('ignoreValidate');
        }
        for (var i in inputsMaterialOficina) {
            $('#' + inputsMaterialOficina[i]).removeClass('ignoreValidate');
        }
        for (var i in inputsRecursoOficina) {
            $('#' + inputsRecursoOficina[i]).removeClass('ignoreValidate');
        }
    }

    var indexRowArquivoOficina = 0;
    function addArquivoOficina() {
        $('.msgEmptyListArquivoOficina').addClass('d-none');
        //$('#listTableArquivoOficina').removeClass('d-none');
        let error = false;
        for (var i in inputsArquivoOficina) {
            if (!$('#' + inputsArquivoOficina[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        const index = indexRowArquivoOficina;
        let dados = {};
        dados.nome = $('#arquivooficina_nome').val();
        dados.arquivo = $('#arquivooficina_arquivo').val().split(/[/\\\\]/).pop();
            
        insertRowArquivoOficina(dados);

        const $fileInput = $('#arquivooficina_arquivo');
        const $fileWrapper = $fileInput.closest('.custom-file');
        $fileInput
            .attr('id', 'arquivooficina_file_' + index)
            .attr('name', 'arquivooficina_arquivo_' + index)
            .addClass('d-none');
        $('#filesArquivoOficina').append($fileInput);

        $fileWrapper.html(
            '<input type="file" class="custom-file-input" id="arquivooficina_arquivo" name="arquivooficina_arquivo" accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.zip">' +
            '<label class="custom-file-label" for="arquivooficina_arquivo" data-browse="Arquivo"></label>'
        );
        
        $('#arquivooficina_nome').val('');
    }

    var indexRowMaterialOficina = 0;
    function addMaterialOficina() {
        $('.msgEmptyListMaterialOficina').addClass('d-none');
        //$('#listTableMaterialOficina').removeClass('d-none');
        let error = false;
        for (var i in inputsMaterialOficina) {
            if (!$('#' + inputsMaterialOficina[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        const index = indexRowMaterialOficina;
        let dados = {};
        dados.descricao = $('#materialoficina_descricao').val();
        dados.foto = $('#materialoficina_foto').val().split(/[/\\\\]/).pop();
            
        insertRowMaterialOficina(dados);
        
        const $fotoInput = $('#materialoficina_foto');
        const $fotoContainer = $fotoInput.closest('.form-group');
        const dropifyFoto = $fotoInput.data('dropify');
        if (dropifyFoto) {
            dropifyFoto.destroy();
        }
        $fotoInput
            .attr('id', 'materialoficina_file_' + index)
            .attr('name', 'materialoficina_foto_' + index)
            .removeClass('dropify')
            .addClass('d-none');
        $('#filesMaterialOficina').append($fotoInput);

        $fotoContainer.append(
            '<input type="file" class="dropify" id="materialoficina_foto" name="materialoficina_foto" accept=".jpg,.jpeg,.webp,.png" ' +
            'data-allowed-file-extensions="webp png jpeg jpg" data-max-file-size="10M">'
        );
        $fotoContainer.find('#materialoficina_foto').dropify();
        
        $('#materialoficina_descricao').val('');
    }

    var indexRowRecursoOficina = 0;
    function addRecursoOficina() {
        $('.msgEmptyListRecursoOficina').addClass('d-none');
        //$('#listTableRecursoOficina').removeClass('d-none');
        let error = false;
        for (var i in inputsRecursoOficina) {
            if (!$('#' + inputsRecursoOficina[i]).valid()) {
                error = true;
            }
        }
        if (error) {
            return;
        }
        let dados = {};
        dados.RecursoTrabalho_id = $('#recursooficina_RecursoTrabalho_id').val();
        dados.RecursoTrabalho_id_Text = $('#recursooficina_RecursoTrabalho_id_Text').val();
            
        insertRowRecursoOficina(dados);
        
        $('#recursooficina_RecursoTrabalho_id').val('');
        $('#recursooficina_RecursoTrabalho_id_Text').val('');
    }
    
    function insertRowArquivoOficina(dados){
        let html = $('#templateRowArquivoOficina').html();
        html = html.replaceAll('{_index_}', indexRowArquivoOficina);
        html = html.replaceAll('{_nome_}', dados.nome);
        html = html.replaceAll('{_arquivo_}', dados.arquivo);
        let viewBtnArquivo = '';
        if (dados.id && dados.arquivo) {
            viewBtnArquivo = buildViewButton(dados.arquivo);
        }
        html = html.replaceAll('{_view_btn_}', viewBtnArquivo);
        $('#listTableArquivoOficina tbody').append(html);
        
        indexRowArquivoOficina++;
        $(".msgEmptyListArquivoOficina").hide();
    }
    
    function insertRowMaterialOficina(dados){
        let html = $('#templateRowMaterialOficina').html();
        html = html.replaceAll('{_index_}', indexRowMaterialOficina);
        html = html.replaceAll('{_descricao_}', dados.descricao);
        html = html.replaceAll('{_foto_}', dados.foto);
        let viewBtnFoto = '';
        if (dados.id && dados.foto) {
            viewBtnFoto = buildViewButton(dados.foto);
        }
        html = html.replaceAll('{_view_btn_}', viewBtnFoto);
        $('#listTableMaterialOficina tbody').append(html);
        
        indexRowMaterialOficina++;
        $(".msgEmptyListMaterialOficina").hide();
    }
    
    function insertRowRecursoOficina(dados){
        let html = $('#templateRowRecursoOficina').html();
        html = html.replaceAll('{_index_}', indexRowRecursoOficina);
        html = html.replaceAll('{_RecursoTrabalho_id_}', dados.RecursoTrabalho_id);
        html = html.replaceAll('{_RecursoTrabalho_id_Text_}', dados.RecursoTrabalho_id_Text);
        $('#listTableRecursoOficina tbody').append(html);
        
        indexRowRecursoOficina++;
        $(".msgEmptyListRecursoOficina").hide();
    }

    const baseUrl = "<?= base_url() ?>";

    function buildFileUrl(path) {
        if (!path) return '';
        if (/^https?:\/\//i.test(path)) return path;
        const base = baseUrl.replace(/\/$/, '');
        const cleanPath = path.replace(/^\//, '');
        return base + '/' + cleanPath;
    }

    function buildViewButton(path) {
        const url = buildFileUrl(path);
        return '<a class="btn btn-info mr-1" target="_blank" rel="noopener" href="' + url + '">' +
            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">' +
            '<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>' +
            '<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>' +
            '</svg>' +
            '</a>';
    }

<?PHP foreach ($oficinatematica->getListArquivoOficina() as $i => $o) {
?>
    insertRowArquivoOficina(<?= json_encode($o) ?>);
<?PHP } ?>
<?PHP foreach ($oficinatematica->getListMaterialOficina() as $i => $o) {
?>
    insertRowMaterialOficina(<?= json_encode($o) ?>);
<?PHP } ?>
<?PHP foreach ($oficinatematica->getListRecursoOficina() as $i => $o) {
    $o->RecursoTrabalho_id_Text = $o->getRecursoTrabalho()->nome;
?>
    insertRowRecursoOficina(<?= json_encode($o) ?>);
<?PHP } ?>


$(function() {
        setTimeout(function() {
            var $frame = $('.summernote').next('.note-editor'); // contêiner renderizado
            $frame.find('.note-editable').css('height', '500px'); // altura fixa
            $frame.find('.note-editable').css('min-height', '500px'); // ou min-height
            $frame.find('.note-statusbar').show(); // opcional: habilitar barra p/ redimensionar
        }, 100);
    });
</script>    
<?= $this->endSection('scripts'); ?>
