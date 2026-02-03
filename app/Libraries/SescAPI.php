<?php
namespace App\Libraries;


final class SescAPI
{
    private const ENDPOINT_CADASTRAR_CLIENTE = '/webmanager/api/InterfacedoCliente/GravarSincrono';
    private const ENDPOINT_CONSULTAR_CLIENTE = '/webmanager/api/InterfaceDoCliente/ConsultaporCPFouCNPJ';
    private const ENDPOINT_CADASTRAR_FATURA = '/webmanager/api/InterfacedaFatura/Gravar';
    private const ENDPOINT_CONSULTAR_FATURA = '/webmanager/api/InterfacedaFatura/ConsultaporProcesso';
    private const ENDPOINT_CONSULTAR_SERVICO = '/webmanager/api/InterfacedoProduto/ConsultaProdutoServico';

    private string $baseUrl;
    private string $username;
    private string $password;
    private string $environment;
    private ?int $timeoutSeconds;

    public function __construct(array $config = [])
    {
        $this->baseUrl = $this->requireConfigString($config, 'baseUrl');
        $this->username = $this->requireConfigString($config, 'username');
        $this->password = $this->requireConfigString($config, 'password', false);
        $this->environment = $this->requireConfigString($config, 'environment');

        $timeout = $config['timeout_seconds'] ?? null;
        if ($timeout === null || $timeout === '') {
            $this->timeoutSeconds = null;
        } else {
            $this->timeoutSeconds = max(1, (int) $timeout);
        }
    }

    private function requireConfigString(array $config, string $key, bool $trim = true): string
    {
        if (!array_key_exists($key, $config)) {
            throw new \InvalidArgumentException(sprintf('Configuração obrigatória ausente: %s', $key));
        }

        $value = $config[$key];
        if (!is_string($value) && !is_numeric($value)) {
            throw new \InvalidArgumentException(sprintf('Configuração inválida para %s', $key));
        }

        $stringValue = $trim ? trim((string) $value) : (string) $value;
        if ($stringValue === '') {
            throw new \InvalidArgumentException(sprintf('Configuração obrigatória vazia: %s', $key));
        }

        return $stringValue;
    }

    /**
     * Cadastra um cliente.
     *
     * Exemplo do array $dados:
     * [
     *   "SequenciadoRegistro" => 1,
     *   "Codigo" => "150814530920113",
     *   "TipodePessoa" => "F",
     *   "NomeFantansia" => "Claudia Costa",
     *   "Nome" => "Claudia Costa",
     *   "CPFouCNPJ" => "34351204877",
     *   "TipodoLocaldoIndicadordeInscricaoEstadual" => "9",
     *   "Inscricao" => "",
     *   "Email" => "cliente.teste@sesc.com.br",
     *   "Telefone" => "48999999999",
     *   "Endereco" => "Rua Felipe Schmidt",
     *   "NumerodoEndereco" => "752",
     *   "Bairro" => "Centro",
     *   "Cidade" => "Florianopolis",
     *   "Uf" => "SC",
     *   "Cep" => "88010002",
     *   "CodigodoPais" => "BRA",
     *   "CodigodaCidade" => "4205407",
     *   "Pais" => "Brasil",
     *   "Ativo" => "A"
     * ]
     *
     * Exemplo de payload:
     * {
     *   "Data": {
     *     "InterfacedoCliente": [
     *       {
     *         "SequenciadoRegistro": 1,
     *         "Codigo": "150814530920113",
     *         "TipodePessoa": "F",
     *         "NomeFantansia": "Claudia Costa",
     *         "Nome": "Claudia Costa",
     *         "CPFouCNPJ": "34351204877",
     *         "TipodoLocaldoIndicadordeInscricaoEstadual": "9",
     *         "Inscricao": "",
     *         "Email": "cliente.teste@sesc.com.br",
     *         "Telefone": "48999999999",
     *         "Endereco": "Rua Felipe Schmidt",
     *         "NumerodoEndereco": "752",
     *         "Bairro": "Centro",
     *         "Cidade": "Florianopolis",
     *         "Uf": "SC",
     *         "Cep": "88010002",
     *         "CodigodoPais": "BRA",
     *         "CodigodaCidade": "4205407",
     *         "Pais": "Brasil",
     *         "Ativo": "A"
     *       }
     *     ]
     *   }
     * }
     */
    public function cadastroCliente(array $dados): array
    {
        $data = [
            'InterfacedoCliente' => [
                $dados,
            ],
        ];

        return $this->enviar(self::ENDPOINT_CADASTRAR_CLIENTE, $data);
    }

