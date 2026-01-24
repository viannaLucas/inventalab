<?PHP if (count($vExemploCampos) > 0) { ?>
    <!-- row -->
    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Tipo Texto</th>
                  <th scope="col">Tipo Data</th>
                  <th scope="col">Tipo Número</th>
                  <th scope="col">Tipo Real</th>
                  <th scope="col">Tipo CPF</th>
                  <th scope="col">Tipo CNPJ</th>
                  <th scope="col">Tipo Email</th>
                  <th scope="col">Tipo Select</th>
                  <th scope="col">Tipo Telefone</th>
                  <th scope="col">Tipo Senha</th>
                  <th scope="col">Foreignkey</th>
                </tr>
            </thead>
            <tbody>
            <?PHP foreach ($vExemploCampos as $i) { ?>
                <tr data-id='<?= $i->id ?>' data-text='<?= $i->tipoTexto ?>'>
                    <td><?= $i->id ?></td>
                    <td><?= $i->tipoTexto ?></td>
                    <td><?= $i->tipoData ?></td>
                    <td><?= $i->tipoNumero ?></td>
                    <td><?= $i->tipoReal ?></td>
                    <td><?= $i->tipoCPF ?></td>
                    <td><?= $i->tipoCNPJ ?></td>
                    <td><?= $i->tipoEmail ?></td>
                    <td><span style="color: <?= $i->_cl('tipoSelect', $i->tipoSelect) ?>;"><?= $i->_op('tipoSelect', $i->tipoSelect) ?></span></td>
                    <td><?= $i->tipoTelefone ?></td>
                    <td><?= $i->tipoSenha ?></td>
                    <td><?= $i->getTabelaFK()?->nome ?></td>
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