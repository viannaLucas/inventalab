<?PHP if (count($vReserva) > 0) { ?>
    <!-- row -->
    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Data Cadastro</th>
                  <th scope="col">Data Reserva</th>
                  <th scope="col">Hora Início</th>
                  <th scope="col">Hora Fim</th>
                  <th scope="col">Tipo</th>
                  <th scope="col">Número Convidados</th>
                  <th scope="col">Status</th>
                  <th scope="col">Turma Escola</th>
                  <th scope="col">Hora Entrada</th>
                  <th scope="col">Hora Saída</th>
                </tr>
            </thead>
            <tbody>
            <?PHP foreach ($vReserva as $i) { ?>
                <tr data-id='<?= $i->id ?>' data-text='<?= $i->dataReserva ?>'>
                    <td><?= $i->id ?></td>
                    <td><?= $i->dataCadastro ?></td>
                    <td><?= $i->dataReserva ?></td>
                    <td><?= $i->horaInicio ?></td>
                    <td><?= $i->horaFim ?></td>
                    <td><span style="color: <?= $i->_cl('tipo', $i->tipo) ?>;"><?= $i->_op('tipo', $i->tipo) ?></span></td>
                    <td><?= $i->numeroConvidados ?></td>
                    <td><span style="color: <?= $i->_cl('status', $i->status) ?>;"><?= $i->_op('status', $i->status) ?></span></td>
                    <td><span style="color: <?= $i->_cl('turmaEscola', $i->turmaEscola) ?>;"><?= $i->_op('turmaEscola', $i->turmaEscola) ?></span></td>
                    <td><?= $i->horaEntrada ?></td>
                    <td><?= $i->horaSaida ?></td>
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