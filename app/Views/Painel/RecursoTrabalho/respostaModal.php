<?PHP if (count($vRecursoTrabalho) > 0) { ?>
    <!-- row -->
    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Nome</th>
                  <th scope="col">Tipo</th>
                  <th scope="col">Requer Habilidade</th>
                  <th scope="col">Uso Exclusivo</th>
                  <th scope="col">Situação Trabalho</th>
                </tr>
            </thead>
            <tbody>
            <?PHP foreach ($vRecursoTrabalho as $i) { ?>
                <tr data-id='<?= esc($i->id, 'attr') ?>' data-text='<?= esc($i->nome, 'attr') ?>'>
                    <td><?= esc($i->id) ?></td>
                    <td><?= esc($i->nome) ?></td>
                    <td><span style="color: <?= $i->_cl('tipo', $i->tipo) ?>;"><?= esc($i->_op('tipo', $i->tipo)) ?></span></td>
                    <td><span style="color: <?= $i->_cl('requerHabilidade', $i->requerHabilidade) ?>;"><?= esc($i->_op('requerHabilidade', $i->requerHabilidade)) ?></span></td>
                    <td><span style="color: <?= $i->_cl('usoExclusivo', $i->usoExclusivo) ?>;"><?= esc($i->_op('usoExclusivo', $i->usoExclusivo)) ?></span></td>
                    <td><span style="color: <?= $i->_cl('situacaoTrabalho', $i->situacaoTrabalho) ?>;"><?= esc($i->_op('situacaoTrabalho', $i->situacaoTrabalho)) ?></span></td>
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