<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Cobranças</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Relatório</span>
        </div>
        <p class="small text-muted mb-0" id="info-periodo-relatorio"></p>
    </div>
</div>
<!-- breadcrumb -->

<div class="container px-0">
    <!-- CARDS GERAIS -->
    <div class="row">
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="mb-1 text-muted">Total de cobranças</p>
                    <h3 id="card-total-cobrancas" class="mb-0">0</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="mb-1 text-muted">Valor total</p>
                    <h3 id="card-total-valor" class="mb-0">R$ 0,00</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="mb-1 text-muted">Ticket médio</p>
                    <h3 id="card-ticket-medio" class="mb-0">R$ 0,00</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="mb-1 text-muted">% pago</p>
                    <h3 id="card-pct-pago" class="mb-0">0%</h3>
                    <p class="small text-muted mb-0" id="card-pct-pago-info">valor pago / (pago + aberto)</p>
                    <p class="small text-muted mb-0" id="card-abertas-info"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- GRAFICOS GERAIS -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title">Valor total por mês</h6>
                    <p class="small-muted mb-3">Soma do valor das cobranças no período selecionado.</p>
                    <canvas id="chart-valor-mes"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title">Quantidade de cobranças por mês</h6>
                    <p class="small-muted mb-3">Volume de cobranças agrupado por mês.</p>
                    <canvas id="chart-qtd-mes"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title">Valor por serviço (pizza)</h6>
                    <p class="small-muted mb-3">Distribuição do valor total por serviço.</p>
                    <canvas id="chart-servicos"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title">Valor por situação</h6>
                    <p class="small-muted mb-3">Comparação entre abertas, pagas e canceladas.</p>
                    <canvas id="chart-situacao"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- TABELA SERVIÇOS -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title">Top serviços no período</h6>
                    <p class="small-muted mb-3">Ordenado pelo valor total.</p>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Serviço</th>
                                    <th>Quantidade</th>
                                    <th>Valor total</th>
                                </tr>
                            </thead>
                            <tbody id="tabela-servicos">
                                <tr><td colspan="3" class="text-muted small">Sem dados.</td></tr>
                            </tbody>
                        </table>
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
                    <p class="small-muted mb-4">Selecione dois intervalos para comparar desempenho.</p>
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
                    <p class="small text-muted mb-1">Valor total (Período A)</p>
                    <h4 id="cmp-valor-a" class="mb-0">R$ 0,00</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="small text-muted mb-1">Valor total (Período B)</p>
                    <h4 id="cmp-valor-b" class="mb-0">R$ 0,00</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="small text-muted mb-1">Variação (R$)</p>
                    <h4 id="cmp-variacao-abs" class="mb-0 text-success">R$ 0,00</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="small text-muted mb-1">Variação (%)</p>
                    <h4 id="cmp-variacao-pct" class="mb-0 text-success">0%</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- GRÁFICOS COMPARATIVOS -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title">Valor por mês (A x B)</h6>
                    <p class="small-muted mb-3">Compara a evolução mensal do valor total.</p>
                    <canvas id="chart-valor-mes-comp"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title">Valor por situação (A x B)</h6>
                    <p class="small-muted mb-3">Comparativo de valores por status.</p>
                    <canvas id="chart-situacao-comp"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title">Serviços (Período A)</h6>
                    <p class="small-muted mb-3">Distribuição por serviço.</p>
                    <canvas id="chart-servicos-a"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title">Serviços (Período B)</h6>
                    <p class="small-muted mb-3">Distribuição por serviço.</p>
                    <canvas id="chart-servicos-b"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title">Tabela de variação</h6>
                    <p class="small-muted mb-3">Resumo das métricas comparadas entre períodos.</p>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
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
<script src="<?= base_url('assets/vendor/cdn/chart.js') ?>"></script>
<script>
  window.cobrancaRelatorioData = <?= json_encode($relatorioData ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
  window.cobrancaRelatorioEndpoint = "<?= base_url('Cobranca/relatorioDados') ?>";
</script>
<script>
    const charts = {};
    const currencyFormatter = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' });

    function formatBRL(valor){
        return currencyFormatter.format(Number(valor || 0));
    }

    function formatPercent(valor){
        return (Number(valor || 0)).toFixed(1) + '%';
    }

    function setChart(id, config){
        const ctx = document.getElementById(id);
        if (!ctx) return;
        if (charts[id]) charts[id].destroy();
        charts[id] = new Chart(ctx, config);
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

    function renderTabelaServicos(servicos){
        const tbody = document.getElementById('tabela-servicos');
        tbody.innerHTML = '';
        if (!Array.isArray(servicos) || servicos.length === 0) {
            const tr = document.createElement('tr');
            tr.innerHTML = '<td colspan="3" class="text-muted small">Sem dados.</td>';
            tbody.appendChild(tr);
            return;
        }
        servicos.slice(0, 10).forEach(s => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${s.nome || 'Serviço'}</td>
                <td>${Number(s.quantidade || 0)}</td>
                <td>${formatBRL(s.total || 0)}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    function renderGeral(data){
        const totalCobrancas = Number(data.totalCobrancas || 0);
        const totalValor = Number(data.totalValor || 0);
        const ticketMedio = Number(data.ticketMedio || 0);
        const situacaoValores = data.situacaoValores || {};
        const totalAbertas = Number(data.totalAbertas || 0);
        const valorAbertas = Number(data.valorAbertas || 0);

        const valorPago = Number(situacaoValores[1] || 0);
        const totalReferenciaPago = totalValor + valorAbertas;
        const pctPago = totalReferenciaPago > 0 ? (valorPago / totalReferenciaPago) * 100 : 0;

        document.getElementById('card-total-cobrancas').textContent = totalCobrancas;
        document.getElementById('card-total-valor').textContent = formatBRL(totalValor);
        document.getElementById('card-ticket-medio').textContent = formatBRL(ticketMedio);
        document.getElementById('card-pct-pago').textContent = formatPercent(pctPago);
        const abertoInfo = document.getElementById('card-abertas-info');
        if (abertoInfo) {
            abertoInfo.textContent = totalAbertas > 0 ? `Abertas: ${totalAbertas} (${formatBRL(valorAbertas)})` : '';
        }

        setChart('chart-valor-mes', {
            type: 'line',
            data: {
                labels: data.labelsMeses || [],
                datasets: [{
                    label: 'Valor (R$)',
                    data: data.valoresPorMes || [],
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.15)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        setChart('chart-qtd-mes', {
            type: 'bar',
            data: {
                labels: data.labelsMeses || [],
                datasets: [{
                    label: 'Cobranças',
                    data: data.quantidadesPorMes || [],
                    backgroundColor: '#0f766e'
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });

        const servicosChart = data.servicosChart || { labels: [], valores: [] };
        setChart('chart-servicos', {
            type: 'pie',
            data: {
                labels: servicosChart.labels || [],
                datasets: [{
                    data: servicosChart.valores || [],
                    backgroundColor: ['#2563eb', '#0f766e', '#f97316', '#e11d48', '#8b5cf6', '#14b8a6', '#f59e0b', '#64748b', '#94a3b8']
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });

        setChart('chart-situacao', {
            type: 'doughnut',
            data: {
                labels: ['Aberta', 'Paga', 'Cancelada'],
                datasets: [{
                    data: [Number(situacaoValores[0] || 0), Number(situacaoValores[1] || 0), Number(situacaoValores[2] || 0)],
                    backgroundColor: ['#f97316', '#22c55e', '#e11d48']
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } }, cutout: '55%' }
        });

        renderTabelaServicos(data.servicos || []);
    }

    function renderTabelaVariacao(pA, pB){
        const tbody = document.getElementById('tabela-variacao');
        tbody.innerHTML = '';

        const linhas = [
            { nome: 'Total de cobranças', a: Number(pA.totalCobrancas || 0), b: Number(pB.totalCobrancas || 0), format: v => v.toFixed(0) },
            { nome: 'Valor total', a: Number(pA.totalValor || 0), b: Number(pB.totalValor || 0), format: v => formatBRL(v) },
            { nome: 'Ticket médio', a: Number(pA.ticketMedio || 0), b: Number(pB.ticketMedio || 0), format: v => formatBRL(v) },
            { nome: 'Serviços lançados (qtd)', a: Number(pA.totalServicos || 0), b: Number(pB.totalServicos || 0), format: v => v.toFixed(0) }
        ];

        linhas.forEach(l => {
            const diff = l.b - l.a;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${l.nome}</td>
                <td>${l.format(l.a)}</td>
                <td>${l.format(l.b)}</td>
                <td class="${diff >= 0 ? 'text-success' : 'text-danger'} font-weight-bold">${l.format(diff)}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    function renderComparativo(data){
        const pA = data.periodoA || {};
        const pB = data.periodoB || {};
        const totalA = Number(pA.totalValor || 0);
        const totalB = Number(pB.totalValor || 0);
        const variacaoAbs = totalB - totalA;
        const variacaoPct = totalA > 0 ? (variacaoAbs / totalA) * 100 : 0;

        document.getElementById('cmp-valor-a').textContent = formatBRL(totalA);
        document.getElementById('cmp-valor-b').textContent = formatBRL(totalB);

        const elAbs = document.getElementById('cmp-variacao-abs');
        const elPct = document.getElementById('cmp-variacao-pct');
        elAbs.textContent = formatBRL(variacaoAbs);
        elPct.textContent = formatPercent(variacaoPct);

        elAbs.classList.remove('text-success', 'text-danger');
        elPct.classList.remove('text-success', 'text-danger');
        if (variacaoAbs >= 0) {
            elAbs.classList.add('text-success');
            elPct.classList.add('text-success');
        } else {
            elAbs.classList.add('text-danger');
            elPct.classList.add('text-danger');
        }

        setChart('chart-valor-mes-comp', {
            type: 'line',
            data: {
                labels: data.labelsMeses || [],
                datasets: [
                    { label: 'Período A', data: (data.seriesA && data.seriesA.valores) ? data.seriesA.valores : [], borderColor: '#0f766e', tension: 0.3, fill: false },
                    { label: 'Período B', data: (data.seriesB && data.seriesB.valores) ? data.seriesB.valores : [], borderColor: '#2563eb', tension: 0.3, fill: false }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true } }
            }
        });

        const situacaoValoresA = pA.situacaoValores || {};
        const situacaoValoresB = pB.situacaoValores || {};
        setChart('chart-situacao-comp', {
            type: 'bar',
            data: {
                labels: ['Aberta', 'Paga', 'Cancelada'],
                datasets: [
                    { label: 'Período A', data: [Number(situacaoValoresA[0] || 0), Number(situacaoValoresA[1] || 0), Number(situacaoValoresA[2] || 0)], backgroundColor: 'rgba(15,118,110,0.7)' },
                    { label: 'Período B', data: [Number(situacaoValoresB[0] || 0), Number(situacaoValoresB[1] || 0), Number(situacaoValoresB[2] || 0)], backgroundColor: 'rgba(37,99,235,0.7)' }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true } }
            }
        });

        const servicosChartA = (pA.servicosChart || { labels: [], valores: [] });
        const servicosChartB = (pB.servicosChart || { labels: [], valores: [] });

        setChart('chart-servicos-a', {
            type: 'pie',
            data: {
                labels: servicosChartA.labels || [],
                datasets: [{
                    data: servicosChartA.valores || [],
                    backgroundColor: ['#0f766e', '#2563eb', '#f97316', '#e11d48', '#8b5cf6', '#14b8a6', '#f59e0b', '#64748b', '#94a3b8']
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });

        setChart('chart-servicos-b', {
            type: 'pie',
            data: {
                labels: servicosChartB.labels || [],
                datasets: [{
                    data: servicosChartB.valores || [],
                    backgroundColor: ['#2563eb', '#0f766e', '#f97316', '#e11d48', '#8b5cf6', '#14b8a6', '#f59e0b', '#64748b', '#94a3b8']
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });

        renderTabelaVariacao(pA, pB);
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

        if (!window.cobrancaRelatorioEndpoint) {
            return;
        }

        const params = new URLSearchParams({ dataADe, dataAAte, dataBDe, dataBAte });

        if (info) info.textContent = 'Carregando...';

        try {
            const response = await fetch(window.cobrancaRelatorioEndpoint + '?' + params.toString(), {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const payload = await response.json();
            const erroFlag = payload && (payload.erro === true || payload.erro === 1 || payload.erro === '1' || payload.erro === 'true');
            if (!response.ok && !payload) {
                if (info) info.textContent = 'Erro ao carregar dados.';
                return;
            }
            if (erroFlag) {
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
        aplicarDados(window.cobrancaRelatorioData || {});
    })();
</script>
<?= $this->endSection(); ?>
