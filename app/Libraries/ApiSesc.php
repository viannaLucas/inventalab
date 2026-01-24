<?php
namespace App\Libraries;

final class ApiSesc
{
    private const DEFAULT_BASE_URL = 'https://sescschom.mxmwebmanager.com.br';

    private const ENDPOINT_CADASTRAR_CLIENTE = '/webmanager/api/InterfacedoCliente/GravarSincrono';
    private const ENDPOINT_CONSULTAR_CLIENTE = '/webmanager/api/InterfaceDoCliente/ConsultaporCPFouCNPJ';
    private const ENDPOINT_CADASTRAR_FATURA = '/webmanager/api/InterfacedaFatura/Gravar';
    private const ENDPOINT_CONSULTAR_FATURA_PROCESSO = '/webmanager/api/InterfacedaFatura/ConsultaporProcesso';
    private const ENDPOINT_CADASTRAR_SERVICO_NOTA = '/webmanager/api/InterfacedoMaterialBemServico/Gravar';
    private const ENDPOINT_CONSULTAR_SERVICO_PROCESSO = '/webmanager/api/InterfacedoMaterialBemServico/ConsultaporProcesso';
    private const ENDPOINT_CONSULTAR_SERVICO_PROCESSO_ALT = '/webmanager/api/InterfacedoMaterialBemServico/ConsultaporProcessoeSequencia';
    private const ENDPOINT_CONSULTAR_SERVICO_NOTA = '/webmanager/api/InterfacedoMaterialBemServico/ConsultaMaterialBemServicoP';
    private const ENDPOINT_CADASTRAR_PRODUTO_SERVICO_NOTA = '/webmanager/api/InterfacedoProduto/Gravar';
    private const ENDPOINT_CONSULTAR_PRODUTO_PROCESSO = '/webmanager/api/InterfacedoProduto/ConsultaporProcesso';
    private const ENDPOINT_CONSULTAR_PRODUTO_PROCESSO_ALT = '/webmanager/api/InterfacedoProduto/ConsultaporProcessoeSequencia';
    private const ENDPOINT_CONSULTAR_PRODUTO_SERVICO_NOTA = '/webmanager/api/InterfacedoProduto/ConsultaProdutoServico';

    private string $baseUrl;
    private string $authorizationHeader;
    private string $username;
    private string $password;
    private string $environment;
    private ?int $timeoutSeconds;
    private int $waitTimeoutSeconds;
    private int $waitIntervalSeconds;

    public function __construct(array $config = [])
    {
        $this->baseUrl = trim((string) ($config['base_url'] ?? getenv('MXM_WEBMANAGER_BASE_URL') ?: self::DEFAULT_BASE_URL));
        $this->authorizationHeader = trim((string) ($config['authorization_header'] ?? getenv('MXM_WEBMANAGER_AUTHORIZATION') ?: ''));
        $this->username = trim((string) ($config['username'] ?? getenv('MXM_WEBMANAGER_USERNAME') ?: 'INTEGRACAOSC'));
        $this->password = (string) ($config['password'] ?? getenv('MXM_WEBMANAGER_PASSWORD') ?: 'A1x5ubs5a18g#p0');
        $this->environment = trim((string) ($config['environment'] ?? getenv('MXM_WEBMANAGER_ENVIRONMENT') ?: 'SESCSCHOM'));

        $timeout = $config['timeout_seconds'] ?? null;
        if ($timeout === null || $timeout === '') {
            $this->timeoutSeconds = null;
        } else {
            $this->timeoutSeconds = max(1, (int) $timeout);
        }

        $waitTimeout = (int) ($config['wait_timeout_seconds'] ?? getenv('MXM_WEBMANAGER_WAIT_TIMEOUT') ?? 120);
        $waitInterval = (int) ($config['wait_interval_seconds'] ?? getenv('MXM_WEBMANAGER_WAIT_INTERVAL') ?? 3);
        $this->waitTimeoutSeconds = max(1, min($waitTimeout, 300));
        $this->waitIntervalSeconds = max(1, min($waitInterval, 30));
    }

    public function cadastrarCliente(array $data): array
    {
        return $this->enviar(self::ENDPOINT_CADASTRAR_CLIENTE, $data);
    }

    public function consultarCliente(array $data): array
    {
        return $this->enviar(self::ENDPOINT_CONSULTAR_CLIENTE, $data);
    }

