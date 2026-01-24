<?PHP if (count($vControlePresenca) > 0) { ?>
    <!-- row -->
    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Evento</th>
                  <th scope="col">Descrição</th>
                </tr>
            </thead>
            <tbody>
            <?PHP foreach ($vControlePresenca as $i) { ?>
                <tr data-id='<?= $i->id ?>' data-text='<?= $i->descricao ?>'>
                    <td><?= $i->id ?></td>
                    <td><?= $i->getEvento()?->nome ?></td>
                    <td><?= $i->descricao ?></td>
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