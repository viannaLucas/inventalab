<?PHP if (count($vGarantia) > 0) { ?>
    <!-- row -->
    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Recurso Trabalho</th>
                  <th scope="col">Descrição</th>
                  <th scope="col">Tipo</th>
                  <th scope="col">Data Início</th>
                  <th scope="col">Data Fim</th>
                </tr>
            </thead>
            <tbody>
            <?PHP foreach ($vGarantia as $i) { ?>
                <tr data-id='<?= $i->id ?>' data-text='<?= $i->descricao ?>'>
                    <td><?= $i->id ?></td>
                    <td><?= $i->getRecursoTrabalho()?->nome ?></td>
                    <td><?= $i->descricao ?></td>
                    <td><span style="color: <?= $i->_cl('tipo', $i->tipo) ?>;"><?= $i->_op('tipo', $i->tipo) ?></span></td>
                    <td><?= $i->dataInicio ?></td>
                    <td><?= $i->dataFim ?></td>
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