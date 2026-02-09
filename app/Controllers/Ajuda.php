<?php

namespace App\Controllers;

use App\Controllers\BaseController;


class Ajuda extends BaseController
{

    public function index()
    {
        $baseDir = rtrim(WRITEPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'ajuda_arquivos';
        $baseDirReal = realpath($baseDir);

        if ($baseDirReal === false || !is_dir($baseDirReal)) {
            return view('Ajuda/templateAjuda', [
                'erro' => 'Diretorio de ajuda nao encontrado em ' . $baseDir,
            ]);
        }

        $docs = $this->listDocs($baseDirReal, $baseDirReal);
        $flat = $this->flattenDocs($docs);
        $defaultPage = $flat[0] ?? null;

        $current = $this->request->getGet('page');
        if (!is_string($current) || $current === '') {
            $current = $defaultPage;
        }

        if (!is_string($current) || substr($current, -3) !== '.md') {
            return view('Ajuda/templateAjuda', [
                'erro' => 'Arquivo invalido.',
            ]);
        }

        $currentPath = realpath($baseDirReal . DIRECTORY_SEPARATOR . $current);
        if ($currentPath === false || strpos($currentPath, $baseDirReal) !== 0 || !is_file($currentPath)) {
            $current = $defaultPage;
            $currentPath = $current ? realpath($baseDirReal . DIRECTORY_SEPARATOR . $current) : false;
        }

        if (!$currentPath || !$current) {
            return view('Ajuda/templateAjuda', [
                'erro' => 'Nenhum arquivo .md encontrado em ' . $baseDirReal,
            ]);
        }

        $pos = array_search(str_replace($baseDirReal . DIRECTORY_SEPARATOR, '', $currentPath), $flat, true);
        $prev = ($pos !== false) ? ($flat[$pos - 1] ?? null) : null;
        $next = ($pos !== false) ? ($flat[$pos + 1] ?? null) : null;

        $currentContent = file_get_contents($currentPath) ?: '';
        $currentContent = $this->rewriteImageLinks($currentContent);
        $currentContent = $this->rewriteHelpLinks($currentContent);
        $currentDir = trim(str_replace($baseDirReal, '', dirname($currentPath)), DIRECTORY_SEPARATOR);

        return view('Ajuda/templateAjuda', [
            'docs' => $docs,
            'currentContent' => $currentContent,
            'prev' => $prev,
            'next' => $next,
            'currentDir' => $currentDir,
            'assetBaseUrl' => base_url('Ajuda/arquivo'),
        ]);
    }

    public function arquivo()
    {
        $baseDir = rtrim(WRITEPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'ajuda_arquivos';
        $baseDirReal = realpath($baseDir);
        if ($baseDirReal === false || !is_dir($baseDirReal)) {
            return $this->response->setStatusCode(404);
        }

        $file = $this->request->getGet('file');
        if (!is_string($file) || $file === '' || strpos($file, "\0") !== false) {
            return $this->response->setStatusCode(404);
        }

        $file = ltrim(str_replace('\\', '/', $file), '/');
        $path = realpath($baseDirReal . DIRECTORY_SEPARATOR . $file);

        if ($path === false || strpos($path, $baseDirReal) !== 0 || !is_file($path)) {
            return $this->response->setStatusCode(404);
        }

        $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if ($ext === '' || !in_array($ext, $allowedExtensions, true)) {
            return $this->response->setStatusCode(404);
        }

        $mime = mime_content_type($path) ?: 'application/octet-stream';
        $this->response->setHeader('Content-Type', $mime);
        $this->response->setBody((string) file_get_contents($path));
        return $this->response;
    }

    public function img()
    {
        $baseDir = rtrim(WRITEPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'ajuda_arquivos' . DIRECTORY_SEPARATOR . 'img';
        $baseDirReal = realpath($baseDir);
        if ($baseDirReal === false || !is_dir($baseDirReal)) {
            return $this->response->setStatusCode(404);
        }

        $segments = $this->request->getUri()->getSegments();
        $fileSegments = array_slice($segments, 2);
        if (!$fileSegments) {
            return $this->response->setStatusCode(404);
        }

        $file = implode('/', $fileSegments);
        if (strpos($file, "\0") !== false) {
            return $this->response->setStatusCode(404);
        }

        $file = ltrim(str_replace('\\', '/', $file), '/');
        $path = realpath($baseDirReal . DIRECTORY_SEPARATOR . $file);
        if ($path === false || strpos($path, $baseDirReal) !== 0 || !is_file($path)) {
            return $this->response->setStatusCode(404);
        }

        $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if ($ext === '' || !in_array($ext, $allowedExtensions, true)) {
            return $this->response->setStatusCode(404);
        }

        $mime = mime_content_type($path) ?: 'application/octet-stream';
        $this->response->setHeader('Content-Type', $mime);
        $this->response->setBody((string) file_get_contents($path));
        return $this->response;
    }

    private function listDocs(string $dir, string $base): array
    {
        $files = [];
        $folders = [];

        foreach (scandir($dir) as $file) {
            if ($file[0] === '.') {
                continue;
            }
            if ($file === 'img') {
                continue;
            }

            $path = $dir . DIRECTORY_SEPARATOR . $file;

            if (is_dir($path)) {
                $folders[$file] = $this->listDocs($path, $base);
                continue;
            }

            if (pathinfo($file, PATHINFO_EXTENSION) === 'md') {
                $files[$file] = str_replace($base . DIRECTORY_SEPARATOR, '', $path);
            }
        }

        return $files + $folders;
    }

    private function flattenDocs(array $items): array
    {
        $list = [];
        foreach ($items as $val) {
            if (is_array($val)) {
                $list = array_merge($list, $this->flattenDocs($val));
                continue;
            }
            $list[] = $val;
        }
        return $list;
    }

    private function rewriteImageLinks(string $content): string
    {
        if ($content === '') {
            return $content;
        }

        $base = base_url('Ajuda/img/');

        $content = preg_replace_callback(
            '/!\[([^\]]*)\]\(([^)\s]+)(?:\s+"[^"]*")?\)/',
            static function ($m) use ($base) {
                $alt = $m[1] ?? '';
                $url = $m[2] ?? '';
                if ($url === '' || preg_match('#^(https?:)?//#i', $url) || str_starts_with($url, 'data:') || str_starts_with($url, '/')) {
                    return $m[0];
                }
                return '![' . $alt . '](' . $base . ltrim($url, '/') . ')';
            },
            $content
        );

        $content = preg_replace_callback(
            '/<img\b[^>]*\bsrc=["\']([^"\']+)["\'][^>]*>/i',
            static function ($m) use ($base) {
                $url = $m[1] ?? '';
                if ($url === '' || preg_match('#^(https?:)?//#i', $url) || str_starts_with($url, 'data:') || str_starts_with($url, '/')) {
                    return $m[0];
                }
                $safe = $base . ltrim($url, '/');
                return str_replace($m[1], $safe, $m[0]);
            },
            $content
        );

        return $content;
    }

    private function rewriteHelpLinks(string $content): string
    {
        if ($content === '') {
            return $content;
        }

        $base = base_url('Ajuda/index');

        $content = preg_replace_callback(
            '/\[[^\]]*\]\(([^)\s]+)(?:\s+"[^"]*")?\)/',
            static function ($m) use ($base) {
                $url = $m[1] ?? '';
                if ($url === '' || $url[0] !== '?') {
                    return $m[0];
                }
                $query = substr($url, 1);
                parse_str($query, $params);
                if (!isset($params['page'])) {
                    return $m[0];
                }
                $safe = $base . '?' . http_build_query($params);
                return str_replace($m[1], $safe, $m[0]);
            },
            $content
        );

        $content = preg_replace_callback(
            '/<a\b[^>]*\bhref=["\']([^"\']+)["\'][^>]*>/i',
            static function ($m) use ($base) {
                $url = $m[1] ?? '';
                if ($url === '' || $url[0] !== '?') {
                    return $m[0];
                }
                $query = substr($url, 1);
                parse_str($query, $params);
                if (!isset($params['page'])) {
                    return $m[0];
                }
                $safe = $base . '?' . http_build_query($params);
                return str_replace($m[1], $safe, $m[0]);
            },
            $content
        );

        return $content;
    }
    
}
