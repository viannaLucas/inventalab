<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Olá, Bem-vindo de volta!</h2>
            <p class="mg-b-0">Dashboard para visão geral do sistema.</p>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card">
            <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mb-0">Reservas de Hoje</h4>
                    <a href="<?= base_url('Reserva/cadastrar') ?>" class="btn btn-sm btn-secondary">Adicionar Reserva</a>
                </div>
                <p class="tx-12 text-muted mb-0">Lista de Reservas agendadas para hoje.</p>
            </div>
            <div class="card-body">
                <div class="container px-0 ">
                    <div class="card m-0">
                        <div class="card-body p-0 m-0">
                            <?php if (empty($vReserva)) : ?>
                                <div class="p-3 text-center">Não há reservas para hoje.</div>
                            <?php else : ?>
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="pt-1">Descrição</th>
                                                <th scope="col" class="text-right px-5"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?PHP foreach ($vReserva as $i) {
                                                $horaEntrada = $i->horaEntrada == '0000-00-00 00:00:00' ? '' : DateTime::createFromFormat('Y-m-d H:i:s', $i->horaEntrada)->format('H:i');
                                            $horaSaida = $i->horaSaida == '0000-00-00 00:00:00' ? '' : DateTime::createFromFormat('Y-m-d H:i:s', $i->horaSaida)->format('H:i');
                                            $textoSaida = $horaSaida == '' ? 'Aguardando Saída' : $horaSaida;
                                            $textoEntradaSaida = $horaEntrada == '' ? 'Aguardando Entrada' : $horaEntrada . ' - ' . $textoSaida;
                                            $textoAno = $i->anoTurma != '' && isset($i->op_anoTurma[$i->anoTurma]) ? ' - ' . $i->op_anoTurma[$i->anoTurma] : "";
                                            $nomeParticipante = $i->getListReservaParticipante()[0]->getParticipante()->nome;
                                        ?>
                                            <tr>
                                                <td>
                                                    <div><?= $nomeParticipante ?></div>
                                                    <div>Reserva <?= $i->op_tipo[$i->tipo] ?> das <?= $i->horaInicio . " às " . $i->horaFim ?> <?= $i->numeroConvidados + 1 ?> <?= $i->numeroConvidados == 0 ? 'Participante' : 'Participantes';  ?></div>
                                                    <div><?= $textoEntradaSaida; ?></div>
                                                    <div class="text-muted"><?= $i->nomeEscola . $textoAno ?></div>
                                                </td>
                                                <td class="text-right">
                                                        <?php if ($horaEntrada == '') { ?>
                                                            <div data-reserva='<?= $i->id; ?>' data-idade="<?= (int) ($i->idadeParticipante ?? 0); ?>" data-termo="<?= (int) ($i->temTermoResponsabilidade ?? 0); ?>" data-suspenso="<?= (int) ($i->participanteSuspenso ?? 0); ?>" class="btn btn-sm btn-success btn-entrada">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                                                    <title>Definir Entrada</title>
                                                                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z" />
                                                                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                                                                </svg>
                                                                <span class="pl-1">Definir Entrada</span>

                                                            </div>
                                                        <?php } elseif ($horaSaida == '') { ?>
                                                            <div data-reserva='<?= $i->id; ?>' data-participante="<?= esc($nomeParticipante, 'attr'); ?>" class="btn  btn-sm btn-secondary btn-add-consumo">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-check" viewBox="0 0 16 16">
                                                                    <title>Adicionar Consumo</title>
                                                                    <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0" />
                                                                </svg>
                                                                <span class="pl-1">Adicionar Consumo &nbsp;&nbsp;</span>
                                                            </div>
                                                            <div data-reserva='<?= $i->id; ?>' data-participante="<?= esc($nomeParticipante, 'attr'); ?>" data-hora-entrada="<?= esc($i->horaEntrada, 'attr'); ?>" data-convidados="<?= (int) $i->numeroConvidados; ?>" class="btn btn-sm btn-info btn-saida">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                                                    <title>Definir Saída</title>
                                                                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                                                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                                                                </svg>
                                                                <span class="pl-1">Definir Saída &nbsp;&nbsp;</span>
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($vReservasSemSaida)) : ?>
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card  box-shadow-0">
            <div class="card-header">
                <h4 class="card-title mb-1">Reserva em aberto de outros dias</h4>
                <small class="text-muted d-block">Reservas de outros dias que tiveram registro de entrada e não tiveram registro de saída; precisam ser corrigidas.</small>
            </div>
            <div class="card-body pt-0">
                <?php
                $formatarHora = static function ($valor) {
                    if (empty($valor) || $valor === '0000-00-00 00:00:00') {
                        return '-';
                    }

                    $timestamp = strtotime($valor);

                    return $timestamp ? date('H:i', $timestamp) : '-';
                };
                ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Data Cadastro</th>
                                <th scope="col">Data Reserva</th>
                                <th scope="col">Reserva<br>Início/Fim</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Convidados</th>
                                <th scope="col">Status</th>
                                <th scope="col">Turma Escola</th>
                                <th scope="col">Hora<br>Entrada/Saída</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                        <?PHP foreach ($vReservasSemSaida as $i) { ?>
                            <tr>
                                <td><?= $i->id ?></td>
                                <td><?= $i->dataCadastro ?></td>
                                <td><?= $i->dataReserva ?></td>
                                <td><?= $i->horaInicio.' - '.$i->horaFim ?></td>
                                <td><span style="color: <?= $i->_cl('tipo', $i->tipo) ?>;"><?= $i->_op('tipo', $i->tipo) ?></span></td>
                                <td><?= $i->numeroConvidados ?></td>
                                <td><span style="color: <?= $i->_cl('status', $i->status) ?>;"><?= $i->_op('status', $i->status) ?></span></td>
                                <td><span style="color: <?= $i->_cl('turmaEscola', $i->turmaEscola) ?>;"><?= $i->_op('turmaEscola', $i->turmaEscola) ?></span></td>
                                <td><?= $formatarHora($i->horaEntrada) . ' / ' . $formatarHora($i->horaSaida) ?></td>
                                <td>
                                    <a href="<?php echo base_url('Reserva/alterar/' . $i->id); ?>" class="btn btn-primary  btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </a>
                                    <div data-href="<?php echo base_url('Reserva/excluir/' . $i->id); ?>" class="btn btn-danger btn-sm btnExcluirLista">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('modal'); ?>

<template id="horario-modal-template">
    <div class="modal fade" id="{modalId}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <form method="post" action="">
                    <div class="modal-header">
                        <h6 class="modal-title"></h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="{modalId}-hora">Horário</label>
                            <input type="time" class="form-control" id="{modalId}-hora" name="hora" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple" type="submit"></button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<div class="modal fade" id="modalReservaSaida" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <form method="post" action="">
                <div class="modal-header">
                    <h6 class="modal-title">Definir Saída</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Reserva de <strong class="js-saida-participante"></strong></p>
                    <input type="hidden" name="reserva_id" value="">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Hora de Entrada</label>
                            <div class="form-control-plaintext border rounded px-2 py-1 js-saida-hora-entrada">--:--</div>
                        </div>
                        <div class="col-md-4">
                            <label for="modalReservaSaida-hora">Hora de Saída</label>
                            <input type="time" class="form-control" id="modalReservaSaida-hora" name="hora" required>
                        </div>
                        <div class="col-md-4">
                            <label>Pessoas</label>
                            <input type="number" min="1" class="form-control js-saida-pessoas" value="1">
                        </div>
                    </div>

                    <?php if (!empty($usarCalculoUsoEspaco)) : ?>
                    <div class="card border mt-3">
                        <div class="card-body p-3">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                <h6 class="mb-2 mb-md-0">Uso do Espaço</h6>
                                <small class="text-muted">Calcule primeiro, depois adicione à lista de serviços.</small>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mt-2">
                                    <label>Minutos de uso</label>
                                    <input type="text" class="form-control form-control-sm js-saida-minutos" readonly>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label>Quantidade (pessoas x minutos)</label>
                                    <input type="text" class="form-control form-control-sm js-saida-quantidade" readonly>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label>Valor por minuto</label>
                                    <input type="text" class="form-control form-control-sm js-saida-valor-minuto" readonly>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-2">
                                <div class="text-muted js-saida-calculo-text">--</div>
                                <div class="d-flex align-items-center mt-2 mt-md-0">
                                    <button type="button" class="btn btn-sm btn-primary js-saida-adicionar-servico">Adicionar</button>
                                </div>
                            </div>
                            <div class="text-danger small mt-2 js-saida-calculo-erro d-none"></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group mt-3">
                        <label for="modalReservaSaida-servico">Buscar Serviço</label>
                        <select class="form-control select2 js-saida-servico" name="servico_id" id="modalReservaSaida-servico" data-placeholder="Selecione um serviço">
                            <option value="">Selecione um serviço</option>
                            <?php foreach (($servicosAtivos ?? []) as $servico) : ?>
                                <option value="<?= esc($servico['id'], 'attr'); ?>">
                                    <?= esc($servico['nome']); ?> - R$ <?= number_format((float) $servico['valor'], 2, ',', '.'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (!empty($usarCalculoUsoEspaco)) : ?>
                        <small class="form-text text-muted">Opcional: use a calculadora acima para calcular “Uso do Espaço”.</small>
                        <?php endif; ?>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0 js-saida-tabela-servicos">
                            <thead>
                                <tr>
                                    <th>Serviço</th>
                                    <th class="text-right">Valor</th>
                                    <th style="width: 140px;">Quantidade</th>
                                    <th class="text-right">Total</th>
                                    <th style="width: 70px;" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="js-saida-empty-row">
                                    <td colspan="5" class="text-center text-muted">Nenhum serviço selecionado.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <strong>Total Serviços: <span class="js-saida-total-servicos">R$ 0,00</span></strong>
                    </div>
                    <?php if (false) : // PRODUTOS_DESATIVADOS ?>
                    <div class="form-group mt-3">
                        <label for="modalReservaSaida-produto">Buscar Produto</label>
                        <select class="form-control select2 js-saida-produto" name="produto_id" id="modalReservaSaida-produto" data-placeholder="Selecione um produto">
                            <option value="">Selecione um produto</option>
                            <?php foreach (($produtosAtivos ?? []) as $produto) : ?>
                                <option value="<?= esc($produto['id'], 'attr'); ?>">
                                    <?= esc($produto['nome']); ?> - R$ <?= number_format((float) $produto['valor'], 2, ',', '.'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0 js-saida-tabela-produtos">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th class="text-right">Valor</th>
                                    <th style="width: 140px;">Quantidade</th>
                                    <th class="text-right">Total</th>
                                    <th style="width: 70px;" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="js-saida-empty-row-produto">
                                    <td colspan="5" class="text-center text-muted">Nenhum produto selecionado.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <strong>Total Produtos: <span class="js-saida-total-produtos">R$ 0,00</span></strong>
                    </div>
                    <?php endif; ?>

                    <div class="form-group mt-3 mb-2">
                        <label for="modalReservaSaida-observacoes">Observações</label>
                        <textarea class="form-control js-saida-observacoes" name="observacoes" id="modalReservaSaida-observacoes" rows="3"></textarea>
                        <small class="form-text text-muted">Obrigatório quando a cobrança não for paga (mínimo 15 caracteres).</small>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input js-saida-pago" id="modalReservaSaida-pago" name="pago" value="1">
                        <label class="form-check-label" for="modalReservaSaida-pago">Cobrança paga?</label>
                    </div>
                    <div class="d-flex justify-content-end js-saida-total-geral-wrapper d-none">
                        <strong>Total: <span class="js-saida-total-geral">R$ 0,00</span></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-info" type="submit">Salvar Saída</button>
                    <button class="btn ripple btn-secondary js-saida-cancelar" data-dismiss="modal" type="button">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReservaConsumo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <form method="post" action="">
                <div class="modal-header">
                    <h6 class="modal-title">Adicionar Consumo</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Reserva de <strong class="js-consumo-participante"></strong></p>
                    <input type="hidden" name="reserva_id" value="">
                    <div class="form-group">
                        <label for="modalReservaConsumo-servico">Buscar Serviço</label>
                        <select class="form-control select2 js-consumo-servico" name="servico_id" id="modalReservaConsumo-servico" data-placeholder="Selecione um serviço">
                            <option value="">Selecione um serviço</option>
                            <?php foreach (($servicosAtivos ?? []) as $servico) : ?>
                                <option value="<?= esc($servico['id'], 'attr'); ?>">
                                    <?= esc($servico['nome']); ?> - R$ <?= number_format((float) $servico['valor'], 2, ',', '.'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0 js-tabela-servicos">
                            <thead>
                                <tr>
                                    <th>Serviço</th>
                                    <th class="text-right">Valor</th>
                                    <th style="width: 140px;">Quantidade</th>
                                    <th class="text-right">Total</th>
                                    <th style="width: 70px;" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="js-empty-row">
                                    <td colspan="5" class="text-center text-muted">Nenhum serviço selecionado.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php if (false) : // PRODUTOS_DESATIVADOS ?>
                    <div class="form-group mt-3">
                        <label for="modalReservaConsumo-produto">Buscar Produto</label>
                        <select class="form-control select2 js-consumo-produto" name="produto_id" id="modalReservaConsumo-produto" data-placeholder="Selecione um produto">
                            <option value="">Selecione um produto</option>
                            <?php foreach (($produtosAtivos ?? []) as $produto) : ?>
                                <option value="<?= esc($produto['id'], 'attr'); ?>">
                                    <?= esc($produto['nome']); ?> - R$ <?= number_format((float) $produto['valor'], 2, ',', '.'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0 js-tabela-produtos">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th class="text-right">Valor</th>
                                    <th style="width: 140px;">Quantidade</th>
                                    <th class="text-right">Total</th>
                                    <th style="width: 70px;" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="js-empty-row-produto">
                                    <td colspan="5" class="text-center text-muted">Nenhum produto selecionado.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-end mt-2">
                        <strong>Total: <span class="js-consumo-total">R$ 0,00</span></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="submit">Salvar</button>
                    <button class="btn ripple btn-secondary js-consumo-cancelar" data-dismiss="modal" type="button">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script>
    (function($) {
        'use strict';

        if (!$) {
            return;
        }

        var servicosAtivos = <?= json_encode($servicosAtivos ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
        if (!Array.isArray(servicosAtivos)) {
            servicosAtivos = [];
        }
        // PRODUTOS_DESATIVADOS
        var produtosAtivos = [];
        /*
        var produtosAtivos = <?= json_encode($produtosAtivos ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
        if (!Array.isArray(produtosAtivos)) {
            produtosAtivos = [];
        }
        */
        var usarCalculoUsoEspaco = <?= json_encode(!empty($usarCalculoUsoEspaco)); ?>;
        var SERVICO_USO_ESPACO_ID = Number(<?= json_encode($servicoUsoEspacoId ?? 1); ?>) || 1;
        var servicoPorId = {};
        servicosAtivos.forEach(function(servico) {
            if (servico && typeof servico.id !== 'undefined') {
                servicoPorId[Number(servico.id)] = servico;
            }
        });
        // PRODUTOS_DESATIVADOS
        var produtoPorId = {};
        /*
        produtosAtivos.forEach(function(produto) {
            if (produto && typeof produto.id !== 'undefined') {
                produtoPorId[Number(produto.id)] = produto;
            }
        });
        */

        function obterServicoPorId(id) {
            var chave = Number(id);
            return servicoPorId.hasOwnProperty(chave) ? servicoPorId[chave] : null;
        }

        // PRODUTOS_DESATIVADOS
        function obterProdutoPorId(id) {
            return null;
        }

        var modalId = 'modalReservaHorario';
        var modalTemplate = ($('#horario-modal-template').html() || '').split('{modalId}').join(modalId);

        if (!$('#' + modalId).length) {
            $('body').append(modalTemplate);
        }

        var $modal = $('#' + modalId);
        var $form = $modal.find('form');
        var $inputHora = $modal.find('input[name="hora"]');
        var $title = $modal.find('.modal-title');
        var $submit = $form.find('button[type="submit"]');

        function getCurrentTime() {
            var now = new Date();
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');
            return hours + ':' + minutes;
        }

        function prepareModal(config) {
            $form.attr('action', config.action);
            $title.text(config.title);
            $submit.text(config.submitText);
            $submit.removeClass('btn-success btn-info').addClass(config.submitClass);
            $inputHora.val(getCurrentTime());
            $modal.modal('show');
        }

        var consumoModalId = 'modalReservaConsumo';
        var $consumoModal = $('#' + consumoModalId);
        var $consumoForm = $consumoModal.find('form');
        var $consumoReserva = $consumoForm.find('input[name="reserva_id"]');
        var $consumoParticipante = $consumoModal.find('.js-consumo-participante');
        var $consumoTabela = $consumoModal.find('.js-tabela-servicos');
        var $consumoTabelaProdutos = $consumoModal.find('.js-tabela-produtos');
        var $consumoTotal = $consumoModal.find('.js-consumo-total');
        var $consumoServico = $consumoModal.find('.js-consumo-servico');
        var $consumoProduto = $consumoModal.find('.js-consumo-produto');
        var $consumoSubmit = $consumoForm.find('button[type="submit"]');
        var listarServicosUrl = '<?= base_url('Reserva/litarServicosReserva'); ?>';
        var definirServicosUrl = '<?= base_url('Reserva/definirServicosReserva'); ?>';
        var definirSaidaUrl = '<?= base_url('Reserva/definirSaida'); ?>';
        var consumoSelecionados = [];
        var consumoProdutosSelecionados = [];
        var reservaCarregadaId = null;
        var saidaModalId = 'modalReservaSaida';
        var $saidaModal = $('#' + saidaModalId);
        var $saidaForm = $saidaModal.find('form');
        var $saidaReserva = $saidaForm.find('input[name="reserva_id"]');
        var $saidaParticipante = $saidaModal.find('.js-saida-participante');
        var $saidaHoraEntrada = $saidaModal.find('.js-saida-hora-entrada');
        var $saidaHoraSaida = $saidaForm.find('input[name="hora"]');
        var $saidaPessoas = $saidaModal.find('.js-saida-pessoas');
        var $saidaMinutos = $saidaModal.find('.js-saida-minutos');
        var $saidaQuantidade = $saidaModal.find('.js-saida-quantidade');
        var $saidaValorMinuto = $saidaModal.find('.js-saida-valor-minuto');
        var $saidaCalculoText = $saidaModal.find('.js-saida-calculo-text');
        var $saidaCalculoErro = $saidaModal.find('.js-saida-calculo-erro');
        var $saidaTotalUso = $saidaModal.find('.js-saida-total-uso');
        var $saidaTabela = $saidaModal.find('.js-saida-tabela-servicos');
        var $saidaTabelaProdutos = $saidaModal.find('.js-saida-tabela-produtos');
        var $saidaTotalServicos = $saidaModal.find('.js-saida-total-servicos');
        var $saidaTotalProdutos = $saidaModal.find('.js-saida-total-produtos');
        var $saidaTotalGeral = $saidaModal.find('.js-saida-total-geral');
        var $saidaTotalGeralWrapper = $saidaModal.find('.js-saida-total-geral-wrapper');
        var $saidaServico = $saidaModal.find('.js-saida-servico');
        var $saidaProduto = $saidaModal.find('.js-saida-produto');
        var $saidaObservacoes = $saidaModal.find('.js-saida-observacoes');
        var $saidaPago = $saidaModal.find('.js-saida-pago');
        var $saidaSubmit = $saidaForm.find('button[type="submit"]');
        var saidaServicosSelecionados = [];
        var saidaProdutosSelecionados = [];
        var saidaReservaCarregadaId = null;
        var saidaPessoasTotal = 0;
        var saidaHoraEntradaRaw = '';
        var saidaCalculoAtual = { minutos: 0, quantidade: 0, total: 0, valido: false };

        function formatarValor(valor) {
            var numero = Number(valor);
            if (!isFinite(numero)) {
                numero = 0;
            }
            return numero.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        }

        function escaparHtml(texto) {
            return $('<div>').text(texto || '').html();
        }

        function initSelect2InsideModal($select, $modal, namespace, placeholder) {
            if (!$.fn.select2 || !$select.length) {
                return;
            }
            if ($select.hasClass('select2-hidden-accessible')) {
                $select.select2('destroy');
            }
            $select.select2({
                dropdownParent: $modal,
                placeholder: placeholder || 'Selecione um serviço',
                allowClear: true,
                width: '100%'
            });

            var ns = (namespace || 'default').replace('.', '');
            $select.off('select2:open.' + ns).on('select2:open.' + ns, function() {
                var focarPesquisa = function() {
                    var $campoPesquisa = $modal.find('.select2-container--open .select2-search__field');
                    if ($campoPesquisa.length) {
                        $campoPesquisa.get(0).focus();
                    }
                };
                focarPesquisa();
                setTimeout(focarPesquisa, 0);
            });
        }

        function resetarSelectConsumo() {
            if (!$consumoServico.length) {
                return;
            }
            $consumoServico.val('');
            if ($.fn.select2 && $consumoServico.hasClass('select2-hidden-accessible')) {
                $consumoServico.trigger('change.select2');
            }
        }

        function resetarSelectConsumoProduto() {
            if (!$consumoProduto.length) {
                return;
            }
            $consumoProduto.val('');
            if ($.fn.select2 && $consumoProduto.hasClass('select2-hidden-accessible')) {
                $consumoProduto.trigger('change.select2');
            }
        }

        function atualizarTotalConsumo() {
            var totalServicos = consumoSelecionados.reduce(function(acumulado, item) {
                var quantidade = Number(item.quantidade) || 0;
                var valor = Number(item.valor) || 0;
                return acumulado + (quantidade * valor);
            }, 0);
            var totalProdutos = consumoProdutosSelecionados.reduce(function(acumulado, item) {
                var quantidade = Number(item.quantidade) || 0;
                var valor = Number(item.valor) || 0;
                return acumulado + (quantidade * valor);
            }, 0);
            $consumoTotal.text(formatarValor(totalServicos + totalProdutos));
        }

        function renderTabela() {
            var $tbody = $consumoTabela.find('tbody');
            $tbody.empty();

            if (!consumoSelecionados.length) {
                $tbody.append('<tr class="js-empty-row"><td colspan="5" class="text-center text-muted">Nenhum serviço selecionado.</td></tr>');
                atualizarTotalConsumo();
                return;
            }

            consumoSelecionados.forEach(function(item) {
                var quantidade = Number(item.quantidade) || 0;
                var total = quantidade * (Number(item.valor) || 0);
                var unidade = (item.unidade || '').toString().trim();
                var textoUnidade = '';
                if (unidade) {
                    textoUnidade = unidade.toLowerCase().indexOf('por ') === 0 ? unidade : ('Por ' + unidade);
                }
                var linha = '' +
                    '<tr data-id="' + item.id + '">' +
                    '  <td>' + escaparHtml(item.nome) + '</td>' +
                    '  <td class="text-right">' +
                    '    <div>' + formatarValor(item.valor) + '</div>' +
                    (textoUnidade ? ('    <small class="form-text text-muted">' + escaparHtml(textoUnidade) + '</small>') : '') +
                    '  </td>' +
                    '  <td style="width: 140px;">' +
                    '    <input type="number" min="0" step="1" class="form-control form-control-sm js-servico-qtde" data-id="' + item.id + '" value="' + quantidade + '">' +
                    '  </td>' +
                    '  <td class="text-right js-servico-total">' + formatarValor(total) + '</td>' +
                    '  <td class="text-center">' +
                    '    <button type="button" class="btn btn-danger btn-sm js-remover-servico" data-id="' + item.id + '" title="Excluir" aria-label="Excluir">' +
                    '      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">' +
                    '        <title>Excluir</title>' +
                    '        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>' +
                    '        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>' +
                    '      </svg>' +
                    '    </button>' +
                    '  </td>' +
                    '</tr>';
                $tbody.append(linha);
            });
            atualizarTotalConsumo();
        }

        function renderTabelaProdutos() {
            var $tbody = $consumoTabelaProdutos.find('tbody');
            $tbody.empty();

            if (!consumoProdutosSelecionados.length) {
                $tbody.append('<tr class="js-empty-row-produto"><td colspan="5" class="text-center text-muted">Nenhum produto selecionado.</td></tr>');
                atualizarTotalConsumo();
                return;
            }

            consumoProdutosSelecionados.forEach(function(item) {
                var quantidade = Number(item.quantidade) || 0;
                var total = quantidade * (Number(item.valor) || 0);
                var linha = '' +
                    '<tr data-id="' + item.id + '">' +
                    '  <td>' + escaparHtml(item.nome) + '</td>' +
                    '  <td class="text-right">' +
                    '    <div>' + formatarValor(item.valor) + '</div>' +
                    '  </td>' +
                    '  <td style="width: 140px;">' +
                    '    <input type="number" min="0" step="1" class="form-control form-control-sm js-produto-qtde" data-id="' + item.id + '" value="' + quantidade + '">' +
                    '  </td>' +
                    '  <td class="text-right js-produto-total">' + formatarValor(total) + '</td>' +
                    '  <td class="text-center">' +
                    '    <button type="button" class="btn btn-danger btn-sm js-remover-produto" data-id="' + item.id + '" title="Excluir" aria-label="Excluir">' +
                    '      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">' +
                    '        <title>Excluir</title>' +
                    '        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>' +
                    '        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>' +
                    '      </svg>' +
                    '    </button>' +
                    '  </td>' +
                    '</tr>';
                $tbody.append(linha);
            });
            atualizarTotalConsumo();
        }

        function focusQuantidade(id) {
            var $campo = $consumoTabela.find('.js-servico-qtde[data-id="' + id + '"]');
            if ($campo.length) {
                $campo.trigger('focus');
            }
        }

        function focusQuantidadeProduto(id) {
            var $campo = $consumoTabelaProdutos.find('.js-produto-qtde[data-id="' + id + '"]');
            if ($campo.length) {
                $campo.trigger('focus');
            }
        }

        function adicionarServico(servicoId) {
            if (!servicoId) {
                return;
            }

            var servico = servicosAtivos.find(function(item) {
                return Number(item.id) === Number(servicoId);
            });

            if (!servico) {
                return;
            }

            var existente = consumoSelecionados.find(function(item) {
                return Number(item.id) === Number(servico.id);
            });

            if (existente) {
                focusQuantidade(servico.id);
                return;
            }

            consumoSelecionados.push({
                id: servico.id,
                nome: servico.nome,
                valor: Number(servico.valor) || 0,
                unidade: servico.unidade || '',
                quantidade: 0
            });
            renderTabela();
            focusQuantidade(servico.id);
        }

        function adicionarProduto(produtoId) {
            if (!produtoId) {
                return;
            }

            var produto = produtosAtivos.find(function(item) {
                return Number(item.id) === Number(produtoId);
            });

            if (!produto) {
                return;
            }

            var existente = consumoProdutosSelecionados.find(function(item) {
                return Number(item.id) === Number(produto.id);
            });

            if (existente) {
                focusQuantidadeProduto(produto.id);
                return;
            }

            consumoProdutosSelecionados.push({
                id: produto.id,
                nome: produto.nome,
                valor: Number(produto.valor) || 0,
                quantidade: 0
            });
            renderTabelaProdutos();
            focusQuantidadeProduto(produto.id);
        }

        function resetConsumoModal() {
            consumoSelecionados = [];
            consumoProdutosSelecionados = [];
            $consumoReserva.val('');
            $consumoParticipante.text('');
            resetarSelectConsumo();
            resetarSelectConsumoProduto();
            renderTabela();
            renderTabelaProdutos();
        }

        function carregarServicosReserva(reservaId) {
            reservaCarregadaId = Number(reservaId) || null;
            if (!reservaCarregadaId) {
                return Promise.resolve();
            }

            var $tbody = $consumoTabela.find('tbody');
            var $tbodyProdutos = $consumoTabelaProdutos.find('tbody');
            $tbody.html('<tr><td colspan="5" class="text-center text-muted">Carregando serviços...</td></tr>');
            $tbodyProdutos.html('<tr><td colspan="5" class="text-center text-muted">Carregando produtos...</td></tr>');
            $consumoTotal.text('R$ 0,00');

            return fetch(listarServicosUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify({ reserva_id: reservaCarregadaId })
            }).then(function(response) {
                return response.json();
            }).then(function(data) {
                if (!data || data.erro) {
                    throw new Error((data && data.msg) ? data.msg : 'Não foi possível carregar os serviços.');
                }

                if (Number($consumoReserva.val()) !== reservaCarregadaId) {
                    return;
                }

                var servicos = Array.isArray(data.servicos) ? data.servicos : [];
                consumoSelecionados = servicos.map(function(item) {
                    return {
                        id: Number(item.id) || Number(item.servico_id) || 0,
                        nome: item.nome || '',
                        valor: Number(item.valorUnitario) || 0,
                        unidade: item.unidade || '',
                        quantidade: Number(item.quantidade) || 0
                    };
                }).filter(function(item) {
                    return item.id > 0;
                });

                var produtos = Array.isArray(data.produtos) ? data.produtos : [];
                consumoProdutosSelecionados = produtos.map(function(item) {
                    return {
                        id: Number(item.id) || Number(item.produto_id) || 0,
                        nome: item.nome || '',
                        valor: Number(item.valorUnitario) || 0,
                        quantidade: Number(item.quantidade) || 0
                    };
                }).filter(function(item) {
                    return item.id > 0;
                });

                renderTabela();
                renderTabelaProdutos();
            }).catch(function(error) {
                alert(error && error.message ? error.message : 'Erro ao carregar serviços.');
                consumoSelecionados = [];
                consumoProdutosSelecionados = [];
                renderTabela();
                renderTabelaProdutos();
            });
        }

        function resetarSelectSaida() {
            if (!$saidaServico.length) {
                return;
            }
            $saidaServico.val('');
            if ($.fn.select2 && $saidaServico.hasClass('select2-hidden-accessible')) {
                $saidaServico.trigger('change.select2');
            }
        }

        function resetarSelectSaidaProduto() {
            if (!$saidaProduto.length) {
                return;
            }
            $saidaProduto.val('');
            if ($.fn.select2 && $saidaProduto.hasClass('select2-hidden-accessible')) {
                $saidaProduto.trigger('change.select2');
            }
        }

        function limparErroCalculoSaida() {
            $saidaCalculoErro.addClass('d-none').text('');
        }

        function exibirErroCalculoSaida(msg) {
            $saidaCalculoErro.removeClass('d-none').text(msg || 'Não foi possível calcular o uso do espaço.');
        }

        function formatarHoraDisplay(dataHoraStr) {
            if (!dataHoraStr) {
                return '';
            }
            if (/^\d{2}:\d{2}/.test(dataHoraStr)) {
                return dataHoraStr.substring(0, 5);
            }
            var partes = dataHoraStr.replace('T', ' ').split(' ');
            if (partes.length > 1 && partes[1]) {
                return partes[1].substring(0, 5);
            }
            return '';
        }

        function calcularDiferencaSaida(horaEntradaCompleta, horaSaidaHoraMinuto) {
            var entradaBruta = (horaEntradaCompleta || '').trim();
            var saidaStr = (horaSaidaHoraMinuto || '').trim();
            if (entradaBruta === '' || saidaStr === '') {
                return { minutos: 0, valido: false };
            }
            var partesEntrada = entradaBruta.replace('T', ' ').split(' ');
            var dataEntrada = partesEntrada[0] || '';
            var horaEntrada = (partesEntrada[1] || '').substring(0, 5);
            if (!dataEntrada) {
                var agora = new Date();
                dataEntrada = agora.toISOString().slice(0, 10);
            }
            var entrada = new Date(dataEntrada + 'T' + horaEntrada + ':00');
            var saida = new Date(dataEntrada + 'T' + saidaStr + ':00');
            if (isNaN(entrada.getTime()) || isNaN(saida.getTime())) {
                return { minutos: 0, valido: false };
            }
            var diff = (saida.getTime() - entrada.getTime()) / 60000;
            return { minutos: Math.max(0, Math.round(diff)), valido: diff > 0 };
        }

        function atualizarCalculoSaida() {
            if (!usarCalculoUsoEspaco) {
                saidaCalculoAtual = { minutos: 0, quantidade: 0, total: 0, valido: false };
                return saidaCalculoAtual;
            }

            var horaSaidaStr = ($saidaHoraSaida.val() || '').trim();
            var servicoUso = obterServicoPorId(SERVICO_USO_ESPACO_ID);
            var valorMinuto = servicoUso ? (Number(servicoUso.valor) || 0) : 0;
            var nomeServicoUso = servicoUso && servicoUso.nome ? servicoUso.nome : 'Uso do Espaço';
            var resultado = calcularDiferencaSaida(saidaHoraEntradaRaw, horaSaidaStr);
            var pessoasInformadas = Number($saidaPessoas.val()) || 0;
            pessoasInformadas = Math.max(1, pessoasInformadas);
            saidaPessoasTotal = pessoasInformadas;
            var quantidadeCalculada = resultado.minutos * pessoasInformadas;
            var totalCalculado = quantidadeCalculada * valorMinuto;

            saidaCalculoAtual = {
                minutos: resultado.minutos,
                quantidade: quantidadeCalculada,
                total: totalCalculado,
                valido: resultado.valido && quantidadeCalculada > 0 && valorMinuto > 0
            };

            $saidaMinutos.val(resultado.minutos > 0 ? resultado.minutos + ' min' : '0');
            $saidaQuantidade.val(quantidadeCalculada > 0 ? quantidadeCalculada : 0);
            $saidaValorMinuto.val(formatarValor(valorMinuto));
            $saidaTotalUso.text(formatarValor(totalCalculado));
            $saidaCalculoText.text((pessoasInformadas || 0) + ' pessoa(s) x ' + resultado.minutos + ' min x ' + formatarValor(valorMinuto) + ' = ' + formatarValor(totalCalculado));

            if (!resultado.valido) {
                exibirErroCalculoSaida('Hora de saída deve ser posterior à entrada.');
            } else if (!servicoUso) {
                exibirErroCalculoSaida('Serviço "' + nomeServicoUso + '" (ID ' + SERVICO_USO_ESPACO_ID + ') não encontrado.');
                saidaCalculoAtual.valido = false;
            } else if (valorMinuto <= 0) {
                exibirErroCalculoSaida('Defina um valor para o serviço "' + nomeServicoUso + '".');
                saidaCalculoAtual.valido = false;
            } else {
                limparErroCalculoSaida();
            }

            return saidaCalculoAtual;
        }

        function atualizarTotalSaida() {
            var totalServicos = saidaServicosSelecionados.reduce(function(acumulado, item) {
                var quantidade = Number(item.quantidade) || 0;
                var valor = Number(item.valor) || 0;
                return acumulado + (quantidade * valor);
            }, 0);
            var totalProdutos = saidaProdutosSelecionados.reduce(function(acumulado, item) {
                var quantidade = Number(item.quantidade) || 0;
                var valor = Number(item.valor) || 0;
                return acumulado + (quantidade * valor);
            }, 0);
            if (usarCalculoUsoEspaco) {
                var usoItem = saidaServicosSelecionados.find(function(item) {
                    return Number(item.id) === SERVICO_USO_ESPACO_ID;
                });
                if (usoItem) {
                    var usoTotal = (Number(usoItem.quantidade) || 0) * (Number(usoItem.valor) || 0);
                    $saidaTotalUso.text(formatarValor(usoTotal));
                }
            }
            var total = totalServicos + totalProdutos;
            $saidaTotalServicos.text(formatarValor(totalServicos));
            $saidaTotalProdutos.text(formatarValor(totalProdutos));
            $saidaTotalGeral.text(formatarValor(total));
            if ($saidaTotalGeralWrapper.length) {
                var temItens = saidaServicosSelecionados.length > 0 || saidaProdutosSelecionados.length > 0;
                $saidaTotalGeralWrapper.toggleClass('d-none', !temItens);
            }
        }

        function renderTabelaSaida() {
            var $tbody = $saidaTabela.find('tbody');
            $tbody.empty();

            if (!saidaServicosSelecionados.length) {
                $tbody.append('<tr class="js-saida-empty-row"><td colspan="5" class="text-center text-muted">Nenhum serviço selecionado.</td></tr>');
                atualizarTotalSaida();
                return;
            }

            saidaServicosSelecionados.forEach(function(item) {
                var quantidade = Number(item.quantidade) || 0;
                var total = quantidade * (Number(item.valor) || 0);
                var unidade = (item.unidade || '').toString().trim();
                var textoUnidade = '';
                if (unidade) {
                    textoUnidade = unidade.toLowerCase().indexOf('por ') === 0 ? unidade : ('Por ' + unidade);
                }
                var campoQuantidade = '<input type="number" min="0" step="1" class="form-control form-control-sm js-saida-servico-qtde" data-id="' + item.id + '" value="' + quantidade + '">';
                var acoes = '<button type="button" class="btn btn-danger btn-sm js-saida-remover-servico" data-id="' + item.id + '" title="Excluir" aria-label="Excluir">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">' +
                    '<title>Excluir</title>' +
                    '<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>' +
                    '<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>' +
                    '</svg>' +
                    '</button>';

                var linha = '' +
                    '<tr data-id="' + item.id + '">' +
                    '  <td>' + escaparHtml(item.nome) + '</td>' +
                    '  <td class="text-right">' +
                    '    <div>' + formatarValor(item.valor) + '</div>' +
                    (textoUnidade ? ('    <small class="form-text text-muted">' + escaparHtml(textoUnidade) + '</small>') : '') +
                    '  </td>' +
                    '  <td style="width: 140px;">' + campoQuantidade + '</td>' +
                    '  <td class="text-right js-saida-servico-total">' + formatarValor(total) + '</td>' +
                    '  <td class="text-center">' + acoes + '</td>' +
                    '</tr>';
                $tbody.append(linha);
            });
            atualizarTotalSaida();
        }

        function renderTabelaSaidaProdutos() {
            var $tbody = $saidaTabelaProdutos.find('tbody');
            $tbody.empty();

            if (!saidaProdutosSelecionados.length) {
                $tbody.append('<tr class="js-saida-empty-row-produto"><td colspan="5" class="text-center text-muted">Nenhum produto selecionado.</td></tr>');
                atualizarTotalSaida();
                return;
            }

            saidaProdutosSelecionados.forEach(function(item) {
                var quantidade = Number(item.quantidade) || 0;
                var total = quantidade * (Number(item.valor) || 0);
                var campoQuantidade = '<input type="number" min="0" step="1" class="form-control form-control-sm js-saida-produto-qtde" data-id="' + item.id + '" value="' + quantidade + '">';
                var acoes = '<button type="button" class="btn btn-danger btn-sm js-saida-remover-produto" data-id="' + item.id + '" title="Excluir" aria-label="Excluir">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">' +
                    '<title>Excluir</title>' +
                    '<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>' +
                    '<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>' +
                    '</svg>' +
                    '</button>';

                var linha = '' +
                    '<tr data-id="' + item.id + '">' +
                    '  <td>' + escaparHtml(item.nome) + '</td>' +
                    '  <td class="text-right">' +
                    '    <div>' + formatarValor(item.valor) + '</div>' +
                    '  </td>' +
                    '  <td style="width: 140px;">' + campoQuantidade + '</td>' +
                    '  <td class="text-right js-saida-produto-total">' + formatarValor(total) + '</td>' +
                    '  <td class="text-center">' + acoes + '</td>' +
                    '</tr>';
                $tbody.append(linha);
            });
            atualizarTotalSaida();
        }

        function focusSaidaQuantidade(id) {
            var $campo = $saidaTabela.find('.js-saida-servico-qtde[data-id="' + id + '"]');
            if ($campo.length) {
                $campo.trigger('focus');
            }
        }

        function focusSaidaQuantidadeProduto(id) {
            var $campo = $saidaTabelaProdutos.find('.js-saida-produto-qtde[data-id="' + id + '"]');
            if ($campo.length) {
                $campo.trigger('focus');
            }
        }

        function adicionarServicoSaida(servicoId) {
            if (!servicoId) {
                return;
            }

            var servico = obterServicoPorId(servicoId);
            if (!servico) {
                resetarSelectSaida();
                return;
            }

            var existente = saidaServicosSelecionados.find(function(item) {
                return Number(item.id) === Number(servico.id);
            });

            if (existente) {
                focusSaidaQuantidade(servico.id);
                resetarSelectSaida();
                return;
            }

            saidaServicosSelecionados.push({
                id: servico.id,
                nome: servico.nome,
                valor: Number(servico.valor) || 0,
                unidade: servico.unidade || '',
                quantidade: 0
            });
            renderTabelaSaida();
            focusSaidaQuantidade(servico.id);
            resetarSelectSaida();
        }

        function adicionarProdutoSaida(produtoId) {
            if (!produtoId) {
                return;
            }

            var produto = obterProdutoPorId(produtoId);
            if (!produto) {
                resetarSelectSaidaProduto();
                return;
            }

            var existente = saidaProdutosSelecionados.find(function(item) {
                return Number(item.id) === Number(produto.id);
            });

            if (existente) {
                focusSaidaQuantidadeProduto(produto.id);
                resetarSelectSaidaProduto();
                return;
            }

            saidaProdutosSelecionados.push({
                id: produto.id,
                nome: produto.nome,
                valor: Number(produto.valor) || 0,
                quantidade: 0
            });
            renderTabelaSaidaProdutos();
            focusSaidaQuantidadeProduto(produto.id);
            resetarSelectSaidaProduto();
        }

        function adicionarUsoDoEspacoNaLista() {
            if (!usarCalculoUsoEspaco) {
                return;
            }

            var servico = obterServicoPorId(SERVICO_USO_ESPACO_ID);
            var nomeServicoUso = servico && servico.nome ? servico.nome : 'Uso do Espaço';
            var calculo = atualizarCalculoSaida();

            if (!servico) {
                exibirErroCalculoSaida('Serviço "' + nomeServicoUso + '" (ID ' + SERVICO_USO_ESPACO_ID + ') não encontrado na lista de serviços ativos.');
                return;
            }

            if (!calculo.valido) {
                exibirErroCalculoSaida('Informe uma hora de saída válida para calcular o uso do espaço.');
                return;
            }

            var existente = saidaServicosSelecionados.find(function(item) {
                return Number(item.id) === Number(servico.id);
            });

            if (existente) {
                existente.quantidade = calculo.quantidade;
                existente.valor = Number(servico.valor) || 0;
                existente.unidade = servico.unidade || '';
            } else {
                saidaServicosSelecionados.push({
                    id: servico.id,
                    nome: servico.nome,
                    valor: Number(servico.valor) || 0,
                    unidade: servico.unidade || '',
                    quantidade: calculo.quantidade
                });
            }

            limparErroCalculoSaida();
            renderTabelaSaida();
        }

        function resetSaidaModal() {
            saidaServicosSelecionados = [];
            saidaProdutosSelecionados = [];
            saidaReservaCarregadaId = null;
            saidaPessoasTotal = 0;
            saidaHoraEntradaRaw = '';
            saidaCalculoAtual = { minutos: 0, quantidade: 0, total: 0, valido: false };

            $saidaReserva.val('');
            $saidaParticipante.text('');
            $saidaHoraEntrada.text('--:--').data('raw', '');
            $saidaHoraSaida.val('');
            $saidaPessoas.val('').data('pessoas', 0);
            $saidaObservacoes.val('');
            $saidaPago.prop('checked', false);
            resetarSelectSaida();
            resetarSelectSaidaProduto();
            renderTabelaSaida();
            renderTabelaSaidaProdutos();
            limparErroCalculoSaida();
            $saidaMinutos.val('');
            $saidaQuantidade.val('');
            $saidaValorMinuto.val('');
            $saidaTotalUso.text('R$ 0,00');
            $saidaTotalServicos.text('R$ 0,00');
            $saidaTotalProdutos.text('R$ 0,00');
            $saidaTotalGeral.text('R$ 0,00');
            $saidaTotalGeralWrapper.addClass('d-none');
            $saidaCalculoText.text('--');
        }

        function carregarServicosSaida(reservaId) {
            saidaReservaCarregadaId = Number(reservaId) || null;
            if (!saidaReservaCarregadaId) {
                return Promise.resolve();
            }

            var $tbody = $saidaTabela.find('tbody');
            var $tbodyProdutos = $saidaTabelaProdutos.find('tbody');
            $tbody.html('<tr><td colspan="5" class="text-center text-muted">Carregando serviços...</td></tr>');
            $tbodyProdutos.html('<tr><td colspan="5" class="text-center text-muted">Carregando produtos...</td></tr>');
            $saidaTotalServicos.text('R$ 0,00');
            $saidaTotalProdutos.text('R$ 0,00');
            $saidaTotalGeral.text('R$ 0,00');
            $saidaTotalGeralWrapper.addClass('d-none');

            return fetch(listarServicosUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify({ reserva_id: saidaReservaCarregadaId })
            }).then(function(response) {
                return response.json();
            }).then(function(data) {
                if (!data || data.erro) {
                    throw new Error((data && data.msg) ? data.msg : 'Não foi possível carregar os serviços.');
                }

                if (Number($saidaReserva.val()) !== saidaReservaCarregadaId) {
                    return;
                }

                var servicos = Array.isArray(data.servicos) ? data.servicos : [];
                saidaServicosSelecionados = servicos.map(function(item) {
                    return {
                        id: Number(item.id) || Number(item.servico_id) || 0,
                        nome: item.nome || '',
                        valor: Number(item.valorUnitario) || 0,
                        unidade: item.unidade || '',
                        quantidade: Number(item.quantidade) || 0
                    };
                }).filter(function(item) {
                    return item.id > 0;
                });

                var produtos = Array.isArray(data.produtos) ? data.produtos : [];
                saidaProdutosSelecionados = produtos.map(function(item) {
                    return {
                        id: Number(item.id) || Number(item.produto_id) || 0,
                        nome: item.nome || '',
                        valor: Number(item.valorUnitario) || 0,
                        quantidade: Number(item.quantidade) || 0
                    };
                }).filter(function(item) {
                    return item.id > 0;
                });

                renderTabelaSaida();
                renderTabelaSaidaProdutos();
            }).catch(function(error) {
                alert(error && error.message ? error.message : 'Erro ao carregar serviços.');
                saidaServicosSelecionados = [];
                saidaProdutosSelecionados = [];
                renderTabelaSaida();
                renderTabelaSaidaProdutos();
            }).finally(function() {
                if (usarCalculoUsoEspaco) {
                    // Recalcula o uso do espaço após carregar/limpar a lista, garantindo exibição imediata.
                    atualizarCalculoSaida();
                }
            });
        }

        function coletarServicosPayloadSaida() {
            return saidaServicosSelecionados.map(function(item) {
                var quantidade = Number($saidaTabela.find('.js-saida-servico-qtde[data-id="' + item.id + '"]').val());
                quantidade = isFinite(quantidade) ? quantidade : 0;
                return {
                    id: item.id,
                    quantidade: quantidade
                };
            });
        }

        function coletarProdutosPayloadSaida() {
            return saidaProdutosSelecionados.map(function(item) {
                var quantidade = Number($saidaTabelaProdutos.find('.js-saida-produto-qtde[data-id="' + item.id + '"]').val());
                quantidade = isFinite(quantidade) ? quantidade : 0;
                return {
                    id: item.id,
                    quantidade: quantidade
                };
            });
        }

        function validarObservacoesSaida(pago, observacoes) {
            var texto = (observacoes || '').trim();
            if (!pago) {
                var semEspacos = texto.replace(/\s+/g, '');
                if (semEspacos.length < 15) {
                    return {
                        ok: false,
                        mensagem: 'Observações obrigatórias com pelo menos 15 caracteres quando a cobrança não for paga.'
                    };
                }
            }
            return { ok: true, mensagem: '' };
        }

        $(document).on('click', '.btn-add-consumo', function() {
            var id = $(this).data('reserva');
            if (!id) {
                return;
            }
            var participante = $(this).data('participante') || '';
            resetConsumoModal();
            $consumoReserva.val(id);
            $consumoParticipante.text(participante);
            $consumoModal.modal('show');
            carregarServicosReserva(id);
        });

        $consumoModal.on('shown.bs.modal', function() {
            initSelect2InsideModal($consumoServico, $consumoModal, 'consumo-servico', 'Selecione um serviço');
            initSelect2InsideModal($consumoProduto, $consumoModal, 'consumo-produto', 'Selecione um produto');

            if ($.fn.select2 && $consumoServico.hasClass('select2-hidden-accessible')) {
                var $selecao = $consumoModal.find('.select2-container .select2-selection');
                if ($selecao.length) {
                    $selecao.trigger('focus');
                    return;
                }
            }
            $consumoServico.trigger('focus');
        });

        $consumoModal.on('hidden.bs.modal', function() {
            resetConsumoModal();
        });

        $consumoServico.on('change', function() {
            var servicoId = Number($(this).val());
            if (!servicoId) {
                return;
            }
            adicionarServico(servicoId);
            resetarSelectConsumo();
        });

        $consumoProduto.on('change', function() {
            var produtoId = Number($(this).val());
            if (!produtoId) {
                return;
            }
            adicionarProduto(produtoId);
            resetarSelectConsumoProduto();
        });

        $(document).on('click', '.js-remover-servico', function() {
            var servicoId = Number($(this).data('id'));
            consumoSelecionados = consumoSelecionados.filter(function(item) {
                return Number(item.id) !== servicoId;
            });
            renderTabela();
        });

        $(document).on('click', '.js-remover-produto', function() {
            var produtoId = Number($(this).data('id'));
            consumoProdutosSelecionados = consumoProdutosSelecionados.filter(function(item) {
                return Number(item.id) !== produtoId;
            });
            renderTabelaProdutos();
        });

        $(document).on('input', '.js-servico-qtde', function() {
            var servicoId = Number($(this).data('id'));
            var quantidade = parseFloat($(this).val());
            if (!isFinite(quantidade) || quantidade < 0) {
                quantidade = 0;
                $(this).val('0');
            }

            var selecionado = consumoSelecionados.find(function(item) {
                return Number(item.id) === servicoId;
            });

            if (selecionado) {
                selecionado.quantidade = quantidade;
                var total = quantidade * (Number(selecionado.valor) || 0);
                $(this).closest('tr').find('.js-servico-total').text(formatarValor(total));
                atualizarTotalConsumo();
            }
        });

        $(document).on('input', '.js-produto-qtde', function() {
            var produtoId = Number($(this).data('id'));
            var quantidade = parseFloat($(this).val());
            if (!isFinite(quantidade) || quantidade < 0) {
                quantidade = 0;
                $(this).val('0');
            }

            var selecionado = consumoProdutosSelecionados.find(function(item) {
                return Number(item.id) === produtoId;
            });

            if (selecionado) {
                selecionado.quantidade = quantidade;
                var total = quantidade * (Number(selecionado.valor) || 0);
                $(this).closest('tr').find('.js-produto-total').text(formatarValor(total));
                atualizarTotalConsumo();
            }
        });

        $consumoForm.on('submit', function(event) {
            event.preventDefault();

            var reservaId = $consumoReserva.val();
            var payloadServicos = consumoSelecionados.map(function(item) {
                var quantidade = Number($consumoTabela.find('.js-servico-qtde[data-id="' + item.id + '"]').val());
                quantidade = isFinite(quantidade) ? quantidade : 0;

                return {
                    id: item.id,
                    quantidade: quantidade
                };
            });
            var payloadProdutos = consumoProdutosSelecionados.map(function(item) {
                var quantidade = Number($consumoTabelaProdutos.find('.js-produto-qtde[data-id="' + item.id + '"]').val());
                quantidade = isFinite(quantidade) ? quantidade : 0;

                return {
                    id: item.id,
                    quantidade: quantidade
                };
            });

            if (!reservaId) {
                alert('Reserva inválida.');
                return;
            }

            $consumoSubmit.prop('disabled', true);
            fetch(definirServicosUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    reserva_id: Number(reservaId),
                    servicos: payloadServicos,
                    produtos: payloadProdutos
                })
            }).then(function(response) {
                return response.json();
            }).then(function(response) {
                if (response && response.erro === false) {
                    resetConsumoModal();
                    $consumoModal.modal('hide');
                    return;
                }

                var mensagem = response && response.msg ? response.msg : 'Não foi possível salvar o consumo.';
                alert(mensagem);
            }).catch(function() {
                alert('Erro ao enviar os serviços. Tente novamente.');
            }).then(function() {
                $consumoSubmit.prop('disabled', false);
            });
        });

        $(document).on('click', '.js-saida-adicionar-servico', function() {
            adicionarUsoDoEspacoNaLista();
        });

        $saidaServico.on('change', function() {
            var servicoId = Number($(this).val());
            if (!servicoId) {
                return;
            }
            adicionarServicoSaida(servicoId);
        });

        $saidaProduto.on('change', function() {
            var produtoId = Number($(this).val());
            if (!produtoId) {
                return;
            }
            adicionarProdutoSaida(produtoId);
        });

        $(document).on('input', '.js-saida-servico-qtde', function() {
            var servicoId = Number($(this).data('id'));
            var quantidade = parseFloat($(this).val());
            if (!isFinite(quantidade) || quantidade < 0) {
                quantidade = 0;
                $(this).val('0');
            }

            var selecionado = saidaServicosSelecionados.find(function(item) {
                return Number(item.id) === servicoId;
            });

            if (selecionado) {
                selecionado.quantidade = quantidade;
                var total = quantidade * (Number(selecionado.valor) || 0);
                $(this).closest('tr').find('.js-saida-servico-total').text(formatarValor(total));
                atualizarTotalSaida();
            }
        });

        $(document).on('input', '.js-saida-produto-qtde', function() {
            var produtoId = Number($(this).data('id'));
            var quantidade = parseFloat($(this).val());
            if (!isFinite(quantidade) || quantidade < 0) {
                quantidade = 0;
                $(this).val('0');
            }

            var selecionado = saidaProdutosSelecionados.find(function(item) {
                return Number(item.id) === produtoId;
            });

            if (selecionado) {
                selecionado.quantidade = quantidade;
                var total = quantidade * (Number(selecionado.valor) || 0);
                $(this).closest('tr').find('.js-saida-produto-total').text(formatarValor(total));
                atualizarTotalSaida();
            }
        });

        $(document).on('click', '.js-saida-remover-servico', function() {
            var servicoId = Number($(this).data('id'));
            saidaServicosSelecionados = saidaServicosSelecionados.filter(function(item) {
                return Number(item.id) !== servicoId;
            });
            renderTabelaSaida();
        });

        $(document).on('click', '.js-saida-remover-produto', function() {
            var produtoId = Number($(this).data('id'));
            saidaProdutosSelecionados = saidaProdutosSelecionados.filter(function(item) {
                return Number(item.id) !== produtoId;
            });
            renderTabelaSaidaProdutos();
        });

        $saidaHoraSaida.on('change input', function() {
            atualizarCalculoSaida();
        });

        $(document).on('click', '.btn-saida', function() {
            var id = $(this).data('reserva');
            if (!id) {
                return;
            }

            var participante = $(this).data('participante') || '';
            var horaEntradaCompleta = $(this).data('hora-entrada') || '';
            var convidados = Number($(this).data('convidados')) || 0;
            var pessoas = convidados + 1;

            resetSaidaModal();
            $saidaReserva.val(id);
            $saidaParticipante.text(participante);
            $saidaHoraEntrada.text(formatarHoraDisplay(horaEntradaCompleta) || '--:--').data('raw', horaEntradaCompleta);
            saidaHoraEntradaRaw = horaEntradaCompleta;
            saidaPessoasTotal = Math.max(1, pessoas);
            $saidaPessoas.val(saidaPessoasTotal).data('pessoas', saidaPessoasTotal);
            $saidaHoraSaida.val(getCurrentTime());

            atualizarCalculoSaida();
            $saidaModal.modal('show');
            carregarServicosSaida(id);
        });

        $saidaPessoas.on('change input', function() {
            atualizarCalculoSaida();
        });

        $saidaModal.on('shown.bs.modal', function() {
            initSelect2InsideModal($saidaServico, $saidaModal, 'saida-servico', 'Selecione um serviço');
            initSelect2InsideModal($saidaProduto, $saidaModal, 'saida-produto', 'Selecione um produto');
            $saidaHoraSaida.trigger('focus');
        });

        $saidaModal.on('hidden.bs.modal', function() {
            resetSaidaModal();
        });

        $saidaForm.on('submit', function(event) {
            event.preventDefault();

            var reservaId = Number($saidaReserva.val());
            if (!reservaId) {
                alert('Reserva inválida.');
                return;
            }

            var horaSaida = ($saidaHoraSaida.val() || '').trim();
            var servicosPayload = coletarServicosPayloadSaida();
            var produtosPayload = coletarProdutosPayloadSaida();

            var pago = $saidaPago.is(':checked');
            var observacoes = ($saidaObservacoes.val() || '').trim();
            var validacaoObs = validarObservacoesSaida(pago, observacoes);
            if (!validacaoObs.ok) {
                alert(validacaoObs.mensagem);
                return;
            }

            $saidaSubmit.prop('disabled', true);

            fetch(definirServicosUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    reserva_id: reservaId,
                    servicos: servicosPayload,
                    produtos: produtosPayload
                })
            }).then(function(response) {
                return response.json();
            }).then(function(response) {
                if (response && response.erro === false) {
                    return fetch(definirSaidaUrl + '/' + reservaId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({
                            reserva_id: reservaId,
                            hora: horaSaida,
                            observacoes: observacoes,
                            pago: pago
                        })
                    }).then(function(resp) {
                        return resp.json();
                    });
                }
                var mensagem = response && response.msg ? response.msg : 'Não foi possível atualizar os serviços.';
                throw new Error(mensagem);
            }).then(function(respSaida) {
                if (respSaida && respSaida.erro === false) {
                    resetSaidaModal();
                    $saidaModal.modal('hide');
                    window.location.reload();
                    return;
                }
                var mensagemSaida = respSaida && respSaida.msg ? respSaida.msg : 'Não foi possível salvar a saída.';
                throw new Error(mensagemSaida);
            }).catch(function(error) {
                alert(error && error.message ? error.message : 'Erro ao salvar a saída.');
            }).finally(function() {
                $saidaSubmit.prop('disabled', false);
            });
        });

        var requererTermo = <?= (int) ($requererTermo ?? 0) ?>;

        $(document).on('click', '.btn-entrada', function() {
            var $btn = $(this);
            var id = $btn.data('reserva');
            if (!id) {
                return;
            }

            var idade = parseInt($btn.data('idade'), 10) || 0;
            var temTermo = parseInt($btn.data('termo'), 10) || 0;
            var suspenso = parseInt($btn.data('suspenso'), 10) || 0;

            var abrirModalEntrada = function() {
                prepareModal({
                    action: '<?= base_url('Reserva/definirEntrada'); ?>' + '/' + id,
                    title: 'Definir Entrada',
                    submitText: 'Salvar Entrada',
                    submitClass: 'btn-success'
                });
            };

            if (suspenso === 1) {
                swal({
                    title: 'Participante suspenso',
                    text: 'Este participante está suspenso e não pode dar entrada.',
                    type: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (requererTermo === 1 && idade > 0 && idade < 18 && temTermo !== 1) {
                swal({
                    title: 'Termo não apresentado',
                    text: 'O participante é menor de 18 anos e o termo de responsabilidade não foi apresentado. Deseja continuar?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, continuar',
                    cancelButtonText: 'Não'
                }, function(isConfirm) {
                    if (isConfirm) {
                        abrirModalEntrada();
                    }
                });
                return;
            }

            abrirModalEntrada();
        });

        $modal.on('shown.bs.modal', function() {
            $inputHora.trigger('focus');
        });
    })(window.jQuery);
</script>
<?= $this->endSection(); ?>
