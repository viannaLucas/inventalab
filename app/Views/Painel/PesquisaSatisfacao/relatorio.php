<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Pesquisa de Satisfação</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Relatório</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<!-- row -->
<div class="container px-0 ">
    <!-- CARDS GERAIS -->
    <div class="row">
      <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <p class="mb-1 text-muted">Total de respostas</p>
            <h3 id="card-total-respostas" class="mb-0">0</h3>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <p class="mb-1 text-muted">Taxa de resposta</p>
            <h3 id="card-taxa-resposta" class="mb-0">0%</h3>
            <p class="small text-muted mb-0">respondidas / enviadas</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <p class="mb-1 text-muted">Média geral</p>
            <h3 id="card-media-geral" class="mb-0">0.0</h3>
            <p class="small text-muted mb-0">média das 3 notas</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <p class="mb-1 text-muted">Última resposta</p>
            <h5 id="card-ultima-resposta" class="mb-0">--</h5>
            <p class="small text-muted mb-0">dataResposta mais recente</p>
          </div>
        </div>
      </div>
    </div>

    <!-- GRAFICOS PRINCIPAIS -->
    <div class="row">
      <!-- Comparativo de áreas -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Comparativo de Áreas (média)</h6>
            <p class="small-muted mb-3">Compara a nota média das três dimensões avaliadas para identificar rapidamente qual está melhor ou pior.</p>
            <canvas id="barAreas"></canvas>
          </div>
        </div>
      </div>

      <!-- Distribuição 0-10 -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Distribuição de notas (0–10)</h6>
            <p class="small-muted mb-3">Mostra quantas respostas ficaram em cada nota, ajudando a ver se há concentração em notas altas ou baixas.</p>
            <canvas id="barDistribuicao"></canvas>
          </div>
        </div>
      </div>

      <!-- Evolução -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Evolução mensal das médias</h6>
            <p class="small-muted mb-3">Exibe a tendência das notas ao longo dos meses para acompanhar melhorias ou quedas.</p>
            <canvas id="lineEvolucao"></canvas>
          </div>
        </div>
      </div>

      <!-- Respondido x não respondido (AJUSTADO) -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Respondido x Não Respondido</h6>
            <p class="small-muted mb-3">Indica o quanto da pesquisa foi de fato respondida em relação ao que foi enviado.</p>
            <div class="d-flex align-items-center">
              <div style="width: 45%; min-width: 180px;">
                <canvas id="pieRespondido"></canvas>
              </div>
              <div class="pl-3">
                <!-- apenas o texto informativo -->
                <p class="mb-1 font-weight-bold" id="info-respondido-title">Resumo</p>
                <p class="small text-muted mb-0" id="info-respondido"></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Envios x Respostas geral -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Envios x Respostas (geral)</h6>
            <p class="small-muted mb-3">Compara ao longo do tempo quantas pesquisas foram enviadas e quantas voltaram respondidas.</p>
            <canvas id="lineEnvios"></canvas>
          </div>
        </div>
      </div>

      <!-- Média da pontuação -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Média da pontuação</h6>
            <p class="small-muted mb-3">Representação visual do quanto a média atual está distante da nota máxima (10).</p>
            <div class="d-flex align-items-center">
              <div style="width: 45%;">
                <canvas id="doughnutMedia"></canvas>
              </div>
              <div class="pl-3">
                <p class="mb-1 small text-muted">Meta: 10</p>
                <h3 id="texto-media-pontuacao" class="mb-1">0.0</h3>
                <p class="small text-muted mb-0">representação visual da média</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- COMPARATIVO DE PERÍODOS -->
    <div class="row">
      <div class="col-12 mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title mb-1">Comparar períodos</h5>
            <p class="small-muted mb-4">Selecione dois intervalos para comparar notas, engajamento e temas de sugestões.</p>
            <div class="row">
              <div class="col-md-6 mb-3">
                <p class="small text-uppercase text-muted mb-2">Período A</p>
                <div class="form-row">
                  <div class="col">
                    <label class="small text-muted">De</label>
                    <input id="dataADe" type="date" class="form-control form-control-sm" />
                  </div>
                  <div class="col">
                    <label class="small text-muted">Até</label>
                    <input id="dataAAte" type="date" class="form-control form-control-sm" />
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <p class="small text-uppercase text-muted mb-2">Período B</p>
                <div class="form-row">
                  <div class="col">
                    <label class="small text-muted">De</label>
                    <input id="dataBDe" type="date" class="form-control form-control-sm" />
                  </div>
                  <div class="col">
                    <label class="small text-muted">Até</label>
                    <input id="dataBAte" type="date" class="form-control form-control-sm" />
                  </div>
                </div>
              </div>
            </div>
            <button onclick="aplicarComparacao()" class="btn btn-dark btn-sm mt-2">Aplicar comparação</button>
            <p class="small text-muted mt-2 mb-0">(No exemplo os dados são mock. Aqui você faria a consulta ao backend usando essas datas.)</p>
          </div>
        </div>
      </div>
    </div>

    <!-- CARDS COMPARATIVOS -->
    <div class="row">
      <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <p class="small text-muted mb-1">Média geral (Período A)</p>
            <h4 id="cmp-media-a" class="mb-0">0.0</h4>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <p class="small text-muted mb-1">Média geral (Período B)</p>
            <h4 id="cmp-media-b" class="mb-0">0.0</h4>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <p class="small text-muted mb-1">Variação (pts)</p>
            <h4 id="cmp-variacao-abs" class="mb-0 text-success">0.0</h4>
            <!-- se fosse negativo: <h4 class="mb-0 text-danger">-0.3</h4> -->
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <p class="small text-muted mb-1">Variação (%)</p>
            <h4 id="cmp-variacao-pct" class="mb-0 text-success">0%</h4>
            <!-- se fosse negativo: <h4 class="mb-0 text-danger">-2.5%</h4> -->
          </div>
        </div>
      </div>
    </div>

    <!-- GRÁFICOS COMPARATIVOS -->
    <div class="row">
      <!-- Barras lado a lado -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Notas por pergunta - Período A x B</h6>
            <p class="small-muted mb-3">Mostra a média de cada pergunta em cada período para ver onde houve melhora ou queda.</p>
            <canvas id="barAreasComparativo"></canvas>
          </div>
        </div>
      </div>

      <!-- Distribuição A x B -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Distribuição de notas (0–10) - A x B</h6>
            <p class="small-muted mb-3">Compara a forma como as notas se distribuíram em cada período.</p>
            <canvas id="barDistribuicaoComparativo"></canvas>
          </div>
        </div>
      </div>

      <!-- Envios x respostas por período -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Envios x Respostas (por período)</h6>
            <p class="small-muted mb-3">Mostra se os períodos tiveram volumes parecidos de envio e resposta.</p>
            <canvas id="lineEnviosComparativo"></canvas>
          </div>
        </div>
      </div>

      <!-- Tabela de variação -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="card-title">Tabela de variação de métricas</h6>
            <p class="small-muted mb-3">Resumo dos valores de cada período com destaque para a diferença.</p>
            <!-- Dif. verde quando positivo e vermelho quando negativo. -->
            <div class="table-responsive">
              <table class="table table-sm mb-0">
                <thead class="thead-light">
                  <tr>
                    <th>Métrica</th>
                    <th>Período A</th>
                    <th>Período B</th>
                    <th>Dif.</th>
                  </tr>
                </thead>
                <tbody id="tabela-variacao">
                  <!-- linhas via JS -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Ranking de temas -->
    <div class="row">
      <div class="col-12 mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Ranking de temas (respostas abertas) - A x B</h6>
            <p class="small-muted mb-3">Compara os assuntos mais citados em cada período para orientar ações.</p>
            <div class="row" id="ranking-temas">
              <!-- preenchido via JS -->
            </div>
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
    .card-title {
        margin-bottom: 0.25rem;
    }
    .small-muted {
        font-size: 0.7rem;
        color: #6c757d;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ==========================================================
    // DADOS GERAIS (mock)
    // ==========================================================
    const totalRespostas = 42;
    const totalEnviadas = 60;
    const taxaResposta = totalRespostas / totalEnviadas * 100;
    const mediaUsoGeral = 8.1;
    const mediaAtendimento = 9.0;
    const mediaEquipamentos = 7.4;
    const mediaGeral = ((mediaUsoGeral + mediaAtendimento + mediaEquipamentos) / 3).toFixed(1);
    const ultimaResposta = '2025-11-05';

    const labelsNotas = ['0','1','2','3','4','5','6','7','8','9','10'];
    const distUsoGeral = [0,0,1,0,2,3,4,6,10,9,7];
    const distAtendimento = [0,0,0,1,1,2,3,4,9,10,12];
    const distEquip = [0,1,1,2,3,4,5,5,7,6,3];

    const labelsMeses = ['Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov'];
    const evolucaoUso = [7.5, 7.8, 8.0, 8.1, 8.2, 8.0, 8.1];
    const evolucaoAtendimento = [8.6, 8.8, 8.9, 9.0, 9.1, 9.0, 9.0];
    const evolucaoEquip = [6.8, 7.0, 7.2, 7.5, 7.3, 7.4, 7.4];

    const qtdRespondido = totalRespostas;
    const qtdNaoRespondido = totalEnviadas - totalRespostas;

    const enviosPorMes = [8, 10, 9, 11, 10, 6, 6];
    const respostasPorMes = [6, 8, 7, 9, 7, 3, 2];

    // popula cards
    document.getElementById('card-total-respostas').textContent = totalRespostas;
    document.getElementById('card-taxa-resposta').textContent = taxaResposta.toFixed(1) + '%';
    document.getElementById('card-media-geral').textContent = mediaGeral;
    document.getElementById('card-ultima-resposta').textContent = ultimaResposta;
    document.getElementById('texto-media-pontuacao').textContent = mediaGeral;

    // ==========================================================
    // GRÁFICOS GERAIS
    // ==========================================================
    new Chart(document.getElementById('barAreas'), {
      type: 'bar',
      data: {
        labels: ['Uso geral', 'Atendimento', 'Equipamentos'],
        datasets: [{
          label: 'Nota média',
          data: [mediaUsoGeral, mediaAtendimento, mediaEquipamentos],
          backgroundColor: ['#0f766e', '#2563eb', '#f97316']
        }]
      },
      options: {
        scales: { y: { beginAtZero: true, max: 10 } }
      }
    });

    new Chart(document.getElementById('barDistribuicao'), {
      type: 'bar',
      data: {
        labels: labelsNotas,
        datasets: [
          { label: 'Uso geral', data: distUsoGeral, backgroundColor: '#0f766e' },
          { label: 'Atendimento', data: distAtendimento, backgroundColor: '#2563eb' },
          { label: 'Equipamentos', data: distEquip, backgroundColor: '#f97316' }
        ]
      },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
      }
    });

    new Chart(document.getElementById('lineEvolucao'), {
      type: 'line',
      data: {
        labels: labelsMeses,
        datasets: [
          { label: 'Uso geral', data: evolucaoUso, borderColor: '#0f766e', backgroundColor: '#0f766e', tension: 0.3 },
          { label: 'Atendimento', data: evolucaoAtendimento, borderColor: '#2563eb', backgroundColor: '#2563eb', tension: 0.3 },
          { label: 'Equipamentos', data: evolucaoEquip, borderColor: '#f97316', backgroundColor: '#f97316', tension: 0.3 }
        ]
      },
      options: {
        scales: { y: { beginAtZero: true, max: 10 } }
      }
    });

        // RESPONDIDO x NAO RESPONDIDO 
    const ctxPie = document.getElementById('pieRespondido');
    new Chart(ctxPie, {
      type: 'doughnut',
      data: {
        labels: ['Respondido', 'Não respondido'],
        datasets: [{
          data: [totalRespostas, totalEnviadas - totalRespostas],
          backgroundColor: ['#22c55e', '#e11d48']
        }]
      },
      options: {
        legend: {
          display: true,
          position: 'top'
        },
        cutoutPercentage: 55
      }
    });
    document.getElementById('info-respondido').textContent =
        totalEnviadas + ' enviadas, sendo '+
            totalRespostas + ' respondidas (' + taxaResposta.toFixed(1) + '%).';

    new Chart(document.getElementById('lineEnvios'), {
      type: 'line',
      data: {
        labels: labelsMeses,
        datasets: [
          { label: 'Envios', data: enviosPorMes, borderColor: '#94a3b8', backgroundColor: '#94a3b8', tension: 0.3, fill: false },
          { label: 'Respostas', data: respostasPorMes, borderColor: '#0f766e', backgroundColor: '#0f766e', tension: 0.3, fill: false }
        ]
      },
      options: {
        scales: { y: { beginAtZero: true } }
      }
    });

    new Chart(document.getElementById('doughnutMedia'), {
      type: 'doughnut',
      data: {
        labels: ['Média', 'Restante até 10'],
        datasets: [{ data: [mediaGeral, 10 - mediaGeral], backgroundColor: ['#2563eb', '#e2e8f0'] }]
      },
      options: {
        cutoutPercentage: 60,
        legend: { display: false }
      }
    });

    // ==========================================================
    // MOCK COMPARATIVO
    // ==========================================================
    const periodoA = {
      nome: 'Período A',
      mediaUso: 8.0,
      mediaAtendimento: 9.2,
      mediaEquip: 7.0,
      totalRespostas: 30,
      totalEnviadas: 40,
      distribuicao: {
        uso: [0,0,1,0,2,3,3,5,7,6,3],
        atendimento: [0,0,0,1,0,2,2,4,6,9,6],
        equip: [0,1,1,2,3,4,4,4,5,4,2]
      },
      envios: [6, 7, 5, 8, 6, 4, 4],
      respostas: [5, 6, 4, 7, 5, 2, 1],
      temas: [
        { tema: 'Mais oficinas', qtd: 6 },
        { tema: 'Equipamentos', qtd: 4 },
        { tema: 'Horário', qtd: 3 }
      ]
    };

    const periodoB = {
      nome: 'Período B',
      mediaUso: 7.6,
      mediaAtendimento: 9.4,
      mediaEquip: 7.5,
      totalRespostas: 26,
      totalEnviadas: 35,
      distribuicao: {
        uso: [0,0,0,0,1,3,4,5,6,5,2],
        atendimento: [0,0,0,0,1,1,2,3,5,8,6],
        equip: [0,0,1,1,2,3,4,5,6,6,3]
      },
      envios: [5, 8, 6, 7, 7, 3, 3],
      respostas: [4, 7, 5, 6, 6, 3, 2],
      temas: [
        { tema: 'Equipamentos', qtd: 7 },
        { tema: 'Espaço físico', qtd: 4 },
        { tema: 'Mais oficinas', qtd: 2 }
      ]
    };

    let chartBarAreasComp, chartBarDistComp, chartLineEnviosComp;

    function renderTabelaVariacao(pA, pB) {
      const tbody = document.getElementById('tabela-variacao');
      tbody.innerHTML = '';

      const linhas = [
        { nome: 'Média - Uso geral', a: pA.mediaUso, b: pB.mediaUso },
        { nome: 'Média - Atendimento', a: pA.mediaAtendimento, b: pB.mediaAtendimento },
        { nome: 'Média - Equipamentos', a: pA.mediaEquip, b: pB.mediaEquip },
        { nome: 'Taxa de resposta (%)', a: (pA.totalRespostas / pA.totalEnviadas) * 100, b: (pB.totalRespostas / pB.totalEnviadas) * 100 }
      ];

      linhas.forEach(l => {
        const diff = l.b - l.a;
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${l.nome}</td>
          <td>${l.a.toFixed(1)}</td>
          <td>${l.b.toFixed(1)}</td>
          <td class="${diff >= 0 ? 'text-success' : 'text-danger'} font-weight-bold">${diff.toFixed(1)}</td>
        `;
        tbody.appendChild(tr);
      });
    }

    function renderRankingTemas(pA, pB) {
      const container = document.getElementById('ranking-temas');
      container.innerHTML = `
        <div class="col-md-6 mb-3">
          <p class="small text-muted mb-2">${pA.nome}</p>
          <ul class="list-group list-group-flush">
            ${pA.temas.map(t => `<li class="list-group-item d-flex justify-content-between align-items-center px-0">${t.tema}<span class="badge badge-primary badge-pill">${t.qtd}</span></li>`).join('')}
          </ul>
        </div>
        <div class="col-md-6 mb-3">
          <p class="small text-muted mb-2">${pB.nome}</p>
          <ul class="list-group list-group-flush">
            ${pB.temas.map(t => `<li class="list-group-item d-flex justify-content-between align-items-center px-0">${t.tema}<span class="badge badge-primary badge-pill">${t.qtd}</span></li>`).join('')}
          </ul>
        </div>
      `;
    }

    function aplicarComparacao() {
      const pA = periodoA;
      const pB = periodoB;

      const mediaA = (pA.mediaUso + pA.mediaAtendimento + pA.mediaEquip) / 3;
      const mediaB = (pB.mediaUso + pB.mediaAtendimento + pB.mediaEquip) / 3;
      const variacaoAbs = mediaB - mediaA;
      const variacaoPct = mediaA > 0 ? (variacaoAbs / mediaA) * 100 : 0;

      document.getElementById('cmp-media-a').textContent = mediaA.toFixed(1);
      document.getElementById('cmp-media-b').textContent = mediaB.toFixed(1);

      const elAbs = document.getElementById('cmp-variacao-abs');
      const elPct = document.getElementById('cmp-variacao-pct');

      elAbs.textContent = variacaoAbs.toFixed(1);
      elPct.textContent = variacaoPct.toFixed(1) + '%';

      elAbs.classList.remove('text-success', 'text-danger');
      elPct.classList.remove('text-success', 'text-danger');
      if (variacaoAbs >= 0) {
        elAbs.classList.add('text-success');
        elPct.classList.add('text-success');
      } else {
        elAbs.classList.add('text-danger');
        elPct.classList.add('text-danger');
      }

      // barras comparativas
      const ctx1 = document.getElementById('barAreasComparativo');
      if (chartBarAreasComp) chartBarAreasComp.destroy();
      chartBarAreasComp = new Chart(ctx1, {
        type: 'bar',
        data: {
          labels: ['Uso geral', 'Atendimento', 'Equipamentos'],
          datasets: [
            { label: 'Per. A', data: [pA.mediaUso, pA.mediaAtendimento, pA.mediaEquip], backgroundColor: '#0f766e' },
            { label: 'Per. B', data: [pB.mediaUso, pB.mediaAtendimento, pB.mediaEquip], backgroundColor: '#2563eb' }
          ]
        },
        options: { scales: { y: { beginAtZero: true, max: 10 } } }
      });

      // distribuição comparativa
      const ctx2 = document.getElementById('barDistribuicaoComparativo');
      if (chartBarDistComp) chartBarDistComp.destroy();
      chartBarDistComp = new Chart(ctx2, {
        type: 'bar',
        data: {
          labels: labelsNotas,
          datasets: [
            { label: 'Per. A - Uso', data: pA.distribuicao.uso, backgroundColor: 'rgba(15,118,110,0.7)' },
            { label: 'Per. B - Uso', data: pB.distribuicao.uso, backgroundColor: 'rgba(37,99,235,0.7)' },
            { label: 'Per. A - Atendimento', data: pA.distribuicao.atendimento, backgroundColor: 'rgba(15,118,110,0.3)' },
            { label: 'Per. B - Atendimento', data: pB.distribuicao.atendimento, backgroundColor: 'rgba(37,99,235,0.3)' },
            { label: 'Per. A - Equipamentos', data: pA.distribuicao.equip, backgroundColor: 'rgba(249,115,22,0.5)' },
            { label: 'Per. B - Equipamentos', data: pB.distribuicao.equip, backgroundColor: 'rgba(148,163,184,0.8)' }
          ]
        },
        options: {
          responsive: true,
          scales: { y: { beginAtZero: true } },
          legend: { position: 'bottom' }
        }
      });

      // envios comparativo
      const ctx3 = document.getElementById('lineEnviosComparativo');
      if (chartLineEnviosComp) chartLineEnviosComp.destroy();
      chartLineEnviosComp = new Chart(ctx3, {
        type: 'line',
        data: {
          labels: labelsMeses,
          datasets: [
            { label: 'Per. A - Envios', data: pA.envios, borderColor: '#94a3b8', fill: false, tension: 0.3 },
            { label: 'Per. A - Respostas', data: pA.respostas, borderColor: '#0f766e', fill: false, tension: 0.3 },
            { label: 'Per. B - Envios', data: pB.envios, borderColor: '#f97316', fill: false, tension: 0.3 },
            { label: 'Per. B - Respostas', data: pB.respostas, borderColor: '#2563eb', fill: false, tension: 0.3 }
          ]
        },
        options: {
          responsive: true,
          scales: { y: { beginAtZero: true } },
          legend: { position: 'bottom' }
        }
      });

      renderTabelaVariacao(pA, pB);
      renderRankingTemas(pA, pB);
    }

    // chama inicialmente
    aplicarComparacao();
  </script>
<?= $this->endSection(); ?>