    /**
     * Consulta cliente por CPF/CNPJ.
     *
     * Exemplo de payload:
     * {
     *   "Data": {
     *     "InterfaceDoCliente": [
     *       {
     *         "CPFouCNPJ": "34351204877"
     *       }
     *     ]
     *   }
     * }
     */
    public function consultaCliente(string $cpf): array
    {
        $data = [
            'InterfaceDoCliente' => [
                [
                    'CPFouCNPJ' => $cpf,
                ],
            ],
        ];

        return $this->enviar(self::ENDPOINT_CONSULTAR_CLIENTE, $data);
    }

    /**
     * Cadastra uma fatura.
     *
     * Exemplo do array $dados:
     * [
     *   "SequenciadoRegistro" => 1,
     *   "CodigodaEmpresa" => "SC",
     *   "CodigodaFilial" => "05",
     *   "CodigodaFatura" => "",
     *   "DatadaFatura" => "19012026",
     *   "TipodeOperacao" => "N13",
     *   "DescricaodaNaturazadaOperacao" => "Prestação de Serviço",
     *   "IndicadordeClienteouFornecedor" => "C",
     *   "CodigodoClienteouFornecedor" => "0129113613",
     *   "CodigodaMoeda" => "BRL",
     *   "IndicadordeUsoouConsumo" => "N",
     *   "StatusdaFatura" => "A",
     *   "CodigodoAIDF" => "RPS",
     *   "TipodeFatura" => "56",
     *   "Motivodocancelamento" => "",
     *   "TotaldaNota" => "100,00",
     *   "TipodaFormadeAtendimentodaFatura" => "1",
     *   "DatadeCompetencia" => "19012026",
     *   "IndicadordeUtilizacaodeAdiantamento" => "1",
     *   "TipoRetencaoISSQN" => "1",
     *   "TributacaoISSQN" => "2",
     *   "TipoImunidadeISSQN" => "3",
     *   "TipoRegimeEspecialTributacaoMunicipal" => "0",
     *   "InterfaceItemdaFatura" => [
     *     [
     *       "CodigodaEmpresa" => "SC",
     *       "CodigodaFilial" => "05",
     *       "CodigodaFatura" => "",
     *       "SequenciadoItemnaNota" => 1,
     *       "CodigodoItem" => "06040101",
     *       "DescricaodoItem" => "Uso do espaco enventaLab",
     *       "CodigodaUnidadedeMedida" => "SV",
     *       "QuantidadedoItem" => "1,00",
     *       "ClassificacaoFiscal" => "125059000",
     *       "PrecoInformado" => "100,00",
     *       "ValordoItem" => "100,00",
     *       "CodigodoTipodeOperacao" => "N13"
     *     ]
     *   ]
     * ]
     *
     * Exemplo de payload:
     * {
     *   "Data": {
     *     "InterfacedaFatura": [
     *       {
     *         "SequenciadoRegistro": 1,
     *         "CodigodaEmpresa": "SC",
     *         "CodigodaFilial": "05",
     *         "CodigodaFatura": "",
     *         "DatadaFatura": "19012026",
     *         "TipodeOperacao": "N13",
     *         "DescricaodaNaturazadaOperacao": "Prestação de Serviço",
     *         "IndicadordeClienteouFornecedor": "C",
     *         "CodigodoClienteouFornecedor": "0129113613",
     *         "CodigodaMoeda": "BRL",
     *         "IndicadordeUsoouConsumo": "N",
     *         "StatusdaFatura": "A",
     *         "CodigodoAIDF": "RPS",
     *         "TipodeFatura": "56",
     *         "Motivodocancelamento": "",
     *         "TotaldaNota": "100,00",
     *         "TipodaFormadeAtendimentodaFatura": "1",
     *         "DatadeCompetencia": "19012026",
     *         "IndicadordeUtilizacaodeAdiantamento": "1",
     *         "TipoRetencaoISSQN": "1",
     *         "TributacaoISSQN": "2",
     *         "TipoImunidadeISSQN": "3",
     *         "TipoRegimeEspecialTributacaoMunicipal": "0",
     *         "InterfaceItemdaFatura": [
     *           {
     *             "CodigodaEmpresa": "SC",
     *             "CodigodaFilial": "05",
     *             "CodigodaFatura": "",
     *             "SequenciadoItemnaNota": 1,
     *             "CodigodoItem": "06040101",
     *             "DescricaodoItem": "Uso do espaco enventaLab",
     *             "CodigodaUnidadedeMedida": "SV",
     *             "QuantidadedoItem": "1,00",
     *             "ClassificacaoFiscal": "125059000",
     *             "PrecoInformado": "100,00",
     *             "ValordoItem": "100,00",
     *             "CodigodoTipodeOperacao": "N13"
     *           }
     *         ]
     *       }
     *     ]
     *   }
     * }
     */
    public function cadastroFatura(array $dados): array
    {
        $data = [
            'InterfacedaFatura' => [
                $dados,
            ],
        ];

        return $this->enviar(self::ENDPOINT_CADASTRAR_FATURA, $data);
    }

