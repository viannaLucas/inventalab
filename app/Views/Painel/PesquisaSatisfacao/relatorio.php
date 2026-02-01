<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Pesquisa de Satisfação</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Relatório</span>
        </div>
        <p class="small text-muted mb-0" id="info-periodo-relatorio"></p>
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
            <p class="small text-muted mt-2 mb-0" id="info-comparacao"></p>
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
  window.pesquisaRelatorioData = <?= json_encode($relatorioData ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
  window.pesquisaRelatorioEndpoint = "<?= base_url('PesquisaSatisfacao/relatorioDados') ?>";
</script>
<script>
    const labelsNotasPadrao = ['0','1','2','3','4','5','6','7','8','9','10'];
    let chartBarAreas, chartBarDistribuicao, chartLineEvolucao, chartPieRespondido, chartLineEnvios, chartDoughnutMedia;
    let chartBarAreasComp, chartBarDistComp, chartLineEnviosComp;

    function getLabelsNotas(labels){
      return Array.isArray(labels) && labels.length ? labels : labelsNotasPadrao;
    }

    function setChart(instance, canvasId, config){
      const ctx = document.getElementById(canvasId);
      if (!ctx) return instance;
      if (instance) instance.destroy();
      return new Chart(ctx, config);
    }

    function formatDateBR(dateStr){
      if (!dateStr) return '--';
      if (/^\d{2}\/\d{2}\/\d{4}$/.test(dateStr)) return dateStr;
      if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) {
        const [y,m,d] = dateStr.split('-');
        return `${d}/${m}/${y}`;
      }
      const date = new Date(dateStr);
      if (Number.isNaN(date.getTime())) return '--';
      const d = String(date.getDate()).padStart(2, '0');
      const m = String(date.getMonth() + 1).padStart(2, '0');
      const y = date.getFullYear();
      return `${d}/${m}/${y}`;
    }

    function renderGeral(data){
      const totalRespostas = Number(data.totalRespostas || 0);
      const totalEnviadas = Number(data.totalEnviadas || 0);
      const taxaResposta = totalEnviadas > 0 ? (totalRespostas / totalEnviadas) * 100 : 0;
      const mediaUsoGeral = Number(data.mediaUso || 0);
      const mediaAtendimento = Number(data.mediaAtendimento || 0);
      const mediaEquipamentos = Number(data.mediaEquip || 0);
      const mediaGeral = Number(data.mediaGeral || 0);
      const ultimaResposta = formatDateBR(data.ultimaResposta);

      const labelsNotas = getLabelsNotas(data.labelsNotas);
      const distUsoGeral = Array.isArray(data.distUso) ? data.distUso : new Array(11).fill(0);
      const distAtendimento = Array.isArray(data.distAtendimento) ? data.distAtendimento : new Array(11).fill(0);
      const distEquip = Array.isArray(data.distEquip) ? data.distEquip : new Array(11).fill(0);

      const labelsMeses = Array.isArray(data.labelsMeses) ? data.labelsMeses : [];
      const evolucaoUso = Array.isArray(data.evolucaoUso) ? data.evolucaoUso : [];
      const evolucaoAtendimento = Array.isArray(data.evolucaoAtendimento) ? data.evolucaoAtendimento : [];
      const evolucaoEquip = Array.isArray(data.evolucaoEquip) ? data.evolucaoEquip : [];

      const enviosPorMes = Array.isArray(data.enviosPorMes) ? data.enviosPorMes : [];
      const respostasPorMes = Array.isArray(data.respostasPorMes) ? data.respostasPorMes : [];

      document.getElementById('card-total-respostas').textContent = totalRespostas;
      document.getElementById('card-taxa-resposta').textContent = taxaResposta.toFixed(1) + '%';
      document.getElementById('card-media-geral').textContent = mediaGeral.toFixed(1);
      document.getElementById('card-ultima-resposta').textContent = ultimaResposta;
      document.getElementById('texto-media-pontuacao').textContent = mediaGeral.toFixed(1);

      chartBarAreas = setChart(chartBarAreas, 'barAreas', {
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

      chartBarDistribuicao = setChart(chartBarDistribuicao, 'barDistribuicao', {
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

      chartLineEvolucao = setChart(chartLineEvolucao, 'lineEvolucao', {
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

      chartPieRespondido = setChart(chartPieRespondido, 'pieRespondido', {
        type: 'doughnut',
        data: {
          labels: ['Respondido', 'Não respondido'],
          datasets: [{
            data: [totalRespostas, Math.max(totalEnviadas - totalRespostas, 0)],
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
        totalEnviadas + ' enviadas, sendo ' + totalRespostas + ' respondidas (' + taxaResposta.toFixed(1) + '%).';

      chartLineEnvios = setChart(chartLineEnvios, 'lineEnvios', {
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

      chartDoughnutMedia = setChart(chartDoughnutMedia, 'doughnutMedia', {
        type: 'doughnut',
        data: {
          labels: ['Média', 'Restante até 10'],
          datasets: [{ data: [mediaGeral, Math.max(10 - mediaGeral, 0)], backgroundColor: ['#2563eb', '#e2e8f0'] }]
        },
        options: {
          cutoutPercentage: 60,
          legend: { display: false }
        }
      });
    }

    function renderTabelaVariacao(pA, pB) {
      const tbody = document.getElementById('tabela-variacao');
      tbody.innerHTML = '';

      const totalRespostasA = Number(pA.totalRespostas || 0);
      const totalEnviadasA = Number(pA.totalEnviadas || 0);
      const totalRespostasB = Number(pB.totalRespostas || 0);
      const totalEnviadasB = Number(pB.totalEnviadas || 0);
      const taxaA = totalEnviadasA > 0 ? (totalRespostasA / totalEnviadasA) * 100 : 0;
      const taxaB = totalEnviadasB > 0 ? (totalRespostasB / totalEnviadasB) * 100 : 0;

      const linhas = [
        { nome: 'Média - Uso geral', a: Number(pA.mediaUso || 0), b: Number(pB.mediaUso || 0) },
        { nome: 'Média - Atendimento', a: Number(pA.mediaAtendimento || 0), b: Number(pB.mediaAtendimento || 0) },
        { nome: 'Média - Equipamentos', a: Number(pA.mediaEquip || 0), b: Number(pB.mediaEquip || 0) },
        { nome: 'Taxa de resposta (%)', a: taxaA, b: taxaB }
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
      const temasA = Array.isArray(pA.temas) && pA.temas.length ? pA.temas : [];
      const temasB = Array.isArray(pB.temas) && pB.temas.length ? pB.temas : [];
      container.innerHTML = `
        <div class="col-md-6 mb-3">
          <p class="small text-muted mb-2">${pA.nome}</p>
          <ul class="list-group list-group-flush">
            ${temasA.length ? temasA.map(t => `<li class="list-group-item d-flex justify-content-between align-items-center px-0">${t.tema}<span class="badge badge-primary badge-pill">${t.qtd}</span></li>`).join('') : '<li class="list-group-item px-0 text-muted">Sem dados.</li>'}
          </ul>
        </div>
        <div class="col-md-6 mb-3">
          <p class="small text-muted mb-2">${pB.nome}</p>
          <ul class="list-group list-group-flush">
            ${temasB.length ? temasB.map(t => `<li class="list-group-item d-flex justify-content-between align-items-center px-0">${t.tema}<span class="badge badge-primary badge-pill">${t.qtd}</span></li>`).join('') : '<li class="list-group-item px-0 text-muted">Sem dados.</li>'}
          </ul>
        </div>
      `;
    }

    function renderComparativo(data) {
      const labelsNotas = getLabelsNotas(data.labelsNotas);
      const labelsMeses = Array.isArray(data.labelsMeses) ? data.labelsMeses : [];
      const pA = data.periodoA || {};
      const pB = data.periodoB || {};
      pA.nome = pA.nome || 'Período A';
      pB.nome = pB.nome || 'Período B';

      const mediaA = (Number(pA.mediaUso || 0) + Number(pA.mediaAtendimento || 0) + Number(pA.mediaEquip || 0)) / 3;
      const mediaB = (Number(pB.mediaUso || 0) + Number(pB.mediaAtendimento || 0) + Number(pB.mediaEquip || 0)) / 3;
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
      chartBarAreasComp = setChart(chartBarAreasComp, 'barAreasComparativo', {
        type: 'bar',
        data: {
          labels: ['Uso geral', 'Atendimento', 'Equipamentos'],
          datasets: [
            { label: 'Per. A', data: [Number(pA.mediaUso || 0), Number(pA.mediaAtendimento || 0), Number(pA.mediaEquip || 0)], backgroundColor: '#0f766e' },
            { label: 'Per. B', data: [Number(pB.mediaUso || 0), Number(pB.mediaAtendimento || 0), Number(pB.mediaEquip || 0)], backgroundColor: '#2563eb' }
          ]
        },
        options: { scales: { y: { beginAtZero: true, max: 10 } } }
      });

      // distribuição comparativa
      chartBarDistComp = setChart(chartBarDistComp, 'barDistribuicaoComparativo', {
        type: 'bar',
        data: {
          labels: labelsNotas,
          datasets: [
            { label: 'Per. A - Uso', data: (pA.distribuicao && pA.distribuicao.uso) ? pA.distribuicao.uso : new Array(11).fill(0), backgroundColor: 'rgba(15,118,110,0.7)' },
            { label: 'Per. B - Uso', data: (pB.distribuicao && pB.distribuicao.uso) ? pB.distribuicao.uso : new Array(11).fill(0), backgroundColor: 'rgba(37,99,235,0.7)' },
            { label: 'Per. A - Atendimento', data: (pA.distribuicao && pA.distribuicao.atendimento) ? pA.distribuicao.atendimento : new Array(11).fill(0), backgroundColor: 'rgba(15,118,110,0.3)' },
            { label: 'Per. B - Atendimento', data: (pB.distribuicao && pB.distribuicao.atendimento) ? pB.distribuicao.atendimento : new Array(11).fill(0), backgroundColor: 'rgba(37,99,235,0.3)' },
            { label: 'Per. A - Equipamentos', data: (pA.distribuicao && pA.distribuicao.equip) ? pA.distribuicao.equip : new Array(11).fill(0), backgroundColor: 'rgba(249,115,22,0.5)' },
            { label: 'Per. B - Equipamentos', data: (pB.distribuicao && pB.distribuicao.equip) ? pB.distribuicao.equip : new Array(11).fill(0), backgroundColor: 'rgba(148,163,184,0.8)' }
          ]
        },
        options: {
          responsive: true,
          scales: { y: { beginAtZero: true } },
          legend: { position: 'bottom' }
        }
      });

      // envios comparativo
      chartLineEnviosComp = setChart(chartLineEnviosComp, 'lineEnviosComparativo', {
        type: 'line',
        data: {
          labels: labelsMeses,
          datasets: [
            { label: 'Per. A - Envios', data: Array.isArray(pA.envios) ? pA.envios : [], borderColor: '#94a3b8', fill: false, tension: 0.3 },
            { label: 'Per. A - Respostas', data: Array.isArray(pA.respostas) ? pA.respostas : [], borderColor: '#0f766e', fill: false, tension: 0.3 },
            { label: 'Per. B - Envios', data: Array.isArray(pB.envios) ? pB.envios : [], borderColor: '#f97316', fill: false, tension: 0.3 },
            { label: 'Per. B - Respostas', data: Array.isArray(pB.respostas) ? pB.respostas : [], borderColor: '#2563eb', fill: false, tension: 0.3 }
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

    function aplicarFiltrosIniciais(filtros){
      const dataADe = document.getElementById('dataADe');
      const dataAAte = document.getElementById('dataAAte');
      const dataBDe = document.getElementById('dataBDe');
      const dataBAte = document.getElementById('dataBAte');

      if (filtros.dataADe) dataADe.value = filtros.dataADe;
      if (filtros.dataAAte) dataAAte.value = filtros.dataAAte;
      if (filtros.dataBDe) dataBDe.value = filtros.dataBDe;
      if (filtros.dataBAte) dataBAte.value = filtros.dataBAte;

      if (!dataADe.value || !dataAAte.value || !dataBDe.value || !dataBAte.value) {
        const hoje = new Date();
        const fimA = new Date(hoje);
        const inicioA = new Date(hoje);
        inicioA.setDate(fimA.getDate() - 30);
        const fimB = new Date(inicioA);
        fimB.setDate(fimB.getDate() - 1);
        const inicioB = new Date(fimB);
        inicioB.setDate(fimB.getDate() - 29);

        if (!dataADe.value) dataADe.value = inicioA.toISOString().split('T')[0];
        if (!dataAAte.value) dataAAte.value = fimA.toISOString().split('T')[0];
        if (!dataBDe.value) dataBDe.value = inicioB.toISOString().split('T')[0];
        if (!dataBAte.value) dataBAte.value = fimB.toISOString().split('T')[0];
      }
    }

    function atualizarInfoPeriodo(filtros){
      const infoPeriodo = document.getElementById('info-periodo-relatorio');
      if (!infoPeriodo) return;
      const dataADe = filtros.dataADe || document.getElementById('dataADe').value;
      const dataAAte = filtros.dataAAte || document.getElementById('dataAAte').value;
      if (!dataADe || !dataAAte) {
        infoPeriodo.textContent = '';
        return;
      }
      infoPeriodo.textContent = `Período considerado: ${formatDateBR(dataADe)} a ${formatDateBR(dataAAte)}`;
    }

    function aplicarDados(payload){
      const filtros = payload.filtros || {};
      aplicarFiltrosIniciais(filtros);
      atualizarInfoPeriodo(filtros);

      if (payload.geral) {
        renderGeral(payload.geral);
      }
      if (payload.comparativo) {
        renderComparativo(payload.comparativo);
      }
    }

    async function aplicarComparacao(){
      const info = document.getElementById('info-comparacao');
      const dataADe = document.getElementById('dataADe').value;
      const dataAAte = document.getElementById('dataAAte').value;
      const dataBDe = document.getElementById('dataBDe').value;
      const dataBAte = document.getElementById('dataBAte').value;

      if (!window.pesquisaRelatorioEndpoint) {
        return;
      }

      const params = new URLSearchParams({
        dataADe,
        dataAAte,
        dataBDe,
        dataBAte
      });

      if (info) info.textContent = 'Carregando...';

      try {
        const response = await fetch(window.pesquisaRelatorioEndpoint + '?' + params.toString(), {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
        const payload = await response.json();
        if (!response.ok || payload.erro) {
          if (info) info.textContent = payload.msg || 'Erro ao carregar dados.';
          return;
        }
        if (info) info.textContent = '';
        aplicarDados(payload);
      } catch (err) {
        if (info) info.textContent = 'Erro ao carregar dados.';
      }
    }

    window.aplicarComparacao = aplicarComparacao;

    (function init(){
      aplicarDados(window.pesquisaRelatorioData || {});
    })();
  </script>
<?= $this->endSection(); ?>