    public function cadastrarFatura(array $data): array
    {
        return $this->enviarComAcompanhamentoFatura($data);
    }

    public function cadastrarServicoNota(array $data): array
    {
        return $this->enviarComAcompanhamentoServicoNota($data);
    }

    public function consultarServicoNota(array $data): array
    {
        return $this->enviar(self::ENDPOINT_CONSULTAR_SERVICO_NOTA, $data);
    }

    public function cadastrarProdutoServicoNota(array $data): array
    {
        return $this->enviarComAcompanhamentoProdutoServicoNota($data);
    }

    public function consultarProdutoServicoNota(array $data): array
    {
        return $this->enviar(self::ENDPOINT_CONSULTAR_PRODUTO_SERVICO_NOTA, $data);
    }

    private function enviar(string $path, array $data): array
    {
        $url = $this->montarUrl($path);
        $payload = $this->montarPayload($data);
        $sanitizedPayload = $this->sanitizarPayload($payload);

        if ($url === null) {
            return [
                'request' => [
                    'url' => null,
                    'http_code' => 0,
                    'authorization' => $this->sanitizarAuthorizationHeader($this->authorizationHeader),
                    'payload' => $sanitizedPayload,
                ],
                'curl_error' => 'Base URL nao configurada.',
                'raw_response' => null,
                'decoded_response' => null,
            ];
        }

        $result = $this->postJson($url, $payload);

        return [
            'request' => [
                'url' => $url,
                'http_code' => $result['http_code'],
                'authorization' => $this->sanitizarAuthorizationHeader($this->authorizationHeader),
                'payload' => $sanitizedPayload,
            ],
            'curl_error' => $result['curl_error'],
            'raw_response' => $result['raw_response'],
            'decoded_response' => $result['decoded_response'],
        ];
    }

    private function enviarComAcompanhamentoFatura(array $data): array
    {
        $resultado = $this->enviar(self::ENDPOINT_CADASTRAR_FATURA, $data);
        $processId = $this->extrairProcessId($resultado['decoded_response'] ?? null);
        if ($processId === null) {
            $resultado['follow_up'] = null;
            return $resultado;
        }

        $resultado['follow_up'] = $this->acompanharFatura($processId);

        return $resultado;
    }

    private function enviarComAcompanhamentoServicoNota(array $data): array
    {
        $resultado = $this->enviar(self::ENDPOINT_CADASTRAR_SERVICO_NOTA, $data);
        $processId = $this->extrairProcessId($resultado['decoded_response'] ?? null);
        if ($processId === null) {
            $resultado['follow_up'] = null;
            return $resultado;
        }

        $resultado['follow_up'] = $this->acompanharServicoNota(
            $processId,
            $this->normalizarData($data)
        );

        return $resultado;
    }

    private function enviarComAcompanhamentoProdutoServicoNota(array $data): array
    {
        $resultado = $this->enviar(self::ENDPOINT_CADASTRAR_PRODUTO_SERVICO_NOTA, $data);
        $processId = $this->extrairProcessId($resultado['decoded_response'] ?? null);
        if ($processId === null) {
            $resultado['follow_up'] = null;
            return $resultado;
        }

        $resultado['follow_up'] = $this->acompanharProdutoServicoNota(
            $processId,
            $this->normalizarData($data)
        );

        return $resultado;
    }

    private function montarToken(): array
    {
        return [
            'Username' => $this->username,
            'Password' => $this->password,
            'EnvironmentName' => $this->environment,
        ];
    }

    private function montarPayload(array $data): array
    {
        return [
            'AutheticationToken' => $this->montarToken(),
            'Data' => $this->normalizarData($data),
        ];
    }

    private function normalizarData(array $data): array
    {
        if (isset($data['Data']) && is_array($data['Data'])) {
            return $data['Data'];
        }

        return $data;
    }

    private function montarUrl(string $path): ?string
    {
        $base = trim($this->baseUrl);
        if ($base === '') {
            return null;
        }

        return rtrim($base, '/') . $path;
    }

    private function sanitizarAuthorizationHeader(string $authorizationHeader): ?string
    {
        $authorizationHeader = trim($authorizationHeader);
        if ($authorizationHeader === '') {
            return null;
        }

        $authorizationHeader = preg_replace('/\\s+/', ' ', $authorizationHeader) ?? $authorizationHeader;

        if (stripos($authorizationHeader, 'Bearer ') === 0) {
            return 'Bearer ***';
        }

        return '***';
    }

