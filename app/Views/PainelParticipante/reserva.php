<?= $this->extend('PainelParticipante/template'); ?>

<?= $this->section('content'); ?>

<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Reserva</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Cadastrar</span>
    </div>
  </div>
</div>
<!-- breadcrumb -->

<div class="container px-0 ">
  <div class="card  box-shadow-0">
    <div class="card-header">
      <h4 class="card-title mb-1">Cadastrar</h4>
    </div>
    <div class="card-body pt-0">

      <!-- Formulário principal -->
      <div class="card mb-4">
        <div class="card-body p-4">
          <form id="formReserva" autocomplete="off" novalidate>
            <div class="row">
              <div class="col-12 col-md-6 mb-3">
                <label for="datePicker">Data</label>
                <input type="date" id="datePicker" class="form-control" />
                <small class="form-text text-muted">Escolha uma data válida conforme horário de funcionamento e exceções.</small>
              </div>
              <div class="col-12 col-md-6 mb-3">
                <label for="people">Total de pessoas</label>
                <input type="number" id="people" class="form-control" min="1" value="1" />
                <small class="form-text text-muted">Inclui participante e convidados. Checaremos a lotação simultânea por <em>slot</em>.</small>
              </div>
            </div>
            <div class="mt-2">
              <div class="d-flex align-items-center justify-content-between">
                <label class="mb-0">Horários disponíveis</label>
                <small class="text-secondary">1º clique = entrada • 2º clique = saída (no <em>mesmo grupo</em>). Você pode selecionar em <em>vários grupos</em>.</small>
              </div>
              <div id="slotGroups" class="d-flex flex-column mt-2"></div>
              <small id="slotsHelper" class="form-text text-muted mt-1"></small>
              <div class="mt-2 small text-secondary">
                <span class="d-inline-block" style="width:10px;height:10px;border-radius:50%;background:#cfe9cf;border:1px solid #198754;margin-right:.4rem;"></span>Boa disponibilidade
                <span class="d-inline-block ml-3" style="width:10px;height:10px;border-radius:50%;background:#ffe8a1;border:1px solid #ffc107;margin-right:.4rem;"></span>Disponibilidade baixa
                <span class="d-inline-block ml-3" style="width:10px;height:10px;border-radius:50%;background:#f8c6c9;border:1px solid #dc3545;margin-right:.4rem;"></span>Lotado / indisponível
                <span class="d-inline-block ml-3" style="width:10px;height:10px;border-radius:50%;background:rgba(220,53,69,.7);margin-right:.4rem;"></span>Conflito (sua seleção excede a lotação do slot)
              </div>
            </div>

            <hr class="border-secondary my-4 escola d-none" id="escolaDivider" />
            <div class="row escola d-none" id="escolaContainer">
              <div class="form-group col-12 col-md-4">
                <label class="main-content-label tx-11 tx-medium tx-gray-600" for="turmaEscola">É Uma Turma Escolar?</label>
                <select class="form-control" name="turmaEscola" id="turmaEscola">
                  <option value="" <?= old('turmaEscola') == '' ? 'selected' : ''; ?>></option>
                  <?PHP foreach (App\Entities\ReservaEntity::_op('turmaEscola') as $k => $op) { ?>
                    <option value="<?= $k; ?>" <?= old('turmaEscola') === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                  <?PHP } ?>
                </select>
              </div>
              <div class="form-group col-12 col-md-4 turma-escola-extra d-none" id="nomeEscolaGroup">
                <label class="main-content-label tx-11 tx-medium tx-gray-600" for="nomeEscola">Nome Escola</label>
                <input class="form-control" name="nomeEscola" id="nomeEscola" type="text" maxlength="250" value="<?= old('nomeEscola') ?>">
              </div>
              <div class="form-group col-12 col-md-4 turma-escola-extra d-none" id="anoTurmaGroup">
                <label class="main-content-label tx-11 tx-medium tx-gray-600" for="anoTurma">Ano Turma</label>
                <select class="form-control" name="anoTurma" id="anoTurma">
                  <option value="" <?= old('anoTurma') == '' ? 'selected' : ''; ?>></option>
                  <?PHP foreach (App\Entities\ReservaEntity::_op('anoTurma') as $k => $op) { ?>
                    <option value="<?= $k; ?>" <?= old('anoTurma') === $k ? 'selected' : ''; ?>><?= $op; ?></option>
                  <?PHP } ?>
                </select>
              </div>
            </div>
            <hr class="border-secondary my-4" />
            <!-- Atividade da Reserva -->
            <div class="mb-3">
              <h2 class="h5 mb-2">Atividade</h2>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="actTypeOficina" name="actType" class="custom-control-input" value="oficina" checked>
                <label class="custom-control-label" for="actTypeOficina">Oficina Temática</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="actTypeLivre" name="actType" class="custom-control-input" value="livre">
                <label class="custom-control-label" for="actTypeLivre">Atividade Livre</label>
              </div>

              <!-- Oficina Temática -->

              <div id="oficinaBlock" class="mt-3">

                <div class="form-group col-12 col-md-6">
                  <label class="main-content-label tx-11 tx-medium tx-gray-600">Oficina Temática</label>
                  <div class="input-group">
                    <input class="form-control" name="OficinaTematica_id_Text" id="OficinaTematica_id_Text" type="text" readonly="true" onclick="$('#modalTematica').modal('show')" value="<?= old('OficinaTematica_id_Text'); ?>" />
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" id="addonSearchOficinaTematica_id"
                        data-toggle="modal" data-target="#modalTematica">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                      </button>
                    </div>
                    <input class="d-none" name="OficinaTematica_id" id="OficinaTematica_id" type="text" value="<?= old('OficinaTematica_id'); ?>" />
                  </div>
                  <small id="oficinaHint" class="form-text text-muted"></small>
                </div>
                <div class="row">
                  <div class="col-12 mb-2">
                    <label for="note" class="form-label">Observação (opcional)</label>
                    <textarea id="note" class="form-control" rows="2" placeholder="Algum detalhe útil para a equipe"></textarea>
                  </div>
                </div>
              </div>

              <!-- Atividade Livre -->
              <div id="livreBlock" class="mt-3 d-none">
                <div class="form-group">
                  <label for="actDesc">Descrição / Passos</label>
                  <textarea id="actDesc" class="form-control" rows="3" placeholder="Passo 1: ..."></textarea>
                </div>
                <div class="form-group">
                  <label>Recursos a utilizar</label>
                  <div id="resChecks" class="row"></div>
                  <small class="form-text text-muted">Marque os equipamentos/ferramentas que serão utilizados.</small>
                </div>
              </div>

              <div class="d-flex flex-wrap align-items-center mt-2">
                <button type="button" id="btnReserve" class="btn btn-primary btn-lg px-4 mr-3" disabled>
                  Confirmar Reserva(s)
                </button>
                <div id="selectionSummary" class="text-secondary"></div>
              </div>
          </form>
        </div>
      </div>

      <div class="position-fixed p-3 d-none" style="z-index:1080; right:1rem; top:1rem;">
        <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2500">
          <div class="toast-header">
            <strong class="mr-auto">Reserva</strong>
            <small class="text-muted">agora</small>
            <button type="button" class="close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="toast-body" id="toastBody">Mensagem</div>
        </div>
      </div>



    </div>
  </div>
