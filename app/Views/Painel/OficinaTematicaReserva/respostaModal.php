<?PHP if (count($vOficinaTematicaReserva) > 0) { ?>
    <!-- row -->
    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Reserva</th>
                  <th scope="col">Oficina Temática</th>
                </tr>
            </thead>
            <tbody>
            <?PHP foreach ($vOficinaTematicaReserva as $i) { ?>
                <tr data-id='<?= $i->id ?>' data-text='<?= $i->id ?>'>
                    <td><?= $i->id ?></td>
                    <td><?= $i->getReserva()?->dataReserva ?></td>
                    <td><?= $i->getOficinaTematica()?->nome ?></td>
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