    private function sanitizarPayload(array $payload): array
    {
        if (isset($payload['AutheticationToken']['Password'])) {
            $payload['AutheticationToken']['Password'] = '***';
        }

        return $payload;
    }

    private function extrairProcessId($decodedResponse): ?int
    {
        if (!is_array($decodedResponse) || (($decodedResponse['Success'] ?? null) !== true)) {
            return null;
        }

        $data = $decodedResponse['Data'] ?? null;
        if (is_int($data)) {
            return $data;
        }

        if (is_string($data) && ctype_digit($data)) {
            return (int) $data;
        }

        return null;
    }

    private function acompanharFatura(int $processId): array
    {
        $consultUrl = $this->montarUrl(self::ENDPOINT_CONSULTAR_FATURA_PROCESSO);
        $consultPayload = [
            'AutheticationToken' => $this->montarToken(),
            'Data' => [
                'SequenciadoProcesso' => $processId,
            ],
        ];
        $sanitizedConsultPayload = $this->sanitizarPayload($consultPayload);

        $start = microtime(true);
        $attempts = 0;
        $done = false;
        $mensagem = null;
        $mensagens = [];
        $consultResult = null;

        while (true) {
            $attempts++;

            if ($consultUrl === null) {
                $consultResult = [
                    'http_code' => 0,
                    'curl_error' => 'Base URL nao configurada.',
                    'raw_response' => null,
                    'decoded_response' => null,
                ];
                break;
            }

            $consultResult = $this->postJson($consultUrl, $consultPayload);

            $decoded = $consultResult['decoded_response'];
            $mensagem = null;
            $mensagens = [];
            if (is_array($decoded)) {
                $data = $decoded['Data'] ?? null;
                $faturas = is_array($data) ? ($data['InterfacedaFatura'] ?? null) : null;
                if (is_array($faturas)) {
                    if (!isset($faturas[0]) && (isset($faturas['Mensagem']) || isset($faturas['SequenciadoRegistro']))) {
                        $faturas = [$faturas];
                    }

                    foreach ($faturas as $fatura) {
                        if (!is_array($fatura) || !isset($fatura['Mensagem'])) {
                            continue;
                        }
                        $msg = trim((string) $fatura['Mensagem']);
                        if ($msg !== '') {
                            $mensagens[] = $msg;
                        }
                    }

                    $mensagens = array_values(array_unique($mensagens));
                }
            }

            $done = false;
            foreach ($mensagens as $msg) {
                $normalizada = $this->normalizarMensagem($msg);
                $isNotProcessed = stripos($normalizada, 'Nao Processado') !== false;
                if (stripos($normalizada, 'Processado') !== false && !$isNotProcessed) {
                    $done = true;
                    $mensagem = $msg;
                    break;
                }
            }

            if ($mensagem === null && isset($mensagens[0])) {
                $mensagem = $mensagens[0];
            }

            $elapsed = microtime(true) - $start;
            if ($done || $elapsed >= $this->waitTimeoutSeconds) {
                break;
            }

            sleep($this->waitIntervalSeconds);
        }

        return [
            'wait' => [
                'enabled' => true,
                'process_id' => $processId,
                'timeout_seconds' => $this->waitTimeoutSeconds,
                'interval_seconds' => $this->waitIntervalSeconds,
                'attempts' => $attempts,
                'elapsed_seconds' => round(microtime(true) - $start, 3),
                'done' => $done,
                'mensagem' => $mensagem,
                'mensagens' => $mensagens,
            ],
            'consult_request' => [
                'url' => $consultUrl,
                'payload' => $sanitizedConsultPayload,
            ],
            'consult_response' => $consultResult,
        ];
    }

