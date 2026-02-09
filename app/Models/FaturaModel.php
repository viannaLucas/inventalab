<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;
use App\Entities\CobrancaEntity;
use App\Entities\CobrancaServicoEntity;
use App\Entities\FaturaEntity;
use App\Libraries\SescAPI;

class FaturaModel extends BaseModel{
    
    protected $table = 'Fatura';
    protected $allowedFields = ['Cobranca_id', 'processoApiSesc', 'situacao'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Cobranca_id' => ['label'=> 'Cobrança', 'rules'=>'required|is_natural_no_zero|is_not_unique[Cobranca.id]'],
        'processoApiSesc' => ['label'=> 'Processo Api Sesc', 'rules'=>'required|integer'],
        'situacao' => ['label'=> 'Situação', 'rules'=>'required|in_list[0,1,2]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\FaturaEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['Cobranca_id'])) $this->where('Cobranca_id =', $data['Cobranca_id']); 
        if(isset($data['processoApiSesc'])){
            $func = is_array($data['processoApiSesc']) ? 'whereIn' : 'where';
            $this->$func('processoApiSesc', $data['processoApiSesc']);
        }
        if(isset($data['situacao'])){
            $func = is_array($data['situacao']) ? 'whereIn' : 'where';
            $this->$func('situacao', $data['situacao']);
        }
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }

    public function processarFatura(CobrancaEntity $cobranca)
    {
        if(count($cobranca->getListFatura()) > 0 
                || $cobranca->situacao != CobrancaEntity::SITUACAO_PAGA){
            return;
        }
        
        $lCobrancaServico = $cobranca->getListCobrancaServico();
        if(count($lCobrancaServico) < 0){
            return;
        }
        $participanteM = new ParticipanteModel();
        $codigoParticipanteApi = $participanteM->cadastroSescApi($cobranca->getParticipante());

        $sescApi = new SescAPI([
            'baseUrl'=> env('sescApi_baseUrl'),
            'username'=> env('sescApi_username'),
            'password'=> env('sescApi_password'),
            'environment'=> env('sescApi_environment'),
            'timeout_seconds'=> env('sescApi_timeoutSeconds'),
        ]);

        $total = 0;
        $InterfaceItemdaFatura = [];
        /** @var CobrancaServicoEntity $cs */
        foreach($lCobrancaServico as $k => $cs){
            $total += floatval($cs->quantidade) * floatval($cs->valorUnitario);
            $InterfaceItemdaFatura[] = [
                    "CodigodaEmpresa" => env('sescApi_CodigodaEmpresa'),
                    "CodigodaFilial" => env('sescApi_CodigodaFilial'),
                    "CodigodaFatura" => "",
                    "SequenciadoItemnaNota" => ''.($k+1),
                    "CodigodoItem" => $cs->getServico()->getDadosApi()->codigo,
                    "DescricaodoItem" =>  $cs->getServico()->Nome,
                    "CodigodaUnidadedeMedida" => $cs->getServico()->getDadosApi()->UnidadedeControle,
                    "QuantidadedoItem" => ''.number_format($cs->quantidade, 2, ',',''),
                    "ClassificacaoFiscal" => $cs->getServico()->getDadosApi()->ClassificacaoFiscal,
                    "PrecoInformado" => ''.number_format($cs->valorUnitario, 2, ',',''),
                    "ValordoItem" => ''.number_format($cs->valorUnitario, 2, ',',''),
                    "CodigodoTipodeOperacao" => $cs->getServico()->getDadosApi()->CodigodoTipodeOperacao
                ];
        }

        $dados = [
            "SequenciadoRegistro" => 1,
            "CodigodaEmpresa" => env('sescApi_CodigodaEmpresa'),
            "CodigodaFilial" => env('sescApi_CodigodaFilial'),
            "CodigodaFatura" => "",
            "DatadaFatura" => date("dmY"),
            "TipodeOperacao" => env('sescApi_TipodeOperacao'),
            "DescricaodaNaturazadaOperacao" => env('sescApi_DescricaodaNaturazadaOperacao'),
            "IndicadordeClienteouFornecedor" => "C",
            "CodigodoClienteouFornecedor" => $codigoParticipanteApi,
            "CodigodaMoeda" => "BRL",
            "IndicadordeUsoouConsumo" => env('sescApi_IndicadordeUsoouConsumo'),
            "StatusdaFatura" => env('sescApi_StatusdaFatura'),
            "CodigodoAIDF" => env('sescApi_CodigodoAIDF'),
            "TipodeFatura" => env('sescApi_TipodeFatura'),
            "Motivodocancelamento" => "",
            "TotaldaNota" => ''.number_format($total, 2, ',',''),
            "TipodaFormadeAtendimentodaFatura" => env('sescApi_TipodaFormadeAtendimentodaFatura'),
            "DatadeCompetencia" => date('dmY'),
            "IndicadordeUtilizacaodeAdiantamento" => env('sescApi_IndicadordeUtilizacaodeAdiantamento'),
            "TipoRetencaoISSQN" => env('sescApi_TipoRetencaoISSQN'),
            "TributacaoISSQN" => env('sescApi_TributacaoISSQN'),
            "TipoImunidadeISSQN" => env('sescApi_TipoImunidadeISSQN'),
            "TipoRegimeEspecialTributacaoMunicipal" => env('sescApi_TipoRegimeEspecialTributacaoMunicipal'),
            "InterfaceItemdaFatura" => $InterfaceItemdaFatura
        ];
        $resp = $sescApi->cadastroFatura($dados);
        log_message('debug', print_r($resp, true));

        if($resp['decoded_response']['Success'] !== true
                && $resp['decoded_response']['Success'] !== 1){
            log_message('error', 'Erro ao enviar solicitação de cadastro da Fatura. '."\nResposta: \n". print_r($resp)."\n\nDados Enviados:\n".print_r($dados));
            return;
        }

        $faturaE = new FaturaEntity();
        $faturaE->Cobranca_id = $cobranca->id;
        $faturaE->processoApiSesc = $resp['decoded_response']['Data'];
        $faturaE->situacao = FaturaEntity::SITUACAO_NAO_PROCESSADO;
        $faturaM = new FaturaModel();
        if(!$faturaM->insert($faturaE,false)){
            dd($faturaM->errors());
        }

        
    }
}
