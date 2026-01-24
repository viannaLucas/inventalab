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

// Cria array linear com todos arquivos em ordem
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
            margin: 0;
            font-family: Arial, sans-serif;
            padding: 2rem;
        }
        pre {
            background: #222;
            color: #eee;
            padding: .7rem;
            border-radius: 6px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <?php foreach ($flat as $doc): ?>
        <section class="doc-section">
            <div class="content" style="display:none"><?php echo file_get_contents($baseDir . "/" . $doc); ?></div>
            <div class="rendered"></div>
            <hr>
        </section>
    <?php endforeach; ?>

    <script>
        // Render todos os blocos
        document.querySelectorAll(".doc-section").forEach(section => {
            let raw = section.querySelector(".content").innerText;
            section.querySelector(".rendered").innerHTML = marked.parse(raw);
        });

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
    </script>
</body>
</html>