    private function acompanharServicoNota(int $processId, array $data): array
    {
        $consultUrl = $this->montarUrl(self::ENDPOINT_CONSULTAR_SERVICO_PROCESSO);
        $consultUrlAlt = $this->montarUrl(self::ENDPOINT_CONSULTAR_SERVICO_PROCESSO_ALT);
        $catalogUrl = $this->montarUrl(self::ENDPOINT_CONSULTAR_SERVICO_NOTA);

        $consultPayload = [
            'AutheticationToken' => $this->montarToken(),
            'Data' => [
                'SequenciadoProcesso' => $processId,
            ],
        ];
        $sanitizedConsultPayload = $this->sanitizarPayload($consultPayload);
        $expectedItems = $this->extrairItensServicoEsperados($data);

        $start = microtime(true);
        $attempts = 0;
        $done = false;
        $mensagem = null;
        $mensagens = [];
        $consultResult = null;
        $consultUrlInUse = $consultUrl;
        $catalogCheck = null;

        while (true) {
            $attempts++;

            if ($consultUrlInUse === null) {
                $consultResult = [
                    'http_code' => 0,
                    'curl_error' => 'Base URL nao configurada.',
                    'raw_response' => null,
                    'decoded_response' => null,
                ];
                break;
            }

            $consultResult = $this->postJson($consultUrlInUse, $consultPayload);
            if ($consultResult['http_code'] === 404 && $consultUrlAlt !== null && $consultUrlInUse !== $consultUrlAlt) {
                $consultUrlInUse = $consultUrlAlt;
                $consultResult = $this->postJson($consultUrlInUse, $consultPayload);
            }

            $decoded = $consultResult['decoded_response'];
            $mensagem = null;
            $mensagens = [];
            if (is_array($decoded)) {
                $dataDecoded = $decoded['Data'] ?? null;
                $itens = is_array($dataDecoded) ? ($dataDecoded['InterfacedoMaterialBemServico'] ?? null) : null;

                if (is_array($itens)) {
                    if (!isset($itens[0]) && (isset($itens['Mensagem']) || isset($itens['SequenciadoRegistro']))) {
                        $itens = [$itens];
                    }

                    foreach ($itens as $item) {
                        if (!is_array($item) || !isset($item['Mensagem'])) {
                            continue;
                        }
                        $msg = trim((string) $item['Mensagem']);
                        if ($msg !== '') {
                            $mensagens[] = $msg;
                        }
                    }

                    $mensagens = array_values(array_unique($mensagens));
                }
            }

            $done = false;
            foreach ($mensagens as $msg) {
                $normalizada = $this->normalizarMensagem($msg);
                $isNotProcessed = stripos($normalizada, 'Nao Processado') !== false;
                if (stripos($normalizada, 'Processado') !== false && !$isNotProcessed) {
                    $done = true;
                    $mensagem = $msg;
                    break;
                }
            }

            if (!$done && $expectedItems !== []) {
                foreach ($expectedItems as $expected) {
                    if ($catalogUrl === null) {
                        $catalogCheck = [
                            'found' => false,
                            'expected' => $expected,
                            'request' => [
                                'url' => null,
                                'payload' => null,
                            ],
                            'response' => [
                                'http_code' => 0,
                                'curl_error' => 'Base URL nao configurada.',
                                'raw_response' => null,
                                'decoded_response' => null,
                            ],
                        ];
                        break;
                    }

                    $catalogPayload = [
                        'AutheticationToken' => $this->montarToken(),
                        'Data' => [
                            'CodigodoMaterialBemServico' => $expected['codigo'],
                            'TipodeItem' => $expected['tipo'],
                        ],
                    ];

                    $sanitizedCatalogPayload = $this->sanitizarPayload($catalogPayload);
                    $catalogResult = $this->postJson($catalogUrl, $catalogPayload);
                    $catalogData = null;
                    if (is_array($catalogResult['decoded_response'])) {
                        $catalogData = $catalogResult['decoded_response']['Data'] ?? null;
                    }

                    $found = is_array($catalogData) && count($catalogData) > 0;
                    $catalogCheck = [
                        'found' => $found,
                        'expected' => $expected,
                        'request' => [
                            'url' => $catalogUrl,
                            'payload' => $sanitizedCatalogPayload,
                        ],
                        'response' => $catalogResult,
                    ];

                    if ($found) {
                        $done = true;
                        $mensagem = 'Item localizado em ConsultaMaterialBemServicoP';
                        break;
                    }
                }
            }

            if ($mensagem === null && isset($mensagens[0])) {
                $mensagem = $mensagens[0];
            }

            $elapsed = microtime(true) - $start;
            if ($done || $elapsed >= $this->waitTimeoutSeconds) {
                break;
            }

            sleep($this->waitIntervalSeconds);
        }

        return [
            'wait' => [
                'enabled' => true,
                'process_id' => $processId,
                'timeout_seconds' => $this->waitTimeoutSeconds,
                'interval_seconds' => $this->waitIntervalSeconds,
                'attempts' => $attempts,
                'elapsed_seconds' => round(microtime(true) - $start, 3),
                'done' => $done,
                'mensagem' => $mensagem,
                'mensagens' => $mensagens,
            ],
            'consult_request' => [
                'url' => $consultUrlInUse,
                'payload' => $sanitizedConsultPayload,
            ],
            'consult_response' => $consultResult,
            'catalog_check' => $catalogCheck,
        ];
    }

