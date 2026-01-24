<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Reservas</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Relatório</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- row -->
<div class="container px-0 ">
    <!-- FILTROS -->
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <form id="form-filtros" class="form-inline">
          <div class="form-group">
            <label for="dataInicio" class="mr-2 small text-muted">Data início</label>
            <input type="date" id="dataInicio" class="form-control form-control-sm" />
          </div>
          <div class="form-group">
            <label for="dataFim" class="mr-2 small text-muted">Data fim</label>
            <input type="date" id="dataFim" class="form-control form-control-sm" />
          </div>
          <div class="form-group">
            <label for="agrupamento" class="mr-2 small text-muted">Agrupar por</label>
            <select id="agrupamento" class="form-control form-control-sm">
              <option value="mes">Mês</option>
              <option value="semana">Semana</option>
              <option value="dia">Dia</option>
            </select>
          </div>
          <button class="btn btn-primary btn-sm" type="submit">Aplicar</button>
          <p class="mb-0 ml-auto small text-muted" id="info-periodo"></p>
        </form>
      </div>
    </div>

    <!-- CARDS -->
    <div class="row">
      <!-- Comparecimentos -->
      <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card shadow-sm h-100 card-kpi">
          <div class="card-body">
            <p class="mb-1 text-muted">Comparecimentos</p>
            <h3 id="kpi-comparecimentos-pct">0%</h3>
            <p class="kpi-sub" id="kpi-comparecimentos">0 de 0 reservas compareceram</p>
          </div>
        </div>
      </div>
      <!-- Antecedência média -->
      <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card shadow-sm h-100 card-kpi">
          <div class="card-body">
            <p class="mb-1 text-muted">Antecedência média</p>
            <h3 id="kpi-antecedencia">0h 00m</h3>
            <p class="kpi-sub">diferença entre cadastro e reserva</p>
          </div>
        </div>
      </div>
      <!-- Duração média (reservada) -->
      <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card shadow-sm h-100 card-kpi">
          <div class="card-body">
            <p class="mb-1 text-muted">Duração média (reservada)</p>
            <h3 id="kpi-duracao-reservada">0 min</h3>
            <p class="kpi-sub">hora fim - hora início</p>
          </div>
        </div>
      </div>
      <!-- Duração média (permanência) -->
      <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card shadow-sm h-100 card-kpi">
          <div class="card-body">
            <p class="mb-1 text-muted">Permanência média (real)</p>
            <h3 id="kpi-duracao-real">—</h3>
            <p class="kpi-sub">hora saída - hora entrada</p>
          </div>
        </div>
      </div>
    </div>

    <!-- GRÁFICOS 1: Visitas e Pessoas -->
    <div class="row">
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Número de visitas realizadas</h6>
            <p class="small-muted mb-3">Reservas que compareceram (com hora de entrada) agrupadas pelo período selecionado.</p>
            <div class="chart-container">
              <canvas id="chart-visitas"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Número de pessoas que visitaram</h6>
            <p class="small-muted mb-3">Soma de (convidados + 1) das reservas que compareceram.</p>
            <div class="chart-container">
              <canvas id="chart-pessoas"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- GRÁFICOS 2: Comparecimento / Escolas -->
    <div class="row">
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Comparecidos vs não comparecidos</h6>
            <p class="small-muted mb-3">Mostra a taxa de comparecimento do período.</p>
            <div class="chart-container d-flex align-items-center justify-content-center">
              <canvas id="chart-comparecimento"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Escolas vs não escolas</h6>
            <p class="small-muted mb-3">Compara visitas de turmas escolares com reservas comuns.</p>
            <div class="chart-container d-flex align-items-center justify-content-center">
              <canvas id="chart-escolas"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- GRÁFICOS 3: Turmas por ano + Visitantes por ano -->
    <div class="row">
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Quantidade de turmas por ano</h6>
            <p class="small-muted mb-3">Reservas de escolas agrupadas por ano escolar.</p>
            <div class="chart-container-sm">
              <canvas id="chart-turmas"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Número de visitantes por ano</h6>
            <p class="small-muted mb-3">Soma das pessoas esperadas das reservas de escola por ano escolar.</p>
            <div class="chart-container-sm">
              <canvas id="chart-visitantes-ano"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- GRÁFICOS 4: Horários -->
    <div class="row">
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Pessoas vs horários</h6>
            <p class="small-muted mb-3">Horários do dia x total de pessoas esperadas naquele horário.</p>
            <div class="chart-container">
              <canvas id="chart-pessoas-horario"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Reservas vs horários</h6>
            <p class="small-muted mb-3">Quantidade de reservas iniciando em cada horário.</p>
            <div class="chart-container">
              <canvas id="chart-reservas-horario"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- TABELA: Top escolas -->
    <div class="row">
      <div class="col-lg-12 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Top escolas no período</h6>
            <p class="small-muted mb-3">Agrupadas por nome da escola.</p>
            <div class="table-responsive">
              <table class="table table-sm mb-0" id="tbl-escolas">
                <thead>
                  <tr>
                    <th>Escola</th>
                    <th>Reservas</th>
                    <th>Pessoas</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td colspan="3" class="text-muted small">Sem dados.</td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- row closed -->
