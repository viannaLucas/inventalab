<?PHP if (count($vDatasExtraordinarias) > 0) { ?>
    <!-- row -->
    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Data</th>
                  <th scope="col">Hora Início</th>
                  <th scope="col">Hora Fim</th>
                  <th scope="col">Tipo</th>
                </tr>
            </thead>
            <tbody>
            <?PHP foreach ($vDatasExtraordinarias as $i) { ?>
                <tr data-id='<?= esc($i->id, 'attr') ?>' data-text='<?= esc($i->data, 'attr') ?>'>
                    <td><?= esc($i->id) ?></td>
                    <td><?= esc($i->data) ?></td>
                    <td><?= esc($i->horaInicio) ?></td>
                    <td><?= esc($i->horaFim) ?></td>
                    <td><span style="color: <?= $i->_cl('tipo', $i->tipo) ?>;"><?= esc($i->_op('tipo', $i->tipo)) ?></span></td>
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