    private function acompanharProdutoServicoNota(int $processId, array $data): array
    {
        $consultUrl = $this->montarUrl(self::ENDPOINT_CONSULTAR_PRODUTO_PROCESSO);
        $consultUrlAlt = $this->montarUrl(self::ENDPOINT_CONSULTAR_PRODUTO_PROCESSO_ALT);
        $catalogUrl = $this->montarUrl(self::ENDPOINT_CONSULTAR_PRODUTO_SERVICO_NOTA);

        $consultPayload = [
            'AutheticationToken' => $this->montarToken(),
            'Data' => [
                'SequenciadoProcesso' => $processId,
            ],
        ];
        $sanitizedConsultPayload = $this->sanitizarPayload($consultPayload);
        $expectedItems = $this->extrairItensProdutoEsperados($data);

        $start = microtime(true);
        $attempts = 0;
        $done = false;
        $mensagem = null;
        $consultResult = null;
        $consultUrlInUse = $consultUrl;
        $catalogCheck = null;

        while (true) {
            $attempts++;

            if ($consultUrlInUse === null) {
                $consultResult = [
                    'http_code' => 0,
                    'curl_error' => 'Base URL nao configurada.',
                    'raw_response' => null,
                    'decoded_response' => null,
                ];
                break;
            }

            $consultResult = $this->postJson($consultUrlInUse, $consultPayload);
            if ($consultResult['http_code'] === 404 && $consultUrlAlt !== null && $consultUrlInUse !== $consultUrlAlt) {
                $consultUrlInUse = $consultUrlAlt;
                $consultResult = $this->postJson($consultUrlInUse, $consultPayload);
            }

            $fatalErrors = [];
            $decoded = $consultResult['decoded_response'];
            if (is_array($decoded)) {
                $dataDecoded = $decoded['Data'] ?? null;
                $itens = is_array($dataDecoded) ? ($dataDecoded['InterfacedoProduto'] ?? null) : null;
                if (is_array($itens)) {
                    foreach ($itens as $item) {
                        if (!is_array($item)) {
                            continue;
                        }
                        $errors = $item['InterfaceErrodoProduto'] ?? null;
                        if (is_array($errors) && count($errors) > 0) {
                            $fatalErrors = $errors;
                            break;
                        }
                    }
                }
            }

            if ($fatalErrors !== []) {
                $done = true;
                $mensagem = 'Processado com Erros';
            }

            if (!$done && $expectedItems !== []) {
                foreach ($expectedItems as $expected) {
                    if ($catalogUrl === null) {
                        $catalogCheck = [
                            'found' => false,
                            'expected' => $expected,
                            'request' => [
                                'url' => null,
                                'payload' => null,
                            ],
                            'response' => [
                                'http_code' => 0,
                                'curl_error' => 'Base URL nao configurada.',
                                'raw_response' => null,
                                'decoded_response' => null,
                            ],
                        ];
                        break;
                    }

                    $catalogPayload = [
                        'AutheticationToken' => $this->montarToken(),
                        'Data' => [
                            'Codigo' => $expected['codigo'],
                            'ProdutoServico' => $expected['produto_servico'],
                        ],
                    ];

                    $sanitizedCatalogPayload = $this->sanitizarPayload($catalogPayload);
                    $catalogResult = $this->postJson($catalogUrl, $catalogPayload);
                    $catalogData = null;
                    if (is_array($catalogResult['decoded_response'])) {
                        $catalogData = $catalogResult['decoded_response']['Data'] ?? null;
                    }

                    $found = is_array($catalogData) && count($catalogData) > 0;
                    $catalogCheck = [
                        'found' => $found,
                        'expected' => $expected,
                        'request' => [
                            'url' => $catalogUrl,
                            'payload' => $sanitizedCatalogPayload,
                        ],
                        'response' => $catalogResult,
                    ];

                    if ($found) {
                        $done = true;
                        $mensagem = 'Item localizado em ConsultaProdutoServico';
                        break;
                    }
                }
            }

            $elapsed = microtime(true) - $start;
            if ($done || $elapsed >= $this->waitTimeoutSeconds) {
                break;
            }

            sleep($this->waitIntervalSeconds);
        }

        return [
            'wait' => [
                'enabled' => true,
                'process_id' => $processId,
                'timeout_seconds' => $this->waitTimeoutSeconds,
                'interval_seconds' => $this->waitIntervalSeconds,
                'attempts' => $attempts,
                'elapsed_seconds' => round(microtime(true) - $start, 3),
                'done' => $done,
                'mensagem' => $mensagem,
            ],
            'consult_request' => [
                'url' => $consultUrlInUse,
                'payload' => $sanitizedConsultPayload,
            ],
            'consult_response' => $consultResult,
            'catalog_check' => $catalogCheck,
        ];
    }

