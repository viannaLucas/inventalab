<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Usuário</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Pesquisar</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- row -->
<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Pesquisar</h4>
        </div>
        <div class="card-body pt-0">
            <form id='formPesquisar' action="<?PHP echo base_url('Usuario/doPesquisar'); ?>" class="needs-validation" method="get" enctype="multipart/form-data" >
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Nome</label> 
                        <input class="form-control" name="nome" id="nome" type="text" maxlength="50" value="<?= esc(old('nome'), 'attr') ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">Email Login</label> 
                        <input class="form-control" name="login" id="login" type="text" maxlength="50" value="<?= esc(old('login'), 'attr' ) ?>">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600" for="ativo">Ativo</label> 
                        <select class="form-control select2" name="ativo[]" id="ativo" multiple="multiple">
                            <option value=""></option>
                            <option value="0">Inativo</option>
                            <option value="1">Ativo</option>
                        </select>
                    </div>
                    <div class="form-group mb-0 mt-3 text-center col-12">
                        <div>
                            <button type="submit" class="btn btn-primary submitButton">Pesquisar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- row closed -->
<?= $this->endSection('content'); ?>