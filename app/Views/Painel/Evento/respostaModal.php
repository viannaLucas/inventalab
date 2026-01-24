<?PHP if (count($vEvento) > 0) { ?>
    <!-- row -->
    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Nome</th>
                  <th scope="col">Vagas Limitadas</th>
                  <th scope="col">Inscrições Abertas</th>
                  <th scope="col">Divulgar</th>
                  <th scope="col">Data Início</th>
                  <th scope="col">Valor</th>
                </tr>
            </thead>
            <tbody>
            <?PHP foreach ($vEvento as $i) { ?>
                <tr data-id='<?= $i->id ?>' data-text='<?= $i->nome ?>'>
                    <td><?= $i->id ?></td>
                    <td><?= $i->nome ?></td>
                    <td><span style="color: <?= $i->_cl('vagasLimitadas', $i->vagasLimitadas) ?>;"><?= $i->_op('vagasLimitadas', $i->vagasLimitadas) ?></span></td>
                    <td><span style="color: <?= $i->_cl('inscricoesAbertas', $i->inscricoesAbertas) ?>;"><?= $i->_op('inscricoesAbertas', $i->inscricoesAbertas) ?></span></td>
                    <td><span style="color: <?= $i->_cl('divulgar', $i->divulgar) ?>;"><?= $i->_op('divulgar', $i->divulgar) ?></span></td>
                    <td><?= $i->dataInicio ?></td>
                    <td><?= $i->valor ?></td>
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
