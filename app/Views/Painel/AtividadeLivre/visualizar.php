<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Atividade Livre</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Visualizar</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- content -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Visualizar</h4>
        </div>
        <div class="card-body pt-0">
            <form id='formVisualizar' class="needs-validation" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="id" value="<?= $atividadelivre->id ?>" />
                <div class="form-row">
                    
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Reserva</label> 
                        <div class="input-group">
                            <input class="form-control" name="Reserva_id_Text" id="Reserva_id_Text" type="text" disabled="true" value="<?= $atividadelivre->getReserva()->dataReserva ?>"/>
                            <input class="d-none" name="Reserva_id" id="Reserva_id" type="text" value="<?= $atividadelivre->Reserva_id ?>" />
                        </div>
                    </div>                    
                    <div class="form-group col-12 ">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Descrição</label> 
                        <textarea name="descricao" id="descricao" class="form-control" placeholder="" rows="3" disabled="true"><?= $atividadelivre->descricao ?></textarea>
                    </div>                                        
                <fieldset class="border rounded-10 m-0 mb-3 p-2 w-100">
                    <div class="border-bottom mx-n1 mb-3">
                        <h4 class="px-2">Lista de Atividade Livre Recurso</h4>
                    </div>
                    <table class="table table-striped" id="listTableAtividadeLivreRecurso">
                        <thead>
                            <tr>
                                <th scope="col">Recurso Trabalho</th>
                            </tr>
                        </thead>
                        <tbody >
                        </tbody>
                    </table>
                    <div class="w-100 text-center msgEmptyListAtividadeLivreRecurso mb-3">
                        <span class="h5">Sem itens selecionados</span>
                    </div>
                </fieldset>
                <div class="form-group mb-0 mt-3 text-center col-12">
                    <a href="javascript:history.back();" class="btn btn-primary">Voltar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="templateRowAtividadeLivreRecurso">
    <tr id='AtividadeLivreRecurso_{_index_}'>
        <td>
            <input type="text" class="form-control ignoreValidate" readonly="true" value="{_RecursoTrabalho_id_Text_}" />
        </td>
    </tr>
</template>
<!-- content closed -->
<?= $this->endSection('content'); ?>

<?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?>

<?= $this->section('scripts'); ?>
<script>
    var indexRowAtividadeLivreRecurso = 0;
    function insertRowAtividadeLivreRecurso(dados){
        let html = $('#templateRowAtividadeLivreRecurso').html();
        html = html.replaceAll('{_index_}', indexRowAtividadeLivreRecurso);
        html = html.replaceAll('{_RecursoTrabalho_id_Text_}', dados.RecursoTrabalho_id_Text);
        $('#listTableAtividadeLivreRecurso tbody').append(html);
        
        indexRowAtividadeLivreRecurso++;
        $(".msgEmptyListAtividadeLivreRecurso").hide();
    }

<?PHP foreach ($atividadelivre->getListAtividadeLivreRecurso() as $i => $o) {
    $o->RecursoTrabalho_id_Text = $o->getRecursoTrabalho()->nome;
?>
    insertRowAtividadeLivreRecurso(<?= json_encode($o) ?>);
<?PHP } ?>
</script>    
<?= $this->endSection('scripts'); ?>
