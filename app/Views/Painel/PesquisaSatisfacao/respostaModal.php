<?PHP if (count($vPesquisaSatisfacao) > 0) { ?>
    <!-- row -->
    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Participante</th>
                  <th scope="col">Resposta 1</th>
                  <th scope="col">Resposta 2</th>
                  <th scope="col">Resposta 3</th>
                  <th scope="col">Data Resposta</th>
                </tr>
            </thead>
            <tbody>
            <?PHP foreach ($vPesquisaSatisfacao as $i) { ?>
                <tr data-id='<?= $i->id ?>' data-text='<?= $i->id ?>'>
                    <td><?= $i->id ?></td>
                    <td><?= $i->Participante_id ?></td>
                    <td><?= $i->resposta1 ?></td>
                    <td><?= $i->resposta2 ?></td>
                    <td><?= $i->resposta3 ?></td>
                    <td><?= $i->dataResposta ?></td>
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