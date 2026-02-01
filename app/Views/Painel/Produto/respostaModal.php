<?PHP if (count($vProduto) > 0) { ?>
    <!-- row -->
    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Nome</th>
                  <!-- Valor desabilitado temporariamente -->
                  <!-- <th scope="col">Valor</th> -->
                  <th scope="col">Estoque Mínimo</th>
                  <th scope="col">Estoque Atual</th>
                  <!-- <th scope="col">Ativo</th> -->
                </tr>
            </thead>
            <tbody>
            <?PHP foreach ($vProduto as $i) { ?>
                <tr data-id='<?= esc($i->id, 'attr') ?>' data-text='<?= esc($i->nome, 'attr') ?>'>
                    <td><?= esc($i->id) ?></td>
                    <td><?= esc($i->nome) ?></td>
                    <!-- <td><?= esc($i->valor) ?></td> -->
                    <td><?= esc($i->estoqueMinimo) ?></td>
                    <td><?= esc($i->estoqueAtual) ?></td>
                    <!-- <td><span style="color: <?= $i->_cl('ativo', $i->ativo) ?>;"><?= esc($i->_op('ativo', $i->ativo)) ?></span></td> -->
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