</div>

<div class="modal" id="modalTematica">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">Oficina Temáticas</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="w-100 modalTematicoLista">
          <h6>Escolha uma oficina temática</h6>
          <div class="row">
            <div class="col-12 mb-3">
              <label for="filtroModalTematico" class="form-label">Filtro</label>
              <input type="text" id="filtroModalTematico" class="form-control" placeholder="O que procura?" />
            </div>
          </div>
          <div class="row p-3">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Selecionar</th>
                  <th scope="col">Visualizar</th>
                  <th scope="col">Nome</th>
                </tr>
              </thead>
              <tbody>
                <?PHP foreach ($vOficinaTematica as $i) { ?>
                  <tr>
                    <td style="width: 70px;">
                      <div class="btn btn-primary btn-sm btnModalSelecionarLista" onclick="idOficina=<?= $i->id ?>; selecionarOficina();" data-id='<?= $i->id ?>'>
                        Selecionar
                      </div>
                    </td>
                    <td style="width: 130px;">
                      <div class="btn btn-secondary btn-sm btnModalDetalhes" data-id='<?= $i->id ?>'>
                        Ver Detalhes
                      </div>
                    </td>
                    <td><?= esc($i->nome) ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="w-100 modalTematicoNavegacao d-none">
          <div class="row modalTematicoNavegacao">
            <div class="col-6">
              <div class="btn btn-primary btn-sm" id='voltarLista'>Voltar Lista</div>
              <div class="btn btn-primary btn-sm" onclick="selecionarOficina()">Selecionar Oficina</div>
            </div>
            <div class="col-6  float-right text-right">
              <div class="btn btn-secondary btn-sm">
                < Anterior</div>
                  <div class="btn btn-secondary btn-sm ">Próxima ></div>
              </div>
            </div>
            <iframe id="editorPreview"></iframe>
          </div>

        </div>
        <div class="modal-footer">
          <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Fechar</button>
        </div>
      </div>
    </div>
  </div>


  <?= $this->endSection(); ?>

  <?= $this->section('styles'); ?>
  <style>
    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, .25);
    }

    .group-header {
      background: rgba(0, 0, 0, .04);
      border: 1px solid rgba(0, 0, 0, .08);
      border-radius: 1rem;
    }

    .dark-theme .group-header {
      background: rgba(255, 255, 255, .04);
      border: 1px solid rgba(255, 255, 255, .08);
      border-radius: 1rem;
    }

    .table-sticky thead th {
      position: sticky;
      top: 0;
      background: #fff;
      z-index: 1;
    }

    /* Slots */
    .slot-btn {
      position: relative;
      min-width: 110px;
    }

    .slot-badge {
      position: absolute;
      top: -6px;
      right: -6px;
      font-size: .75rem;
    }

    .slot-btn.active-start.btn-outline-light:not(:disabled):not(.disabled).active {
      outline: 2px solid #0d6efd;
    }

    .slot-btn.active-end.btn-outline-light:not(:disabled):not(.disabled).active {
      outline: 2px dashed #0d6efd;
    }

    .slot-btn.in-range {
      background: rgba(25, 135, 84, .2);
      border-color: rgba(25, 135, 84, .5);
    }

    .slot-btn.conflict {
      background: rgba(220, 53, 69, .25) !important;
      border-color: rgba(220, 53, 69, .8) !important;
    }

    /* Helpers para espaçamento (equivalente ao gap) */
    .flex-gap-2>* {
      margin-right: .5rem;
      margin-bottom: .5rem;
    }

    .mr-3-imp {
      margin-right: 1rem !important;
    }

    /* 1) o dialog ocupa a janela (descontando as margens padrão do BS4) */
    #modalTematica .modal-dialog {
      margin: 1.75rem auto;
      /* mantém margens do BS >=576px */
      height: calc(100vh - 3.5rem);
      /* 100vh - (1.75rem * 2) */
    }

    /* em telas pequenas o BS usa .5rem de margem */
    @media (max-width: 575.98px) {
      #modalTematica .modal-dialog {
        margin: .5rem;
        height: calc(100vh - 1rem);
      }
    }

    /* 2) o conteúdo do modal ocupa 100% do dialog */
    #modalTematica .modal-content {
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    /* 3) o body vira um flex container que pode encolher */
    #modalTematica .modal-body {
      flex: 1 1 auto;
      display: flex;
      flex-direction: column;
      min-height: 0;
      /* crucial pra permitir que os filhos usem 100% */
      overflow: hidden;
      /* evita barra dupla */
    }

    /* 4) área de navegação (onde está o iframe) preenche o body */
    #modalTematica .modalTematicoNavegacao {
      display: flex;
      flex-direction: column;
      flex: 1 1 auto;
      min-height: 0;
    }

    /* wrapper do iframe ocupa o que sobrar */
    #modalTematica .iframe-wrap {
      flex: 1 1 auto;
      min-height: 0;
      /* sem isso, o iframe não consegue h-100 */
      display: flex;
    }

    /* o iframe finalmente consegue 100% */
    #editorPreview {
      width: 100%;
      height: 100%;
      border: 0;
      display: block;
      background-color: #FFF;
    }
  </style>
  <?= $this->endSection(); ?>

  <?= $this->section('scripts'); ?>
  <script>
    // ==========================
    //  Configurações & Estado
    // ==========================

    const CAPACITY = <?= $configuracao->lotacaoEspaco; ?>; // capacidade simultânea
    const SLOT_MINUTES = 30; // granularidade dos botões

    // Horário padrão (seg–sex): 08:00–12:00 e 14:00–18:00 | ISO weekday 1..7
    <?php
    $scheduleByDay = [];
    foreach ($vHorarioFuncionamento as $horario) {
      $dayKey = (int) $horario->diaSemana;
      $scheduleByDay[$dayKey][] = [
        'start' => substr((string) $horario->horaInicio, 0, 5),
        'end'   => substr((string) $horario->horaFinal, 0, 5),
      ];
    }

    foreach ([1, 2, 3, 4, 5, 6, 7] as $dayKey) {
      $scheduleByDay[$dayKey] = $scheduleByDay[$dayKey] ?? [];
    }

    foreach ($scheduleByDay as &$intervals) {
      if (count($intervals) > 1) {
        usort($intervals, static function ($a, $b) {
          return strcmp($a['start'], $b['start']);
        });
      }
    }
    unset($intervals);
    ?>
    const DEFAULT_SCHEDULE = <?= json_encode($scheduleByDay, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

    const CLOSED_DATES = new Set([ /* '2025-12-25' */ ]); // feriados: fechado o dia todo
    const SPECIAL_CLOSED_INTERVALS_BY_DATE = {
      /* '2025-09-22': [ { start: '16:00', end: '18:00' } ] */ };
    const SPECIAL_OPENINGS_BY_DATE = {
      /* '2025-09-20': [ { start: '09:00', end: '13:00' } ] */ };

    // Recursos do espaço (agora com flag de exclusividade e quantidade)
    const RESOURCES = <?= json_encode($vRecursoTrabalho, JSON_PRETTY_PRINT) ?>;

    const EXCLUSIVE_RESOURCE_IDS = new Set(RESOURCES.filter(r => r.exclusive).map(r => r.id));

    // Oficinas temáticas pré-definidas (5 exemplos maker)
    const ACTIVITIES = <?= json_encode($lAtividades, JSON_PRETTY_PRINT) ?>;

    // Reservas simuladas (em produção: carregar/salvar via API)
    let reservations = [ /* { date, start:'HH:MM', duration: min, people, name, participantId, note, activity: {...} } */ ];

    // Estado de seleções (múltiplos grupos): { [groupIndex]: { startIdx, endIdx } }
    let selectedRanges = {};

    // Memória dos grupos renderizados atualmente
    let currentGroups = [];

    // ID da Oficina Temática/Atividade selecionada no modal
    let idOficina = 0;
    let validatorInstance = null;

    // ==========================
    //  Utilidades de tempo
    // ==========================
    function toMinutes(hhmm) {
      const [h, m] = hhmm.split(':').map(Number);
      return h * 60 + m;
    }

    function minutesToHHMM(total) {
      const h = Math.floor(total / 60),
        m = total % 60;
      return `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}`;
    }

    function todayStr() {
      const d = new Date();
      d.setHours(0, 0, 0, 0);
      return d.toISOString().slice(0, 10);
    }

    function isoToDate(iso) {
      const [y, mo, da] = iso.split('-').map(Number);
      return new Date(y, mo - 1, da);
    }

    function isoWeekday(iso) {
      let wd = isoToDate(iso).getDay();
      return wd === 0 ? 7 : wd;
    }

    // ==========================
    //  Regras de agenda
    // ==========================
    function getOpenIntervalsForDate(isoDate) {
      if (CLOSED_DATES.has(isoDate)) return [];
      if (SPECIAL_OPENINGS_BY_DATE[isoDate]) return SPECIAL_OPENINGS_BY_DATE[isoDate];
      const wd = isoWeekday(isoDate);
      return DEFAULT_SCHEDULE[wd] || [];
    }

    function isOverlapping(aStart, aEnd, bStart, bEnd) {
      return aStart < bEnd && bStart < aEnd;
    }

    // Gera grupos contínuos de slots (split por intervalos fechados)
    function generateGroupedSlots(isoDate) {
      const openings = getOpenIntervalsForDate(isoDate);
      const closed = SPECIAL_CLOSED_INTERVALS_BY_DATE[isoDate] || [];
      const groups = [];

      openings.forEach(win => {
        const wStart = toMinutes(win.start),
          wEnd = toMinutes(win.end);
        let current = [];
        for (let t = wStart; t + SLOT_MINUTES <= wEnd; t += SLOT_MINUTES) {
          const s = t,
            e = t + SLOT_MINUTES;
          const blocked = closed.some(ci => isOverlapping(s, e, toMinutes(ci.start), toMinutes(ci.end)));
          if (blocked) {
            if (current.length) {
              const last = current[current.length - 1];
              const label = `${current[0].start}–${minutesToHHMM(toMinutes(last.start) + SLOT_MINUTES)}`;
              groups.push({
                label,
                slots: current
              });
              current = [];
            }
            continue;
          }
          const used = peopleInInterval(isoDate, s, e);
          current.push({
            start: minutesToHHMM(s),
            end: minutesToHHMM(e),
            used,
            left: Math.max(0, CAPACITY - used)
          });
        }
        if (current.length) {
          const last = current[current.length - 1];
          const label = `${current[0].start}–${minutesToHHMM(toMinutes(last.start) + SLOT_MINUTES)}`;
          groups.push({
            label,
            slots: current
          });
        }
      });

      return groups;
    }

    function peopleInInterval(isoDate, startMin, endMin) {
      return reservations.filter(r => r.date === isoDate).reduce((sum, r) => {
        const rs = toMinutes(r.start),
          re = rs + Number(r.duration);
        return sum + (isOverlapping(startMin, endMin, rs, re) ? r.people : 0);
      }, 0);
    }

    // ==========================
    //  (ALTERADO) Aceitar 1 slot e validar capacidade
    // ==========================
    function canBookRange(isoDate, group, startIdx, endIdx, people) {
      if (startIdx == null) return {
        ok: false,
        reason: 'Selecione a entrada.'
      };
      const effectiveEndIdx = (endIdx == null || endIdx <= startIdx) ? startIdx + 1 : endIdx;
      for (let i = startIdx; i < effectiveEndIdx; i++) {
        const slot = group.slots[i];
        if (slot.used + Number(people) > CAPACITY) {
          return {
            ok: false,
            reason: `Lotação excedida entre ${slot.start}-${slot.end}.`
          };
        }
      }
      return {
        ok: true
      };
    }

    // ==========================
    //  Atividades (UI + helpers)
    // ==========================
    const oficinaBlock = document.getElementById('oficinaBlock');
    const livreBlock = document.getElementById('livreBlock');
    const oficinaHint = document.getElementById('oficinaHint');
    const resChecks = document.getElementById('resChecks');

    function renderActivitiesUI() {
      // Renderizar checkboxes de recursos (indica exclusivo e quantidade)
      resChecks.innerHTML = '';
      RESOURCES.forEach((r) => {
        const col = document.createElement('div');
        col.className = 'col-md-4';
        const id = `res-${r.id}`;
        const extra = r.exclusive ? ` <span class="badge badge-danger">exclusivo${r.quantity>1?` ×${r.quantity}`:''}</span>` : '';
        col.innerHTML = `
        <div class="custom-control custom-checkbox mb-1">
          <input type="checkbox" class="custom-control-input" id="${id}" value="${r.id}">
          <label class="custom-control-label" for="${id}">${r.name}${extra}</label>
        </div>`;
        resChecks.appendChild(col);
      });

      if (oficinaIdInput) {
        setOficinaSelection(oficinaIdInput.value);
      } else {
        updateOficinaHint();
        updateSelectionSummary(currentGroups);
      }
    }

    function getSelectedOficina() {
      if (!oficinaIdInput) return null;
      const id = (oficinaIdInput.value || '').trim();
      if (!id) return null;
      return ACTIVITIES.find(a => String(a.id) === id) || null;
    }

    function setOficinaSelection(id) {
      const normalized = id !== undefined && id !== null ? String(id).trim() : '';
      if (oficinaIdInput) {
        oficinaIdInput.value = normalized;
      }
      const activity = normalized ? ACTIVITIES.find(a => String(a.id) === normalized) : null;
      if (oficinaTextInput) {
        if (activity) {
          oficinaTextInput.value = activity.name;
        } else if (!normalized) {
          oficinaTextInput.value = '';
        }
      }
      updateOficinaHint();
      updateSelectionSummary(currentGroups);
    }

    function updateOficinaHint() {
      if (!oficinaHint) return;
      const activity = getSelectedOficina();
      if (!activity) {
        oficinaHint.innerHTML = '<strong>Descrição:</strong> -- <br><strong>Recursos:</strong> --';
        return;
      }
      const resNames = (activity.resourceIds || []).map(rid => {
        const r = RESOURCES.find(rr => rr.id === rid);
        if (!r) return rid;
        let label = r.name;
        if (r.exclusive) label += ` (exclusivo${r.quantity>1?` ×${r.quantity}`:''})`;
        return label;
      }).join(', ') || '--';
      oficinaHint.innerHTML = `<strong>Descrição:</strong> ${activity.description} <br><strong>Recursos:</strong> ${resNames}`;
    }

    function getActivityPayload() {
      const type = document.querySelector('input[name="actType"]:checked').value;
      if (type === 'oficina') {
        const activity = getSelectedOficina();
        if (!activity) return {
          ok: false,
          reason: 'Selecione uma oficina.'
        };
        return {
          ok: true,
          value: {
            type: 'oficina',
            id: activity.id
          }
        };
      }
      // livre
      const description = document.getElementById('actDesc').value.trim();
      const resourceIds = Array.from(resChecks.querySelectorAll('input[type=checkbox]:checked')).map(i => i.value);
      return {
        ok: true,
        value: {
          type: 'livre',
          description,
          resourceIds
        }
      };
    }

    function getActivityResourceIds(actValue) {
      if (!actValue) return [];
      if (actValue.type === 'oficina') {
        const a = ACTIVITIES.find(x => x.id === actValue.id);
        return a ? a.resourceIds : [];
      }
      if (actValue.type === 'livre') {
        return actValue.resourceIds || [];
      }
      return [];
    }

    function getActivitySummary() {
      const type = document.querySelector('input[name="actType"]:checked').value;
      if (type === 'oficina') {
        const activity = getSelectedOficina();
        return activity ? `Oficina: <strong>${activity.name}</strong>` : 'Oficina: --';
      } else {
        const desc = document.getElementById('actDesc').value.trim();
        if (!desc) return 'Atividade Livre: --';
        const preview = desc.length > 80 ? `${desc.slice(0, 77)}...` : desc;
        return `Atividade Livre: <strong>${preview}</strong>`;
      }
    }

    function toggleActivityBlocks() {
      const type = document.querySelector('input[name="actType"]:checked').value;
      if (type == 'oficina') {
        oficinaBlock.classList.remove('d-none');
        livreBlock.classList.add('d-none');
      } else {
        oficinaBlock.classList.add('d-none');
        livreBlock.classList.remove('d-none');
      }
    }

    // ==========================
    //  Exclusividade/Quantidade de recursos (verificação)
    // ==========================
    function reservationResourceIds(activity) {
      if (!activity) return [];
      if (activity.type === 'oficina') {
        const a = ACTIVITIES.find(x => x.id === activity.id);
        return a ? a.resourceIds : [];
      }
      if (activity.type === 'livre') {
        return activity.resourceIds || [];
      }
      return [];
    }

    function getResourceById(id) {
      return RESOURCES.find(r => r.id === id) || null;
    }

    function countOverlappingUsage(isoDate, startMin, endMin, resourceId, pool) {
      let count = 0;
      for (const r of pool) {
        if (r.date !== isoDate) continue;
        const rs = toMinutes(r.start),
          re = rs + Number(r.duration);
        if (!isOverlapping(startMin, endMin, rs, re)) continue;
        const usedIds = reservationResourceIds(r.activity);
        if (usedIds && usedIds.indexOf(resourceId) !== -1) {
          count++;
        }
      }
      return count;
    }

    // Verifica capacidade para recursos exclusivos considerando quantidade
    function findExclusiveCapacityConflict(isoDate, startMin, endMin, requestedExclusiveIds, pool) {
      if (!requestedExclusiveIds.length) return null;
      for (const rid of requestedExclusiveIds) {
        const res = getResourceById(rid);
        const cap = res && typeof res.quantity === 'number' ? res.quantity : 1;
        const used = countOverlappingUsage(isoDate, startMin, endMin, rid, pool);
        if (used >= cap) {
          return {
            resourceId: rid,
            resourceName: res ? res.name : rid,
            inUseStart: minutesToHHMM(startMin),
            inUseEnd: minutesToHHMM(endMin),
            used,
            capacity: cap
          };
        }
      }
      return null;
    }

    // ==========================
    //  Renderização de UI (horários)
    // ==========================
    const datePicker = document.getElementById('datePicker');
    const peopleInput = document.getElementById('people');
    const slotGroupsEl = document.getElementById('slotGroups');
    const slotsHelper = document.getElementById('slotsHelper');
    const btnReserve = document.getElementById('btnReserve');
    const selectionSummary = document.getElementById('selectionSummary');
    const escolaDivider = document.getElementById('escolaDivider');
    const escolaContainer = document.getElementById('escolaContainer');
    const turmaEscolaSelect = document.getElementById('turmaEscola');
    const nomeEscolaGroup = document.getElementById('nomeEscolaGroup');
    const anoTurmaGroup = document.getElementById('anoTurmaGroup');
    const nomeEscolaInput = document.getElementById('nomeEscola');
    const anoTurmaSelect = document.getElementById('anoTurma');
    const oficinaIdInput = document.getElementById('OficinaTematica_id');
    const oficinaTextInput = document.getElementById('OficinaTematica_id_Text');

    let selectedDate = todayStr();
    const today = selectedDate;
    const maxDate = new Date();
    maxDate.setDate(maxDate.getDate() + 90);
    const maxIso = maxDate.toISOString().slice(0, 10);
    datePicker.min = today;
    datePicker.max = maxIso;
    datePicker.value = today;

    function clearFieldValidation(fields) {
      if (!Array.isArray(fields)) {
        fields = [fields];
      }
      fields.forEach(field => {
        if (!field) return;
        field.classList.remove('is-valid', 'is-invalid');
        field.removeAttribute('aria-invalid');
        if (validatorInstance) {
          validatorInstance.errorsFor(field).hide();
        }
      });
    }

    function enableValidationFieldsFK() {
      // Mantém compatibilidade com padrões de validação usados no painel.
    }

    function updateTurmaValidation() {
      if (!validatorInstance) return;
      if (turmaEscolaSelect) {
        validatorInstance.element(turmaEscolaSelect);
      }
      if (nomeEscolaInput) {
        if (nomeEscolaGroup && nomeEscolaGroup.classList.contains('d-none')) {
          clearFieldValidation(nomeEscolaInput);
        } else {
          validatorInstance.element(nomeEscolaInput);
        }
      }
      if (anoTurmaSelect) {
        if (anoTurmaGroup && anoTurmaGroup.classList.contains('d-none')) {
          clearFieldValidation(anoTurmaSelect);
        } else {
          validatorInstance.element(anoTurmaSelect);
        }
      }
    }

    function toggleTurmaExtra(show) {
      [nomeEscolaGroup, anoTurmaGroup].forEach(group => {
        if (!group) return;
        group.classList.toggle('d-none', !show);
      });
      if (!show) {
        if (nomeEscolaInput) nomeEscolaInput.value = '';
        if (anoTurmaSelect) anoTurmaSelect.value = '';
        clearFieldValidation([nomeEscolaInput, anoTurmaSelect]);
      }
      updateTurmaValidation();
    }

    function toggleEscolaSection() {
      const show = Number(peopleInput.value || 0) > 1;
      if (escolaDivider) escolaDivider.classList.toggle('d-none', !show);
      if (escolaContainer) escolaContainer.classList.toggle('d-none', !show);
      if (!show) {
        if (turmaEscolaSelect) turmaEscolaSelect.value = '';
        toggleTurmaExtra(false);
        clearFieldValidation(turmaEscolaSelect);
      } else {
        toggleTurmaExtra(turmaEscolaSelect && turmaEscolaSelect.value === '0');
      }
      updateTurmaValidation();
    }

    function renderGroups({
      keepSelections
    } = {
      keepSelections: true
    }) {
      const iso = selectedDate;
      const openings = getOpenIntervalsForDate(iso);

      slotGroupsEl.innerHTML = '';
      if (!keepSelections) selectedRanges = {};

      if (CLOSED_DATES.has(iso)) {
        slotsHelper.textContent = 'Fechado o dia todo (feriado/agenda).';
        currentGroups = [];
        updateSelectionSummary([]);
        return;
      }
      if (!openings.length) {
        slotsHelper.textContent = 'Dia sem funcionamento.';
        currentGroups = [];
        updateSelectionSummary([]);
        return;
      }

      currentGroups = generateGroupedSlots(iso);
      if (!currentGroups.length) {
        slotsHelper.textContent = 'Sem horários disponíveis (fechamentos parciais ou sem janelas úteis).';
        updateSelectionSummary([]);
        return;
      }
      slotsHelper.textContent = '';

      currentGroups.forEach((group, gi) => {
        const card = document.createElement('div');
        card.className = 'p-3 group-header mb-3';
        const title = document.createElement('div');
        title.className = 'mb-2 d-flex justify-content-between align-items-center';
        title.innerHTML = `<span class="font-weight-semibold">Janela contínua ${gi+1}: ${group.label}</span>` +
          `<small class="text-secondary">Selecione <em>entrada</em> e <em>saída</em> nesta janela</small>`;

        const wrap = document.createElement('div');
        wrap.className = 'd-flex flex-wrap flex-gap-2';

        group.slots.forEach((slot, si) => {
          const btn = document.createElement('button');
          btn.type = 'button';
          btn.className = 'btn btn-outline-light slot-btn';
          btn.textContent = slot.start;
          const badge = document.createElement('span');
          badge.className = 'badge badge-pill badge-secondary slot-badge';
          badge.textContent = `${slot.used}/${CAPACITY}`;
          if (slot.left <= 0) {
            btn.classList.add('disabled', 'btn-outline-danger');
            badge.classList.remove('badge-secondary');
            badge.classList.add('badge-danger');
          } else if (slot.left <= CAPACITY * 0.25) {
            btn.classList.add('btn-outline-warning');
            badge.classList.remove('badge-secondary');
            badge.classList.add('badge-warning');
          } else {
            btn.classList.add('btn-outline-success');
            badge.classList.remove('badge-secondary');
            badge.classList.add('badge-success');
          }
          btn.appendChild(badge);

          btn.addEventListener('click', () => handleSlotClick(gi, si));
          wrap.appendChild(btn);
        });

        card.appendChild(title);
        card.appendChild(wrap);
        slotGroupsEl.appendChild(card);
      });

      refreshSelectionStyles();
      updateSelectionSummary(currentGroups);
    }

    // ==========================
    //  (ALTERADO) Visual da seleção aceita 1 slot
    // ==========================
    function refreshSelectionStyles() {
      // Limpa estilos
      Array.prototype.forEach.call(document.querySelectorAll('.slot-btn'), b => {
        b.classList.remove('active', 'active-start', 'active-end', 'in-range', 'conflict');
      });

      const p = Number(peopleInput.value || 0);

      Object.entries(selectedRanges).forEach(([giStr, range]) => {
        const gi = Number(giStr);
        const g = currentGroups[gi];
        if (!g || range.startIdx == null) return;
        const groupEl = slotGroupsEl.querySelectorAll('.group-header')[gi];
        if (!groupEl) return;
        const groupBtns = groupEl.querySelectorAll('.slot-btn');
        const startBtn = groupBtns[range.startIdx];
        if (startBtn) startBtn.classList.add('active', 'active-start');

        const effectiveEnd = (range.endIdx != null && range.endIdx > range.startIdx) ?
          range.endIdx :
          range.startIdx + 1;

        for (let i = range.startIdx; i < effectiveEnd; i++) {
          const btn = groupBtns[i];
          if (btn) btn.classList.add('in-range');
          // Checa conflito de lotação por slot
          if (p && (g.slots[i].used + p > CAPACITY)) {
            if (btn) btn.classList.add('conflict');
          }
        }
        const endBtn = groupBtns[effectiveEnd - 1];
        if (endBtn) endBtn.classList.add('active', 'active-end');
      });
    }

    // ==========================
    //  (ALTERADO) Coleta seleção mesmo com 1 slot
    // ==========================
    function collectSelections() {
      // Retorna array de { gi, start, end, duration, groupLabel }
      const out = [];
      Object.entries(selectedRanges).forEach(([giStr, r]) => {
        const gi = Number(giStr);
        const g = currentGroups[gi];
        if (!g || r.startIdx == null) return;

        const startIdx = r.startIdx;
        const endIdxEff = (r.endIdx == null || r.endIdx <= startIdx) ? startIdx + 1 : r.endIdx;

        const start = g.slots[startIdx].start;
        const end = g.slots[endIdxEff - 1].end;
        const duration = toMinutes(end) - toMinutes(start);
        out.push({
          gi,
          start,
          end,
          duration,
          groupLabel: g.label,
          group: g
        });
      });
      return out.sort((a, b) => toMinutes(a.start) - toMinutes(b.start));
    }

    // ==========================
    //  (ALTERADO) Clique no mesmo slot de entrada limpa a seleção
    // ==========================
    function handleSlotClick(gi, si) {
      const g = currentGroups[gi];
      const slot = g.slots[si];
      if (slot.left <= 0) return; // não selecionar slot lotado

      const r = selectedRanges[gi] || {
        startIdx: null,
        endIdx: null
      };

      if (r.startIdx == null || r.endIdx != null) {
        // Inicia/Reseta seleção neste grupo
        r.startIdx = si;
        r.endIdx = null;
      } else {
        // Já temos entrada e aguardamos saída
        if (si === r.startIdx) {
          // Clique novamente no mesmo slot de entrada => limpa seleção da janela
          r.startIdx = null;
          r.endIdx = null;
        } else if (si > r.startIdx) {
          r.endIdx = si + 1; // fim exclusivo
        } else { // clicou antes do início => redefine início
          r.startIdx = si;
          r.endIdx = null;
        }
      }

      selectedRanges[gi] = r;
      refreshSelectionStyles();
      updateSelectionSummary(currentGroups);
    }

    function updateSelectionSummary(groups) {
      const p = Number(peopleInput.value || 0);
      const selections = collectSelections();
      const activityStr = getActivitySummary();
      if (!selections.length) {
        selectionSummary.innerHTML = activityStr;
        btnReserve.disabled = true;
        return;
      }

      // Validar todos os ranges (capacidade; exclusividade é checada no submit)
      let allOk = p >= 1;
      const parts = selections.map(sel => {
        const check = canBookRange(selectedDate, sel.group, selectedRanges[sel.gi].startIdx, selectedRanges[sel.gi].endIdx, p);
        if (!check.ok) allOk = false;
        return `${sel.start}–${sel.end}${check.ok ? '' : ` <span class="text-warning">(${check.reason})</span>`}`;
      });
      let dataBR = (new Date(selectedDate)).toLocaleDateString("pt-BR")
      selectionSummary.innerHTML = `Reserva em <strong>${dataBR}</strong> para <strong>${p}</strong> pessoa(s): ${parts.join(' • ')}<br>${activityStr}`;
      btnReserve.disabled = !allOk;
    }

    // ==========================
    //  Eventos
    // ==========================
    datePicker.addEventListener('change', () => {
      selectedDate = datePicker.value;
      selectedRanges = {}; // nova data => limpa seleções
      renderGroups({
        keepSelections: false
      });
    });

    peopleInput.addEventListener('input', () => {
      toggleEscolaSection();
      refreshSelectionStyles();
      updateSelectionSummary(currentGroups);
    });

    if (turmaEscolaSelect) {
      turmaEscolaSelect.addEventListener('change', () => {
        toggleTurmaExtra(turmaEscolaSelect.value === '0');
      });
    }

    if (oficinaIdInput) {
      ['change', 'input'].forEach(evt => {
        oficinaIdInput.addEventListener(evt, () => setOficinaSelection(oficinaIdInput.value));
      });
    }
    if (oficinaTextInput) {
      ['change', 'input'].forEach(evt => {
        oficinaTextInput.addEventListener(evt, () => {
          updateOficinaHint();
          updateSelectionSummary(currentGroups);
        });
      });
    }

    document.querySelectorAll('input[name="actType"]').forEach(el => {
      el.addEventListener('change', () => {
        toggleActivityBlocks();
        updateSelectionSummary(currentGroups);
      });
    });
    document.getElementById('actDesc').addEventListener('input', () => updateSelectionSummary(currentGroups));

    function toastMsg(msg) {
      document.getElementById('toastBody').textContent = msg;
      $('#toast').toast('show');
    }

    validatorInstance = $("#formReserva").validate({
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        error.appendTo(element.parent());
      },
      highlight: function(element) {
        $(element).removeClass('is-valid').addClass('is-invalid');
      },
      unhighlight: function(element) {
        $(element).removeClass('is-invalid').addClass('is-valid');
      },
      onfocusout: function(element) {
        if (!this.checkable(element)) {
          this.element(element);
        }
      },
      invalidHandler: function() {
        $('.submitButton').attr('disabled', false);
        enableValidationFieldsFK();
      },
      errorElement: "div",
      ignore: '.ignoreValidate',
      rules: {
        turmaEscola: {
          required: function() {
            return escolaContainer && !escolaContainer.classList.contains('d-none');
          },
        },
        nomeEscola: {
          required: function() {
            return nomeEscolaGroup && !nomeEscolaGroup.classList.contains('d-none');
          },
        },
        anoTurma: {
          required: function() {
            return anoTurmaGroup && !anoTurmaGroup.classList.contains('d-none');
          },
        },
      },
    });
    updateTurmaValidation();

    btnReserve.addEventListener('click', () => {
      if (validatorInstance && !validatorInstance.form()) {
        return;
      }
      const participantName = '<?=  $participante->nome ?>';
      const participantId = '<?=  $participante->id ?>';
      const note = document.getElementById('note').value.trim();
      const p = Number(peopleInput.value || 0);

      const act = getActivityPayload();
      if (!act.ok) return toastMsg(act.reason);

      const selections = collectSelections();
      if (!selections.length) return toastMsg('Selecione entrada e saída em ao menos uma janela.');

      // Validação final por range (capacidade)
      for (const sel of selections) {
        const ok = canBookRange(selectedDate, sel.group, selectedRanges[sel.gi].startIdx, selectedRanges[sel.gi].endIdx, p);
        if (!ok.ok) return toastMsg(ok.reason);
      }

      // Verificação de exclusividade + capacidade de recursos (somente para recursos exclusivos)
      const reqResIds = getActivityResourceIds(act.value);
      const requestedExclusiveIds = reqResIds.filter(id => EXCLUSIVE_RESOURCE_IDS.has(id));

      // Verifica conflitos tanto com reservas existentes como entre os próprios intervalos selecionados
      const pending = []; // acumula reservas que serão criadas nesta operação
      for (const sel of selections) {
        const sMin = toMinutes(sel.start),
          eMin = toMinutes(sel.end);
        const conflict = findExclusiveCapacityConflict(selectedDate, sMin, eMin, requestedExclusiveIds, reservations.concat(pending));
        if (conflict) {
          return toastMsg(`Recurso exclusivo "${conflict.resourceName}" sem unidades disponíveis entre ${conflict.inUseStart} e ${conflict.inUseEnd} (${conflict.used}/${conflict.capacity} em uso).`);
        }
        pending.push({
          date: selectedDate,
          start: sel.start,
          duration: sel.duration,
          activity: act.value
        });
      }

      // enviando ao servidor
      let newReservations = {
        date: selectedDate,
        interval: [],
        people: p,
        name: participantName || '',
        participantId: participantId || '',
        note: note || '',
        activity: act.value, // { type:'oficina', id } ou { type:'livre', description, resourceIds }
        isClass: $('#turmaEscola').val() == '0' ? true : false,
        nameSchool: $('#nomeEscola').val() || '',
        yearClass: $('#anoTurma').val() || '',
      };

      for (const sel of selections) {
        newReservations.interval.push({
          start: sel.start,
          duration: sel.duration,
        });
      }

      fetch("<?= base_url(); ?>PainelParticipante/cadastrarReserva", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(newReservations)
        })
        .then(response => {
          if (!response.ok) throw new Error("Erro HTTP " + response.status);
          return response.json(); // ou response.text(), depende do que seu controller retorna
        })
        .then(data => {
          console.log("Resposta do servidor:", data);
          // exemplo: tratar a resposta
          if (data.erro) {
            alert("Erro: " + data.msg);
          } else {
            alert("Reservas salvas com sucesso!");
          }
        })
        .catch(error => {
          console.error("Erro na requisição:", error);
        });


      // Criar múltiplas reservas (uma por janela selecionada)
      for (const sel of selections) {
        reservations.push({
          date: selectedDate,
          start: sel.start,
          duration: sel.duration,
          people: p,
          name: participantName || '',
          participantId: participantId || '',
          note: note || '',
          activity: act.value // { type:'oficina', id } ou { type:'livre', description, resourceIds }
        });
      }

      toastMsg(`Reserva${selections.length>1?'s':''} confirmada${selections.length>1?'s':''}: ${selections.map(s=>s.start+'–'+s.end).join(' • ')}`);

      // Após reserva, limpar seleções mas manter valores do formulário
      selectedRanges = {};
      renderGroups({
        keepSelections: false
      });
    });


    $('.btnModalDetalhes').on('click', function(evt) {
      idOficina = $(evt.target).data('id');
      let url = '<?= base_url(); ?>PainelParticipante/descricaoOficina/' + idOficina;

      const iframe = document.getElementById("editorPreview");
      const doc = iframe.contentDocument || iframe.contentWindow.document;
      doc.open();
      doc.write(`<!doctype html><html><head><meta charset="utf-8"></head><body>Carregando....</body></html>`);
      doc.close();
      fetch(url)
        .then(response => {
          if (!response.ok) {
            throw new Error("Erro HTTP " + response.status);
          }
          return response.json();
        })
        .then(data => {
          if (!data.error) {
            $('.modalTematicoLista').addClass('d-none');
            $('.modalTematicoNavegacao').removeClass('d-none');
            const iframe = document.getElementById("editorPreview");
            const doc = iframe.contentDocument || iframe.contentWindow.document;
            doc.open();
            doc.write(`<!doctype html><html><head><meta charset="utf-8"></head><body>${data.html}</body></html>`);
            doc.close();
          } else {
            console.error("Erro da API:", data.msg);
          }
        })
        .catch(error => {
          console.error("Erro na requisição:", error);
        });
    });

    $("#voltarLista").on('click', (evt) => {
      $('.modalTematicoLista').removeClass('d-none');
      $('.modalTematicoNavegacao').addClass('d-none');
    });

    const filtroModalTematicoInput = document.getElementById('filtroModalTematico');
    const modalTematicaTableBody = document.querySelector('#modalTematica tbody');

    const normalizeText = (value) => {
      const text = (value || '').toString();
      try {
        return text.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
      } catch (err) {
        return text.toLowerCase();
      }
    };

    const filtrarOficinasPorNome = () => {
      if (!modalTematicaTableBody) {
        return;
      }
      const termo = normalizeText(filtroModalTematicoInput ? filtroModalTematicoInput.value.trim() : '');
      Array.from(modalTematicaTableBody.querySelectorAll('tr')).forEach((row) => {
        const nomeCelula = row.querySelector('td:last-child');
        const nome = normalizeText(nomeCelula ? nomeCelula.textContent : '');
        const deveOcultar = termo.length > 0 && !nome.includes(termo);
        row.classList.toggle('d-none', deveOcultar);
      });
    };

    if (filtroModalTematicoInput) {
      filtroModalTematicoInput.addEventListener('input', filtrarOficinasPorNome);
      $('#modalTematica').on('shown.bs.modal', () => {
        filtroModalTematicoInput.value = '';
        filtrarOficinasPorNome();
        filtroModalTematicoInput.focus();
      });
    }

    function selecionarOficina() {
      setOficinaSelection(idOficina ? String(idOficina) : '');
      $('#modalTematica').modal('hide');
    }

    $('#modalTematica').on('hidden.bs.modal', function(event) {
      $('.modalTematicoLista').removeClass('d-none');
      $('.modalTematicoNavegacao').addClass('d-none');
      if (filtroModalTematicoInput) {
        filtroModalTematicoInput.value = '';
        filtrarOficinasPorNome();
      }
    });

    // ==========================
    //  Inicialização 
    // ==========================

    <?PHP

    echo "reservations = " . json_encode($itensReserva) . "\n";
    ?>
    // reservations.push(
    // {"date":"2025-10-02","start":"10:30","duration":30,"people":2,"name":"Lucas Participante","activity":{"type":"oficina","id":"2"}},
    // {"date":"2025-10-02","start":"10:30","duration":30,"people":2,"name":"Lucas Participante","activity":{"type":"oficina","id":"2"}},
    // { date: todayDemo, start: '09:00', duration: 60, people: 8, name: 'Grupo A', activity: { type:'oficina', id:'A1' } },
    // { date: todayDemo, start: '10:00', duration: 60, people: 6, name: 'Grupo B', activity: { type:'oficina', id:'A2' } },
    // { date: todayDemo, start: '11:00', duration: 60, people: 12, name: 'Equipe C', activity: { type:'livre', description:'Prototipagem Rápida', resourceIds:['R11','R12'] } },
    // { date: todayDemo, start: '15:00', duration: 120, people: 10, name: 'Workshop', activity: { type:'oficina', id:'A4' } },
    // );

    // Exceções exemplo:
    // CLOSED_DATES.add('2025-12-25');
    // SPECIAL_CLOSED_INTERVALS_BY_DATE['2025-09-22'] = [{ start: '16:00', end: '18:00' }];
    // SPECIAL_OPENINGS_BY_DATE['2025-09-20'] = [{ start: '09:00', end: '13:00' }];

    <?php
    $buildSpecialIntervals = static function (array $items): array {
      $grouped = [];

      foreach ($items as $item) {
        if (!isset($item->data, $item->horaInicio, $item->horaFim)) {
          continue;
        }

        $date = \DateTime::createFromFormat('d/m/Y', (string) $item->data)
          ?: \DateTime::createFromFormat('Y-m-d', (string) $item->data);

        if ($date === false) {
          continue;
        }

        $isoDate = $date->format('Y-m-d');
        $start = substr((string) $item->horaInicio, 0, 5);
        $end   = substr((string) $item->horaFim, 0, 5);

        $grouped[$isoDate][] = [
          'start' => $start,
          'end'   => $end,
        ];
      }

      return $grouped;
    };

    foreach ($buildSpecialIntervals($vDatasFechado) as $isoDate => $intervals) {
      echo "  SPECIAL_CLOSED_INTERVALS_BY_DATE['{$isoDate}'] = "
        . json_encode($intervals, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        . ";\n";
    }

    foreach ($buildSpecialIntervals($vDatasAberto) as $isoDate => $intervals) {
      echo "  SPECIAL_OPENINGS_BY_DATE['{$isoDate}'] = "
        . json_encode($intervals, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        . ";\n";
    }
    ?>

    setInterval(() => {
      console.log('interval...');
      fetch("<?= base_url(); ?>PainelParticipante/listaReservaJson", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
        })
        .then(response => {
          if (!response.ok) throw new Error("Erro HTTP " + response.status);
          return response.json(); // ou response.text(), depende do que seu controller retorna
        })
        .then(data => {
          reservations = data;
          renderActivitiesUI();
          toggleEscolaSection();
          toggleActivityBlocks();
          renderGroups({
            keepSelections: true
          });
        })
        .catch(error => {
          console.error("Erro na requisição:", error);
        });
    }, 10000);

    renderActivitiesUI();
    toggleEscolaSection();
    toggleActivityBlocks();
    renderGroups({
      keepSelections: false
    });
  </script>
  <?= $this->endSection(); ?>
