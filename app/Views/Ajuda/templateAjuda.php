<?php
$docs = $docs ?? [];
$currentContent = $currentContent ?? '';
$prev = $prev ?? null;
$next = $next ?? null;
$currentDir = $currentDir ?? '';
$assetBaseUrl = $assetBaseUrl ?? '';
$erro = $erro ?? null;

function renderAjudaMenu(array $items): void
{
    echo '<ul>';
    foreach ($items as $name => $val) {
        if (is_array($val)) {
            echo "<li><span class='folder'>📁 " . esc($name) . '</span>';
            renderAjudaMenu($val);
            echo '</li>';
            continue;
        }
        $label = basename($name, '.md');
        echo "<li><a href='?page=" . urlencode($val) . "'>📄 " . esc($label) . '</a></li>';
    }
    echo '</ul>';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Ajuda <?= esc(env('nomeEmpresa')) ;?></title>
    <script src="<?= base_url('assets/plugin/marked/marked.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugin/dompurify/purify.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugin/mermaid/mermaid.min.js') ?>"></script>
    <style>
        body {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        nav {
            width: 260px;
            background: #f7f7f7;
            padding: 1rem;
            height: 100vh;
            overflow: auto;
            border-right: 1px solid #ccc;
            transition: transform 0.3s ease;
        }
        nav.collapsed {
            transform: translateX(-100%);
            position: absolute;
        }
        main {
            flex: 1;
            padding: 2rem;
            overflow: auto;
            transition: width 0.3s ease;
        }
        body.nav-collapsed main {
            width: 100vw;
        }
        ul {
            list-style: none;
            padding-left: 1rem;
        }
        li {
            margin: .2rem 0;
        }
        a {
            text-decoration: none;
            color: #333;
        }
        a:hover {
            text-decoration: underline;
        }
        .folder {
            font-weight: bold;
            display: block;
            margin-top: .5rem;
        }
        pre {
            background: #222;
            color: #eee;
            padding: .7rem;
            border-radius: 6px;
            overflow-x: auto;
        }
        #nav-buttons {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
        }
        #nav-buttons a {
            padding: .5rem 1rem;
            background: #ddd;
            border-radius: 6px;
            text-decoration: none;
            color: #000;
        }
        #nav-buttons a:hover {
            background: #bbb;
        }
        #toggle-btn {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 999;
            background: #ddd;
            border: none;
            padding: .5rem .8rem;
            border-radius: 6px;
            cursor: pointer;
        }
        #toggle-btn:hover {
            background: #bbb;
        }
    </style>
</head>
<body>
    <button id="toggle-btn">☰</button>
    <nav id="sidebar">
        <h3>Documentacao</h3>
        <?php renderAjudaMenu($docs); ?>
    </nav>

    <main>
        <?php if ($erro): ?>
            <div><?= esc($erro) ?></div>
        <?php else: ?>
            <div id="content" style="display:none"><?= $currentContent ?></div>
            <div id="rendered"></div>

            <div id="nav-buttons">
                <?php if ($prev): ?>
                    <?php $prevLabel = basename($prev, '.md'); ?>
                    <a href="?page=<?= urlencode($prev) ?>">⬅️ <?= esc($prevLabel) ?></a>
                <?php else: ?><span></span><?php endif; ?>

                <?php if ($next): ?>
                    <?php $nextLabel = basename($next, '.md'); ?>
                    <a href="?page=<?= urlencode($next) ?>"><?= esc($nextLabel) ?> ➡️</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>

    <script>
        const renderedEl = document.getElementById("rendered");
        const contentEl = document.getElementById("content");
        const raw = contentEl ? contentEl.innerText : "";
        const applyImageSizeSyntax = (md) => {
            if (!md) return md;
            return md.replace(/!\[([^\]]*)\]\(([^)\s]+)(?:\s+"[^"]*")?\)\{([^}]+)\}/g, (match, alt, src, attrs) => {
                const tokens = attrs.split(/\s+/).filter(Boolean);
                let width = "";
                let height = "";
                let maxWidth = "";
                let maxHeight = "";
                let center = false;

                tokens.forEach((token) => {
                    const [rawKey, rawValue] = token.split("=");
                    const key = (rawKey || "").toLowerCase().trim();
                    const value = (rawValue || "").trim();
                    if (key === "center") {
                        center = true;
                        return;
                    }
                    if (!value) return;
                    if (!/^[0-9]{1,4}(?:px|%)?$/.test(value)) return;
                    if (key === "width") width = value;
                    if (key === "height") height = value;
                    if (key === "max-width") maxWidth = value;
                    if (key === "max-height") maxHeight = value;
                });

                if (!width && !height && !maxWidth && !maxHeight && !center) {
                    return match;
                }
                const safeAlt = alt.replace(/"/g, "&quot;");
                let html = '<img src="' + src + '" alt="' + safeAlt + '"';
                const styles = [];
                if (width) {
                    const wUnit = /%$/.test(width) ? '%' : 'px';
                    const wVal = width.replace(/(px|%)$/i, '');
                    if (wUnit === '%') {
                        styles.push('width:' + wVal + '%');
                    } else {
                        html += ' width="' + wVal + '"';
                    }
                }
                if (height) {
                    const hUnit = /%$/.test(height) ? '%' : 'px';
                    const hVal = height.replace(/(px|%)$/i, '');
                    if (hUnit === '%') {
                        styles.push('height:' + hVal + '%');
                    } else {
                        html += ' height="' + hVal + '"';
                    }
                }
                if (maxWidth) styles.push('max-width:' + maxWidth);
                if (maxHeight) styles.push('max-height:' + maxHeight);
                if (center) styles.push('display:block', 'margin:0 auto');
                if (styles.length) html += ' style="' + styles.join(';') + '"';
                html += '>';
                return html;
            });
        };

        if (renderedEl) {
            marked.setOptions({ mangle: false, headerIds: false });
            const processed = applyImageSizeSyntax(raw);
            const html = processed ? marked.parse(processed) : "";
            const clean = html ? DOMPurify.sanitize(html, { USE_PROFILES: { html: true } }) : "";
            renderedEl.innerHTML = clean;
        }

        mermaid.initialize({ startOnLoad: false });
        document.querySelectorAll("code.language-mermaid").forEach((block) => {
            const code = block.textContent;
            const container = document.createElement("div");
            container.className = "mermaid";
            container.innerHTML = code;
            block.parentNode.replaceWith(container);
        });
        mermaid.init();

        const assetBaseUrl = "<?= esc($assetBaseUrl) ?>";
        const currentDir = "<?= esc($currentDir) ?>";
        document.querySelectorAll("#rendered img").forEach((img) => {
            const src = img.getAttribute("src") || "";
            if (!src || /^(https?:)?\/\//i.test(src) || src.startsWith("data:") || src.startsWith("/")) {
                return;
            }
            const base = "http://local/" + (currentDir ? currentDir + "/" : "");
            const resolved = new URL(src, base).pathname.replace(/^\/+/, "");
            img.setAttribute("src", assetBaseUrl + "?file=" + encodeURIComponent(resolved));
        });

        const toggleBtn = document.getElementById("toggle-btn");
        const sidebar = document.getElementById("sidebar");
        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
            document.body.classList.toggle("nav-collapsed");
        });

        if (window.innerWidth <= 768) {
            sidebar.classList.add("collapsed");
            document.body.classList.add("nav-collapsed");
        }
    </script>
</body>
</html>
