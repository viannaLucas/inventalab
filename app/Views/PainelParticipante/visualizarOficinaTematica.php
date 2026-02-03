<?= $this->extend('PainelParticipante/template'); ?>

<?= $this->section('content'); ?>
<?php
$arquivos = $oficinatematica->getListArquivoOficina();
$materiais = $oficinatematica->getListMaterialOficina();
$recursos = $oficinatematica->getListRecursoOficina();
$descricao = trim((string) ($oficinatematica->descricaoAtividade ?? ''));
?>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Oficina Temática</h4>
            <span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Visualizar</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->

<div class="container px-0 oficina-view">
    <div class="oficina-hero">
        <div class="oficina-hero__content">
            <div class="oficina-badge">Conteúdo da Oficina</div>
            <h1 class="oficina-title"><?= esc($oficinatematica->nome) ?></h1>
            <div class="oficina-meta">
                <span><?= count($materiais) ?> <?= count($materiais) === 1 ? 'material' : 'materiais' ?></span>
                <span class="dot"></span>
                <span><?= count($recursos) ?> <?= count($recursos) === 1 ? 'recurso' : 'recursos' ?></span>
                <?php if (!empty($arquivos)) { ?>
                    <span class="dot"></span>
                    <span><?= count($arquivos) ?> <?= count($arquivos) === 1 ? 'arquivo' : 'arquivos' ?></span>
                <?php } ?>
            </div>
        </div>
        <div class="oficina-hero__art" aria-hidden="true">
            <div class="ring ring-1"></div>
            <div class="ring ring-2"></div>
            <div class="ring ring-3"></div>
        </div>
    </div>

    <?php if (!empty($arquivos)) { ?>
        <section class="oficina-section">
            <div class="section-head">
                <h2>Lista de Arquivos da Oficina</h2>
                <p>Baixe os materiais de apoio da oficina.</p>
            </div>
            <div class="arquivo-grid">
                <?php foreach ($arquivos as $arquivo) { ?>
                    <?php
                    $arquivoNome = trim((string) ($arquivo->nome ?? ''));
                    $arquivoPath = trim((string) ($arquivo->arquivo ?? ''));
                    $arquivoUrl = $arquivoPath !== '' ? base_url('PainelParticipante/resource/' . $arquivoPath) : '';
                    ?>
                    <div class="arquivo-card">
                        <div class="arquivo-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5z"/>
                                <path d="M9.5 0v4a1 1 0 0 0 1 1h4"/>
                            </svg>
                        </div>
                        <div class="arquivo-info">
                            <div class="arquivo-title"><?= esc($arquivoNome !== '' ? $arquivoNome : 'Arquivo da oficina') ?></div>
                        </div>
                        <?php if ($arquivoUrl !== '') { ?>
                            <a class="btn btn-sm btn-outline-primary" href="<?= esc($arquivoUrl, 'attr') ?>" target="_blank" rel="noopener">Abrir</a>
                        <?php } else { ?>
                            <span class="arquivo-empty">Indisponível</span>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </section>
    <?php } ?>

    <?php if (!empty($materiais)) { ?>
        <section class="oficina-section">
            <div class="section-head">
                <h2>Lista de Material Oficina</h2>
                <p>Itens que podem ser usados durante a oficina.</p>
            </div>
            <div class="material-grid">
                <?php foreach ($materiais as $material) { ?>
                    <?php
                    $materialFoto = trim((string) ($material->foto ?? ''));
                    $materialUrl = $materialFoto !== '' ? base_url('PainelParticipante/resource/' . $materialFoto) : '';
                    $materialDescricao = trim((string) ($material->descricao ?? ''));
                    ?>
                    <div class="material-card">
                        <div class="material-image">
                            <?php if ($materialUrl !== '') { ?>
                                <img src="<?= esc($materialUrl, 'attr') ?>" alt="<?= esc($materialDescricao !== '' ? $materialDescricao : 'Material da oficina') ?>">
                            <?php } else { ?>
                                <div class="material-placeholder">Sem imagem</div>
                            <?php } ?>
                        </div>
                        <div class="material-body">
                            <div class="material-title"><?= esc($materialDescricao !== '' ? $materialDescricao : 'Material da oficina') ?></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    <?php } ?>

    <?php if (!empty($recursos)) { ?>
        <section class="oficina-section">
            <div class="section-head">
                <h2>Lista de Recurso Oficina</h2>
                <p>Recursos e equipamentos associados à oficina.</p>
            </div>
            <div class="recurso-grid">
                <?php foreach ($recursos as $recurso) { ?>
                    <?php
                    $recursoTrabalho = $recurso->getRecursoTrabalho();
                    $recursoFoto = trim((string) ($recursoTrabalho->foto ?? ''));
                    $recursoFotoUrl = $recursoFoto !== '' ? base_url('PainelParticipante/resource/' . $recursoFoto) : '';
                    ?>
                    <div class="recurso-card">
                        <div class="recurso-icon">
                            <?php if ($recursoFotoUrl !== '') { ?>
                                <img src="<?= esc($recursoFotoUrl, 'attr') ?>" alt="<?= esc($recursoTrabalho->nome ?? 'Recurso da oficina') ?>">
                            <?php } else { ?>
                                <div class="recurso-placeholder">Sem imagem</div>
                            <?php } ?>
                        </div>
                        <div class="recurso-info">
                            <div class="recurso-title"><?= esc($recursoTrabalho->nome ?? 'Recurso da oficina') ?></div>
                            <?php if (!empty($recursoTrabalho->descricao)) { ?>
                                <div class="recurso-sub"><?= esc($recursoTrabalho->descricao) ?></div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    <?php } ?>

    <section class="oficina-section">
        <div class="section-head">
            <h2>Texto da Oficina</h2>
            <p>Conteúdo completo da atividade.</p>
        </div>
        <div class="oficina-text">
            <?php if ($descricao !== '') { ?>
                <?= $descricao ?>
            <?php } else { ?>
                <div class="text-muted">Nenhum conteúdo foi informado para esta oficina.</div>
            <?php } ?>
        </div>
    </section>
</div>
<?= $this->endSection('content'); ?>

<?= $this->section('styles'); ?>
<style>
.oficina-view {
    --oficina-bg: #f6f5f1;
    --oficina-card: #ffffff;
    --oficina-ink: #1c1c1c;
    --oficina-muted: #5f615c;
    --oficina-accent: #d97706;
    --oficina-accent-soft: #fef3c7;
    --oficina-border: #e4e1d9;
    --oficina-shadow: 0 14px 32px rgba(18, 16, 12, 0.12);
    color: var(--oficina-ink);
}

.oficina-hero {
    position: relative;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 24px;
    padding: 32px 32px 28px;
    border-radius: 24px;
    background: radial-gradient(circle at top left, #fff4d2 0%, #fdf7e7 45%, #f7efe0 100%);
    border: 1px solid var(--oficina-border);
    overflow: hidden;
    margin-bottom: 28px;
}

.oficina-hero__content {
    position: relative;
    z-index: 2;
}

.oficina-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 999px;
    background: var(--oficina-accent-soft);
    color: #9a5b00;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.02em;
    text-transform: uppercase;
}

.oficina-title {
    margin: 16px 0 8px;
    font-size: clamp(28px, 3vw, 40px);
    font-weight: 700;
}

.oficina-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    color: var(--oficina-muted);
    font-size: 14px;
}

.oficina-meta .dot {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: var(--oficina-muted);
    opacity: 0.6;
}

.oficina-hero__art {
    position: relative;
    min-height: 120px;
}

.oficina-hero__art .ring {
    position: absolute;
    border-radius: 50%;
    border: 1px dashed rgba(217, 119, 6, 0.3);
}

.oficina-hero__art .ring-1 {
    width: 150px;
    height: 150px;
    top: 0;
    right: 10%;
}

.oficina-hero__art .ring-2 {
    width: 220px;
    height: 220px;
    top: -40px;
    right: -20px;
}

.oficina-hero__art .ring-3 {
    width: 90px;
    height: 90px;
    bottom: -10px;
    right: 45%;
}

.oficina-section {
    background: var(--oficina-card);
    border-radius: 20px;
    border: 1px solid var(--oficina-border);
    padding: 24px;
    margin-bottom: 22px;
    box-shadow: var(--oficina-shadow);
}

.section-head h2 {
    margin: 0 0 4px;
    font-size: 22px;
    font-weight: 700;
}

.section-head p {
    margin: 0 0 18px;
    color: var(--oficina-muted);
}

.arquivo-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 16px;
}

.arquivo-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 16px;
    border: 1px solid var(--oficina-border);
    background: #fffaf0;
}

.arquivo-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: #fde7b0;
    color: #9a5b00;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.arquivo-info {
    flex: 1;
    min-width: 0;
}

.arquivo-title {
    font-weight: 600;
    font-size: 14px;
}

.arquivo-sub {
    font-size: 12px;
    color: var(--oficina-muted);
    word-break: break-all;
}

.arquivo-empty {
    font-size: 12px;
    color: var(--oficina-muted);
}

.material-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 200px));
    gap: 18px;
    justify-content: flex-start;
}

