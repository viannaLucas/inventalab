<?PHP if (count($vServico) > 0) { ?>
    <!-- row -->
    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Nome</th>
                  <th scope="col">Descrição</th>
                  <th scope="col">Valor</th>
                  <th scope="col">Unidade</th>
                  <th scope="col">Ativo</th>
                </tr>
            </thead>
            <tbody>
            <?PHP foreach ($vServico as $i) { ?>
                <tr data-id='<?= $i->id ?>' data-text='<?= $i->Nome ?>' data-valor='<?= $i->valor ?>'>
                    <td><?= $i->id ?></td>
                    <td><?= $i->Nome ?></td>
                    <td><?= $i->descricao ?></td>
                    <td><?= $i->valor ?></td>
                    <td><?= $i->unidade ?></td>
                    <td><span style="color: <?= $i->_cl('ativo', $i->ativo) ?>;"><?= $i->_op('ativo', $i->ativo) ?></span></td>
                </tr>
            <?PHP } ?>
            </tbody>
        </table>
    </div>
<?PHP } else { ?>
    <div class="justify-content-center">
        <div class="card mg-b-20 text-center ">
            <div class="card-body h-100">
                <img src="<?PHP echo base_url('assets/img/no-data.svg'); ?>" alt="" class="" style="max-height: 100px;"/>
                <h5 class="mg-b-10 mg-t-15 tx-18">Itens não encontrados</h5>
                <a href="#" class="text-muted">Tente outro termo de pesquisa</a>
            </div>
        </div>
    </div>
<?PHP } ?>