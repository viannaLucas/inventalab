<?php
// Caminho base da documentação (pasta onde ficam os .md)
$baseDir = __DIR__ . '/pages';

// Função recursiva para listar arquivos/pastas (arquivos antes das pastas)
function listDocs($dir, $base)
{
    $files = [];
    $folders = [];

    foreach (scandir($dir) as $file) {
        if ($file[0] === '.') continue; // ignora ocultos
        $path = $dir . '/' . $file;

        if (is_dir($path)) {
            $folders[$file] = listDocs($path, $base);
        } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'md') {
            $files[$file] = str_replace($base . '/', '', $path);
        }
    }

    return $files + $folders; // arquivos primeiro
}

// Lista tudo a partir da raiz
$docs = listDocs($baseDir, $baseDir);

// Página atual
$current = $_GET['page'] ?? "1.1 Introdução.md";
if(!is_string($current) || substr($current, -3) !='.md'){
    echo "Arquivo inválido";
    exit;
}
$currentPath = realpath($baseDir . "/" . $current);

// Segurança
if (!$currentPath || strpos($currentPath, $baseDir) !== 0 || !is_file($currentPath)) {
    $currentPath = $baseDir . "/1.1 Introdução.md";
}

// Cria array linear para navegação anterior/próximo
function flattenDocs($items)
{
    $list = [];
    foreach ($items as $v) {
        if (is_array($v)) {
            $list = array_merge($list, flattenDocs($v));
        } else {
            $list[] = $v;
        }
    }
    return $list;
}
$flat = flattenDocs($docs);
$pos = array_search(str_replace($baseDir . '/', '', $currentPath), $flat);
$prev = $flat[$pos - 1] ?? null;
$next = $flat[$pos + 1] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>📑 Documentação</title>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>
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
            position: absolute; /* não ocupa espaço no layout */
        }
        main {
            flex: 1;
            padding: 2rem;
            overflow: auto;
            transition: width 0.3s ease;
        }
        body.nav-collapsed main {
            width: 100vw; /* ocupa toda a tela quando o menu está retraído */
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
        <h3>📂 Documentação</h3>
        <?php
        function renderMenu($items)
        {
            echo "<ul>";
            foreach ($items as $name => $val) {
                if (is_array($val)) {
                    echo "<li><span class='folder'>📁 " . htmlspecialchars($name) . "</span>";
                    renderMenu($val); // itens da pasta
                    echo "</li>";
                } else {
                    $label = basename($name, ".md");
                    echo "<li><a href='?page=" . urlencode($val) . "'>📄 " . htmlspecialchars($label) . "</a></li>";
                }
            }
            echo "</ul>";
        }
        renderMenu($docs);
        ?>
    </nav>

    <main>
        <div id="content" style="display:none"><?php echo file_get_contents($currentPath); ?></div>
        <div id="rendered"></div>

        <div id="nav-buttons">
            <?php if ($prev): ?>
                <?php $prevLabel = basename($prev, ".md"); ?>
                <a href="?page=<?= urlencode($prev) ?>">⬅️ <?= htmlspecialchars($prevLabel) ?></a>
            <?php else: ?><span></span><?php endif; ?>

            <?php if ($next): ?>
                <?php $nextLabel = basename($next, ".md"); ?>
                <a href="?page=<?= urlencode($next) ?>"><?= htmlspecialchars($nextLabel) ?> ➡️</a>
            <?php endif; ?>
        </div>
    </main>

    <script>
        // Render Markdown
        let raw = document.getElementById("content").innerText;
        document.getElementById("rendered").innerHTML = marked.parse(raw);

        // Render Mermaid
        mermaid.initialize({ startOnLoad: false });
        document.querySelectorAll("code.language-mermaid").forEach((block) => {
            const code = block.textContent;
            const container = document.createElement("div");
            container.className = "mermaid";
            container.innerHTML = code;
            block.parentNode.replaceWith(container);
        });
        mermaid.init();

        // Toggle Menu
        const toggleBtn = document.getElementById("toggle-btn");
        const sidebar = document.getElementById("sidebar");

        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
            document.body.classList.toggle("nav-collapsed");
        });

        // Se for mobile, já inicia retraído
        if (window.innerWidth <= 768) {
            sidebar.classList.add("collapsed");
            document.body.classList.add("nav-collapsed");
        }
    </script>
</body>
</html>