.material-card {
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid var(--oficina-border);
    background: #fff;
    display: flex;
    flex-direction: column;
    max-width: 200px;
}

.material-image {
    height: 160px;
    background: #f1efe9;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid var(--oficina-border);
}

.material-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.material-placeholder {
    font-size: 13px;
    color: var(--oficina-muted);
}

.material-body {
    padding: 12px 14px;
    background: #fff;
}

.material-title {
    font-weight: 600;
    color: var(--oficina-ink);
    font-size: 13px;
}

.recurso-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 14px;
}

.recurso-card {
    display: flex;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 16px;
    border: 1px solid var(--oficina-border);
    background: #f9f7f2;
}

.recurso-icon {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: #f1e7d1;
    color: #8a5a0a;
}

.recurso-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.recurso-placeholder {
    font-size: 10px;
    color: var(--oficina-muted);
    text-align: center;
    padding: 2px;
}

.recurso-info {
    min-width: 0;
}

.recurso-title {
    font-weight: 600;
    font-size: 14px;
}

.recurso-sub {
    font-size: 12px;
    color: var(--oficina-muted);
}

.oficina-text {
    font-size: 15px;
    line-height: 1.8;
}

.oficina-text h1,
.oficina-text h2,
.oficina-text h3 {
    margin-top: 18px;
}

@media (max-width: 576px) {
    .oficina-hero {
        padding: 24px;
    }

    .oficina-section {
        padding: 20px;
    }
}
</style>
<?= $this->endSection('styles'); ?>