    private function extrairItensServicoEsperados(array $data): array
    {
        $expected = [];
        $itens = $data['InterfacedoMaterialBemServico'] ?? null;
        if (!is_array($itens)) {
            return [];
        }

        foreach ($itens as $item) {
            if (!is_array($item)) {
                continue;
            }
            $codigo = $item['CodigoMaterialBemServico'] ?? '';
            $codigo = is_string($codigo) ? trim($codigo) : '';
            if ($codigo === '') {
                continue;
            }

            $tipo = $item['TipoMaterialBemServico'] ?? '';
            $tipo = is_string($tipo) ? strtoupper(trim($tipo)) : '';
            if ($tipo === '') {
                $tipo = 'S';
            }

            $expected[] = [
                'codigo' => substr($codigo, 0, 15),
                'tipo' => in_array($tipo, ['E', 'P', 'S'], true) ? $tipo : 'S',
            ];
        }

        return array_values(array_unique($expected, SORT_REGULAR));
    }

    private function extrairItensProdutoEsperados(array $data): array
    {
        $expected = [];
        $itens = $data['InterfacedoProduto'] ?? null;
        if (!is_array($itens)) {
            return [];
        }

        foreach ($itens as $item) {
            if (!is_array($item)) {
                continue;
            }
            $codigo = $item['CodigodoProduto'] ?? '';
            $codigo = is_string($codigo) ? trim($codigo) : '';
            if ($codigo === '') {
                continue;
            }

            $tipo = $item['IndicacaodeProdutoouServico'] ?? '';
            $tipo = is_string($tipo) ? strtoupper(trim($tipo)) : '';
            if ($tipo === '' || !in_array($tipo, ['P', 'S'], true)) {
                $tipo = 'S';
            }

            $expected[] = [
                'codigo' => substr($codigo, 0, 15),
                'produto_servico' => $tipo,
            ];
        }

        return array_values(array_unique($expected, SORT_REGULAR));
    }

    private function normalizarMensagem(string $mensagem): string
    {
        $mensagem = trim($mensagem);
        if ($mensagem === '') {
            return $mensagem;
        }

        if (function_exists('iconv')) {
            $convertida = @iconv('UTF-8', 'ASCII//TRANSLIT', $mensagem);
            if (is_string($convertida) && $convertida !== '') {
                return $convertida;
            }
        }

        return $mensagem;
    }

    private function postJson(string $url, array $payload): array
    {
        $headers = [
            'Content-Type: application/json',
        ];
        if ($this->authorizationHeader !== '') {
            $headers[] = 'Authorization: ' . $this->authorizationHeader;
        }

        $ch = curl_init($url);
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => json_encode(
                $payload,
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            ),
        ];
        if ($this->timeoutSeconds !== null) {
            $options[CURLOPT_TIMEOUT] = $this->timeoutSeconds;
        }

        curl_setopt_array($ch, $options);

        $responseBody = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $decodedResponse = null;
        if (is_string($responseBody) && $responseBody !== '') {
            $decodedResponse = json_decode($responseBody, true);
        }

        return [
            'http_code' => $httpCode,
            'curl_error' => $curlError !== '' ? $curlError : null,
            'raw_response' => $responseBody,
            'decoded_response' => $decodedResponse,
        ];
    }
}
