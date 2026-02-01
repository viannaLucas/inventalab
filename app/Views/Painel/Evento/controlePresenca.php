<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Evento</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Controle de Presença</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
<?PHP

use App\Entities\ControlePresencaEntity;

if($controlePresenca instanceof ControlePresencaEntity){ 
    $evento = $controlePresenca->getEvento();
    $participantes = $evento->getListParticipanteEvento();

?>

<div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h3 class="text-center">Controle de Presença: <?= $controlePresenca->descricao ?></h3>
        </div>
        <div class="card-body pt-0">
            <div class="w-100 border rounded-sm mb-4">
                <div class="form-group col-12">
                    <label class="main-content-label tx-11 tx-medium tx-gray-600">Filtro / Pesquisa</label> 
                    <input class="form-control" name="filtro" id="filtro" type="text" value="">
                </div>    
            </div>
            <div class="table-responsive">
                <h4 class="mb-3">Lista Participantes</h4>
                <table class="table table-striped" id="tabelaListaParticipantes">
                    <thead>
                        <tr>
                            <th scope="col">Participante Evento</th>
                            <th scope="col">Presente</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?PHP foreach ($participantes as $i) { ?>
                        <tr>
                            <td width=200><div data-controle-presenca='<?= esc($controlePresenca->id, 'attr') ?>' data-participante='<?= esc($i->getParticipante()->id, 'attr') ?>' class="btn btn-success btn-presenca">Adicionar Presença</div></td>
                            <td><h4><?= esc($i->getParticipante()->nome) ?></h4></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?PHP }else{ ?>
 <div class="container px-0 ">
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h3 class="">Selecione o Controle de Presença</h3>
        </div>
        <div class="card-body pt-0">
            <?PHP if (count($evento->getListControlePresenca()) > 0) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Descrição</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?PHP foreach ($evento->getListControlePresenca() as $i) { ?>
                        <tr>
                            <td><h5><?= $i->getEvento()?->nome ?>: <?= $i->descricao ?></h5></td>
                            <td>
                                <a href="<?php echo base_url('Evento/controlePresenca/'. $evento->id.'/'.$i->id); ?>" class="btn btn-primary ">
                                    Selecionar
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <?PHP } else { ?>
                <div class="justify-content-center">
                    <div class="card mg-b-20 text-center ">
                        <div class="card-body h-100">
                            <img src="<?PHP echo base_url('assets/img/no-data.svg'); ?>" alt="" class="" style="max-height: 100px;"/>
                            <h5 class="mg-b-10 mg-t-15 tx-18">Controles de Presença não encontrados</h5>
                            <p class="text-muted">Não há nenhuma lista de presença cadastrada para este evento</ps>
                            <div class="w-100">
                                <a class="btn btn-secondary" href="<?PHP echo base_url('Evento/alterar/'.$evento->id.'#controlePresenca'); ?>">Cadastrar Controle de Presença</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?PHP } ?>
        </div>
    </div>
</div>
<?PHP } ?>
<!-- row closed -->
<?= esc($this->endSection('content'); ) ?><?= $this->section('scripts'); ?>
<script>
// Presença: click handler + fetch + toast + limpar filtro
document.addEventListener('click', async function (e) {
    const btn = e.target.closest('.btn-presenca');
    if (!btn) return;

    const controle = btn.dataset.controlePresenca;
    const participante = btn.dataset.participante;
    if (!controle || !participante) {
        showToast('Dados inválidos para registrar presença.', true);
        return;
    }

    const url = '<?= base_url('Evento/definirPresenca/'); ?>' + encodeURIComponent(controle) + '/' + encodeURIComponent(participante);
    try {
        const resp = await fetch(url, { credentials: 'same-origin' });
        const data = await resp.json().catch(() => ({ erro: true, mensagem: 'Resposta inválida do servidor.' }));
        showToast(data.mensagem || 'Operação concluída.', !!data.erro);

        if (!data.erro) {
            // Atualiza o estado visual e desabilita o botão imediatamente
            btn.classList.add('disabled');
            btn.setAttribute('disabled', 'disabled');
            btn.setAttribute('aria-disabled', 'true');
            btn.style.pointerEvents = 'none';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-secondary');
            btn.textContent = 'Presente';
        }
    } catch (err) {
        showToast('Falha ao comunicar com o servidor.', true);
    } finally {
        const filtro = document.getElementById('filtro');
        if (filtro) {
            filtro.value = '';
            aplicarFiltro('');
        }
    }
});

// Filtro: aplica enquanto digita
const inputFiltro = document.getElementById('filtro');
if (inputFiltro) {
    inputFiltro.addEventListener('input', function () {
        aplicarFiltro(this.value || '');
    });
}

function aplicarFiltro(texto) {
    const termo = (texto || '').toLowerCase();
    const tabela = document.getElementById('tabelaListaParticipantes');
    if (!tabela) return;
    const linhas = tabela.querySelectorAll('tbody tr');
    linhas.forEach(tr => {
        const nomeCell = tr.querySelector('td:first-child');
        const nome = (nomeCell ? nomeCell.textContent : '').toLowerCase();
        const visivel = termo === '' || nome.includes(termo);
        tr.style.display = visivel ? '' : 'none';
    });
}

// Toast helper
function showToast(mensagem, erro) {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'demo-static-toast';
        container.style.position = 'fixed';
        container.style.right = '10px';
        container.style.top = '10px';
        container.style.zIndex = '1080';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = 'toast fade show';
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    const header = document.createElement('div');
    header.className = 'toast-header';
    const title = document.createElement('h6');
    title.className = 'tx-14 mg-b-0 mg-r-auto';
    title.textContent = erro ? 'Erro' : 'Sucesso';
    const closeBtn = document.createElement('button');
    closeBtn.type = 'button';
    closeBtn.className = 'ml-2 mb-1 close tx-normal';
    closeBtn.setAttribute('data-dismiss', 'toast');
    closeBtn.setAttribute('aria-label', 'Close');
    closeBtn.innerHTML = '<span aria-hidden="true">&times;</span>';
    closeBtn.addEventListener('click', () => removerToast(toast));
    header.appendChild(title);
    header.appendChild(closeBtn);

    const body = document.createElement('div');
    body.className = 'toast-body';
    if (erro) body.classList.add('text-danger');
    body.textContent = mensagem || '';

    toast.appendChild(header);
    toast.appendChild(body);
    container.appendChild(toast);

    setTimeout(() => removerToast(toast), 5000);
}

function removerToast(el) {
    if (!el) return;
    el.classList.remove('show');
    el.classList.add('hide');
    setTimeout(() => el.remove(), 200);
}
</script>

<script>
    // Atualiza, a cada 5s, a lista de presentes e desabilita os botões correspondentes
    (function initControlePresencaAutoRefresh() {
        const btns = Array.from(document.querySelectorAll('.btn-presenca'));
        if (!btns.length) return; // nada para atualizar

        const controle = btns[0]?.dataset?.controlePresenca;
        if (!controle) return;

        const urlPresentes = '<?= base_url('Evento/getPresentesEmControle/'); ?>' + encodeURIComponent(controle);

        // aplica estado de habilitado/desabilitado conforme set de IDs presentes
        function aplicarEstadoPresentes(presentesSet) {
            for (let i = 0; i < btns.length; i++) {
                const btn = btns[i];
                const participanteId = btn.dataset.participante;
                const isPresente = presentesSet.has(String(participanteId));

                // evita writes desnecessários
                const jaDesabilitado = btn.classList.contains('disabled');
                if (isPresente && !jaDesabilitado) {
                    btn.classList.add('disabled');
                    btn.setAttribute('disabled', 'disabled');
                    btn.setAttribute('aria-disabled', 'true');
                    btn.style.pointerEvents = 'none';
                    // Ajusta classes do botão: de sucesso para secundário
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-secondary');
                    btn.textContent = 'Presente';
                } else if (!isPresente && jaDesabilitado) {
                    btn.classList.remove('disabled');
                    btn.removeAttribute('disabled');
                    btn.removeAttribute('aria-disabled');
                    btn.style.pointerEvents = '';
                    // Restaura classes do botão: de secundário para sucesso
                    btn.classList.remove('btn-secondary');
                    btn.classList.add('btn-success');
                }
            }
        }

        async function atualizarPresentes() {
            try {
                const resp = await fetch(urlPresentes, { credentials: 'same-origin', cache: 'no-store' });
                if (!resp.ok) return; // mantém estado anterior em caso de erro
                const arr = await resp.json();
                const presentesSet = new Set((Array.isArray(arr) ? arr : []).map(v => String(v)));
                aplicarEstadoPresentes(presentesSet);
            } catch (_) {
                // silêncio em falhas transitórias
            }
        }

        // rodada imediata e agendamento a cada 5s
        atualizarPresentes();
        setInterval(atualizarPresentes, 5000);
    })();
</script>
<?= $this->endSection(); ?>
