<?php

namespace App\Controllers;

use App\Controllers\BaseController;


class Ajuda extends BaseController
{

    const arquivosPermitidos = [
        'writable/ajuda_arquivos/02 Cobrança/2.1 Cadastrar Cobrança.md',
        'writable/ajuda_arquivos/02 Cobrança/2.2 Pesquisar Cobrança.md',
        'writable/ajuda_arquivos/02 Cobrança/2.3 Alterar Cobrança.md',
        'writable/ajuda_arquivos/03 Evento/3.1 Cadastrar Evento.md',
        'writable/ajuda_arquivos/03 Evento/3.2 Pesquisar Evento.md',
        'writable/ajuda_arquivos/03 Evento/3.3 Alterar Evento.md',
        'writable/ajuda_arquivos/04 Oficina Temática/4.1 Cadastrar Oficina Temática.md',
        'writable/ajuda_arquivos/04 Oficina Temática/4.2 Pesquisar Oficina Temática.md',
        'writable/ajuda_arquivos/04 Oficina Temática/4.3 Alterar Oficina Temática.md',
        'writable/ajuda_arquivos/05 Participante/5.1 Cadastrar Participante.md',
        'writable/ajuda_arquivos/05 Participante/5.2 Pesquisar Participante.md',
        'writable/ajuda_arquivos/05 Participante/5.3 Alterar Participante.md',
        'writable/ajuda_arquivos/06 Recurso de Trabalho/6.1 Cadastrar Recurso de Trabalho.md',
        'writable/ajuda_arquivos/06 Recurso de Trabalho/6.2 Pesquisar Recurso de Trabalho.md',
        'writable/ajuda_arquivos/06 Recurso de Trabalho/6.3 Alterar Recurso de Trabalho.md',
        'writable/ajuda_arquivos/07 Pesquisa Satisfação/7.1 Pesquisar Pesquisa Satisfação.md',
        'writable/ajuda_arquivos/08 Produto/8.1 Cadastrar Produto.md',
        'writable/ajuda_arquivos/08 Produto/8.2 Pesquisar Produto.md',
        'writable/ajuda_arquivos/08 Produto/8.3 Alterar Produto.md',
        'writable/ajuda_arquivos/09 Relatórios/9.1 Relatório Pesquisa Satisfação.md',
        'writable/ajuda_arquivos/09 Relatórios/9.2 Relatório Reservas.md',
        'writable/ajuda_arquivos/09 Relatórios/9.3 Relatório Cobranças.md',
        'writable/ajuda_arquivos/10 Reserva/10.1 Cadastrar Reserva.md',
        'writable/ajuda_arquivos/10 Reserva/10.2 Pesquisar Reserva.md',
        'writable/ajuda_arquivos/10 Reserva/10.3 Alterar Reserva.md',
        'writable/ajuda_arquivos/1.1 Introdução.md',
        'writable/ajuda_arquivos/11 Serviço/11.1 Cadastrar Serviço.md',
        'writable/ajuda_arquivos/11 Serviço/11.2 Pesquisar Serviço.md',
        'writable/ajuda_arquivos/11 Serviço/11.3 Alterar Serviço.md',
        'writable/ajuda_arquivos/12 Configuração/12.1 Configurações Gerais.md',
        'writable/ajuda_arquivos/12 Configuração/12.2 Horário de Funcionamento.md',
        'writable/ajuda_arquivos/12 Configuração/12.3 Termo de Autorização.md',
        'writable/ajuda_arquivos/1.2 Usuários do Sistema.md',
        'writable/ajuda_arquivos/1.3 Página Principal.md',
        'writable/ajuda_arquivos/13 Usuário/13.1 Cadastrar Usuário.md',
        'writable/ajuda_arquivos/13 Usuário/13.2 Pesquisar Usuário.md',
        'writable/ajuda_arquivos/13 Usuário/13.3 Alterar Usuário.md',
        'writable/ajuda_arquivos/img/evento_botoes_presenca.png',
        'writable/ajuda_arquivos/img/evento_cadastro_controle_presenca.png',
        'writable/ajuda_arquivos/img/evento_lista_entrega_material_botao.png',
        'writable/ajuda_arquivos/img/evento_lista_entrega_material_impressao.png',
        'writable/ajuda_arquivos/img/evento_lista_exportar_participantes_botao.png',
        'writable/ajuda_arquivos/img/evento_lista_participante_com_pagamento.png',
        'writable/ajuda_arquivos/img/evento_lista_participante_formulario.png',
        'writable/ajuda_arquivos/img/evento_lista_participante_sem_pagamento.png',
        'writable/ajuda_arquivos/img/evento_lista_participantes.png',
        'writable/ajuda_arquivos/img/evento_lista_presenca_botao_imprimir.png',
        'writable/ajuda_arquivos/img/evento_lista_presenca_botao.png',
        'writable/ajuda_arquivos/img/evento_lista_presenca_impressao.png',
        'writable/ajuda_arquivos/img/evento_selecionar_lista_presenca.png',
        'writable/ajuda_arquivos/img/reserva_atividade_livre_lista_recursos.png',
        'writable/ajuda_arquivos/img/reserva_atividade_livre.png',
        'writable/ajuda_arquivos/img/reserva_atividade_livre_recurso_selecionado.png',
        'writable/ajuda_arquivos/img/reserva_atividade_tematica_janela_selecao.png',
        'writable/ajuda_arquivos/img/reserva_atividade_tematica.png',
        'writable/ajuda_arquivos/img/reserva_atividade_tematica_selecionada.png',
        'writable/ajuda_arquivos/img/reserva_atividade_tematica_visualizar_atividade.png',
        'writable/ajuda_arquivos/img/reserva_campo_escola.png',
        'writable/ajuda_arquivos/img/reserva_campo_escoola_campos_obrigatorios.png',
        'writable/ajuda_arquivos/img/reserva_detalhes_slots_conflito_selecao_indisponivel.png',
        'writable/ajuda_arquivos/img/reserva_detalhes_slots_conflito_selecao_slot_lotado.png',
        'writable/ajuda_arquivos/img/reserva_detalhes_slots_disponibilidade_baixa.png',
        'writable/ajuda_arquivos/img/reserva_detalhes_slots_disponivel.png',
        'writable/ajuda_arquivos/img/reserva_erro_recurso_indisponivel.png',
        'writable/ajuda_arquivos/img/servico_dados_fiscais.png',
        'writable/ajuda_arquivos/img/servico_dados_fiscias_campo_codigo.png',
        'writable/ajuda_arquivos/img/servico_produto_formulario_excluir.png',
        'writable/ajuda_arquivos/img/servico_produto_formulario.png',
        'writable/ajuda_arquivos/img/tela_principal_reservas_adicionando_consumo_definindo_qauntidade.png',
        'writable/ajuda_arquivos/img/tela_principal_reservas_adicionando_consumo.png',
        'writable/ajuda_arquivos/img/tela_principal_reservas_adicionando_consumo_selecionando_servico.png',
        'writable/ajuda_arquivos/img/tela_principal_reservas_aguardando_entrada.png',
        'writable/ajuda_arquivos/img/tela_principal_reservas_aguardando_saida.png',
        'writable/ajuda_arquivos/img/tela_principal_reservas_botao_reserva.png',
        'writable/ajuda_arquivos/img/tela_principal_reservas_confirmar_hora_entrada.png',
        'writable/ajuda_arquivos/img/tela_principal_reservas_menu.png',
        'writable/ajuda_arquivos/img/tela_principal_reservas.png',
        'writable/ajuda_arquivos/img/tela_principal_reservas_realizando_saida_adicionando_servicos.png.png',
        'writable/ajuda_arquivos/img/tela_principal_reservas_realizando_saida_calcular_tempo_uso.png',
        'writable/ajuda_arquivos/img/tela_principal_reservas_realizando_saida_campo_cobranca_paga.png',
        'writable/ajuda_arquivos/img/tela_principal_reservas_saida_realizada.png',
        'writable/ajuda_arquivos/img/tela_principal_reservas_termo_nao_apresentado.png',
    ];

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
        $allowed = array_map(
            static function (string $path): string {
                $path = str_replace('\\', '/', $path);
                $path = preg_replace('#^writable/ajuda_arquivos/#', '', $path);
                return ltrim($path, '/');
            },
            self::arquivosPermitidos
        );
        if (!is_string($current) || $current === '') {
            $current = $defaultPage;
        } else {
            $current = ltrim(str_replace('\\', '/', $current), '/');
            if (!in_array($current, $allowed, true)) {
                return view('Ajuda/templateAjuda', [
                    'erro' => 'Arquivo nao permitido.',
                ]);
            }
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
        $allowed = array_map(
            static function (string $path): string {
                $path = str_replace('\\', '/', $path);
                $path = preg_replace('#^writable/ajuda_arquivos/#', '', $path);
                return ltrim($path, '/');
            },
            self::arquivosPermitidos
        );
        if (!in_array($file, $allowed, true)) {
            return $this->response->setStatusCode(404);
        }
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