<?= $this->endSection('content'); ?>

<?= $this->section('styles'); ?>
<style>
    body {
      background: #f8fafc;
    }
    .small-muted {
      font-size: 0.7rem;
      color: #6c757d;
    }
    .card-title {
      margin-bottom: 0.35rem;
    }
    .chart-container {
      position: relative;
      height: 260px;
    }
    .chart-container-sm {
      position: relative;
      height: 220px;
    }
    .form-inline .form-group {
      margin-right: .75rem;
      margin-bottom: .5rem;
    }
    .card-kpi h3 {
      font-size: 1.6rem;
      margin-bottom: .25rem;
    }
    .kpi-sub {
      font-size: 0.72rem;
      color: #6c757d;
      margin-bottom: 0;
    }
  </style>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    // =========================================================
    // DADOS EXEMPLO (substitua por window.reservasData)
    // =========================================================
    const sampleReservations = [
      {
        dataCadastro: "2024-11-05",
        dataReserva: "2024-11-20",
        horaInicio: "09:00",
        horaFim: "10:00",
        tipo: "exclusiva",
        numeroConvidados: 3,
        status: "confirmada",
        turmaEscola: 1,
        nomeEscola: "Escola Aurora",
        anoTurma: 4,
        horaEntrada: "09:02",
        horaSaida: "10:01"
      },
      {
        dataCadastro: "2025-01-10",
        dataReserva: "2025-01-15",
        horaInicio: "14:00",
        horaFim: "15:30",
        tipo: "compartilhada",
        numeroConvidados: 0,
        status: "confirmada",
        turmaEscola: 0,
        nomeEscola: "",
        anoTurma: 0,
        horaEntrada: "",
        horaSaida: ""
      },
      {
        dataCadastro: "2025-03-02",
        dataReserva: "2025-03-12",
        horaInicio: "08:30",
        horaFim: "10:00",
        tipo: "exclusiva",
        numeroConvidados: 25,
        status: "confirmada",
        turmaEscola: 1,
        nomeEscola: "Colégio Central",
        anoTurma: 7,
        horaEntrada: "08:25",
        horaSaida: "10:05"
      },
      {
        dataCadastro: "2025-03-10",
        dataReserva: "2025-03-20",
        horaInicio: "10:30",
        horaFim: "11:30",
        tipo: "compartilhada",
        numeroConvidados: 1,
        status: "confirmada",
        turmaEscola: 0,
        nomeEscola: "",
        anoTurma: 0,
        horaEntrada: "10:35",
        horaSaida: "11:20"
      },
      {
        dataCadastro: "2025-05-15",
        dataReserva: "2025-05-30",
        horaInicio: "15:00",
        horaFim: "17:00",
        tipo: "exclusiva",
        numeroConvidados: 10,
        status: "confirmada",
        turmaEscola: 0,
        nomeEscola: "",
        anoTurma: 0,
        horaEntrada: "",
        horaSaida: ""
      },
      {
        dataCadastro: "2025-07-01",
        dataReserva: "2025-07-10",
        horaInicio: "09:00",
        horaFim: "12:00",
        tipo: "exclusiva",
        numeroConvidados: 32,
        status: "confirmada",
        turmaEscola: 1,
        nomeEscola: "Escola Horizonte",
        anoTurma: 2,
        horaEntrada: "08:59",
        horaSaida: "12:05"
      },
      {
        dataCadastro: "2025-09-10",
        dataReserva: "2025-09-30",
        horaInicio: "16:00",
        horaFim: "17:00",
        tipo: "compartilhada",
        numeroConvidados: 2,
        status: "confirmada",
        turmaEscola: 0,
        nomeEscola: "",
        anoTurma: 0,
        horaEntrada: "",
        horaSaida: ""
      },
      {
        dataCadastro: "2025-10-01",
        dataReserva: "2025-10-05",
        horaInicio: "11:00",
        horaFim: "12:00",
        tipo: "compartilhada",
        numeroConvidados: 2,
        status: "confirmada",
        turmaEscola: 0,
        nomeEscola: "",
        anoTurma: 0,
        horaEntrada: "11:02",
        horaSaida: "12:02"
      }
    ];

    const RAW_RESERVAS = (window.reservasData && window.reservasData.length) ? window.reservasData : sampleReservations;

    // =========================================================
    // UTILITÁRIOS
    // =========================================================
    function toDateOnly(str){
      const [y,m,d] = str.split("-").map(Number);
      return new Date(y, m-1, d);
    }

    function formatBR(date){
      return date.toLocaleDateString("pt-BR");
    }

    function diffMinutes(h1, h2){
      if(!h1 || !h2) return null;
      const [hA,mA] = h1.split(":").map(Number);
      const [hB,mB] = h2.split(":").map(Number);
      return (hB*60+mB) - (hA*60+mA);
    }

    function minutesToHM(min){
      const h = Math.floor(min/60);
      const m = Math.round(min%60);
      return {h, m};
    }

    function minutesToDH(min){
      const d = Math.floor(min / 1440); // 1440 = 24*60
      const h = Math.floor((min % 1440) / 60);
      return {d, h};
    }

    function getDefaultPeriod(){
      const now = new Date();
      const fim = new Date(now.getFullYear(), now.getMonth()+1, 0);
      const iniYear = now.getFullYear() - 1;
      const iniMonth = now.getMonth() + 1;
      const inicio = new Date(iniYear, iniMonth, 1);
      return {inicio, fim};
    }

    function dateToInputValue(date){
      return date.toISOString().split("T")[0];
    }

    function getWeekKey(date){
      const d = new Date(date.getTime());
      d.setHours(0,0,0,0);
      d.setDate(d.getDate() + 4 - (d.getDay() || 7));
      const yearStart = new Date(d.getFullYear(),0,1);
      const weekNo = Math.ceil((((d - yearStart) / 86400000) + 1)/7);
      return d.getFullYear() + "-S" + String(weekNo).padStart(2,"0");
    }

    function getMonthKey(date){
      return date.getFullYear() + "-" + String(date.getMonth()+1).padStart(2,"0");
    }

    function getDayKey(date){
      return date.toISOString().split("T")[0];
    }

    function makeLabelFromKey(key, mode){
      if(mode === "mes"){
        const [y,m] = key.split("-").map(Number);
        return String(m).padStart(2,"0") + "/" + y;
      }
      if(mode === "semana"){
        return key.replace("-", " ");
      }
      return formatBR(new Date(key));
    }

    function filterByPeriod(data, dataInicio, dataFim){
      return data.filter(r => {
        const d = toDateOnly(r.dataReserva);
        return d >= dataInicio && d <= dataFim;
      });
    }

    function groupByPeriod(data, mode, filterFn){
      const map = {};
      data.forEach(r => {
        if(filterFn && !filterFn(r)) return;
        const d = toDateOnly(r.dataReserva);
        let key;
        if(mode === "semana") key = getWeekKey(d);
        else if(mode === "dia") key = getDayKey(d);
        else key = getMonthKey(d);
        if(!map[key]) map[key] = [];
        map[key].push(r);
      });
      const sortedKeys = Object.keys(map).sort();
      return {keys: sortedKeys, groups: map};
    }

    // =========================================================
    // CHARTS
    // =========================================================
    const charts = {};

    // plugin pra desenhar % em pizza/donut
    const pieLabelPlugin = {
      id: 'pieLabel',
      afterDraw(chart, args, opts) {
        if (!opts || !opts.enabled) return;
        const {ctx} = chart;
        const dataset = chart.data.datasets[0];
        const total = dataset.data.reduce((a,b)=>a+b,0);
        const meta = chart.getDatasetMeta(0);
        meta.data.forEach((arc, index) => {
          const value = dataset.data[index];
          if(!value) return;
          const pct = total ? Math.round(value/total*100) + '%' : '0%';
          const pos = arc.tooltipPosition();
          ctx.save();
          ctx.fillStyle = opts.color || '#0f172a';
          ctx.font = (opts.fontSize || 12) + 'px sans-serif';
          ctx.textAlign = 'center';
          ctx.textBaseline = 'middle';
          ctx.fillText(pct, pos.x, pos.y);
          ctx.restore();
        });
      }
    };

    Chart.register(pieLabelPlugin);

    function createOrUpdateChart(id, config){
      if(charts[id]){
        charts[id].destroy();
      }
      charts[id] = new Chart(document.getElementById(id).getContext("2d"), config);
    }

    // =========================================================
    // RENDER PRINCIPAL
    // =========================================================
    function renderDashboard(){
      const di = toDateOnly(document.getElementById("dataInicio").value);
      const df = toDateOnly(document.getElementById("dataFim").value);
      const agrup = document.getElementById("agrupamento").value;

      const reservas = filterByPeriod(RAW_RESERVAS, di, df);
      document.getElementById("info-periodo").textContent = "Período: " + formatBR(di) + " a " + formatBR(df);
      

      // ========= CARDS =========
      const total = reservas.length;
      const comparecidas = reservas.filter(r => r.horaEntrada && r.horaEntrada !== "");
      const naoComparecidas = total - comparecidas.length;
      const taxa = total ? (comparecidas.length / total * 100) : 0;

      // 1) porcentagem grande, texto pequeno
      document.getElementById("kpi-comparecimentos-pct").textContent = taxa.toFixed(0) + "%";
      document.getElementById("kpi-comparecimentos").textContent =
        comparecidas.length + " de " + total + " reservas compareceram";

      // antecedência média (em minutos)
      const antecedencias = reservas.map(r => {
        const dc = new Date(r.dataCadastro + "T00:00:00");
        const dr = toDateOnly(r.dataReserva);
        if(r.horaInicio){
          const [h,m] = r.horaInicio.split(":").map(Number);
          dr.setHours(h, m, 0, 0);
        }
        const diffMs = dr - dc;
        return diffMs / 60000;
      }).filter(v => v >= 0);

      let antStr = "0h 00m";
      if(antecedencias.length){
        const mediaMin = antecedencias.reduce((a,b)=>a+b,0) / antecedencias.length;
        if(mediaMin >= 1440){
          const {d,h} = minutesToDH(mediaMin);
          antStr = d + "d " + h + "h";
        } else {
          const {h,m} = minutesToHM(mediaMin);
          antStr = h + "h " + String(m).padStart(2,"0") + "m";
        }
      }
      document.getElementById("kpi-antecedencia").textContent = antStr;

      // duração reservada média
      const durReservadas = reservas.map(r => diffMinutes(r.horaInicio, r.horaFim)).filter(v => v !== null && v > 0);
      const durReservadaMedia = durReservadas.length ? (durReservadas.reduce((a,b)=>a+b,0) / durReservadas.length) : 0;
      document.getElementById("kpi-duracao-reservada").textContent = durReservadaMedia.toFixed(0) + " min";

      // duração real
      const durReais = reservas.map(r => diffMinutes(r.horaEntrada, r.horaSaida)).filter(v => v !== null && v > 0);
      if(durReais.length){
        const durRealMedia = durReais.reduce((a,b)=>a+b,0) / durReais.length;
        document.getElementById("kpi-duracao-real").textContent = durRealMedia.toFixed(0) + " min";
      } else {
        document.getElementById("kpi-duracao-real").textContent = "—";
      }

      // ========= GRÁFICO: Número de visitas realizadas =========
      const visitasGroup = groupByPeriod(reservas, agrup, r => r.horaEntrada && r.horaEntrada !== "");
      const visitasLabels = visitasGroup.keys.map(k => makeLabelFromKey(k, agrup));
      const visitasData = visitasGroup.keys.map(k => visitasGroup.groups[k].length);

      createOrUpdateChart("chart-visitas", {
        type: "line",
        data: {
          labels: visitasLabels,
          datasets: [{
            label: "Visitas",
            data: visitasData,
            borderWidth: 2,
            tension: 0.3
          }]
        },
        options: {
          responsive: true,
          plugins: { legend: { display: false } },
          scales: { y: { beginAtZero: true, ticks: { precision:0 } } }
        }
      });

      // ========= GRÁFICO: Número de pessoas que visitaram =========
      const pessoasData = visitasGroup.keys.map(k => {
        return visitasGroup.groups[k].reduce((acc, r) => acc + ((r.numeroConvidados || 0) + 1), 0);
      });

      createOrUpdateChart("chart-pessoas", {
        type: "bar",
        data: {
          labels: visitasLabels,
          datasets: [{
            label: "Pessoas",
            data: pessoasData,
            borderWidth: 1
          }]
        },
        options: {
          plugins: { legend: { display: false } },
          scales: { y: { beginAtZero: true } }
        }
      });

      // ========= GRÁFICO: Comparecidos vs não comparecidos (pizza com %) =========
      createOrUpdateChart("chart-comparecimento", {
        type: "pie",
        data: {
          labels: ["Compareceram", "Não compareceram"],
          datasets: [{
            data: [comparecidas.length, naoComparecidas],
            borderWidth: 1,
            // backgroundColor: ["#2563eb", "#94a3b8"]
          }]
        },
        options: {
          plugins: {
            legend: {
              position: "bottom",
              labels: {
                generateLabels: function(chart){
                  const data = chart.data;
                  const ds = data.datasets[0];
                  const total = ds.data.reduce((a,b)=>a+b,0);
                  return data.labels.map((label, i) => {
                    const value = ds.data[i];
                    const bg = ds.backgroundColor[i];
                    const pct = total ? Math.round(value/total*100) : 0;
                    return {
                      text: label + " ("+ value +")",
                      fillStyle: bg,
                      strokeStyle: "#fff",
                      lineWidth: 1
                    };
                  });
                }
              }
            },
            pieLabel: {
              enabled: true,
              fontSize: 12,
              color: "#0f172a"
            }
          }
        }
      });

      // ========= GRÁFICO: Escolas vs não escolas (pizza com %) =========
      const escolas = reservas.filter(r => r.turmaEscola == 1).length;
      const naoEscolas = reservas.length - escolas;

      createOrUpdateChart("chart-escolas", {
        type: "pie",
        data: {
          labels: ["Escolas", "Não escolas"],
          datasets: [{
            data: [escolas, naoEscolas],
            borderWidth: 1,
            // backgroundColor: ["#0f766e", "#94a3b8"]
          }]
        },
        options: {
          plugins: {
            legend: {
              position: "bottom",
              labels: {
                generateLabels: function(chart){
                  const data = chart.data;
                  const ds = data.datasets[0];
                  const total = ds.data.reduce((a,b)=>a+b,0);
                  return data.labels.map((label, i) => {
                    const value = ds.data[i];
                    const bg = ds.backgroundColor[i];
                    const pct = total ? Math.round(value/total*100) : 0;
                    return {
                      text: label + " ("+value+")",
                      fillStyle: bg,
                      strokeStyle: "#fff",
                      lineWidth: 1
                    };
                  });
                }
              }
            },
            pieLabel: {
              enabled: true,
              fontSize: 12,
              color: "#0f172a"
            }
          }
        }
      });

      // ========= GRÁFICO: Quantidade de turmas por ano =========
      const turmas = reservas.filter(r => r.turmaEscola == 1);
      const anos = Array.from({length: 9}, (_,i) => i);
      const turmasData = anos.map(a => turmas.filter(t => t.anoTurma == a).length);
      createOrUpdateChart("chart-turmas", {
        type: "bar",
        data: {
          labels: anos.map(a => (a+1) + "º"),
          datasets: [{
            label: "Reservas",
            data: turmasData,
            borderWidth: 1
          }]
        },
        options: {
          plugins: { legend: { display: false } },
          scales: { y: { beginAtZero: true, ticks: { precision:0 } } }
        }
      });

      // ========= GRÁFICO: Número de visitantes por ano =========
      const visitantesAnoData = anos.map(a => {
        return turmas
          .filter(t => t.anoTurma == a)
          .reduce((acc, r) => acc + ((r.numeroConvidados || 0) + 1), 0);
      });
      createOrUpdateChart("chart-visitantes-ano", {
        type: "bar",
        data: {
          labels: anos.map(a => (a+1) + "º"),
          datasets: [{
            label: "Pessoas",
            data: visitantesAnoData,
            borderWidth: 1
          }]
        },
        options: {
          plugins: { legend: { display: false } },
          scales: { y: { beginAtZero: true, ticks: { precision:0 } } }
        }
      });

      // ========= GRÁFICO: Pessoas vs horários =========
      const pessoasHorarioMap = {};
      reservas.forEach(r => {
        const h = r.horaInicio || "00:00";
        const pessoas = (r.numeroConvidados || 0) + 1;
        pessoasHorarioMap[h] = (pessoasHorarioMap[h] || 0) + pessoas;
      });
      const horariosOrdenados = Object.keys(pessoasHorarioMap).sort();
      createOrUpdateChart("chart-pessoas-horario", {
        type: "bar",
        data: {
          labels: horariosOrdenados,
          datasets: [{
            label: "Pessoas",
            data: horariosOrdenados.map(h => pessoasHorarioMap[h]),
            borderWidth: 1
          }]
        },
        options: {
          plugins: { legend: { display: false } },
          scales: { y: { beginAtZero: true } }
        }
      });

      // ========= GRÁFICO: Reservas vs horários =========
      const reservasHorarioMap = {};
      reservas.forEach(r => {
        const h = r.horaInicio || "00:00";
        reservasHorarioMap[h] = (reservasHorarioMap[h] || 0) + 1;
      });
      const horariosReservas = Object.keys(reservasHorarioMap).sort();
      createOrUpdateChart("chart-reservas-horario", {
        type: "bar",
        data: {
          labels: horariosReservas,
          datasets: [{
            label: "Reservas",
            data: horariosReservas.map(h => reservasHorarioMap[h]),
            borderWidth: 1
          }]
        },
        options: {
          plugins: { legend: { display: false } },
          scales: { y: { beginAtZero: true, ticks: { precision:0 } } }
        }
      });

      // ========= TABELA: Top escolas =========
      const tblEscolasBody = document.querySelector("#tbl-escolas tbody");
      tblEscolasBody.innerHTML = "";
      const escolasAgg = {};
      reservas.filter(r => r.turmaEscola == 1).forEach(r => {
        const nome = r.nomeEscola || "Escola (sem nome)";
        if(!escolasAgg[nome]) escolasAgg[nome] = {reservas:0, pessoas:0};
        escolasAgg[nome].reservas += 1;
        escolasAgg[nome].pessoas += ((r.numeroConvidados || 0) + 1);
      });
      const escolasArr = Object.entries(escolasAgg).sort((a,b)=>b[1].reservas - a[1].reservas).slice(0,10);
      if(escolasArr.length){
        escolasArr.forEach(([nome,info])=>{
          const tr = document.createElement("tr");
          tr.innerHTML = `<td>${nome}</td><td>${info.reservas}</td><td>${info.pessoas}</td>`;
          tblEscolasBody.appendChild(tr);
        });
      } else {
        const tr = document.createElement("tr");
        tr.innerHTML = `<td colspan="3" class="text-muted small">Sem dados.</td>`;
        tblEscolasBody.appendChild(tr);
      }
    }

    // =========================================================
    // INIT
    // =========================================================
    (function init(){
      const {inicio, fim} = getDefaultPeriod();
      document.getElementById("dataInicio").value = dateToInputValue(inicio);
      document.getElementById("dataFim").value = dateToInputValue(fim);

      document.getElementById("form-filtros").addEventListener("submit", function(e){
        e.preventDefault();
        renderDashboard();
      });

      renderDashboard();
    })();
  </script>

<?= $this->endSection(); ?>
