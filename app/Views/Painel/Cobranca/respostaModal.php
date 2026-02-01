<?PHP if (count($vCobranca) > 0) { ?>
    <!-- row -->
    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Participante</th>
                  <th scope="col">Data</th>
                  <th scope="col">Valor</th>
                  <th scope="col">Situação</th>
                </tr>
            </thead>
            <tbody>
            <?PHP foreach ($vCobranca as $i) { ?>
                <tr data-id='<?= esc($i->id, 'attr') ?>' data-text='<?= esc($i->id, 'attr') ?>'>
                    <td><?= esc($i->id) ?></td>
                    <td><?= $i->getParticipante()?->nome ?></td>
                    <td><?= esc($i->data) ?></td>
                    <td><?= esc($i->valor) ?></td>
                    <td><span style="color: <?= $i->_cl('situacao', $i->situacao) ?>;"><?= esc($i->_op('situacao', $i->situacao)) ?></span></td>
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