    /**
     * Consulta fatura por processo.
     *
     * Exemplo do parametro:
     * $sequenciadoProcesso = 923;
     *
     * Exemplo de payload:
     * {
     *   "Data": {
     *     "SequenciadoProcesso": 923
     *   }
     * }
     */
    public function consultaFatura(int $sequenciadoProcesso): array
    {
        $data = [
            'SequenciadoProcesso' => $sequenciadoProcesso,
        ];

        return $this->enviar(self::ENDPOINT_CONSULTAR_FATURA, $data);
    }

    /**
     * Consulta um servico pelo codigo.
     *
     * Exemplo do parametro:
     * $codigo = "06040101";
     *
     * Exemplo de payload:
     * {
     *   "Data": {
     *     "Codigo": "06040101",
     *     "ProdutoServico": "S"
     *   }
     * }
     */
    public function consultaServico(string $codigo): array
    {
        $data = [
            'Codigo' => $codigo,
            'ProdutoServico' => 'S',
        ];

        return $this->enviar(self::ENDPOINT_CONSULTAR_SERVICO, $data);
    }

    private function enviar(string $path, array $data): array
    {
        $url = $this->montarUrl($path);
        $payload = $this->montarPayload($data);
        
        if ($url === null) {
            return [
                'request' => [
                    'url' => null,
                    'http_code' => 0,
                    'payload' => $$this->liparPayloadDebug($payload),
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
                'payload' => $this->liparPayloadDebug($payload),
            ],
            'curl_error' => $result['curl_error'],
            'raw_response' => $result['raw_response'],
            'decoded_response' => $result['decoded_response'],
        ];
    }

    private function liparPayloadDebug($payload)
    {
        if(isset($payload['AutheticationToken']['Password'])){
            $payload['AutheticationToken']['Password'] = '***';
        }
        return $payload;
    }

    private function montarPayload(array $data): array
    {
        return [
            'AutheticationToken' => [
                'Username' => $this->username,
                'Password' => $this->password,
                'EnvironmentName' => $this->environment,
            ],
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

    private function postJson(string $url, array $payload): array
    {
        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init($url);
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
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
